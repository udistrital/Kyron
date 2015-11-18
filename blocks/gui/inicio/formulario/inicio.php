<?php
//Se establece el espacio de nombre
namespace gui\accesoIncorrecto\formulario;
// Se verifica si el usuario está autorizado
if (!isset($GLOBALS['autorizado'])) {
	include ('../index.php');
	exit();
}

class Form {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $site;
	var $sesionUsuario;
	
	function __construct($lenguaje, $formulario) {
		$this -> miConfigurador = \Configurador::singleton();
		
		$this -> miInspectorHTML = \InspectorHTML::singleton();

		$this -> miConfigurador -> fabricaConexiones -> setRecursoDB('principal');

		$this -> lenguaje = $lenguaje;

		$this -> miFormulario = $formulario;
		
		$this -> site = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
		
		$this->sesionUsuario = \Sesion::singleton ();
	}

	function miForm() {
		// Rescatar los datos de este bloque
			
		$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
		include $this -> site.'funcion/VerificarSesion.php';
		if($respuesta){
			$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
			$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
			$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
			$valorCodificado = "pagina=bienvenido";
			//$valorCodificado .= "&autenticado=true";
			$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
			$enlace = $directorio.'='.$valorCodificado;
			
			header('Location: '.$enlace);
		}
// 		$autenticado = false;
// 		if(isset($_REQUEST['autenticado'])&&$_REQUEST['autenticado']==true){
// 			$autenticado = true;
// 		}
		include $this->site.'formulario/paginaInicio.html.php';
	}

	function mensaje() {

		// Si existe algun tipo de error en el login aparece el siguiente mensaje
		$mensaje = $this -> miConfigurador -> getVariableConfiguracion('mostrarMensaje');
		$this -> miConfigurador -> setVariableConfiguracion('mostrarMensaje', null);

		if ($mensaje) {
			$tipoMensaje = $this -> miConfigurador -> getVariableConfiguracion('tipoMensaje');
			if ($tipoMensaje == 'json') {

				$atributos['mensaje'] = $mensaje;
				$atributos['json'] = true;
			} else {
				$atributos['mensaje'] = $this -> lenguaje -> getCadena($mensaje);
			}
			// ------------------Division para los botones-------------------------
			$atributos['id'] = 'divMensaje';
			$atributos['estilo'] = 'marcoBotones';
			echo $this -> miFormulario -> division("inicio", $atributos);

			// -------------Control texto-----------------------
			$esteCampo = 'mostrarMensaje';
			$atributos["tamanno"] = '';
			$atributos["estilo"] = 'information';
			$atributos["etiqueta"] = '';
			$atributos["columnas"] = '';
			// El control ocupa 47% del tamaño del formulario
			echo $this -> miFormulario -> campoMensaje($atributos);
			unset($atributos);

			// ------------------Fin Division para los botones-------------------------
			echo $this -> miFormulario -> division("fin");
		}
	}

}

$miSeleccionador = new Form($this -> lenguaje, $this -> miFormulario);

$miSeleccionador -> mensaje();

$miSeleccionador -> miForm();
?>