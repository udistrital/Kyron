<?php

class Logout {
	
	var $miSesionSso;
		
	function __construct() {
		$this->miSesionSso = \SesionSso::singleton ();
	}
	function procesarFormulario() {
		return $this->miSesionSso->terminarSesion();
	}
}

$miProcesador = new Logout ();
$miProcesador->procesarFormulario();
?>