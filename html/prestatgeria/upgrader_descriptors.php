<?php

// XTEC ************* AFEGIT -> Script to fill the descriptors
// 2012.06.22 @mmartinez

if (isset($_GET['pass']) && $_GET['pass'] == 'nimda'){
	$s_time = microtime();
	
	echo '<h1>PRESTATGERIA :: Descriptors upgrader log</h1>';
	
	include_once '../config/config.php';
	//echo '<hr>Connection info:<br>{server: ' . $PNConfig['DBInfo']['default']['dbhost'] . ', user: ' . $PNConfig['DBInfo']['default']['dbuname'] . ', pass: ' . $PNConfig['DBInfo']['default']['dbpass'] . ', dname: ' . $PNConfig['DBInfo']['default']['dbname'] . '}<hr>'; //debug
	
	//conect to db
	$c = mysql_connect($PNConfig['DBInfo']['default']['dbhost'], $PNConfig['DBInfo']['default']['dbuname'], $PNConfig['DBInfo']['default']['dbpass']) or die ('Connection error (' . mysql_error() . ')');
	mysql_select_db($PNConfig['DBInfo']['default']['dbname'], $c) or die ('Select db error (' . mysql_error() . ')');
	
	//get initial info
	$res = mysql_query("SELECT bookDescript FROM zk_books", $c) or die ('Initial query error (' . mysql_error() . ')');
	echo '<hr>Initial query results:'; while ($row = mysql_fetch_array($res)){ echo '<br>' . serialize($row);}echo '<hr>'; mysql_data_seek($res, 0); //debug
	
	//calculate descriptor num
	$descriptors_array = array();
	while ($row = mysql_fetch_array($res)){
		$desc = explode('#', $row['bookDescript']);
		foreach ($desc as $d){
			if (empty($d)){
				continue;	
			}
			
			if (!array_key_exists($d, $descriptors_array)){
				$descriptors_array[$d] = 1;
			} else {
				$descriptors_array[$d]++;
			}
			
		}
	}
	echo '<hr>Calculated descriptors:<br><pre>'; var_dump($descriptors_array); echo '</pre><hr>'; //debug 
	
	//clean books_descriptors table
	$res = mysql_query("DELETE FROM zk_books_descriptors", $c) or die ('Clean zk_books_descriptors:<br>KO! (Error: ' . mysql_error() . ')');
	echo '<hr>Clean zk_books_descriptors:<br>OK! (' . mysql_affected_rows($c) . ' rows affected)<hr>';
	
	//inset new values
	$cnt = 0;
	foreach($descriptors_array as $k => $v){
		$res = mysql_query("INSERT INTO zk_books_descriptors (descriptor, number) VALUES ('{$k}', '{$v}')");
		$cnt++;
	}
	echo '<hr>Insert into zk_books_descriptor:<br>OK! (' . $cnt . ' rows inserted)<hr>';
	
	mysql_close($c);
	$f_time = microtime();
	
	echo '<br><br>Script finished in ' . round($f_time - $s_time, 3) . ' seconds';
} else {
	die('No tens permisos per abrir aquesta plana web');
}

// *************** FI
?>