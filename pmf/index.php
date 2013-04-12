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

	$AllChapters=getAllChapters(array('validat'=>$_SESSION['validat'],'lang'=>getLang($lang)));
	
	if(isset($_COOKIE['estat']))
		$estat=$_COOKIE['estat'];
		
	if(empty($estat)){
		$estat="111111111111111111111111111111111111111111111111111111111111";
		//$estat="000000000000000000000000000000000000000000000000000000";
	}
	if(isset($_REQUEST['d'])){
		if($_REQUEST['d']==1){
			$estat="000000000000000000000000000000000000000000000000000000";
		}else{
			$estat="11111111111111111111111111111111111111111111111111";
		}
	}

	if(isset($_REQUEST['i'])){
		//Canvia l'estat del men�
		$estat0=substr($_COOKIE['estat'],0,$_REQUEST['i']);
		$estat1=substr($_COOKIE['estat'],$_REQUEST['i']+1,strlen($_COOKIE['estat']));
		$e=substr($_COOKIE['estat'],$_REQUEST['i'],1);
		if($e==0){$e=1;}else{$e=0;}
		$estat=$estat0.$e.$estat1;
	}

	setcookie('estat',$estat);
	
	$i=0;
	$Items=array();
	$comments=array();
	$newComments=getAllNewComments();
	foreach($newComments as $newComment){
		$questionSid=getQuestionSid(array('question_id'=>$newComment['question_id']));
		$question=getQuestion(array('sid'=>$questionSid,'lang'=>getLang('')));
		if(isset($question['modified']))
			($question['modified']>time()-$days_modified*24*60*60)?$modified=1:$modified=0 ;
		else
			$modified=0;
		
		if(isset($question['created']))
			($question['created']>time()-$days_created*24*60*60)?$created=1:$created=0;
		else
			$created=0;
		if(!isset($question['tid']))
			$question['tid'] = 0;
			
		$comments[]=array('created'=>$created,'modified'=>$modified,'tipus'=>2,'id'=>$question['sid'],'tid'=>$question['tid'],'text'=>$question['pregunta'],'valida'=>$question['valida']);	

	}
	

	foreach($AllChapters as $chapter){
		$i++;
		$estatc01=substr($estat,$i,1);
		($chapter['modified']>time()-$days_modified*24*60*60)?$modified=1:$modified=0;
		($chapter['created']>time()-$days_created*24*60*60)?$created=1:$created=0;
		$Items[]=array('created'=>$created,'modified'=>$modified,'tipus'=>0,'id'=>$chapter['cid'],'text'=>$chapter['titol'],'estatc'=>$estatc01,'i'=>$i,'valida'=>$chapter['valida'],'ordre'=>$chapter['ordre']);
		$AllSections=getAllSections(array('cid'=>$chapter['cid'],'validat'=>$_SESSION['validat'],'lang'=>getLang($lang)));
		foreach($AllSections as $section){
			$i++;
			$estatt01=substr($estat,$i,1);
			($section['modified']>time()-$days_modified*24*60*60)?$modified=1:$modified=0;
			($section['created']>time()-$days_created*24*60*60)?$created=1:$created=0;
			$Items[]=array('created'=>$created,'modified'=>$modified,'tipus'=>1,'id'=>$section['id'],'text'=>$section['titol'],'estatc'=>$estatc01,'estatt'=>$estatt01,'i'=>$i,'valida'=>$section['valida'],'ordre'=>$section['ordre'],'cid'=>$section['cid']);	
			//Agafem les dades de totes les URL validades
			$AllItems=getAllItems(array('cid'=>$chapter['cid'],'id'=>$section['id'],'validat'=>$_SESSION['validat'],'lang'=>getLang($lang)));
			foreach($AllItems as $Item){
				($Item['modified']>time()-$days_modified*24*60*60)?$modified=1:$modified=0;
				($Item['created']>time()-$days_created*24*60*60)?$created=1:$created=0;
				($Item['clics']=='')?$Item['clics']='0':$Item['clics']=$Item['clics'];
				$Items[]=array('created'=>$created,'modified'=>$modified,'tipus'=>2,'id'=>$Item['sid'],'tid'=>$Item['tid'],'text'=>$Item['pregunta'],'estatt'=>$estatt01,'estatc'=>$estatc01,'valida'=>$Item['valida'],'ordre'=>$Item['ordre'],'clics'=>$Item['clics']);	
			}
		}
	}

	$smarty->assign('comments',$comments);
	$smarty->assign('validat',$_SESSION['validat']);
	$smarty->assign('Items',$Items);
	$smarty->assign('arrel',$arrel);
	$smarty->assign('showhits',$showhits);
	$smarty->assign('lang',getLang($lang));
	$smarty->display('index.htm');
?>