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
?>
<body bgcolor="#000000" background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" >
<br><br>
<center>
	<form action="permissions.php" method="post">
		<input type="hidden" name="action" value="updates">
			<?php
			function showpaging(){
				global $mydatabase,$perpage,$top,$total_p,$projectid;
				$maxout = 10;
				$diff = ($top % $perpage);
				$page = ($top- $diff)/$perpage + 1;
				$start = (($page - ($page % $maxout))/$maxout ) * $maxout;
				$counting = ($start * $perpage) - $perpage;
				if (($total_p % $perpage) == 0){ $diff = 0; } else { $diff = 1; }
				$total = ($total_p  - ($total_p % $perpage))/$perpage + $diff;
				print '<table width="620">';
				print '<tr bgcolor="#FFFFCC">';
				if ($page != 1){
					$previous = (($page - 2) * $perpage) ;
					print "<td width=\"1%\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td><a href=\"index.php?top=$previous\"><img src=\"../images/back_s.gif\" border=\"0\"></a></td><td><strong><a href=\"index.php?top=$previous&whattodo=slide&projectid=$projectid\">"._BOOKPREVIOUS."</strong></a></td></tr></table></td>";
				} else {
					print "<td width=\"1%\">.</td>";
				}
				print '<td width="98%" align="center">';
				print "<font size=-1>"._BOOKPAGE." <strong><font color=007700>$page</font></strong> of <strong><font color=000077>$total</font></strong> :</font> ";
				$count = 1;
				$back =  $counting - $perpage;
				if ($back >= 0 ){print "<a href=index.php?top=$back&whattodo=slide&projectid=$projectid>"._BOOLASTTEN." </a> <font size=+1>|</font> ";}
				for($i = $start; $i <= $total; $i++){
					if ($page == $i){
						print " <strong>$i</strong> <font size=+1>|</font> ";
					} else {
						if($i != 0){
							print " <a href=index.php?top=$counting&whattodo=slide&projectid=$projectid>$i</a> <font size=+1>|</font> ";
						}
					}
					if ($count > 9){
						$counting = $counting + $perpage;
						print " <a href=index.php?top=$counting&whattodo=slide&projectid=$projectid>"._BOOKNEXTTEN." </a>  ";
						$i = $total;
					}
					$count++;
					$counting = $counting + $perpage;
				}
				print "</td>";
				if ($page < $total){
					$nextpage = ($page * $perpage) ;
					print "<td width=1%><table cellpadding=0 cellspacing=0 border=0><tr><td><strong><a href=index.php?top=$nextpage&whattodo=slide&projectid=$projectid>"._BOOKNEXT."</strong></a></td><td><a href=index.php?top=$nextpage&whattodo=slide&projectid=$projectid><img src=../images/next_s.gif border=0></a></td></tr></table></td>";
				} else {
					print '<td width="1%"><strong>.</strong></td>';
				}
				print "</tr></table>";
			}
			if(md5($prefix.$password_admin) != $mypass){
				print _BOOKACCESSDENAIED;
			} else {
				$query = "SELECT * FROM ".$prefix."_users order by name ";
				$data = $mydatabase->select($query);?>
				<table width="450">
					<tr>
						<td><?php echo _BOOKIFHAVEDEPENTS;?></td>
					</tr>
				</table>
				<table border="1">
					<tr bgcolor="#DDDDDD">
						<td><?php echo _BOOKNAMEUSERNAME; ?></td>
						<td><?php echo _BOOKACCESS;?></td>
					</tr>
					<tr>
						<td><?php echo _BOOKADMIN;?>: </td>
						<td><?php echo _BOOKCOMPLETEACCES;?></td>
					</tr>
					<tr>
						<td><?php echo _BOOKEVERYONE;?>: </td>
						<td>
							<select name="everyone">
								<option value="N"><?php echo _BOOKNOTACCES;?></option>
								<option value="R"><?php echo _BOOKREADONLY;?></option>
								<option value="A"><?php echo _BOOKADDWITHAPROVAL;?></option>
								<option value="m"><?php echo _BOOKADDWITHOUTAPROVAL;?></option>
								<option value="F"><?php echo _BOOKCOMPLETEACCES;?></option>
							</select>
						</td>
					</tr>
					<?php for($i=0;$i< count($data); $i++){
						$myrow = $data[$i];
						print '<tr><td>'.$myrow['name'].' '.$myrow['myusername'].'</td><td>';
						$query = "SELECT * FROM ".$prefix."_access where userid='$myrow[recno]'";
						$data_user = $mydatabase->select($query);
						$data_user = $data_user[0];
						?>
						<select name="access_<?php echo $myrow['recno']; ?>">
							<option value="N" <?php if (($data_user['myaccess'] == "") || ($data_user['myaccess'] == "N")){print " selected "; } ?>><?php echo _BOOKNOTACCES;?></option>
							<option value="R" <?php if($data_user['myaccess'] == "N"){print " selected ";} ?>><?php echo _BOOKREADONLY;?></option>
							<option value="A" <?php if($data_user['myaccess'] == "N"){print " selected ";} ?>><?php echo _BOOKADDWITHAPROVAL;?></option>
							<option value="m" <?php if ($data_user['myaccess'] == "N"){print " selected ";} ?>><?php echo _BOOKADDWITHOUTAPROVAL;?></option>
							<option value="F" <?php if ($data_user['myaccess'] == "N"){print " selected ";} ?>><?php echo _BOOKCOMPLETEACCES;?></option>
						</select>
						</td></tr>
					<?php }
				}?>
		</center>
</body>
</html>
