<?php
	require "config.php";
	//Select the file with the lang strings
	include("lang/".$lang.'.php');
?>
<HTML>
<HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
   <TITLE></TITLE>
 <link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
</HEAD>
<body bgcolor="#000000" background="themes/<?php echo $theme;?>/images/bkbook.gif" text="#664411" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" >
<center>


<center>
  <h1><?php echo _BOOKTHANKYOU; ?></h1>
</center>
<hr>
<div align="center">
<?php if ($approved == "Y"){?>
	<?php echo _BOOKHASBEENAPROVED;?>
	<br>
	<br>
<?php } else {?>
	<?php echo _BOOKNEEDAPROVAL;?>
	<br>
	<br>
<?php } ?>
<br>
<br>
<a href="index.php?section=<?php echo $section; ?>&page=-1" target="_top"><?php echo _BOOKCLICKHERETORETURN;?></a>
</div>
</BODY>
</HTML>
