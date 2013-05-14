<?php
	//Posem les funcions de consulta de la base de dades
	include_once('inc/db.php');

	//Agafem les dades de la pregunta
	$resultat=editQuestion(array('sid'=>$_REQUEST['sid'],'pregunta'=>$_REQUEST['pregunta'],'capitol'=>$_REQUEST['capitol'],'tema'=>$_REQUEST['tema'],'resposta'=>$_REQUEST['resposta'],'altres'=>$_REQUEST['altres'],'lang'=>$_REQUEST['lang'],));
	if($resultat){
		header('location:index.php');
	}
?>
