<?php
	require "config.php";
	//Select the file with the lang strings
	include("lang/".$lang.'.php');
	$query = "SELECT * from ".$prefix."_config ";
	$data = $mydatabase->select($query);
	$row = $data[0];
	if($version<$actual_version){
		header('location:update.php');
		exit;
	}
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title><?php echo stripslashes($site_title); ?></title>
</head>
<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
<body background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633">
	<center>
		<?php
		if ($row['openimage'] != "" && file_exists($image_folder_path.'/'.$row['openimage'])){
			$imagehw = GetImageSize($image_folder_path.'/'.$row['openimage']);
			$width = $imagehw[0];
			$height = $imagehw[1];
			$mylink= "";
			if($width > 350){
				$width=" width=\"350\" "; $mylink= '<br><a href="'.$image_folder.'/'.$top_r['openimage'].'" target="_blank">'._BOOKCLICKTOORIGINALSIZE."</a>";
			}else{
				$width= "";
			}
			print '<br><img src="'.$image_folder.'/'.$row['openimage'].'" '.$width.'>'.$mylink;
		}
		?>
		<?php echo stripslashes($row['opentext']); ?>
		<?php
		if ($searchbox == "YES"){
		?>
			<form action="search.php" method="post" target="rightcontent">
				<input type="hidden" name="action" value="search">
				<strong><?php echo _BOOKSEARCHINTHISBOOK;?>:</strong>
				<input type="text" size="14" name="keyword">
				<input type="submit" value=<?php echo _BOOKSEARCH; ?>>
				<br>
			</form>
		<?php }else{?>
		<br />
		<?php }?>
		<font size="-2"><?php echo _BOOKPRODUCEDBY;?>: <a href="http://sourceforge.net/projects/myscrapbook" target="_blank">Myscrapbook <?php echo $version; ?></a></font>
	</center>
</body>
</html>
