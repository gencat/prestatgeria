<?php
	//Posem les funcions de consulta de la base de dades
	include_once('inc/db.php');
	include_once('inc/sessio.inc');

	//INICIALITZEM LA PLANTILLA SMARTY
	include_once $Smarty_path;
	$smarty = new Smarty;
	$smarty->compile_check = true;
	$smarty->debugging = false;

	//Agafem les dades de la pregunta
	$pregunta=getQuestion(array('sid'=>$_REQUEST['sid'],'lang'=>getLang('')));
	if(!$pregunta){
		die('La connexi&oacute; a la base de dades ha fallat');
	}

	//Agafem tots els comentaris
	$getcomments=getAllComments(array('id'=>$pregunta['id'],'lang'=>getLang(''),'validat'=>$_SESSION['validat']));
	$i=0;
	foreach($getcomments as $comment){
		$i++;
		$author=($comment['author']=="")?"No especificat":$comment['author'];
		if($i%2){$backgroud_color='white';}else{$backgroud_color='#EAF9FF';}
		$comments[]=array('backgroud_color'=>$backgroud_color,'id'=>$comment['id'],'comment'=>$comment['comment'],'date'=>date('d/m/Y - H.i',$comment['date']),'author'=>$author,'validate'=>$comment['validate']);
	}
	//Agafem les dades del tema
	$tema=getSection(array('id'=>$pregunta['t'],'sid'=>$pregunta['sid'],'lang'=>getLang('')));
	if(!$tema){
		//die('La connexi� a la base de dades ha fallat');
	}

	//Agafem les dades del cap�tol
	$capitol=getChapter(array('cid'=>$tema['cid'],'lang'=>getLang('')));
	if(!$capitol){
		//die('La connexi� a la base de dades ha fallat');
	}

	//Compabilitzem el nombre de clics que s'han fet sobre aquest �tem
	clics(array('sid'=>$_REQUEST['sid'],'lang'=>getLang($lang),'validat'=>$_SESSION['validat']));
	$words=(isset($_REQUEST['words'])?$_REQUEST['words']:'');
	if(!empty($words)){
		$retorn='search.php?words='.$words;
	}else{
		$retorn='index.php';
	}

	if(isset($_REQUEST['comment']) && $_REQUEST['comment']==1){
		$retorn='suport.php?sid='.$_REQUEST['sid'].'&amp;lang='.getLang($lang);
	}
	$words=explode(' ',$words);

	$resposta=$pregunta['resposta'];

	foreach($words as $word){
		if(!empty($word)){
            //separem per paraules
            $resposta_words=explode(' ',$resposta);//$resposta_words=split(' ',$resposta);
            foreach($resposta_words as $resposta_word){
                //Eliminem tots els tags html
                $resposta_word=strip_tags($resposta_word);
                $resposta_word = unhtmlentities($resposta_word); //utilitzem la funci� que hem creat a db.php
				if(strtolower($word)==strtolower($resposta_word) ){ 
					if(!empty($resposta_word)){
						$resposta=str_replace($resposta_word,'<font color="red"><strong>'.$resposta_word.'</strong></font>',$resposta);
                    }
				}
			}
		}
	}
	if(isset($_REQUEST['comment']))
		$smarty->assign('comment',$_REQUEST['comment']);
	$smarty->assign('sid',$_REQUEST['sid']);
	$smarty->assign('capitol',$capitol['titol']);
	$smarty->assign('tema',$tema);
	$smarty->assign('pregunta',$pregunta['pregunta']);
	$smarty->assign('id',$pregunta['id']);
	$smarty->assign('altres',$pregunta['altres']);
	$smarty->assign('resposta',$resposta);
	$smarty->assign('retorn',$retorn);
	$smarty->assign('admet_comentaris',$admet_comentaris);
	if(isset($comments))
		$smarty->assign('comments',$comments);
	$smarty->assign('validat',$_SESSION['validat']);	
	$smarty->display('suport.htm');
?>
