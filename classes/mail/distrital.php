<?php

include("class.phpmailer.php");
include("class.smtp.php");

$mail = new phpmailer();
$mail->From     = "fernandotower@gmail.com";
$mail->FromName = "fernando name";
$mail->Host     = "mail.udistrital.edu.co";
$mail->Mailer   = "smtp";
$mail->SMTPAuth = true;
$mail->Username = "ftorres@udistrital.edu.co";
$mail->Password = "mafecyta06";
$mail->Timeout  = 120;
$mail->Charset  = "utf-8";
$mail->IsHTML(false);




        $mail->Body    = "Este es el cuerpo del mensaje";
	$mail->Subject = "el sujeto";
	$mail->AddAddress("ftorres@udistrital.edu.co");		    	

   	if(!$mail->Send())
   	{
   		header("Location: $redir?error_login=16");
   	}
	else
	{
		header("Location: $redir?error_login=18");
	}
    	$mail->ClearAllRecipients();

?>
