<?php
//-----------------------------------------------------------------
//MyScrapBook online book program by Eric Gerdes (Crafty Syntax . Com )
//-----------------------------------------------------------------
// Feel free to change this code to better fit your website. I am
// open for any suggestions on how to improve the program and 
// you can submit suggestions and/or bugs to:
// http://craftysyntax.com/myscrapbook/updates/
// if you like using this program and feel it is a good program 
// please send a donation by going to:
// http://craftysyntax.com/myscrapbook/abouts.php
//-----------------------------------------------------------------
include 'config.php';
$version = '4.0';

//If the language is not selected
if(!isset($_REQUEST['lang']) || $_REQUEST['lang']==''){
	header('location:setup0.php');
	exit;
}

$lang=$_REQUEST['lang'];

//Select the file with the lang strings
include("lang/".$lang.'.php');

if($image_folder==''){$image_folder='userimages';}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca_ES">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link rel="stylesheet" href="style.css" type="text/css">	
</head>
<body>
<?php

// first check to see if the setup already ran if so do not do this page.
if ($installed == true){
	print _BOOKINIT."<a href=index.php>"._BOOKDOCLIC."</a>";
	print '</body>';
	print '</html>';
	exit;
}

// check to see if they can parse php
if (false) {
	?>
		<META HTTP-EQUIV="refresh" content="2;URL=nophp.htm">
	<?php
}

