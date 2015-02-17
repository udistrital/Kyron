<?
// echo "redireccionar funcion ->";
// exit ();
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( "pagina" );
	// var_dump($_REQUEST);exit;
	
	switch ($solicitud) {
		
		case "mostrarMensajeCorreccion" :
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=mostrarMensajeCorreccion";
			$variable .= "&mensaje=" . $datos ["mensaje"];
			$variable .= "&error=" . $datos ["error"];
			break;
		
		case "mostrarMensaje" :
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=mostrarMensaje";
			$variable .= "&mensaje=" . $datos ["mensaje"];
			$variable .= "&error=" . $datos ["error"];
			break;
		
		case "confirmar" :
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=confirmar";
			// if ($valor != "") {
			// $variable .= "&id_sesion=" . $valor;
			// }
			break;
		case "procesarNuevo" :
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=confirmar";
			if ($valor != "") {
				$variable .= "&id_sesion=" . $valor;
			}
			break;
		
		case "mostrarInfo" :
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=mostrarInfo";
			$variable .= "&datos=" . $datos;
			//
			break;
		
		case "cambiarEstado" :
			
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=CambiarEstado";
			$variable .= "&datos=" . $datos;
			//
			break;
		
		case "historico" :
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=historicoDocente";
			$variable .= "&datos=" . $datos;
			//
			break;
			
			
			
		case "historicoGeneral" :
			
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=historicoDocenteGeneral";
			$variable .= "&datos=" . $datos;
			//
			break;
		
		case "modificarEstado" :
			
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=ModificarEstado";
			$variable .= "&datos=" . $datos;
			//
			break;
		
		case "paginaPrincipal" :
			$variable = "pagina=index";
			break;
	}
	foreach ( $_REQUEST as $clave => $valor ) {
		unset ( $_REQUEST [$clave] );
	}
	
	$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
	$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
	
	$_REQUEST [$enlace] = $variable;
	$_REQUEST ["recargar"] = true;
}
?>