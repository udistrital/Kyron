<?php

class VerificarSesion {
	var $miSesionSso;
	
	function __construct() {
		$this->miSesionSso = \SesionSso::singleton ();
	}
	function procesarFormulario() {
		$respuesta = $this->miSesionSso->verificarSesionAbierta();
		return $respuesta;
	}
}

$miProcesador = new VerificarSesion ();
$respuesta = $miProcesador->procesarFormulario();
?>