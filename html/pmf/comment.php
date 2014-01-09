<?php
	//Posem les funcions de consulta de la base de dades
	include_once('inc/sessio.inc');

	//INICIALITZEM LA PLANTILLA SMARTY
	#include_once '../../libs/Smarty.class.php';
	include_once 'libs/Smarty.class.php';
	$smarty = new Smarty;
	$smarty->compile_check = true;
	$smarty->debugging = false;
	//Posem les funcions de consulta de la base de dades
	include_once('inc/db.php');
	//if($_REQUEST['comment']==''){
		//Entrem la pregunta a la base de dades
		$date=time();
		$entrada=comment(array('comment'=>$_REQUEST['comment'],'question_id'=>$_REQUEST['question_id'],'author'=>$_REQUEST['author'],'date'=>$date));
		if($entrada){
			$msg="Moltes gr&aacute;cies per entrar un comentari nou.<br /><br />El revisarem, i si ho creiem oport&uacute;, l'inclourem al sistema";
		}else{
			$msg="L'entrada del comentari ha fallat";
		}
		$retorn="suport.php?sid=".$_REQUEST['sid'];
		$retorn_text="Torna";
		$smarty->assign('msg',$msg);
		$smarty->assign('retorn',$retorn);
		$smarty->assign('retorn_text',$retorn_text);
		$smarty->display('msg.htm');
	//}
?>
