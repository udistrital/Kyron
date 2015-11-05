<?php
namespace asignacionPuntajes\salariales\produccionVideosDocente\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class FormularioModificar {
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
		
		/*
		 * Se realiza la decodificacion del arreglo "validadorCampos"
		 */
		//$validadorCampos = $this->miFormulario->decodificarCampos($_REQUEST['validadorCampos']);
		
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

		// ---------------- CONTROL: Lista Docente--------------------------------------------------------
		$datos = array(
				'documento_docente' =>  $_REQUEST ['documento_docente'],
				'identificadorProduccionVideo' => $_REQUEST ['identificadorProduccionVideo'],
		
		);
		 
		$cadena_sql = $this->miSql->getCadenaSql ( "publicacionActualizar", $datos );
		$resultadoProduccionVideo = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
		
		$cadena_sql = $this->miSql->getCadenaSql ( "publicacionEvaluadoresActualizar", $resultadoProduccionVideo[0]['id_produccion_video'] );
		$evaluador = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
		
		for($i=0; $i< $resultadoProduccionVideo[0]['numero_evaluadores']; $i++){
			$_REQUEST['nombreEvaluador'.($i+1)] =  $evaluador[$i]['nombre_evaluador'];
			$_REQUEST['universidadEvaluador'.($i+1)] =  $evaluador[$i]['id_universidad'];
			$_REQUEST['puntajeEvaluador'.($i+1)] =  $evaluador[$i]['puntaje'];
		}
		
		$_REQUEST['docenteRegistrar'] =  $resultadoProduccionVideo[0]['documento_docente'] . " - " . $resultadoProduccionVideo[0]['nombre_docente'];
		$_REQUEST['id_docenteRegistrar'] =  $resultadoProduccionVideo[0]['documento_docente'];
		$_REQUEST['tituloVideo'] =  $resultadoProduccionVideo[0]['titulo_video'];
		$_REQUEST['numeroAutores'] =  $resultadoProduccionVideo[0]['numero_autores'];
		$_REQUEST['numeroAutoresUd'] =  $resultadoProduccionVideo[0]['numero_autores_ud'];
		$_REQUEST['fechaRealizacion'] =  $resultadoProduccionVideo[0]['fecha_realizacion'];
		$_REQUEST['impacto'] =  $resultadoProduccionVideo[0]['id_contexto'];
		$_REQUEST['caracter'] =  $resultadoProduccionVideo[0]['id_caracter_video'];
		$_REQUEST['numeroEvaluadores'] = $resultadoProduccionVideo[0]['numero_evaluadores'];
		$_REQUEST['numeroActa'] =  $resultadoProduccionVideo[0]['numero_acta'];
		$_REQUEST['fechaActa'] =  $resultadoProduccionVideo[0]['fecha_acta'];
		$_REQUEST['numeroCasoActa'] =  $resultadoProduccionVideo[0]['caso_acta'];
		$_REQUEST['puntaje'] =  $resultadoProduccionVideo[0]['puntaje'];
		$_REQUEST['normatividad'] =  $resultadoProduccionVideo[0]['normatividad'];
		
		$esteCampo = "marcoModificarRegistro";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		$atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		
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
				$atributos ['deshabilitado'] = true;
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
					
				
				// ----------------INICIO CONTROL: Campo de Texto Titulo del Video--------------------------------------------------------
				$esteCampo = 'tituloVideo';
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
				// ----------------FIN CONTROL: Campo de Texto Titulo del Video--------------------------------------------------------
					
				// ----------------INICIO CONTROL: Campo de Texto Número De Autores del Video--------------------------------------------------------
				$esteCampo = 'numeroAutores';
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
				$atributos ['validar'] = 'required, custom[onlyNumberSp], maxSize[2]';
					
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = '';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 57;
				$atributos ['maximoTamanno'] = '2';
				$atributos ['anchoEtiqueta'] = 280;
				$tab ++;
					
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				// ----------------FIN CONTROL: Campo de Texto Número  De Autores del Video--------------------------------------------------------
						
				// ----------------INICIO CONTROL: Campo de Texto Número De Autores del Video Pertenecientes a la UD--------------------------------------------------------
				$esteCampo = 'numeroAutoresUd';
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
				$atributos ['validar'] = 'required, custom[onlyNumberSp], maxSize[2]';
					
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = '';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 57;
				$atributos ['maximoTamanno'] = '2';
				$atributos ['anchoEtiqueta'] = 280;
				$tab ++;
					
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				// ----------------FIN CONTROL: Campo de Texto Número  De Autores del Video Pertenecientes a la UD--------------------------------------------------------
				
				// ----------------INICIO CONTROL: Campo de Texto Fecha de Realización del Video--------------------------------------------------------
				$esteCampo = 'fechaRealizacion';
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
				// ----------------FIN CONTROL: Campo de Texto Fecha de Realización del Video--------------------------------------------------------
						
