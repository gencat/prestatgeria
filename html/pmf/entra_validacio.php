<?php
	include_once('inc/connecta.inc');

	$server = mysql_connect($host, $username, $password) or die(mysql_error());

	// Select the database now:
	$connection = mysql_select_db($database, $server);
	if($_REQUEST['valida']==1){
		//Si no existeix editem el registre
		$sql="update webs_dinamiques set centre=\"".$_REQUEST['centre']."\",url=\"".$_REQUEST['url']."\",localitat=\"".$_REQUEST['municipi']."\",tipusID=".$_REQUEST['tipusID'].",valida=1,obs=\"".$_REQUEST['obs']."\" where wid=".$_REQUEST['wid'];
	}else{
		$sql="update webs_dinamiques set valida=0 where wid=".$_REQUEST['wid'];
	}
	$rs=mysql_query($sql); 

	(!$rs)?	die("La base de dades ha fallat. No ha estat possible entrar el centre.<br /><br />Ho haur�eu de provar m�s endavant."):"";

	header('location:valida.php');

?>