<?php
/**********************************************************************
						 Php Textfile DB Access API
						Copyright 2002 by c-worker.ch
						  http://www.c-worker.ch
***********************************************************************/
/**********************************************************************
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
***********************************************************************/

include_once(API_HOME_DIR . "util.php");
include_once(API_HOME_DIR . "const.php");


/**********************************************************************
							Global Vars 
***********************************************************************/

// Special Strings in SQL Queries
// Insert Strings before Single Chars !! (e.g. >= before >)
$g_sqlComparisonOperators=array("<>","!=",">=","<=","=","<",">");
$g_sqlQuerySpecialStrings = array_merge($g_sqlComparisonOperators, array("(",")",";",",","."));
$g_sqlQuerySpecialStringsMaxLen = 2;


/**********************************************************************
							SqlParser
***********************************************************************/
// Used to parse an SQL-Query (as String) into an SqlObject
class SqlParser {
	
	var $query_str="";
	
	/***********************************
		 		Constructor
	************************************/
	function SqlParser($sql_query_str) {
		debug_print ("New SqlParser instance: $sql_query_str<br>");
		$this->query_str=$sql_query_str;
	}
	
	/***********************************
		 	Parse Dispatcher
	************************************/
	// Returns a SqlQuery Object or null if an error accoured
	function parseSqlQuery() {
		$type="";
		if(!$type=$this->parseNextElement()) 
			return null;
		$type=strtoupper($type);
		switch($type) {
			case "SELECT":
				return $this->parseSelectQuery();
				break;
			case "INSERT":
				return $this->parseInsertQuery();
				break;
			case "DELETE":
				return $this->parseDeleteQuery();
				break;
			case "UPDATE":
				return $this->parseUpdateQuery();
				break;
			case "CREATE":
				if(strtoupper($this->peekNextElement())=="TABLE") {
					$this->skipNextElement();
					return $this->parseCreateTableQuery();
				}	
				break;
			default:
				print_error("SQL Type $type not supported");
				return null;
		}
	}
	
	
	/***********************************
		 Select Query Parse Function
	************************************/
	
	// SELECT must be removed here (do not call this Function directly !!!)
	// returns a SqlQuery Object
	function parseSelectQuery() {
		$fieldNames=array();
		$fieldTables=array();
		$fieldAliases=array();
		$fieldValues=array();
		$tables=array();
		$orderFields=array();
		$orderTypes=array();
		$where_expr="";
		
		// parse Fields
		$fieldIndex=0;
		while(!is_empty_str($elem=$this->parseNextElement())) {
			if(strtoupper($elem)=="FROM")
				break;
			if($this->peekNextElement()==".") {
				$fieldTables[$fieldIndex]=$elem;
				$this->skipNextElement();
				$fieldNames[$fieldIndex]=$this->parseNextElement();
			} else {
				$fieldTables[$fieldIndex]="";
				$fieldNames[$fieldIndex]=$elem;
			}
			if(strtoupper($this->peekNextElement())=="AS") {
				$this->skipNextElement();
				$fieldAliases[$fieldIndex]=$this->parseNextElement();
			} else {
				$fieldAliases[$fieldIndex]="";
			}
			if($this->peekNextElement()==",") {
				$this->skipNextElement();
			}
			$fieldIndex++;
		}
		
		// parse Tables
		$tableIndex=0;
		while(!is_empty_str($elem=$this->peekNextElement())) {
			if(strtoupper($elem)=="WHERE" || strtoupper($elem)=="ORDER" || $elem==";")
				break;
			$this->skipNextElement();
			if($elem==",")
				$tableIndex++;
			else
				$tables[$tableIndex]=$elem;
		}
		
		// parse Where statement (Raw, because the escape-chars are needend in the ExpressionParser)
		if(strtoupper($this->peekNextElement()) == "WHERE") {
			$this->skipNextElement();
			while(!is_empty_str($elem=$this->peekNextElementRaw())) {
				if(strtoupper($elem)=="ORDER" || $elem==";")
					break;
				$this->skipNextElement();
				
				// no " " on points
				if($elem==".") {
					remove_last_char($where_expr);
					$where_expr .= $elem;
				} else {
					$where_expr .= $elem . " ";
				}
			}
		}
		debug_print( "WHERE EXPR: $where_expr<br>");
		
		// parse ORDER BY
		$orderFieldIndex=0;
		if(strtoupper($this->peekNextElement()) == "ORDER") {
			$this->skipNextElement();
			if(strtoupper($this->parseNextElement())!="BY") {
				print_error("BY expected");
				return null;
			}
			
			while(!is_empty_str($elem=$this->peekNextElement())) {
				if($elem==";")
					break;
				$this->skipNextElement();
				if($elem==",") {
					$orderFieldIndex++;
				}
				else if(strtoupper($elem)=="ASC") 
					$orderTypes[$orderFieldIndex]=ORDER_ASC;
				else if(strtoupper($elem)=="DESC")
					$orderTypes[$orderFieldIndex]=ORDER_DESC;
				else {
					if(!isset($orderFields[$orderFieldIndex])) 
						$orderFields[$orderFieldIndex]=$elem;
					else
						$orderFields[$orderFieldIndex].=$elem;
					$orderTypes[$orderFieldIndex]=ORDER_ASC;
				}	
			}
		}
		
		return new SqlQuery("SELECT", $fieldNames, $tables, $fieldAliases, $fieldTables, $where_expr, $orderFields, $orderTypes);;
	}


