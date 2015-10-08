<?php
namespace hojaDeVida\titulosAcademicos\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class FormularioRegistro {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	
	function __construct($lenguaje, $formulario, $sql) {
		
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		$this->miSql = $sql;		
	}
	
	function formulario() {
		
		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */
		
		$conexion = "docencia";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
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
		$esteCampo = $esteBloque ['nombre']."Registrar";
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		
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
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		
		$atributos ['tipoEtiqueta'] = 'inicio';
				// Aplica atributos globales al control
		echo $this->miFormulario->formulario ( $atributos );

		// ---------------- CONTROL: Lista Docente--------------------------------------------------------
		
		$esteCampo = 'docenteRegistrar';
			
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'text';
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['columnas'] = 1;
		$atributos ['dobleLinea'] = 0;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['validar'] = 'required, maxSize[200]';
		$atributos ['textoFondo'] = 'Ingrese Mínimo 3 Caracteres de Búsqueda';
			
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 80;
		$atributos ['maximoTamanno'] = '200';
		$atributos ['anchoEtiqueta'] = 280;
		$tab ++;
			
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
			
		$esteCampo = 'id_docenteRegistrar';
		$atributos ["id"] = $esteCampo; // No cambiar este nombre
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ['validar'] = '';//decia required
		$atributos ["obligatorio"] = true;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ----------------FIN CONTROL: Lista Docente--------------------------------------------------------
			
		// ----------------INICIO CONTROL: Lista Tipo de Patente--------------------------------------------------------
			
		$esteCampo = 'tipoPatente';
		$atributos ['nombre'] = $esteCampo;
		$atributos ['id'] = $esteCampo;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['tab'] = $tab ++;
		$atributos ['anchoEtiqueta'] = 280;
		$atributos ['evento'] = '';
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['seleccion'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['seleccion'] = - 1;
		}
		$atributos ['deshabilitado'] = false;
		$atributos ['columnas'] = 1;
		$atributos ['tamanno'] = 1;
		$atributos ['ajax_function'] = "";
		$atributos ['ajax_control'] = $esteCampo;
		$atributos ['estilo'] = "jqueryui";
		$atributos ['limitar'] = true;
		$atributos ['anchoCaja'] = 57;
		$atributos ['miEvento'] = '';
		$atributos ['validar'] = 'required';
		$atributos ['cadena_sql'] = $cadenaSql = $this->miSql->getCadenaSql ( 'tipo_patente' );
		$matrizItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		$atributos ['matrizItems'] = $matrizItems;
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
			
		// ----------------FIN CONTROL: Lista Tipo de Patente--------------------------------------------------------
				
		// ----------------INICIO CONTROL: Campo de Texto Título de Patente--------------------------------------------------------
		$esteCampo = 'tituloPatente';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'text';
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['columnas'] = 1;
		$atributos ['dobleLinea'] = 0;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['validar'] = 'required, minSize[6],maxSize[50]';
			
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 57;
		$atributos ['maximoTamanno'] = '50';
		$atributos ['anchoEtiqueta'] = 280;
		$tab ++;
			
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		// ----------------FIN CONTROL: Campo de Texto Título de Patente--------------------------------------------------------
				
		// ---------------- CONTROL: Lista Entidad Patente--------------------------------------------------------
			
		$esteCampo = "entidadPatente";
		$atributos ['nombre'] = $esteCampo;
		$atributos ['id'] = $esteCampo;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['tab'] = $tab ++;
		$atributos ['anchoEtiqueta'] = 280;
		$atributos ['evento'] = '';
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['seleccion'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['seleccion'] = - 1;
		}
		$atributos ['deshabilitado'] = false;
		$atributos ['columnas'] = 1;
		$atributos ['tamanno'] = 1;
		$atributos ['ajax_function'] = "";
		$atributos ['ajax_control'] = $esteCampo;
		$atributos ['estilo'] = "jqueryui";
		$atributos ['validar'] = "required";
		$atributos ['limitar'] = false;
		$atributos ['anchoCaja'] = 60;
		$atributos ['miEvento'] = '';
		$atributos ['cadena_sql'] = $cadenaSql = $this->miSql->getCadenaSql ( 'entidadInstitucion' );
		$matrizItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		$atributos ['matrizItems'] = $matrizItems;
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		// ----------------FIN CONTROL: Lista Entidad Patente--------------------------------------------------------

		// ---------------- CONTROL: Lista País--------------------------------------------------------
			
		$esteCampo = "pais";
		$atributos ['nombre'] = $esteCampo;
		$atributos ['id'] = $esteCampo;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['tab'] = $tab ++;
		$atributos ['anchoEtiqueta'] = 280;
		$atributos ['evento'] = '';
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['seleccion'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['seleccion'] = - 1;
		}
		$atributos ['deshabilitado'] = false;
		$atributos ['columnas'] = 1;
		$atributos ['tamanno'] = 1;
		$atributos ['ajax_function'] = "";
		$atributos ['ajax_control'] = $esteCampo;
		$atributos ['estilo'] = "jqueryui";
		$atributos ['validar'] = "required";
		$atributos ['limitar'] = false;
		$atributos ['anchoCaja'] = 60;
		$atributos ['miEvento'] = '';
		$atributos ['cadena_sql'] = $cadenaSql = $this->miSql->getCadenaSql ( 'pais' );
		$matrizItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		$atributos ['matrizItems'] = $matrizItems;
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
			
		// ----------------FIN CONTROL: Lista País--------------------------------------------------------
				
		// ----------------INICIO CONTROL: Campo de Texto Año de Registro de Patente--------------------------------------------------------
		
		$esteCampo = "anno";
		$atributos ['nombre'] = $esteCampo;
		$atributos ['id'] = $esteCampo;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['tab'] = $tab ++;
		$atributos ['anchoEtiqueta'] = 280;
		$atributos ['evento'] = '';
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['seleccion'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['seleccion'] = 0;
		}
		$atributos ['deshabilitado'] = false;
		$atributos ['columnas'] = 1;
		$atributos ['tamanno'] = 1;
		$atributos ['ajax_function'] = "";
		$atributos ['ajax_control'] = $esteCampo;
		$atributos ['estilo'] = "jqueryui";
		$atributos ['validar'] = "required";
		$atributos ['limitar'] = false;
		$atributos ['anchoCaja'] = 60;
		$atributos ['miEvento'] = '';
		
		$matrizItems = array();
		 
		for($i=date ("Y"); $i >= date ("Y")-50;   $i--){
			$anno = array(
				$i,
				$i	
			);
			array_push($matrizItems, $anno);
		}
		
		$atributos ['matrizItems'] = $matrizItems;
			
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		// ----------------FIN CONTROL: Campo de Texto Año de Registro de Patente--------------------------------------------------------
			
		// ----------------INICIO CONTROL: Campo de Texto Concepto Patente--------------------------------------------------------
		
		$esteCampo = 'conceptoPatente'; 
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'text';
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['columnas'] = 1;
		$atributos ['dobleLinea'] = 0;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['validar'] = 'required, minSize[10],maxSize[30]';
			
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 57;
		$atributos ['maximoTamanno'] = '30';
		$atributos ['anchoEtiqueta'] = 280;
		$tab ++;
			
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		// ----------------FIN CONTROL: Campo de Texto Concepto Patente--------------------------------------------------------

		// ----------------INICIO CONTROL: Campo de Texto Número de Registro de Patente--------------------------------------------------------
		$esteCampo = 'numeroRegistro';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'text';
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['columnas'] = 1;
		$atributos ['dobleLinea'] = 0;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['validar'] = 'required, custom[onlyNumberSp], maxSize[15]';
			
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 57;
		$atributos ['maximoTamanno'] = '15';
		$atributos ['anchoEtiqueta'] = 280;
		$tab ++;
			
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		// ----------------FIN CONTROL: Campo de Texto Número de Registro de Patente--------------------------------------------------------
			
		// ----------------INICIO CONTROL: Campo de Texto Número Acta Patente--------------------------------------------------------
		$esteCampo = 'numeroActa';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'text';
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['columnas'] = 1;
		$atributos ['dobleLinea'] = 0;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['validar'] = 'required, maxSize[15]';
			
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 57;
		$atributos ['maximoTamanno'] = '15';
		$atributos ['anchoEtiqueta'] = 280;
		$tab ++;
			
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		// ----------------FIN CONTROL: Campo de Texto Numero Acta Patente--------------------------------------------------------
			
		// ----------------INICIO CONTROL: Campo de Texto Fecha Acta Patente--------------------------------------------------------
		$esteCampo = 'fechaActa';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'text';
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['columnas'] = 1;
		$atributos ['dobleLinea'] = 0;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['validar'] = 'required, custom[date]';
			
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = true;
		$atributos ['tamanno'] = 57;
		$atributos ['maximoTamanno'] = '';
		$atributos ['anchoEtiqueta'] = 280;
		$tab ++;
			
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		// ----------------FIN CONTROL: Campo de Texto Fecha Acta Patente--------------------------------------------------------
			
		// ----------------INICIO CONTROL: Campo de Texto Número Caso Acta Patente--------------------------------------------------------
		$esteCampo = 'numeroCasoActa';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'text';
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['columnas'] = 1;
		$atributos ['dobleLinea'] = 0;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['validar'] = 'required, custom[onlyNumberSp], maxSize[6]';
			
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 57;
		$atributos ['maximoTamanno'] = '6';
		$atributos ['anchoEtiqueta'] = 280;
		$tab ++;
			
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		// ----------------FIN CONTROL: Campo de Texto Número Caso Acta Patente--------------------------------------------------------
			
		// ----------------INICIO CONTROL: Campo de Texto Puntaje Patente--------------------------------------------------------
		$esteCampo = 'puntaje';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'text';
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['columnas'] = 1;
		$atributos ['dobleLinea'] = 0;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['validar'] = 'required, min[0.1], custom[number]';
			
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 57;
		$atributos ['maximoTamanno'] = '4';
		$atributos ['anchoEtiqueta'] = 280;
		$tab ++;
			
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		// ----------------FIN CONTROL: Campo de Texto Puntaje Patente--------------------------------------------------------
		
				
				// ------------------Division para los botones-------------------------
				$atributos ["id"] = "botones";
				$atributos ["estilo"] = "marcoBotones";
				echo $this->miFormulario->division ( "inicio", $atributos );
				{
					// -----------------CONTROL: Botón ----------------------------------------------------------------
					$esteCampo = 'botonRegistrar';
					$atributos ["id"] = $esteCampo;
					$atributos ["tabIndex"] = $tab;
					$atributos ["tipo"] = 'boton';
					// submit: no se coloca si se desea un tipo button genérico
					$atributos ['submit'] = 'true';
					$atributos ["estiloMarco"] = '';
					$atributos ["estiloBoton"] = 'jqueryui';
					// verificar: true para verificar el formulario antes de pasarlo al servidor.
					$atributos ["verificar"] = '';
					$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
					$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['nombreFormulario'] = $esteBloque ['nombre']."Registrar";
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoBoton ( $atributos );
					
					// -----------------FIN CONTROL: Botón -----------------------------------------------------------
				}
	// 			------------------Fin Division para los botones-------------------------
				echo $this->miFormulario->division( "fin" );
				
				
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
				
				$valorCodificado  = "action=" . $esteBloque ["nombre"];
				$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
				$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
				$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
				$valorCodificado .= "&opcion=registrar";
				
				/**
				 * SARA permite que los nombres de los campos sean dinámicos.
				 * Para ello utiliza la hora en que es creado el formulario para
				 * codificar el nombre de cada campo.
				 */
				$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
				$valorCodificado .= "&tiempo=" . time();
				/*
				 * Sara permite validar los campos en el formulario o funcion destino.
				 * Para ello se envía los datos atributos["validadar"] de los componentes del formulario
				 * Estos se pueden obtener en el atributo $this->miFormulario->validadorCampos del formulario
				 * La función $this->miFormulario->codificarCampos() codifica automáticamente el atributo validadorCampos
				 */
				$valorCodificado .= "&validadorCampos=" . $this->miFormulario->codificarCampos();
				
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
				
				$atributos ['marco'] = true;
				$atributos ['tipoEtiqueta'] = 'fin';
				echo $this->miFormulario->formulario ( $atributos );
								
				// ----------------FIN SECCION: Paso de variables -------------------------------------------------
				// ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
			// ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
			// Se debe declarar el mismo atributo de marco con que se inició el formulario.
		
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
			$atributos ["etiqueta"] = '';
			$atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
			echo $this->miFormulario->campoMensaje ( $atributos );
			unset ( $atributos );
		}
		
		return true;
	}
}


$miFormulario = new FormularioRegistro ( $this->lenguaje, $this->miFormulario, $this->sql  );

$miFormulario->formulario ();
$miFormulario->mensaje ();
?>
