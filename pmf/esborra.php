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
	
	switch ($_REQUEST['q']){
		case 'c':
			//Agafem les dades del cap�tol
			$array=getChapter(array('cid'=>$_REQUEST['id'],'lang'=>$lang));
			$text=$array['titol'];
			$id=$array['cid'];
			$tipus='Cap�tol';
			break;
		case 't':
			//Agafem les dades del tema
			$array=getSection(array('id'=>$_REQUEST['id'],'lang'=>$lang));
			$text=$array['titol'];
			$id=$_REQUEST['id'];
			$tipus='Tema';
			break;
		case 'p':
			//Agafem les dades de la pregunta
			$array=getQuestion(array('sid'=>$_REQUEST['id'],'lang'=>$lang));
			$text=$array['pregunta'];
			$id=$array['sid'];
			$tipus='Pregunta';
			break;
	}

	$smarty->assign('text',$text);
	$smarty->assign('q',$_REQUEST['q']);
	$smarty->assign('id',$id);
	$smarty->assign('tipus',$tipus);
	$smarty->display('esborra.htm');
?>
