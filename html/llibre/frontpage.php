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

if($theme_form!=''){$theme=$theme_form;}
if($lang_form!=''){$lang=$lang_form;}
if($html_editor_form!=''){$html_editor=$html_editor_form;}


//Select the file with the lang strings
include("lang/".$lang.'.php');

if(md5($prefix.$password_admin) != $mypass){
	echo _BOOKACCESSDENAIED;
	exit;
}

function uniqueimagename(){
	global $ext;
	$string = md5(uniqid(microtime(),1));
	$string = substr($string,0,12);
	$init1  =substr($string,0,1);
	$fullname = $string . $ext;
	return $string;
}
   
if ($tablewidth == ""){$tablewidth = 250;}

if ($section == ""){$section = "thoughts";}

if ($page == ""){$page = 1;}

$nextpage = $page + 1;
$errors = "";
if ($action == "doit"){
	if (($myfile != "") && ($myfile != "none")){
		// get a good image name
		$imagename = uniqueimagename();
		if (function_exists('move_uploaded_file')) {
			move_uploaded_file($myfile,$image_folder_path.'/'.$imagename);
		} else {
			copy($myfile,$image_folder_path.'/'.$imagename);
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
	$image_tan = ",openimage='$largeimage'";
	// convert image for netpbm
	$dirpath = $application_root.$image_folder_path;
	if ($Processor == "netpbm"){
		$nextpath = "$dirpath/$largeimage" . "_2.pnm";
		if($ext == ".jpg"){system("$imagemagic/jpegtopnm --quiet $dirpath/$largeimage > $dirpath/$imagename.pnm");}
		if($ext == ".gif"){system("$imagemagic/giftopnm --quiet $dirpath/$largeimage > $dirpath/$imagename.pnm");}
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
				chmod("$nextpath", 0777);
				system("$imagemagic/ppmtojpeg --quiet $nextpath > $dirpath/$largeimage");
				chmod("$dirpath/$largeimage", 0777);
			}
			if($ext == ".gif"){
				system("$imagemagic/pnmscale --quiet -width $maxwidth $dirpath/$imagename.pnm > $nextpath");
				chmod("$nextpath", 0777);
				system("$imagemagic/ppmtogif --quiet $nextpath > $dirpath/$largeimage");
				chmod("$dirpath/$largeimage", 0777);
			}
		}
	}   
}

if($removeimage != ""){
	$image_tan = ",openimage=''";
	unlink($image_folder_path.'/'.$removeimage);   	
}
  
