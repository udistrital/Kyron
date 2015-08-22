<?php

namespace gui\menuPrincipal\formulario;

include_once ($this->ruta . "/builder/DibujarMenu.class.php");
use gui\menuPrincipal\builder\Dibujar;
// // include_once ($this -> ruta . 'funcion/GetLink.php');
// // use gui\menuPrincipal\funcion\GetLink;
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Formulario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	function __construct($lenguaje, $formulario, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		$this->miSql = $sql;
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
		
		$conexion = "estructura";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		/**
		 * Nuevo a partir de la versión 1.0.0.2, se utiliza para crear de manera rápida el js asociado a
		 * validationEngine.
		 */
		$atributos ['validar'] = true;
		
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = '';
		
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
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->formulario ( $atributos );
		unset ( $atributos );
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		$paginas = [ 
				'inicio' 
		];
		
		$enlaces = array ();
		
		foreach ( $paginas as $pagina ) {
			$enlace = 'pagina=' . $pagina;
			$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
			// $enlace = GetLink::obtener($pagina);
			$nombrePagina = $this->lenguaje->getCadena ( $pagina );
			$enlaces [$nombrePagina] = $enlace;
		}
		
		// $enlaces[$this->lenguaje->getCadena ( 'sesion' )]=array(
		
		// 'usuario registrado'=>'#',
		// 'logout'=>'#',
		// );
		
		$cadenaSql = $this->miSql->getCadenaSql ( "datosMenu", 0 );
		$datosMenu = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		
		// var_dump($enlaces[$this->lenguaje->getCadena ( 'sesion' )]);
		
		$enlaces [$this->lenguaje->getCadena ( 'hojaVida' )] = array (
				$this->lenguaje->getCadena ( 'crearDocente' ) => '#',
				$this->lenguaje->getCadena ( 'titulosAcademicos' ) => '#',
				$this->lenguaje->getCadena ( 'sinTitulosAcademicos' ) => '#',
				$this->lenguaje->getCadena ( 'consultarActividadDocente' ) => '#' 
		);

		//Pendiente crear la tabla Grupo en las Tablas.
		
		foreach ( $datosMenu as $datos => $menu ) {
			$grupo ['grupo' . $menu ['grupo']]['columna'. $menu ['columna']][$menu ['descripcion']] = array ();
			$columna ['columna'. $menu ['columna']] = array ();
		}
		foreach ( $datosMenu as $datos => $menu ) {
			$grupo ['grupo' . $menu ['grupo']]['columna'. $menu ['columna']][$menu ['descripcion']] = "#";
		}
			
		foreach ($grupo as $datos=>$grupos){
			foreach ($grupos as $paginas=>$descripcion){
				
			}
		}
		
		
		$enlaces [$this->lenguaje->getCadena ( 'asignacionPuntajes' )] = array (
				'columnas' => array (
						'columna1' => array (
								'title' => $this->lenguaje->getCadena ( 'tituloSalariales' ),
								$this->lenguaje->getCadena ( 'capituloLibros' ) => '#',
								$this->lenguaje->getCadena ( 'cartasEditor' ) => '#',
								$this->lenguaje->getCadena ( 'direccionTrabajosGrado' ) => '#',
								$this->lenguaje->getCadena ( 'experienciaDireccionAcademica' ) => '#',
								$this->lenguaje->getCadena ( 'experienciaInvestigacion' ) => '#',
								$this->lenguaje->getCadena ( 'experienciaDocencia' ) => '#',
								$this->lenguaje->getCadena ( 'experienciaProfesional' ) => '#',
								$this->lenguaje->getCadena ( 'experienciaCalificada' ) => '#',
								$this->lenguaje->getCadena ( 'excelenciaAcademica' ) => '#',
								$this->lenguaje->getCadena ( 'revistasindexadas' ) => '#',
								$this->lenguaje->getCadena ( 'comunicacionCorta' ) => '#',
								$this->lenguaje->getCadena ( 'obrasArtisticasDocente' ) => '#',
								$this->lenguaje->getCadena ( 'patentes' ) => '#',
								$this->lenguaje->getCadena ( 'PremiosDocente' ) => '#',
								$this->lenguaje->getCadena ( 'produccionVideosDocente' ) => '#',
								$this->lenguaje->getCadena ( 'produccionLibros' ) => '#',
								$this->lenguaje->getCadena ( 'traducciones' ) => '#',
								$this->lenguaje->getCadena ( 'registroTecnicaSoftware' ) => '#' 
						),
						'columna2' => array (
								'title' => $this->lenguaje->getCadena ( 'tituloBonificacion' ),
								$this->lenguaje->getCadena ( 'crearDocente' ) => '#',
								$this->lenguaje->getCadena ( 'titulosAcademicos' ) => '#',
								$this->lenguaje->getCadena ( 'sinTitulosAcademicos' ) => '#',
								$this->lenguaje->getCadena ( 'consultarActividadDocente' ) => '#' 
						),
						'columna3' => array (
								'title' => $this->lenguaje->getCadena ( 'tituloNovedades' ),
								$this->lenguaje->getCadena ( 'crearDocente' ) => '#',
								$this->lenguaje->getCadena ( 'titulosAcademicos' ) => '#',
								$this->lenguaje->getCadena ( 'sinTitulosAcademicos' ) => '#',
								$this->lenguaje->getCadena ( 'consultarActividadDocente' ) => '#' 
						) 
				) 
		);
		
		$enlaces [$this->lenguaje->getCadena ( 'reportesDocencia' )] = array (
				'title' => $this->lenguaje->getCadena ( 'tituloConsultaReportes' ),
				$this->lenguaje->getCadena ( 'consultaReportes' ) => '#',
				$this->lenguaje->getCadena ( 'estadoCuentaDocente' ) => '#' 
		);
		
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
		
		return true;
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

$miFormulario = new Formulario ( $this->lenguaje, $this->miFormulario, $this->sql );

$miFormulario->formulario ();
$miFormulario->mensaje ();

?>

<?php
// include_once ($this->ruta . "/builder/DibujarMenu.class.php");
// use gui\menuPrincipal\builder\Dibujar;
// // include_once ($this -> ruta . 'funcion/GetLink.php');
// // use gui\menuPrincipal\funcion\GetLink;

// $directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
// $directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
// $directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

// $esteBloque=$this->miConfigurador->getVariableConfiguracion ( 'esteBloque' );

// $this->miSql = $sql;
// $this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );

// $conexion = "estructura";
// $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

// $paginas = [
// 'inicio',
// ];

// $enlaces = array ();

// foreach ( $paginas as $pagina ) {
// $enlace = 'pagina=' . $pagina;
// $enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
// //$enlace = GetLink::obtener($pagina);
// $nombrePagina = $this->lenguaje->getCadena ( $pagina );
// $enlaces[$nombrePagina] = $enlace;
// }

// // $enlaces[$this->lenguaje->getCadena ( 'sesion' )]=array(

// // 'usuario registrado'=>'#',
// // 'logout'=>'#',
// // );

// $cadenaSQL = $this->miSql->getCadenaSql("$cadenaSql", 0);
// $datosMenu = $esteRecursoDB->ejecutarAcceso($cadenaSQL, "busqueda");

// var_dump($datosMenu);

// $enlaces[$this->lenguaje->getCadena ( 'hojaVida' )]=array(
// $this->lenguaje->getCadena ( 'crearDocente' ) => '#',
// $this->lenguaje->getCadena ( 'titulosAcademicos' ) => '#',
// $this->lenguaje->getCadena ( 'sinTitulosAcademicos' ) => '#',
// $this->lenguaje->getCadena ( 'consultarActividadDocente' ) => '#',
// );

// $enlaces[$this->lenguaje->getCadena ( 'asignacionPuntajes' )]=array(
// 'columnas' => array(
// 'columna1' => array(
// 'title'=>$this->lenguaje->getCadena ( 'tituloSalariales' ),
// $this->lenguaje->getCadena ( 'capituloLibros' ) => '#',
// $this->lenguaje->getCadena ( 'cartasEditor' ) => '#',
// $this->lenguaje->getCadena ( 'direccionTrabajosGrado' ) => '#',
// $this->lenguaje->getCadena ( 'experienciaDireccionAcademica' ) => '#',
// $this->lenguaje->getCadena ( 'experienciaInvestigacion' ) => '#',
// $this->lenguaje->getCadena ( 'experienciaDocencia' ) => '#',
// $this->lenguaje->getCadena ( 'experienciaProfesional' ) => '#',
// $this->lenguaje->getCadena ( 'experienciaCalificada' ) => '#',
// $this->lenguaje->getCadena ( 'excelenciaAcademica' ) => '#',
// $this->lenguaje->getCadena ( 'revistasindexadas' ) => '#',
// $this->lenguaje->getCadena ( 'comunicacionCorta' ) => '#',
// $this->lenguaje->getCadena ( 'obrasArtisticasDocente' ) => '#',
// $this->lenguaje->getCadena ( 'patentes' ) => '#',
// $this->lenguaje->getCadena ( 'PremiosDocente' ) => '#',
// $this->lenguaje->getCadena ( 'produccionVideosDocente' ) => '#',
// $this->lenguaje->getCadena ( 'produccionLibros' ) => '#',
// $this->lenguaje->getCadena ( 'traducciones' ) => '#',
// $this->lenguaje->getCadena ( 'registroTecnicaSoftware' ) => '#',
// ),
// 'columna2' => array(
// 'title'=>$this->lenguaje->getCadena ( 'tituloBonificacion' ),
// $this->lenguaje->getCadena ( 'crearDocente' ) => '#',
// $this->lenguaje->getCadena ( 'titulosAcademicos' ) => '#',
// $this->lenguaje->getCadena ( 'sinTitulosAcademicos' ) => '#',
// $this->lenguaje->getCadena ( 'consultarActividadDocente' ) => '#',
// ),
// 'columna3' => array(
// 'title'=>$this->lenguaje->getCadena ( 'tituloNovedades' ),
// $this->lenguaje->getCadena ( 'crearDocente' ) => '#',
// $this->lenguaje->getCadena ( 'titulosAcademicos' ) => '#',
// $this->lenguaje->getCadena ( 'sinTitulosAcademicos' ) => '#',
// $this->lenguaje->getCadena ( 'consultarActividadDocente' ) => '#',
// ),
// ),
// );

// $enlaces[$this->lenguaje->getCadena ( 'reportesDocencia' )]=array(
// 'title'=>$this->lenguaje->getCadena ( 'tituloConsultaReportes' ),
// $this->lenguaje->getCadena ( 'consultaReportes' ) => '#',
// $this->lenguaje->getCadena ( 'estadoCuentaDocente' ) => '#',
// );

// $atributos ['enlaces'] = $enlaces;

// $crearMenu = new Dibujar ();
// echo $crearMenu->html ( $atributos );

// ?>
