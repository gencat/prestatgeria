<?php
	//Posem les funcions de consulta de la base de dades
	include_once('inc/sessio.inc');

	//INICIALITZEM LA PLANTILLA SMARTY
	include_once $Smarty_path;
	$smarty = new Smarty;
	$smarty->compile_check = true;
	$smarty->debugging = false;
	
	//Posem les funcions de consulta de la base de dades
	include_once('inc/db.php');
	if(!isset($_REQUEST['pregunta'])){
		//Agafem les dades de la pregunta
		$smarty->display('nova.htm');
	}else{
		//Entrem la pregunta a la base de dades
		$entrada=nova(array('pregunta'=>$_REQUEST['pregunta'],'resposta'=>$_REQUEST['resposta'],'altres'=>$_REQUEST['altres'],'lang'=>getLang($lang)));
		if($entrada){
			$msg="Moltes gr&aacute;cies per entrar un suggeriment nou.<br /><br />El revisarem, i si ho creiem oport&uacute;, l'inclourem al sistema";
		}else{
			$msg="L'entrada de la pregunta ha fallat";
		}
		$smarty->assign('retorn_text','Torna a l\'index');
		$smarty->assign('retorn','index.php');
		$smarty->assign('msg',$msg);
		$smarty->display('msg.htm');
	}
?>
