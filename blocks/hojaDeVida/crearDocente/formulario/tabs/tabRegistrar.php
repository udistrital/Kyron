<?php
namespace asignacionPuntajes\salariales\experienciaDireccionAcademica\formulario;

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
		$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
			
		$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
			
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
		$rutaBloque .= $esteBloque ['grupo'] . '/' . $esteBloque ['nombre'];
		
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

		// ----------------INICIO CONTROL: Lista Tipo de Documento--------------------------------------------------------
			$esteCampo = 'tipoDocumento';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ["etiquetaObligatorio"] = true;
			$atributos ['tab'] = $tab ++;
			$atributos ['anchoEtiqueta'] = 310;
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
			$atributos ['cadena_sql'] = $cadenaSql = $this->miSql->getCadenaSql ( 'tipo_documento' );
			$matrizItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
			$atributos ['matrizItems'] = $matrizItems;
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroLista ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Lista Tipo de Documento--------------------------------------------------------
				
			// ----------------INICIO CONTROL: Campo de Texto Número de identificación del Funcionario--------------------------------------------------------
			
			$esteCampo = 'identificacionDocente';
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
			$atributos ['validar'] = 'required, minSize[8],maxSize[30],custom[onlyNumberSp]';
				
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 57;
			$atributos ['maximoTamanno'] = '30';
			$atributos ['anchoEtiqueta'] = 310;
			$tab ++;
				
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Campo de Texto Número de identificación del Funcionario--------------------------------------------------------
		
			$esteCampo = "marcoLugarExpedicion";
			$atributos ['id'] = $esteCampo;
			$atributos ["estilo"] = "jqueryui";
			$atributos ['tipoEtiqueta'] = 'inicio';
			$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
			echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
			
				// ---------------- CONTROL: Lista País--------------------------------------------------------
					$esteCampo = "pais";
					$atributos ['nombre'] = $esteCampo;
					$atributos ['id'] = $esteCampo;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ['tab'] = $tab ++;
					$atributos ['anchoEtiqueta'] = 200;
					$atributos ['evento'] = '';
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['seleccion'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['seleccion'] = 'COL';
					}
					$atributos ['deshabilitado'] = true;
					$atributos ['columnas'] = 2;
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
					
					// ---------------- CONTROL: Lista País--------------------------------------------------------
					$esteCampo = "ciudad";
					$atributos ['nombre'] = $esteCampo;
					$atributos ['id'] = $esteCampo;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ['tab'] = $tab ++;
					$atributos ['anchoEtiqueta'] = 200;
					$atributos ['evento'] = '';
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['seleccion'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['seleccion'] = - 1;
					}
					$atributos ['deshabilitado'] = false;
					$atributos ['columnas'] = 2;
					$atributos ['tamanno'] = 1;
					$atributos ['ajax_function'] = "";
					$atributos ['ajax_control'] = $esteCampo;
					$atributos ['estilo'] = "jqueryui";
					$atributos ['validar'] = "required";
					$atributos ['limitar'] = false;
					$atributos ['anchoCaja'] = 60;
					$atributos ['miEvento'] = '';
					$atributos ['cadena_sql'] = $cadenaSql = $this->miSql->getCadenaSql ( 'ciudad', 'COL' );
					$matrizItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
					$atributos ['matrizItems'] = $matrizItems;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
				// ----------------FIN CONTROL: Lista Ciudad--------------------------------------------------------
					
			echo $this->miFormulario->marcoAgrupacion ( 'fin' );
			
			$esteCampo = "marcoNombre";
			$atributos ['id'] = $esteCampo;
			$atributos ["estilo"] = "jqueryui";
			$atributos ['tipoEtiqueta'] = 'inicio';
			$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
			echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
			
				// ----------------INICIO CONTROL: Campo de Texto Primer Nombre del Docente--------------------------------------------------------
				$esteCampo = 'primerNombre';
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['columnas'] = 2;
				$atributos ['dobleLinea'] = 0;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'required, minSize[1],maxSize[30],custom[onlyLetterNumber]';
				
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = '';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 40;
				$atributos ['maximoTamanno'] = '30';
				$atributos ['anchoEtiqueta'] = 200;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				// ----------------FIN CONTROL: Campo de Texto Primer Nombre del Docente--------------------------------------------------------
				
				// ----------------INICIO CONTROL: Campo de Texto Segundo Nombre del Docente--------------------------------------------------------
				
				$esteCampo = 'segundoNombre';
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ['columnas'] = 2;
				$atributos ['dobleLinea'] = 0;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'minSize[1],maxSize[30],custom[onlyLetterNumber]';
					
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = '';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 40;
				$atributos ['maximoTamanno'] = '30';
				$atributos ['anchoEtiqueta'] = 200;
				$tab ++;
					
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				// ----------------FIN CONTROL: Campo de Texto Segundo Nombre del Docente--------------------------------------------------------
				
				// ----------------INICIO CONTROL: Campo de Texto Primer Apellido del Docente--------------------------------------------------------
					
				$esteCampo = 'primerApellido';
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['columnas'] = 2;
				$atributos ['dobleLinea'] = 0;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'required, minSize[1],maxSize[30],custom[onlyLetterNumber]';
				
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = '';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 40;
				$atributos ['maximoTamanno'] = '30';
				$atributos ['anchoEtiqueta'] = 200;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				// ----------------FIN CONTROL: Campo de Texto Primer Apellido del Docente--------------------------------------------------------
							
				// ----------------INICIO CONTROL: Campo de Texto Segundo Apellido del Docente--------------------------------------------------------
					
				$esteCampo = 'segundoApellido';
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ['columnas'] = 2;
				$atributos ['dobleLinea'] = 0;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'minSize[1],maxSize[30],custom[onlyLetterNumber]';
				
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = '';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 40;
				$atributos ['maximoTamanno'] = '30';
				$atributos ['anchoEtiqueta'] = 200;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				// ----------------FIN CONTROL: Campo de Texto Segundo Apellido del Docente--------------------------------------------------------
						
			echo $this->miFormulario->marcoAgrupacion ( 'fin' );
				
			// ----------------INICIO CONTROL: Campo de Texto Fecha de Ingreso--------------------------------------------------------
			$esteCampo = 'fechaIngreso';
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
			$atributos ['anchoEtiqueta'] = 305;
			$tab ++;
				
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Campo de Texto Fecha de Ingreso--------------------------------------------------------
					
			// ----------------INICIO CONTROL: Campo de Texto Resolución de Nombramiento--------------------------------------------------------
			$esteCampo = 'resolucion';
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
			$atributos ['anchoEtiqueta'] = 305;
			$tab ++;
				
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Campo de Texto Resolución de Nombramiento--------------------------------------------------------
					
			// ----------------INICIO CONTROL: Lista Tipo de Dedicación--------------------------------------------------------
			$esteCampo = 'dedicacion';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ["etiquetaObligatorio"] = true;
			$atributos ['tab'] = $tab ++;
			$atributos ['anchoEtiqueta'] = 305;
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
			$atributos ['cadena_sql'] = $cadenaSql = $this->miSql->getCadenaSql ( 'tipo_dedicacion' );
			$matrizItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
			$atributos ['matrizItems'] = $matrizItems;
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroLista ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Lista Tipo de Dedicación--------------------------------------------------------
			
			// ----------------INICIO CONTROL: Lista Categoria Actual del Docente--------------------------------------------------------
			$esteCampo = 'categoriaActualDocente';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ["etiquetaObligatorio"] = true;
			$atributos ['tab'] = $tab ++;
			$atributos ['anchoEtiqueta'] = 305;
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
			$atributos ['cadena_sql'] = $cadenaSql = $this->miSql->getCadenaSql ( 'categoria_actual_docente' );
			$matrizItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
			$atributos ['matrizItems'] = $matrizItems;
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroLista ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Lista Categoria Actual del Docente--------------------------------------------------------			
			
			// ----------------INICIO CONTROL: Lista Facultad--------------------------------------------------------
			$esteCampo = 'facultad';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ["etiquetaObligatorio"] = true;
			$atributos ['tab'] = $tab ++;
			$atributos ['anchoEtiqueta'] = 305;
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
			$atributos ['cadena_sql'] = $cadenaSql = $this->miSql->getCadenaSql ( 'facultad' );
			$matrizItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
			$atributos ['matrizItems'] = $matrizItems;
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroLista ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Lista Facultad--------------------------------------------------------
				
			// ----------------INICIO CONTROL: Lista Proyecto Curricular--------------------------------------------------------
			$esteCampo = 'proyectoCurricular';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ["etiquetaObligatorio"] = true;
			$atributos ['tab'] = $tab ++;
			$atributos ['anchoEtiqueta'] = 305;
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
			$atributos ['cadena_sql'] = $cadenaSql = $this->miSql->getCadenaSql ( 'proyectoCurricular' );
			$matrizItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
			$atributos ['matrizItems'] = $matrizItems;
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroLista ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Lista  Proyecto Curricular--------------------------------------------------------
					
			// ----------------INICIO CONTROL: Campo de Texto Correo Institucional--------------------------------------------------------
			$esteCampo = 'correoInstitucional';
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
			$atributos ['validar'] = 'required, custom[email], maxSize[40]';
				
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 57;
			$atributos ['maximoTamanno'] = '15';
			$atributos ['anchoEtiqueta'] = 305;
			$tab ++;
				
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Campo de Texto Correo Institucional--------------------------------------------------------
					
			// ----------------INICIO CONTROL: Campo de Texto Correo Institucional--------------------------------------------------------
			$esteCampo = 'correoPersonal';
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
			$atributos ['validar'] = 'required, custom[email], maxSize[40]';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 57;
			$atributos ['maximoTamanno'] = '15';
			$atributos ['anchoEtiqueta'] = 305;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Campo de Texto Correo Institucional--------------------------------------------------------
						
			// ----------------INICIO CONTROL: Campo de Texto Dirección de Residencia--------------------------------------------------------
			$esteCampo = 'direccionResidencia';
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
			$atributos ['validar'] = 'required,minSize[1],maxSize[30],custom[onlyLetterNumber]';
				
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 57;
			$atributos ['maximoTamanno'] = '30';
			$atributos ['anchoEtiqueta'] = 305;
			$tab ++;
				
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Campo de Texto Dirección de Residencia--------------------------------------------------------
						
			// ----------------INICIO CONTROL: Campo de Texto Número telefonico docente--------------------------------------------------------
			$esteCampo = 'telefonoDocente';
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
			$atributos ['validar'] = 'required,minSize[6],maxSize[10],custom[onlyNumberSp]';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 57;
			$atributos ['maximoTamanno'] = '10';
			$atributos ['anchoEtiqueta'] = 305;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Campo de Texto Número telefonico docente--------------------------------------------------------
			
			// ----------------INICIO CONTROL: Campo de Texto Número Celular Docente--------------------------------------------------------
			$esteCampo = 'celularDocente';
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
			$atributos ['validar'] = 'required,minSize[10],maxSize[10],custom[onlyNumberSp]';
				
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 57;
			$atributos ['maximoTamanno'] = '10';
			$atributos ['anchoEtiqueta'] = 305;
			$tab ++;
				
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Campo de Texto Número Celular Docente--------------------------------------------------------
			
			// ----------------INICIO CONTROL: Campo de Texto Número Acta--------------------------------------------------------
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
			$atributos ['validar'] = 'required, maxSize[15],custom[onlyLetterNumber]';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 57;
			$atributos ['maximoTamanno'] = '15';
			$atributos ['anchoEtiqueta'] = 305;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Campo de Texto Numero Acta--------------------------------------------------------
			
			// ----------------INICIO CONTROL: Campo de Texto Fecha Acta--------------------------------------------------------
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
			$atributos ['anchoEtiqueta'] = 305;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Campo de Texto Fecha Acta--------------------------------------------------------
			
			// ----------------INICIO CONTROL: Campo de Texto Número Caso Acta--------------------------------------------------------
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
			$atributos ['anchoEtiqueta'] = 305;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// ----------------FIN CONTROL: Campo de Texto Número Caso Acta--------------------------------------------------------
					
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
			$atributos ['nombreFormulario'] = $esteBloque ['nombre'] . "Registrar";
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
