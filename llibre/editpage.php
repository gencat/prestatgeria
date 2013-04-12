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
include("lang/".$lang.'.php');

if(has_access("F",$contentsid)){


if ($what == _BOOKDELETE || $what1 == _BOOKDELETE){
	//Select contents from data base
	$query = "SELECT * FROM ".$prefix."_words where id='$idnum' ";
	$data1 = $mydatabase->select($query);
	$data1 = $data1[0];
	
	//Remove image if exists
	if($data1['myimage'] != ""){
		unlink($image_folder_path.'/'.$data1['myimage']);
	}
	
	//Delete record from data base
	$query = "DELETE FROM ".$prefix."_words where id='$idnum' ";
	$mydatabase->sql_query($query);
	print _BOOKTHEPAGEHSBEENREMOVED;
	//XTEC MULTIBOOKS
        include('../config/config_books.php');
		include_once('../config/xtecAPI.php');
		$book=explode('_',$prefix);
       	//get schoolId
	    $school = getSchool($book[0]);
	    //Calc the database from school identity
	    $num = floor($school/50) + 1;
        $database .= $num;
		updateBookPages($prefix, $database);
	//XTEC END
	?>
	<br>
	<script>   
		function gothere(){
			window.parent.location.replace("index.php?section=<?php echo $recno; ?>&page=-1");
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
	<br /><a href="index.php?section=<?php echo $recno;?>&page=-1" target="_top"><?php echo _BOOKCLICHEREIFESTILREADING;?></a><br><br><br>
	</body>
	</html>
	<?php
	exit;
}

if (($what == _BOOKUPDATE) || ($what == _BOOKVALIDATE) || ($what1 == _BOOKUPDATE) || ($what1 == _BOOKVALIDATE)){   
	$query = "SELECT * FROM ".$prefix."_words where id='$idnum' ";
	$data1 = $mydatabase->select($query);
	$data1 = $data1[0];

	if($removephoto == "YES"){
		unlink($image_folder_path.'/'.$data1['myimage']);
		$image_tan = ",myimage=''";
	}
	if (($myimage != "") && ($myimage != "none")){
		// get rid of old image
		if( ($removephoto == "") && ($data1[myimage] != "")){
			unlink($image_folder_path.'/'.$data1['myimage']);
		}

		// get a good image name
		$imagename = uniqueimagename();
		if (function_exists('move_uploaded_file')) {
			move_uploaded_file($myimage,$image_folder_path.'/'.$imagename);
		} else {
			copy($myimage,$image_folder_path.'/'.$imagename);
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
		chmod($image_folder_path.'/'.$largeimage, 0775);
		$image_tan = ",myimage='$largeimage'";
		// convert image for netpbm
		$dirpath = $application_root.$image_folder_path;
		if ($Processor == "netpbm"){
			$nextpath = "$dirpath/$largeimage" . "_2.pnm";
			if($ext == ".jpg"){
				system("$imagemagic/jpegtopnm --quiet $dirpath/$largeimage > $dirpath/$imagename.pnm");
			}
			if($ext == ".gif"){
				system("$imagemagic/giftopnm --quiet $dirpath/$largeimage > $dirpath/$imagename.pnm");
			}
			chmod("$dirpath/$imagename.pnm", 0777);
		}	  
  
		// fix the big image if it is too big
		if($maxwidth == ""){ $maxwidth = 300; }
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
		$query = "update ".$prefix."_words set email='$email',webaddress='$webaddress',webname='$webname',approved='Y',contentsid='$contentsid',name='$name',comment='$comment',title='$title' $image_tan where id='$idnum' "; 
	} else {
		$query = "update ".$prefix."_words set email='$email',webaddress='$webaddress',webname='" . addslashes($webname) . "',approved='Y',contentsid='$contentsid',name='" . addslashes($name) . "',comment='" . addslashes($comment) . "',title='" . addslashes($title) . "' $image_tan where id='$idnum' ";
	}
	$mydatabase->sql_query($query);
	print _BOOKPAGEUPDATEDRELOAD;
    //XTEC MULTIBOOKS
        include('../config/config_books.php');
		include_once('../config/xtecAPI.php');
		$book=explode('_',$prefix);
        //$editLastEntryBook = editLastEntryBook($book[0]);
       	//get schoolId
	    $school = getSchool($book[0]);
	    //Calc the database from school identity
	    $num = floor($school/50) + 1;
        $database .= $num;
		updateBookPages($prefix, $database);
	//XTEC END
?>
	<br>
	<script>
		function gothere(){
			window.parent.location.replace('index.php?section=<?php echo $recno; ?>&page=-1');
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
} else {
	print _BOOKACCESSDENAIED;
}
?>