if ($action == _BOOKINSTALLBOOK){
	// need to know what way the slashes are.
	$whatway = ($hosting == "WINDOWS")?"\\":"/";
	
	// check for errors.
	if($image_folder==''){
		$errors .= '<li>'._BOOKIMAGEFOLDERNOTDEFINED;
	}else{
		if (!file_exists($image_folder_path)){$errors .= '<li>'._BOOKIMAGEFOLDERNOTEXIST;}
	}
	
	if ($password == ""){$errors .= "<li>"._BOOKNOTPASS;}

	if ($password != $password2){$errors .= "<li>"._BOOKPASSDIF;}
	$password = ereg_replace("[^A-Za-z0-9]", "", $password);
	if ($password != $password2){$errors .= "<li>"._BOOKPASSINV;}
	if ($email == ""){ $errors .= "<li>"._BOOKNOTEMAIL; }
	if ($dbtype == "mysql_options.php"){
		if ($database == ""){ $errors .= "<li>"._BOOKNOTNAMEBBDD;}
		if ($datausername == ""){ $errors .= "<li>"._BOOKNOTUSERNAMEBBDD; }
		if ($mypassword == ""){ $errors .= "<li>"._BOOKNOTPASSBBDD; }
		if($errors == ""){
			$conn = mysql_connect($server,$datausername,$mypassword);		
			if(!$conn) {
				$errors .= "<li>"._BOOKNOTCONECTBBDD; 
			} 
		if(!mysql_select_db($database,$conn)) {
			$errors .= "<li>"._BOOKERRORBBDD; 
		}
	}
}

//ImageMagick
if ($Processor == "ImageMagick"){
	$tryone = file_exists($pathtoproccess."/utilities/convert");
	$fullpathtoit = $pathtoproccess."/utilities/convert";
	if (!$tryone){
		$tryone = file_exists($pathtoproccess."/convert");
		$fullpathtoit = $pathtoproccess."/convert";
		if(!$tryone){
			$errors .= _BOOKLOCATEIMAGEMAGICK;
			$errors .= _BOOKIMAGEMAGICKPATH." <strong>".$pathtoproccess."</strong> "._BOOKOR." <strong>".$pathtoproccess."/utilities/</strong>";
			$errors .= _BOOKBESUREPATH;
			$errors .= _BOOKBEABLE;
		} else {
			$pathtoproccess = $pathtoproccess."/utilities/";
		}
	}

	// if no errors try thumbnailing the test image.
	if($errors == ""){
		system($fullpathtoit." -geometry 10000x75 test.jpg $image_folder_path/test.jpg"); 	
		chmod ($image_folder_path.'/test.jpg', 0777);
		$info = stat($image_folder_path.'/test.jpg');
		if(($info[7] == 0) || ($info[7] == "") ){
			$errors .= _BOOKERRORTESTIMAGE;          	
			$errors .= '<font color="#007700">'._BOOKHOWTORESOLT.'</font><ul>';
			$errors .= "<li>"._BOOKBESUREBINARIESAREEXECUTABLE." <strong>".$pathtoproccess."</strong> "._BOOKNEED755PERMS;      
			$errors .= "<li>"._BOOKBESUREIMAGE." <a href=test.jpg target=_blank>"._BOOKIMAGEEXISTS."</a> "._BOOKTRYIMAGE;
			$errors .= "<li>"._BOOKBESURECORRECTBINARIES;
			$errors .= "<li>"._BOOKERRORPROCESSOR;    
		}
	}
}

//netpbm
if ( $Processor == "netpbm"){
	$tryone = file_exists($pathtoproccess."/pnmscale");
	$fullpathtoit = $pathtoproccess;
	if(!$tryone){
		$errors .= "<li>"._BOOKCANTLOCATENETPBM;
		$errors .= _BOOKISLOOKINGFORFULLPATH." <strong>".$pathtoproccess."</strong>";
		$errors .= _BOOKMAKESURENOTENDINGSLASH;
		$errors .= _BOOKBEABLETODOWNLOADBINARIES;
		$errors .= '<a href="http://sourceforge.net/projects/csyntax/" target="_blank"> http://sourceforge.net/projects/csyntax/</a>';
	} else {
		$pathtoproccess = $pathtoproccess;
	}

	// if no errors try thumbnailing the test image.
	if($errors == ""){
 		$nextpath = $image_folder_path.'/test' . "_2.pnm";    
        	system($pathtoproccess."/jpegtopnm --quiet test.jpg > $image_folder_path/test.pnm"); 
        	chmod ($image_folder_path.'/test.pnm', 0777);    		
        	system($pathtoproccess."/pnmscale --quiet -height 400 $image_folder_path/test.pnm > $nextpath");
        	chmod ($nextpath, 0777);    	
     		system($pathtoproccess."/ppmtojpeg --quiet $nextpath > $image_folder_path/test.jpg");     	
     		chmod ($image_folder_path.'/test.jpg', 0777);    	
		$info = stat($image_folder_path.'/test.jpg');
		if(($info[7] == 0) || ($info[7] == "") ){
			$errors .= _BOOKERRORRUNNINGNETPBM;          	
			$errors .= '<font color="#007700">'._BOOKHOWOFIX.':</font><ul>';
			$errors .= '<li>'._BOOKMAKESUREBINARIESEXECUTABLE.' <strong>'.$pathtoproccess.'</strong> '._BOOKALLSHOULDBEAT755;
			$errors .= '<li>'._BOOKMAKESURETHAT.' <a href="test.jpg" target="_blank">'._BOOKTHISIMAGEEXIST.'</a> '._BOOKTHETESTIMAGE;
			$errors .= '<li>'._BOOKMAKESURECORRECTBINARIES;
			$errors .= '<li>'._BOOKIFALLFAILTRYANOTHERPROCESSOR.'</ul>';          
		}
	}
}

if ($dbtype == "txt-db-api.php"){
	$filename = $txtpath . $whatway . "touch.txt";
	$fp3 = fopen ($filename, "w+");	
	if(!$fp3){
		$errors .= '<li>'._BOOKFOLDERTXTNOTWRITTEABLE.' <strong>'.$txtpath.'</strong> '._BOOKBESUREPREMSARE777; 
	}
}

if( ($homepage == "") || ($homepage == "http://www.urltoyourwebsite.com") ){ 
	$errors .= '<li>'._BOOKNOTVALIDURL;
}

if ($dbtype == "MSaccess.php"){
	$conn = new COM("ADODB.Connection") or $errors .= '<li>'._BOOKNOTADODBCONNECTION;
	$conn->Open("DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbpath;");
	$rs = $conn->Execute("SELECT * FROM ".$prefix."_config");    // Recordset
	$num_columns = $rs->Fields->Count(); 
}

if ($errors == ""){
	// setup the config file..
	$fcontents = implode ('', file ('config.php'));
	$fcontents = ereg_replace("installed=false","installed=true",$fcontents);
	$fcontents = ereg_replace("INPUT-DBTYPE",$dbtype,$fcontents);
	$fcontents = ereg_replace("INPUT-SERVER",$server,$fcontents);
	$fcontents = ereg_replace("INPUT-DATABASE",$database,$fcontents);
	$fcontents = ereg_replace("INPUT-DATAUSERNAME",$datausername,$fcontents);
	$fcontents = ereg_replace("INPUT-PASSWORD",$mypassword,$fcontents);
	$fcontents = ereg_replace("INPUT-HOSTING",$hosting,$fcontents);
	$fcontents = ereg_replace("INPUT-PREFIX",$prefix,$fcontents);
	
	$lastchar = substr($txtpath,-1);
	if($lastchar != $whatway){ $txtpath .= $whatway; }
	$lastchar = substr($rootpath,-1);  
	if($lastchar != $whatway){ $rootpath .= $whatway; }
	$fcontents = ereg_replace("INPUT-TXTPATH",stripslashes($txtpath),$fcontents);
	$fcontents = ereg_replace("INPUT-ROOTPATH",stripslashes($rootpath),$fcontents);
	$fcontents = ereg_replace("INPUT-DBPATH",stripslashes($dbpath),$fcontents);
	$insert_query = "INSERT INTO ".$prefix."_config 	
			(recno,site_title,site_home,mypass,loggedin,opentext,openimage,logins,abouttext,version,
			adminemail,pathtoproccess,Processor,showsearch,lang,image_folder,theme) VALUES (1, 
			'$site_title', '$homepage', '$password', 'Y', '"._BOOKINITINSTALLMESSAGE."', '','0','"._BOOKINITPAGECANBEUPDATED."','4.0',
			'$email','$pathtoproccess','$Processor','N','$lang','$image_folder_uri','$theme')";

	// update the config file.
	$fp = fopen ("config.php", "w+");
	fwrite($fp,$fcontents);
	fclose($fp);

	// build the database.
	if ($dbtype == "MSaccess.php"){
		$conn = new COM("ADODB.Connection") or die("Cannot start ADO");
		$conn->Open("DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbpath;");
		$rs = $conn->Execute($insert_query);   	
	}

	if($installationtype == "newinstall"){
		if ($dbtype == "txt-db-api.php"){
			$txtpath = stripslashes($txtpath);
			$filepath = "$txtpath" . $whatway . "myscrapbook";
			mkdir ("$filepath", 0777);
			$filepath = "$txtpath" . $whatway ."myscrapbook" . $whatway ."scrapbook_access.txt";
			$fp = fopen ("$filepath", "w+");
			$headerfields = "recno#userid#contentsid#myaccess#\n";
			$headerfields .= "inc#int#int#str#\n";
			fwrite($fp,$headerfields);
			fclose($fp);
			chmod("$filepath", 0777);
			$filepath2 = "$txtpath" . $whatway ."myscrapbook" . $whatway ."scrapbook_config.txt";
			$fp2 = fopen ("$filepath2", "w+");
			$headerfields ="recno#site_title#site_home#mypass#loggedin#opentext#openimage#logins#abouttext#version#adminemail#pathtoproccess#Processor#showsearch#\n";
			$headerfields .= "inc#str#str#str#str#str#str#int#str#str#str#str#str#str#\n";
			$headerfields .= "1#$site_title#$homepage#$password#Y#"._BOOKINITINSTALLMESSAGE.'##0#'._BOOKINITPAGECANBEUPDATED."#4.0#$email#$pathtoproccess#$Processor#N#\n";
			fwrite($fp2,$headerfields);
			fclose($fp2);
			chmod($filepath, 0777);

			$filepath = $txtpath . $whatway ."myscrapbook" . $whatway ."scrapbook_contents.txt";
			$fp = fopen("$filepath", "w+");
			$headerfields = "recno#name#openimage#ordernum#opentext#permissions#notifyemail#entriespage#showname#showemail#showurl#showimage#formatpage#sortby#insertto#\n";
			$headerfields .= "inc#str#str#int#str#str#str#str#str#str#str#str#int#str#str#\n";
			fwrite($fp,$headerfields);
			fclose($fp);
			chmod($filepath, 0777);

			$filepath = $txtpath . $whatway ."myscrapbook" . $whatway ."scrapbook_users.txt";
			$fp = fopen ($filepath, "w+");
			$headerfields = "recno#myusername#mypassword#email#name#loggedin#\n";
			$headerfields .= "inc#str#str#str#str#str#\n";
			fwrite($fp,$headerfields);
			fclose($fp);
			chmod($filepath, 0777);
			$filepath = $txtpath . $whatway ."myscrapbook" . $whatway ."scrapbook_words.txt";
			$fp = fopen ($filepath, "w+");
			$headerfields = "id#section#email#webaddress#webname#comment#name#title#updated#contentsid#approved#myimage#ordernum#imagealign#\n";
			$headerfields .= "inc#str#str#str#str#str#str#str#str#str#str#str#int#str#\n";
			fwrite($fp,$headerfields);
			fclose($fp);
			chmod("$filepath", 0777);
		}
		if ($dbtype == "mysql_options.php"){
			$sql = "CREATE TABLE ".$prefix."_config (
				recno int(10) NOT NULL auto_increment,
				site_title varchar(60) NOT NULL default '',
				site_home varchar(255) NOT NULL default '',
				mypass varchar(30) NOT NULL default '',
				loggedin char(1) NOT NULL default 'N',
				opentext text NOT NULL,
				openimage varchar(60) NOT NULL default '',
				logins int(5) NOT NULL default '0',
				abouttext text NOT NULL,
				version varchar(25) NOT NULL,
				adminemail varchar(255) NOT NULL,
				pathtoproccess varchar(255) NOT NULL,
				Processor varchar(255) NOT NULL,
				showsearch varchar(25) NOT NULL,
				lang varchar(2) NOT NULL,
				image_folder varchar(12) NOT NULL,
				theme varchar(12) NOT NULL,				
				PRIMARY KEY  (recno))";
	 		$results = mysql_query($sql,$conn);
			if(!$results){
				echo '<H2>'._BOOKCREATETABLEERROR.'</H2>\n';
				echo mysql_errno().":  ".mysql_error()."<P>";
				$wentwrong = true;
			}
 			$results = mysql_query($insert_query,$conn);
			if(!$results) {
				echo '<H2>'._BOOKCREATETABLEERROR.'</H2>\n';
				echo mysql_errno().":  ".mysql_error()."<P>";
				$wentwrong = true;
			}		

			$sql  ="CREATE TABLE ".$prefix."_access (
				recno int(10) NOT NULL auto_increment,
				userid int(10) NOT NULL default '0',
				contentsid int(10) NOT NULL default '0',
				myaccess char(1) NOT NULL default 'N',
				PRIMARY KEY  (recno))";
			$results = mysql_query($sql,$conn);
			if(!$results){
				echo '<H2>'._BOOKCREATETABLEERROR.'</H2>\n';
				echo mysql_errno().":  ".mysql_error()."<P>";
				$wentwrong = true;
			}
			$sql  ="CREATE TABLE ".$prefix."_contents (
				recno int(10) NOT NULL auto_increment,
				name varchar(150) NOT NULL default '',
				openimage varchar(80) NOT NULL default '',
				ordernum int(10) NOT NULL default '0',
				opentext text NOT NULL,
				permissions varchar(30) NOT NULL default '',
				notifyemail varchar(80) NOT NULL default '',
				entriespage char(1) NOT NULL default 'Y',
				showname char(1) NOT NULL default 'Y',
				showemail char(1) NOT NULL default 'Y',
				showurl char(1) NOT NULL default 'Y',
				showimage char(1) NOT NULL default 'Y',
				formatpage int(2) NOT NULL default '2',
				sortby varchar(30) NOT NULL default '',
				insertto varchar(30) NOT NULL default '',
				PRIMARY KEY  (recno))";
			$results = mysql_query($sql,$conn);
			if(!$results){
				echo '<H2>'._BOOKCREATETABLEERROR.'</H2>\n';
				echo mysql_errno().":  ".mysql_error()."<P>";
				$wentwrong = true;
			}
			$sql  ="CREATE TABLE ".$prefix."_users (
				recno int(10) NOT NULL auto_increment,
				myusername varchar(60) NOT NULL default '',
				mypassword varchar(60) NOT NULL default '',
				email varchar(80) NOT NULL default '',
				name varchar(100) NOT NULL default '',
				loggedin char(1) NOT NULL default 'N',
				PRIMARY KEY  (recno))";
			$results = mysql_query($sql,$conn);
			if(!$results){
				echo '<H2>'._BOOKCREATETABLEERROR.'</H2>\n';
				echo mysql_errno().":  ".mysql_error()."<P>";
				$wentwrong = true;
			}
			$sql  ="CREATE TABLE ".$prefix."_words (
				id int(30) NOT NULL auto_increment,
				section varchar(150) default NULL,
				email varchar(150) default NULL,
				webaddress varchar(150) default NULL,
				webname varchar(150) default NULL,
				comment text,
				name varchar(100) default NULL,
				title varchar(70) default NULL,
				updated timestamp(14) NOT NULL,
				contentsid int(10) NOT NULL default '0',
				approved char(1) NOT NULL default 'N',
				myimage varchar(60) NOT NULL default '',
				ordernum int(11) NOT NULL default '0',
				imagealign varchar(60) NOT NULL default 'top',
				PRIMARY KEY  (id),KEY id (id))";
 			$results = mysql_query($sql,$conn);
			if(!$results){
				echo '<H2>'._BOOKCREATETABLEERROR.'</H2>\n';
				echo mysql_errno().":  ".mysql_error()."<P>";
				$wentwrong = true;
			}	 
		}
	}
	?>
	<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
	<center>
	<table width="400">
		<tr>
			<td bgcolor="#FFFFCC"><strong><font size="+3"><?php echo _BOOKINITINSTALLFINISHED;?></font></strong></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFEE"><?php echo _BOOKCLICKTOLOGGIN;?>
		<br><br><center>
		<strong><?php echo _BOOKUSERNAME;?>:</strong>admin <br>
		<strong><?php echo _BOOKUSERPASSWORD;?>:</strong><?php echo $password2;?><br>
		</center>
		<br>
		<!--   <FORM ACTION=http://craftysyntax.com/installation.php Method=GET name=mine TARGET=_blank>
			<input type=hidden name=pr value=myscrapbook >
			<input type=hidden name=v value=<?php echo $version ?> >
			<input type=hidden name=p value=<?php echo $Processor ?> >
			<input type=hidden name=d value=<?php echo $dbtype ?> >
			<input type=hidden name=i value=<?php echo $installationtype ?> >
			</FORM>
		-->
		<script>
			document.mine.submit();
		</script>
		<?
		print '<a href="login.php">'._BOOKCLICTOADMIN.'</a></td></tr></table>';
		print '</body>';
		print '</html>';
		exit;
	}
}