				// ----------------INICIO CONTROL: Campo de Texto Impacto del Video Realizado--------------------------------------------------------
				$esteCampo = 'impacto';
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
				$atributos ['cadena_sql'] = $cadenaSql = $this->miSql->getCadenaSql ( 'contexto' );
				$matrizItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
				$atributos ['matrizItems'] = $matrizItems;
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroLista ( $atributos );
				unset ( $atributos );
				// ----------------FIN CONTROL: Campo de Texto Impacto del Video Realizado--------------------------------------------------------
					
				// ---------------- CONTROL: Lista Caracter del Video Realizado--------------------------------------------------------
				$esteCampo = "caracter";
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
				$atributos ['cadena_sql'] = $cadenaSql = $this->miSql->getCadenaSql ( 'caracter' );
				$matrizItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
				$atributos ['matrizItems'] = $matrizItems;
					
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroLista ( $atributos );
				unset ( $atributos );
				// ----------------FIN CONTROL: Lista Caracter del Video Realizado--------------------------------------------------------
						
				$esteCampo = "marcoEvaluadores";
				$atributos ['id'] = $esteCampo;
				$atributos ["estilo"] = "jqueryui";
				$atributos ['tipoEtiqueta'] = 'inicio';
				$atributos ["leyenda"] = "Evaluadores del Video Producido por el Docente";
				echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
				unset($atributos);
				
