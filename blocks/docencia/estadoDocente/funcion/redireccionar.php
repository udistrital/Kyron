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
		
		case "inserto" :
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=mensaje";
			$variable .= "&mensaje=confirma";
			if ($datos != "") {
				$variable .= "&docente=" . $datos;
			}
			break;
		
		case "noInserto" :
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=mensaje";
			$variable .= "&mensaje=error";
			if ($datos != "") {
				$variable .= "&docente=" . $datos;
			}
			break;
		
		case "Actualizo" :
			
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=mensaje";
			$variable .= "&mensaje=mensajeActualizar";
			if ($datos != "") {
				
				$variable .= "&docente=" . $datos;
			}
			break;
		
		case "noActualizo" :
			
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=mensaje";
			$variable .= "&mensaje=mensajenoActualizar";
			if ($datos != "") {
				
				$variable .= "&docente=" .$datos;
			}
			break;
		// -----------------------------------------------------------------------------------
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
		
		// case "mostrarInfo" :
		// $variable = "pagina=" . $miPaginaActual;
		// $variable .= "&solicitud=mostrarInfo";
		// $variable .= "&datos=" . $datos;
		// //
		// break;
		
		case "mostrarInfo" :
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=consultar";
			$variable .= "&datos=" . $datos;
			//
			break;
		
		case "cambiarEstado" :
			
			$variable = "pagina=" . $miPaginaActual;
			$variable .= "&solicitud=CambiarEstado";
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
			$variable = "pagina=estadoDocente";
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