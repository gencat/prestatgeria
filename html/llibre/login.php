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

if($action == "logout"){ 
	$query = "UPDATE ".$prefix."_users set loggedin='N' Where recno='$myuser'";
	$mydatabase->sql_query($query);
	if($logins > 6){
		$query = "UPDATE ".$prefix."_config set logins='3'";
		$mydatabase->sql_query($query);
	}
	setcookie("mypass","",0,'/');
	setcookie("myuser","",0,'/'); 
	$query = "UPDATE ".$prefix."_config set loggedin='N'";
	$mydatabase->sql_query($query);
	print _BOOKLOGOUTOK;?>
	<br>
	<script>
		function gothere(){
     			window.parent.location.replace("index.php?section=<?php echo $recno ?>");
     		}
		setTimeout("gothere();",2000); 
	</script>
	<html>
	<HEAD>
	    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<title><?php echo _BOOKLOGINPAGE;?></title>
	</HEAD>
	<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">	
	<body bgcolor="#000000" background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" >
	<br /><a href="index.php?section=<?php echo $recno;?>" target="_top"><?php echo _BOOKCLICHEREIFESTILREADING;?></a><br><br><br>
	</bohy>
	</html>
	<?php
	exit;
}

if($action == "login"){
	$loginok = false;
	$myusername = strtolower($myusername);
	if(($myusername == $myname) && (md5($mypassword) == $password_admin_t)){
		$loginok = true;
		setcookie("myuser","admin",0,'/');
		setcookie("mypass",md5($prefix.md5($mypassword)),0,'/');
		$logins++;
		$query = "UPDATE ".$prefix."_config set loggedin='Y',logins='$logins'";
		$mydatabase->sql_query($query);
	} else {
		$query_d = "SELECT * FROM ".$prefix."_users WHERE myusername='$myusername' AND mypassword='$mypassword'";
		$myrow_d = $mydatabase->select($query_d);
		if(count($myrow_d) != 0){
			$loginok = true;
			$myrow = $myrow_d[0];
			setcookie("myuser",$myrow['recno'],0,'/');
			setcookie("mypass",md5($prefix.$mypassword),0,'/');
			$query = "UPDATE ".$prefix."_users set loggedin='Y' WHERE recno='$myrow[recno]'";
			$mydatabase->sql_query($query);
		}
	}
 	if($loginok == true){
		print _BOOKLOGINCORRECT;
		?>
		<br>
		<script>
			function details(theURL,winName,features) {
				//v1.0 window.open(theURL,winName,features);
			}
			function gothere(num){
				if(num < 250000){
					window.parent.location.replace("index.php?section=<?php echo $recno ?>");
				} else {
					document.mine.submit();
					setTimeout("gothere(2);",2000);
				}
			}
			setTimeout("gothere(<?php echo $logins ?>);",2000);
		</script>
		<form action="http://craftysyntax.com/myscrapbook/abouts.php" method="get" name="mine" target="_blank">
			<input type="hidden" name="v" value="<?php $version; ?>" >
			<input type="hidden" name="p" value="<?php $Processor; ?>" >
		</form>
		<html>
		<HEAD>
			<title><?php echo _BOOKLOGINPAGE;?></title>
		</HEAD>
		<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">	
		<body bgcolor="#000000" background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" >
		<a href="index.php?section=<?php echo $recno;?>" target="_top"><?php echo _BOOKCLICHEREIFESTILREADING?></a><br><br><br>
		</body>
		</html>
		<?php
		exit;
	} else {
		$errors = _BOOKUSERINCORRECT;
	}
}	

if ($tablewidth == ""){$tablewidth = 250;}

if ($section == ""){$section = "thoughts";}

if ($page == ""){$page = 1;}

$nextpage = $page + 1;
?>

<HTML>
<HEAD>
	<title><?php echo _BOOKLOGINPAGE;?></title>
</HEAD>
<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">

<body bgcolor="#000000" background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" >
	<br><br>
	<form action="login.php" method="post">
		<input type="hidden" name="action" value="login">
		<center>
			<table width="500">
				<tr>
					<td>
						<?php echo _BOOKLOGINALLOWEDIT;?>
						<br>
						<br>
						<br>
						<?php echo _BOOKDOCLICKIFNOTALLOWED;?>
						<a href=index.php target=_top><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/back.gif" border=0/></a>
						<?php echo _BOOKRETURNWITHOUTLOGIN; ?>
					</td>
				</tr>
			</table>
			<br>
			<?php
				if ($errors != ""){
					print '<br><font color="#990000">'.$errors."</font> ";
				}
			?>
			<script>
				function details(theURL,winName,features) {
					//v1.0
					window.open(theURL,winName,features);
				}
				// onmouseovers
				r_about = new Image;
				h_about = new Image;
				r_about.src = 'themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/about_pro.gif';
				h_about.src = 'themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/about_pro2.gif';
				r_about2 = new Image;
				h_about2 = new Image;
				r_about2.src = 'themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/about_web.gif';
				h_about2.src = 'themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/about_web2.gif';
			</script>
			<table width="500">
				<tr>
					<td colspan="2" bgcolor="#cc9966" align="center">
						<table width="98%" bgcolor="#FFFFEE" background="themes/<?php echo $theme;?>/images/bkbook.gif">
							<tr bgcolor="#FFFFEE" background="themes/<?php echo $theme;?>/images/bkbook.gif">
								<td align="right" bgcolor="#FFFFEE" background="themes/<?php echo $theme;?>/images/bkbook.gif">
									<b><?php echo _BOOKUSERNAME;?>:</b>
								</td>
								<td>
									<input type="text" size="20" name="myusername" value="<?php echo $myusername; ?>">
								</td>
							</tr>
							<tr bgcolor="#FFFFEE" background="themes/<?php echo $theme;?>/images/bkbook.gif">
								<td align="right" bgcolor="#FFFFEE" background="themes/<?php echo $theme;?>/images/bkbook.gif">
									<b><?php echo _BOOKUSERPASSWORD;?>:</b>
								</td>
								<td>
									<input type="password" size="20" name="mypassword" value="<?php echo $mypassword;?>">
								</td>
							</tr>
							<tr bgcolor="#FFFFEE" background="themes/<?php echo $theme;?>/images/bkbook.gif">
								<td colspan="2" bgcolor="#FFFFEE" background="themes/<?php echo $theme;?>/images/bkbook.gif" align="center">
									<p><a href="lostpass.php"><?php echo _BOOKHASLOSTYOURPASSWORD; ?></a></p>
									<p><br><input type="submit" value="<?php echo _BOOKLOGIN; ?>"><br></p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<br><br>
			<table>
				<tr>
					<td>
						<div align="center">
							<a href="javascript:details('about.php','image374','scrollbars=yes,resizable=yes,width=590,height=420')";>
								<img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/about_book.gif" border="0" name="about2">
							</a>
						</div>
					</td>
				</tr>
			</table>
			<br><br>
			</form>
			<br><br>
			<font size="-2">
				<?php echo _BOOKDISTRIBUTEDBY;?> <a href="http://craftysyntax.com/myscrapbook/?v=<?php $version ?>&p=<?php echo $Processor; ?>" target="_blank">Myscrapbook <?php echo $version; ?></a>
			</font>
		</center>
	</form>
</BODY>
</HTML>
