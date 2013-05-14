<?php
	//Posem les funcions de consulta de la base de dades
	include_once('inc/sessio.inc');

	//INICIALITZEM LA PLANTILLA SMARTY
	include_once $Smarty_path;
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

	//Agafem les dades de la pregunta
	valida(array('id'=>$_REQUEST['id'],'q'=>$_REQUEST['q'],'a'=>$_REQUEST['a'],'lang'=>getLang($lang)));
	
	header('location:index.php');
?>