	/***********************************
		 Insert Query Parse Function
	************************************/
	
	// INSERT must be removed here (do not call this Function directly !!!)
	// returns a SqlQuery Object
	function parseInsertQuery() {
		
		$fieldNames=array();
		$fieldTables=array();
		$fieldAliases=array();
		$fieldValues=array();
		$tables=array();
		$insertType="";
		
		
		// remove INTO
		if(strtoupper($this->peekNextElement())=="INTO") 
			$this->skipNextElement();
				
		// Read Table				
		$tables[0]=$this->parseNextElement();
		
		// Read Field Names between ()'s
		$fieldNamesIndex=0;
		if($this->peekNextElement()=="(") {
			while(($elem=$this->parseNextElement())!=")") {
				if($elem==",")
					$fieldNamesIndex++;
				else 
					$fieldNames[$fieldNamesIndex]=$elem;
			}
		}

		// read Insert Type
		$insertType=$this->parseNextElement();
		
		switch($insertType) {
			case "SELECT":
				break;
			case "SET":
				$commaCheck=5;  // table.field=xy 
				// Read Fields and Values
				$fieldNamesIndex=0;
				while( !is_empty_str(($elem=$this->parseNextElement())) && ($elem != ";")) {
					if($elem==",") {
						$commaCheck=5;
						$fieldNamesIndex++;
					} else if($elem=="=") {
						$commaCheck=2;
						$fieldValues[$fieldNamesIndex]=$this->parseNextElement();
					} else {
						$fieldNames[$fieldNamesIndex]=$elem;
					}
					$commaCheck--;
					if($commaCheck<=0) {
						print_error(", Expected");
						return null;
					}
				}
				break;
				
			case "VALUES":
				if($this->parseNextElement()!="(") {
					print_error("VALUES in the INSERT Statement must be in Braces \"(,)\"");
					return null;
				}
				$fieldValuesIndex=0;
				while(($elem=$this->parseNextElement())!=")") {
					if(is_empty_str($elem)) {
						print_error(") Expected");
						return null;
					}
					
					if($elem==",")
						$fieldValuesIndex++;
					else 
						$fieldValues[$fieldValuesIndex]=$elem;
				}
				break;
			default:
				print_error("Insert Type " . $insertType . " not supported");
				return null;
		}
		$sqlObj = new SqlQuery();
		$sqlObj->type = "INSERT";
		$sqlObj->fields=$fieldNames;
		$sqlObj->fieldAlias=$fieldAliases;
		$sqlObj->fieldTables=$fieldTables;
		$sqlObj->fieldValues=$fieldValues;
		$sqlObj->insertType=$insertType;
		$sqlObj->tables=$tables;
		
		return $sqlObj;
	}
	
	
	/***********************************
		 Delete Query Parse Function
	************************************/
	
	// DELETE must be removed here (do not call this Function directly !!!)
	// returns a SqlQuery Object
	function parseDeleteQuery() {
		
		$tables=array();
		$where_expr="";
		
		if(strtoupper($this->parseNextElement())!="FROM") {
			print_error("FROM expected");
			return null;
		}
		$tables[0]=$this->parseNextElement();
		
		// Because the Where Statement is not parsed with 
		// the parseXX Functions, this equals a Raw-Parse,
		// as needed for the ExpressionParser
		if(strtoupper($this->parseNextElement())=="WHERE") {
			$where_expr=$this->query_str;
			if(last_char($where_expr)==";")
				remove_last_char($where_expr);
		} else if ($elem=$this->parseNextElement()) {
			print_error("Nothing more expected: $elem");
			return null;
		}
		
		$sqlObj = new SqlQuery();
		$sqlObj->type = "DELETE";
		$sqlObj->tables=$tables;
		$sqlObj->where_expr=$where_expr;
		
		return $sqlObj;
	}
	
	
	/***********************************
		 Update Query Parse Function
	************************************/
	
