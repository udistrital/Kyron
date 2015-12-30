<?php

if (! isset ( $GLOBALS ['autorizado'] )) {
	include ('../index.php');
	exit ();
}
/*
 * Este código permite hacer la conexión de confianza del bloque con cóndor, el link es válido durante 1 hora
 * Se deben realizar peticiones de la forma pagina=estadoDeCuentaCondor&docente=79211280&expiracion=1450226796
 * Ejemplo: http://10.20.0.38/kyron/index.php?data=####
 */
if (! isset ( $_REQUEST ['expiracion'] ) || time() - $_REQUEST ['expiracion'] >= 3600 ) {
	echo '<br/><h1>¡Recurso expiró su sesión!</h1><br/>';
	echo '<br/><h1>Recargue la página.</h1><br/>';
	sleep(2);
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
		
		$_REQUEST['tiempo'] = time();
		
		$documento = $_REQUEST['docente'];		
		
		$conexion = 'docencia';
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'datos_docente', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$datosDocente = $resultado[0];
		
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
				
				unset($valoresPrincipales['resultados']);
				unset($valoresPrincipales['llavesPrimarias']);
				$resultado['observaciones'] = ($observacion)?$observacion['observacion']:'';
				
				$nombreObservacion = $this->miConfigurador->fabricaConexiones->crypto->codificar($nombreObservacion);
				$checked = ($observacion)?($observacion['verificado']==true)?'checked':'':'';
				$resultado['verificacion'] = '<input type="checkbox" name="'.$nombreObservacion.'" value="validado" '.$checked.'>';
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