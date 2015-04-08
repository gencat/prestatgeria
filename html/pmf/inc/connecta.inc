<?php

require_once dirname(dirname(dirname(__FILE__))) . '/config/env-config.php';

$host = $presta['dbhost'];
$username = $presta['dbuser'];
$password = $presta['dbpass'];
$database = $presta['dbname'];

$server = mysql_connect($host, $username, $password) or die(mysql_error());
$connection = mysql_select_db($database, $server);

$arrel = 'continguts/';

// XTEC ADDED
// @aginard: Force latin1 connections to DB
mysql_query("SET NAMES 'latin1'");
mysql_query("SET CHARACTER SET latin1");
mysql_query("SET COLLATION_CONNECTION = 'latin1_general_ci'");

