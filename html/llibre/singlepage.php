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
	Header("Location: setup.php");
	exit;
}

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title><?php echo stripslashes($site_title); ?></title>
</head>

<?php
if($page == ""){ $page = 2; }
if ($page % 2 == 0){
if ($footer == ""){
?>
<frameset rows="27,*,29" border="0" frameborder="0" framespacing="0" spacing="0">
<?php } else { ?>
<frameset rows="27,*,65" border="0" frameborder="0" framespacing="0" spacing="0">
<?php } ?>
  <frameset cols="61,*,70" border="0" frameborder="0" framespacing="0" spacing="0">
    <frame src="themes/<?php echo $theme;?>/1c.html" name="1c" scrolling="no" border="0" marginheight="0" marginwidth="0">
    <frame src="themes/<?php echo $theme;?>/1d.html" name="1d" scrolling="no" border="0" marginheight="0" marginwidth="0">
    <frame src="themes/<?php echo $theme;?>/1e.html" name="1e" scrolling="no" border="0" marginheight="0" marginwidth="0">
  </frameset>

  <frameset cols="61,*,70" border="0" frameborder="0" framespacing="0" spacing="0">
   <frame src="themes/<?php echo $theme;?>/mid.html" name="ac" scrolling="no" border="0" marginheight="0" marginwidth="0">
   <frame src="<?php echo $html;?>?action=<?php echo $action;?>&section=<?php echo $section; ?>&page=<?php echo $page; ?>&viewis=<?php echo $viewis; ?>&id=<?php echo $id ?>" name="ad" scrolling="auto" border="0" marginheight="0" marginwidth="0">
    <frame src="themes/<?php echo $theme;?>/wordsright.html" name="ae" scrolling="no" border="0" marginheight="0" marginwidth="0">
  </frameset>
  <frameset cols="61,*,70" border="0" frameborder="0" framespacing="0" spacing="0">
<?php if ($footer == ""){ ?>  
    <frame src="themes/<?php echo $theme;?>/2k.html" name="2c" scrolling="no" border="0" marginheight="0" marginwidth="0">
    <frame src="themes/<?php echo $theme;?>/2h.html" name="2d" scrolling="no" border="0" marginheight="0" marginwidth="0">
    <frame src="themes/<?php echo $theme;?>/2i.html" name="2e" scrolling="no" border="0" marginheight="0" marginwidth="0">
<?php } else { ?>
    <frame src="themes/<?php echo $theme;?>/2c.html" name="2c" scrolling="no" border="0" marginheight="0" marginwidth="0">
    <frame src="footer.php?section=<?php echo $section; ?>&page=<?php echo $page; ?>&openingpage=<?php echo $openingpage;?>&contentspage=<?php echo $contentspage; ?>" name="2d" scrolling="no" border="0" marginheight="0" marginwidth="0">
    <frame src="themes/<?php echo $theme;?>/2e.html" name="2e" scrolling="no" border="0" marginheight="0" marginwidth="0">
<?php } ?>
  </frameset>

</frameset><noframes></noframes>
<?php } else { 
if ($footer == ""){
?>
<frameset rows="27,*,29" border="0" frameborder="0" framespacing="0" spacing="0">
<?php } else { ?>
<frameset rows="27,*,65" border="0" frameborder="0" framespacing="0" spacing="0">
<?php } ?>
  <frameset cols="58,*,61" border="0" frameborder="0" framespacing="0" spacing="0">
    <frame src="themes/<?php echo $theme;?>/1f.html" name="1a" scrolling="no" border="0" marginheight="0" marginwidth="0">
    <frame src="themes/<?php echo $theme;?>/1b.html" name="1b" scrolling="no" border="0" marginheight="0" marginwidth="0">
    <frame src="themes/<?php echo $theme;?>/1c.html" name="1c" scrolling="no" border="0" marginheight="0" marginwidth="0">
  </frameset>

  <frameset cols="58,*,61" border="0" frameborder="0" framespacing="0" spacing="0">
    <frame src="themes/<?php echo $theme;?>/wordsleft2.html" name="aa" scrolling="no" border="0" marginheight="0" marginwidth="0">
   <frame src="<?php echo $html;?>?action=<?php echo $action; ?>&section=<?php echo $section; ?>&page=<?php echo $page; ?>&viewis=<?php echo $viewis; ?>&id=<?php echo $id; ?>" name="ad" scrolling="AUTO" border="0" marginheight="0" marginwidth="0">
    <frame src="themes/<?php echo $theme;?>/mid.html" name="ac" scrolling="no" border="0" marginheight="0" marginwidth="0">
 </frameset>

  <frameset cols="58,*,61" border="0" frameborder="0" framespacing="0" spacing="0">
<?php if ($footer == ""){ ?>    
    <frame src="themes/<?php echo $theme;?>/2j.html" name="2a" scrolling="no" border="0" marginheight="0" marginwidth="0">
    <frame src="themes/<?php echo $theme;?>/2h.html" name="2b" scrolling="no" border="0" marginheight="0" marginwidth="0">
    <frame src="themes/<?php echo $theme;?>/2k.html" name="2c" scrolling="no" border="0" marginheight="0" marginwidth="0">
    <?php } else { ?>
    <frame src="themes/<?php echo $theme;?>/2f.html" name="2a" scrolling="no" border="0" marginheight="0" marginwidth="0">
    <frame src="footer.php?section=<?php echo $section;?>&page=<?php echo $page;?>&openingpage=<?php echo $openingpage; ?>&contentspage=<?php echo $contentspage; ?>" name="2b" scrolling="no" border="0" marginheight="0" marginwidth="0">
    <frame src="themes/<?php echo $theme;?>/2c.html" name="2c" scrolling="no" border="0" marginheight="0" marginwidth="0">
    <?php } ?>
  </frameset>
</frameset>
<?php } ?>