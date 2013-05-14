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

if(isset($_REQUEST['submit']) && $_REQUEST['submit']!=""){
	//$titles=array(); $validates=array();
	//foreach ($langs as $lang){
		//$titles['titol_'.$lang['lang']]=$_REQUEST['titol_'.$lang['lang']];
		//$validates['valida_'.$lang['lang']]=($_REQUEST['valida_'.$lang['lang']]=="on")?1:0;
	//}
	$args=array_merge(array('sid'=>$_REQUEST['sid'],'pregunta'=>$_REQUEST['pregunta'],'capitol'=>$_REQUEST['capitol'],'tema'=>$_REQUEST['tema'],'lang'=>$_REQUEST['lang'],'resposta'=>$_REQUEST['resposta'],'altres'=>$_REQUEST['altres']));
	editQuestion($args);
	header('location:index.php');
}


//Agafem les dades dels capítols
$capitols=getAllChapters(array('validat'=>$_SESSION['validat'],'lang'=>getLang($lang)));
//Agafem les dades dels temes
$tema=getAllSections1(array('validat'=>$_SESSION['validat'],'lang'=>getLang($lang)));


$pregunta=getQuestion(array('sid'=>$_REQUEST['sid'],'lang'=>getLang('')));

$smarty->assign('pregunta',$pregunta);
$smarty->assign('capitols',$capitols);
$smarty->assign('tema',$tema);
$smarty->assign('langs',$langs);
$smarty->assign('lang',$lang);

$smarty->display('edita.htm');
?>