// if we are changing proccessors..
if( ($newProcessor != $Processor) || ($pathtoproccess != $imagemagic)){    
	if( $newProcessor  == 'ImageMagick'){
		$tryone = file_exists($pathtoproccess.'/utilities/convert');
		$fullpathtoit = $pathtoproccess.'/utilities/convert';
		if (!$tryone){
			$tryone = file_exists($pathtoproccess.'/convert');
			$fullpathtoit = $pathtoproccess.'/convert';
			if(!$tryone){
				$errors .= '<li>'._BOOKCANTLOCATEIMAGEMAGICK;
				$errors .= _BOOKISLOOKINGFORFULLPATH.' <strong>'.$pathtoproccess.'</strong> '._BOOKOR.' <strong>'.$pathtoproccess.'/utilities/</strong>';
				$errors .= _BOOKMAKESURENOTENDINGSLASH;
				$errors .= _BOOKBEABLETODOWNLOADNETPBM.' ';
			} else {
				$pathtoproccess = $pathtoproccess."/utilities/";
			}
		}

		// if no errors try thumbnailing the test image.
		if($errors == ""){
			system("$fullpathtoit -geometry 10000x75 test.jpg $image_folder_path/test.jpg");
			chmod ($image_folder_path.'/test.jpg', 0777);
			$info = stat($image_folder_path.'/test.jpg');
			if(($info[7] == 0) || ($info[7] == "") ){
				$errors .= _BOOKERRORRUNNINGIMAGEMAGICK;
				$errors .= '<font color="#007700">'._BOOKHOWOFIX.':</font><ul>';
				$errors .= '<li>'._BOOKMAKESUREBINARIESEXECUTABLE.' <strong>'.$pathtoproccess.'</strong> '._BOOKALLSHOULDBEAT;
				$errors .= '<li>'._BOOKMAKESURETHAT.' <a href="test.jpg" target="_blank">'._BOOKTHISIMAGEEXIST.'</a>'._BOOKTHETESTIMAGE;
				$errors .= '<li>'._BOOKMAKESURECORRECTBINARIES;
				$errors .= '<li>'._BOOKIFALLFAILTRYANOTHERPROCESSOR.'</ul>';
			}
		}
	}

	//netpbm
	if ($newProcessor  == "netpbm"){
		$tryone = file_exists($pathtoproccess.'/pnmscale');
		$fullpathtoit = $pathtoproccess;
		if(!$tryone){
			$errors .= '<li>'._BOOKCANTLOCATENETPBM;
			$errors .= ' '._BOOKISLOOKINGFORFULLPATH.' "<strong>'.$pathtoproccess.'</strong>". ';
			$errors .= _BOOKMAKESURENOTENDINGSLASH.' ';
			$errors .= _BOOKBEABLETODOWNLOADBINARIES;
			$errors .= ' <a href="http://sourceforge.net/projects/csyntax/" target="_blank">http://sourceforge.net/projects/csyntax/</a>';
		} else {
			$pathtoproccess = $pathtoproccess;
		}
	
		// if no errors try thumbnailing the test image.
		if($errors == ""){
			$nextpath = $image_folder_path.'/test' . "_2.pnm";
			system("$pathtoproccess/jpegtopnm --quiet test.jpg > $image_folder_path/test.pnm");
			chmod ($image_folder_path.'/test.pnm', 0777);
			system("$pathtoproccess/pnmscale --quiet -height 400 $image_folder_path/test.pnm > $nextpath");
			chmod ($nextpath, 0777);
			system("$pathtoproccess/ppmtojpeg --quiet $nextpath > $image_folder_path/test.jpg");
			chmod ($image_folder_path.'/test.jpg', 0777);
			$info = stat($image_folder_path.'/test.jpg');
			if(($info[7] == 0) || ($info[7] == "") ){
				$errors .= _BOOKERRORRUNNINGNETPBM;
				$errors .= '<br><font color="#007700">'._BOOKHOWOFIX.':</font>';
				$errors .= '<li>'._BOOKMAKESUREBINARIESEXECUTABLE.' <strong>'.$pathtoproccess.'</strong>. '._BOOKALLSHOULDBEAT755;
				$errors .= '<li>'._BOOKMAKESURETHAT.' <a href="test.jpg" target="_blank">'._BOOKTHISIMAGEEXIST.'</a>'._BOOKITISTHETESTIMAGE;
				$errors .= '<li>'._BOOKMAKESURECORRECTBINARIES;
				$errors .= '<li>'._BOOKIFALLFAILTRYANOTHERPROCESSOR;
			}
		}
	}
}
  
if($errors == ""){
	if (get_magic_quotes_gpc()==1) {
		$query = "UPDATE ".$prefix."_config set showsearch='$showsearch',pathtoproccess='$pathtoproccess',Processor='$newProcessor',adminemail='$adminemail',abouttext='$abouttext',site_title='$title',opentext='$opentext',lang='$lang_form',html_editor='$html_editor_form',theme='$theme_form' $image_tan ";
	} else {
		$query = "UPDATE ".$prefix."_config set showsearch='$showsearch',pathtoproccess='$pathtoproccess',Processor='$newProcessor',adminemail='$adminemail',abouttext='" . addslashes($abouttext) . "',site_title='" . addslashes($title) . "',opentext='" . addslashes($opentext) . "',lang='" . $lang_form . "',html_editor='" . $html_editor_form . "',theme='" . $theme_form . "' $image_tan ";	
	}
	$mydatabase->sql_query($query);
	//XTEC MULTIBOOKS
        include_once dirname(dirname(__FILE__)) . '/prestatgeria/config/config.php';
		include_once '../config/xtecAPI.php';
        $book = explode('_',$prefix);
		$editBook=editBook($book[1], $title, $lang_form);
	//XTEC END?>
		<br>
		<script>
			function gothere(){
				window.parent.location.replace("index.php");
			}
			setTimeout("gothere();",2000);
		</script>	
	<?php if($editBook){?>
		<html>
		<HEAD>
		    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
			<title><?php echo _BOOKLOGINPAGE;?></title>
			<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">		
		</HEAD>
		<body bgcolor="#000000" background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">	
		<?php echo _BOOKMADE;?>
		<br><br><a href="index.php?section=<?php echo $recno;?>" target="_top"><?php echo _BOOKCLICHEREIFESTILREADING;?></a><br><br><br>
		</body>
		</html>
		<?php
		  exit;
		 //XTEC MULTIBOOKS
	}else{?>
		<html>
		<HEAD>
			<title><?php echo _BOOKLOGINPAGE;?></title>
			<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">		
		</HEAD>
		<body bgcolor="#000000" background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">	
		<?php echo _BOOKMADEERROR;?>
		<br><br><a href="index.php?section=<?php echo $recno;?>" target="_top"><?php echo _BOOKCLICHEREIFESTILREADING;?></a><br><br><br>
		</body>
		</html>
	<?php exit;
	//XTEC END
		}
	} 
}
?>

