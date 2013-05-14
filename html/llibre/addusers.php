<?php
	include("config.php");
	//Select the file with the lang strings
	include("lang/".$lang.'.php');
?>
<HTML>
<HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title><?php _BOOKIMPORTRESULT; ?></title>
	<link rel="stylesheet" href="themes/<?php echo $theme;?>/style.css" type="text/css">
</HEAD>
<BODY background="themes/<?php echo $theme;?>/images/bkbook.gif">
	<div align="center"><font size="+2" color="#664411"><strong><?php _BOOKIMPORTRESULT;?></strong></font></div>
	<?php
		//COGEMOS EL ARCHIVO PROCEDENTE DEL FORMULARIO
		$userfile=$_FILES['userfile']['tmp_name'];
		$userfile_name=$_FILES['userfile']['name'];
		$userfile_type=$_FILES['userfile']['type'];
		$userfile_error=$_FILES['userfile']['error'];
		//COMPROBAMOS SI HAY ERRORES
		if ($userfile_error >0){
			echo _BOOKHAVEPROBLEMSLOADFILE.': ';
		 	switch ($userfile_error){
				case 1: echo _BOOKTOOBIG; break;
				case 2: echo _BOOKTOOBIG; break;
				case 3: echo _BOOKFILE; break;
				case 4: echo _BOOKNOTOPENFILE; break;
			}
			exit();
		}
		//COMPROBAMOS QUE EL ARCHIVO QUE EL USUARIO HA SUBIDO ES DE TEXTO
		if ($userfile_type != 'text/plain'){
			echo _BOOKNOTTEXTPLAIN;
			exit();
		}

		//ABRIMOS EL FICHERO DE TEXTO SUBIDO
		$fich = fopen($userfile, "r");
		//CONECTAMOS CON LA BASE DE DATOS
		$c=mysql_connect($server,$datausername,$password);
		mysql_select_db($database,$c);
		//COMPROBAMOS QUE EL PUNTERO NO EST� EN EL FINAL DEL ARCHIVO Y PROCESAMOS EL ARCHIVO
		while(!feof($fich)){
			$cadena = fgets($fich,4096);
			$cadena=substr($cadena,0,strpos($cadena,"\r\n"));
			$trozos = explode(";", $cadena);
			if(($trozos[0]=="") && ($trozos[1]=="") && ($trozos[2]=="") && ($trozos[3]=="") && ($trozos[4]=="")){
				echo '<br><br><div align="center"><font color="#CC0000">'._BOOKUSERSIMPORT.'</font><div><br>';
			}else{
				if ($trozos[1]==""){
					echo "<br>"._BOOKNOTUSERIN.": ".$trozos[1].", "._BOOKNOTPASSW;
				}else{
					$sql="select myusername from ".$prefix."_users where myusername='".$trozos[1]."'";
					$resultado=mysql_query($sql)or die (_BOOKNOTANSWERBBDD.", ".mysql_error());
					if (mysql_num_rows($resultado)==0){
						$sql="insert into ".$prefix."_users(myusername,mypassword,email,name,loggedin) VALUES ('".$trozos[0]."','".$trozos[1]."','".$trozos[2]."','".$trozos[3]."','".$trozos[4]."')";
						$resultado=mysql_query($sql)or die (_BOOKNOTANSWERBBDD.", ".mysql_error());
						echo '<br><font color="#004400">'._BOOKUSERINOK.': </font>'.$trozos[0].' / '.$trozos[1].' / '. $trozos[2];
					}else{
						echo '<br><font color="#cc0000">'._BOOKUSERREP.": ".$trozos[0].'</font>';
					}
	  			}
			}
  		}
	?>
	<div align="center">
		<form action="updatechapter.php" method="post">
			<input type="hidden" name="whattodo" value="<?php echo _BOOKUSEREDIT;?>">
			<input type="submit" name="whattodo" value="<?php echo _BOOKUSEREDIT;?>">
		</form>

  		<form action="index.php" target="_top" method="post">
			<input type="submit" value="<?php echo _BOOKGOBACKTOCONTENTS?>">
		</form>
  	</div>

</BODY>
</HTML>
<?php
	exit();
?>
