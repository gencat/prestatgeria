<?php
	require "config.php";
	//Select the file with the lang strings
	include("lang/".$lang.'.php');
?>
<link rel="stylesheet" href="../custom.css" type="text/css">
<body background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" link="#996633" vlink="#996633">
	<center>
		<table width="450">
			<tr>
				<td>
					<div align="center"><strong><?php echo _BOOKABOUT; ?></strong></div>
					<br><br><br>
					<?php echo $data['abouttext'];?>
					<br><br><br>
					<div align="center"><a href="javascript:window.close()"><?php echo _BOOKCLICTOCLOSE; ?></a></div>
				</td>
			</tr>
		</table>
	</center>
</body>
