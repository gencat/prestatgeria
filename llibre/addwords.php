<?php
//-----------------------------------------------------------------
//MyScrapBook online book program by Eric Gerdes (Crafty Syntax . Com )
//-----------------------------------------------------------------
//Spanish Translation and new features to version 4.0 by Antonio Temprano (antoniotemprano.org)
//----------------------------------------------------------------------------------------------
// Feel free to change this code to better fit your website. I am
// open for any suggestions on how to improve the program and 
// you can submit suggestions and/or bugs to:
// http://craftysyntax.com/myscrapbook/updates/
// if you like using this program and feel it is a good program 
// feel free to send a donation by going to:
// http://craftysyntax.com/myscrapbook/abouts.php
//-----------------------------------------------------------------
require "config.php";
require "functions.php";
include_once $zikulapath . '/modules/advMailer/pnincludes/mailsender.class.php';
include_once $zikulapath . '/modules/advMailer/pnincludes/message.class.php';

//Select the file with the lang strings
include("lang/".$lang.'.php');

if ($tablewidth == ""){$tablewidth = 250;}

if ($section == ""){$section = "1";}

if ($page == ""){$page = 1;}

$nextpage = $page + 1;
$errors = "";
if ($action == "doit"){
	$query = "SELECT ordernum FROM ".$prefix."_words ORDER by ordernum";
	$result_t = $mydatabase->select($query);
	$top_t = $result_t[0];
	$ordernum = $top_t[ordernum] - 1;

	$query = "SELECT * FROM ".$prefix."_contents WHERE recno='$tabtype'";
	$result = $mydatabase->select($query);
	$top_r = $result[0];

	if(has_access("m",$tabtype)){$approved = "Y";}else{$approved = "N";}

	if ($title == ""){ $errors = "<li>"._BOOKTITLEISREQUIRED.'</li>'; }
	if ($comment == ""){ $errors .= "<li>"._BOOKADDTEXT.'</li>'; }
	if ($_FILES['myimage']['size'] > 409600) $errors .= "<li>" . _BOOKFILETOOBIG . '</li>';
	if ($errors == ""){
		if($top_r['notifyemail'] != ""){
			$mailsender = new mailsender($IDAPP,$REPLYADDRESS,$SENDER,$ENVIRONMENT,$LOG,$LOGDEBUG,$LOGPATH);
			$message = new message($CONTENTTYPE,$LOG,$LOGDEBUG,$LOGPATH);
			
			//Indiquem l'adreça del destinatari
			$adr_desti = $top_r['notifyemail'];
			$message->set_to($adr_desti);

			//Assignem assumpte i cos al missatge
			$message->set_subject(_BOOKNEWENTRY);	
			
			$missatge_html = _BOOKDEAR.'<br /><br />'._BOOKAUTOMATICMSG;
			$missatge_html .='<br /><br />'._BOOKNEWENTRYTITLE.':<strong> '.$title.'</strong>';
			$missatge_html .='<br /><br />'._BOOKPLEASENOTREPLY;
			$missatge_html .='<br /><br />'._BOOKTHEMAINUSER;

//			$missatge_pla = _BOOKDEAR.'\n\n'._BOOKAUTOMATICMSG;
//			$missatge_pla .='\n\n'._BOOKNEWENTRYTITLE.": ".$title;
//			$missatge_pla .='\n\n'._BOOKPLEASENOTREPLY;
//			$missatge_pla .='\n\n'._BOOKTHEMAINUSER;

			$message->set_bodyContent($missatge_html);

			$mailsender->add($message);
			
			$exit = $mailsender->send_mail();
				
//			//Si no s'ha pogut enviar realitzem 4 intents més... fem una pausa de 5 s a cada nou intent ( funció sleep )
//			$intents = 1;
//			while ((!$exit) && ($intents < 2)) {
//				sleep(5);
//				$exit = $mail->Send();
//				$intents = $intents + 1;
//			}			
		}

		if (($myimage != "") && ($myimage != "none")){
			// get a good image name
			$imagename = uniqueimagename();
	
			if (function_exists('move_uploaded_file')) {
				move_uploaded_file($myimage,$image_folder_path.'/'.$imagename); 
			}else{
				copy($myimage,$image_folder_path.'/'.$imagename);
			}
			// get the height and width
			$imagehw = GetImageSize($image_folder_path.'/'.$imagename);
			$width = $imagehw[0]; 
			$height = $imagehw[1]; 
			switch($imagehw[2]) {
				case 1:
					$ext = ".gif";
					break;
				case 2:
					$ext = ".jpg";
					break;
				case 3:
					$ext = ".png";
					break;
				case 4:
					$ext = ".swf";
					break;
				case 5:
					$ext = ".psd";
					break;
				case 6:
					$ext = ".bmp";
					break;
			}		
			$largeimage = $imagename . $ext;
			copy($image_folder_path.'/'.$imagename,$image_folder_path.'/'.$largeimage);
			unlink($image_folder_path.'/'.$imagename);
			chmod($image_folder_path.'/'.$largeimage, 0775);
			$image_tan = $largeimage;

			// convert image for netpbm
			$dirpath = $application_root.$image_folder;
			if ($Processor == "netpbm"){
				$nextpath = $dirpath."/".$largeimage."_2.pnm";
				if($ext == ".jpg"){        
					system("$imagemagic/jpegtopnm --quiet $dirpath/$largeimage > $dirpath/$imagename.pnm");     	
				}
				if($ext == ".gif"){
					system("$imagemagic/giftopnm --quiet $dirpath/$largeimage > $dirpath/$imagename.pnm");        	     	
				}	
				chmod("$dirpath/$imagename.pnm", 0777);
			}	  
	  	
			// fix the big image if it is too big
			if($maxwidth == ""){ $maxwidth = 300; }
			if (($width > $maxwidth) && ($Processor != "none")){    
				if ($Processor == "ImageMagick"){
					system("$imagemagic -geometry $maxwidthx10000 $dirpath/$largeimage  $dirpath/$largeimage");   
					chmod("$dirpath/$largeimage", 0777); 
				}
				if ($Processor == "netpbm"){
					if ($ext == ".jpg"){       	     	
						system("$imagemagic/pnmscale --quiet -width $maxwidth $dirpath/$imagename.pnm > $nextpath");
						chmod($nextpath, 0777);
						system("$imagemagic/ppmtojpeg --quiet $nextpath > $dirpath/$largeimage");     	
						chmod("$dirpath/$largeimage", 0777);
					}        
					if($ext == ".gif"){      	     	
						system("$imagemagic/pnmscale --quiet -width $maxwidth $dirpath/$imagename.pnm > $nextpath");
						chmod($nextpath, 0777);
						system("$imagemagic/ppmtogif --quiet $nextpath > $dirpath/$largeimage");     	
						chmod("$dirpath/$largeimage", 0777);
					}        
				}
			} 	
		}

		$comment = nl2br($comment);
		$updated = date("YmdHis",time());
		$query = "INSERT into ".$prefix."_words (email,webaddress,webname,comment,name,title,updated,contentsid,approved,myimage,ordernum) VALUES ";
		if (get_magic_quotes_gpc()==1) {
			$query .= " ('$email','$webaddress','$webname','$comment','$name','$title','$updated','$tabtype','$approved','$image_tan','$ordernum') ";
		} else {
			$query .= " ('$email','$webaddress','". addslashes($webname) . "','". addslashes($comment) . "','". addslashes($name) . "','". addslashes($title) ."','$updated','$tabtype','$approved','$image_tan','$ordernum') ";	
		}
		$mydatabase->insert($query);
		//XTEC MULTIBOOKS
		if($approved=='Y'){
            include('../config/config_books.php');
    		include_once('../config/xtecAPI.php');
    		$book=explode('_',$prefix);
            $editLastEntryBook = editLastEntryBook($book[1]);
           	//get schoolId
    	    $school = getSchool($book[0]);
    	    //Calc the database from school identity
    	    $num = floor($school/50) + 1;
            $database .= $num;
    		updateBookPages($prefix, $database);
			generateRss($prefix);
		}
		//XTEC END
		header("location: thankyou.php?section=$tabtype&approved=$approved&section=$tabtype");
	} else {
		$section = $tabtype;
	}
}
?>

