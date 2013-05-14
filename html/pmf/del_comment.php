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
	
	//Agafem les dades del tema
	$array=getComment(array('id'=>$_REQUEST['id']));
	$smarty->assign('comment',$array['comment']);
	$smarty->assign('id',$_REQUEST['id']);
	$smarty->assign('sid',$_REQUEST['sid']);
	$smarty->display('del_comment.htm');
?>