	// UPDATE must be removed here (do not call this Function directly !!!)
	// returns a SqlQuery Object
	function parseUpdateQuery() {
		
		$fieldNames=array();
		$fieldValues=array();
		$tables=array();
		$where_expr="";
		
		// Read Table				
		$tables[0]=$this->parseNextElement();
		
		// Remove SET
		if(strtoupper($this->parseNextElement())!="SET") {
			print_error("SET expected");
			return null;
		}
		
		// Read Fields and Values
		$elem="";
		$fieldNamesIndex=0;
		while( !is_empty_str(($elem=$this->parseNextElement())) && ($elem != ";") && (strtoupper($elem) != "WHERE")) {
			if($elem==",")
				$fieldNamesIndex++;
			else if($elem=="=") {
				$fieldValues[$fieldNamesIndex]=$this->parseNextElement();
			} else {
				$fieldNames[$fieldNamesIndex]=$elem;
			}
		}
		
		// Raw-Parse Where Statement
		if(strtoupper($elem)=="WHERE") {
			$where_expr=$this->query_str;
			if(last_char($where_expr)==";")
				remove_last_char($where_expr);
		}


		$sqlObj = new SqlQuery();
		$sqlObj->type = "UPDATE";
		$sqlObj->fields=$fieldNames;
		$sqlObj->fieldValues=$fieldValues;
		$sqlObj->tables=$tables;
		$sqlObj->where_expr=$where_expr;
		
		return $sqlObj;
	}
	
	
	/***********************************
	  Create Table Query Parse Function
	************************************/
	
	// CREATE TABLE must be removed here (do not call this Function directly !!!)
	// returns a SqlQuery Object
	function parseCreateTableQuery() {
		$fieldNames=array();
		$fieldTypes=array();
		$tables=array();
	
		$tables[0]=$this->parseNextElement();	
		
		if($this->parseNextElement()!="(") {
			print_error("( expected");
			return null;
		}

		$name=""; $type="";
		$index=0;
		while( !is_empty_str(($name=$this->parseNextElement())) &&  ($type=$this->parseNextElement()) && $name!=";" && $type !=";") { 
			$fieldNames[$index]=$name;
			$fieldTypes[$index]=$type;
			if($this->parseNextElement()==",")
				$index++;
			else
				break;
		}
		
		$sqlObj = new SqlQuery();
		$sqlObj->type = "CREATE TABLE";
		$sqlObj->fields=$fieldNames;
		$sqlObj->fieldTypes=$fieldTypes;
		$sqlObj->tables=$tables;
	
		return $sqlObj;		
	}

	
	/***********************************
		 	Parse Helper Functions
	************************************/
	// All these Functions remove the parsed part out of
	// the source String ($str)
	
	function skipNextElement() {
		$this->parseNextElement(true);
	}
	
	function peekNextElement() {
		return $this->parseNextElement(false);
	}
	
	// does not remove Escape Chars
	function parseNextElementRaw() {
		return $this->parseNextElement(true, false);
	}
	
	// does not remove Escape Chars
	function peekNextElementRaw() {
		return $this->parseNextElement(false, false);
	}
	