?>
<script>
	<!--function tellme(){openwindow('http://craftysyntax.com/myscrapbook/bugs.php?from=myscrapbook','image460','scrollbars=yes,resizable=yes,width=500,height=400');} -->
	function openwindow(theURL,winName,features) {
		win2 = window.open(theURL,winName,features); 
		window.win2.focus(); 
	}
</script>

<h2><?php echo _BOOKMYSCRAPBOOKINSTALL;?> <?php $test_dir = getcwd();?></h2>
<p><a href="setup0.php"><?php echo _BOOKRETURN;?></a></p>
<?php echo _BOOKPROBLEMSINTHISPAGE;?> <a href="http://www.craftysyntax.com/support/index.php?c=2" target="_blank"><?php echo _BOOKCLICKHERETOLINKSUPPORTPAGE;?></a>
<hr>
<?php
if ($errors != ""){?>
	<table width="600px">
		<tr>
			<td><ul><font color="#990000"><?php echo _BOOKERRORS;?>: <?php echo $errors;?></font></ul></td>
		</tr>
	</table>
<?php }
// Check to see if we can write to the config file.
$fp = fopen ("config.php", "r+");
$fp2 = fopen ($image_folder_path.'/touch.txt', "w+");

if((!$fp) || (!$fp2)){?>
	<table width="500" bgcolor="#FFFFEE">
		<tr>
			<td>
				<?php if (!$fp){ ?>
					<font color="#990000" size="+2"><strong><?php echo _BOOKCONFIGFILECANBEOPEN;?> <font color="#000099">config.php</font> <?php echo _BOOKTOBEWRITTE;?>:</strong></font><br>
				<?php } ?>
				<?php if (!$fp2){ ?>
					<font color="#990000" size="+2"><strong><?php echo _BOOKIMAGEFOLDERCANBEOPEN;?> <font color="#000099"><?php echo $image_folder;?></font> <?php echo _BOOKTOBEWRITTE;?>:</strong></font><br>
				<?php } ?>
				<font color="#007700"><strong><?php _BOOKHOWITWORK;?></strong></font><br />
				<?php echo _BOOKCONFIGANDUSERIMAGENEEDPERMS;?><br /><br />
				<img src="directions.gif">
				<br>
				<br>
			</td>
		</tr>
	</table>
	
	<?php
	print '</body>';
	print '</html>';
	exit;
}

