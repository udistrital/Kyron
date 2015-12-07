<?php

if (! isset ( $GLOBALS ['autorizado'] )) {
	include ('../index.php');
	exit ();
}

include_once ('core/builder/InspectorHTML.class.php');

class registrarForm {
	var $miConfigurador;
	var $miInspectorHTML;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	function __construct($lenguaje, $formulario, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miInspectorHTML = \InspectorHTML::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		$this->miSql = $sql;
	}
	function miForm() {
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( 'esteBloque' );
		$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		
		$directorio = $this->miConfigurador->getVariableConfiguracion ( 'host' );
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( 'site' ) . '/index.php?';
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( 'enlace' );
		
		$rutaUrlBloque = $this->miConfigurador->getVariableConfiguracion ( 'host' );
		$rutaUrlBloque .= $this->miConfigurador->getVariableConfiguracion ( 'site' ) . '/blocks/';
		$rutaUrlBloque .= $esteBloque ['grupo'] .'/'. $esteBloque ['nombre'];
		
		$rutaSara = $this->miConfigurador->getVariableConfiguracion ( 'raizDocumento' );
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( 'rutaBloque' );
		
		// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
		/**
		 * Atributos que deben ser aplicados a todos los controles de este formulario.
		 * Se utiliza un arreglo
		 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		 *
		 * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
		 * $atributos= array_merge($atributos,$atributosGlobales);
		 */
		
		
		$atributosGlobales ['campoSeguro'] = 'true';
		/*
		 * Se propone un tipo de validación diferente a la convencional estructura:
		 *	 if (isset ( $_REQUEST ['id_docente'] ) && $_REQUEST ['id_docente'] != '') {
		 *		$id_docente = $_REQUEST ['id_docente'];
		 *	} else {
		 *		$id_docente = '';
		 *	}
		 * Se crea una función que valida todo de acuerdo a el campo validarCampos que corresponde
		 * a las entradas puestas en el string jquery.validationEngine
		 */
		/*
		 * Se realiza la decodificación de los campos 'validador' de los 
		 * componentes del FormularioHtml. Se realiza la validación. En caso de que algún parámetro
		 * sea ingresado fuera de lo correspondiente en el campo 'validador', este será ajustado
		 * (o convertido a) a un parámetro permisible o simplemente de no ser válido se devolverá 
		 * el valor false. Si lo que se quiere es saber si los parámetros son correctos o no, se
		 * puede introducir un tercer parámetro $arreglar, que es un parámetro booleano que indica,
		 * si es pertinente o no realizar un recorte de los datos 'string' para que cumpla los requerimientos
		 * de longitud (tamaño) del campo.
		 */
		if(isset($_REQUEST['validadorCampos'])){
			$validadorCampos = $this->miInspectorHTML->decodificarCampos($_REQUEST['validadorCampos']);
			$respuesta = $this->miInspectorHTML->validacionCampos($_REQUEST,$validadorCampos,false,false);
			if ($respuesta != false){
				$_REQUEST = $respuesta;
			} else {
				//Lo que se desea hacer si los parámetros son inválidos
				$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
				$variable = 'pagina=accesoIncorrecto';
				$variable .= '&opcion=error';
				$variable .= '&paginaError='.$miPaginaActual;
				$variable .= '&parametros='.$this->miInspectorHTML->codificarCampos($_REQUEST);
				$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
				$url = $this->miConfigurador->configuracion ['host'] . $this->miConfigurador->configuracion ['site'] . '/index.php?';
				$enlace = $this->miConfigurador->configuracion ['enlace'];				
				$redireccion = $url . $enlace . '=' . $variable;
				echo '<script>location.replace("' . $redireccion . '")</script>';
			}
		}
		
		// -------------------------------------------------------------------------------------------------
		$conexion = 'docencia';
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$documento = '79708124';
		
		
		$atributos ['id'] = 'formSaraData'; // No cambiar este nombre
		$atributos ['origen'] = 'plantilla1.html.php';
		$atributos ['destino'] = $documento.'pdf';
		echo $this->miFormulario->pdf ( $atributos );
		unset ( $atributos );
		
		
		// ------------------- SECCION: Paso de variables ------------------------------------------------
		
		/**
		 * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
		 * SARA permite realizar esto a través de tres
		 * mecanismos:
		 * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
		 * la base de datos.
		 * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
		 * formsara, cuyo valor será una cadena codificada que contiene las variables.
		 * (c) a través de campos ocultos en los formularios. (deprecated)
		 */
		
		// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
		
		// Paso 1: crear el listado de variables
		
		$valorCodificado = 'actionBloque=' . $esteBloque ['nombre'];
		$valorCodificado .= '&pagina=' . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$valorCodificado .= '&bloque=' . $esteBloque ['nombre'];
		$valorCodificado .= '&bloqueGrupo=' . $esteBloque ['grupo'];
		$valorCodificado .= '&opcion=regresar';
		$valorCodificado .= '&redireccionar=regresar';
		/**
		 * SARA permite que los nombres de los campos sean dinámicos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
		 * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
		 * (b) asociando el tiempo en que se está creando el formulario
		 */
		$valorCodificado .= '&tiempo=' . time ();
		// Paso 2: codificar la cadena resultante
		$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
		
		$atributos ['id'] = 'formSaraData'; // No cambiar este nombre
		$atributos ['tipo'] = 'hidden';
		$atributos ['estilo'] = '';
		$atributos ['obligatorio'] = false;
		$atributos ['marco'] = true;
		$atributos ['etiqueta'] = '';
		$atributos ['valor'] = $valorCodificado;
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );
	}
}

$miSeleccionador = new registrarForm ( $this->lenguaje, $this->miFormulario, $this->sql );

$miSeleccionador->miForm ();
?>	