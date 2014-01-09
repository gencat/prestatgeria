<?php
	//Posem les funcions de consulta de la base de dades
	include_once('inc/sessio.inc');

	//INICIALITZEM LA PLANTILLA SMARTY
	#include_once '../../libs/Smarty.class.php';
	include_once 'libs/Smarty.class.php';
	$smarty = new Smarty;
	$smarty->compile_check = true;
	$smarty->debugging = false;

	//Comprovació de seguretat
	if($_SESSION['validat']!=1){
		$smarty->display('noacces.htm');
		exit;
	}

	//Posem les funcions de consulta de la base de dades
	include_once('inc/db.php');	
	delComment(array('id'=>$_REQUEST['id']));
	header('location:suport.php?sid='.$_REQUEST['sid']);
?>