<HTML>
<HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<TITLE><?php echo _BOOKNEWCONTENTTITLE; ?></TITLE>
	<?php if ($html_editor=='xinha'){?>	
		<script type="text/javascript">
			_editor_url  = "xinha/"  // (preferably absolute) URL (including trailing slash) where Xinha is installed
			_editor_lang = "<?php echo $lang;?>";      // And the language we need to use in the editor.
		</script>
		<script type="text/javascript" src="xinha/XinhaCore.js"></script>	
		<script language="javascript" type="text/javascript" src="xinha/supportXinha1.js"></script>
	<?php }else{?>
		<script language="javascript" type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
		<script language="javascript" type="text/javascript">
			tinyMCE.init({
				language : "<?php echo $lang;?>",
				mode : "textareas",
				theme : "advanced",
				content_css : "tinymce/jscripts/tiny_mce/themes/advanced/mycontent.css",
				plugins : "emotions,preview",
				theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,forecolor,backcolor,emotions,preview,fontselect",
				theme_advanced_buttons2 : "",
				theme_advanced_buttons3 : "",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_path_location : "bottom",
				extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"});
		</script>
	<?php  }?>
	<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
</HEAD>

<body bgcolor="#000000" background="themes/<?php echo $theme;?>/images/bkbook.gif" text="#664411" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" >
	<center>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" background="themes/<?php echo $theme;?>/images/bkbook.gif">
			<tr>
				<td width="100%" background="themes/<?php echo $theme;?>/images/bkbook.gif">
				<a href="index.php?section=<?php echo $section ?>&page=-1" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/back.gif" border="0"></a>
				<form action="addwords.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="action" value="doit">
					<center>
						<strong><?php echo _BOOKCREATENEWITEM; ?>:
						<?php
							$query = "SELECT * FROM ".$prefix."_contents WHERE recno='$section'";
							$result = $mydatabase->select($query);
							$top_r = $result[0];
						?>
						<font color="#770000"><strong><i><?php echo $top_r['name']; ?></strong></i></font></strong><br />
						<input type="hidden" name="tabtype" value="<?php echo $section; ?>"><br>
						<?php
							if ($errors != ""){
								print '<br><font color="#990000"><strong>'._BOOKYOUNEEDSOMEINFO.':</strong>'.$errors.'</font>';
							}
						?>
						<table>
							<?php if($top_r['showname'] == "Y"){ ?>
								<tr>
									<td><strong><?php echo _BOOKYOURNAME; ?>:</strong></td>
									<td><input type="text" size="20" name="name" value="<?php echo $name; ?>"></td>
								</tr>
							<?php }?>
							<?php if($top_r['showemail'] == "Y"){ ?>
								<tr>
									<td><strong><?php echo _BOOKREQUIREDMAIL;?>:</strong></td>
									<td><input type="text" size="20" name="email"  value="<?php echo $email; ?>"></td>
								</tr>
							<?php }?>
							<?php if($top_r['showurl'] == "Y"){ ?>
								<tr>
									<td><strong><?php echo _BOOKREQUIREDURL;?>:</strong></td>
									<td><input type="text" size="35" name="webaddress" value="<?php echo $webaddress; ?>"></td>
								</tr>
								<tr>
									<td><strong><?php echo _BOOKURLNAME;?>:</strong></td>
									<td><input type="text" size="35" name="webname"  value="<?php echo $webname; ?>"></td>
								</tr>
							<?php }?>
							<?php if($top_r['showimage'] == "Y"){ ?>
								<tr>
									<td valign="top"><strong><?php echo _BOOKIMAGE;?>:</strong></td>
									<td>
										<input type="file" size="20" name="myimage">
										<?php if (($Processor == "netpbm") || ($Processor == "ImageMagick")){ ?>
											<br>
											<?php echo _BOOKIMAGESIZE;?>:
											<select name="maxwidth">
												<option>500</option>
												<option>450</option>
												<option>400</option>
												<option>350</option>
												<option selected>300</option>
												<option>250</option>
												<option>200</option>
												<option>150</option>
												<option>100</option>
											</select>
											<?php echo _BOOKWIDTH;?>
										<?php }?>
										<br />
										(<?php echo _BOOKIMAGEMAXSIZE;?>)<br /><br />
									</td>
								</tr>
							<?php }?>

							<tr>
								<td><strong><?php echo _BOOKITEMTITLE; ?>:</strong></td>
								<td><input type="text" size="30" name="title"  value="<?php echo $title; ?>"></td>
							</tr>
						</table>
						<strong><?php echo _BOOKTEXTTOSHOW; ?></strong><br>
						<?php if($comment==''){$comment=_BOOKWRITTETHETEXTHERE;}?>
						<textarea name="comment" cols="55" rows="15" wrap="Virtual" id="editbook"><?php echo stripslashes($comment);?></textarea>
						<br>
						<input type="submit" value="<?php echo _BOOKSENDITEM; ?>">
					</center>
				</form>
				<a href="index.php?section=<?php echo $section ?>&page=-1" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/back.gif" border="0"></a>
				</td>
			</tr>
		</table>
	</center>
</body>
</html>
