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
//Select the file with the lang strings
include('lang/'.$lang.'.php');

$query = "SELECT * FROM ".$prefix."_contents WHERE recno='$section'";
$result = $mydatabase->select($query);
$top_r = $result[0];
$next = $page + 1;
$back = $page - 1;
$current = $page;
$othercurrent = $current + 1;
$formatpage = $top_r['formatpage'];
$entriespage = $top_r['entriespage'];
	
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title>words</title>
<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
</head>

<?php
if($formatpage == 1){
	$next_l = $page + 1;
	$back_l = $page - 1;
	if( ($back_l < 1) && ($entriespage == "N")){
		$backlink = "index.php";
	} else {
		$backlink = "singlepage.php?html=bookcontents.php&footer=1&section=$section&page=$back_l";
	}
	$nextlink = "singlepage.php?html=bookcontents.php&footer=1&section=$section&page=$next_l";
	$entireslink = "singlepage.php?html=bookcontents.php&footer=1&section=$section&page=0";
	$entireslink = "index.php?section=$section&page=-1";
	
} else {
	$next_l = $page + 1;
	$back_l = $page - 2;
	$backlink = "index.php?section=$section&page=$back_l";
	$nextlink = "index.php?section=$section&page=$next_l";
	$entireslink = "index.php?section=$section&page=-1";
}
?>

<body background="themes/<?php echo $theme;?>/images/bot_l.gif" bgcolor="#ffffff" >
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="10" align="center"><hr></td>
		</tr>
		<tr><?php if ($current < 0){
			if (islogedin()){?>
				<td align="center"><a href="singlepage.php?html=login.php&action=logout" target="_top" title="<?php echo _BOOKLOGOUT?>"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/exit.gif" border="0" alt="<?php echo _BOOKLOGOUT;?>"></a>
				</td>
			<?php } else {?>
				<td align="center"><a href="singlepage.php?html=login.php" target="_top" title="<?php echo _BOOKLOGIN;?>"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/login.gif" border="0" alt="<?php echo _BOOKLOGIN;?>"></a></td>
			<?php }
			// this is the main page. only admin has access to it.
			if($section == "") { $h = "frontpage"; } else { $h = "bookcontents"; }
			if(md5($prefix.$password_admin) == $mypass){?>
				<td align="center"><a href="singlepage.php?html=<?php echo $h; ?>.php&section=<?echo $section;?>&page=<?echo $page;?>&viewis=editmode&username=<?php echo $username;?>" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/edit.gif" border="0"></a></td>
			<?php }
			if($formatpage == 1){?>
				<td><a href="<?php echo $nextlink; ?>" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/next.gif" border="0"></a></td>
			<?php }
			// now we are in the book
		} else {
			if ((($current % 2)== 1) || ($formatpage == 1)){?>
				<td align="left"><a href="<?php echo $backlink; ?>" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/back.gif" border="0"></a></td>
				<?php if(((md5($prefix.$password_admin) == $mypass) || (has_access("F",$section))) && ($page != 0)){ ?>
					<td align="center"><a href="singlepage.php?html=bookcontents.php&footer=1&section=<?echo "$section"?>&page=<?echo "$page"?>&viewis=editmode&username=<?php echo $username; ?>" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/edit.gif" border="0"></a></td>
				<?php }
				// if this chapter allows outside submissions then show this icon 
				if(has_access("A",$section)){?>
					<td align="center"><a href="singlepage.php?html=addwords.php&section=<?echo "$section"?>" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/add.gif" border="0"></a></td>
				<?php } else { ?>
					<td align="center">&nbsp;</td>
				<?php } ?>
				<td align="center"><a href="<?php echo $entireslink;?>" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/entries.gif" border="0"></a></td>
			<?} 
			if ((($current % 2) == 0) || ($formatpage == 1)){?>
				<td align="center">
					<?php if ($section != ""){ ?>
						<a href="index.php" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/content.gif" border="0"></a>
					<?php } else {
						print "&nbsp;";
					}?>
				</td>
				<?php if ($section != ""){ ?>
					<?php if(has_access("F",$section)&& ($page != 0) && ($formatpage != 1)){ ?>
						<td align="center"><a href="singlepage.php?html=bookcontents.php&footer=1&section=<?php echo $section; ?>&page=<?php echo $page;?>&viewis=editmode&username=<?php echo $username; ?>" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/edit.gif" border="0"></a></td>
					<?php } ?>
				<?php } else { ?>
					<?php if (islogedin()){ ?>
						<td align="center"><a href="singlepage.php?html=login.php&action=logout" target="_top" title="<?php echo _BOOKLOGOUT;?>"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/exit.gif" border="0" alt="<?php echo _BOOKLOGIN;?>"></a></td>
					<?php } else { ?>
						<td align="center"><a href="singlepage.php?html=login.php" target="_top" title="<?php echo _BOOKLOGIN;?>"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/login.gif" border="0" alt="<?php echo _BOOKLOGIN;?>"></a></td> 
					<?php } ?>
				<?php } ?>
				<td align="center">
					<?php if ($section != ""){
						// if this chapter allows outside submissions then show this icon
						if( (has_access("A",$section)) && ($formatpage != 1) ){?>
							<td align="center"><a href="singlepage.php?html=addwords.php&section=<?php echo "$section"?>" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/add.gif" border="0"></a></td>
						<?php } else { ?>
							<td align="center">&nbsp;</td>
						<?php } ?>
					<?php } else {
						if(md5($prefix.$password_admin) == $mypass){
							if($openingpage == "true"){?>
								<a href="singlepage.php?html=frontpage.php" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/edit.gif" border="0"></a>
							<?php } ?>

						<?php }
					}?> 
				</td>
				<td align="right">
					<?php if ($section != ""){ ?>
						<a href="<?php echo $nextlink; ?>" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/next.gif" border="0"></a>
					<?php } else { print "&nbsp;"; }?>
				</td>
			<?php }
		} ?>
	</tr>
</table>
</body>
</html>