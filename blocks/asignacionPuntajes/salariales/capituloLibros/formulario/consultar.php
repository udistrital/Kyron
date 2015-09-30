<?php

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

class registrarForm {
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
	function miForm() {
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		
		$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
		
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
		$rutaBloque .= $esteBloque ['grupo'] ."/". $esteBloque ['nombre'];
		
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
		
		// -------------------------------------------------------------------------------------------------
		$conexion = "docencia";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
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
		
		$arreglo = array (
				'documento_docente' => $_REQUEST ['id_docente'],
				'id_facultad' =>$_REQUEST ['facultad'],
				'id_proyectocurricular' =>$_REQUEST ['proyectoCurricular'] 
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'consultarCapituloLibro', $arreglo );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		
		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = 'multipart/form-data';
		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';
		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		// $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		

		$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
			
		$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
			
		$variable = "pagina=" . $miPaginaActual;
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $directorio );
			
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		$esteCampo = 'botonRegresar';
		$atributos ['id'] = $esteCampo;
		$atributos ['enlace'] = $variable;
		$atributos ['tabIndex'] = 1;
		$atributos ['estilo'] = 'textoSubtitulo';
		$atributos ['enlaceTexto'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['ancho'] = '10%';
		$atributos ['alto'] = '10%';
		$atributos ['redirLugar'] = true;
		echo $this->miFormulario->enlace ( $atributos );
			
		unset ( $atributos );
		
				if ($resultado) {
					
					$esteCampo = "marcoDatosBasicos";
					$atributos ['id'] = $esteCampo;
					$atributos ["estilo"] = "jqueryui";
					$atributos ['tipoEtiqueta'] = 'inicio';
					$atributos ["leyenda"] = "Revistas Indexadas";					
					echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
					
					echo "<table id='tablaTitulos'>";
					
					echo "<thead>
	                <tr>
	                   
	                    <th>Identificación</th>
	                    <th>Nombres y Apellidos</th>
						<th>Título Capítulo</th>
						<th>Título Libro</th>
						<th>Tipo Libro</th>
						<th>Código ISBN</th>
						<th>Editorial</th>
						<th>Año Publicación</th>
						<th>Volumen</th>
						<th>Número Autores Capítulo</th>
						<th>Números Autores Capítulo UD</th>
						<th>Número Autores Libro</th>
						<th>Números Autores Libro UD</th>
						<th>Número Acta</th>
						<th>Fecha Acta</th>
						<th>Número Caso</th>
						<th>Puntaje</th>
						<th>Modificar</th>
	                </tr>
	            </thead>
	            <tbody>";
					
					for($i = 0; $i < count ( $resultado ); $i ++) {
						$variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
						$variable .= "&opcion=modificar";
						// $variable .= "&usuario=" . $miSesion->getSesionUsuarioId ();
						$variable .= "&documento_docente=" . $resultado [$i] ['documento_docente'];
						$variable .= "&codigo_isbn=" . $resultado [$i] ['codigo_isbn'];
						$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $directorio );
						
						$mostrarHtml = "<tr>
	                    <td><center>" . $resultado [$i] ['documento_docente'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['nombre_docente'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['titulo_capitulo'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['titulo_libro'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['tipo_libro'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['codigo_isbn'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['editorial'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['anno_publicacion'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['volumen'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['numero_autores_capitulo'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['numero_autores_capitulo_ud'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['numero_autores_libro'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['numero_autores_libro_ud'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['numero_acta'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['fecha_acta'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['numero_caso'] . "</center></td>
	                    <td><center>" . $resultado [$i] ['puntaje'] . "</center></td>
	                    <td><center>
	                    	<a href='" . $variable . "'>
	                            <img src='" . $rutaBloque . "/css/images/Entrada.png' width='15px'>
	                        </a>
	                  	</center> </td>
	           
	                    </tr>";
						echo $mostrarHtml;
						unset ( $mostrarHtml );
						unset ( $variable );
					}
					
					echo "</tbody>";
					
					echo "</table>";

					echo $this->miFormulario->marcoAgrupacion ( 'fin' );

				} else {
					
					$mensaje = "No Se Encontraron<br> Registros.";
					
					// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
					$esteCampo = 'mensajeRegistro';
					$atributos ['id'] = $esteCampo;
					$atributos ['tipo'] = 'information';
					$atributos ['estilo'] = 'textoCentrar';
					$atributos ['mensaje'] = $mensaje;
					
					$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->cuadroMensaje ( $atributos );
				// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
			}
// 		}
// 		echo $this->miFormulario->agrupacion ( 'fin' );
		
		
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
		$valorCodificado .= "&opcion=regresar";
		$valorCodificado .= "&redireccionar=regresar";
		/**
		 * SARA permite que los nombres de los campos sean dinámicos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
		 * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
		 * (b) asociando el tiempo en que se está creando el formulario
		 */
		$valorCodificado .= "&tiempo=" . time ();
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
	}
}

$miSeleccionador = new registrarForm ( $this->lenguaje, $this->miFormulario, $this->sql );

$miSeleccionador->miForm ();
?>	