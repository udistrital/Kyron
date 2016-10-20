<?php

namespace gui\menuPrincipal\formulario;

include_once ($this->ruta . "/builder/DibujarMenu.class.php");
use gui\menuPrincipal\builder\Dibujar;
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class FormularioMenu {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $miSesionSso;
	
	function __construct($lenguaje, $formulario, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		$this->miSql = $sql;
		
		$this->miSesionSso = \SesionSso::singleton ();
	}
	function formulario() {
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		
		$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
		
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
		$rutaBloque .= $esteBloque ['grupo'] . '/' . $esteBloque ['nombre'];
		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
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
		$_REQUEST ['tiempo'] = time ();
		
		// -------------------------------------------------------------------------------------------------
		
		
		
		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		/**
		 * Nuevo a partir de la versión 1.0.0.2, se utiliza para crear de manera rápida el js asociado a
		 * validationEngine.
		 */
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = 'multipart/form-data';
		
		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';
		
		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		
		$conexion = "estructura";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
// 		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->formulario ( $atributos );
		unset ( $atributos );
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		$respuesta = $this->miSesionSso->getParametrosSesionAbierta();
		
		$cadenaSql = $this->miSql->getCadenaSql ( "datosMenu", $respuesta['perfil'] );
		$datosMenu = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );


		
// 		foreach ( $datosMenu as $menu => $item ) {
// 			if(strcmp($item['tipo_enlace'], 'submenu_enlace_interno') == 0){
// 				$enlace = '#';
// 				$enlaces [$this->lenguaje->getCadena ($item ['menu'])]['columna'. $item ['columna']][$item ['tipo_enlace']][$this->lenguaje->getCadena ($item ['titulo'])] = $enlace;
// 			}elseif(strcmp($item['tipo_enlace'], 'enlace_interno') == 0){
// 				$enlace = 'pagina=' . $item ['enlace'].$item['parametros'];
// 				$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
// 				$enlaces [$this->lenguaje->getCadena ($item ['menu'])]['columna'. $item ['columna']][$item ['tipo_enlace']][$this->lenguaje->getCadena ($item ['titulo'])] = $enlace;
// 			}
// 			elseif(strcmp($item['tipo_enlace'], 'enlace_externo') == 0){
// 				$enlace = $item ['enlace'];
// 				//$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
// 				$enlaces [$this->lenguaje->getCadena ($item ['menu'])]['columna'. $item ['columna']][$item ['tipo_enlace']][$this->lenguaje->getCadena ($item ['titulo'])] = $enlace;
// 			}
// 		}
		
// 		foreach ( $datosMenu as $menu => $item ) {
// 			if(strcmp($item['tipo_enlace'], 'submenu_enlace_interno') == 0){
// 				$enlace = '#';
// 				$enlaces ['menu'.$item ['menu']]['columna'. $item ['columna']][$item ['tipo_enlace']][$this->lenguaje->getCadena ($item ['titulo'])] = $enlace;	
// 			}elseif(strcmp($item['tipo_enlace'], 'enlace_interno') == 0){				
// 				$enlace = 'pagina=' . $item ['enlace'].$item['parametros'];		
// 				$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
// 				$enlaces ['menu'.$item ['menu']]['columna'. $item ['columna']][$item ['tipo_enlace']][$this->lenguaje->getCadena ($item ['titulo'])] = $enlace;					
// 			}

// 		foreach ( $datosMenu as $menu => $item ) {
// 			if(strcmp($item['tipo_enlace'], 'menu_enlace_interno') == 0){
// 				//Enlace de menú siempre se codifica?
// 				$enlace = 'pagina=' . $item ['enlace'].$item['parametros'];
// 				$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
// 				$enlaces ['menu'.$item ['menu']]['columna'. $item ['columna']][$item ['tipo_enlace']][$this->lenguaje->getCadena ($item ['titulo'])] = $enlace;
// 			}elseif(strcmp($item['tipo_enlace'], 'submenu_enlace_interno') == 0){
// 				//Enlace de submenú nunca se codifica?
// 				$enlace = '#';
// 				$enlaces ['menu'.$item ['menu']]['columna'. $item ['columna']][$item ['tipo_enlace']][$this->lenguaje->getCadena ($item ['titulo'])] = $enlace;
// 			}elseif(strcmp($item['tipo_enlace'], 'enlace_interno') == 0){
// 				//Enlace normal siempre se codifica?
// 				$enlace = 'pagina=' . $item ['enlace'].$item['parametros'];
// 				$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
// 				$enlaces ['menu'.$item ['menu']]['columna'. $item ['columna']][$item ['tipo_enlace']][$this->lenguaje->getCadena ($item ['titulo'])] = $enlace;
// 			}
// // 			elseif(strcmp($item['tipo_enlace'], 'submenu_enlace_interno') == 0){
// // 				$enlace = 'pagina=' . $item ['menu'];
// // 				$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
// // 				$nombrePagina = $this->lenguaje->getCadena ( $item ['menu'] );
// // 				$enlaces [$nombrePagina] = $enlace;
// // 			}elseif(strcmp($item['tipo_enlace'], 'enlace_interno') == 0){
// // 				$enlace = $item ['externo'];
// // 				//$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
// // 				$enlaces ['menu'.$item ['menu']]['columna'. $item ['columna']][$item ['tipo_enlace']][$this->lenguaje->getCadena ($item ['titulo'])] = $enlace;						
// // 			}
// 		}
		
		/*
		 * Se generan la estructura de un arreglo 3dimensional y se llena con arreglos vacíos.
		 */
		foreach ( $datosMenu as $menu => $item ) {
			$enlaces ['menu'.$item ['menu']]['columna'. $item ['columna']][$item ['clase_enlace']][$this->lenguaje->getCadena ($item ['titulo'])] = array ();
		}
		
		foreach ( $datosMenu as $menu => $item ) {
			//Se instancia el enlace como # que significa que el enlace no existe inicialmente.
			$enlace = '#';
			//Dependiendo de la clase del enlace (menú, submenú, normal) se da un enlace al componente.
			switch($item['clase_enlace']){
				case 'menu'://Cuando el enlace es clase menú.
					//Dependiendo del tipo de enlace (interno o externo) se codifica o no el enlace.
					switch($item['tipo_enlace']){
						case 'interno'://Cuando el enlace del menú es de tipo interno.
							$enlace = 'pagina=' . $item ['enlace'].$item['parametros'];
							$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
							break;
						case 'externo':
							$enlace = $item ['enlace'].$item['parametros'];
							break;
					}
					break;
				case 'submenu':
					switch($item['tipo_enlace']){
						case 'interno'://Cuando el enlace del submenú es de tipo interno.
							$enlace = '#';
							break;
						case 'externo':
							$enlace = '#';
							break;
					}
					break;
				case 'normal':
					switch($item['tipo_enlace']){
						case 'interno'://Cuando el enlace normal es de tipo interno.
							$enlace = 'pagina=' . $item ['enlace'].$item['parametros'];
							$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
							break;
						case 'externo':
							
							break;
					}
				break;
			}
			$enlaces ['menu'.$item ['menu']]['columna'. $item ['columna']][$item ['clase_enlace']][$this->lenguaje->getCadena ($item ['titulo'])] = $enlace;
		}
		$atributos ['enlaces'] = $enlaces;
		$crearMenu = new Dibujar ();
		echo $crearMenu->html ( $atributos );
		
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
		
		$valorCodificado = "actionBloque=" . $esteBloque ["nombre"];
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&opcion=registrarBloque";
		/**
		 * SARA permite que los nombres de los campos sean dinámicos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo.
		 */
		$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
		$valorCodificado .= "&tiempo=" . time();
		// Paso 2: codificar la cadena resultante
		$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
		
		$atributos ["id"] = "formSaraData"; // No cambiar este nombre
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ["obligatorio"] = false;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		$atributos ["valor"] = $valorCodificado;
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ----------------FIN SECCION: Paso de variables -------------------------------------------------
		
		// ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
		
		// ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
		// Se debe declarar el mismo atributo de marco con que se inició el formulario.
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );
	}
	function mensaje() {
		
		// Si existe algun tipo de error en el login aparece el siguiente mensaje
		$mensaje = $this->miConfigurador->getVariableConfiguracion ( 'mostrarMensaje' );
		$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', null );
		
		if ($mensaje) {
			
			$tipoMensaje = $this->miConfigurador->getVariableConfiguracion ( 'tipoMensaje' );
			
			if ($tipoMensaje == 'json') {
				
				$atributos ['mensaje'] = $mensaje;
				$atributos ['json'] = true;
			} else {
				$atributos ['mensaje'] = $this->lenguaje->getCadena ( $mensaje );
			}
			// -------------Control texto-----------------------
			$esteCampo = 'divMensaje';
			$atributos ['id'] = $esteCampo;
			$atributos ["tamanno"] = '';
			$atributos ["estilo"] = 'information';
			$atributos ['efecto'] = 'desvanecer';
			$atributos ["etiqueta"] = '';
			$atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
			echo $this->miFormulario->campoMensaje ( $atributos );
			unset ( $atributos );
		}
		
		return true;
	}
}

$miFormulario = new FormularioMenu ( $this->lenguaje, $this->miFormulario, $this->sql );

$miFormulario->formulario ();
$miFormulario->mensaje ();

?>
