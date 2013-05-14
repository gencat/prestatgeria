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
			$titles['titol_'.$lang['lang']]=$_REQUEST['titol_'.$lang['lang']];
			$validates['valida_'.$lang['lang']]=(isset($_REQUEST['valida_'.$lang['lang']]) && $_REQUEST['valida_'.$lang['lang']]=="on")?1:0;
		}
		#$args=array_merge(array('titol'=>$_REQUEST['titol'],'cid'=>$_REQUEST['cid'],'lang'=>$lang), $titles, $validates);
		$args=array_merge(array('cid'=>$_REQUEST['cid'],'lang'=>$lang), $titles, $validates);
		createSection($args);
		header('location:index.php');
	}

/*	if(isset($_REQUEST['titol']) && $_REQUEST['titol']!=""){
		$valida=(isset($_REQUEST['valida'])?$_REQUEST['valida']:'0');
		createSection(array('titol'=>$_REQUEST['titol'],'id'=>$_REQUEST['id'],'cid'=>$_REQUEST['cid'],'valida'=>$valida,'lang'=>$lang));
		header('location:index.php');
	}*/

	//Agafem les dades dels capítols
	$capitols=getAllChapters(array('validat'=>$_SESSION['validat'],'lang'=>getLang($lang)));

	$smarty->assign('capitols',$capitols);
	$smarty->assign('capitol',$_REQUEST['id']);

	$smarty->assign('langs',$langs);
	$smarty->assign('lang',$lang);

	$smarty->display('nou1.htm');
?>
