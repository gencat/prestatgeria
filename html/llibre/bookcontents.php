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

	if((has_access("F",$section)) && ($whattodo == "reorderpages")){
		while (list($key, $val) = each($HTTP_POST_VARS)) {
			$array = split("__",$key);
			if($array[0] == "ordernum") {
				$query = "UPDATE ".$prefix."_words set ordernum='$val' WHERE id='$array[1]' ";
				$mydatabase->sql_query($query);
			}
		}
	}

	$next =  $page + 1;
	$back =  $page - 1;
	$current = $page;
	$othercurrent = $current + 1;
	$displayedsomething = 0;

	$query = "SELECT * FROM ".$prefix."_contents WHERE recno='$section'";
	$result = $mydatabase->select($query);
	$top_r = $result[0];
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title></title>
	<script  language="javascript" type="text/javascript">
		function confirma(){
			var conf = confirm('<?php echo _BOOKCONFIRMDELETE?>');
			if (conf) {
				document.editpage.what1.value = "<?php echo _BOOKDELETE;?>";
				document.editpage.submit();
			}
		}
		function edita(){
			document.editpage.what1.value = "<?php echo _BOOKUPDATE;?>";
			document.editpage.submit();
		}		
	</script>

	<?php if ($html_editor=='xinha' && $viewis =="editmode"){?>	
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
	<?php  }
	/* display open graphic */
	if ($current == -1){
		if($viewis =="editmode"){
			$query = "SELECT * FROM ".$prefix."_contents where recno='$section'";
			$data = $mydatabase->select($query);
			$data = $data[0];
	?>
	<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
</HEAD>
<body background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633">
<a href="index.php" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/back.gif" border="0"></a>
<center>
	<form action="updatechapter.php" method="post"  enctype="multipart/form-data">
		<input type="hidden" name="recno" value="<?php echo $data['recno'];?>">
		<input type="hidden" name="section" value="<?php echo $data['section'];?>">
		<input type="hidden" name="largeimage" value="<?php echo $data['openimage'];?>">
		<table>
			<tr>
				<td><strong><?php echo _BOOKCHAPTERNUMBER;?>:</strong></td>
				<td>
					<select name="ordernum">
					<?
						for($i=1;$i<41;$i++){
							print "<option value=$i ";
							if($data['ordernum'] == $i){print " selected ";}
							print ">$i</option>\n";}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td><strong><?php echo _BOOKCHAPTERNAME;?>:</strong></td>
				<td><input type="text" size="20" name="name" value="<?php echo $data['name']; ?>"></td>
			</tr>
			<tr>
				<td valign="top"><strong><?php echo _BOOKIMAGEOPTIONAL; ?>:</strong></td>
				<td>
					<?php
						if ($data['openimage'] != ""){
							print '<img src="'.$image_folder.'/'.$data[openimage].'"><br><i>'._BOOKUSEBOTTONTOCANGEIMAGE."<br></i>";
							print '<input type="checkbox" name="removephoto" value="YES"><font color="#990000">'._BOOKCHECKTOCHANGEIMAGE.'</font><br>';
						}
					?>
					<input type="file" size="35" name="myfile" ><br>
					<?php if (($Processor == "netpbm") || ($Processor == "ImageMagick")){ ?>
						<?php echo _BOOKIMAGESIZE; ?>:
						<select name="maxwidth">
							<option>500</option>
							<option>450</option>
							<option>400</option>
							<option>350</option>
							<option selected>300</option>
							<option>250</option>
							<option>200</option>
							<option>150</option>
							<option>100</option>
						</select> 
						<?php echo _BOOKWIDTH; ?>
					<?php } ?>
					(<?php echo _BOOKIMAGEMAXSIZE;?>)<br /><br />
				</td>
			</tr>
			<?php
				$no_ent = $yes_ent = "";
				if($data['entriespage'] == "Y"){$yes_ent = " selected ";}
				if($data['entriespage'] == "C"){$con_ent = " selected ";}
				if($data['entriespage'] == "N"){$no_ent = " selected ";}
			?>
			<tr>
				<td><strong><?php echo _BOOKINITTYPE;?>:</strong></td>
				<td>
					<select name="entriespage">
						<option value="Y" <?php echo $yes_ent;?>><?php echo _BOOBEGINENTRYPAGE; ?></option>
						<option value="C" <?php echo $con_ent;?>><?php echo _BOOBEGINCONTENTPAGE; ?></option>
						<option value="N" <?php echo $no_ent;?>><?php echo _BOOBEGINPAGEONE; ?></option>
					</select>
				</td>
			</tr>
			<?php
				$exp_ent = $no_ent = $yes_ent = "";
				if($data['formatpage'] == 2){$yes_ent = " selected "; }
				if($data['formatpage'] == 1){$no_ent = " selected "; }
				if($data['formatpage'] == 0){$exp_ent = " selected "; }
			?>
			<tr>
				<td><strong><?php echo _BOOKPAGESTYLE;?>:</strong></td>
				<td>
					<select name="formatpage">
						<option value="2" <?php echo $yes_ent;?>><?php echo _BOOKTWOPAGES;?></option>
						<option value="1" <?php echo $no_ent;?>><?php echo _BOOKONEPAGE; ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table>
						<?php
							$no_ent = $yes_ent = "";
							if($data['showname'] == "Y"){$showname_ent = " checked "; }
							if($data['showemail'] == "Y"){$showemail_ent = " checked "; }
							if($data['showurl'] == "Y"){$showurl_ent = " checked "; }
							if($data['showimage'] == "Y"){$showimage_ent = " checked "; }
						?>
						<tr>
							<td><strong><?php echo _BOOKUSERREQUIREDFIELDS;?>:</strong></td>
							<td><input type="checkbox" name="showname" value="Y" <?php echo $showname_ent; ?> ></td>
							<td><span class="Estilo10">- <?php echo _BOOKREQUIREDNAME;?></span></td>
							<td><input type="checkbox" name="showemail" value="Y" <?php echo $showemail_ent; ?> ></td>
							<td><span class="Estilo10">- <?php echo _BOOKREQUIREDMAIL;?></span></td>
							<td><input type="checkbox" name="showurl" value="Y" <?php echo $showurl_ent; ?> ></td>
							<td><span class="Estilo10">- <?php echo _BOOKREQUIREDURL;?></span></td>
							<td><input type="checkbox" name="showimage" value="Y" <?php echo $showimage_ent; ?> ></td>
							<td><span class="Estilo10">- <?php echo _BOOKREQUIREDUPLOADIMAGE;?></span></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><strong><?php echo _BOOKMAILTONOTIFYENTRIES; ?>:</strong></td>
				<td><input type="text" size="40" name="notifyemail" value="<?php echo $data['notifyemail']; ?>"></td>
			</tr>
			<tr>
				<td colspan=2>
					<strong><?php echo _BOOKINITMESSAGE; ?>:</strong><br>
					<textarea name="opentext" cols="55" rows="15" wrap="virtual" id="editbook"><?php echo $data['opentext']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="whattodo" value="<?php echo _BOOKUPDATE;?>">
			</tr>			
			<tr>
				<td colspan="2"><strong><?php echo _BOOKPERMS;?>:</strong><br>
					<?php
						// if a removeal was made
						if ($removeaccess != ""){
							$query = "DELETE FROM ".$prefix."_access WHERE recno='$removeaccess'";
							$mydatabase->sql_query($query);
						}
						$query = "SELECT * FROM ".$prefix."_access WHERE contentsid='$section'";
						$data_t = $mydatabase->select($query);
					?>
					<table border="1">
						<tr bgcolor="#DDDDDD">
							<td><?php echo _BOOKREQUIREDNAME;?></td>
							<td><?php echo _BOOKUSER;?></td>
							<td><?php echo _BOOKACCESS;?></td>
							<td><?php echo _BOOKACTIONS;?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><?php echo $myname;?></td>
							<td><?php echo _BOOKCOMPLETEACCES; ?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><font color="#000077"><?php echo _BOOKALL; ?></font>							
							</td>
							<td>
								<select name="permissions">
									<option value="none" <?php if($data['permissions']=='none'){echo ' selected ';} ?>><?php echo _BOOKNOTACCES;?></option>
									<option value="read" <?php if($data['permissions']=='read'){echo ' selected ';} ?>><?php echo _BOOKREADONLY;?></option>
									<option value="approval" <?php if($data['permissions']=='approval'){echo ' selected ';} ?>><?php echo _BOOKADDWITHAPROVAL;?></option>
									<option value="all" <?php if($data['permissions']=='all'){echo ' selected ';} ?>><?php echo _BOOKADDWITHOUTAPROVAL;?></option>
								</select>
							</td>
						</tr>
						<?php
							for($i=0;$i< count($data_t); $i++){
								$myrow = $data_t[$i];
								$query = "SELECT * FROM ".$prefix."_users where recno='$myrow[userid]'";
								$data_user = $mydatabase->select($query);
								$data_user = $data_user[0];
								print '<tr><td>'.$data_user['name'].'</td><td>'.$data_user['myusername'].'</td><td>';
								?>
								<select name="myaccess_<?php echo $myrow['recno']; ?>">
									<option value="R" <?php if ($myrow['myaccess'] == "R"){print " selected ";}?>><?php echo _BOOKREADONLY;?></option>
									<option value="A" <?php if ($myrow['myaccess'] == "A"){print " selected ";}?>><?php echo _BOOKADDWITHAPROVAL;?></option>
									<option value="m" <?php if ($myrow['myaccess'] == "m"){print " selected ";}?>><?php echo _BOOKADDWITHOUTAPROVAL;?></option>
									<option value="F" <?php if ($myrow['myaccess'] == "F"){print " selected ";}?>><?php echo _BOOKCOMPLETEACCES; ?></option>
								</select>
								<?php
								print '</td><td>[<font color="#990000"><a href="bookcontents.php?section=$section&page=-1&viewis=editmode&removeaccess='.$myrow['recno'].'">'._BOOKREMOVEACCESS.'</font>]</td></tr>';
							}
						?>
						<tr>
							<td colspan="4">
								<strong><?php echo _BOOKUSERSINDB;?>:</strong>
								<?php
									$query = "SELECT * FROM ".$prefix."_users order by myusername";
									$data_users = $mydatabase->select($query);
									if (count($data_users) != 0){?>
										<select name="adduser"><?php
											for($j=0;$j< count($data_users); $j++){
												$data_users_d = $data_users[$j];
												print '<option value="'.$data_users_d['recno'].'">'.$data_users_d['myusername'].': '.$data_users_d['name'].'</option>'."\n";
											}?>
										</select>
										<input type=submit value="<?php echo _BOOKGIVEACCESS; ?>" name="whattodo">
										<br>
									<?php } else {
										print "<i>"._BOOKCLICTOEDITUSERSLIST."</i>";
									}?>
								<hr><input type="submit" name="whattodo" value="<?php echo _BOOKUSEREDIT;?>">
								<input type="submit" name="whattodo" value="<?php echo _BOOKUPDATEPERMS; ?>">
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="50%">
					<input type="submit" name="whattodo" value="<?php echo _BOOKUPDATE; ?>">
				</td>
				<td width="50%">
					<input type="submit" name="whattodo" value="<?php echo _BOOKDELETE;?>">
				</td>
			</tr>
		</table>
	</form>	
	</center>
	<a href="index.php" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/back.gif" border="0"></a>

	<?php
	}else{?>
		</HEAD>
		<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
		<body bgcolor="#ffffff" background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633">
		<center>
			<?php
			if ($top_r[openimage] != "" && file_exists($image_folder_path.'/'.$top_r['openimage'])){ 
				$imagehw = GetImageSize($image_folder_path.'/'.$top_r['openimage']);
				$width = $imagehw[0];
				$height = $imagehw[1];
				if($width > 350){ $width=" width=\"350\" "; $mylink= '<br><a href="'.$image_folder.'/'.$top_r['openimage'].'" target="_blank">'._BOOKCLICKTOORIGINALSIZE."</a>";
				}else{
					$width= "";
				}
				print '<img src="'.$image_folder.'/'.$top_r['openimage'].'" '.$width.'>'.$mylink;
			}
			?>
		</center>
		<center>
			<table>
				<tr>
					<td>
						<?php echo $top_r['opentext']; ?>
					</td>
				</tr>
			</table><br><br><br>
			<font size="-2"><?php echo _BOOKPRODUCEDBY;?>: <a href="http://sourceforge.net/projects/myscrapbook" target="_blank">Myscrapbook <?php echo $version; ?></a></font>
		</center>
		<?php $displayedsomething = 1;
	}
}?>
</body>
</html>

