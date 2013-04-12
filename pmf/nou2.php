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


	if(isset($_REQUEST['submit']) && !empty($_REQUEST['submit'])){
		$titles=array(); $validates=array();
		foreach ($langs as $lang){
			$titles['titol_'.$lang['lang']]=$_REQUEST['titol_'.$lang['lang']];
			$validates['valida_'.$lang['lang']]=(isset($_REQUEST['valida_'.$lang['lang']]) && $_REQUEST['valida_'.$lang['lang']]=="on")?1:0;
		}
		//if(isset($_REQUEST['titol']) && empty($_REQUEST['titol']) && isset($_REQUEST['cid']) && empty($_REQUEST['cid'])){
			$args=array_merge(array('lang'=>$lang), $titles, $validates);
			createChapter($args);
		//}
		header('location:index.php');
	}


/*	if(isset($_REQUEST['titol']) && $_REQUEST['titol']!=""){
		$valida=(isset($_REQUEST['valida'])?$_REQUEST['valida']:'0');
		createChapter(array('titol'=>$_REQUEST['titol'],'valida'=>$valida,'lang'=>$lang));
		header('location:index.php');
	}*/
	
	$smarty->assign('langs',$langs);
	$smarty->assign('lang',$lang);

	$smarty->display('nou2.htm');
?>
