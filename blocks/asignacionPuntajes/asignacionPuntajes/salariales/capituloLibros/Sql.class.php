<?php

namespace asignacionPuntajes\salariales\capituloLibros;

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
			case "facultad" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_facultad,";
				$cadenaSql .= "	nombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.facultad";
				break;
				
			case "proyectoCurricular" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_proyectocurricular,";
				$cadenaSql .= "	nombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.proyectocurricular";
				break;
				
			case "entidadCertificadora" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_universidad,";
				$cadenaSql .= "	nombre_universidad";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.universidad";				
				break;
				
			case "editorial" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_editorial,";
				$cadenaSql .= "	nombre_editorial";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.editorial";
				break;
				
			case "tipoLibro" :
				$cadenaSql = "select";
				$cadenaSql .= " id_tipo_libro, tipo_libro";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_libro ORDER BY";
				$cadenaSql .= " tipo_libro ASC";
				break;
				
			case "docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido AS value, ";
				$cadenaSql.=" documento_docente AS data ";
				$cadenaSql.=" FROM ";
				$cadenaSql.=" docencia.docente WHERE documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido ";
				$cadenaSql.=" LIKE '%" . $variable . "%' LIMIT 10;";
				
				break;
			
			case "consultarCapitulo" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.documento_docente||' - '||dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" cl.titulo_capitulo AS titulo_capitulo,";
				$cadenaSql.=" cl.titulo_libro AS titulo_libro,";
				$cadenaSql.=" tl.id_tipo_libro AS id_tipo_libro,";
				$cadenaSql.=" tl.tipo_libro AS tipo_libro,";
				$cadenaSql.=" cl.codigo_isbn AS codigo_isbn,";
				$cadenaSql.=" cl.anno_publicacion AS anno_publicacion,";
				$cadenaSql.=" cl.volumen AS volumen,";
				$cadenaSql.=" cl.numero_autores_capitulo AS numero_autores_capitulo,";
				$cadenaSql.=" cl.numero_autores_capitulo_ud AS numero_autores_capitulo_ud,";
				$cadenaSql.=" cl.numero_autores_libro AS numero_autores_libro,";
				$cadenaSql.=" cl.numero_autores_libro_ud AS numero_autores_libro_ud,";
				$cadenaSql.=" cl.id_editorial AS id_editorial,";
				$cadenaSql.=" ed.nombre_editorial AS editorial,";
				$cadenaSql.=" cl.numero_acta AS numero_acta,";
				$cadenaSql.=" cl.fecha_acta AS fecha_acta,";
				$cadenaSql.=" cl.numero_caso AS numero_caso,";
				$cadenaSql.=" cl.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.capitulo_libro AS cl";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente = cl.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.tipo_libro AS tl ON tl.id_tipo_libro = cl.id_tipo_libro";
				$cadenaSql.=" LEFT JOIN docencia.editorial AS ed ON ed.id_editorial = cl.id_editorial";
				$cadenaSql.=" WHERE cl.estado=true";
				$cadenaSql.=" AND dc.estado=true";
				$cadenaSql.=" AND ed.estado=true";
				$cadenaSql.=" AND cl.documento_docente = '".$variable ['documento_docente']."'";
				$cadenaSql.=" AND cl.codigo_isbn = '".$variable ['codigo_isbn']."'";
				break;
					
			case "consultarEvaluador" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" ecl.documento_evaluador AS documento_evaluador,";
				$cadenaSql.=" ecl.nombre AS nombre_evaluador,";
				$cadenaSql.=" un.id_universidad AS id_entidad_certificadora,";
				$cadenaSql.=" un.nombre_universidad AS entidad_certificadora,";
				$cadenaSql.=" ecl.puntaje AS puntaje";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.evaluador_capitulo_libro AS ecl";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS un ON un.id_universidad = ecl.id_universidad";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" ecl.estado=true";
				$cadenaSql.=" AND ecl.documento_docente = '".$variable ['documento_docente']."'";
				$cadenaSql.=" AND ecl.codigo_isbn = '".$variable ['codigo_isbn']."'";
				break;
				
			case "consultarCapituloLibro" :			
				$cadenaSql=" SELECT";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" cl.titulo_capitulo AS titulo_capitulo,";
				$cadenaSql.=" cl.titulo_libro AS titulo_libro,";
				$cadenaSql.=" tl.tipo_libro AS tipo_libro,";
				$cadenaSql.=" cl.codigo_isbn AS codigo_isbn,";
				$cadenaSql.=" cl.anno_publicacion AS anno_publicacion,";
				$cadenaSql.=" cl.volumen AS volumen,";
				$cadenaSql.=" cl.numero_autores_capitulo AS numero_autores_capitulo,";
				$cadenaSql.=" cl.numero_autores_capitulo_ud AS numero_autores_capitulo_ud,";
				$cadenaSql.=" cl.numero_autores_libro AS numero_autores_libro,";
				$cadenaSql.=" cl.numero_autores_libro_ud AS numero_autores_libro_ud,";
				$cadenaSql.=" ed.nombre_editorial AS editorial,";
				$cadenaSql.=" cl.numero_acta AS numero_acta,";
				$cadenaSql.=" cl.fecha_acta AS fecha_acta,";
				$cadenaSql.=" cl.numero_caso AS numero_caso,";
				$cadenaSql.=" cl.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.capitulo_libro AS cl";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente = cl.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.tipo_libro AS tl ON tl.id_tipo_libro = cl.id_tipo_libro";
				$cadenaSql.=" LEFT JOIN docencia.editorial AS ed ON ed.id_editorial = cl.id_editorial";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON cl.documento_docente=dc_pc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.proyectocurricular AS pc ON dc_pc.id_proyectocurricular=pc.id_proyectocurricular";
				$cadenaSql.=" LEFT JOIN docencia.facultad AS fc ON pc.id_facultad=fc.id_facultad";
				$cadenaSql.=" WHERE cl.estado=true";
				$cadenaSql.=" AND dc.estado=true";
				$cadenaSql.=" AND dc_pc.estado=true";
				$cadenaSql.=" AND pc.estado=true";
				if ($variable ['documento_docente'] != '') {
					$cadenaSql .= " AND dc.documento_docente = '" . $variable ['documento_docente'] . "'";
				}
				if ($variable ['id_facultad'] != '') {
					$cadenaSql .= " AND fc.id_facultad = '" . $variable ['id_facultad'] . "'";
				}
				if ($variable ['id_proyectocurricular'] != '') {
					$cadenaSql .= " AND pc.id_proyectocurricular = '" . $variable ['id_proyectocurricular'] . "'";
				}
				break;
				
				
			case "insertarCapituloLibro" :
				$cadenaSql='';
				for($i = 1; $i <= 3; $i++){
					$evaluadorExiste =  $variable ['documentoEvaluador'.$i] != '' &&
										$variable ['nombreEvaluador'.$i] != '' &&
										$variable ['entidadCertificadora'.$i] != '' &&
										$variable ['puntajeSugeridoEvaluador'.$i] != '';
					if($i == 1 && $evaluadorExiste){
						$cadenaSql=" with rows as (";
					}
					if($i == 1){
						$cadenaSql.=" INSERT INTO docencia.capitulo_libro (";
						$cadenaSql.=" documento_docente, ";
						$cadenaSql.=" titulo_capitulo, ";
						$cadenaSql.=" titulo_libro, ";
						$cadenaSql.=" id_tipo_libro, ";
						$cadenaSql.=" codigo_isbn, ";
						$cadenaSql.=" id_editorial, ";
						$cadenaSql.=" anno_publicacion,";
						$cadenaSql.=" volumen,";
						$cadenaSql.=" numero_autores_capitulo, ";
						$cadenaSql.=" numero_autores_capitulo_ud, ";
						$cadenaSql.=" numero_autores_libro, ";
						$cadenaSql.=" numero_autores_libro_ud, ";						
						$cadenaSql.=" numero_acta,";
						$cadenaSql.=" fecha_acta, ";
						$cadenaSql.=" numero_caso, ";
						$cadenaSql.=" puntaje ";
						$cadenaSql.=" )";
						$cadenaSql.=" VALUES (";
						$cadenaSql.=" '" . $variable ['id_docenteRegistrar'] . "',";
						$cadenaSql.=" '" . $variable ['nombreCapitulo'] . "',";
						$cadenaSql.=" '" . $variable ['nombreLibro'] . "',";
						$cadenaSql.=" '" . $variable ['tipoLibro'] . "',";
						$cadenaSql.=" '" . $variable ['isbnLibro'] . "',";
						$cadenaSql.=" '" . $variable ['editorial'] . "',";
						$cadenaSql.=" '" . $variable ['annoLibro'] . "',";
						$cadenaSql.=" '" . $variable ['volumenLibro'] . "',";
						$cadenaSql.=" '" . $variable ['numeroAutoresCapitulo'] . "',";
						$cadenaSql.=" '" . $variable ['numeroAutoresCapituloUniversidad'] . "',";
						$cadenaSql.=" '" . $variable ['numeroAutoresLibro'] . "',";
						$cadenaSql.=" '" . $variable ['numeroAutoresLibroUniversidad'] . "',";
						$cadenaSql.=" '" . $variable ['numeroActaLibro'] . "',";
						$cadenaSql.=" '" . $variable ['fechaActaLibro'] . "',";
						$cadenaSql.=" '" . $variable ['numeroCasoActaLibro'] . "',";
						$cadenaSql.=" '" . $variable ['puntajeLibro'] . "'";
						$cadenaSql.=" ) ";
					}
					if($i == 1 && $evaluadorExiste){
						$cadenaSql.=" returning documento_docente, codigo_isbn";
						$cadenaSql.=" )";
						$cadenaSql.=" INSERT INTO docencia.evaluador_capitulo_libro(";
						$cadenaSql.=" documento_evaluador,";
						$cadenaSql.=" nombre,";
						$cadenaSql.=" codigo_isbn,";
						$cadenaSql.=" documento_docente,";
						$cadenaSql.=" id_universidad,";
						$cadenaSql.=" puntaje";
						$cadenaSql.=" )";
						$cadenaSql.=" VALUES ";
					}
					if($evaluadorExiste){
						$cadenaSql.=" (";
						$cadenaSql.=" '" . $variable ['documentoEvaluador'.$i] . "',";
						$cadenaSql.=" '" . $variable ['nombreEvaluador'.$i] . "',";
						$cadenaSql.=" (SELECT codigo_isbn FROM rows),";
						$cadenaSql.=" (SELECT documento_docente FROM rows),";
						$cadenaSql.=" '" . $variable ['entidadCertificadora'.$i] . "',";
						$cadenaSql.=" '" . $variable ['puntajeSugeridoEvaluador'.$i] . "'";
						$cadenaSql.=" ),";
					}
				}
				$cadenaSql = substr ($cadenaSql, 0, -1);
				$cadenaSql.=" ;";
				break;
				
			case "actualizarCapituloLibro" :
				$cadenaSql=" UPDATE docencia.capitulo_libro";
				$cadenaSql.=" SET";
				$cadenaSql.=" documento_docente = '" . $variable ['id_docenteRegistrar'] . "',";
				$cadenaSql.=" titulo_capitulo = '" . $variable ['nombreCapitulo'] . "',";
				$cadenaSql.=" titulo_libro = '" . $variable ['nombreLibro'] . "',";
				$cadenaSql.=" id_tipo_libro = '" . $variable ['tipoLibro'] . "',";
				$cadenaSql.=" codigo_isbn = '" . $variable ['isbnLibro'] . "',";
				$cadenaSql.=" id_editorial = '" . $variable ['editorial'] . "',";
				$cadenaSql.=" anno_publicacion = '" . $variable ['annoLibro'] . "',";
				$cadenaSql.=" volumen = '" . $variable ['volumenLibro'] . "',";
				$cadenaSql.=" numero_autores_capitulo = '" . $variable ['numeroAutoresCapitulo'] . "',";
				$cadenaSql.=" numero_autores_capitulo_ud = '" . $variable ['numeroAutoresCapituloUniversidad'] . "',";
				$cadenaSql.=" numero_autores_libro = '" . $variable ['numeroAutoresLibro'] . "',";
				$cadenaSql.=" numero_autores_libro_ud = '" . $variable ['numeroAutoresLibroUniversidad'] . "',";
				$cadenaSql.=" numero_acta = '" . $variable ['numeroActaLibro'] . "',";
				$cadenaSql.=" fecha_acta = '" . $variable ['fechaActaLibro'] . "', ";
				$cadenaSql.=" numero_caso = '" . $variable ['numeroCasoActaLibro'] . "', ";
				$cadenaSql.=" puntaje = '" . $variable ['puntajeLibro'] . "'";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" documento_docente = '" . $variable ['old_id_docenteRegistrar'] . "'";
				$cadenaSql.=" AND codigo_isbn = '" . $variable ['old_isbnLibro'] . "'";
				$cadenaSql.=" ;";
				break;
				
			case "insertarEvaluador" :
				$cadenaSql=" INSERT INTO docencia.evaluador_libro_docente (";
				$cadenaSql.=" documento_evaluador,";
				$cadenaSql.=" nombre,";
				$cadenaSql.=" codigo_isbn,";
				$cadenaSql.=" documento_docente,";
				$cadenaSql.=" id_universidad,";
				$cadenaSql.=" puntaje";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES (";
				$cadenaSql.=" '" . $variable ['documento_evaluador'] . "',";
				$cadenaSql.=" '" . $variable ['nombre'] . "',";
				$cadenaSql.=" '" . $variable ['codigo_isbn'] . "',";
				$cadenaSql.=" '" . $variable ['documento_docente'] . "',";
				$cadenaSql.=" '" . $variable ['id_universidad'] . "',";
				$cadenaSql.=" '" . $variable ['puntaje'] . "'";
				$cadenaSql.=" );";
				break;
				
			case "actualizarEvaluador" :
				$cadenaSql=" UPDATE";
				$cadenaSql.=" docencia.evaluador_capitulo_libro";
				$cadenaSql.=" SET";
				$cadenaSql.=" documento_evaluador = '" . $variable ['documento_evaluador'] . "',";
				$cadenaSql.=" nombre = '" . $variable ['nombre'] . "',";
				$cadenaSql.=" codigo_isbn = '" . $variable ['codigo_isbn'] . "',";
				$cadenaSql.=" documento_docente = '" . $variable ['documento_docente'] . "',";
				$cadenaSql.=" id_universidad = '" . $variable ['id_universidad'] . "',";
				$cadenaSql.=" puntaje = '" . $variable ['puntaje'] . "'";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" documento_evaluador = '" . $variable ['old_documento_evaluador'] . "'";
				$cadenaSql.=" AND codigo_isbn = '" . $variable ['old_codigo_isbn'] . "'";
				$cadenaSql.=" AND documento_docente = '" . $variable ['old_documento_docente'] . "'";
				$cadenaSql.=" ;";
				break;
		}
		
		return $cadenaSql;
	}
}

?>
