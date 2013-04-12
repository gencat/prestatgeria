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
$errors = "";
require "config.php";
include_once $zikulapath . '/modules/advMailer/pnincludes/mailsender.class.php';
include_once $zikulapath . '/modules/advMailer/pnincludes/message.class.php';

//Select the file with the lang strings
include("lang/".$lang.'.php');

if($action == "search"){
	$adminemail = $data['adminemail'];
	$query = "select * from ".$prefix."_users WHERE email='$email' ";
	$data = $mydatabase->select($query);

	$message = _BOOKTHEEMAILHASBEENSENDED." <br>\n";
	$message .= _BOOKBELOWISTHELOGGININFO."<br>\n";

	if( (count($data) == 0) && ($adminemail != $email) ){
		$errors = '<font color="#990000"><b>'._BOOKSORRYTHEEMAILADDRESS.' <font color="#000099">'.$email.'</font> '._BOOKCOULDNOTBEFOUND;
		$errors .= ' '._BOOKIFYOUANADMIN.' <font color="#000099">'.$adminemail.'</font>.<br></b></font>';    
	} else {
		for($j=0;$j< count($data); $j++){
			$row = $data[$j];
			$message .= "--------------------------------\n<br> ";
			$message .= "username: ".$row['myusername']." \n<br> ";
			$message .= "password: ".$row['mypassword']." \n<br> ";
		}
		if ($adminemail == $email){
			$message .= "-------------------------------- \n<br> ";
			$message .= "username: ".$myname." \n<br> ";
			$message .= "password: ".$password_admin_t." \n<br> ";
		}
		$contactemail  = $adminemail;
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From: ".$adminemail." <".$adminemail.">\r\n";
		$subject = _BOOKLOSTPASSWORD;
		$headers .= "To: <".$email.">\r\n";
				
		$mailsender = new mailsender($IDAPP,$REPLYADDRESS,$SENDER,$ENVIRONMENT,$LOG,$LOGDEBUG,$LOGPATH);
		$msg = new message($CONTENTTYPE,$LOG,$LOGDEBUG,$LOGPATH);
		
		//Indiquem l'adreça del destinatari
		$adr_desti = $top_r['notifyemail'];
		$msg->set_to($adminemail);			
			
		//Asignem assumpte i cos del missatge
		$msg->set_subject($subject);
		$msg->set_bodyContent($message);
			
		$mailsender->add($msg);
		$exit = $mailsender->send_mail();
			
//			//Si no s'ha pogut enviar realitzem 4 intents m�s... fem una pausa de 5 s a cada nou intent ( funci� sleep )
//			$intents = 1;
//			while ((!$exit) && ($intents < 2)) {
//				sleep(5);
//				$exit = $mail->Send();
//				$intents = $intents + 1;
//			}			
		?>
		<HTML>
		<HEAD>
		    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
			<TITLE></TITLE>
		</HEAD>
		<body bgcolor="#000000" background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">
			<br><br>
			<?php echo _BOOKEMAILSENDTO;?> <?php echo $email;?> <?php echo _BOOKWITHTHEENTRYINFO;?>
			<br><br><a href="login.php"><?php echo _BOOKHERETOLOGININ;?></a>
		</body>
		</html>
		<?php
		exit;
	}
}
?>
<HTML>
<HEAD>
   <TITLE></TITLE>
</HEAD>
<body bgcolor="#000000" background="themes/<?php echo $theme;?>/images/bkbook.gif" bgcolor="#ffffff" text="#664411" link="#996633" vlink="#996633" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0">

	<br><br>
	<form action="lostpass.php" method="post">
		<input type="hidden" name="action" value="search">
		<a href="index.php" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/back.gif" border="0"></a>		
		<center>
			<table width="500">
				<tr>
					<td>
						<b><?php echo _BOOKLOSTPASSWORD;?>:</b><br><br>
						<?php echo _BOOKENTERTHEEMAIL;?>
						<br>
						<?php
						print $errors;
						?><br>
						<b><?php echo _BOOKREQUIREDMAIL;?>:</b><input type="text" name="email" size="40"><input type="submit" value="<?php echo _BOOKSEND;?>"><br>						
					</td>
				</tr>
			</table>
		</center>
		<a href="index.php" target="_top"><img src="themes/<?php echo $theme;?>/lang/<?php echo $lang;?>/back.gif" border="0"></a>
	</form>
</body>
</html>
