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

	//Agafem les dades dels idiomes
	$langs=getAllLanguages();
	$lang=getLang($lang);
	
	if(isset($_REQUEST['submit']) && $_REQUEST['submit']!=""){
		$titles=array(); $validates=array();
		foreach ($langs as $lang){
			$questions['pregunta_'.$lang['lang']]=$_REQUEST['pregunta_'.$lang['lang']];
			$validates['valida_'.$lang['lang']]=(isset($_REQUEST['valida_'.$lang['lang']]) && $_REQUEST['valida_'.$lang['lang']]=="on")?1:0;
		}
		$args=array_merge(array('tema'=>$_REQUEST['tema']), $questions, $validates);
		createQuestion($args);
		header('location:index.php');
	}
	

/*	if(isset($_REQUEST['pregunta']) && $_REQUEST['pregunta']!=""){
		$valida=(isset($_REQUEST['valida'])?$_REQUEST['valida']:'0');
		createQuestion(array('pregunta'=>$_REQUEST['pregunta'],'tema'=>$_REQUEST['tema'],'valida'=>$valida,'lang'=>$lang));
		header('location:index.php');
	}*/

	//Agafem les dades dels capítols
	$temes=getAllSections1(array('validat'=>$_SESSION['validat']));

	$smarty->assign('temes',$temes);
	$smarty->assign('tema',$_REQUEST['id']);
	
	$smarty->assign('langs',$langs);
	$smarty->assign('lang',$lang);

	$smarty->display('nou.htm');
?>
