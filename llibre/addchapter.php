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

//Select the file with the lang strings
include("lang/".$lang.'.php');

if(md5($prefix.$password_admin) != $mypass){
	print _BOOKACCESSDENAIED;
	exit;
}

if($notifyemail==''){
	$notifyemail = $data['adminemail'];
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

if (($name != "") && ($action == "doit")){
	if( ($myimage != "") && ($myimage != "none")){
    
	// get a good image name
	$imagename = uniqueimagename();
   
	if (function_exists('move_uploaded_file')) {
        	move_uploaded_file($myimage,$image_folder_path.'/'.$imagename); 
	} else {
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

	// convert image for netpbm
	$dirpath = $application_root.$image_folder_path;
	if ($Processor == "netpbm"){
		$nextpath = $dirpath."/".$largeimage . "_2.pnm";
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

	$query = "INSERT INTO ".$prefix."_contents (name,openimage,ordernum,permissions,opentext,notifyemail,showname,showemail,showurl,showimage,formatpage,entriespage) VALUES ";
	if (get_magic_quotes_gpc()==1) {
		$query .= " ('$name','$largeimage','$ordernum','$permissions','$comment','$notifyemail','$showname','$showemail','$showurl','$showimage','$formatpage','$entriespage') ";
	} else {
		$query .= " ('" . addslashes($name) . "','$largeimage','$ordernum','$permissions','" . addslashes($comment) . "','$notifyemail','" . addslashes($showname) . "','$showemail','$showurl','$showimage','$formatpage','$entriespage') ";	
   	}
	$mydatabase->insert($query);
	header("Location: index.php");
	exit;
}
?>

<HTML>
<HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<TITLE><?php echo _BOOKADDCHAPTER;?></TITLE>
	<style type="text/css">
		<!--
			.Estilo1 {font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10;}
			.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
			.Estilo6 {font-size: 12px}
			.Estilo9 {font-size: 10px}
			.Estilo10 {font-size: 11px}
			.Estilo11 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
		-->
   	</style>
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
</HEAD>

<body bgcolor="#000000" background="themes/<?php echo $theme;?>/images/bkbook.gif" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" >
	<p><a href="index.php" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/back.gif" border="0"></a></p>
	<center>
		<form action="addchapter.php" method="post" target="_top" enctype="multipart/form-data">
			<input type="hidden" name="action" value="doit">
			<strong><span class="Estilo1"><span class="Estilo6"><?echo _BOOKCREATECHAPTER;?></span>:
			<?if ($errors != ""){print '<br><font color="#990000"><strong>'._BOOKNEEDCORRECTIONS.":</strong><ul>".$errors."</ul></font>";}?>
			<table>
				<tr>
					<td class="Estilo11"><?php echo _BOOKCHAPTERNUMBER;?>:</td>
					<td class="Estilo1"><span class="Estilo6">
						<select name="ordernum">
							 <?php $query = "select * from ".$prefix."_contents";  
								$result3 = $mydatabase->select($query);
								$totalans = count($result3);
								$totalans++;
								for($i=1;$i<41;$i++){
									print "<option value=$i ";
									if($totalans == $i){ print " selected "; }
									print ">$i</option>\n";
								}?>
						</select></span>
					</td>
				</tr>
				<tr>
					<td class="Estilo11"><?php echo _BOOKCHAPTERNAME; ?>:</td>
					<td class="Estilo1"><input name="name" type="text" value="<?php echo "$name"; ?>" size="20"></td>
				</tr>
				<tr>
					<td valign="top" class="Estilo11"><?php echo _BOOKCHAPTERIMAGE;?>:</td>
					<td valign="top" class="Estilo5"><input type="file" name="myimage"><br>
						<?php if (($Processor == "netpbm") || ($Processor == "ImageMagick")){ ?>
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
						<?php } ?>(<?php echo _BOOKIMAGEMAXSIZE;?>)<br /><br />
					</td>
				</tr>
				<tr>
					<td class="Estilo11"><?php echo _BOOKPERMS;?>:</td>
					<td class="Estilo5">
						<select name="permissions">
							<option value="none"><?php echo _BOOKPRIVATECHAPTER;?> *</option>
							<option value="read"><?php echo _BOOKONLYWEBMASTER;?></option>
							<option value="approval" selected><?php echo _BOOKACCEPTWITHAPROVAL;?></option>
							<option value="all"><?php echo _BOOKACCEPTWITHOUTAPROVAL;?></option>
						</select><br>
						*<span class="Estilo9"><?php echo _BOOKPRIVATECHAPTERNEEDEDIT;?></span></td>
				</tr>
				<tr>
					<td class="Estilo1"><span class="Estilo6"><strong><?php echo _BOOKINITTYPE;?></strong></span></td>
					<td class="Estilo1"><span class="Estilo6">
						<select name="entriespage">
							<option value="Y"><?php echo _BOOBEGINENTRYPAGE;?></option>
							<option value="C"><?php echo _BOOBEGINCONTENTPAGE;?></option>
							<option value="N"><?php echo _BOOBEGINPAGEONE;?></option>
						</select></span>
					</td>
				</tr>
				<tr>
					<td class="Estilo1"><span class="Estilo6"><strong><?php echo _BOOKPAGESTYLE;?>:</strong></span></td>
					<td class="Estilo1"><span class="Estilo6">
						<select name=formatpage>
							<option value="2"><?php echo _BOOKTWOPAGES;?></option>
							<option value="1"><?php echo _BOOKONEPAGE;?></option>
						</select></span>
					</td>
				</tr>
				<tr>
					<td class="Estilo5"><strong><?php echo _BOOKUSERREQUIREDFIELDS;?>:</strong></td>
					<td class="Estilo5">
						<table>
							<tr>
								<td><input name="showname" type="checkbox" value="Y" CHECKED></td>
								<td><span class="Estilo10">- <?php echo _BOOKREQUIREDNAME;?></span></td>
								<td><input name="showemail" type="checkbox" value="Y"></td>
								<td><span class="Estilo10">- <?php echo _BOOKREQUIREDMAIL;?></span></td>
								<td><input name="showurl" type="checkbox" value="Y"></td>
								<td><span class="Estilo10">- <?php echo _BOOKREQUIREDURL;?></span></td>
								<td><input name="showimage" type="checkbox" value="Y" CHECKED></td>
								<td><span class="Estilo10">- <?php echo _BOOKREQUIREDUPLOADIMAGE;?></span></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="Estilo5"><strong><?php echo _BOOKMAILTONOTIFYENTRIES;?>:</strong></td>
					<td class="Estilo1"><input name="notifyemail" type="text" value="<?php echo "$notifyemail"; ?>" size="40"></td>
				</tr>
				<tr>
					<td colspan=2 class="Estilo5">
						<strong><?php echo _BOOKINITMESSAGE;?>:</strong><br>
						<textarea name="comment" cols="55" rows="10" wrap="Virtual" id="editbook"><?php echo "$comment"; ?></textarea>
					</td>
				</tr>
			</table>
			<input type="submit" value="<?php echo _BOOKADDNEWCHAPTER;?>">
		</form>
		<br><br>
	</center>
	<a href="index.php" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/back.gif" border="0"></a>	
</BODY>
</HTML>
