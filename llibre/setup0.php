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

$version = "4.0";
echo '<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">';

//check for possible languages

$dir = 'lang';
if (is_dir($dir)) {
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if(strtolower(substr($file,-4)) =='.php'){
				$languages[]=array('filetext'=>substr($file,0,-4));
			}
		}
		closedir($dh);
	}
} 
?>

<h2>Installation of Crafty Syntax MyScrapbook</h2>

<FORM action="setup.php" method="post" name="lang" enctype="application/x-www-form-urlencoded">
<table width=600 bgcolor=FFFFEE>
<tr><td bgcolor="#DDDDDD" colspan="2"><b>LANGUAGE</b></td></tr>
<tr><td bgcolor="#EEEECC" colspan="2">Choose the language for your book from de list of installed languages.</td></tr>
<tr>
	<td>
		The language of my book will be:
	</td>
	<td>
		<select name="lang">
			<?php foreach($languages as $language){?>
				<option value="<?php echo $language['filetext']; ?>"><?php echo $language['filetext'];?></option>
			<?php }?>
		</select>
	</td>
</tr>
<tr>
	<td align="right" colspan="2">
		<input type="submit" value="Install">
	</td>
</tr>
</table>
</form>
