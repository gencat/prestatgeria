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
	$id=$_REQUEST['id'];

	switch ($_REQUEST['q']){
		case 'c':
			delChapter(array('cid'=>$id));
			break;
		case 't':
			delSection(array('id'=>$id));
			break;
		case 'p':
			delItem(array('sid'=>$id));
			break;
	}
	header('location:index.php');
?>