<?php
/* display entries */
if ($current == 0){ ?>
<html>
<head>
	<title><?php print "$section"; ?></title>
	<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
</head>
<body background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633">
	<center>
		<?php echo _BOOKENTRIESIN;?><strong> <font color="#990000"><?php print $top_r['name']; ?></font></strong>:<br /><br />
		<?php if(has_access("F",$section)){ ?>
			<form action="bookcontents.php" method="post">
				<input type="hidden" name="whattodo" value="reorderpages">
				<input type="hidden" name="page" value="<?php echo $page; ?>" >
				<input type="hidden" name="section" value="<?php echo $section; ?>" >
				<?php } 
				$query = "SELECT formatpage FROM ".$prefix."_contents where recno='$section'";
				$data = $mydatabase->select($query);
				$data = $data[0];
				$formatpage = $data['formatpage'];
				$query = "SELECT * FROM ".$prefix."_words WHERE contentsid='$section' AND approved='Y' ORDER By ordernum";
				$result = $mydatabase->select($query);
				$num = count($result);
				$i=0;
				$counter = -1;
				$evenodd = 1;
				echo "<table>";
				while($i<$num){
					$result_row = $result[$i];
					$id = $result_row[id];
					$ordernum = $result_row['ordernum'];
					$title = $result_row['title'];
					$name = $result_row['name'];
					if (($evenodd % 2) == 1){$counter = $counter + 2;}
					if($formatpage != 2){
						echo '<tr><td valign="top">';
						if(has_access("F",$section)){
							print "<input type=\"text\" size=\"4\" name=\"ordernum__$id\" value=\"$ordernum\" > &nbsp;&nbsp;";
						}
						echo "<font color=\"#000000\">$evenodd</font>.</td><td><a href=singlepage.php?html=bookcontents.php&footer=1&section=$section&page=$evenodd target=_top>$title</a>";
						if($name!=''){echo "&nbsp;-&nbsp;$name<br></td></tr>";}
					} else {
						echo '<tr><td valign="top">';
						if(has_access("F",$section)){
							print "<input type=\"text\" size=\"5\" name=\"ordernum__$id\" value=\"$ordernum\" >&nbsp;&nbsp;";
						}
						echo "<font color=\"#000000\">$evenodd</font>.</td><td><a href=index.php?section=$section&page=$counter target=_top>$title</a>";
						if($name!=''){echo "&nbsp;-&nbsp;$name<br></td></tr>";}
					}
					$evenodd++;
					$i++;
				}
				echo "</table>";
				if(has_access("F",$section)){
					print "<font color='#990000'><br>"._BOOKAPPROVALARTICLES.":</font><br>";
					$query = "SELECT * FROM ".$prefix."_words WHERE contentsid='$section' AND approved='N' ORDER By ordernum";
					$result = $mydatabase->select($query);
					$num = count($result);
					$i=0;
					$counter = -1;
					$evenodd = 1;
					echo "<table>";
					while($i<$num){
						$result_row = $result[$i];
						$title = $result_row['title'];
						$name = $result_row['name'];
						$id = $result_row['id'];
						if (($evenodd % 2) == 1){  $counter = $counter + 2; }?>
							<tr bgcolor="#DDDDDD">
								<td valign="top"><font color="#000000"><?php echo $evenodd;?></font>.</td>
								<td><a href="singlepage.php?html=unapproved.php&id=<?php echo $id;?>" target="_top"><?php echo $title;?></a><?php if($name !=''){ ?> - <?php echo $name;?><br><?php }?></td>
							</tr>
						<?php
						$evenodd++;
						$i++;
					}
					echo "</table>";
				}
				if(has_access("F",$section)){
					print "<input type='submit' value=\""._BOOKORDERPAGES."\">";
				}
				print "</body></html>";?>
				<?php }
				/* display info */
				if ($current > 0){ ?>
					<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
					<body background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633">
					<center>
					<?php 
						$query = "SELECT * FROM ".$prefix."_words WHERE contentsid='$section' AND approved='Y' ORDER By ordernum";
						$result = $mydatabase->select($query);
						$num = count($result);
						if ($num < $current ){
							$name = "";
							$title = "";
							$email = "";
							$webaddress = "";
							$query = "SELECT formatpage FROM ".$prefix."_contents where recno='$section'";
							$data = $mydatabase->select($query);
							$data = $data[0];
							$formatpage = $data['formatpage'];
							if ($formatpage == 1){
								$comment = "<script>window.location.replace(\"contents.php\");</script> <a href=\"contents.php\">"._BOOKDOCLIC."</a>";
							}else{
								if(($current % 2) == 1){
									$comment = "<SCRIPT>window.location.replace(\"contents.php\");</SCRIPT> <a href=contents.php>"._BOOKDOCLIC."</a>";
								}
							}
						} else {
							$result_row = $result[$back];
							$ordernum = $result_row['ordernum'];
							$name = $result_row['name'];
							$title = $result_row['title'];
							$email = $result_row['email'];
							$webaddress = $result_row['webaddress'];
							$webname = $result_row['webname'];
							$id = $result_row['id'];
							$comment = $result_row['comment'];
							$contentsid = $result_row['contentsid'];
							$myimage = $result_row['myimage'];
						}
						if ($viewis == "editmode"){?>
							<font color="#990000" size="+1"><strong><?php echo _BOOKEDITPAGE;?>:</strong></font><br><hr><br>
							<form name="editpage" action="editpage.php" method="post"  ENCTYPE="multipart/form-data">
							<input type="hidden" name="recno" value="<?php echo $section;?>">
							<input type="hidden" name="what1" value="">
							
							<strong><?php echo _BOOKCHAPTER;?>:</strong>
							<select name="contentsid">
							<?php
							$query = "SELECT * from ".$prefix."_contents";
							$data = $mydatabase->select($query);
							for($i=0;$i< count($data); $i++){
								$row = $data[$i];
								print "<option value=\"$row[recno]\" ";
								if($contentsid == $row[recno]){ print " selected "; }
								print ">$row[name]</option>\n";
							}
							print "</select><input type=\"hidden\" name=\"idnum\" value=\"$id\"><br>";
						}
						if ($viewis == "editmode"){
							print "<br><strong>"._BOOKITEMTITLE.":</strong> <input type=\"text\" size=\"30\" name=\"title\" value=\"$title\" >";
						}else{
							?> 
							<center><strong><?php echo $title; ?></strong>
								<?php
								
								if ($myimage != "" && file_exists($image_folder_path . '/'.$top_r['openimage'])){
									$imagehw = GetImageSize($image_folder_path.'/'.$myimage);
									$width = $imagehw[0];
									$height = $imagehw[1];
									if($width > 350){
										$width=" width=\"350\" ";
										$mylink= '<br><a href="'.$image_folder.'/'.$myimage.'" target="_blank">'._BOOKCLICKTOORIGINALSIZE.'</a>';
									}else{
										$width= "";
									}
									print '<br /><br /><img src="'.$image_folder.'/'.$myimage.'" '.$width.'>'.$mylink.'</center>';
								}?>
						<?php } ?>
						<br>
						<?php
						if ($viewis == "editmode"){?>
							<br />
							<textarea rows="15" cols="60" name="comment" wrap="virtual" id="editbook"><?php echo $comment;?></textarea>
							<br><input type="submit" name="what" value="<?php echo _BOOKUPDATE;?>">
							<?php
						} else {
							echo "<table><tr><td>$comment</td></tr></table>";
						} ?>
						<br>
						
						
						<font color="#000000">
						<?php
						if ($viewis == "editmode"){
							if ($myimage != ""){
								print '<br><img src="'.$image_folder.'/'.$myimage.'"><br><i>'._BOOKUSEBOTTONTOCANGEIMAGE.'<br></i><br>';
								print '<input type="checkbox" name="removephoto" value="YES"><font color="#990000">'._BOOKCHECKTOCHANGEIMAGE.'</font><br><br>';
							}
							echo '<table><tr><td>'._BOOKIMAGE.':</td><td><input type="file" size="30" name="myimage" >';
							if (($Processor == "netpbm") || ($Processor == "ImageMagick")){
								echo _BOOKIMAGESIZE;?>
								<select name="maxwidth">
									<option>500</option>
									<option>450</option>
									<option>400</option>
									<option>350</option>
									<option selected>300</option>
									<option>250</option>
									<option>200</option>
									<option>150</option>
									<option>100</option>
								</select>
								<?php echo _BOOKWIDTH;?>:
							<?}?>
							<br>
							<?php 
							echo '<tr><td>'._BOOKREQUIREDNAME.":</td><td><input type=\"text\" size=\"30\" name=\"name\" value=\"$name\" ><td></tr>";
						}else{
							echo $name;
						}
						if ($viewis == "editmode"){
							print '<tr><td>'._BOOKREQUIREDMAIL.":</td><td><input type=\"text\" size=\"30\" name=\"email\" value=\"$email\"></td></tr>";
							print '<tr><td>'._BOOKREQUIREDURL.":</td><td><input type=\"text\" size=\"30\" name=\"webaddress\" value=\"$webaddress\"></td></tr>";
							print '<tr><td>'._BOOKURLNAME.":</td><td><input type=\"text\" size=\"30\" name=\"webname\" value=\"$webname\"></td></tr>";
						}else{
							if ($email != "") { echo '<font color="#000077">&nbsp;('.$email.')</font><br>'; }
							if ($webname != "none") { echo "<a href=\"$webaddress\" target=\"other\">$webname</a>";
						} 
					}?>
					</p>
					<?php
					if ($viewis == "editmode"){
						print '<center><table width="50%"><tr><td><input type="button" value='._BOOKUPDATE.' onclick="edita();"></td><td><input type="button" value="'._BOOKDELETE.'" onclick="confirma();"></td></tr></table></center>';
					}?>
				<?php } ?>
