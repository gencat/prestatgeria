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

	($_REQUEST['m']=='p')?$ordre=-15:$ordre=+15;

	//Agafem les dades de la pregunta
	if(isset($_REQUEST['tid']) && $_REQUEST['q'] == 'p' ){//preguntes
		#ordre(array('ordre'=>$ordre,'id'=>$_REQUEST['id'],'q'=>$_REQUEST['q'],'tid'=>$_REQUEST['tid'],'cid'=>$_REQUEST['cid']));
		ordre(array('ordre'=>$ordre,'id'=>$_REQUEST['id'],'q'=>$_REQUEST['q'],'tid'=>$_REQUEST['tid'],'lang'=>getLang($lang)));
	}elseif(isset($_REQUEST['cid']) && $_REQUEST['q'] == 't'){//temes
		ordre(array('ordre'=>$ordre,'id'=>$_REQUEST['id'],'q'=>$_REQUEST['q'],'cid'=>$_REQUEST['cid'],'lang'=>getLang($lang)));
	}else{//capitols
		ordre(array('ordre'=>$ordre,'id'=>$_REQUEST['id'],'q'=>$_REQUEST['q'],'lang'=>getLang($lang)));
	}
	
	header('location:index.php');
?>