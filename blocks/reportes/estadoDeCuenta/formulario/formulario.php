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
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'datos_docente', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$datosDocente = $resultado[0];
		
		//Almacena todos los resultados del docente
		//$items = array();
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'titulos_docente', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Hoja de Vida',
				'titulo' => 'Títulos Académicos',
				'titulo1' => 'Titulo',
				'llavevalor1' => 'tipo_titulo_academico',
				'llavevalor2' => 'titulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'revistas_indexadas', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Revistas Indexadas',
				'titulo1' => 'Titulo',
				'llavevalor1' => 'tipo_contexto',
				'llavevalor2' => 'nombre_revista'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'capitulos_libros', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Capítulos de Libros',
				'titulo1' => 'Titulo',
				'llavevalor1' => 'tipo_libro',
				'llavevalor2' => 'titulo_capitulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'cartas_editor', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Cartas al Editor',
				'titulo1' => 'Titulo',
				'llavevalor1' => 'tipo_titulo_academico',
				'llavevalor2' => 'nombre_revista'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'direccion_de_trabajos', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Dirección de Trabajos de Grado',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'tipo_trabajogrado',
				'llavevalor2' => 'titulo_trabajogrado'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_direccion_academica', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Experiencia Dirección Académica',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'nombre_tipo_entidad',
				'llavevalor2' => 'nombre_universidad'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_investigacion', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Experiencia En Investigación',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'tipo_experiencia_investigacion',
				'llavevalor2' => 'nombre_universidad'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_docencia', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Experiencia En Docencia',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'nombre_tipo_entidad',
				'llavevalor2' => 'nombre_universidad'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_profesional', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Experiencia Profesional',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'nombre_universidad',
				'llavevalor2' => 'cargo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_calificada', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Experiencia Calificada',
				'titulo1' => 'Categoría',
				'llavevalor1' => 'tipo_experiencia_calificada',
				'llavevalor2' => 'tipo_emisor_resolucion'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_direccion_academica', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Experiencia Dirección Académica',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'nombre_tipo_entidad',
				'llavevalor2' => 'nombre_universidad'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'comunicacion_corta', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Comunicación Corta',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'contexto',
				'llavevalor2' => 'nombre_revista'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'obras_artisticas', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Obras Artísticas',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'contexto',
				'llavevalor2' => 'titulo_obra'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'patentes', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Patentes',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'tipo_patente',
				'llavevalor2' => 'titulo_patente'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'premios_docente', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Premios Docente',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'contexto',
				'llavevalor2' => 'nombre_tipo_entidad'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'produccion_videos', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Producción de Vídeos',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'contexto',
				'llavevalor2' => 'titulo_video'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'produccion_libros', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Producción de Libros',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'tipo_libro',
				'llavevalor2' => 'titulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'traduccion_libros', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Traducción de Libros',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'normatividad',
				'llavevalor2' => 'titulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'produccion_tecnicaysoftware', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Salariales',
				'titulo' => 'Producción Técnica y Software Docente',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'tipo_tecnicaysoftware',
				'llavevalor2' => 'nombre'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'publicaciones_impresas_universitarias', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Bonificación',
				'titulo' => 'Publicaciones Impresas Universitarias',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'tipo_indexacion',
				'llavevalor2' => 'titulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'estudios_post_doctorales', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Bonificación',
				'titulo' => 'Estudios Post Doctorales',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'nombre_universidad',
				'llavevalor2' => 'titulo_obtenido'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'resena_critica', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Bonificación',
				'titulo' => 'Reseña Crítica',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'tipo_indexacion',
				'llavevalor2' => 'titulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'traduccion_articulos', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Bonificación',
				'titulo' => 'Traducción de Artículos',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'tipo_traduccion_articulo',
				'llavevalor2' => 'titulo_traduccion'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'ponencias', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Bonificación',
				'titulo' => 'Ponencias',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'contexto_ponencia',
				'llavevalor2' => 'titulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'novedades', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => 'Novedades',
				'titulo' => 'Novedades Salariales y Bonificacion',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'tipo_trabajogrado',
				'llavevalor2' => 'titulo_trabajogrado'
		);
		
		
		$atributos ['id'] = 'formSaraData'; // No cambiar este nombre
		$atributos ['origen'] = 'plantilla1.html.php';
		$atributos ['datos_docente'] = $datosDocente;
		$atributos ['items'] = $items;
		$atributos ['soloHTML'] = true;
		$randomName = $this->miConfigurador->fabricaConexiones->crypto->codificar (time());
		$atributos ['destino'] = $documento.'-'.$randomName.'.pdf';
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