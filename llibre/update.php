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

if($version>=$actual_version){
	print 'NO SE PUEDE ACTUALIZAR';
	exit;
}
//Init update proces
//Create fields in table config of data base
//$theme
//$lang
//$image_folder

//Include records in data base
//$theme -> Can be choosed
//$lang -> Can be choosed
//$image_folder -> userimages

//Writte the config file
//$prefix = "INPUT-PREFIX";


?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>
</title>
<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
</head>
<body background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633">
	<center>
		Formulario de actualitzaci�n
	</center>
</body>
</html>
</html>

