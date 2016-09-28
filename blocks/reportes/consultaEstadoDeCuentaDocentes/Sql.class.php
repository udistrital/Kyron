<?php

namespace reportes\estadoDeCuentaCondor;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class Sql extends \Sql {
	var $miConfigurador;
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
	}
	function getCadenaSql($tipo, $variable = "") {
		
		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		
		switch ($tipo) {
			
			/**
			 * Clausulas genéricas.
			 * se espera que estén en todos los formularios
			 * que utilicen esta plantilla
			 */
			case "iniciarTransaccion" :
				$cadenaSql = "START TRANSACTION";
				break;
			
			case "finalizarTransaccion" :
				$cadenaSql = "COMMIT";
				break;
			
			case "cancelarTransaccion" :
				$cadenaSql = "ROLLBACK";
				break;
			
			case "eliminarTemp" :
				
				$cadenaSql = "DELETE ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= $prefijo . "tempFormulario ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "id_sesion = '" . $variable . "' ";
				break;
			
			case "insertarTemp" :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= $prefijo . "tempFormulario ";
				$cadenaSql .= "( ";
				$cadenaSql .= "id_sesion, ";
				$cadenaSql .= "formulario, ";
				$cadenaSql .= "campo, ";
				$cadenaSql .= "valor, ";
				$cadenaSql .= "fecha ";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				
				foreach ( $_REQUEST as $clave => $valor ) {
					$cadenaSql .= "( ";
					$cadenaSql .= "'" . $idSesion . "', ";
					$cadenaSql .= "'" . $variable ['formulario'] . "', ";
					$cadenaSql .= "'" . $clave . "', ";
					$cadenaSql .= "'" . $valor . "', ";
					$cadenaSql .= "'" . $variable ['fecha'] . "' ";
					$cadenaSql .= "),";
				}
				
				$cadenaSql = substr ( $cadenaSql, 0, (strlen ( $cadenaSql ) - 1) );
				break;
			
			case "rescatarTemp" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "id_sesion, ";
				$cadenaSql .= "formulario, ";
				$cadenaSql .= "campo, ";
				$cadenaSql .= "valor, ";
				$cadenaSql .= "fecha ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= $prefijo . "tempFormulario ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "id_sesion='" . $idSesion . "'";
				break;
			
			/* Consultas del desarrollo */
				
			case "docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido AS value, ";
				$cadenaSql.=" documento_docente AS data ";
				$cadenaSql.=" FROM ";
				$cadenaSql.=" docencia.docente WHERE documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido ";
				$cadenaSql.=" LIKE '%" . $variable . "%' AND estado = true LIMIT 10;";
				break;
				
			case "datos_docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" pc.nombre AS proyecto_curricular,";
				$cadenaSql.=" fc.nombre AS facultad,";
				$cadenaSql.=" dc.codigo_docente AS codigo_docente,";
				$cadenaSql.=" ge.genero AS genero,";
				$cadenaSql.=" dc.estado AS estado,";
				$cadenaSql.=" dc.documento_docente AS documento_docente";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.docente AS dc";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON dc_pc.documento_docente = dc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.proyectocurricular AS pc ON pc.id_proyectocurricular = dc_pc.id_proyectocurricular";
				$cadenaSql.=" LEFT JOIN docencia.facultad AS fc ON fc.id_facultad = pc.id_facultad";
				$cadenaSql.=" LEFT JOIN docencia.genero AS ge ON ge.id_genero = dc.id_genero";
				$cadenaSql.=" WHERE dc.documento_docente='". $variable."'";
				$cadenaSql.=" AND dc.estado = true";
				$cadenaSql.=" ;";
				break;
				
			case "titulos_docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_titulo_academico AS id_titulo_academico,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" c.tipo AS tipo_titulo_academico,";
				$cadenaSql.=" a.titulo AS titulo,";
				$cadenaSql.=" d.nombre_universidad AS universidad,";
				$cadenaSql.=" e.paisnombre AS pais,";
				$cadenaSql.=" a.anno AS anno,";
				$cadenaSql.=" b.modalidad AS modalidad,";
				$cadenaSql.=" a.resolucion AS resolucion,";
				$cadenaSql.=" a.fecha_resolucion AS fecha_resolucion,";
				$cadenaSql.=" a.entidad_convalidacion AS entidad_convalidacion,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_caso AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.titulo_academico AS a";
				$cadenaSql.=" LEFT JOIN docencia.modalidad_titulo_academico AS b ON b.id_modalidad_titulo_academico = a.id_modalidad_titulo_academico";
				$cadenaSql.=" LEFT JOIN docencia.tipo_titulo_academico AS c ON c.id_tipo_titulo_academico = a.id_tipo_titulo_academico";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS d ON d.id_universidad = a.id_universidad";
				$cadenaSql.=" LEFT JOIN docencia.pais AS e ON e.paiscodigo = a.paiscodigo";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY titulo ASC";
				$cadenaSql.=" ;";
				break;
				
			case "revistas_indexadas" :
				$cadenaSql=" SELECT";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.nombre_revista AS nombre_revista,";
				$cadenaSql.=" b.descripcion AS contexto,";
				$cadenaSql.=" d.paisnombre AS pais,";
				$cadenaSql.=" c.descripcion AS tipo_indexacion,";
				$cadenaSql.=" a.numero_issn AS numero_issn,";
				$cadenaSql.=" a.anno_publicacion AS anno_publicacion,";
				$cadenaSql.=" a.volumen_revista AS volumen_revista,";
				$cadenaSql.=" a.numero_revista AS numero_revista,";
				$cadenaSql.=" a.paginas_revista AS paginas_revista,";
				$cadenaSql.=" a.titulo_articulo AS titulo_articulo,";
				$cadenaSql.=" a.numero_autores AS numero_autores,";
				$cadenaSql.=" a.numero_autores_ud AS numero_autores_ud,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_caso AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.revista_indexada AS a";
				$cadenaSql.=" LEFT JOIN docencia.contexto AS b ON b.id_contexto = a.id_contexto";
				$cadenaSql.=" LEFT JOIN docencia.tipo_indexacion AS c ON c.id_tipo_indexacion = a.id_tipo_indexacion";
				$cadenaSql.=" LEFT JOIN docencia.pais AS d ON d.paiscodigo = a.paiscodigo";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY nombre_revista ASC";
				$cadenaSql.=" ;";
				break;
				
			case "capitulos_libros" :
				$cadenaSql=" SELECT";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.titulo_capitulo AS titulo_capitulo,";
				$cadenaSql.=" a.titulo_libro AS titulo_libro,";
				$cadenaSql.=" c.tipo_libro AS tipo_libro,";
				$cadenaSql.=" a.codigo_isbn AS codigo_isbn,";
				$cadenaSql.=" b.nombre_editorial AS editorial,";
				$cadenaSql.=" a.anno_publicacion AS anno_publicacion,";
				$cadenaSql.=" a.volumen AS volumen,";
				$cadenaSql.=" a.numero_autores_capitulo AS numero_autores_capitulo,";
				$cadenaSql.=" a.numero_autores_capitulo_ud AS numero_autores_capitulo_ud,";
				$cadenaSql.=" a.numero_autores_libro AS numero_autores_libro,";
				$cadenaSql.=" a.numero_autores_libro_ud AS numero_autores_libro_ud,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_caso AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad,";
				//$cadenaSql.=" a.estado AS estado,";
				$cadenaSql.=" array_to_string(array(";
				$cadenaSql.=" SELECT";
				$cadenaSql.=" '( Documento: '||d.documento_evaluador||', '||";
				$cadenaSql.=" 'Nombre: '||d.nombre||', '||";
				$cadenaSql.=" 'Universidad: '||e.nombre_universidad||', '||";
				$cadenaSql.=" 'Puntaje: '||d.puntaje||' )'";
				$cadenaSql.=" FROM docencia.evaluador_capitulo_libro AS d";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS e ON e.id_universidad = d.id_universidad";
				$cadenaSql.=" WHERE d.documento_docente = a.documento_docente";
				$cadenaSql.=" AND d.codigo_isbn = a.codigo_isbn";
				$cadenaSql.=" AND d.estado = true";
				$cadenaSql.=" ), ',') AS evaluadores";
				$cadenaSql.=" FROM docencia.capitulo_libro AS a";
				$cadenaSql.=" LEFT JOIN docencia.editorial AS b ON b.id_editorial = a.id_editorial";
				$cadenaSql.=" LEFT JOIN docencia.tipo_libro AS c ON c.id_tipo_libro = a.id_tipo_libro";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY titulo_capitulo ASC";
				$cadenaSql.=" ;";
				break;
				
			case "cartas_editor" :
				$cadenaSql=" SELECT";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.nombre_revista AS nombre_revista,";
				$cadenaSql.=" b.descripcion AS contexto,";
				$cadenaSql.=" d.paisnombre AS pais,";
				$cadenaSql.=" c.descripcion AS tipo_indexacion,";
				$cadenaSql.=" a.numero_issn AS numero_issn,";
				$cadenaSql.=" a.anno_publicacion AS anno_publicacion,";
				$cadenaSql.=" a.volumen_revista AS volumen_revista,";
				$cadenaSql.=" a.numero_revista AS numero_revista,";
				$cadenaSql.=" a.paginas_revista AS paginas_revista,";
				$cadenaSql.=" a.titulo_articulo AS titulo_articulo,";
				$cadenaSql.=" a.numero_autores AS numero_autores,";
				$cadenaSql.=" a.numero_autores_ud AS numero_autores_ud,";
				$cadenaSql.=" a.fecha_publicacion AS fecha_publicacion,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_caso AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				//$cadenaSql.=" a.estado AS estado,";
				$cadenaSql.=" a.normatividad AS normatividad";
				$cadenaSql.=" FROM docencia.cartas_editor AS a";
				$cadenaSql.=" LEFT JOIN docencia.contexto AS b ON b.id_contexto = a.id_contexto";
				$cadenaSql.=" LEFT JOIN docencia.tipo_indexacion AS c ON c.id_tipo_indexacion = a.id_tipo_indexacion";
				$cadenaSql.=" LEFT JOIN docencia.pais AS d ON d.paiscodigo = a.paiscodigo";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY nombre_revista ASC";
				$cadenaSql.=" ;";
				break;
				
			case "direccion_de_trabajos" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_direccion_trabajogrado AS id_direccion_trabajogrado,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" c.nombre_tipo_trabajogrado AS tipo_trabajogrado,";
				$cadenaSql.=" b.nombre_categoria_trabajogrado AS categoria_trabajogrado,";
				$cadenaSql.=" a.numero_autores AS numero_autores,";
				$cadenaSql.=" a.titulo_trabajogrado AS titulo_trabajogrado,";
				$cadenaSql.=" a.anno_direccion AS anno_direccion,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.caso_acta AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				//$cadenaSql.=" a.estado AS estado,";
				$cadenaSql.=" a.normatividad AS normatividad,";
				$cadenaSql.=" array_to_string(array(";
				$cadenaSql.=" SELECT";
				$cadenaSql.=" '( Código Estudiante: '||d.codigo_estudiante||', '||";
				$cadenaSql.=" 'Nombre: '||d.nombre_estudiante||' )'";
				$cadenaSql.=" FROM docencia.direccion_trabajogrado_estudiante AS d";
				$cadenaSql.=" WHERE d.id_direccion_trabajogrado = a.id_direccion_trabajogrado";
				$cadenaSql.=" AND d.estado = true";
				$cadenaSql.=" ), ',') AS estudiantes";
				$cadenaSql.=" FROM docencia.direccion_trabajogrado AS a";
				$cadenaSql.=" LEFT JOIN docencia.categoria_trabajogrado AS b ON b.id_categoria_trabajogrado = a.id_categoria_trabajogrado";
				$cadenaSql.=" LEFT JOIN docencia.tipo_trabajogrado AS c ON c.id_tipo_trabajogrado = a.id_tipo_trabajogrado";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY titulo_trabajogrado ASC";
				$cadenaSql.=" ;";
				break;
				
			case "experiencia_direccion_academica" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_experiencia_direccion_academica AS id_experiencia_direccion_academica,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" c.nombre_universidad AS universidad,";
				$cadenaSql.=" a.otra_entidad AS otra_entidad,";
				$cadenaSql.=" b.nombre_tipo_entidad AS tipo_entidad,";
				$cadenaSql.=" a.horas_semana AS horas_semana,";
				$cadenaSql.=" a.fecha_inicio AS fecha_inicio,";
				$cadenaSql.=" a.fecha_finalizacion AS fecha_finalizacion,";
				$cadenaSql.=" a.dias_experiencia AS dias_experiencia,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.caso_acta AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.experiencia_direccion_academica AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_entidad AS b ON b.id_tipo_entidad = a.id_tipo_entidad";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS c ON c.id_universidad = a.id_universidad";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY universidad ASC";
				$cadenaSql.=" ;";
				break;

			case "experiencia_investigacion" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_experiencia_investigacion AS id_experiencia_investigacion,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" c.nombre_universidad AS universidad,";
				$cadenaSql.=" a.otra_entidad AS otra_entidad,";
				$cadenaSql.=" b.descripcion AS tipo_experiencia_investigacion,";
				$cadenaSql.=" a.horas_semana AS horas_semana,";
				$cadenaSql.=" a.fecha_inicio AS fecha_inicio,";
				$cadenaSql.=" a.fecha_finalizacion AS fecha_finalizacion,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.caso_acta AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.experiencia_investigacion AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_experiencia_investigacion AS b ON b.id_tipo_experiencia_investigacion = a.id_tipo_experiencia_investigacion";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS c ON c.id_universidad = a.id_universidad";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY universidad ASC";
				$cadenaSql.=" ;";
				break;
				
			case "experiencia_docencia" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_experiencia_docencia AS id_experiencia_docencia,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" c.nombre_universidad AS universidad,";
				$cadenaSql.=" a.otra_entidad AS otra_entidad,";
				$cadenaSql.=" b.nombre_tipo_entidad AS tipo_entidad,";
				$cadenaSql.=" a.horas_semana AS horas_semana,";
				$cadenaSql.=" a.fecha_inicio AS fecha_inicio,";
				$cadenaSql.=" a.fecha_finalizacion AS fecha_finalizacion,";
				$cadenaSql.=" a.dias_experiencia AS dias_experiencia,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.caso_acta AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.experiencia_docencia AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_entidad AS b ON b.id_tipo_entidad = a.id_tipo_entidad";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS c ON c.id_universidad = a.id_universidad";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY universidad ASC";
				$cadenaSql.=" ;";
				break;
				
			case "experiencia_profesional" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_experiencia_profesional AS id_experiencia_profesional,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" b.nombre_universidad AS universidad,";
				$cadenaSql.=" a.otra_entidad AS otra_entidad,";
				$cadenaSql.=" a.cargo AS cargo,";
				$cadenaSql.=" a.fecha_inicio AS fecha_inicio,";
				$cadenaSql.=" a.fecha_finalizacion AS fecha_finalizacion,";
				$cadenaSql.=" a.dias_experiencia AS dias_experiencia,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.caso_acta AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.experiencia_profesional AS a";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS b ON b.id_universidad = a.id_universidad";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY universidad ASC";
				$cadenaSql.=" ;";
				break;
				
			case "experiencia_calificada" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_experiencia_calificada AS id_experiencia_calificada,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" b.descripcion AS tipo_experiencia_calificada,";
				$cadenaSql.=" a.annio_experiencia AS annio_experiencia,";
				$cadenaSql.=" a.numero_resolucion AS numero_resolucion,";
				$cadenaSql.=" b.descripcion AS tipo_emisor_resolucion,";
				$cadenaSql.=" a.fecha_resolucion AS fecha_resolucion,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" '' AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.experiencia_calificada AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_emisor_resolucion AS b ON b.id_tipo_emisor_resolucion = a.id_tipo_emisor_resolucion";
				$cadenaSql.=" LEFT JOIN docencia.tipo_experiencia_calificada AS c ON c.id_tipo_experiencia_calificada = a.id_tipo_experiencia_calificada";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY tipo_experiencia_calificada ASC";
				$cadenaSql.=" ;";
				break;
				
			case "excelencia_academica" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_excelencia_academica AS id_excelencia_academica,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.annio_otorgamiento AS annio_otorgamiento,";
				$cadenaSql.=" a.numero_resolucion AS numero_resolucion,";
				$cadenaSql.=" a.fecha_resolucion AS fecha_resolucion,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.excelencia_academica AS a";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY annio_otorgamiento ASC";
				$cadenaSql.=" ;";
				break;
				
			case "comunicacion_corta" :
				$cadenaSql=" SELECT";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.nombre_revista AS nombre_revista,";
				$cadenaSql.=" b.descripcion AS contexto,";
				$cadenaSql.=" d.paisnombre AS pais,";
				$cadenaSql.=" c.descripcion AS tipo_indexacion,";
				$cadenaSql.=" a.numero_issn AS numero_issn,";
				$cadenaSql.=" a.anno_publicacion AS anno_publicacion,";
				$cadenaSql.=" a.volumen_revista AS volumen_revista,";
				$cadenaSql.=" a.numero_revista AS numero_revista,";
				$cadenaSql.=" a.paginas_revista AS paginas_revista,";
				$cadenaSql.=" a.titulo_articulo AS titulo_articulo,";
				$cadenaSql.=" a.numero_autores AS numero_autores,";
				$cadenaSql.=" a.numero_autores_ud AS numero_autores_ud,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_caso AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.comunicacion_corta AS a";
				$cadenaSql.=" LEFT JOIN docencia.contexto AS b ON b.id_contexto = a.id_contexto";
				$cadenaSql.=" LEFT JOIN docencia.tipo_indexacion AS c ON c.id_tipo_indexacion = a.id_tipo_indexacion";
				$cadenaSql.=" LEFT JOIN docencia.pais AS d ON d.paiscodigo = a.paiscodigo";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY nombre_revista ASC";
				$cadenaSql.=" ;";
				break;
				
			case "obras_artisticas" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_obra_artistica AS id_obra_artistica,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" c.descripcion AS tipo_obra_artistica,";
				$cadenaSql.=" a.titulo_obra AS titulo_obra,";
				$cadenaSql.=" a.certificador AS certificador,";
				$cadenaSql.=" b.descripcion AS contexto,";
				$cadenaSql.=" a.anno_obra AS anno_obra,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_caso AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.obra_artistica AS a";
				$cadenaSql.=" LEFT JOIN docencia.contexto AS b ON b.id_contexto = a.id_contexto";
				$cadenaSql.=" LEFT JOIN docencia.tipo_obra_artistica AS c ON c.id_tipo_obra_artistica = a.id_tipo_obra_artistica";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY titulo_obra ASC";
				$cadenaSql.=" ;";
				break;
				
			case "patentes" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_patente AS id_patente,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" b.descripcion AS tipo_patente,";
				$cadenaSql.=" a.titulo_patente AS titulo_patente,";
				$cadenaSql.=" c.nombre_universidad AS universidad,";
				$cadenaSql.=" d.paisnombre AS pais,";
				$cadenaSql.=" a.anno_obtencion AS anno_obtencion,";
				$cadenaSql.=" a.concepto_patente AS concepto_patente,";
				$cadenaSql.=" a.numero_registro AS numero_registro,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_caso AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.patente AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_patente AS b ON b.id_tipo_patente = a.id_tipo_patente";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS c ON c.id_universidad = a.id_universidad";
				$cadenaSql.=" LEFT JOIN docencia.pais AS d ON d.paiscodigo = a.paiscodigo";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY titulo_patente ASC";
				$cadenaSql.=" ;";
				break;
				
			case "premios_docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_premio_docente AS id_premio_docente,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" d.nombre_universidad AS universidad,";
				$cadenaSql.=" a.otra_entidad AS otra_entidad,";
				$cadenaSql.=" c.nombre_tipo_entidad AS tipo_entidad,";
				$cadenaSql.=" b.descripcion AS contexto,";
				$cadenaSql.=" e.paisnombre AS pais,";
				$cadenaSql.=" f.ciudadnombre AS ciudad,";
				$cadenaSql.=" a.concepto_premio AS concepto_premio,";
				$cadenaSql.=" a.fecha_premio AS fecha_premio,";
				$cadenaSql.=" a.numero_condecorados AS numero_condecorados,";
				$cadenaSql.=" a.anno_premio AS anno_premio,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.caso_acta AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.premio_docente AS a";
				$cadenaSql.=" LEFT JOIN docencia.contexto AS b ON b.id_contexto = a.id_contexto";
				$cadenaSql.=" LEFT JOIN docencia.tipo_entidad AS c ON c.id_tipo_entidad = a.id_tipo_entidad";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS d ON d.id_universidad = a.id_universidad";
				$cadenaSql.=" LEFT JOIN docencia.pais AS e ON e.paiscodigo = a.paiscodigo";
				$cadenaSql.=" LEFT JOIN docencia.ciudad AS f ON f.ciudadid = a.ciudadid";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY universidad ASC";
				$cadenaSql.=" ;";
				break;
				
			case "produccion_videos" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_produccion_video AS id_produccion_video,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.titulo_video AS titulo_video,";
				$cadenaSql.=" a.numero_autores AS numero_autores,";
				$cadenaSql.=" a.numero_autores_ud AS numero_autores_ud,";
				$cadenaSql.=" a.fecha_realizacion AS fecha_realizacion,";
				$cadenaSql.=" c.descripcion AS contexto,";
				$cadenaSql.=" b.descripcion AS caracter_video,";
				$cadenaSql.=" a.numero_evaluadores AS numero_evaluadores,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.caso_acta AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad,";
				//$cadenaSql.=" a.estado AS estado,";
				$cadenaSql.=" array_to_string(array(";
				$cadenaSql.=" SELECT";
				$cadenaSql.=" '( Nombre: '||d.nombre_evaluador||', '||";
				$cadenaSql.=" 'Universidad: '||e.nombre_universidad||', '||";
				$cadenaSql.=" 'Puntaje: '||d.puntaje||' )'";
				$cadenaSql.=" FROM docencia.evaluador_produccion_video AS d";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS e ON e.id_universidad = d.id_universidad";
				$cadenaSql.=" WHERE d.id_produccion_video = a.id_produccion_video";
				$cadenaSql.=" AND d.estado = true";
				$cadenaSql.=" ), ',') AS evaluadores";
				$cadenaSql.=" FROM docencia.produccion_video AS a";
				$cadenaSql.=" LEFT JOIN docencia.caracter_video AS b ON b.id_caracter_video = a.id_caracter_video";
				$cadenaSql.=" LEFT JOIN docencia.contexto AS c ON c.id_contexto = a.id_contexto";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY titulo_video ASC";
				$cadenaSql.=" ;";
				break;
				
			case "produccion_libros" :
				$cadenaSql=" SELECT";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.titulo AS titulo,";
				$cadenaSql.=" c.tipo_libro AS tipo_libro,";
				$cadenaSql.=" d.nombre_universidad AS universidad,";
				$cadenaSql.=" a.codigo_isbn AS codigo_isbn,";
				$cadenaSql.=" a.anno_publicacion AS anno_publicacion,";
				$cadenaSql.=" a.numero_autores AS numero_autores,";
				$cadenaSql.=" a.numero_autores_ud AS numero_autores_ud,";
				$cadenaSql.=" b.nombre_editorial AS editorial,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_caso AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad,";
				//$cadenaSql.=" a.estado AS estado,";
				$cadenaSql.=" array_to_string(array(";
				$cadenaSql.=" SELECT";
				$cadenaSql.=" '( Documento: '||e.documento_evaluador||', '||";
				$cadenaSql.=" 'Nombre: '||e.nombre||', '||";
				$cadenaSql.=" 'Universidad: '||f.nombre_universidad||', '||";
				$cadenaSql.=" 'Puntaje: '||e.puntaje||' )'";
				$cadenaSql.=" FROM docencia.evaluador_libro_docente AS e";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS f ON f.id_universidad = e.id_universidad";
				$cadenaSql.=" WHERE e.documento_docente = a.documento_docente";
				$cadenaSql.=" AND e.codigo_isbn = a.codigo_isbn";
				$cadenaSql.=" AND e.estado = true";
				$cadenaSql.=" ), ',') AS evaluadores";
				$cadenaSql.=" FROM docencia.libro_docente AS a";
				$cadenaSql.=" LEFT JOIN docencia.editorial AS b ON b.id_editorial = a.id_editorial";
				$cadenaSql.=" LEFT JOIN docencia.tipo_libro AS c ON c.id_tipo_libro = a.id_tipo_libro";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS d ON d.id_universidad = a.id_universidad";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY titulo ASC";
				$cadenaSql.=" ;";
				break;
				
			case "traduccion_libros" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_traduccion_libro AS id_traduccion_libro,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.titulo AS titulo,";
				$cadenaSql.=" a.nombre_autor_original AS nombre_autor_original,";
				$cadenaSql.=" a.anno_traduccion AS anno_traduccion,";
				$cadenaSql.=" a.anno_publicacion AS anno_publicacion,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_caso AS numero_caso,";
				$cadenaSql.=" a.volumen AS volumen,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.traduccion_libro AS a";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY titulo ASC";
				$cadenaSql.=" ;";
				break;
				
			case "produccion_tecnicaysoftware" :
				$cadenaSql=" SELECT";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.nombre AS nombre,";
				$cadenaSql.=" b.nombre AS tipo_tecnicaysoftware,";
				$cadenaSql.=" a.numero_certificado AS numero_certificado,";
				$cadenaSql.=" a.anno_produccion AS anno_produccion,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_caso AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad,";
				//$cadenaSql.=" a.estado AS estado,";
				$cadenaSql.=" array_to_string(array(";
				$cadenaSql.=" SELECT";
				$cadenaSql.=" '( Documento: '||c.documento_evaluador||', '||";
				$cadenaSql.=" 'Nombre: '||c.nombre||', '||";
				$cadenaSql.=" 'Universidad: '||d.nombre_universidad||', '||";
				$cadenaSql.=" 'Puntaje: '||c.puntaje||' )'";
				$cadenaSql.=" FROM docencia.evaluador_produccion_tecnicaysoftware AS c";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS d ON d.id_universidad = c.id_universidad";
				$cadenaSql.=" WHERE c.documento_docente = a.documento_docente";
				$cadenaSql.=" AND c.numero_certificado = a.numero_certificado";
				$cadenaSql.=" AND c.estado = true";
				$cadenaSql.=" ), ',') AS evaluadores";
				$cadenaSql.=" FROM docencia.produccion_tecnicaysoftware AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_tecnicaysoftware AS b ON b.id_tipo_tecnicaysoftware = a.id_tipo_tecnicaysoftware";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY nombre ASC";
				$cadenaSql.=" ;";
				break;
				
			case "publicaciones_impresas_universitarias" :
				$cadenaSql=" SELECT";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.titulo AS titulo,";
				$cadenaSql.=" a.numero_issn AS numero_issn,";
				$cadenaSql.=" a.nombre_revista AS nombre_revista,";
				$cadenaSql.=" a.numero_revista AS numero_revista,";
				$cadenaSql.=" a.volumen_revista AS volumen_revista,";
				$cadenaSql.=" a.anno_revista AS anno_revista,";
				$cadenaSql.=" b.descripcion AS tipo_indexacion,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_caso AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.publicacion_impresa AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_indexacion AS b ON b.id_tipo_indexacion = a.id_tipo_indexacion";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY titulo ASC";
				$cadenaSql.=" ;";
				break;
				
			case "estudios_post_doctorales" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_estudio_postdoctoral_docente AS id_estudio_postdoctoral_docente,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.titulo_obtenido AS titulo_obtenido,";
				$cadenaSql.=" a.fecha_obtencion AS fecha_obtencion,";
				$cadenaSql.=" b.nombre_universidad AS universidad,";
				$cadenaSql.=" a.otra_entidad AS otra_entidad,";
				$cadenaSql.=" a.annos_doctorado AS annos_doctorado,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.caso_acta AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.estudio_postdoctoral_docente AS a";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS b ON b.id_universidad = a.id_universidad";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY titulo_obtenido ASC";
				$cadenaSql.=" ;";
				break;
				
			case "resena_critica" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_resena_critica AS id_resena_critica,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.titulo AS titulo,";
				$cadenaSql.=" a.revista AS revista,";
				$cadenaSql.=" b.descripcion AS tipo_indexacion,";
				$cadenaSql.=" a.anno AS anno,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.caso_acta AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.resena_critica AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_indexacion AS b ON b.id_tipo_indexacion = a.id_tipo_indexacion";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY titulo ASC";
				$cadenaSql.=" ;";
				break;
				
			case "traduccion_articulos" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_traduccion_articulo AS id_traduccion_articulo,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.titulo_publicacion AS titulo_publicacion,";
				$cadenaSql.=" a.titulo_traduccion AS titulo_traduccion,";
				$cadenaSql.=" b.descripcion AS tipo_traduccion_articulo,";
				$cadenaSql.=" a.fecha_traduccion AS fecha_traduccion,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_caso AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.traduccion_articulo AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_traduccion_articulo AS b ON b.id_tipo_traduccion_articulo = a.id_tipo_traduccion_articulo";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY titulo_publicacion ASC";
				$cadenaSql.=" ;";
				break;
				
			case "ponencias" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_ponencia AS id_ponencia,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.titulo AS titulo,";
				$cadenaSql.=" a.numero_autores AS numero_autores,";
				$cadenaSql.=" a.numero_autores_ud AS numero_autores_ud,";
				$cadenaSql.=" a.anno AS anno,";
				$cadenaSql.=" b.descripcion AS contexto_ponencia,";
				$cadenaSql.=" a.evento_presentacion AS evento_presentacion,";
				$cadenaSql.=" a.institucion_certificadora AS institucion_certificadora,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.caso_acta AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad";
				//$cadenaSql.=" a.estado AS estado";
				$cadenaSql.=" FROM docencia.ponencia AS a";
				$cadenaSql.=" LEFT JOIN docencia.contexto_ponencia AS b ON b.id_contexto_ponencia = a.id_contexto_ponencia";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY titulo ASC";
				$cadenaSql.=" ;";
				break;
							
			case "novedades_salariales" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_novedad AS id_novedad,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.descripcion AS descripcion,";
				$cadenaSql.=" b.tipo_novedad AS tipo_novedad,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_caso AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad,";
				//$cadenaSql.=" a.estado AS estado,";
				$cadenaSql.=" c.categoria_puntaje AS categoria_puntaje";
				$cadenaSql.=" FROM docencia.novedad AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_novedad AS b ON b.id_tipo_novedad = a.id_tipo_novedad";
				$cadenaSql.=" LEFT JOIN docencia.categoria_puntaje AS c ON c.id_categoria_puntaje = b.id_categoria_puntaje";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND c.id_categoria_puntaje = '1'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY descripcion ASC";
				$cadenaSql.=" ;";
				break;
				
			case "novedades_bonificacion" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.id_novedad AS id_novedad,";
				//$cadenaSql.=" a.documento_docente AS documento_docente,";
				$cadenaSql.=" a.descripcion AS descripcion,";
				$cadenaSql.=" b.tipo_novedad AS tipo_novedad,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_caso AS numero_caso,";
				$cadenaSql.=" a.puntaje AS puntaje,";
				$cadenaSql.=" a.normatividad AS normatividad,";
				//$cadenaSql.=" a.estado AS estado,";
				$cadenaSql.=" c.categoria_puntaje AS categoria_puntaje";
				$cadenaSql.=" FROM docencia.novedad AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_novedad AS b ON b.id_tipo_novedad = a.id_tipo_novedad";
				$cadenaSql.=" LEFT JOIN docencia.categoria_puntaje AS c ON c.id_categoria_puntaje = b.id_categoria_puntaje";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" AND c.id_categoria_puntaje = '2'";
				$cadenaSql.=" AND a.estado = true";
				$cadenaSql.=" ORDER BY descripcion ASC";
				$cadenaSql.=" ;";
				break;
			
			case 'primary_key_table':
				$cadenaSql=" SELECT a.attname AS primarykey";
				$cadenaSql.=" FROM pg_index i";
				$cadenaSql.=" JOIN pg_attribute a ON a.attrelid = i.indrelid";
				$cadenaSql.=" AND a.attnum = ANY(i.indkey)";
				$cadenaSql.=" WHERE i.indrelid = 'docencia.".$variable."'::regclass";
				$cadenaSql.=" AND i.indisprimary;";
				break;
				
			case 'observaciones':
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.llaves_primarias_valor AS llaves_primarias_valor,";
				$cadenaSql.=" a.id_tipo_observacion AS id_tipo_observacion,";
				$cadenaSql.=" a.observacion AS observacion,";
				$cadenaSql.=" a.verificado AS verificado";
				$cadenaSql.=" FROM docencia.observacion_verificacion AS a";
				$cadenaSql.=" WHERE a.documento_docente='".$variable."'";
				$cadenaSql.=" ORDER BY id_tipo_observacion ASC";
				$cadenaSql.=" ;";
				break;
			
			case 'registrar_observacion':
				$cadenaSql=" INSERT INTO docencia.observacion_verificacion";
				$cadenaSql.=" (";
				$cadenaSql.=" llaves_primarias_valor,";
				$cadenaSql.=" documento_docente,";
				$cadenaSql.=" id_tipo_observacion,";
				$cadenaSql.=" observacion,";
				$cadenaSql.=" verificado";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES";
				$cadenaSql.=" (";
				$cadenaSql.=" '" . $variable ['llaves_primarias_valor'] . "',";
				$cadenaSql.=" '" . $variable ['docente'] . "',";
				$cadenaSql.=" '" . $variable ['id_tipo_observacion'] . "',";
				$cadenaSql.=" '" . $variable ['observacion'] . "',";
				$cadenaSql.=" '" . $variable ['verificado'] . "'";
				$cadenaSql.=" )";
				$cadenaSql.=" ;";
				break;
				
			case 'actualizar_observacion' :
				$cadenaSql=" UPDATE docencia.observacion_verificacion";
				$cadenaSql.=" SET";
				$cadenaSql.=" observacion='" . $variable ['observacion'] . "',";
				$cadenaSql.=" verificado='" . $variable ['verificado'] . "'";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" llaves_primarias_valor ='" . $variable ['llaves_primarias_valor'] . "'";
				$cadenaSql.=" ;";
				break;
		}
		
		return $cadenaSql;
	}
}

?>
