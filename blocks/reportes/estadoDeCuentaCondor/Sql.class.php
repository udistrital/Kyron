<?php

namespace reportes\estadoDeCuenta;

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
				
			case "datos_docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" pc.nombre AS proyecto_curricular,";
				$cadenaSql.=" fc.nombre AS facultad,";
				$cadenaSql.=" dc.documento_docente AS documento_docente";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.docente AS dc";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON dc_pc.documento_docente = dc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.proyectocurricular AS pc ON pc.id_proyectocurricular = dc_pc.id_proyectocurricular";
				$cadenaSql.=" LEFT JOIN docencia.facultad AS fc ON fc.id_facultad = pc.id_facultad";
				$cadenaSql.=" WHERE dc.documento_docente='". $variable."'";
				$cadenaSql.=" ;";
				break;
				
			case "titulos_docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" ta.titulo AS titulo,";
				$cadenaSql.=" ta.fecha_acta AS fecha_acta,";
				$cadenaSql.=" ta.numero_acta AS numero_acta,";
				$cadenaSql.=" ta.puntaje AS puntaje,";
				$cadenaSql.=" tta.tipo AS tipo_titulo_academico";
				$cadenaSql.=" FROM docencia.titulo_academico AS ta";
				$cadenaSql.=" LEFT JOIN docencia.tipo_titulo_academico AS tta ON tta.id_tipo_titulo_academico = ta.id_tipo_titulo_academico";
				$cadenaSql.=" WHERE ta.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY ta.id_tipo_titulo_academico ASC";				
				$cadenaSql.=" ;";
				break;
				
			case "revistas_indexadas" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" b.descripcion AS tipo_contexto,";
				$cadenaSql.=" c.descripcion AS tipo_indexacion,";
				$cadenaSql.=" a.nombre_revista AS nombre_revista,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.revista_indexada AS a";
				$cadenaSql.=" LEFT JOIN docencia.contexto AS b ON b.id_contexto = a.id_contexto";
				$cadenaSql.=" LEFT JOIN docencia.tipo_indexacion AS c ON c.id_tipo_indexacion = a.id_tipo_indexacion";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY b.descripcion ASC";
				$cadenaSql.=" ;";
				break;
				
			case "capitulos_libros" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" b.nombre_editorial AS editorial,";
				$cadenaSql.=" c.tipo_libro AS tipo_libro,";
				$cadenaSql.=" a.titulo_capitulo AS titulo_capitulo,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.capitulo_libro AS a";
				$cadenaSql.=" LEFT JOIN docencia.editorial AS b ON b.id_editorial = a.id_editorial";
				$cadenaSql.=" LEFT JOIN docencia.tipo_libro AS c ON c.id_tipo_libro = a.id_tipo_libro";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY c.tipo_libro ASC";
				$cadenaSql.=" ;";
				break;
				
			case "cartas_editor" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" b.descripcion AS editorial,";
				$cadenaSql.=" c.descripcion AS tipo_libro,";
				$cadenaSql.=" a.nombre_revista AS nombre_revista,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.cartas_editor AS a";
				$cadenaSql.=" LEFT JOIN docencia.contexto AS b ON b.id_contexto = a.id_contexto";
				$cadenaSql.=" LEFT JOIN docencia.tipo_indexacion AS c ON c.id_tipo_indexacion = a.id_tipo_indexacion";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY c.descripcion ASC";
				$cadenaSql.=" ;";
				break;
				
			case "direccion_de_trabajos" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" ttg.nombre_tipo_trabajogrado AS tipo_trabajogrado,";
				$cadenaSql.=" dtg.fecha_acta AS fecha_acta,";
				$cadenaSql.=" dtg.numero_acta AS numero_acta,";
				$cadenaSql.=" dtg.puntaje AS puntaje,";
				$cadenaSql.=" dtg.titulo_trabajogrado AS titulo_trabajogrado,";
				$cadenaSql.=" ctg.nombre_categoria_trabajogrado AS nombre_categoria_trabajogrado";
				$cadenaSql.=" FROM docencia.direccion_trabajogrado AS dtg";
				$cadenaSql.=" LEFT JOIN docencia.tipo_trabajogrado AS ttg ON ttg.id_tipo_trabajogrado = dtg.id_tipo_trabajogrado";
				$cadenaSql.=" LEFT JOIN docencia.categoria_trabajogrado AS ctg ON ctg.id_categoria_trabajogrado = dtg.id_categoria_trabajogrado";
				$cadenaSql.=" WHERE dtg.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY ttg.nombre_tipo_trabajogrado ASC";
				$cadenaSql.=" ;";
				break;
				
			case "experiencia_direccion_academica" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" b.nombre_tipo_entidad AS nombre_tipo_entidad,";
				$cadenaSql.=" c.nombre_universidad AS nombre_universidad,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.experiencia_direccion_academica AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_entidad AS b ON b.id_tipo_entidad = a.id_tipo_entidad";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS c ON c.id_universidad = a.id_universidad";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY nombre_tipo_entidad ASC";
				$cadenaSql.=" ;";
				break;
				
			case "experiencia_investigacion" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" b.descripcion AS tipo_experiencia_investigacion,";
				$cadenaSql.=" c.nombre_universidad AS nombre_universidad,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.experiencia_investigacion AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_experiencia_investigacion AS b ON b.id_tipo_experiencia_investigacion = a.id_tipo_experiencia_investigacion";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS c ON c.id_universidad = a.id_universidad";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY tipo_experiencia_investigacion ASC";
				$cadenaSql.=" ;";
				break;
				
			case "experiencia_docencia" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" b.nombre_tipo_entidad AS nombre_tipo_entidad,";
				$cadenaSql.=" c.nombre_universidad AS nombre_universidad,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.experiencia_docencia AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_entidad AS b ON b.id_tipo_entidad = a.id_tipo_entidad";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS c ON c.id_universidad = a.id_universidad";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY nombre_tipo_entidad ASC";
				$cadenaSql.=" ;";
				break;
				
			case "experiencia_profesional" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.cargo AS cargo,";
				$cadenaSql.=" b.nombre_universidad AS nombre_universidad,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.experiencia_profesional AS a";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS b ON b.id_universidad = a.id_universidad";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY nombre_universidad ASC";
				$cadenaSql.=" ;";
				break;
				
			case "experiencia_calificada" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" tec.descripcion AS tipo_experiencia_calificada,";
				$cadenaSql.=" ec.fecha_acta AS fecha_acta,";
				$cadenaSql.=" ec.numero_acta AS numero_acta,";
				$cadenaSql.=" ec.puntaje AS puntaje,";
				$cadenaSql.=" ter.descripcion AS tipo_emisor_resolucion";
				$cadenaSql.=" FROM docencia.experiencia_calificada AS ec";
				$cadenaSql.=" LEFT JOIN docencia.tipo_experiencia_calificada AS tec ON tec.id_tipo_experiencia_calificada = ec.id_tipo_experiencia_calificada";
				$cadenaSql.=" LEFT JOIN docencia.tipo_emisor_resolucion AS ter ON ter.id_tipo_emisor_resolucion = ec.id_tipo_emisor_resolucion";
				$cadenaSql.=" WHERE ec.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY ec.id_tipo_emisor_resolucion ASC";
				$cadenaSql.=" ;";
				break;
				
			case "experiencia_direccion_academica" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" u.nombre_universidad AS nombre_universidad,";
				$cadenaSql.=" eda.fecha_acta AS fecha_acta,";
				$cadenaSql.=" eda.numero_acta AS numero_acta,";
				$cadenaSql.=" eda.puntaje AS puntaje,";
				$cadenaSql.=" te.nombre_tipo_entidad AS nombre_tipo_entidad";
				$cadenaSql.=" FROM docencia.experiencia_direccion_academica AS eda";
				$cadenaSql.=" LEFT JOIN docencia.tipo_entidad AS te ON te.id_tipo_entidad = eda.id_tipo_entidad";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS u ON u.id_universidad = eda.id_universidad";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY te.nombre_tipo_entidad ASC";
				$cadenaSql.=" ;";
				break;
				
			case "comunicacion_corta" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.nombre_revista AS nombre_revista,";
				$cadenaSql.=" b.descripcion AS contexto,";
				$cadenaSql.=" c.descripcion AS tipo_indexacion,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.comunicacion_corta AS a";
				$cadenaSql.=" LEFT JOIN docencia.contexto AS b ON b.id_contexto = a.id_contexto";
				$cadenaSql.=" LEFT JOIN docencia.tipo_indexacion AS c ON c.id_tipo_indexacion = a.id_tipo_indexacion";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY contexto ASC";
				$cadenaSql.=" ;";
				break;
				
			case "obras_artisticas" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.titulo_obra AS titulo_obra,";
				$cadenaSql.=" b.descripcion AS contexto,";
				$cadenaSql.=" c.descripcion AS tipo_obra_artistica,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.obra_artistica AS a";
				$cadenaSql.=" LEFT JOIN docencia.contexto AS b ON b.id_contexto = a.id_contexto";
				$cadenaSql.=" LEFT JOIN docencia.tipo_obra_artistica AS c ON c.id_tipo_obra_artistica = a.id_tipo_obra_artistica";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY contexto ASC";
				$cadenaSql.=" ;";
				break;
				
			case "patentes" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.titulo_patente AS titulo_patente,";
				$cadenaSql.=" b.descripcion AS tipo_patente,";
				$cadenaSql.=" c.nombre_universidad AS universidad,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.patente AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_patente AS b ON b.id_tipo_patente = a.id_tipo_patente";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS c ON c.id_universidad = a.id_universidad";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY tipo_patente ASC";
				$cadenaSql.=" ;";
				break;
				
			case "premios_docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" b.descripcion AS contexto,";
				$cadenaSql.=" c.nombre_tipo_entidad AS nombre_tipo_entidad,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.premio_docente AS a";
				$cadenaSql.=" LEFT JOIN docencia.contexto AS b ON b.id_contexto = a.id_contexto";
				$cadenaSql.=" LEFT JOIN docencia.tipo_entidad AS c ON c.id_tipo_entidad = a.id_tipo_entidad";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY contexto ASC";
				$cadenaSql.=" ;";
				break;
				
			case "produccion_videos" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.titulo_video AS titulo_video,";
				$cadenaSql.=" b.descripcion AS caracter_video,";
				$cadenaSql.=" c.descripcion AS contexto,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.produccion_video AS a";
				$cadenaSql.=" LEFT JOIN docencia.caracter_video AS b ON b.id_caracter_video = a.id_caracter_video";
				$cadenaSql.=" LEFT JOIN docencia.contexto AS c ON c.id_contexto = a.id_contexto";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY contexto ASC";
				$cadenaSql.=" ;";
				break;
				
			case "produccion_libros" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.titulo AS titulo,";
				$cadenaSql.=" b.tipo_libro AS tipo_libro,";
				$cadenaSql.=" c.nombre_universidad AS universidad,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.libro_docente AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_libro AS b ON b.id_tipo_libro = a.id_tipo_libro";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS c ON c.id_universidad = a.id_universidad";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY tipo_libro ASC";
				$cadenaSql.=" ;";
				break;
				
			case "traduccion_libros" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.titulo AS titulo,";
				$cadenaSql.=" a.normatividad AS normatividad,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.traduccion_libro AS a";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY normatividad ASC";
				$cadenaSql.=" ;";
				break;
				
			case "produccion_tecnicaysoftware" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.nombre AS nombre,";
				$cadenaSql.=" b.nombre AS tipo_tecnicaysoftware,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.produccion_tecnicaysoftware AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_tecnicaysoftware AS b ON b.id_tipo_tecnicaysoftware = a.id_tipo_tecnicaysoftware";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY tipo_tecnicaysoftware ASC";
				$cadenaSql.=" ;";
				break;
				
			case "publicaciones_impresas_universitarias" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.titulo AS titulo,";
				$cadenaSql.=" b.descripcion AS tipo_indexacion,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.publicacion_impresa AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_indexacion AS b ON b.id_tipo_indexacion = a.id_tipo_indexacion";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY tipo_indexacion ASC";
				$cadenaSql.=" ;";
				break;
				
			case "estudios_post_doctorales" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.titulo_obtenido AS titulo_obtenido,";
				$cadenaSql.=" b.nombre_universidad AS nombre_universidad,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.estudio_postdoctoral_docente AS a";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS b ON b.id_universidad = a.id_universidad";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY nombre_universidad ASC";
				$cadenaSql.=" ;";
				break;
				
			case "resena_critica" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.titulo AS titulo,";
				$cadenaSql.=" b.descripcion AS tipo_indexacion,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.resena_critica AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_indexacion AS b ON b.id_tipo_indexacion = a.id_tipo_indexacion";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY tipo_indexacion ASC";
				$cadenaSql.=" ;";
				break;
				
			case "traduccion_articulos" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.titulo_traduccion AS titulo_traduccion,";
				$cadenaSql.=" a.titulo_publicacion AS titulo_publicacion,";
				$cadenaSql.=" b.descripcion AS tipo_traduccion_articulo,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.traduccion_articulo AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_traduccion_articulo AS b ON b.id_tipo_traduccion_articulo = a.id_tipo_traduccion_articulo";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY tipo_traduccion_articulo ASC";
				$cadenaSql.=" ;";
				break;
				
			case "ponencias" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.titulo AS titulo,";
				$cadenaSql.=" b.descripcion AS contexto_ponencia,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.ponencia AS a";
				$cadenaSql.=" LEFT JOIN docencia.contexto_ponencia AS b ON b.id_contexto_ponencia = a.id_contexto_ponencia";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY contexto_ponencia ASC";
				$cadenaSql.=" ;";
				break;
							
			case "novedades_salariales" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.descripcion AS descripcion,";
				$cadenaSql.=" b.descripcion AS tipo_novedad,";
				$cadenaSql.=" c.categoria_novedad AS categoria_novedad,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.novedad AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_novedad AS b ON b.id_tipo_novedad = a.id_tipo_novedad";
				$cadenaSql.=" LEFT JOIN docencia.categoria_novedad AS c ON c.id_categoria_novedad = b.id_categoria_novedad";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."' AND c.id_categoria_novedad = '1'";
				$cadenaSql.=" ORDER BY categoria_novedad,tipo_novedad ASC";
				$cadenaSql.=" ;";
				break;
				
			case "novedades_bonificacion" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" a.descripcion AS descripcion,";
				$cadenaSql.=" b.descripcion AS tipo_novedad,";
				$cadenaSql.=" c.categoria_novedad AS categoria_novedad,";
				$cadenaSql.=" a.fecha_acta AS fecha_acta,";
				$cadenaSql.=" a.numero_acta AS numero_acta,";
				$cadenaSql.=" a.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.novedad AS a";
				$cadenaSql.=" LEFT JOIN docencia.tipo_novedad AS b ON b.id_tipo_novedad = a.id_tipo_novedad";
				$cadenaSql.=" LEFT JOIN docencia.categoria_novedad AS c ON c.id_categoria_novedad = b.id_categoria_novedad";
				$cadenaSql.=" WHERE a.documento_docente='". $variable."' AND c.id_categoria_novedad = '2'";
				$cadenaSql.=" ORDER BY categoria_novedad,tipo_novedad ASC";
				$cadenaSql.=" ;";
				break;
				
			
		}
		
		return $cadenaSql;
	}
}

?>
