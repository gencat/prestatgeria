<?php

Class MySQL_options
{
	var $CONN   = "";
	var $TRAIL = array();
	var $HITS = array();

	function error($text)
	{
		$no = mysql_errno();
		$msg = mysql_error();
		echo "[$text] ( $no : $msg )<BR>\n";
		exit;
	}

	function init ()
	{	
		global $server,$datausername,$database,$password;		

		$conn = mysql_connect($server,$datausername,$password);		
		if(!$conn) {
			$this->error("Intento de conexi�n fallido");
		}
		if(!mysql_select_db($database,$conn)) {
			$this->error("Error al seleccionar la base de datos");
		}
		$this->CONN = $conn;
		return true;
	}

	function select ($sql="", $column="")
	{
		// debug
		// print "$sql<br><br>";
		if(empty($sql)) { return false; }
		if(!eregi("^select",$sql))
		{
			echo "<H2>Funci�n equivocada!</H2>\n";
			return false;
		}
		if(empty($this->CONN)) { return false; }
		$conn = $this->CONN;
		$results = mysql_query($sql,$conn);
		if( (!$results) or (empty($results))) {
		print $sql;
			mysql_free_result($results);
			return false;
		}
		$count = 0;
		$data = array();
		while ( $row = mysql_fetch_array($results))
		{
			$data[$count] = $row;
			$count++;
		}
		mysql_free_result($results);
		return $data;
	}

	function insert ($sql="")
	{
		if(empty($sql)) { return false; }
		if(!eregi("^insert",$sql))
		{
			echo "<H2>Funci�n equivocada!</H2>\n";
			return false;
		}
		if(empty($this->CONN))
		{
			echo "<H2>No hay conexi�n!</H2>\n";
			return false;
		}
		$conn = $this->CONN;
		$results = mysql_query($sql,$conn);
		if(!$results) 
		{
			echo "<H2>No hay resultados!</H2>\n";
			echo mysql_errno().":  ".mysql_error()."<P>";
			return false;
		}
		$results = mysql_insert_id();
		return $results;
	}

	function sql_query ($sql="")
	{
		if(empty($sql)) { return false; }
		if(empty($this->CONN)) { return false; }
		$conn = $this->CONN;
		$results = mysql_query($sql,$conn);
		if(!$results) 
		{
			echo "<H2>La petici�n no funcion�!</H2>\n";
			echo mysql_errno().":  ".mysql_error()."<P>";
			return false;
		}
		return $results;
	}

	function sql_cnt_query ($sql="")
	{
		if(empty($sql)) { return false; }
		if(empty($this->CONN)) { return false; }
		$conn = $this->CONN;
		$results = mysql_query($sql,$conn);
		if( (!$results) or (empty($results)) ) {
			mysql_free_result($results);
			return false;
		}
		$count = 0;
		$data = array();
		while ( $row = mysql_fetch_array($results))
		{
			$data[$count] = $row;
			$count++;
		}
		mysql_free_result($results);
		return $data[0][0];
	}
	function close_connect(){
	   $conn = $this->CONN;		
	   mysql_close($conn);	
	}
}	//	End Class
?>