if($hosting == ""){ 
// guess
	if( (eregi("c:",$test_dir)) || (eregi("d:",$test_dir)) ||(eregi("e:",$test_dir)) || (eregi("f:",$test_dir))|| (eregi("g:",$test_dir))|| (eregi("h:",$test_dir)) || (eregi("i:",$test_dir))){
    	$hosting = "WINDOWS";
	} else {
    	$hosting = "UNIX";
  	}
}?>

<form action="setup.php" method="post" name="myform">
	<input type="hidden" name="lang" value="<?php echo $lang; ?>">
	<input type="hidden" name="installationtype" value="newinstall">
	<table width="600" bgcolor="#FFFFEE">
		<tr>
			<td bgcolor="#DDDDDD" colspan="2">
				<strong><?php echo _BOOKINSTALLOPTIONS;?>:</strong>
			</td>
		</tr>
		<tr>
			<td bgcolor="#EEEECC" colspan="2">
				<?php echo _BOOKACTUALIZASYSTEM;?>
				<br>
				<font color="#990000"><strong><?php echo _BOOKVERSIONINFNOTACTUALIZABLE;?></strong></font>
			</td>
		</tr>
		<tr>
			<td><?php echo _BOOKINSTALL;?>:</td>
			<td>
				<select name="installationtype">
					<option value="newinstall"><?php echo _BOOKNEWINSTALL;?></option>
					<option value="upgrade" <?php if($installationtype == "upgrade"){echo " selected ";}?>><?php echo _BOOKUPDATEINSTALL;?></option>
				</select>
			</td>
		</tr>	
		<tr>
			<td bgcolor="#DDDDDD" colspan="2">
				<strong><?php echo _BOOKHOSTINGTYPE;?>:</strong>
			</td>
		</tr>
		<tr>
			<td bgcolor="#EEEECC" colspan="2">
				<?php echo _BOOKHOSTINGEXPLANATION;?>
			</td>
		</tr>
		<tr>
			<td><?php echo _BOOKHOSTING;?>:</td>
			<td>
				<select name="hosting" onChange="document.myform.submit();">
					<option value="UNIX">UNIX</option>
					<option value="WINDOWS" <?php if($hosting == "WINDOWS"){print " selected ";}?>>WINDOWS</option>
				</select>
			</td>
		</tr>
	</table>
