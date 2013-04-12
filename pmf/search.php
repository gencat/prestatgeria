<?php
	//Posem les funcions de consulta de la base de dades
	include_once('inc/sessio.inc');

	//INICIALITZEM LA PLANTILLA SMARTY
	include_once $Smarty_path;
	$smarty = new Smarty;
	$smarty->compile_check = true;
	$smarty->debugging = false;
	//session_start();
	session_register("estat");

	//Posem les funcions de consulta de la base de dades
	include_once('inc/db.php');

	//Recollim totes les preguntes que tenen alguna de les paraules
	$AllSearch=getAllSearch(array('words'=>$_REQUEST['words'],'validat'=>$_SESSION['validat']));
	$Items=array();
	$found=0;
	foreach($AllSearch as $search){
		if(!isset($oldchapter))
			$oldchapter = "";
		if(!isset($oldsection))
			$oldsection = "";
		//Busquem el tema al qual correspon la pregunta
		//$section=getSection(array('id'=>$search['tid'],'cid'=>$search['cid'])); 
        $section=getSection(array('id'=>$search['tid'], 'lang'=>$search['lang'])); 
		//Busquem el capitol del qual correspon el tema
		$chapter=getChapter(array('cid'=>$section['cid'], 'lang'=>$search['lang'])); 
		($chapter['modified']>time()-$days_modified*24*60*60)?$modified=1:$modified=0;
		($chapter['created']>time()-$days_created*24*60*60)?$created=1:$created=0;
		//if($chapter['cid'] != $oldchapter && ($chapter['valida']==1 && $section['valida']==1 || $_SESSION['validat']==1)){
        if($chapter['cid'] != $oldchapter && ($chapter['valida']==1 && $section['valida']==1 )){
        	#$Items[]=array('created'=>$created,'modified'=>$modified,'tipus'=>0,'id'=>$chapter['cid'],'text'=>$chapter['titol'],'i'=>$i,'valida'=>$chapter['valida'],'ordre'=>$chapter['ordre'],'cid'=>$chapter['cid']);
			$Items[]=array('created'=>$created,'modified'=>$modified,'tipus'=>0,'id'=>$chapter['cid'],'text'=>$chapter['titol'],'valida'=>$chapter['valida'],'cid'=>$chapter['cid']);	
		}
		($section['modified']>time()-$days_modified*24*60*60)?$modified=1:$modified=0;
		($section['created']>time()-$days_created*24*60*60)?$created=1:$created=0;
		//if($section['id']!=$oldsection && ($section['valida']==1 && $chapter['valida']==1 || $_SESSION['validat']==1)){
        if($section['id']!=$oldsection && ($section['valida']==1 && $chapter['valida']==1 )){
        	#$Items[]=array('created'=>$created,'modified'=>$modified,'tipus'=>1,'id'=>$section['id'],'text'=>$section['titol'],'i'=>$i,'valida'=>$section['valida'],'ordre'=>$section['ordre'],'cid'=>$section['cid']);
			$Items[]=array('created'=>$created,'modified'=>$modified,'tipus'=>1,'id'=>$section['id'],'text'=>$section['titol'],'valida'=>$section['valida'],'cid'=>$section['cid']);	
		}
		$oldchapter=$chapter['cid'];
		$oldsection=$section['id'];

		//Busquem la pregunta que compte alguna de les paraules
		//if($section['valida']==1 && $chapter['valida']==1 && $search['valida']==1 || $_SESSION['validat']==1){
        if($section['valida']==1 && $chapter['valida']==1 && $search['valida']==1 ){ 
			($search['modified']>time()-$days_modified*24*60*60)?$modified=1:$modified=0;
			($search['created']>time()-$days_created*24*60*60)?$created=1:$created=0;
			#$Items[]=array('created'=>$created,'modified'=>$modified,'tipus'=>2,'id'=>$search['sid'],'tid'=>$search['tid'],'text'=>$search['pregunta'],'valida'=>$search['valida'],'ordre'=>$search['ordre']);
			$Items[]=array('created'=>$created,'modified'=>$modified,'tipus'=>2,'id'=>$search['sid'],'tid'=>$search['tid'],'text'=>$search['pregunta'],'valida'=>$search['valida']);	
        $found++;
			
		}
 
	}
	$smarty->assign('words',$_REQUEST['words']);
	$smarty->assign('found',$found);
	$smarty->assign('validat',$_SESSION['validat']);
	$smarty->assign('Items',$Items);
	$smarty->display('search.htm');

?>
