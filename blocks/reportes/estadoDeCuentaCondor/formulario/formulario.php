<?php

if (!isset($GLOBALS['autorizado'])) {
	include ('../index.php');
	exit();
}

include_once ('core/builder/InspectorHTML.class.php');

class registrarForm {
	var $miConfigurador;
	var $miInspectorHTML;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	function __construct($lenguaje, $formulario, $sql) {
		$this -> miConfigurador = \Configurador::singleton();

		$this -> miInspectorHTML = \InspectorHTML::singleton();

		$this -> miConfigurador -> fabricaConexiones -> setRecursoDB('principal');

		$this -> lenguaje = $lenguaje;

		$this -> miFormulario = $formulario;

		$this -> miSql = $sql;
	}

	function miForm() {

		// Rescatar los datos de este bloque
		$esteBloque = $this -> miConfigurador -> getVariableConfiguracion('esteBloque');
		$miPaginaActual = $this -> miConfigurador -> getVariableConfiguracion('pagina');

		$directorio = $this -> miConfigurador -> getVariableConfiguracion('host');
		$directorio .= $this -> miConfigurador -> getVariableConfiguracion('site') . '/index.php?';
		$directorio .= $this -> miConfigurador -> getVariableConfiguracion('enlace');

		$rutaUrlBloque = $this -> miConfigurador -> getVariableConfiguracion('host');
		$rutaUrlBloque .= $this -> miConfigurador -> getVariableConfiguracion('site') . '/blocks/';
		$rutaUrlBloque .= $esteBloque['grupo'] . '/' . $esteBloque['nombre'];

		$rutaSara = $this -> miConfigurador -> getVariableConfiguracion('raizDocumento');
		$rutaBloque = $this -> miConfigurador -> getVariableConfiguracion('rutaBloque');

		// -------------------------------------------------------------------------------------------------

		$_REQUEST['tiempo'] = time();

		/*
		 * Validar usuario y clave del servicio
		 */
		$usuarioToken = $this -> miConfigurador -> getVariableConfiguracion('usuarioToken');
		$claveToken = $this -> miConfigurador -> getVariableConfiguracion('claveTokenSha512');
		//Si el token no viene de cóndor se ejecuta una rutina para jwt
		if (!isset($_REQUEST['token'])){
			if (!($_REQUEST['usuario'] == $usuarioToken && hash('sha512', $_REQUEST['clave']) == $claveToken)) {
				sleep(2);
				include ('../index.php');
				exit();
			}
		} else {
			/**
			 * Se valida que se ponga el token correcto desde cóndor.
			 */
			$tokenCondor = $this -> miConfigurador -> getVariableConfiguracion('tokenCondor');
			if (!isset($_REQUEST['token']) || $_REQUEST['token'] != $tokenCondor){
				include ('../index.php');
				exit();
			}
		}
		
		/*
		 * Retornar un token
		 */
		if (isset($_REQUEST['format']) && $_REQUEST['format'] == 'jwt') {
			$token = 'pagina=estadoDeCuentaCondor';
			$token .= '&bloqueNombre=' . $esteBloque['nombre'];
			$token .= '&bloqueGrupo=' . $esteBloque['grupo'];
			$token .= '&expiracion=' . time();
			$token .= '&procesarAjax=true';
			$token .= '&action=query';
			$token .= '&format=json';
			$token .= '&usuario=' . $_REQUEST['usuario'];
			$token .= '&clave=' . $_REQUEST['clave'];
			$token = $this -> miConfigurador -> fabricaConexiones -> crypto -> codificar($token);
			echo $token;
			exit();
		}

		/**
		 * Este código permite hacer la conexión de confianza del bloque con cóndor, el link es válido durante 1 hora
		 * Se deben realizar peticiones de la forma pagina=estadoDeCuentaCondor&docente=79211280&expiracion=1450226796
		 * Ejemplo: http://10.20.0.38/kyron/index.php?data=####
		 */
		if (!isset($_REQUEST['expiracion']) || time() - $_REQUEST['expiracion'] >= 3600) {
			echo '<br/><h1>¡Recurso expiró su sesión!</h1><br/>';
			echo '<br/><h1>Recargue la página.</h1><br/>';
			sleep(2);
			include ('../index.php');
			exit();
		}
		
		$documento = $_REQUEST['docente'];

		$conexion = 'docencia';
		$esteRecursoDB = $this -> miConfigurador -> fabricaConexiones -> getRecursoDB($conexion);

		$cadenaSql = $this -> miSql -> getCadenaSql('datos_docente', $documento);
		$resultado = $esteRecursoDB -> ejecutarAcceso($cadenaSql, 'busqueda');
		if (!$resultado) {
			/* ---------------- SECCION: WebService Puntaje ---------------- */
			if (isset($_REQUEST['format']) && $_REQUEST['format'] == 'json') {
				header('Content-Type: text/json; charset=utf-8');
				echo json_encode(array("errorType" => "retrieve", "errorMessage" => "La consulta no retorna resultados."));
				exit();
			}
			/* ---------------- SECCION: WebService Puntaje ---------------- */
			echo '<h2>No hay datos de este Docente.</h2>';
			return 0;
		}

		$datosDocente = $resultado[0];

		//Almacena todos los resultados del docente
		//$items = array();

		// ---------------- OJO: copiar desde acá a bloque reportes/estadoDeCuentaCondor/formulario/formulario.php ------
		// ---------------- CONSULTA: títulos docente --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'titulos_docente', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'titulo_academico';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Hoja de Vida',
				'_titulo' => 'Títulos Académicos',
				'_tipoObservacion' => '26',
				'_paginaSARA' => 'titulosAcademicos',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: títulos docente --------------------------------------------------------
		
		// ---------------- CONSULTA: revistas indexadas --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'revistas_indexadas', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'revista_indexada';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Revistas Indexadas',
				'_tipoObservacion' => '1',
				'_paginaSARA' => 'revistasIndexadas',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: revistas indexadas --------------------------------------------------------
		
		// ---------------- CONSULTA: capítulos libros --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'capitulos_libros', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'capitulo_libro';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Capítulos de Libros',
				'_tipoObservacion' => '13',
				'_paginaSARA' => 'capituloLibros',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: capítulos libros --------------------------------------------------------
		
		// ---------------- CONSULTA: cartas editor --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'cartas_editor', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'cartas_editor';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Cartas al Editor',
				'_tipoObservacion' => '3',
				'_paginaSARA' => 'cartasEditor',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: cartas editor --------------------------------------------------------
		
		// ---------------- CONSULTA: experiencia dirección académica --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_direccion_academica', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'experiencia_direccion_academica';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Experiencia Dirección Académica',
				'_tipoObservacion' => '5',
				'_paginaSARA' => 'experienciaDireccionAcademica',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: experiencia dirección académica --------------------------------------------------------
		
		// ---------------- CONSULTA: experiencia investigación --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_investigacion', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'experiencia_investigacion';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Experiencia En Investigación',
				'_tipoObservacion' => '7',
				'_paginaSARA' => 'experienciaInvestigacion',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: experiencia investigación --------------------------------------------------------
		
		// ---------------- CONSULTA: experiencia en docencia --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_docencia', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'experiencia_docencia';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Experiencia En Docencia',
				'_tipoObservacion' => '9',
				'_paginaSARA' => 'experienciaDocencia',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: experiencia en docencia --------------------------------------------------------
		
		// ---------------- CONSULTA: experiencia profesional --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_profesional', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'experiencia_profesional';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Experiencia Profesional',
				'_tipoObservacion' => '10',
				'_paginaSARA' => 'experienciaProfesional',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: experiencia profesional --------------------------------------------------------
		
		// ---------------- CONSULTA: experiencia calificada --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_calificada', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'experiencia_calificada';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
		$llavesPrimarias = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$campos[] = array(
				'alias_campo' => 'Tipo Experiencia',
				'nombre_campo' => 'tipo_experiencia_calificada',
		);
		$campos[] = array(
				'alias_campo' => 'Tipo Emisor Resolución',
				'nombre_campo' => 'tipo_emisor_resolucion',
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Experiencia Calificada',
				'_tipoObservacion' => '11',
				'_paginaSARA' => 'experienciaCalificada',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: experiencia calificada --------------------------------------------------------
		/*****NOOOOOOOOOOOOOOOOOOOOOOOOOOTAAAAAAAAAAAA***/ //BLoque que falta por corrregirorrrrr SQL y Campos
		// ---------------- CONSULTA: excelencia académica --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'excelencia_academica', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'excelencia_academica';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Excelencia Académica',
				'_tipoObservacion' => '12',
				'_paginaSARA' => 'excelenciaAcademica',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: excelencia académica --------------------------------------------------------
		
		// ---------------- CONSULTA: comunicación corta --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'comunicacion_corta', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'comunicacion_corta';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Comunicación Corta',
				'_tipoObservacion' => '18',
				'_paginaSARA' => 'comunicacionCorta',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: comunicación corta --------------------------------------------------------
		
		// ---------------- CONSULTA: obras artísticas --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'obras_artisticas', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'obra_artistica';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Obras Artísticas',
				'_tipoObservacion' => '14',
				'_paginaSARA' => 'obrasArtisticas',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: obras artísticas --------------------------------------------------------
		
		// ---------------- CONSULTA: patentes --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'patentes', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'patente';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Patentes',
				'_tipoObservacion' => '15',
				'_paginaSARA' => 'patentes',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: patentes --------------------------------------------------------
		
		// ---------------- CONSULTA: premios docente --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'premios_docente', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'premio_docente';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Premios Docente',
				'_tipoObservacion' => '16',
				'_paginaSARA' => 'premiosDocente',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: premios docente --------------------------------------------------------
		
		// ---------------- CONSULTA: producción vídeos --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'produccion_videos', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'produccion_video';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Producción de Vídeos',
				'_tipoObservacion' => '17',
				'_paginaSARA' => 'produccionDeVideos',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: producción vídeos --------------------------------------------------------
		
		// ---------------- CONSULTA: producción libros --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'produccion_libros', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'libro_docente';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Producción de Libros',
				'_tipoObservacion' => '2',
				'_paginaSARA' => 'produccionDeLibros',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: producción libros --------------------------------------------------------
				
		// ---------------- CONSULTA: traducción libros --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'traduccion_libros', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'traduccion_libro';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Traducción de Libros',
				'_tipoObservacion' => '6',
				'_paginaSARA' => 'traduccionesDeLibros',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: traducción libros --------------------------------------------------------
		
		// ---------------- CONSULTA: producción técnica y software --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'produccion_tecnicaysoftware', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'produccion_tecnicaysoftware';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Producción Técnica y Software Docente',
				'_tipoObservacion' => '8',
				'_paginaSARA' => 'produccionTecnicaYSoftware',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: producción técnica y software --------------------------------------------------------
		
		// ---------------- CONSULTA: publicaciones impresas universitarias --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'publicaciones_impresas_universitarias', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'publicacion_impresa';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'alias_campo' => 'Número Caso Acta',
				'nombre_campo' => 'numero_caso',
		);
		$campos[] = array(
				'alias_campo' => 'Normatividad',
				'nombre_campo' => 'normatividad',
		);
		$items[] = array(
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '2',
				'_tituloTipo' => 'Bonificación',
				'_titulo' => 'Publicaciones Impresas Universitarias',
				'_tipoObservacion' => '19',
				'_paginaSARA' => 'publicacionesImpresas',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: publicaciones impresas universitarias --------------------------------------------------------
		
		// ---------------- CONSULTA: estudios post doctorales --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'estudios_post_doctorales', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'estudio_postdoctoral_docente';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '2',
				'_tituloTipo' => 'Bonificación',
				'_titulo' => 'Estudios Post Doctorales',
				'_tipoObservacion' => '20',
				'_paginaSARA' => 'estudiosPostDoctorales',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: estudios post doctorales --------------------------------------------------------
		
		// ---------------- CONSULTA: reseña crítica --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'resena_critica', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'resena_critica';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '2',
				'_tituloTipo' => 'Bonificación',
				'_titulo' => 'Reseña Crítica',
				'_tipoObservacion' => '21',
				'_paginaSARA' => 'resenaCritica',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: reseña crítica --------------------------------------------------------
				
		// ---------------- CONSULTA: traducción artículos --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'traduccion_articulos', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'traduccion_articulo';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '2',
				'_tituloTipo' => 'Bonificación',
				'_titulo' => 'Traducción de Artículos',
				'_tipoObservacion' => '22',
				'_paginaSARA' => 'traduccionDeArticulos',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: traducción artículos --------------------------------------------------------
		
		// ---------------- CONSULTA: ponencias --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'ponencias', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'ponencia';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '2',
				'_tituloTipo' => 'Bonificación',
				'_titulo' => 'Ponencias',
				'_tipoObservacion' => '23',
				'_paginaSARA' => 'ponenciasDocente',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: ponencias --------------------------------------------------------
		
		// ---------------- CONSULTA: dirección de trabajos salariales --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'direccion_de_trabajos_salariales', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'direccion_trabajogrado';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Dirección de Trabajos de Grado',
				'_tipoObservacion' => '4',
				'_paginaSARA' => 'direccionTrabajosDeGradoSalariales',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: dirección de trabajos salariales --------------------------------------------------------
		
		// ---------------- CONSULTA: dirección de trabajos bonificación --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'direccion_de_trabajos_bonificacion', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'direccion_trabajogrado';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '2',
				'_tituloTipo' => 'Bonificación',
				'_titulo' => 'Dirección de Trabajos de Grado',
				'_tipoObservacion' => '27',
				'_paginaSARA' => 'direccionTrabajosDeGradoBonificacion',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: dirección de trabajos bonificación --------------------------------------------------------
				
		// ---------------- CONSULTA: novedades salariales --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'novedades_salariales', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'novedad';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'nombre_campo' => 'categoria_puntaje',
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '1',
				'_tituloTipo' => 'Salariales',
				'_titulo' => 'Novedades Salariales',
				'_tipoObservacion' => '24',
				'_paginaSARA' => 'novedadesSalariales',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
		);
		unset($campos);
		// ---------------- FIN CONSULTA: novedades salariales --------------------------------------------------------
		
		// ---------------- CONSULTA: novedades bonificación --------------------------------------------------------
		$cadenaSql = $this->miSql->getCadenaSql ( 'novedades_bonificacion', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$tabla = 'novedad';
		$cadenaSql = $this->miSql->getCadenaSql ( 'primary_key_table',  $tabla);
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
				'nombre_campo' => 'categoria_puntaje',
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
				'_resultados' => ($resultado)?$resultado:array(),
				'_tipo' => '2',
				'_tituloTipo' => 'Bonificación',
				'_titulo' => 'Novedades Bonificación',
				'_tipoObservacion' => '25',
				'_paginaSARA' => 'novedadesBonificacion',
				'_llavesPrimarias' => $llavesPrimarias,
				'_descripcion' => $campos,
				'_tablaDocencia' => $tabla
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
			foreach($item['_resultados'] as $resultado){
				/**
				 * Se quiere agregar los valores principales (de las consultas por módulo) a cada uno de los resultados,
				 * esto quiere decir a todas las filas de todos las consultas. Para ello se usa una variable auxiliar
				 * y se le quitan los resultados para que no queden duplicados. Luego se le adicionan parámetros adicionales.
				 */
				$valoresPrincipales = $item;
				$nombreObservacion = obtenerLLavesValor($valoresPrincipales['_llavesPrimarias'],$resultado,$documento);
				$observacion = consultarPorLLavesValor(
					$nombreObservacion,
					$observacionesPorLLaveValor
				);
				//Se genera un string al estilo GET con las llaves primarias
				$textoGET = '';
				$textoCONDICION = '';
				foreach ($valoresPrincipales['_llavesPrimarias'] as $llavesTabla) {
					$nombreLlavePrimaria = $llavesTabla['primarykey'];
					if($nombreLlavePrimaria=='documento_docente'){
						$valorLlave=$documento;
					} else {
						$valorLlave=$resultado[$nombreLlavePrimaria];
					}
					$textoCONDICION = $textoCONDICION.$nombreLlavePrimaria.'=\''.$valorLlave.'\' AND ';
					
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
							$valoresPrincipales['_paginaSARA'] == 'comunicacionCorta' ||
							$valoresPrincipales['_paginaSARA'] == 'publicacionesImpresas' ||
							$valoresPrincipales['_paginaSARA'] == 'revistasIndexadas'
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
				$textoCONDICION = substr($textoCONDICION, 0, -5);//Quita el ultimo ' AND '
				
				$nombreObservacion = $this->miConfigurador->fabricaConexiones->crypto->codificar($nombreObservacion);
				$tipoObservacion = $valoresPrincipales['_tipoObservacion'];
				
				$resultado['observaciones'] = ($observacion)?$observacion['observacion']:'';
				$resultado['observaciones'] = '<textarea class="text-observacion noselected" placeholder="Escriba su observación" name="'.$nombreObservacion.'">'.$resultado['observaciones'].'</textarea>';
				
				$checked = ($observacion)?($observacion['verificado']=='t')?'checked':'':'';
				$resultado['verificacion'] = '<input type="checkbox" class="checkbox-verificacion" name="'.$nombreObservacion.'" value="'.$tipoObservacion.'" '.$checked.'>';
				//Se arma un arreglo con las llaves primarias para modificar el elemento:
				
				$enlaceModificar = 'pagina='.$valoresPrincipales['_paginaSARA'].'&opcion=modificar&documento_docente='.$documento.'&'.$textoGET;
				$enlaceModificar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceModificar, $directorio );
				
				$resultado['_enlace_modificacion'] = '<a href="'.$enlaceModificar.'"><span class="icon-modificar"></span></a>';
				if (isset($perfiles) && in_array('88', $perfiles)){//88 es Jefe Docencia
					$enlaceEliminar = 'action=' . $esteBloque ['nombre'];
					$enlaceEliminar .= '&pagina=' . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
					$enlaceEliminar .= '&bloque=' . $esteBloque ['nombre'];
					$enlaceEliminar .= '&bloqueGrupo=' . $esteBloque ['grupo'];
					$enlaceEliminar .= '&opcion=eliminar';
					$enlaceEliminar .= '&tabla='.$valoresPrincipales['_tablaDocencia'];
					$enlaceEliminar .= '&condicion='.$textoCONDICION;
					$enlaceEliminar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceEliminar, $directorio );
					$resultado['_enlace_eliminacion'] = '<a href="javascript:confirmarEliminar(\''.$enlaceEliminar.'\');"><span class="icon-eliminar"></span></a>';
				}
				//Se quitan del arreglo general para liberar memoria
				unset($valoresPrincipales['_resultados']);
				unset($valoresPrincipales['_llavesPrimarias']);
				
				$itemsTabla[] = array_merge($resultado,$valoresPrincipales);
			}
		}
		//unset($items);
		
		// ---------------- CONTROL: data tables --------------------------------------------------------
		
		$campos[] = array(
			'alias_campo' => 'Tipo Puntaje',
			'nombre_campo' => '_tituloTipo',			
		);
		$campos[] = array(
			'alias_campo' => 'Producto',
			'nombre_campo' => '_titulo',
		);
		$campos[] = array(
			'alias_campo' => 'Descripción',
			'nombre_campo' => '_descripcion',			
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
		// ---------------- OJO: Quitar controles desde acá para el bloque reportes/estadoDeCuentaCondor/formulario/formulario.php ------
		
		// ---------------- OJO: Quitar controles hasta acá para el bloque reportes/estadoDeCuentaCondor/formulario/formulario.php ------
			
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
		
		// ---------------- OJO: copiar hasta acá en bloque reportes/estadoDeCuentaCondor/formulario/formulario.php ------
		// ---------------- OJO: elimine los registros de eliminación del bloque

	}

}

$miSeleccionador = new registrarForm($this -> lenguaje, $this -> miFormulario, $this -> sql);

$miSeleccionador -> miForm();
?>