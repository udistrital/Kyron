<?php

namespace reportes\estadoDeCuenta\funcion;

include_once ('redireccionar.php');
if (! isset ( $GLOBALS ['autorizado'] )) {
	include ('../index.php');
	exit ();
}
class correo {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miFuncion;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql, $funcion) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
		$this->miFuncion = $funcion;
	}
	function enviarCorreo($asunto, $contenidoMensaje, $destinos = array('condor@udistrital.edu.co')) {
		$rutaSara = $this->miConfigurador->getVariableConfiguracion ( 'raizDocumento' );
		include_once ($rutaSara . '/blocks/clases/mail/class.phpmailer.php');
		include_once ($rutaSara . '/blocks/clases/mail/class.smtp.php');
		
		$mail = new \PHPMailer ();
		
		// configuracion de cuenta de envio
		$mail->Mailer = 'smtp';
		$mail->SMTPAuth = true;
		
		// $mail->Host = 'mail.udistrital.edu.co';
		$mail->Host = $this->miConfigurador->getVariableConfiguracion ( 'hostCorreo' );
		$mail->Username = $this->miConfigurador->getVariableConfiguracion ( 'usuarioCorreo' );
		$mail->Password = $this->miConfigurador->getVariableConfiguracion ( 'claveCorreo' );
		$mail->Password = $this->miConfigurador->fabricaConexiones->crypto->decodificar ( $mail->Password );
		// $mail->Username = //usuario correo;
		// $mail->Password = //clave correo;
		$mail->Timeout = 120;
		$mail->IsHTML ( false );
		
		// remitente
		// $mail->From = 'glud@udistrital.edu.co';
		$mail->From = $this->miConfigurador->getVariableConfiguracion ( 'correoAdministrador' );
		// $mail->FromName = 'KYRON';
		$mail->FromName = $this->miConfigurador->getVariableConfiguracion ( 'nombreAplicativo' );
		
		$mail->Body = $contenidoMensaje;
		$mail->Subject = $asunto;
		
		// destinatarios
		// $mail->AddAddress ( 'condor@udistrital.edu.co' );
		for ($i = 0; $i < count($destinos); $i++) {
			$mail->AddAddress( $destinos[$i] );
		}
		//$mail->AddAddress ( 'juusechec@gmail.com' );
		
		return $mail->Send (); //true es enviado correctamente
	}
}

?>