	// Returns the next element of the SQL Query or "" at the End (use is_empty_str() to check)
	// if $remove is true the element will be remove from $this->query_str
	// if $removeEscapeChar is true, the the Escape Chars will be correctly removed,
	// e.g. \" => ", \\ => \
	function parseNextElement($remove=true, $removeEscapeChar=true) {
		global $g_sqlQuerySpecialStrings;
		global $g_sqlQuerySpecialStringsMaxLen;
		$inQuotes=false;
		$element="";
		
		// handles \ escape Chars
		$lastWasEscapeChar=false;
		
		for($i=0;$i<strlen($this->query_str);$i++) {
			$c=$this->query_str{$i};
			switch($c) {
				case "\\":
					if($lastWasEscapeChar) {
						$element.= $c;
						$lastWasEscapeChar=false;
					} else {
						$lastWasEscapeChar=true;
						if(!$removeEscapeChar)
							$element.= $c;
					}
					break;
				case "'":
				case "\"":
					if(!$lastWasEscapeChar)
						$inQuotes=(!$inQuotes);
					$element.= $c;
					break;
				case " ":
					if(!$inQuotes && strlen($element)>0) 
						break 2;
					else if($inQuotes)
						$element.= $c;
					break;
			}
			if($c!="\\")
				$lastWasEscapeChar=false;
			if($c=="\\" || $c=="\"" || $c=="'" || $c==" ")  // ugly..
				continue;                         
			
			$testSrt=substr($this->query_str,$i,$g_sqlQuerySpecialStringsMaxLen);
			if(
			(!$inQuotes) && 
			($specialChar=array_search_str_start($testSrt,$g_sqlQuerySpecialStrings))) {
				if(strlen($element)>0) {
					break;
				} else {
					$element=$specialChar;
					$i+=strlen($specialChar);
					break;
				}
			} else {
				$element.= $c;	
			}
		}
		if($remove) {
			$this->query_str=substr($this->query_str,$i);
			debug_print( "Element:" . $element . "<br>");
		}
		return $element;
	}
}

/**********************************************************************
								SqlQuery
***********************************************************************/
// Represents an SQL Query 
// Fields should be accessed directly here -> faster 

class SqlQuery {
	
	
	/***********************************
			Member Variables
	************************************/

	var $type;
	
	var $fields=array();
	var $fieldAlias=array();
	var $fieldTables=array();
	
	var $fieldTypes=array();	// At the Moment only used in CREATE TABLE (int, string OR inc)
								// may also used in other Queries 
	var $fieldValues=array(); 	// Used in: INSERT, UPDATE
	
	var $insertType=""; 		// Used in: INSERT ("VALUES", "SET" or "SELECT")
	
	var $orderFields=array(); 	// Used by: ORDER BY
	var $orderTypes=array();	// Used by: ORDER BY
	
	var $tables=array();
	var $where_expr;
	
	
	
	/***********************************
				Constructor
	************************************/
	
	function SqlQuery($type="SELECT", $fields=array(), $tables=array(), $fieldAlias=array(), $fieldTables=array(), $where_expr="", $orderFields=array(),$orderTypes=array()) {
		$this->type=$type;
		$this->fields=$fields;
		$this->tables=$tables;
		$this->where_expr=$where_expr;
		$this->fieldAlias=$fieldAlias;
		$this->fieldTables=$fieldTables;
		$this->orderFields=$orderFields;
		$this->orderTypes=$orderTypes; // ORDER_ASC or ORDER_DESC
	}
	
	function getSize() {
		return count($this->fields);
	}
	
	
	/***********************************
				Test
	************************************/
	// NOT Up to Date
	// Test's if the SqlQuery is valid
	// TRUE if ok, FALSE if not ok
	function test() {
		reset($this->fields);
		for($i=0;$i<count($this->fields);$i++) {
			if($this->fields[$i]=="*")
			{
				if($this->fieldAlias[$i]) {
					print_error("Cannot define Alias by a *");
					return FALSE;
				}
				continue;
			}
			if($key=array_search  ($this->fields[$i], $this->fields)) {
				if($i==$key)
					continue;
				if($this->fieldAlias[$i] == $this->fieldAlias[$key]) {
					print_error("Two Fields with the same name use no or the same alias (" . $this->fields[$i] . ", " . $this->fields[$key] . ")");
					return FALSE;
				}
				if(!$this->fieldTables[$i]) {
					print_error("Field " . $this->fields[$i] . " could belong to multiple Tables");
					return FALSE;
				}
			}
		}
		reset($this->fieldAlias);
		for($i=0;$i<count($this->fieldAlias);$i++) {
			if($key=array_search  ($this->fieldAlias[$i], $this->fieldAlias)) {
				if($i==$key || $this->fieldAlias[$i]=="")
					continue;
				print_error("Two Fields (" . $this->fields[$i] . ", " . $this->fields[$key] . ") use the same alias");
				return FALSE;
			}
		}
		
		reset($this->fields);
		// TODO: error ..?!?  SELECT nr, tabelle1.nr As nr FROM ....
		// produces no Error !
		for($i=0;$i<count($this->fieldAlias);$i++) {
			if(($key=array_search($this->fieldAlias[$i], $this->fields))) {
				if($i==$key) {
					continue;
				}
				print_error("Alias is the name from another field (" . $this->fieldAlias[$i] . ")");
				return FALSE;
			}
		}
		return TRUE;
		
	}

}

?>