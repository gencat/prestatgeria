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

include_once(API_HOME_DIR . "const.php");

/**********************************************************************
							Util Functions
***********************************************************************/

/***********************************
	 	Public Functions
************************************/
function txtdbapi_version() {
	return TXT_DB_API_VERSION;
}



/***********************************
	 	Explode Functions
************************************/

// same as explode_resp_quotes() but the separated strings are
// returned with &$arr and $separators is an array of separators
// returns: the first separator from $separator[] which caused a 
// successfull split
// if a successfull split occurred, the other separator's want be used
// => Attention on the correct Order (e.g. ("<","<=") makes no sense)
// but ("<=","<") does
function explode_resp_quotes_multisep($separators, $string, &$arr) {
	for($i=0;$i<count($separators);$i++) {
		$arr=explode_resp_quotes($separators[$i],$string);
		if(count($arr)>1) {
			return $separators[$i];
		}
	}
	return null;
}

// explode that does not ignore ""'s and is case insensitive
// there is a handling for any escape chars
function explode_resp_quotes($separator, $string) {
	$arr[0]="";
	$inQuotes=false;
	$index=0;
	$sepLen = strlen($separator);
	
	debug_print("IN: $separator, $string<br>");
	
	// handles \ escape Chars
	$lastWasEscapeChar=false;
	
	for($i=0;$i<strlen($string);$i++) {
		$c=$string{$i};
					
		if($c=="\"" || $c=="'") {
			if(!$lastWasEscapeChar)
				$inQuotes=(!$inQuotes);
		}
		if($c=="\\") {
			$lastWasEscapeChar=(!($lastWasEscapeChar));
		} else {
			$lastWasEscapeChar=false;
		}
		
		// performance.. if $c is not char 0 of $separator do no more checks
		if(!$inQuotes && $c==$separator{0} && strtoupper(substr($string,$i,$sepLen))==strtoupper($separator)) {
			$arr[++$index]="";
			$i+=$sepLen-1;
		} else {
			$arr[$index] .= $c;
		}
	}
	if(DEBUG) {
		echo "OUT:<br>";
		echo "<pre>";
		print_r($arr);
		echo "</pre><br><br>";
	}
	return $arr;
	
}



/***********************************
	 	Debug Functions
************************************/
function debug_print($str) {
	if(DEBUG) {
		echo $str;
	}
}


/***********************************
	 	Char Functions
************************************/
function last_char($string) {
	return $string{strlen($string)-1};
}

function remove_last_char(&$string) {
	$string=substr($string,0,strlen($string)-1);
}

/***********************************
	 	String Functions
************************************/
// returns $length chars from the right side of $string
function substr_right($string,$length) {
	return substr($string, strlen($string)-$length);
}


/***********************************
	 	Array Functions
************************************/
function array_walk_trim(&$value, &$key) {
	$value=trim($value);
}

function create_array_fill($size, $value) {
	$arr=array();
	for($i=0;$i<$size;$i++)
		$arr[]=$value;
	return $arr;
}

// searches the first n chars of $string in $array
// where n is the length of reach $array element
// returns the value of $array if found or false
function array_search_str_start($string, $array) {
	for($i=0;$i<count($array);$i++) {
		//debug_print("Searching " . $array[$i] . " in " . $string . "<br>");
		if(strncmp($array[$i],$string, strlen($array[$i]))==0)
			return $array[$i];
	}
	return false;
}

/***********************************
	 	Type Functions
************************************/
function dump_retval_type($var) {
  if(is_bool($var) && !$var) 
    echo "The value is FALSE<br>"; 
  if(is_int($var) && !$var) 
    echo "The value is 0<br>"; 
  if(!isset($var)) 
    echo "The value is NULL<br>"; 
  if(is_string($var) && $var=="") 
    echo "The value is \"\"<br>"; 
  if(is_string($var) && $var=="0") 
    echo "The value is \"0\"<br>"; 
  if($var)
  	echo "The value is a TRUE or something other then 0 or FALSE<br>"; 
} 

function is_false($var) {
	return (is_bool($var) && !$var);
}
function is_0($var) {
	return (is_int($var) && !$var);
}
// _ at the front, cause is_null exists
function _is_null($var) {
	return (!isset($var)) ;
}
function is_empty_str($var) {
	return (is_string($var) && $var=="");
}

/***********************************
	 	SQL Util Functions
************************************/
// compares 2 values by $operator, and returns true or false
function compare($value1,$value2,$operator) {
	
	if($operator=="<>" || $operator=="!=")
		return ($value1 != $value2);
		
	if($operator=="=")
		return ($value1 == $value2);
	
	if($operator==">")
		return ($value1 > $value2);
	if($operator=="<")
		return ($value1 < $value2);
		
	if($operator==">=")
		return ($value1 >= $value2);
	if($operator=="<=")
		return ($value1 <= $value2);
		
	return false;
}


/***********************************
	 	Error Functions
************************************/
function print_error($text, $nr=-1) {

	if($nr==-1)
		echo "<br><b>Php-Txt-Db-Access Error:</b><br>";
	else
		echo "<br> Php-Txt-Db-Access Error Nr $nr:<br>";
	echo $text . "<br>";	
}

function print_warning($text, $nr=-1) {
	if($nr==-1)
		echo "<br><b>Php-Txt-Db-Access Warning:</b><br>";
	else
		echo "<br> Php-Txt-Db-Access Warning Nr $nr:<br>";
	echo $text . "<br>";	
}

/***********************************
	 	Quote Functions
************************************/
function has_quotes($str) {
	return ($str[0]=="'" || $str[0]=="\"") && (last_char($str)=="'" || last_char($str)=="\"");
}

function remove_quotes(&$str) {
	$str=substr($str,1);
	remove_last_char($str);
}

function array_walk_remove_quotes(&$value, &$key) {
	if(has_quotes($value))
		remove_quotes($value);
}


/***********************************
	 	Time Functions
************************************/
function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
} 


?>