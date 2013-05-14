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
?>

<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title></title>
</head>
<body background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633">
<center>
	<script>
		function sorrymess(){
 			alert("<?php echo _BOOKYOUNOTHAVEACCESSTOTHECHAPTER; ?>");	
		}
	</script>
	<table width="100%">
		<?php
		$data = $mydatabase->select("SELECT * FROM ".$prefix."_contents Order by ordernum");
		$num = count($data);
		$i=0;
		$total = 0;
		while($i<$num){
			$myrow = $data[$i];
			$recno = $myrow['recno'];
			$name = $myrow['name'];
			$ordernum = $myrow['ordernum'];
			$formatpage = $myrow['formatpage'];
			$entriespage = $myrow['entriespage'];
			$page_c=-1;
			if($entriespage == "N"){ $page_c=1; }
			if($entriespage == "C"){ $page_c=0; }
			// get reference array
			$data3 = $mydatabase->select("SELECT * FROM ".$prefix."_words where contentsid='$recno' AND approved='Y' order by ordernum");
			$pages = count($data3);
			$l = -1;
			for($k=0;$k<$pages; $k++){
				$row = $data3[$k];
				$rec = $row['id'];
				$reference[$rec] = $k + 1;
				if( (($k+1)%2) == 1){
					$l = $l + 2;
					$reference2[$rec] = $l; 
				} else {
					$reference2[$rec] = $l;
				}
			}
			$data2 = $mydatabase->select("SELECT * FROM ".$prefix."_words where contentsid='$recno' AND (comment like '%$keyword%' OR title like '%$keyword%') AND approved='Y' order by ordernum");
			$pages = count($data2);
			if ($pages != 0){
				echo "<tr>";
				$page = $i + 1;
				echo "<td align=\"left\"><font size=\"+1\"> $ordernum ";
				if (has_access("R",$recno)){
					if($formatpage == 1){
						echo "<a href=\"singlepage.php?html=bookcontents.php&footer=1&section=$recno&page=$page_c\" target=\"_top\">$name</font></a>";
					} else {
						echo "<a href=\"index.php?section=$recno&page=$page_c\" target=\"_top\">$name</font></a>";
					}
					if(md5($prefix.$password_admin) == $mypass){ ?>
						<a href="singlepage.php?html=bookcontents.php&section=<?php echo $recno; ?>&page=-1&viewis=editmode" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/edit.gif" height="23" width="63" border="0"></a>
					<?php }
					for($j=0;$j< $pages; $j++){
						$rowis = $data2[$j];
						$rec = $rowis[id];
						if($formatpage == 1){
							echo "<br>::<a href=\"singlepage.php?html=bookcontents.php&footer=1&section=$recno&page=$reference[$rec]\" target=\"_top\">$rowis[title]</font></a>";
						} else {
							echo "<br>::<a href=\"index.php?section=$recno&page=$reference2[$rec]\" target=\"_top\">$rowis[title]</font></a>";
						}
					}
				} else {
					print "<a href=\"javascript:sorrymess()\"><font color=\"#AAAAAA\">$name</font></a>";
				}
				print "</td><td  align=right>$pages "._BOOKPAGES."</td></tr>";
			}
			$i++;
			$total = $total + $pages;
		}?>
		<tr>
			<td colspan="2" align="right">
				<hr>
				<?php echo _BOOKTOTALPAGES; ?>: <?php echo $total; ?> <?php echo _BOOKPAGES; ?>
			</td>
		</tr>
		<?php if(md5($prefix.$password_admin) == $mypass){ ?>
			<tr>
				<td colspan=3><a href="singlepage.php?html=addchapter.php" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/add.gif" height="23" width="65" border="0"><?php echo _BOOKNEWCHAPTER; ?></a>
				</td>
			</tr>
		<?php }?>
	</table>
	<br><br><a href="contents.php"><?php echo _BOOKCLICKHEREFOR;?><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/content.gif" border="0"></a><br><br><br>
	<script>
		function details(theURL,winName,features) {//v1.0 window.open(theURL,winName,features);}
	</script>
<!--
<a href=javascript:details('about.php','image374','scrollbars=yes,resizable=yes,width=590,height=420');>
<img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/about_web.gif" width=165 height=41 border=0></a>
<a href=javascript:details('http://craftysyntax.com/myscrapbook/about.htm','image373','scrollbars=yes,resizable=yes,width=590,height=420');>
<img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/about_pro.gif" width=165 height=41 border=0></a>
-->
	<br><br>
</center>
</body>
</html>
