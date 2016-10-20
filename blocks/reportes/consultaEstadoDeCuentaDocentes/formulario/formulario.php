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
		
		// -------------------------------------------------------------------------------------------------
		$atributosGlobales ['campoSeguro'] = 'true';
		$_REQUEST['tiempo'] = time();
		
		
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
		unset ( $atributos );
		
		// ---------------- CONTROL: Lista Docente--------------------------------------------------------
		
		$esteCampo = 'docente';
		
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
		$atributos ['validar'] = '';
		$atributos ['textoFondo'] = 'Ingrese Mínimo 3 Caracteres de Búsqueda';
		
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 80;
		$atributos ['maximoTamanno'] = '';
		$atributos ['anchoEtiqueta'] = 280;
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		$esteCampo = 'id_docente';
		$atributos ["id"] = $esteCampo; // No cambiar este nombre
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ["obligatorio"] = false;
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
		
		
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "botones";
		$atributos ["estilo"] = "marcoBotones";
		echo $this->miFormulario->division ( "inicio", $atributos );
		{
			// -----------------CONTROL: Botón ----------------------------------------------------------------
			$esteCampo = 'botonConsultar';
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
			$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
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
		
		$valorCodificado = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
// 		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
// 		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
// 		$valorCodificado .= "&opcion=consultar";
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
		
		
		
		
		// ---------------- CONSULTA: Datos Docente --------------------------------------------------------
		//Si no existe el parámetro docente simplemente imprime el formulario
		if(!isset($_REQUEST['id_docente'])){
			return 0;
		}
		
		$documento = $_REQUEST['id_docente'];
		
		$conexion = 'docencia';
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'datos_docente', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		if(!$resultado){
			echo '<h2>No hay datos de este Docente.</h2>';
			return 0;
		}
		$datosDocente = $resultado[0];
		
		// ---------------- FIN CONSULTA: Datos Docente --------------------------------------------------------
		
		
		//Almacena todos los resultados del docente
		//$items = array();
		
		// ---------------- CONSULTA: títulos docente --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'titulos_docente', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'titulo_academico' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Tipo',
				'nombre_campo' => 'tipo_titulo_academico',
		);
		$campos[] = array(
				'alias_campo' => 'Título',
				'nombre_campo' => 'titulo',
		);
		$campos[] = array(
				'alias_campo' => 'Universidad',
				'nombre_campo' => 'universidad',
		);
		$campos[] = array(
				'alias_campo' => 'País',
				'nombre_campo' => 'pais',
		);
		$campos[] = array(
				'alias_campo' => 'Año',
				'nombre_campo' => 'anno',
		);
		$campos[] = array(
				'alias_campo' => 'Modalidad',
				'nombre_campo' => 'modalidad',
		);
		$campos[] = array(
				'alias_campo' => 'Resolución',
				'nombre_campo' => 'resolucion',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Resolución',
				'nombre_campo' => 'fecha_resolucion',
		);
		$campos[] = array(
				'alias_campo' => 'Entidad Convalidación',
				'nombre_campo' => 'entidad_convalidacion',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Hoja de Vida',
				'titulo' => 'Títulos Académicos',
				'tipoObservacion' => '26',
				'paginaSARA' => 'titulosAcademicos',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: títulos docente --------------------------------------------------------
		
		// ---------------- CONSULTA: revistas indexadas --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'revistas_indexadas', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'revista_indexada' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Nombre Revista',
				'nombre_campo' => 'nombre_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Contexto',
				'nombre_campo' => 'contexto',
		);
		$campos[] = array(
				'alias_campo' => 'País',
				'nombre_campo' => 'pais',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo Indexación',
				'nombre_campo' => 'tipo_indexacion',
		);
		$campos[] = array(
				'alias_campo' => 'Número ISSN',
				'nombre_campo' => 'numero_issn',
		);
		$campos[] = array(
				'alias_campo' => 'Año Publicación',
				'nombre_campo' => 'anno_publicacion',
		);
		$campos[] = array(
				'alias_campo' => 'Volumen Revista',
				'nombre_campo' => 'volumen_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Número Revista',
				'nombre_campo' => 'numero_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Páginas Revista',
				'nombre_campo' => 'paginas_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Título Artículo',
				'nombre_campo' => 'titulo_articulo',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores',
				'nombre_campo' => 'numero_autores',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores UD',
				'nombre_campo' => 'numero_autores_ud',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Revistas Indexadas',
				'tipoObservacion' => '1',
				'paginaSARA' => 'revistasIndexadas',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: revistas indexadas --------------------------------------------------------
		
		// ---------------- CONSULTA: capítulos libros --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'capitulos_libros', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'capitulo_libro' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Título Capítulo',
				'nombre_campo' => 'titulo_capitulo',
		);
		$campos[] = array(
				'alias_campo' => 'Título Libro',
				'nombre_campo' => 'titulo_libro',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo Libro',
				'nombre_campo' => 'tipo_libro',
		);
		$campos[] = array(
				'alias_campo' => 'Código ISBN',
				'nombre_campo' => 'codigo_isbn',
		);
		$campos[] = array(
				'alias_campo' => 'Editorial',
				'nombre_campo' => 'editorial',
		);
		$campos[] = array(
				'alias_campo' => 'Año Publicación',
				'nombre_campo' => 'anno_publicacion',
		);
		$campos[] = array(
				'alias_campo' => 'Volúmen',
				'nombre_campo' => 'volumen',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores Capítulo',
				'nombre_campo' => 'numero_autores_capitulo',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores Capítulo UD',
				'nombre_campo' => 'numero_autores_capitulo_ud',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores Libro',
				'nombre_campo' => 'numero_autores_libro',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores Libro UD',
				'nombre_campo' => 'numero_autores_libro_ud',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$campos[] = array(
				'alias_campo' => 'Evaluadores',
				'nombre_campo' => 'evaluadores',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Capítulos de Libros',
				'tipoObservacion' => '13',
				'paginaSARA' => 'capituloLibros',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: capítulos libros --------------------------------------------------------
		
		// ---------------- CONSULTA: cartas editor --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'cartas_editor', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'cartas_editor' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Nombre Revista',
				'nombre_campo' => 'nombre_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Contexto',
				'nombre_campo' => 'contexto',
		);
		$campos[] = array(
				'alias_campo' => 'País',
				'nombre_campo' => 'pais',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo Indexación',
				'nombre_campo' => 'tipo_indexacion',
		);
		$campos[] = array(
				'alias_campo' => 'Número ISSN',
				'nombre_campo' => 'numero_issn',
		);
		$campos[] = array(
				'alias_campo' => 'Año Publicación',
				'nombre_campo' => 'anno_publicacion',
		);
		$campos[] = array(
				'alias_campo' => 'Volúmen Revista',
				'nombre_campo' => 'volumen_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Número Revista',
				'nombre_campo' => 'numero_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Páginas Revista',
				'nombre_campo' => 'paginas_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Título Artículo',
				'nombre_campo' => 'titulo_articulo',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores',
				'nombre_campo' => 'numero_autores',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores UD',
				'nombre_campo' => 'numero_autores_ud',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Publicación',
				'nombre_campo' => 'fecha_publicacion',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Cartas al Editor',
				'tipoObservacion' => '3',
				'paginaSARA' => 'cartasEditor',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: cartas editor --------------------------------------------------------
		
		// ---------------- CONSULTA: dirección de trabajos --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'direccion_de_trabajos', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'direccion_trabajogrado' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Titulo',
				'nombre_campo' => 'titulo_trabajogrado',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo',
				'nombre_campo' => 'tipo_trabajogrado',
		);
		$campos[] = array(
				'alias_campo' => 'Categoría',
				'nombre_campo' => 'categoria_trabajogrado',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores',
				'nombre_campo' => 'numero_autores',
		);
		$campos[] = array(
				'alias_campo' => 'Año Dirección',
				'nombre_campo' => 'anno_direccion',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$campos[] = array(
				'alias_campo' => 'Estudiantes',
				'nombre_campo' => 'estudiantes',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Dirección de Trabajos de Grado',
				'tipoObservacion' => '4',
				'paginaSARA' => 'direccionTrabajosDeGrado',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: dirección de trabajos --------------------------------------------------------
		
		// ---------------- CONSULTA: experiencia dirección académica --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_direccion_academica', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'experiencia_direccion_academica' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Universidad',
				'nombre_campo' => 'universidad',
		);
		$campos[] = array(
				'alias_campo' => 'Otra Entidad',
				'nombre_campo' => 'otra_entidad',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo Entidad',
				'nombre_campo' => 'tipo_entidad',
		);
		$campos[] = array(
				'alias_campo' => 'Horas Semana',
				'nombre_campo' => 'horas_semana',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Inicio',
				'nombre_campo' => 'fecha_inicio',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Finalización',
				'nombre_campo' => 'fecha_finalizacion',
		);
		$campos[] = array(
				'alias_campo' => 'Días Experiencia',
				'nombre_campo' => 'dias_experiencia',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Experiencia Dirección Académica',
				'tipoObservacion' => '5',
				'paginaSARA' => 'experienciaDireccionAcademica',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: experiencia dirección académica --------------------------------------------------------
		
		// ---------------- CONSULTA: experiencia investigación --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_investigacion', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'experiencia_investigacion' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Universidad',
				'nombre_campo' => 'universidad',
		);
		$campos[] = array(
				'alias_campo' => 'Otra Universidad',
				'nombre_campo' => 'otra_entidad',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo',
				'nombre_campo' => 'tipo_experiencia_investigacion',
		);
		$campos[] = array(
				'alias_campo' => 'Horas por Semana',
				'nombre_campo' => 'horas_semana',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Inicio',
				'nombre_campo' => 'fecha_inicio',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Finalización',
				'nombre_campo' => 'fecha_finalizacion',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Experiencia En Investigación',
				'tipoObservacion' => '7',
				'paginaSARA' => 'experienciaInvestigacion',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: experiencia investigación --------------------------------------------------------
		
		// ---------------- CONSULTA: experiencia en docencia --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_docencia', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'experiencia_docencia' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Universidad',
				'nombre_campo' => 'universidad',
		);
		$campos[] = array(
				'alias_campo' => 'Otra Entidad',
				'nombre_campo' => 'otra_entidad',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo Entidad',
				'nombre_campo' => 'tipo_entidad',
		);
		$campos[] = array(
				'alias_campo' => 'Horas Semana',
				'nombre_campo' => 'horas_semana',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Inicio',
				'nombre_campo' => 'fecha_inicio',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Finalización',
				'nombre_campo' => 'fecha_finalizacion',
		);
		$campos[] = array(
				'alias_campo' => 'Días Experiencia',
				'nombre_campo' => 'dias_experiencia',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Experiencia En Docencia',
				'tipoObservacion' => '9',
				'paginaSARA' => 'experienciaDocencia',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: experiencia en docencia --------------------------------------------------------
		
		// ---------------- CONSULTA: experiencia profesional --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_profesional', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'experiencia_profesional' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Universidad',
				'nombre_campo' => 'universidad',
		);
		$campos[] = array(
				'alias_campo' => 'Otra Entidad',
				'nombre_campo' => 'otra_entidad',
		);
		$campos[] = array(
				'alias_campo' => 'Cargo',
				'nombre_campo' => 'cargo',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Inicio',
				'nombre_campo' => 'fecha_inicio',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Finalización',
				'nombre_campo' => 'fecha_finalizacion',
		);
		$campos[] = array(
				'alias_campo' => 'Días Experiencia',
				'nombre_campo' => 'dias_experiencia',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Experiencia Profesional',
				'tipoObservacion' => '10',
				'paginaSARA' => 'experienciaProfesional',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: experiencia profesional --------------------------------------------------------
		
		// ---------------- CONSULTA: experiencia calificada --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_calificada', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'experiencia_calificada' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Tipo Experiencia',
				'nombre_campo' => 'tipo_experiencia_calificada',
		);
		$campos[] = array(
				'alias_campo' => 'Año Experiencia',
				'nombre_campo' => 'annio_experiencia',
		);
		$campos[] = array(
				'alias_campo' => 'Número Resolución',
				'nombre_campo' => 'numero_resolucion',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo Emisor',
				'nombre_campo' => 'tipo_emisor_resolucion',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Resolución',
				'nombre_campo' => 'fecha_resolucion',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Experiencia Calificada',
				'tipoObservacion' => '11',
				'paginaSARA' => 'experienciaCalificada',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: experiencia calificada --------------------------------------------------------
		/*****NOOOOOOOOOOOOOOOOOOOOOOOOOOTAAAAAAAAAAAA***/ //BLoque que falta por corrregirorrrrr SQL y Campos
		// ---------------- CONSULTA: excelencia académica --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'excelencia_academica', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'excelencia_academica' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Año Otorgamiento',
				'nombre_campo' => 'annio_otorgamiento',
		);
		$campos[] = array(
				'alias_campo' => 'Número Resolución',
				'nombre_campo' => 'numero_resolucion',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Resolución',
				'nombre_campo' => 'fecha_resolucion',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Excelencia Académica',
				'tipoObservacion' => '12',
				'paginaSARA' => 'excelenciaAcademica',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: excelencia académica --------------------------------------------------------
		
		// ---------------- CONSULTA: comunicación corta --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'comunicacion_corta', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'comunicacion_corta' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Revista',
				'nombre_campo' => 'nombre_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Contexto',
				'nombre_campo' => 'contexto',
		);
		$campos[] = array(
				'alias_campo' => 'País',
				'nombre_campo' => 'pais',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo Indexación',
				'nombre_campo' => 'tipo_indexacion',
		);
		$campos[] = array(
				'alias_campo' => 'Número ISSN',
				'nombre_campo' => 'numero_issn',
		);
		$campos[] = array(
				'alias_campo' => 'Año Publicación',
				'nombre_campo' => 'anno_publicacion',
		);
		$campos[] = array(
				'alias_campo' => 'Volúmen Revista',
				'nombre_campo' => 'volumen_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Número Revista',
				'nombre_campo' => 'numero_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Páginas Revista',
				'nombre_campo' => 'paginas_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Título Artículo',
				'nombre_campo' => 'titulo_articulo',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores',
				'nombre_campo' => 'numero_autores',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores UD',
				'nombre_campo' => 'numero_autores_ud',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Comunicación Corta',
				'tipoObservacion' => '18',
				'paginaSARA' => 'comunicacionCorta',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: comunicación corta --------------------------------------------------------
		
		// ---------------- CONSULTA: obras artísticas --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'obras_artisticas', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'obra_artistica' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Título Obra',
				'nombre_campo' => 'titulo_obra',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo Obra Artística',
				'nombre_campo' => 'tipo_obra_artistica',
		);
		$campos[] = array(
				'alias_campo' => 'Certificador',
				'nombre_campo' => 'certificador',
		);
		$campos[] = array(
				'alias_campo' => 'Contexto',
				'nombre_campo' => 'contexto',
		);
		$campos[] = array(
				'alias_campo' => 'Año Obra',
				'nombre_campo' => 'anno_obra',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Obras Artísticas',
				'tipoObservacion' => '14',
				'paginaSARA' => 'obrasArtisticas',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: obras artísticas --------------------------------------------------------
		
		// ---------------- CONSULTA: patentes --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'patentes', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'patente' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Título',
				'nombre_campo' => 'titulo_patente',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo',
				'nombre_campo' => 'tipo_patente',
		);		
		$campos[] = array(
				'alias_campo' => 'Universidad',
				'nombre_campo' => 'universidad',
		);
		$campos[] = array(
				'alias_campo' => 'País',
				'nombre_campo' => 'pais',
		);
		$campos[] = array(
				'alias_campo' => 'Año Obtención',
				'nombre_campo' => 'anno_obtencion',
		);
		$campos[] = array(
				'alias_campo' => 'Concepto Patente',
				'nombre_campo' => 'concepto_patente',
		);
		$campos[] = array(
				'alias_campo' => 'Número Registro',
				'nombre_campo' => 'numero_registro',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Patentes',
				'tipoObservacion' => '15',
				'paginaSARA' => 'patentes',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: patentes --------------------------------------------------------
		
		// ---------------- CONSULTA: premios docente --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'premios_docente', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'premio_docente' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Universidad',
				'nombre_campo' => 'universidad',
		);
		$campos[] = array(
				'alias_campo' => 'Otra Entidad',
				'nombre_campo' => 'otra_entidad',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo Entidad',
				'nombre_campo' => 'tipo_entidad',
		);
		$campos[] = array(
				'alias_campo' => 'Contexto',
				'nombre_campo' => 'contexto',
		);
		$campos[] = array(
				'alias_campo' => 'País',
				'nombre_campo' => 'pais',
		);
		$campos[] = array(
				'alias_campo' => 'Ciudad',
				'nombre_campo' => 'ciudad',
		);
		$campos[] = array(
				'alias_campo' => 'Concepto Premio',
				'nombre_campo' => 'concepto_premio',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Premio',
				'nombre_campo' => 'fecha_premio',
		);
		$campos[] = array(
				'alias_campo' => 'Número Condecorados',
				'nombre_campo' => 'numero_condecorados',
		);
		$campos[] = array(
				'alias_campo' => 'Año Premio',
				'nombre_campo' => 'anno_premio',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Premios Docente',
				'tipoObservacion' => '16',
				'paginaSARA' => 'premiosDocente',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: premios docente --------------------------------------------------------
		
		// ---------------- CONSULTA: producción vídeos --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'produccion_videos', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'produccion_video' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Título',
				'nombre_campo' => 'titulo_video',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores',
				'nombre_campo' => 'numero_autores',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores UD',
				'nombre_campo' => 'numero_autores_ud',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Realización',
				'nombre_campo' => 'fecha_realizacion',
		);
		$campos[] = array(
				'alias_campo' => 'Contexto',
				'nombre_campo' => 'contexto',
		);
		$campos[] = array(
				'alias_campo' => 'Carácter Vídeo',
				'nombre_campo' => 'caracter_video',
		);
		$campos[] = array(
				'alias_campo' => 'Número Evaluadores',
				'nombre_campo' => 'numero_evaluadores',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$campos[] = array(
				'alias_campo' => 'Evaluadores',
				'nombre_campo' => 'evaluadores',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Producción de Vídeos',
				'tipoObservacion' => '17',
				'paginaSARA' => 'produccionDeVideos',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: producción vídeos --------------------------------------------------------
		
		// ---------------- CONSULTA: producción libros --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'produccion_libros', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'libro_docente' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Título',
				'nombre_campo' => 'titulo',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo Libro',
				'nombre_campo' => 'tipo_libro',
		);
		$campos[] = array(
				'alias_campo' => 'Universidad',
				'nombre_campo' => 'universidad',
		);
		$campos[] = array(
				'alias_campo' => 'Código ISBN',
				'nombre_campo' => 'codigo_isbn',
		);
		$campos[] = array(
				'alias_campo' => 'Año Publicación',
				'nombre_campo' => 'anno_publicacion',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores',
				'nombre_campo' => 'numero_autores',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores UD',
				'nombre_campo' => 'numero_autores_ud',
		);
		$campos[] = array(
				'alias_campo' => 'Editorial',
				'nombre_campo' => 'editorial',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$campos[] = array(
				'alias_campo' => 'Evaluadores',
				'nombre_campo' => 'evaluadores',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Producción de Libros',
				'tipoObservacion' => '2',
				'paginaSARA' => 'produccionDeLibros',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: producción libros --------------------------------------------------------
				
		// ---------------- CONSULTA: traducción libros --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'traduccion_libros', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'traduccion_libro' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Título',
				'nombre_campo' => 'titulo',
		);
		$campos[] = array(
				'alias_campo' => 'Autor Original',
				'nombre_campo' => 'nombre_autor_original',
		);
		$campos[] = array(
				'alias_campo' => 'Año Traducción',
				'nombre_campo' => 'anno_traduccion',
		);
		$campos[] = array(
				'alias_campo' => 'Año Publicación',
				'nombre_campo' => 'anno_publicacion',
		);
		$campos[] = array(
				'alias_campo' => 'Volúmen',
				'nombre_campo' => 'volumen',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Traducción de Libros',
				'tipoObservacion' => '6',
				'paginaSARA' => 'traduccionesDeLibros',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: traducción libros --------------------------------------------------------
		
		// ---------------- CONSULTA: producción técnica y software --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'produccion_tecnicaysoftware', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'produccion_tecnicaysoftware' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Nombre',
				'nombre_campo' => 'nombre',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo',
				'nombre_campo' => 'tipo_tecnicaysoftware',
		);
		$campos[] = array(
				'alias_campo' => 'Número Certificado',
				'nombre_campo' => 'numero_certificado',
		);
		$campos[] = array(
				'alias_campo' => 'Año Producción',
				'nombre_campo' => 'anno_produccion',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$campos[] = array(
				'alias_campo' => 'Evaluadores',
				'nombre_campo' => 'evaluadores',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Producción Técnica y Software Docente',
				'tipoObservacion' => '8',
				'paginaSARA' => 'produccionTecnicaYSoftware',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: producción técnica y software --------------------------------------------------------
		
		// ---------------- CONSULTA: publicaciones impresas universitarias --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'publicaciones_impresas_universitarias', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'publicacion_impresa' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Título',
				'nombre_campo' => 'titulo',
		);
		$campos[] = array(
				'alias_campo' => 'Número ISSN',
				'nombre_campo' => 'numero_issn',
		);
		$campos[] = array(
				'alias_campo' => 'Nombre Revista',
				'nombre_campo' => 'nombre_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Número Revista',
				'nombre_campo' => 'numero_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Volúmen Revista',
				'nombre_campo' => 'volumen_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Año Revista',
				'nombre_campo' => 'anno_revista',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo Indexación',
				'nombre_campo' => 'tipo_indexacion',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '2',
				'tituloTipo' => 'Bonificación',
				'titulo' => 'Publicaciones Impresas Universitarias',
				'tipoObservacion' => '19',
				'paginaSARA' => 'publicacionesImpresas',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: publicaciones impresas universitarias --------------------------------------------------------
		
		// ---------------- CONSULTA: estudios post doctorales --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'estudios_post_doctorales', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'estudio_postdoctoral_docente' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Título Obtenido',
				'nombre_campo' => 'titulo_obtenido',
		);
		$campos[] = array(
				'alias_campo' => 'Fecha Obtención',
				'nombre_campo' => 'fecha_obtencion',
		);
		$campos[] = array(
				'alias_campo' => 'Universidad',
				'nombre_campo' => 'universidad',
		);
		$campos[] = array(
				'alias_campo' => 'Otra Entidad',
				'nombre_campo' => 'otra_entidad',
		);
		$campos[] = array(
				'alias_campo' => 'Años Doctorado',
				'nombre_campo' => 'annos_doctorado',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '2',
				'tituloTipo' => 'Bonificación',
				'titulo' => 'Estudios Post Doctorales',
				'tipoObservacion' => '20',
				'paginaSARA' => 'estudiosPostDoctorales',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: estudios post doctorales --------------------------------------------------------
		
		// ---------------- CONSULTA: reseña crítica --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'resena_critica', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'resena_critica' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Título',
				'nombre_campo' => 'titulo',
		);
		$campos[] = array(
				'alias_campo' => 'Revista',
				'nombre_campo' => 'revista',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo Indexación',
				'nombre_campo' => 'tipo_indexacion',
		);
		$campos[] = array(
				'alias_campo' => 'Año',
				'nombre_campo' => 'anno',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '2',
				'tituloTipo' => 'Bonificación',
				'titulo' => 'Reseña Crítica',
				'tipoObservacion' => '21',
				'paginaSARA' => 'resenaCritica',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: reseña crítica --------------------------------------------------------
				
		// ---------------- CONSULTA: traducción artículos --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'traduccion_articulos', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'traduccion_articulo' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Título Traducción',
				'nombre_campo' => 'titulo_traduccion',
		);
		$campos[] = array(
				'alias_campo' => 'Título Publicación',
				'nombre_campo' => 'titulo_publicacion',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo Traducción Artículo',
				'nombre_campo' => 'tipo_traduccion_articulo',
		);
		
		$campos[] = array(
				'alias_campo' => 'Fecha Traducción',
				'nombre_campo' => 'fecha_traduccion',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '2',
				'tituloTipo' => 'Bonificación',
				'titulo' => 'Traducción de Artículos',
				'tipoObservacion' => '22',
				'paginaSARA' => 'traduccionDeArticulos',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: traducción artículos --------------------------------------------------------
		
		// ---------------- CONSULTA: ponencias --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'ponencias', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'ponencia' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Título',
				'nombre_campo' => 'titulo',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores',
				'nombre_campo' => 'numero_autores',
		);
		$campos[] = array(
				'alias_campo' => 'Número Autores UD',
				'nombre_campo' => 'numero_autores',
		);
		$campos[] = array(
				'alias_campo' => 'Año',
				'nombre_campo' => 'anno',
		);
		$campos[] = array(
				'alias_campo' => 'Contexto',
				'nombre_campo' => 'contexto_ponencia',
		);
		$campos[] = array(
				'alias_campo' => 'Evento de la Presentación',
				'nombre_campo' => 'evento_presentacion',
		);
		$campos[] = array(
				'alias_campo' => 'Institución Certificadora',
				'nombre_campo' => 'institucion_certificadora',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '2',
				'tituloTipo' => 'Bonificación',
				'titulo' => 'Ponencias',
				'tipoObservacion' => '23',
				'paginaSARA' => 'ponenciasDocente',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: ponencias --------------------------------------------------------
				
		// ---------------- CONSULTA: novedades salariales --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'novedades_salariales', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table', 'novedad' );
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Título',
				'nombre_campo' => 'descripcion',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo',
				'nombre_campo' => 'tipo_novedad',
		);
		$campos[] = array(
				'alias_campo' => 'Categoría',
				'nombre_campo' => 'categoria_novedad',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Novedades Salariales',
				'tipoObservacion' => '24',
				'paginaSARA' => 'novedadesSalariales',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: novedades salariales --------------------------------------------------------
		
		// ---------------- CONSULTA: novedades bonificación --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'novedades_bonificacion', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Título',
				'nombre_campo' => 'descripcion',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo',
				'nombre_campo' => 'tipo_novedad',
		);
		$campos[] = array(
				'alias_campo' => 'Categoría',
				'nombre_campo' => 'categoria_novedad',
		);
		$campos[] = array(
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '2',
				'tituloTipo' => 'Bonificación',
				'titulo' => 'Novedades Bonificación',
				'tipoObservacion' => '25',
				'paginaSARA' => 'novedadesBonificacion',
				'llavesPrimarias' => $llavesPrimarias,
				'descripcion' => $campos
		);
		unset($campos);
		// ---------------- FIN CONSULTA: novedades bonificación --------------------------------------------------------
		
		// ---------------- CONSULTA: observaciones de todos los módulos --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'observaciones', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$observaciones = ($resultado)?$resultado:array();
		unset($resultado);
		// ---------------- FIN CONSULTA: observaciones de todos los módulos --------------------------------------------------------
		
		$observacionesPorLLaveValor = null;
		
		foreach ($observaciones as $observacion) {
			$observacionesPorLLaveValor[$observacion['llaves_primarias_valor']] = $observacion;
		}
		unset($observaciones);
		
		function obtenerLLavesValor($llaves,$valores,&$documento){
			foreach ($llaves as $llave) {
				if($llave['primarykey']=='documento_docente'){
					$arregloLLaveValor[$llave['primarykey']] = $documento;
				} else {
					$arregloLLaveValor[$llave['primarykey']] = $valores[$llave['primarykey']];										
				}				
			}
			return json_encode($arregloLLaveValor);
		}
		
		function consultarPorLLavesValor($llaves_primarias_valor,&$observacionesPorLLaveValor){
			return (isset($observacionesPorLLaveValor[$llaves_primarias_valor]))
				?$observacionesPorLLaveValor[$llaves_primarias_valor]
				:false;
		}
		// var_dump(consultarPorLLavesValor(
					// array(['primarykey'=>'id_titulo_academico']),
					// array('id_titulo_academico'=>'5'),
					// $documento,
					// $observacionesPorLLaveValor
				// ));die;
		function getAliasLLavePrimaria($nombreLlavePrimaria) {
			$alias['numero_issn'] = 'identificadorColeccion';
			$alias['id_direccion_trabajogrado'] = 'identificadorDireccionTrabajo';
			$alias['id_experiencia_direccion_academica'] = 'identificadorExperiencia';
			$alias['id_experiencia_investigacion'] = 'identificadorExperiencia';
			$alias['id_experiencia_docencia'] = 'identificadorExperiencia';
			$alias['id_experiencia_profesional'] = 'identificadorExperiencia';
			$alias['id_experiencia_calificada'] = 'identificadorExperiencia';
			$alias['id_excelencia_academica'] = 'identificadorExcelenciaAcad';
			$alias['id_obra_artistica'] = 'identificadorObra';
			$alias['id_patente'] = 'identificadorPatente';
			$alias['id_premio_docente'] = 'identificadorPremioDocente';
			$alias['id_produccion_video'] = 'identificadorProduccionVideo';
			if(isset($alias[$nombreLlavePrimaria])) {
				return $alias[$nombreLlavePrimaria];
			} else {
				return $nombreLlavePrimaria;
			}
		}
		/**
		 * Estos ítems de la tabla se adecuan para poder mostrar
		 * las carácterísticas que sólo se ven allí
		 */
		$itemsTabla = array();
		foreach($items as $item){
			foreach($item['resultados'] as $resultado){
				/**
				 * Se quiere agregar los valores principales (de las consultas por módulo) a cada uno de los resultados,
				 * esto quiere decir a todas las filas de todos las consultas. Para ello se usa una variable auxiliar
				 * y se le quitan los resultados para que no queden duplicados. Luego se le adicionan parámetros adicionales.
				 */
				$valoresPrincipales = $item;
				$nombreObservacion = obtenerLLavesValor($valoresPrincipales['llavesPrimarias'],$resultado,$documento);
				$observacion = consultarPorLLavesValor(
					$nombreObservacion,
					$observacionesPorLLaveValor
				);
				//Se genera un string al estilo GET con las llaves primarias
				$textoGET = '';
				foreach ($valoresPrincipales['llavesPrimarias'] as $llavesTabla) {
					$nombreLlavePrimaria = $llavesTabla['primarykey'];
					if($nombreLlavePrimaria=='documento_docente'){
						//Ninguna consulta de elementos retorna documento_docente, pero en veces es una llave primaria del elemento
						//Se le pone el documento del docente
						$valorLlave=$documento;
					} else {
						$valorLlave=$resultado[$nombreLlavePrimaria];
						if(
							$nombreLlavePrimaria == 'numero_issn' && 
							(
							$valoresPrincipales['paginaSARA'] == 'comunicacionCorta' ||
							$valoresPrincipales['paginaSARA'] == 'publicacionesImpresas' ||
							$valoresPrincipales['paginaSARA'] == 'revistasIndexadas'
							)
						){
							//NO hace ninguna reescritura.
						} else {
							//Se sobreescribe el nombre a uno que posee el bloque internamente
							$nombreLlavePrimaria = getAliasLLavePrimaria($nombreLlavePrimaria);
						}
						
					}					
					if($valorLlave!=NULL){
						$textoGET = $textoGET.$nombreLlavePrimaria.'='.$valorLlave.'&';
					}
				}
				$textoGET = substr($textoGET, 0, -1);//Quita el ultimo &
				//BUG FIX: algunos bloques modificar necesitan un argumento en el REQUEST llamado arreglo
				$textoGET .= '&arreglo=true';
				//Se quitan del arreglo general para liberar memoria
				unset($valoresPrincipales['resultados']);
				unset($valoresPrincipales['llavesPrimarias']);
				
				$nombreObservacion = $this->miConfigurador->fabricaConexiones->crypto->codificar($nombreObservacion);
				$tipoObservacion = $valoresPrincipales['tipoObservacion'];
				
				$resultado['observaciones'] = ($observacion)?$observacion['observacion']:'';
				$resultado['observaciones'] = '<textarea class="text-observacion noselected" placeholder="Escriba su observación" name="'.$nombreObservacion.'">'.$resultado['observaciones'].'</textarea>';
				
				$checked = ($observacion)?($observacion['verificado']=='t')?'checked':'':'';
				$resultado['verificacion'] = '<input type="checkbox" class="checkbox-verificacion" name="'.$nombreObservacion.'" value="'.$tipoObservacion.'" '.$checked.'>';
				//Se arma un arreglo con las llaves primarias para modificar el elemento:
				
				$enlaceModificar = 'pagina='.$valoresPrincipales['paginaSARA'].'&opcion=modificar&documento_docente='.$documento.'&'.$textoGET;
				$enlaceModificar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceModificar, $directorio );
				$resultado['enlace_modificacion'] = '<a href="'.$enlaceModificar.'"><span class="icon-modificar"></span></a>';
				$itemsTabla[] = array_merge($resultado,$valoresPrincipales);
			}
		}
		//unset($items);
		
		// ---------------- CONTROL: data tables --------------------------------------------------------
		
		$campos[] = array(
			'alias_campo' => 'Tipo Puntaje',
			'nombre_campo' => 'tituloTipo',			
		);
		$campos[] = array(
			'alias_campo' => 'Producto',
			'nombre_campo' => 'titulo',
		);
		$campos[] = array(
			'alias_campo' => 'Descripción',
			'nombre_campo' => 'descripcion',			
			'es_arreglo' => true,
		);
		$campos[] = array(
			'alias_campo' => 'Fecha',
			'nombre_campo' => 'fecha_acta',
		);
		$campos[] = array(
			'alias_campo' => 'Acta No.',
			'nombre_campo' => 'numero_acta',
		);
		$campos[] = array(
			'alias_campo' => 'Puntos',
			'nombre_campo' => 'puntaje',
		);
		$campos[] = array(
			'alias_campo' => 'Observaciones',
			'nombre_campo' => 'observaciones',			
		);
		$campos[] = array(
			'alias_campo' => 'Verificación',
			'nombre_campo' => 'verificacion',			
		);
		$campos[] = array(
                'alias_campo' => 'Modificar',
                'nombre_campo' => 'enlace_modificacion',
        );
		
		$atributos ['id'] = 'tablaPuntajeDocente';
		$atributos ['campos'] = $campos;
		//$atributos['campoSeguro'] = true;
		$atributos ['items'] = $itemsTabla;
		echo $this->miFormulario->tabla ( $atributos );
		unset ( $atributos );
		// ---------------- FIN CONTROL: data tables --------------------------------------------------------
		
		// ---------------- CONTROL: reporte pdf --------------------------------------------------------
		$atributos ['id'] = 'reportePDFDocente'; // No cambiar este nombre
		$atributos ['plantilla'] = 'plantilla1.html.php';
		$atributos ['showHTML'] = true;
		$atributos ['showPDF'] = true;
		$atributos ['showButton'] = true;
		
		$enlace = "action=index.php";
		$enlace .= "&bloqueNombre=" . $esteBloque ["nombre"];
		$enlace .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$enlace .= "&procesarAjax=true";
		$enlace .= "&funcion=descargarPDF";
		$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
        $directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
        $directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
        $enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
		/**
		 * Opcional para carga asíncrona, es incompatible con las opciones 
		 *	$atributos ['showHTML']
		 *	$atributos ['showPDF']
		 *	$atributos ['showButton']
		 */
		$atributos ['enlaceAjax'] = $enlace;
		
		//Propios de la plantilla
		$atributos ['datos_docente'] = $datosDocente;
		$atributos ['items'] = $items;
				
		echo '<div style="max-width: 1024px; margin: 0 auto;">';
		echo $this->miFormulario->pdf ( $atributos );
		echo '</div>';
		unset ( $atributos );
		// ---------------- FIN CONTROL: reporte pdf --------------------------------------------------------
		
		 
	
	}
}

$miSeleccionador = new registrarForm ( $this->lenguaje, $this->miFormulario, $this->sql );

$miSeleccionador->miForm ();
?>