				for($i=1; $i<=3; $i++){
				
					$esteCampo = "marcoEvaluador" . $i;
					$atributos ['id'] = $esteCampo;
					$atributos ["estilo"] = "jqueryui";
					$atributos ['tipoEtiqueta'] = 'inicio';
					$atributos ["leyenda"] = "Evaluador " . $i;
					echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
					unset($atributos);
						
					// ----------------INICIO CONTROL: Eliminar Evaluador --------------------------------------------------------
					$esteCampo = "botonEliminar" . $i;
					$atributos ["id"] = $esteCampo;
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["borde"] = 0;
					$atributos ["ancho"] = 20;
					$atributos ["alto"] = 20;
					$atributos ["etiqueta"] = "Eliminar";
					$atributos ["imagen"] = $rutaBloque . "/imagenes/add_list_256_modificado.png";
					$atributos ["alineacion"] = "right";
					$atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
					$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
					echo $this->miFormulario->campoImagen ( $atributos );
					unset ( $atributos );
					// ----------------FIN CONTROL: Eliminar Evaluador --------------------------------------------------------
				
						// ----------------INICIO CONTROL: Campo de Texto Nombre del Evaluador --------------------------------------------------------
						$esteCampo = 'nombreEvaluador' . $i;
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
						$atributos ['validar'] = "";
						if (isset ( $_REQUEST [$esteCampo] )) {
							$atributos ['valor'] = $_REQUEST [$esteCampo];
						} else {
							$atributos ['valor'] = '';
						}
						$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
						$atributos ['deshabilitado'] = false;
						$atributos ['tamanno'] = 57;
						$atributos ['maximoTamanno'] = '';
						$atributos ['anchoEtiqueta'] = 250;
						$tab ++;
							
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						//var_dump($atributos);
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						// ----------------FIN CONTROL: Campo de Texto Nombre del Evaluador --------------------------------------------------------
					
						// ----------------INICIO CONTROL: Campo de Texto Entidad o institucion a la que pertenece el evaluador--------------------------------------------------------
						$esteCampo = 'universidadEvaluador' . $i;
						$atributos ['nombre'] = $esteCampo;
						$atributos ['id'] = $esteCampo;
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ["etiquetaObligatorio"] = true;
						$atributos ['tab'] = $tab ++;
						$atributos ['anchoEtiqueta'] = 250;
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
						$atributos ['validar'] = "";
						$atributos ['limitar'] = false;
						$atributos ['anchoCaja'] = 60;
						$atributos ['miEvento'] = '';
						$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "universidad_evaluador" );
						$matrizItems = array (
								array (
										0,
										' '
								)
						);
						$matrizItems = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
							
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroLista ( $atributos );
						unset ( $atributos );
						// ----------------FIN CONTROL: Campo de Texto Entidad o institucion a la que pertenece el evaluador--------------------------------------------------------
										
						
						// ----------------INICIO CONTROL: Campo de Puntaje sugerido por Evaluador--------------------------------------------------------
						$esteCampo = 'puntajeEvaluador' . $i;
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
						$atributos ['validar'] = 'min[0.1], max[15], custom[number]';
						if (isset ( $_REQUEST [$esteCampo] )) {
							$atributos ['valor'] = $_REQUEST [$esteCampo];
						} else {
							$atributos ['valor'] = '';
						}
						$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
						$atributos ['deshabilitado'] = false;
						$atributos ['tamanno'] = 57;
						$atributos ['maximoTamanno'] = '6';
						$atributos ['anchoEtiqueta'] = 250;
						$tab ++;
							
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						//var_dump($atributos);
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						// ----------------FIN CONTROL: Campo de Texto Entidad o institucion a la que pertenece el evaluador--------------------------------------------------------
						
				
						echo $this->miFormulario->marcoAgrupacion ( 'fin' );
							
						}
						
						// -------------INICIO CONTROl: Imagen Agregar Evaluador-----------------------
					$esteCampo = "botonAgregar";
					$atributos ["id"] = $esteCampo;
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["borde"] = 0;
					$atributos ["ancho"] = 20;
					$atributos ["alto"] = 20;
					$atributos ["etiqueta"] = "Agregar";
					$atributos ["imagen"] = $rutaBloque . "/imagenes/add_list_256.png";
					echo $this->miFormulario->campoImagen ( $atributos );
					unset ( $atributos );
						// -------------FIN CONTROL: Imagen Agregar Evaluador----------------------
						
					echo $this->miFormulario->marcoAgrupacion ( 'fin' );
						
						
				
				// ----------------INICIO CONTROL: Campo de Texto Número Acta de Producción de Video-------------------------------------------------------
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
				// ----------------FIN CONTROL: Campo de Texto Numero Acta de Producción de Video--------------------------------------------------------
					
				// ----------------INICIO CONTROL: Campo de Texto Fecha Acta de Producción de Video--------------------------------------------------------
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
				// ----------------FIN CONTROL: Campo de Texto Fecha Acta de Producción de Video--------------------------------------------------------
					
				// ----------------INICIO CONTROL: Campo de Texto Número Caso Acta de Producción de Video--------------------------------------------------------
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
				// ----------------FIN CONTROL: Campo de Texto Número Caso Acta de Producción de Video--------------------------------------------------------
					
				// ----------------INICIO CONTROL: Campo de Texto Puntaje de asignado a la Producción de Video--------------------------------------------------------
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
				$atributos ['validar'] = 'required, custom[number]';
					
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
			// ----------------FIN CONTROL: Campo de Texto Puntaje  asignado a la Producción de Video--------------------------------------------------------
			
				// ----------------INICIO CONTROL: Campo de Texto Normatividad--------------------------------------------------------
				$esteCampo = 'normatividad';
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ['columnas'] = 1;
				$atributos ['dobleLinea'] = 0;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'maxSize[200]';
					
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = '';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 57;
				$atributos ['maximoTamanno'] = '10';
				$atributos ['anchoEtiqueta'] = 280;
				$tab ++;
					
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				// ----------------FIN CONTROL: Campo de Texto Fecha de Normatividad--------------------------------------------------------
				
				// ------------------Division para los botones-------------------------
				$atributos ["id"] = "botones";
				$atributos ["estilo"] = "marcoBotones";
				echo $this->miFormulario->division ( "inicio", $atributos );
				{
					// -----------------CONTROL: Botón ----------------------------------------------------------------
					$esteCampo = 'botonRegresar';
					$atributos ["id"] = $esteCampo;
					$atributos ["tabIndex"] = $tab;
					$atributos ["tipo"] = 'boton';
					// submit: no se coloca si se desea un tipo button genérico
					$atributos ['submit'] = 'false';
					$atributos ["estiloMarco"] = '';
					$atributos ["estiloBoton"] = 'jqueryui';
					// verificar: true para verificar el formulario antes de pasarlo al servidor.
					$atributos ["verificar"] = '';
					$atributos ["tipoSubmit"] = ''; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
					$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['nombreFormulario'] = $esteBloque ['nombre']."Registrar";
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoBoton ( $atributos );
					unset($atributos);
					
					$esteCampo = 'botonGuardar';
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
					unset($atributos);
					
					// -----------------FIN CONTROL: Botón -----------------------------------------------------------
				}
	// 			------------------Fin Division para los botones-------------------------
	
			echo $this->miFormulario->marcoAgrupacion ( 'fin' );
				
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
				$valorCodificado .= "&opcion=actualizar";
				$valorCodificado .= "&arreglo=".$_REQUEST['arreglo'];
				$valorCodificado .= "&identificadorProduccionVideo=".$_REQUEST['identificadorProduccionVideo'];
				
				/*
				 * Sara permite validar los campos en el formulario o funcion destino.
				 * Para ello se envía los datos atributos["validadar"] de los componentes del formulario
				 * Estos se pueden obtener en el atributo $this->miFormulario->validadorCampos del formulario
				 * La función $this->miFormulario->codificarCampos() codifica automáticamente el atributo validadorCampos
				 */
				$valorCodificado .= "&validadorCampos=" . $this->miFormulario->codificarCampos();				
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


$miFormulario = new FormularioModificar ( $this->lenguaje, $this->miFormulario, $this->sql  );

$miFormulario->formulario ();
$miFormulario->mensaje ();
?>
