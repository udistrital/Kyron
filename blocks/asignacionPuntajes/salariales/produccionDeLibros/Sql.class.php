<?php

namespace asignacionPuntajes\salariales\indexacionRevistas;

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
			
			case "consultarLibro" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.documento_docente||' - '||dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" li.titulo AS titulo_libro,";
				$cadenaSql.=" tl.id_tipo_libro AS id_tipo_libro,";
				$cadenaSql.=" tl.tipo_libro AS tipo_libro,";
				$cadenaSql.=" un.id_universidad AS id_entidad_certificadora,";
				$cadenaSql.=" un.nombre_universidad AS entidad_certificadora,";
				$cadenaSql.=" li.codigo_isbn AS codigo_isbn,";
				$cadenaSql.=" li.anno_publicacion AS anno_publicacion,";
				$cadenaSql.=" li.numero_autores AS numero_autores,";
				$cadenaSql.=" li.numero_autores_ud AS numero_autores_ud,";
				$cadenaSql.=" ed.nombre_editorial AS editorial,";
				$cadenaSql.=" li.numero_acta AS numero_acta,";
				$cadenaSql.=" li.fecha_acta AS fecha_acta,";
				$cadenaSql.=" li.numero_caso AS numero_caso,";
				$cadenaSql.=" li.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.libro_docente AS li";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente = li.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.tipo_libro AS tl ON tl.id_tipo_libro = li.id_tipo_libro";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS un ON un.id_universidad = li.id_universidad";
				$cadenaSql.=" LEFT JOIN docencia.editorial AS ed ON ed.id_editorial = li.id_editorial";
				$cadenaSql.=" WHERE li.estado=true";
				$cadenaSql.=" AND dc.estado=true";
				$cadenaSql.=" AND ed.estado=true";
				$cadenaSql.=" AND li.documento_docente = '".$variable ['documento_docente']."'";
				$cadenaSql.=" AND li.codigo_isbn = '".$variable ['codigo_isbn']."'";
				break;
					
			case "consultarEvaluador" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" eld.documento_evaluador AS documento_evaluador,";
				$cadenaSql.=" eld.nombre AS nombre_evaluador,";
				$cadenaSql.=" un.id_universidad AS id_entidad_certificadora,";
				$cadenaSql.=" un.nombre_universidad AS entidad_certificadora,";
				$cadenaSql.=" eld.puntaje AS puntaje";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.evaluador_libro_docente AS eld";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS un ON un.id_universidad = eld.id_universidad";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" eld.estado=true";
				$cadenaSql.=" AND eld.documento_docente = '".$variable ['documento_docente']."'";
				$cadenaSql.=" AND eld.codigo_isbn = '".$variable ['codigo_isbn']."'";
				break;
				
			case "consultarLibros" :			
				$cadenaSql=" SELECT";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" li.titulo AS titulo_libro,";
				$cadenaSql.=" tl.tipo_libro AS tipo_libro,";
				$cadenaSql.=" li.codigo_isbn AS codigo_isbn,";
				$cadenaSql.=" li.anno_publicacion AS anno_publicacion,";
				$cadenaSql.=" li.numero_autores AS numero_autores,";
				$cadenaSql.=" li.numero_autores_ud AS numero_autores_ud,";
				$cadenaSql.=" ed.nombre_editorial AS editorial,";
				$cadenaSql.=" li.numero_acta AS numero_acta,";
				$cadenaSql.=" li.fecha_acta AS fecha_acta,";
				$cadenaSql.=" li.numero_caso AS numero_caso,";
				$cadenaSql.=" li.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.libro_docente AS li";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente = li.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.tipo_libro AS tl ON tl.id_tipo_libro = li.id_tipo_libro";
				$cadenaSql.=" LEFT JOIN docencia.editorial AS ed ON ed.id_editorial = li.id_editorial";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON li.documento_docente=dc_pc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.proyectocurricular AS pc ON dc_pc.id_proyectocurricular=pc.id_proyectocurricular";
				$cadenaSql.=" LEFT JOIN docencia.facultad AS fc ON pc.id_facultad=fc.id_facultad";
				$cadenaSql.=" WHERE li.estado=true";
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
				
				
			case "insertarLibroDocente" :
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
						$cadenaSql.=" INSERT INTO docencia.libro_docente (";
						$cadenaSql.=" documento_docente, ";
						$cadenaSql.=" titulo, ";
						$cadenaSql.=" id_tipo_libro, ";
						$cadenaSql.=" id_universidad, ";
						$cadenaSql.=" codigo_isbn, ";
						$cadenaSql.=" anno_publicacion,";
						$cadenaSql.=" numero_autores, ";
						$cadenaSql.=" numero_autores_ud, ";
						$cadenaSql.=" id_editorial, ";
						$cadenaSql.=" numero_acta,";
						$cadenaSql.=" fecha_acta, ";
						$cadenaSql.=" numero_caso, ";
						$cadenaSql.=" puntaje ";
						$cadenaSql.=" )";
						$cadenaSql.=" VALUES (";
						$cadenaSql.=" '" . $variable ['id_docenteRegistrar'] . "',";
						$cadenaSql.=" '" . $variable ['nombreLibro'] . "',";
						$cadenaSql.=" '" . $variable ['tipoLibro'] . "',";
						$valor = $variable ['entidadCertificadora'];
						$variable ['entidadCertificadora'] = ($valor=='')?'NULL':" '".$valor."'";
						$cadenaSql.=" " . $variable ['entidadCertificadora'] . ",";
						$cadenaSql.=" '" . $variable ['isbnLibro'] . "',";
						$cadenaSql.=" '" . $variable ['annoLibro'] . "',";
						$cadenaSql.=" '" . $variable ['numeroAutoresLibro'] . "',";
						$cadenaSql.=" '" . $variable ['numeroAutoresUniversidad'] . "',";
						$cadenaSql.=" '" . $variable ['editorial'] . "',";
						$cadenaSql.=" '" . $variable ['numeroActaLibro'] . "',";
						$cadenaSql.=" '" . $variable ['fechaActaLibro'] . "',";
						$cadenaSql.=" '" . $variable ['numeroCasoActaLibro'] . "',";
						$cadenaSql.=" '" . $variable ['puntajeLibro'] . "'";
						$cadenaSql.=" ) ";
					}
					if($i == 1 && $evaluadorExiste){
						$cadenaSql.=" returning documento_docente, codigo_isbn";
						$cadenaSql.=" )";
						$cadenaSql.=" INSERT INTO docencia.evaluador_libro_docente (";
						$cadenaSql.=" documento_evaluador,";
						$cadenaSql.=" nombre,";
						$cadenaSql.=" codigo_isbn,";
						$cadenaSql.=" documento_docente,";
						$cadenaSql.=" id_universidad,";
						$cadenaSql.=" puntaje";
						$cadenaSql.=" )";
						$cadenaSql.=" VALUES ";
					}
					if($evaluadorExite){
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
				
			case "actualizarLibro" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "docencia.revista_indexada ";
				$cadenaSql .= "SET ";
				$cadenaSql .= "nombre_revista = '" . $variable ['nombreRevista'] . "', ";
				$cadenaSql .= "id_contexto = '" . $variable ['contextoRevista'] . "', ";
				$cadenaSql .= "paiscodigo = '" . $variable ['pais'] . "', ";
				$cadenaSql .= "id_tipo_indexacion = '" . $variable ['categoria'] . "', ";
				$cadenaSql .= "numero_issn = '" . $variable ['issnRevista'] . "', ";
				$cadenaSql .= "anno_publicacion = '" . $variable ['annoRevista'] . "', ";
				$cadenaSql .= "volumen_revista = '" . $variable ['volumenRevista'] . "', ";
				$cadenaSql .= "numero_revista = '" . $variable ['numeroRevista'] . "', ";
				$cadenaSql .= "paginas_revista = '" . $variable ['paginasRevista'] . "', ";
				$cadenaSql .= "titulo_articulo = '" . $variable ['tituloArticuloRevista'] . "', ";
				$cadenaSql .= "numero_autores = '" . $variable ['numeroAutoresRevista'] . "', ";
				$cadenaSql .= "numero_autores_ud = '" . $variable ['numeroAutoresUniversidad'] . "', ";
				$cadenaSql .= "fecha_publicacion = '" . $variable ['fechaPublicacionrevista'] . "', ";
				$cadenaSql .= "numero_acta = '" . $variable ['numeroActaRevista'] . "', ";
				$cadenaSql .= "fecha_acta = '" . $variable ['fechaActaRevista'] . "', ";
				$cadenaSql .= "numero_caso = '" . $variable ['numeroCasoActaRevista'] . "', ";
				$cadenaSql .= "puntaje = '" . $variable ['puntajeRevista'] . "'";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "documento_docente ='" . $variable ['id_docenteRegistrar'] . "' ";
				$cadenaSql .= "and numero_issn ='" . $variable ['numero_issn_old'] . "' ";
				break;
		}
		
		return $cadenaSql;
	}
}

?>
