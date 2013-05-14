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

	$next =  $page + 1;
	$back =  $page - 1;
	$current = $page;
	$othercurrent = $current + 1;
	$displayedsomething = 0;

	$query = "SELECT * FROM ".$prefix."_words WHERE id='$id'";
	$result = $mydatabase->select($query);
	$myrow = $result[0];
?>
<HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<script>
		function confirma(){
			var conf = confirm('<?php echo _BOOKCONFIRMDELETE?>');
			if (conf) {
				document.editpage.what1.value = "<?php echo _BOOKDELETE;?>";
				document.editpage.submit();
			}
		}
	</script>		
	<?php if ($html_editor=='xinha'){?>	
		<script type="text/javascript">
			_editor_url  = "xinha/"  // (preferably absolute) URL (including trailing slash) where Xinha is installed
			_editor_lang = "<?php echo $lang;?>";      // And the language we need to use in the editor.
		</script>
		<script type="text/javascript" src="xinha/XinhaCore.js"></script>	
		<script language="javascript" type="text/javascript" src="xinha/supportXinha1.js"></script>
	<?php }else{?>
		<script language="javascript" type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
		<script language="javascript" type="text/javascript">
			tinyMCE.init({
				language : "<?php echo $lang;?>",
				mode : "textareas",
				theme : "advanced",
				content_css : "tinymce/jscripts/tiny_mce/themes/advanced/mycontent.css",
				plugins : "emotions,preview",
				theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,forecolor,backcolor,emotions,preview,fontselect",
				theme_advanced_buttons2 : "",
				theme_advanced_buttons3 : "",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_path_location : "bottom",
				extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"});
		</script>
	<?php  }?>
	<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
</head>

<body background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633">
	<center>
		<font color="#990000" size="+3"><strong><?php echo _BOOKEDITVALIDATEPAGE;?></strong></font><br><hr><br>
		<form name="editpage" action="editpage.php" method="post">
			<input type="hidden" name="recno" value="<?php echo $myrow['contentsid'];?>">
			<input type="hidden" name="what1" value="">			
			<strong><?php echo _BOOKCHAPTER;?>:</strong>
			<select name="contentsid">
				<?php
				$query = "SELECT * from ".$prefix."_contents";
				$data = $mydatabase->select($query);
				for($i=0;$i< count($data); $i++){
					$row = $data[$i];
					print "<option value=\"".$row['recno']."\" ";
					if($myrow['contentsid'] == $row['recno']){ print " selected "; }
					print ">".$row['name']."</option>\n";
				}
				?>
			</select>
  			<input type="hidden" name="idnum" value="<?php echo $myrow['id'];?>"><br>
			<strong><?php echo _BOOKITEMTITLE;?>:</strong>
			<input type="text" size="30" name="title" value="<?php echo $myrow['title'];?>" >
			<br>
			<table>
				<tr>
					<td colspan="2">
						<textarea rows="15" cols="60" name="comment" wrap="virtual" id="editbook"><?php echo $myrow['comment'];?> </textarea>
						<br>
						<font color="#000000"> 
							<?php echo _BOOKREQUIREDNAME;?>: 
							<input type="text" size="30" name="name" value="<?php echo $myrow['name'];?>">
						</font>
						<?php if($myrow['email'] != "") {?> <font color="#000077">(<?php echo $myrow['email'];?>)</font><?php } ?>
						<br>
						<?php if($myrow['webname'] != "none") {?> <a href="<?php echo $myrow['webaddress'];?>" target="other"><?php echo $myrow['webname'];?></a><?php } ?>
					</td>
				</tr>
				<tr>
					<td><input type="submit" name="what" value="<?php echo _BOOKVALIDATE;?>"></td>
					<td align="right"><input type="button" value="<?php echo _BOOKDELETE;?>" onclick="confirma();"></td>
				</tr>
			</table>
		</form>
	</center>
</body>
</html>
