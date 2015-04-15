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

if ($installed == false){
	header("Location: setup.php");
	exit;
}

// default frames
$lefttop = 'themes/'.$theme.'/1f.html';
$leftbot = 'themes/'.$theme.'/2f.html';
$leftmid = 'themes/'.$theme.'/wordsleft2.html';    
$rightframe = $leftframe = 'bookcontents.php';


// frames 
if(!isset($page) || ($page == '')) {
	$openingpage = "true";
	$leftframe = "open1.php";
	$lefttop = 'themes/'.$theme.'/1a.html';
	$leftbot = 'themes/'.$theme.'/2a.html';
	$leftmid = 'themes/'.$theme.'/wordsleft.html';
	$contentspage = "true";
	$rightframe = "contents.php";
} else {
	$page2 = $page + 1;
}
/*
if($page == "-1"){
	$rightframe = "unapproved.php";
}
*/

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<title><?php echo stripslashes($site_title); ?></title>
</head>
<frameset rows="63,*,65" border="0" frameborder="0" framespacing="0" spacing="0">

  <frameset cols="58,*,61,*,70" border="0" frameborder="0" framespacing="0" spacing="0">
    <frame src="<?php echo $lefttop; ?>" name="1a" scrolling="no" border="0" marginheight="0" marginwidth="0" NORESIZE>
    <frame src="header.php?openingpage=<?php echo $openingpage ?>&section=<?php echo $section;?>&page=<?php echo $page;?>&username=<?php echo $username;?>" name="1b" scrolling="no" border="0" marginheight="0" marginwidth="0" NORESIZE>
    <frame src="themes/<?php echo $theme;?>/1c.html" name="1c" scrolling="no" border="0" marginheight="0" marginwidth="0" NORESIZE>
    <frame src="header.php?openingpage=<?php echo $openingpage ?>&section=<?php echo $section;?>&page=<?php echo $page2;?>&username=<?php echo $username;?>" name="1d" scrolling="no" border="0" marginheight="0" marginwidth="0" NORESIZE>
    <frame src="themes/<?php echo $theme;?>/1e.html" name="1e" scrolling="no" border="0" marginheight="0" marginwidth="0" NORESIZE>
  </frameset>

  <frameset cols="58,*,61,*,70" border="0" frameborder="0" framespacing="0" spacing="0" NORESIZE>
    <frame src="<?php echo $leftmid;?>" name="aa" scrolling="no" border="0" marginheight="0" marginwidth="0" NORESIZE>    
    <frame src="<?php echo $leftframe;?>?page=<?php echo $page;?>&section=<?php echo $section; ?>&viewis=<?php echo $viewis; ?>&username=<?php echo $username;?>" name="1b" scrolling="auto" border="0" marginheight="0" marginwidth="0">
    <frame src="themes/<?php echo $theme;?>/mid.html" name="ac" scrolling="no" border="0" marginheight="0" marginwidth="0" NORESIZE>
    <frame src="<?php echo $rightframe;?>?page=<?php echo $page2;?>&section=<?php echo $section; ?>&viewis=<?php echo $viewis; ?>&username=<?php echo $username;?>" name="rightcontent" scrolling="auto" border="0" marginheight="0" marginwidth="0">
    <frame src="themes/<?php echo $theme;?>/wordsright.html" name="ae" scrolling="no" border="0" marginheight="0" marginwidth="0" NORESIZE>
  </frameset>

  <frameset cols="58,*,61,*,70" border="0" frameborder="0" framespacing="0" spacing="0" NORESIZE>
    <frame src="<?php echo $leftbot;?>" name="2a" scrolling="no" border="0" marginheight="0" marginwidth="0" NORESIZE>
    <frame src="footer.php?section=<?php echo $section;?>&page=<?php echo $page;?>&openingpage=<?php echo $openingpage;?>&contentspage=<?php echo $contentspage; ?>" name="2b" scrolling="no" border="0" marginheight="0" marginwidth="0" NORESIZE>
    <frame src="themes/<?php echo $theme;?>/2c.html" name="2c" scrolling="no" border="0" marginheight="0" marginwidth="0" NORESIZE>
    <frame src="footer.php?section=<?php echo $section;?>&page=<?php echo $page2;?>&openingpage=<?php echo $openingpage;?>&contentspage=<?php echo $contentspage; ?>" name="2b" scrolling="no" border="0" marginheight="0" marginwidth="0" NORESIZE>
    <frame src="themes/<?php echo $theme;?>/2e.html" name="2e" scrolling="no" border="0" marginheight="0" marginwidth="0" NORESIZE>
  </frameset>

</frameset><noframes></noframes>
</body>
</html>
