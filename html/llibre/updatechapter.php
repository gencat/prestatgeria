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

function uniqueimagename(){
	global $ext;
	$string = md5(uniqid(microtime(),1));
	$string = substr($string,0,12);
	$init1  =substr($string,0,1);
	$fullname = $string . $ext;
	return $string;
}
   
if(md5($prefix.$password_admin) != $mypass){
	print _BOOKACCESSDENAIED;
} else {
	$nextpage = $page + 1;
	$errors = "";
	if($UPDATE_USER != ""){
		if (get_magic_quotes_gpc()==1) {
			$query = "UPDATE ".$prefix."_users set name='$name',email='$email',myusername='$myusername',mypassword='$mypassword' WHERE recno='$userid'";
		} else {
			$query = "UPDATE ".$prefix."_users set name='" . addslashes($name) . "',email='" . addslashes($email) . "',myusername='" . addslashes($myusername) . "',mypassword='" . addslashes($mypassword) . "' WHERE recno='$userid'";
		}
		$mydatabase->sql_query($query);
	}
	if($removeuser != ""){
		$query = "delete from ".$prefix."_users where recno='$removeuser'";
		$mydatabase->sql_query($query);
		$query = "delete from ".$prefix."_access where userid='$removeuser'";
		$mydatabase->sql_query($query);
	}

	//AQU� VA LO DE EDITAR USUARIOS
	if($whattodo == _BOOKUSEREDIT){

		$query = "Select * FROM ".$prefix."_users order by myusername";
		$data = $mydatabase->select($query);
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<title></title>
			<script>
				function details(theURL,winName,features) {
					//v1.0
					window.open(theURL,winName,features);
				}
			</script>
			<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
		</head>
		<body background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633">
			<p align="center"><strong><font size="+2" color="#664411"><?php echo _BOOKUSERS;?></font></strong></p>
			<div align="center">
				<a href="register.php"><?php echo _BOOKNEWUSER; ?></a>
				&nbsp;|&nbsp;
				<a href="index.php" target="_top"><?php echo _BOOKGOBACKTOCONTENTS;?></a>
			</div><br>
			<table width="100%" border="0">
				<tr>
					<td width="50%">
						<div align="right">
							<?php echo _BOOKCREATEMULTIPLEUSERS;?>
						</div>
					</td>
					<td width="2%">
						<a href="javascript:details('help/add_users_text_file_<?php echo $lang;?>.php','image374','scrollbars=yes,resizable=yes,width=590,height=420')"; onmouseover="document.about2.src=h_about2.src" onmouseout="document.about2.src=r_about2.src">
						<img src="themes/<?php echo $theme;?>/images/help.gif" alt="help" border="0" /></a>
						<a href="help/add_users_text_file.php"></a>
					</td>
					<td width="48%">
						<form action="addusers.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
							<input name="userfile" type="file" id="userfile" />
							<input type="submit" name="Submit" value="<?php echo _BOOKSEND;?>" />
						</form>
					</td>
				</tr>
			</table>
			<br>
			<form action="updatechapter.php" method="post">
				<input type="hidden" name="whattodo" value="<?php echo _BOOKUSEREDIT;?>">
				<center>
					<table border="1">
						<tr bgcolor="#DDDDDD">
							<td><?php echo _BOOKREQUIREDNAME;?></td>
							<td><?php echo _BOOKUSERNAME;?></td>
							<td><?php echo _BOOKUSERPASSWORD;?></td>
							<td><?php echo _BOOKREQUIREDMAIL;?></td>
							<td><?php echo _BOOKACTIONS;?></td>
						</tr>
						<?php
						for($k=0;$k<count($data); $k++){
							$row = $data[$k];
							if($edituser == $row['recno']){?>
								<tr>
									<td><input type="text" name="name" value="<?php echo $row['name'];?>" size="20"></td>
									<td><input type="text" name="myusername" value="<?php echo $row['myusername'];?>" size="20"></td>
									<td><input type="text" name="mypassword" value="<?php echo $row['mypassword']?>" size="20"></td>
									<td><input type="text" name="email" value="<?php echo $row['email']?>" size="20"></td>
									<td>
										<input type="hidden" name="userid" value="<?php echo $row['recno'];?>">
										<input type="submit" name="UPDATE_USER" value="<?php echo _BOOKUPDATE;?>">
									</td>
								</tr>
							<?} else {?>
								<tr>
									<td><?php echo $row['name'];?></td>
									<td><?php echo $row['myusername'];?></td>
									<td><?php echo $row['mypassword'];?></td>
									<td><?php echo $row['email'];?></td>
									<td>
										<a href="updatechapter.php?edituser=<?php echo $row['recno'];?>&whattodo=<?php echo _BOOKUSEREDIT;?>"><?php echo _BOOKEDIT; ?></a>
										<a href="updatechapter.php?removeuser=<?php echo $row['recno'];?>&whattodo=<?php echo _BOOKDELETE;?>"><font color="#990000"><?php echo _BOOKDELETE;?></font></a>
									</td>
								</tr>	
							<?php }
						}?>
					</table>
				</center>
			</form>
			<br><br>
			<div align="center">
				<a href="register.php"><?php echo _BOOKNEWUSER;?></a>
				&nbsp;|&nbsp;
				<a href="index.php" target="_top"><?php echo _BOOKGOBACKTOCONTENTS;?></a>
			</div><br><br>
		<?php
		exit;
	}


	if($whattodo == _BOOKGIVEACCESS){
		$query = "INSERT INTO ".$prefix."_access (userid,contentsid,myaccess) VALUES ('$adduser','$recno','R') ";
		$mydatabase->sql_query($query);
		Header("Location: bookcontents.php?section=$recno&page=-1&viewis=editmode");
		exit;
	}

	if($whattodo == _BOOKUPDATEPERMS){
		$query = "UPDATE ".$prefix."_contents set permissions='$permissions' WHERE recno='$recno'";
		$mydatabase->sql_query($query);

		 // update user permissions.
		while (list($key, $val) = each($HTTP_POST_VARS)) {                   
			$array = split("_",$key);
			if( ($array[0] == "myaccess") && (($val != "")) ){
				$query = "UPDATE ".$prefix."_access set myaccess='$val' WHERE recno='$array[1]' ";
				$mydatabase->sql_query($query);
			}
		}  
		Header("Location: bookcontents.php?section=$recno&page=-1&viewis=editmode");
		exit;
	}

	if($whattodo == _BOOKUPDATE){
		$query = "SELECT * FROM ".$prefix."_contents where recno='$recno' ";
		$data1 = $mydatabase->select($query);
		$data1 = $data1[0];
		if($removephoto == "YES"){
			unlink($image_folder_path.'/'.$data1['openimage']);
			$largeimage = "";
		}
		if (($myfile != "") && ($myfile != "none")){
			// get rid of old image
			if( ($removephoto == "") && ($data1['openimage'] != "")){
				unlink($image_folder_path.'/'.$data1['openimage']);
				if($data1['largeimage'] != ""){
					unlink($image_folder_path.'/'.$data1['largeimage']);
				}
				$openimage = "";
			}
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
			chmod($image_folder_path.'/'.$largeimage, 0777);
			// convert image for netpbm
			$dirpath = $application_root . $image_folder_path;
			if ($Processor == "netpbm"){
				$nextpath = "$dirpath/$largeimage" . "_2.pnm";
				if($ext == ".jpg"){system("$imagemagic/jpegtopnm --quiet $dirpath/$largeimage > $dirpath/$imagename.pnm");}
				if($ext == ".gif"){system("$imagemagic/giftopnm --quiet $dirpath/$largeimage > $dirpath/$imagename.pnm");}
				chmod("$dirpath/$imagename.pnm", 0777);
			}
			// fix the big image if it is too big
			if($maxwidth == ""){$maxwidth = 300;}
			if (($width > $maxwidth) && ($Processor != "none")){
				$high_res = $imagename . "_high" . $ext;
				copy("$dirpath/$largeimage", "$dirpath/$high_res");
				chmod("$dirpath/$high_res", 0777);
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
				unlink("$dirpath/$high_res");
				$high_res = "";
			} 
		}
		if (get_magic_quotes_gpc()==1) {
			$query = "UPDATE ".$prefix."_contents set notifyemail='$notifyemail ',name='$name',opentext='$opentext',openimage='$largeimage',permissions='$permissions',showimage='$showimage',showurl='$showurl',showemail='$showemail',showname='$showname',entriespage='$entriespage',ordernum='$ordernum',formatpage='$formatpage' WHERE recno='$recno'";
		} else {
			$query = "UPDATE ".$prefix."_contents set notifyemail='$notifyemail ',name='" . addslashes($name) . "',opentext='" . addslashes($opentext) . "',openimage='$largeimage',permissions='$permissions',showimage='$showimage',showurl='$showurl',showemail='$showemail',showname='" . addslashes($showname) . "',entriespage='$entriespage',ordernum='$ordernum',formatpage='$formatpage' WHERE recno='$recno'";	
		}
		$mydatabase->sql_query($query);
  
		// update user permissions.
		while (list($key, $val) = each($HTTP_POST_VARS)) {
			$array = split("_",$key);
			if( ($array[0] == "myaccess") && (($val != "")) ){
				$query = "UPDATE ".$prefix."_access set myaccess='$val' WHERE recno='$array[1]' ";
				$mydatabase->sql_query($query);
			}
		}
		print _BOOKCHAPTERUPDATED;
	}

	if($whattodo == _BOOKDELETE){
		$data2 = $mydatabase->select("SELECT * FROM ".$prefix."_words where contentsid='$recno'");
		$pages = count($data2);
		if($pages == 0){
			$query = "DELETE FROM ".$prefix."_contents WHERE recno='$recno'";
			$mydatabase->sql_query($query);
			print _BOOKCHAPTERREMOVED;
	} else {
		print '<font color="#990000">'._BOOKNEEDDELETEALLPEGES.'</font>. '._BOOKYOUCANNOW.' <a href=javascript:window.close()>'._BOOKCLOSEWINDOW.'</a>';
	}

}
?> 
<br>
<script>   
	function gothere(){
		window.parent.location.replace("index.php?section=<?php echo $recno;?>&page=-1");
	}
	setTimeout("gothere();",2000); 
</script>
	<HEAD>
		<title><?php echo _BOOKLOGINPAGE;?></title>
	</HEAD>
	<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">	
	<body bgcolor="#000000" background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" >
	<br /><a href="index.php?section=<?php echo $recno;?>&page=-1" target="_top"><?php echo _BOOKCLICHEREIFESTILREADING;?></a><br><br><br>
	</body>
	</html>
	<?php
	exit;
}
?>
</body>
</html>
