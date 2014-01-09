<?php
	include_once('inc/connecta.inc');

	$server = mysql_connect($host, $username, $password) or die(mysql_error());

	// Select the database now:
	$connection = mysql_select_db($database, $server);

	$sql="insert into 012_suport (pregunta,capitol,tema,item) values ('".$_REQUEST['pregunta']."','".$_REQUEST['capitol']."','".$_REQUEST['tema']."','".$_REQUEST['item']."')";
	$rs=mysql_query($sql); 
	(!$rs)?	die("La base de dades ha fallat. No ha estat possible entrar les dades.<br /><br />Ho haur�eu de provar m�s endavant."):"";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF8"/>
<link href="css/estils.css" rel="stylesheet" type="text/css"/>
<title>Documento sin t&iacute;tulo</title>
</head>
<body>
<p class="paragraf">Moltes gr�cies per entrar l'enlla� a una resposta</p>
<p><a href="nova.htm" class="paragraf">Torna al formulari</a></p>
<p><a href="index.php" class="paragraf">Torna a la llista</a></p>

</body>
</html>