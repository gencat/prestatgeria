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
if (!isset($mypass)) {
    $mypass = '';
}
if( (md5($prefix.$password_admin) == $mypass) && ($whattodo == "reorderchapters")){
    while (list($key, $val) = each($_POST)) {
        $array = explode('__', $key);
		if($array[0] == "ordernum") {
			$query = "UPDATE ".$prefix."_contents set ordernum='$val' WHERE recno='$array[1]' ";
			$mydatabase->sql_query($query);
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />
	<title></title>
    <link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
</head>
<body background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633">
	<center>
		<table width="100%">	
		<?php if(md5($prefix.$password_admin) == $mypass){ ?> 
			<form action="contents.php" method="post">
			<input type="hidden" name="whattodo" value="reorderchapters">
			<input type="hidden" name="page" value="<?php echo $page; ?>" >
			<input type="hidden" name="section" value="<?php echo $section; ?>" >
		<?php }?>
		<script>
			function sorrymess(){
				alert("<?php echo _BOOKNOTHAVEACCESS;?>");
			}
		</script>
			<?php
				$data = $mydatabase->select("SELECT * FROM ".$prefix."_contents order by ordernum");
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
					if($entriespage == "N"){ $page_c=1;  }
					if($entriespage == "C"){ $page_c=0;  }
					echo "<tr>";
					$page = $i + 1;
					echo '<td align="left" valign="top">';
					$data2 = $mydatabase->select("SELECT * FROM ".$prefix."_words where contentsid='$recno' AND approved='Y' ");
					$pages = count($data2);
					if(md5($prefix.$password_admin) == $mypass){
						print "<input type=\"text\" size=\"4\" name=\"ordernum__$recno\" value=\"$ordernum\">\n";
					}else {
						print $ordernum; }
					if (has_access("R",$recno)){
						if($formatpage == 1){
							echo "&nbsp;<a href=\"singlepage.php?html=bookcontents.php&footer=1&section=$recno&page=$page_c\" target=\"_top\">".$name."</a>";
						}else{
							echo "&nbsp;<a href=\"index.php?section=$recno&page=$page_c\" target=\"_top\">".$name."</a>";
						}
						 if(md5($prefix.$password_admin) == $mypass){ ?>
							<a href="singlepage.php?html=bookcontents.php&section=<?php echo $recno;?>&page=-1&viewis=editmode" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/edit.gif" border="0"></a>
						<?php }
					} else {
						print '&nbsp;<a href="javascript:sorrymess()"><font color="#AAAAAA">'.$name.'</font></a>';
					}
					print '</td><td  align="right" width="80" valign="top">'.$pages.' '._BOOKPAGENUMBER.'</td></tr>';
					$i++;
					$total = $total + $pages;
				}
			?>
			<tr>
				<td colspan="2" align="right">
					<hr>
					<?php echo _BOOKTOTALPAGES;?>: <?php echo $total.' '._BOOKPAGENUMBER; ?>
				</td>
			</tr>
			<?php if(md5($prefix.$password_admin) == $mypass){ ?>
				<tr>
					<td colspan="3">
						<a href="singlepage.php?html=addchapter.php" target="_top"><?php echo _BOOKNEWCHAPTER;?></a><br><br>
						<input type="submit" value="<?php echo _BOOKORDERCHAPTERS;?>">
					</td>
				</tr>
			<?php } ?>
		</table>
<br><br><br><br><br>
<script>
function details(theURL,winName,features) {
	//v1.0
	window.open(theURL,winName,features);
}
</script>

<!--
<a href=javascript:details('about.php','image374','scrollbars=yes,resizable=yes,width=590,height=420');>
<img src=images/about_web.gif width=165 height=41 border=0></a>
<a href=javascript:details('http://craftysyntax.com/myscrapbook/about.htm','image373','scrollbars=yes,resizable=yes,width=590,height=420');>
<img src=images/about_pro.gif width=165 height=41 border=0></a>
-->

<br><br>
</body>
</html>
