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
$errors = "";
require "config.php";

//Select the file with the lang strings
include("lang/".$lang.'.php');

if($action == "register"){
	$myusername = strtolower($myusername);
	if ($myusername == ""){
		$errors = _BOOKNOTENTERUSERNAME."<br>";
	}
	if ($mypassword == ""){
		$errors .= _BOOKNOTENTERUSERPASSWORD."<br>";
	} 
	if ($name == ""){
		$errors .= _BOOKNOTENTERUSEREALNAME."<br>";
	}

	$query = "SELECT * FROM ".$prefix."_users where myusername='$myusername' ";
	$data_1 = $mydatabase->select($query);
	$anyone = count($data_1);
	if($anyone != 0){
		$errors .= _BOOKSORRY.' <b>'.$myusername.'</b> '._BOOKUSERNAMEEXIST.'<br>';
	}
	if ($errors == ""){
		$query = "INSERT into ".$prefix."_users (myusername,mypassword,email,name) VALUES ('$myusername','$mypassword','$email','$name')";
		$recno = $mydatabase->insert($query);
		Header("Location: updatechapter.php?whattodo="._BOOKUSEREDIT);
		exit;
	}
}	

if ($tablewidth == ""){$tablewidth = 250;}

if ($section == ""){$section = "thoughts";}

if ($page == ""){$page = 1;}

$nextpage = $page + 1;

?>

<HTML>
<HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title></title>
	<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
</HEAD>
<body bgcolor="#000000" background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">
<br><br>

<form action="register.php" method="post">
	<p>
	<input type="hidden" name="action" value="register">
	<center>
		<br>
		<br>
		<b><?php echo _BOOKREGISTERANEWUSER;?>:</font>
		<?php
		if ($errors != ""){print '<br><font color="#990000">'.$errors.'</font> ';}
		?>
		<p>&nbsp;  </p>
		<table>
			<tr>
				<td><b><?php echo _BOOKREQUIREDNAME;?>:</b></td>
				<td><input type="text" size="20" name="name" value="<?php echo $name; ?>"></td>
			</tr>
			<tr>
				<td><b><?php echo _BOOKREQUIREDMAIL;?>:</b></td>
				<td><input type="text" size="20" name="email" value="<?php echo $email; ?>"></td>
			</tr>
			<tr>
				<td><b><?php echo _BOOKUSERNAME;?>:</b></td>
				<td><input type=text size="20" name="myusername" value="<?php echo $myusername; ?>"></td>
			</tr>
			<tr>
				<td><b><?php echo _BOOKUSERPASSWORD;?>:</b></td>
				<td><input type="text" size="20" name="mypassword" value="<?php echo $mypassword; ?>"></td>
			</tr>
		</table>
		<p>&nbsp;</p>
		<p><input type="submit" value="<?php echo _BOOKREGISTER;?>"><br><br></p>
	</center>
</form>
</BODY>
</HTML>
