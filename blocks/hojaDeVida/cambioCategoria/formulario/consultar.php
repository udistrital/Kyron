<?php

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/builder/InspectorHTML.class.php");

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
		 * Se realiza la decodificación de los campos "validador" de los 
		 * componentes del FormularioHtml. Se realiza la validación. En caso de que algún parámetro
		 * sea ingresado fuera de lo correspondiente en el campo "validador", este será ajustado
		 * (o convertido a) a un parámetro permisible o simplemente de no ser válido se devolverá 
		 * el valor false. Si lo que se quiere es saber si los parámetros son correctos o no, se
		 * puede introducir un tercer parámetro $arreglar, que es un parámetro booleano que indica,
		 * si es pertinente o no realizar un recorte de los datos "string" para que cumpla los requerimientos
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
				$variable = "pagina=accesoIncorrecto";
				$variable .= "&opcion=error";
				$variable .= "&paginaError=".$miPaginaActual;
				$variable .= "&parametros=".$this->miInspectorHTML->codificarCampos($_REQUEST);
				$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
				$url = $this->miConfigurador->configuracion ["host"] . $this->miConfigurador->configuracion ["site"] . "/index.php";
				$enlace = $this->miConfigurador->configuracion ['enlace'];				
				$redireccion = $url . $enlace . '=' . $variable;
				echo '<!DOCTYPE html><html><body></body><html><script>
				var form = document.createElement("form");
				form.setAttribute("method", "POST");
				form.setAttribute("action", "'.$url.'");
				var hiddenField = document.createElement("input");
				hiddenField.setAttribute("type", "hidden");
				hiddenField.setAttribute("name", "'.$enlace.'");
				hiddenField.setAttribute("value", "'.$variable.'");
				form.appendChild(hiddenField);
				document.body.appendChild(form);
				form.submit();
				</script>';
				return 0;
			}
		}
		
		// -------------------------------------------------------------------------------------------------
		$conexion = "docencia";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		if (isset ( $_REQUEST ['id_docente'] ) && $_REQUEST ['id_docente'] != '') {
			$id_docente = $_REQUEST ['id_docente'];
		} else {
			$id_docente = '';
		}
		
		if (isset ( $_REQUEST ['facultad'] ) && $_REQUEST ['facultad'] != '') {
			$facultad = $_REQUEST ['facultad'];
		} else {
			$facultad = '';
		}
		
		if (isset ( $_REQUEST ['proyectoCurricular'] ) && $_REQUEST ['proyectoCurricular'] != '') {
			$proyectoCurricular = $_REQUEST ['proyectoCurricular'];
		} else {
			$proyectoCurricular = '';
		}
		
		$arreglo = array (
				'documento_docente' => $id_docente,
				'id_facultad' => $facultad,
				'id_proyectocurricular' => $proyectoCurricular
		);
		
		$arregloSerialize = array (
				$id_docente,
				$facultad,
				$proyectoCurricular
		);

		$cadenaSql = $this->miSql->getCadenaSql ( 'consultar', $arreglo );
		$indexacion = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		$arreglo=serialize($arregloSerialize);
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
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		echo $this->miFormulario->formulario ( $atributos );

		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		

		$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
			
		$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
			
		$variable = "pagina=" . $miPaginaActual;
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $directorio );

		echo "</br>";
		
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
		
				if ($indexacion) {
					
					$esteCampo = $esteCampo = "marcoConsultaGeneral";
					$atributos ['id'] = $esteCampo;
					$atributos ["estilo"] = "jqueryui";
					$atributos ['tipoEtiqueta'] = 'inicio';
					$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );		
					echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
					
					echo "<table id='tablaTitulos'>";
					
					echo "<thead>
	                <tr>
	                   
	                    <th>Identificación</th>
	                    <th>Nombres y Apellidos</th>
						<th>Descripción de Novedad</th>
						<th>Tipo de novedad</th>
						<th>Número Acta</th>
						<th>Fecha Acta</th>
						<th>Caso Acta</th>
						<th>Puntaje</th>
						<th>Puntaje</th>
						<th>Normatividad</th>	
							
	                </tr>
	            </thead>
	            <tbody>";
					
					for($i = 0; $i < count ( $indexacion ); $i ++) {
						$variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
						$variable .= "&opcion=modificar";
						$variable .= "&arreglo=" . $arreglo;
						// $variable .= "&usuario=" . $miSesion->getSesionUsuarioId ();
						$variable .= "&documento_docente=" . $indexacion [$i] ['documento_docente'];
						$variable .= "&id_novedad=" . $indexacion [$i] ['id_novedad'];
						$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $directorio );
						
						$mostrarHtml = "<tr>
	                    <td><center>" . $indexacion [$i] ['documento_docente'] . "</center></td>
	                    <td><center>" . $indexacion [$i] ['nombre_docente'] . "</center></td>
	                    <td><center>" . $indexacion [$i] ['descripcion'] . "</center></td>
	                    <td><center>" . $indexacion [$i] ['tipo_novedad'] . "</center></td>
	                    <td><center>" . $indexacion [$i] ['numero_acta'] . "</center></td>
	                    <td><center>" . $indexacion [$i] ['fecha_acta'] . "</center></td>
	                    <td><center>" . $indexacion [$i] ['numero_caso'] . "</center></td>
	                    <td><center>" . $indexacion [$i] ['puntaje'] . "</center></td>
	                    <td><center>" . $indexacion [$i] ['normatividad'] . "</center></td>
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
					
					$mensaje = $this->lenguaje->getCadena ( 'mensajeNoRegistros' );
					
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
