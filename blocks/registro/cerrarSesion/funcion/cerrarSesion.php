<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	$miSesion = Sesion::singleton ();
	
	if (isset ( $_REQUEST ['sesionId'] )) {
		$miSesion->terminarSesion ( $_REQUEST ['sesionId'] );
	}
	// Redirigir a la página de inicio con mensaje de error en usuario/clave
	$this->funcion->redireccionar ( "paginaPrincipal" );
}
?>