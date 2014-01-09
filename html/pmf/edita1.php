<?php
	//Posem les funcions de consulta de la base de dades
	include_once('inc/sessio.inc');

	//INICIALITZEM LA PLANTILLA SMARTY
	include_once $Smarty_path;
	$smarty = new Smarty;
	$smarty->compile_check = true;
	$smarty->debugging = false;

	//Comprovaci� de seguretat
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
		$args=array_merge(array('id'=>$_REQUEST['id'],'sid'=>$_REQUEST['sid'],'cid'=>$_REQUEST['cid']), $titles, $validates);
		editSection($args);
		header('location: index.php');
	}

/*
	if(isset($_REQUEST['titol']) && $_REQUEST['titol']!="" && $_REQUEST['setlang']!='true'){
		$valida=(isset($_REQUEST['valida'])?$_REQUEST['valida']:'0');
		editSection(array('titol'=>$_REQUEST['titol'],'id'=>$_REQUEST['id'],'cid'=>$_REQUEST['cid'],'valida'=>$valida,'lang'=>$lang));
		header('location:index.php');
	}
*/

	//Agafem les dades del tema
	$temes=array();
	foreach ($langs as $l){
		$tema=getSection(array('id'=>$_REQUEST['id'],'lang'=>$l['lang']));
		$tema['name']=$l['name'];
		array_push($temes, $tema);
	}
	$langs=$temes;
	
	//Agafem les dades del tema
	$tema=getSection(array('id'=>$_REQUEST['id'],'lang'=>$lang));
	
	//$tema=array('id'=>$_REQUEST['id']);


	//Agafem les dades dels cap�tols
	$capitols=getAllChapters(array('validat'=>$_SESSION['validat'],'lang'=>getLang($lang)));

	$smarty->assign('capitols',$capitols);
	$smarty->assign('tema',$tema);
	$smarty->assign('langs',$langs);
	$smarty->assign('lang',$lang);

	$smarty->display('edita1.htm');
?>
