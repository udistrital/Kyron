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
		
		$documento = $_REQUEST['docente'];		
		
		$conexion = 'docencia';
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'datos_docente', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$datosDocente = $resultado[0];
		
		//Almacena todos los resultados del docente
		//$items = array();
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'titulos_docente', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Hoja de Vida',
				'titulo' => 'Títulos Académicos',
				'titulo1' => 'Titulo',
				'llavevalor1' => 'tipo_titulo_academico',
				'llavevalor2' => 'titulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'revistas_indexadas', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Revistas Indexadas',
				'titulo1' => 'Contexto',
				'llavevalor1' => 'tipo_contexto',
				'llavevalor2' => 'nombre_revista'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'capitulos_libros', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Capítulos de Libros',
				'titulo1' => 'Titulo',
				'llavevalor1' => 'tipo_libro',
				'llavevalor2' => 'titulo_capitulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'cartas_editor', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Cartas al Editor',
				'titulo1' => 'Titulo',
				'llavevalor1' => 'tipo_libro',
				'llavevalor2' => 'nombre_revista'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'direccion_de_trabajos', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Dirección de Trabajos de Grado',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'tipo_trabajogrado',
				'llavevalor2' => 'titulo_trabajogrado'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_direccion_academica', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Experiencia Dirección Académica',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'nombre_tipo_entidad',
				'llavevalor2' => 'nombre_universidad'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_investigacion', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Experiencia En Investigación',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'tipo_experiencia_investigacion',
				'llavevalor2' => 'nombre_universidad'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_docencia', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Experiencia En Docencia',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'nombre_tipo_entidad',
				'llavevalor2' => 'nombre_universidad'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_profesional', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Experiencia Profesional',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'nombre_universidad',
				'llavevalor2' => 'cargo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_calificada', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Experiencia Calificada',
				'titulo1' => 'Categoría',
				'llavevalor1' => 'tipo_experiencia_calificada',
				'llavevalor2' => 'tipo_emisor_resolucion'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'experiencia_direccion_academica', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Experiencia Dirección Académica',
				'titulo1' => 'Dirección',
				'llavevalor1' => 'nombre_tipo_entidad',
				'llavevalor2' => 'nombre_universidad'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'comunicacion_corta', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Comunicación Corta',
				'titulo1' => 'Comunicación',
				'llavevalor1' => 'contexto',
				'llavevalor2' => 'nombre_revista'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'obras_artisticas', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Obras Artísticas',
				'titulo1' => 'Obra',
				'llavevalor1' => 'contexto',
				'llavevalor2' => 'titulo_obra'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'patentes', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Patentes',
				'titulo1' => 'Patente',
				'llavevalor1' => 'tipo_patente',
				'llavevalor2' => 'titulo_patente'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'premios_docente', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Premios Docente',
				'titulo1' => 'Premio',
				'llavevalor1' => 'contexto',
				'llavevalor2' => 'nombre_tipo_entidad'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'produccion_videos', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Producción de Vídeos',
				'titulo1' => 'Producción',
				'llavevalor1' => 'contexto',
				'llavevalor2' => 'titulo_video'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'produccion_libros', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Producción de Libros',
				'titulo1' => 'Producción',
				'llavevalor1' => 'tipo_libro',
				'llavevalor2' => 'titulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'traduccion_libros', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Traducción de Libros',
				'titulo1' => 'Traducción',
				'llavevalor1' => 'normatividad',
				'llavevalor2' => 'titulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'produccion_tecnicaysoftware', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '1',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Producción Técnica y Software Docente',
				'titulo1' => 'Producción',
				'llavevalor1' => 'tipo_tecnicaysoftware',
				'llavevalor2' => 'nombre'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'publicaciones_impresas_universitarias', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '2',
				'tituloTipo' => 'Bonificación',
				'titulo' => 'Publicaciones Impresas Universitarias',
				'titulo1' => 'Publicación',
				'llavevalor1' => 'tipo_indexacion',
				'llavevalor2' => 'titulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'estudios_post_doctorales', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '2',
				'tituloTipo' => 'Bonificación',
				'titulo' => 'Estudios Post Doctorales',
				'titulo1' => 'Estudio',
				'llavevalor1' => 'nombre_universidad',
				'llavevalor2' => 'titulo_obtenido'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'resena_critica', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '2',
				'tituloTipo' => 'Bonificación',
				'titulo' => 'Reseña Crítica',
				'titulo1' => 'Reseña',
				'llavevalor1' => 'tipo_indexacion',
				'llavevalor2' => 'titulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'traduccion_articulos', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '2',
				'tituloTipo' => 'Bonificación',
				'titulo' => 'Traducción de Artículos',
				'titulo1' => 'Artículo',
				'llavevalor1' => 'tipo_traduccion_articulo',
				'llavevalor2' => 'titulo_traduccion'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'ponencias', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '2',
				'tituloTipo' => 'Bonificación',
				'titulo' => 'Ponencias',
				'titulo1' => 'Ponencia',
				'llavevalor1' => 'contexto_ponencia',
				'llavevalor2' => 'titulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'novedades_salariales', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '2',
				'tituloTipo' => 'Salariales',
				'titulo' => 'Novedades',
				'titulo1' => 'Novedad',
				'llavevalor1' => 'contexto_ponencia',
				'llavevalor2' => 'titulo'
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'novedades_bonificacion', $documento );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
		$items[] = array(
				'resultados' => ($resultado)?$resultado:array(),
				'tipo' => '2',
				'tituloTipo' => 'Bonificación',
				'titulo' => 'Novedades',
				'titulo1' => 'Novedad',
				'llavevalor1' => 'tipo_trabajogrado',
				'llavevalor2' => 'titulo_trabajogrado'
		);
		
		$atributos ['id'] = 'reportePDFDocente'; // No cambiar este nombre
		$atributos ['plantilla'] = 'plantilla1.html.php';
		$atributos ['datos_docente'] = $datosDocente;
		$atributos ['items'] = $items;
		$atributos ['showHTML'] = true;
		
		$atributos ['destino'] = $documento;
		echo '<div style="max-width:1024px;margin: 0 auto;">';
		echo $this->miFormulario->pdf ( $atributos );
		echo '</div>';
		unset ( $atributos );
		
	}
}

$miSeleccionador = new registrarForm ( $this->lenguaje, $this->miFormulario, $this->sql );

$miSeleccionador->miForm ();
?>	