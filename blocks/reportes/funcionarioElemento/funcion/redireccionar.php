<?

namespace inventarios\gestionElementos\funcionarioElemento\funcion;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class redireccion {
	public static function redireccionar($opcion, $valor = "") {
		$miConfigurador = \Configurador::singleton ();
		$miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
		
		switch ($opcion) {
			
			
			
			case "noSeleccion" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=noSelecciono";
				$variable .= "&funcionario=" . $_REQUEST['funcionario'];
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				if (isset ( $_REQUEST ['accesoCondor'] ) && $_REQUEST ['accesoCondor'] == 'true') {
						
					$variable .= "&accesoCondor=true";
				}
			
				break;
			
			
			
			case "Verificacion" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=" . $valor [0];
				$variable .= "&funcionario=" . $_REQUEST['funcionario'];
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				if (isset ( $_REQUEST ['accesoCondor'] ) && $_REQUEST ['accesoCondor'] == 'true') {
					
					$variable .= "&accesoCondor=true";
				}
				
				break;
			
			case "noVerificado" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=noVerificado";
				$variable .= "&funcionario=" . $valor [0];
				$variable .= "&usuario=" . $valor [1];
				
				break;
			
			case "insertoObservacion" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=insertoObservacion";
				$variable .= "&placa=" . $valor [0];
				$variable .= "&funcionario=" . $valor [1];
				$variable .= "&elemento_individual=" . $valor [2];
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				if (isset ( $_REQUEST ['accesoCondor'] ) && $_REQUEST ['accesoCondor'] == 'true') {
					
					$variable .= "&accesoCondor=true";
				}
				
				break;
			
			case "noInsertoObservacion" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=noInsertoObservación";
				$variable .= "&funcionario=" . $valor;
				
				break;
			
			case "inserto" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=actualizo";
				$variable .= "&placa=" . $valor;
				break;
			
			case "noInserto" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=error";
				
				break;
			
			case "anulado" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=anulado";
				break;
			
			case "noAnulado" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=noAnulado";
				$variable .= "&mensaje=error";
				
				break;
			
			case "notextos" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=otros";
				$variable .= "&errores=notextos";
				
				break;
			
			case "regresar" :
				$variable = "pagina=" . $miPaginaActual;
				break;
			
			case "paginaPrincipal" :
				$variable = "pagina=" . $miPaginaActual;
				break;
		}
		
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		
		$url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
		$enlace = $miConfigurador->configuracion ['enlace'];
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		$_REQUEST [$enlace] = $enlace . '=' . $variable;
		$redireccion = $url . $_REQUEST [$enlace];
		
		echo "<script>location.replace('" . $redireccion . "')</script>";
		exit ();
	}
}

?>