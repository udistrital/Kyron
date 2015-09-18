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
				$cadenaSql = "SELECT documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido AS  value, documento_docente  AS data ";
				$cadenaSql .= " FROM docencia.docente";
				$cadenaSql .= " WHERE cast(documento_docente as text) LIKE '%" . $variable . "%'";
				$cadenaSql .= " OR primer_nombre LIKE '%" . $variable . "%' LIMIT 10;";
				
				break;
								
			case "consultarLibros" :			
				$cadenaSql=" select ";
				$cadenaSql.=" ri.documento_docente, ";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente,";
				$cadenaSql.=" ri.nombre_revista, ri.titulo_articulo, pi.paisnombre, ti.descripcion as tipo_indexacion,";
				$cadenaSql.=" ri.numero_issn, ri.anno_publicacion,";
				$cadenaSql.=" ri.volumen_revista, ri.numero_revista,";
				$cadenaSql.=" ri.paginas_revista,";
				$cadenaSql.=" ri.fecha_publicacion ";
				$cadenaSql.=" from ";
				$cadenaSql.=" docencia.revista_indexada ri ";
				$cadenaSql.=" left join docencia.docente dc on ri.documento_docente=dc.documento_docente ";
				$cadenaSql.=" left join docencia.docente_proyectocurricular dc_pc on ri.documento_docente=dc_pc.documento_docente ";
				$cadenaSql.=" left join docencia.proyectocurricular pc on dc_pc.id_proyectocurricular=pc.id_proyectocurricular ";
				$cadenaSql.=" left join docencia.facultad fc on pc.id_facultad=fc.id_facultad ";
				$cadenaSql.=" left join docencia.pais pi on ri.paiscodigo=pi.paiscodigo ";
				$cadenaSql.=" left join docencia.tipo_indexacion ti ON ti.id_tipo_indexacion = ri.id_tipo_indexacion";
				$cadenaSql.=" where 1=1";
				if ($variable [0] != '') {
					$cadenaSql .= " AND dc.documento_docente = '" . $variable ['documento_docente'] . "'";
				}
				if ($variable [1] != '') {
					$cadenaSql .= " AND fc.id_facultad = '" . $variable ['id_facultad'] . "'";
				}
				if ($variable [2] != '') {
					$cadenaSql .= " AND pc.id_proyectocurricular = '" . $variable ['id_proyectocurricular'] . "'";
				}
				break;
				
			case "insertarLibroDocente" :
				$cadenaSql=" with rows as (";
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
				$cadenaSql.=" puntaje, ";
				$cadenaSql.=" detalles";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES (";
				$cadenaSql.=" '" . $variable ['id_docenteRegistrar'] . "',";
				$cadenaSql.=" '" . $variable ['nombreLibro'] . "',";
				$cadenaSql.=" '" . $variable ['tipoLibro'] . "',";
				$cadenaSql.=" '" . $variable ['entidadCertificadora'] . "',";
				$cadenaSql.=" '" . $variable ['isbnLibro'] . "',";
				$cadenaSql.=" '" . $variable ['annoLibro'] . "',";
				$cadenaSql.=" '" . $variable ['numeroAutoresLibro'] . "',";
				$cadenaSql.=" '" . $variable ['numeroAutoresUniversidad'] . "',";
				$cadenaSql.=" '" . $variable ['editorial'] . "',";
				$cadenaSql.=" '" . $variable ['numeroActaLibro'] . "',";
				$cadenaSql.=" '" . $variable ['fechaActaLibro'] . "',";
				$cadenaSql.=" '" . $variable ['numeroCasoActaLibro'] . "',";
				$cadenaSql.=" '" . $variable ['puntajeLibro'] . "',";
				$cadenaSql.=" '" . $variable ['detalleDocencia'] . "'";
				$cadenaSql.=" ) returning documento_docente, codigo_isbn";
				$cadenaSql.=" )";
				$cadenaSql.=" INSERT INTO docencia.evaluador_libro_docente (";
				$cadenaSql.=" documento_evaluador,";
				$cadenaSql.=" nombre,";
				$cadenaSql.=" codigo_isbn,";
				$cadenaSql.=" documento_docente,";
				$cadenaSql.=" id_universidad,";
				$cadenaSql.=" puntaje";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES (";
				$cadenaSql.=" '" . $variable ['documentoEvaluador1'] . "',";
				$cadenaSql.=" '" . $variable ['nombreEvaluador1'] . "',";
				$cadenaSql.=" (SELECT codigo_isbn FROM rows),";
				$cadenaSql.=" (SELECT documento_docente FROM rows),";
				$cadenaSql.=" '" . $variable ['entidadCertificadora1'] . "',";
				$cadenaSql.=" '" . $variable ['puntajeSugeridoEvaluador1'] . "'";
				$cadenaSql.=" );";
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