</form>
<?php
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
?>

<form action="setup.php" method="post" name="erics">
	<input type="hidden" name="lang" value="<?php echo $lang;?>">
	<input type="hidden" name="hosting" value="<?php echo $hosting; ?>">
	<table width="600" bgcolor="#FFFFEE">
		<tr>
			<td bgcolor="#DDDDDD" colspan="2"><strong><?php echo _BOOKNEWBOOKTITLE;?>:</strong></td>
		</tr>
		<tr>
			<td bgcolor="#EEEECC" colspan="2"><?php echo _BOOKNEWBOOKTITLEINFO;?></td>
		</tr>
		<tr>
			<td><?php echo _BOOKNEWBOOKTITLE;?>:</td>
			<td><input type="text" name="site_title" size="40" value="<?php echo $site_title ?>"></td>
		</tr>
		<?php
		if ($homepage == ""){$homepage  = "http://";}
		?>
		<tr>
			<td bgcolor="#DDDDDD" colspan="2"><strong><?php echo _BOOKYOURINITPAGE;?>:</strong></td>
		</tr>
		<tr>
			<td bgcolor="#EEEECC" colspan="2"><?php echo _BOOKTHISWILLBETHEINITPAGE;?></td>
		</tr>
		<tr>
			<td><?php echo _BOOKURLINITPAGE;?>:</td>
			<td><input type="text" name="homepage" size="40" value="<?php echo $homepage ?>"></td>
		</tr>
		<tr>
			<td bgcolor="#DDDDDD" colspan="2">
				<strong><?php echo _BOOKADMINPASSWORD;?>:</strong>
			</td>
		</tr>
		<tr>
			<td bgcolor="#EEEECC" colspan="2"><?php echo _BOOKADMINLOGINAECRET;?></td>
		</tr>
		<tr>
			<td><?php echo _BOOKUSERPASSWORD;?>:</td>
			<td><input type="password" name="password" size="10" value="<?php echo $password ?>"></td>
		</tr>
		<tr>
			<td><?php echo _BOOKADMINPASSWORDAGAIN;?>:</td>
			<td><input type="password" name="password2" size="10" value="<?php echo $password2 ?>"></td>
		</tr>
		<tr>
			<td bgcolor="#DDDDDD" colspan="2"><strong><?php echo _BOOKADMINEMAIL;?>:</strong></td>
		</tr>
		<tr>
			<td bgcolor="#EEEECC" colspan="2"><?php echo _BOOKADMINEMAILINFO;?></td>
		</tr>
		<tr>
			<td><?php echo _BOOKREQUIREDMAIL;?>:</td>
			<td><input type="text" name="email" size="30" value="<?php echo $email ?>"></td>
		</tr>
		<tr>
			<td bgcolor="#DDDDDD" colspan="2"><strong><?php echo _BOOKFULLPATH;?>:</strong></td>
		</tr>
		<tr>
			<td bgcolor="#EEEECC" colspan="2"><?php echo _BOOKFULLPATHINFO;?></td>
		</tr>
		<tr>
			<td><?php echo _BOOKFULLPATH;?>:</td>
			<td><input type="text" name="rootpath" size="55" value="<?php if($rootpath != ""){echo stripslashes($rootpath);}else{echo getcwd();}?>"></td>
		</tr>
		<tr>
			<td bgcolor="#DDDDDD" colspan="2"><strong><?php echo _BOOKIMAGEPROCESSORTYPE;?>: </strong></td>
		</tr>
		<tr>
			<td bgcolor="#EEEECC" colspan="2">
				<?php echo _BOOKABOUTIMAGEPROCESSOR;?>:
				<ol>
					<li>
						<strong>netPBM</strong>(<font color="#007700"><strong><?php echo _BOOKRECOMENDED;?></strong></font>) - <?php echo _BOOKIFYOUHAVEYOURSERVER;?>
						<br>
						<a href=https://sourceforge.net/projects/myscrapbook/ target=_blank><?php echo _BOOKCLICKHERETOOPTAINNETPBM;?></a>
						<br>
						<a href=http://sourceforge.net/projects/netpbm/ target=_blank><?php echo _BOOKIMAGEPROCESOSMAINPAGE;?> NetPBM</a>
					<li>
						<strong>ImageMagick</strong> - <?php echo _BOOKBINARIESPATH;?>
						<br>
						<a href=http://sourceforge.net/projects/ImageMagick/ target=_blank><?php echo _BOOKIMAGEPROCESOSMAINPAGE;?> ImageMagick</a>
 
 <!--
 <li><strong><font color="#000077">Remote Server</font></strong> - if selected cs gallery will attempt to thumbnail your
 images on a remote server. This option will take twice as long to process an 
 image and should only be used if you can not install netPBM or ImageMagick
 and can not process your own images.. 
 -->

					<li>
						<strong><font color="#990000"><?php echo _BOOKWITHOUTIMAGEPROCESSOR;?></font></strong> - <?php echo _BOOKNEEDGD2LIBRARY;?>
				</ol>
			</td>
		</tr>
		<tr>
			<td><?php echo _BOOKIMAGEPROCESSOR;?>: </td>
			<td>
				<select name="Processor">
					<option value="netpbm" <?php if ($Processor == "netpbm"){echo " selected "; } ?> >netPBM </option>
					<option value="ImageMagick" <?php if ($Processor == "ImageMagick"){echo " selected "; } ?> >ImageMagick </option>
					<!-- <option value=csremote <?php if ($Processor == "csremote"){ print " SELECTED "; } ?> >Remote Server</option>-->
					<option value="none" <?php if ($Processor == "none"){ print " selected "; } ?>><?php echo _BOOKWITHOUTIMAGEPROCESSOR;?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" bgcolor="#FFFFCC">
				<?php echo _BOOKIF;?> <strong>netpbm</strong> <?php echo _BOOKOR;?> <strong>ImageMagick</strong> <?php echo _BOOKNOTLAST;?> /full/path/www/netpbm <?php _BOOKNOT;?> /full/path/www/netpbm/ <br><br>
				<strong><?php echo _BOOKCLUES;?>:</strong><br>Imagemagick <?php echo _BOOKUSEDTOBESIMILAR;?> <font color="#007700">/usr/X11R6/bin</font><br>
 				<font color="#990000"><?php echo _BOOKBESUREEXEBINARIES;?></font>
				<br>
			</td>
		</tr>
		<tr>
			<td><?php echo _BOOKPROCESSORPATH?>:</td>
			<td><input type="text" name="pathtoproccess" size="40" value="<?php echo $pathtoproccess;?>"></td>
		</tr>
		<tr>
			<td bgcolor="#DDDDDD" colspan="2"><strong><?php echo _BOOKIMAGEFOLDER;?>:</strong></td>
		</tr>
		<tr>
			<td bgcolor="#EEEECC" colspan="2"><?php echo _BOOKIMAGEFOLDERINFO;?></td>
		</tr>		

		<tr>
			<td><?php echo _BOOKIMAGEFOLDERPATH?>:</td>
			<td><input type="text" name="image_folder" size="40" value="<?php echo $image_folder;?>"></td>
		</tr>
		<tr>
			<td bgcolor="#DDDDDD" colspan="2"><strong><?php echo _BOOKTHEME;?>:</strong></td>
		</tr>
		<tr>
			<td bgcolor="#EEEECC" colspan="2">
				<table>
				<tr>
				<?php foreach($themes as $theme0){?>
					<td><img src="themes/<?php echo $theme0['themename'];?>/view.png" border="0"></td>
				<?php }?>
				</tr>
				<tr>
				<?php foreach($themes as $theme0){?>
					<td align="center"><strong><?php echo $theme0['themename'];?></strong></td>
				<?php }?>
				</tr>				
				</table>
			</td>
		</tr>		
		<tr>
			<td><?php echo _BOOKCHOISETHEME;?>:</td>
			<td>
				<select name="theme">
					<?php foreach($themes as $theme0){?>
						<option <?php if($theme == $theme0['themename']){echo ' selected ';}?>><?php echo $theme0['themename'];?></option>
					<?php }?>
				</select>
			</td>
		</tr>
		<tr>
			<td bgcolor="#DDDDDD" colspan="2"><strong><?php echo _BOOKDATABASETYPE;?>:</strong></td>
		</tr>
		<tr>
			<td bgcolor="#EEEECC" colspan="2"><?php echo _BOOKDATABASETYPEINFO;?></td>
		</tr>
		<tr>
			<td><?php echo _BOOKDATABASE;?>:</td>
			<td>
				<select name="dbtype">
					<option value="mysql_options.php" <?php if ($dbtype == "mysql_options.php"){ print " selected ";}?>>MySQL</option>
					<?php if ($hosting == "WINDOWS"){ ?>
						<option value="MSaccess.php" <?php if ($dbtype == "MSaccess.php"){ print " selected ";}?>>Microsoft Access</option>
					<?php } else { ?>
						<option value="txt-db-api.php" <?php if ($dbtype == "txt-db-api.php"){ print " selected ";}?>>txt-db-api (<?php echo _BOOKPLAINTEXTFILE;?>)</option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<ul>
				<table bgcolor="#FFFFCC">
					<tr>
						<td colspan="2"><?php echo _BOOKIF;?> <strong>MySQL</strong> <?php echo _BOOKHASBEENSELECTED;?>:</td>
					</tr>
					<tr>
						<td><?php echo _BOOKDATABASESERVER;?>:</td>
						<td><input type="text" name="server" size="20" value="<?php echo $server ?>" ></td>
					</tr>
					<tr>
						<td><?php echo _BOOKDATABASENAME;?>:</td>
						<td><input type="text" name="database" size="20" value="<?php echo $database ?>"></td>
					</tr>
					<tr>
						<td><?php echo _BOOKDATABASEUSER;?>:</td>
						<td><input type="text" name="datausername" size="20" value="<?php echo $datausername ?>"></td>
					</tr>
					<tr>
						<td><?php echo _BOOKDATABASEUSERPASSWORD;?>:</td>
						<td><input type="text" name="mypassword" size="20" value="<?php echo $mypassword ?>"></td>
					</tr>
					<tr>
						<td><?php echo _BOOKDATABASEPREFIX;?>:</td>
						<td><input type="text" name="prefix" size="20" value="<?php echo $prefix ?>"></td>
					</tr>
				</table><br>
				<?php if ($hosting == "WINDOWS"){ ?>
					<table bgcolor="#FFFFCC">
						<tr>
							<td colspan="2">
								<?php echo _BOOKIF;?> <strong>Microsoft Access</strong> <?php echo _BOOKIFACCESSTRIED;?> (<strong>D:\inetpub\mywebspace\db\scrapbook.mdb</strong>)
								<br>
								<font color="#990000"><?php echo _BOOKMDBSPECIALFOLDER;?></font>
							</td>
						</tr>
						<tr>
							<td><?php echo _BOOKDBPATH;?>:</td>
							<td><input type="text" name="dbpath" size="55" value="<?php if($dbpath != ""){echo stripslashes($dbpath); } else {echo getcwd() . "???????????\\scrapbook.mdb";}?>" ></td>
						</tr>
					</table>
				<?php } else { ?>
					<table bgcolor="#FFFFCC">
						<tr>
							<td colspan="2">
								<?php echo _BOOKIF;?> <strong>txt-db-api (<?php echo _BOOKPLAINTEXTFILE;?>)</strong> <?php echo _BOOKIFTEXTPLAINTRIED;?>
							</td>
						</tr>
						<tr>
							<td><?php echo _BOOKTXTPATH;?>:</td>
							<td><input type="text" name="txtpath" size="55" value="<?php if($txtpath != ""){echo stripslashes($txtpath); } else { echo $test_dir.'/'.$image_folder;} ?>"></td>
						</tr>
					</table>
				<?php } ?>
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>
<input type="submit" name="action" value="<?php echo _BOOKINSTALLBOOK;?>">
</form>
</doby>
</html>