<HTML>
<HEAD>
	<title></title>
	<?php if ($html_editor=='xinha'){?>	
		<script type="text/javascript">
			_editor_url  = "xinha/"  // (preferably absolute) URL (including trailing slash) where Xinha is installed
			_editor_lang = "<?php echo $lang;?>";      // And the language we need to use in the editor.
		</script>
		<script type="text/javascript" src="xinha/XinhaCore.js"></script>	
		<script language="javascript" type="text/javascript" src="xinha/supportXinha.js"></script>
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
</HEAD>

<body bgcolor="#000000" background="themes/<?php echo $theme;?>/images/bkbook.gif" text="#664411" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">
	<a href="index.php" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/back.gif" border="0"></a>
	<center>
			<form action="frontpage.php" method="post" ENCTYPE="multipart/form-data">
				<input type="hidden" name="action" value="doit">
				<strong><?php echo _BOOKEDITINITPAGE;?>:</strong>
				<?php
					if ($errors != ""){
						print '<br><font color="#990000"><strong>'._BOOKNEEDCORRECTIONS.':</strong> <ul>'.$errors.'</ul></font>';
					}
					$query = "SELECT * from ".$prefix."_config ";
					$data = $mydatabase->select($query);
					$row = $data[0];
					if($newProcessor==''){$newProcessor=$Processor;}
					if($pathtoproccess!=''){$imagemagic=$pathtoproccess;}

					$dir = 'themes';
					if (is_dir($dir)) {
						if ($dh = opendir($dir)) {
							while (($file = readdir($dh)) !== false) {
								if(strtolower(substr($file,-1)) !='.' && strtolower(substr($file,-1)) !='..'){
									$themes[]=array('themename'=>$file);
								}
							}
							closedir($dh);
						}
					}
					$dir = 'lang';
					if (is_dir($dir)) {
						if ($dh = opendir($dir)) {
							while (($file = readdir($dh)) !== false) {
								if(strtolower(substr($file,-4)) =='.php'){
									$languages[]=array('filetext'=>substr($file,0,-4));
								}
							}
							closedir($dh);
						}
					} 					
				?>
				<table>
					<tr>
						<td><strong><?php echo _BOOKITEMTITLE; ?>:</strong></td>
						<td><input type="text" size="30" name="title" value="<?php echo stripslashes($row['site_title']); ?>"></td>
					</tr>
					<tr>
						<td valign="top"><strong><?php echo _BOOKIMAGEOPTIONAL; ?>:</strong></td>
						<td>
							<?php
								if ($row['openimage'] != ""){
									print '<img src="'.$image_folder.'/'.$row['openimage'].'"><br><i>'._BOOKTOLOADIMAGE.'<br></i>';
									print _BOOKTOREMOVEIMAGE.' <input type="checkbox" name="removeimage" value='.$row['openimage'].'> '._BOOKCHECKHERE."<br>";
								}
							?>
							<input type="file" size="15" name="myfile">
							<br>
							<?php 
								if (($Processor == "netpbm") || ($Processor == "ImageMagick")){ ?>
									<?php echo _BOOKIMAGESIZE; ?>:
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
									<?php echo _BOOKWIDTH; ?>
								<?php }?>
								(<?php echo _BOOKIMAGEMAXSIZE;?>)<br /><br />
								
						</td>
					</tr>
					<tr>
						<td><strong><?php echo _BOOKTHEME; ?>:</strong></td>
						<td>
							<select name="theme_form">
								<?php foreach($themes as $theme0){?>
									<option <?php if($theme == $theme0['themename']){echo ' selected ';}?>><?php echo $theme0['themename'];?></option>
								<?php }?>
							</select>							
						</td>
					</tr>
					<tr>
						<td><strong><?php echo _BOOKLANGUAGE; ?>:</strong></td>
						<td>
							<select name="lang_form">
								<?php foreach($languages as $language){?>
									<option value="<?php echo $language['filetext'];?>" <?php if ($language['filetext']==$lang){echo ' selected ';}?>><?php echo $language['filetext'];?></option>
								<?php }?>
							</select>
						</td>
					</tr>
					<?php if ($dbtype != "txt-db-api.php"){ ?>
						<tr>
							<td colspan="2"><strong><?php echo _BOOKSHOWSERACHOPTION; ?>:</strong>
								<input type="checkbox" value="YES" name="showsearch" <?php if ($row['showsearch'] == "YES"){ print " checked "; } ?>> 
								- <?php echo _BOOKIFWANTSEARCHINMAINPAGE; ?>
							</td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="2"><strong><?php echo _BOOKINITMESSAGEFRONTPAGE; ?></strong><br>
							<textarea name="opentext" cols="55" rows="10" wrap="virtual"  id="editbook"><?php echo stripslashes($row['opentext']); ?></textarea>
						<br>
							<font color="#990000"><?php echo _BOOKADMINCONFIG; ?>:</font>
							<br>
					</tr>
					<tr>
						<td><strong><?php echo _BOOKHTMLEDITOR; ?>:</strong></td>
						<td>
							<select name="html_editor_form">
								<option value="xinha" <?php if($html_editor=='xinha'){echo ' selected ';}?>>xinha</option>
								<option value="tinyMCE" <?php if($html_editor=='tinyMCE'){echo ' selected ';}?>>tinyMCE</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2"><strong><?php echo _BOOKMESSAGEABOUTWEBMASTER;?></strong><br>
							<textarea name="abouttext" cols="55" rows="10" wrap="virtual" id="editbook2"><?php echo $row['abouttext']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td><strong><?php echo _BOOKADMINEMAIL; ?>:</strong></td>
						<td><input type="text" name="adminemail" size="30" value="<?php echo $row['adminemail']; ?>"></td>
					</tr>
					<!---
					<tr>
						<td bgcolor="#DDDDDD" colspan="2"><strong><?php echo _BOOKIMAGEPROCESSORTYPE;?>:</strong></td>
					</tr>
					<tr>
						<td bgcolor="#EEEECC" colspan="2">
							<?php echo _BOOKABOUTIMAGEPROCESSOR; ?>:
							<ol>
								<li><strong>netPBM </strong>(<font color="#007700"><strong><?php echo _BOOKRECOMENDED; ?></strong></font> <?php echo _BOOKIFYOUHAVEYOURSERVER; ?><br>
								<a href="https://sourceforge.net/projects/myscrapbook/" target="_blank"><?php echo _BOOKCLICKHERETOOPTAINNETPBM;?></a><br>
								<a href="http://sourceforge.net/projects/netpbm/" target="_blank"><?php echo _BOOKIMAGEPROCESOSMAINPAGE;?> NetPBM</a>
								<li><strong>ImageMagick</strong> - <?php echo _BOOKBINARIESPATH;?><br>
								<a href="http://sourceforge.net/projects/netpbm/" target="_blank"><?php echo _BOOKIMAGEPROCESOSMAINPAGE;?></a><a href="http://sourceforge.net/projects/ImageMagick/" target="_blank"> ImageMagick</a>
 --->
 <!--
 <li><strong><font color=000077>Remote Server</font></strong> - if selected cs gallery will attempt to thumbnail your
 images on a remote server. This option will take twice as long to process an 
 image and should only be used if you can not install netPBM or ImageMagick
 and can not process your own images.. 
 -->
 <!---
								<li><strong><font color="#990000"><?php echo _BOOKWITHOUTIMAGEPROCESSOR; ?> </font></strong> - <?php echo _BOOKNEEDGD2LIBRARY; ?>
							</ol>
						</td>
					</tr>
					<tr>
						<td><strong><?php echo _BOOKIMAGEPROCESSOR; ?>: </strong></td>
						<td>
							<select name="newProcessor">
								<option value="netpbm" <?php if ($newProcessor=="netpbm"){print " selected "; } ?>>netPBM</option>
								<option value="ImageMagick" <?php if ($newProcessor=="ImageMagick"){print" selected "; } ?>>ImageMagick </option>
								<option value="none" <?php if ($newProcessor=="none"){print" selected "; } ?>><?php echo _BOOKWITHOUTIMAGEPROCESSOR;?></option>
								--->
								<!-- <option value="csremote" <?php if ($newProcessor=="csremote"){print " SELECTED ";}?>>Remote Server</option>-->
								<!---
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" bgcolor="#FFFFCC">
							<?php echo _BOOKIF; ?> <strong>netpbm</strong> <?php echo _BOOKOR; ?> <strong>ImageMagick</strong> <?php echo _BOOKNOTLAST ;?> /full/path/www/netpbm <?php echo _BOOKNOT; ?> /full/path/www/netpbm/ <br>
							<br>
							<strong><?php echo _BOOKCLUES; ?>:</strong><br>
							Imagemagick <?php echo _BOOKUSEDTOBESIMILAR; ?> <font color="#007700">/usr/X11R6/bin</font><br>
							<font color="#990000"><?php echo _BOOKBESUREEXEBINARIES?></font><br>
						</td>
					</tr>
					<tr>
						<td><?php echo _BOOKPROCESSORPATH;?>:</td>
						<td><input type="text" name="pathtoproccess" size="40" value="<?php echo $imagemagic ?>"></td>
					</tr>
					--->
				</table>
				<input type="submit" value="<?php echo _BOOKUPDATE; ?>">
			</form>
			</center>
			<a href="index.php" target="_top">
			<img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/back.gif" border="0"></a>
		</td>
	</tr>
</table>
</BODY>
</HTML>
