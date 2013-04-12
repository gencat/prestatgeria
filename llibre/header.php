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

$next = $page + 1;
$back = $page - 1;
$current = $page;
$query = "SELECT * FROM ".$prefix."_contents WHERE recno='$section';";
$result = $mydatabase->select($query);
$top_r = $result[0];

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title></title>
	<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
</head>
<body background="themes/<?php echo $theme;?>/images/top_l.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">
<img src="themes/<?php echo $theme;?>/images/blank.gif" ><br>
<?php if ($openingpage == ""){ ?>
	<table width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td width="99%" nowrap style="padding-top:20px; ">
				<font color="#000000"><?php echo _BOOKCHAPTER;?>:</font>
				<font color="#000077"><i><b><?php echo $top_r['name']; ?></b></i></font>
			</td>
			<?php if ($current < 1) {
				$current = '<td width="1%" align="right" nowrap style="padding-top:20px; ">-</td>';
			}else {
				$current = '<td width="1%" align="right" NOWRAP style="padding-top:20px; "><font color="#000000">'._BOOKPAGE.' </font><font color="#000077"><b>'.$current.'</b></font></td>'; 
			}
			echo $current;
			?>
		</tr>
	</table>
	<hr>
<?php } ?>
</body>
</html>
