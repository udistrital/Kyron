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
				
			case "pais" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " paiscodigo,";
				$cadenaSql .= "	paisnombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.pais";
				$cadenaSql .= " WHERE 1=1";
				if($variable == 0){
					$cadenaSql .= " and lower(paisnombre) = 'colombia'";
				}elseif ($variable == 1){
					$cadenaSql .= " and lower(paisnombre) != 'colombia'";
				}
				$cadenaSql .= "order by paisnombre";
				break;
				
			case "categoria_revista" :
				$cadenaSql = "select";
				$cadenaSql .= " id_tipo_indexacion,";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_indexacion";
				$cadenaSql .= " WHERE";
				$cadenaSql .= " id_contexto =" . $variable;
				break;
				
			case "docente" :
				$cadenaSql = "SELECT documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido AS  value, documento_docente  AS data ";
				$cadenaSql .= " FROM docencia.docente";
				$cadenaSql .= " WHERE cast(documento_docente as text) LIKE '%" . $variable . "%'";
				$cadenaSql .= " OR primer_nombre LIKE '%" . $variable . "%' LIMIT 10;";
				
				break;
								
			case "consultarIndexacion" :			
				$cadenaSql = "SELECT  id_indexacion_revista, ir.identificacion_docente, ";
				$cadenaSql .= " nombre_docente, ";
				$cadenaSql .= " nombre_revista, titulo_articulo, paisnombre,   ";
				$cadenaSql .= " ti.descripcion as item_nombre, numero_issn, ";
				$cadenaSql .= "anno_publicacion, ";
				$cadenaSql .= " volumen_revista, numero_revista, paginas_revista, fecha_publicacion ";
				$cadenaSql .= "FROM docencia.dependencia_docente as dd ";
				$cadenaSql .= "JOIN docencia.categoria_docente as cd ON cd.categoria_iddocente = dd.dependencia_iddocente ";
				$cadenaSql .= "JOIN docencia.docente as dt ON dt.identificacion_docente = dd.dependencia_iddocente ";
				$cadenaSql .= "JOIN docencia.indexacion_revista as ir ON ir.identificacion_docente = dd.dependencia_iddocente ";
				$cadenaSql .= "LEFT JOIN docencia.tipo_indexacion as ti ON ti.id_tipo_indexacion = ir.id_tipo_indexacion ";
				$cadenaSql .= "LEFT JOIN docencia.pais_kyron pk ON pk.paiscodigo = ir.paiscodigo ";
				$cadenaSql .= "WHERE 1=1";
				if ($variable [0] != '') {
					$cadenaSql .= " AND dd.dependencia_iddocente = '" . $variable [0] . "'";
				}
				if ($variable [1] != '') {
					$cadenaSql .= " AND dd.dependencia_facultad = '" . $variable [1] . "'";
				}
				if ($variable [2] != '') {
					$cadenaSql .= " AND dd.dependencia_proyectocurricular = '" . $variable [2] . "'";
				}
				break;
				
			case "insertarIndexacion" :
				$cadenaSql = "INSERT INTO docencia.indexacion_revista( ";
				$cadenaSql .= "identificacion_docente, nombre_revista, id_contexto_revista, paiscodigo, ";
				$cadenaSql .= "id_tipo_indexacion, ";
				$cadenaSql .= "numero_issn, anno_publicacion, volumen_revista, numero_revista, paginas_revista, ";
				$cadenaSql .= "titulo_articulo, numero_autores, numero_autores_ud, fecha_publicacion, ";
				$cadenaSql .= "numero_acta, fecha_acta, numero_caso, puntaje) ";
				$cadenaSql .= " VALUES (" . $variable [0] . ",";
				$cadenaSql .= " '" . $variable [1] . "',";
				$cadenaSql .= " '" . $variable [2] . "',";
				$cadenaSql .= "'" . $variable [3] . "',";
				$cadenaSql .= " '" . $variable [4] . "',";
				$cadenaSql .= " '" . $variable [5] . "',";
				$cadenaSql .= " '" . $variable [6] . "',";
				$cadenaSql .= " '" . $variable [7] . "',";
				$cadenaSql .= " '" . $variable [8] . "',";
				$cadenaSql .= " '" . $variable [9] . "',";
				$cadenaSql .= " '" . $variable [10] . "',";
				$cadenaSql .= " '" . $variable [11] . "',";
				$cadenaSql .= " '" . $variable [12] . "',";
				$cadenaSql .= "' " . $variable [13] . "' ,";
				$cadenaSql .= "' " . $variable [14] . "',";
				$cadenaSql .= " '" . $variable [15] . "',";
				$cadenaSql .= "' " . $variable [16] . "',";
				$cadenaSql .= " '" . $variable [17] . "')";
				break;
				
			case "consultarRevistas" :
				$cadenaSql  = "SELECT ir.identificacion_docente, dt.nombre_docente, ir.nombre_revista, ir.id_contexto_revista, ir.paiscodigo, ";
				$cadenaSql .= "ir.id_tipo_indexacion, ";
				$cadenaSql .= "ir.numero_issn, ir.anno_publicacion, ir.volumen_revista, ir.numero_revista, ir.paginas_revista, ";
				$cadenaSql .= "ir.titulo_articulo, ir.numero_autores, ir.numero_autores_ud, ir.fecha_publicacion, ";
				$cadenaSql .= "ir.numero_acta, ir.fecha_acta, ir.numero_caso, ir.puntaje ";
				$cadenaSql .= "FROM docencia.dependencia_docente as dd ";
				$cadenaSql .= "JOIN docencia.categoria_docente as cd ON cd.categoria_iddocente = dd.dependencia_iddocente ";
				$cadenaSql .= "JOIN docencia.docente as dt ON dt.identificacion_docente = dd.dependencia_iddocente ";
				$cadenaSql .= "JOIN docencia.indexacion_revista as ir ON ir.identificacion_docente = dd.dependencia_iddocente ";
				$cadenaSql .= "LEFT JOIN docencia.tipo_indexacion as ti ON ti.id_tipo_indexacion = ir.id_tipo_indexacion ";
				$cadenaSql .= "LEFT JOIN docencia.pais_kyron pk ON pk.paiscodigo = ir.paiscodigo ";
				$cadenaSql .= "WHERE id_indexacion_revista =" . $variable;
				break;
				
			case "actualizarIndexacion" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= "docencia.indexacion_revista ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "nombre_revista = '" . $variable [1] . "', ";
				$cadena_sql .= "id_contexto_revista = '" . $variable [2] . "', ";
				$cadena_sql .= "revista_indexacion = '" . $variable [4] . "', ";
				$cadena_sql .= "pais_publicacion = '" . $variable [3] . "', ";
				$cadena_sql .= "numero_issn = '" . $variable [5] . "', ";
				$cadena_sql .= "anno_publicacion = '" . $variable [6] . "', ";
				$cadena_sql .= "volumen_revista = '" . $variable [7] . "', ";
				$cadena_sql .= "numero_volumen = '" . $variable [8] . "', ";
				$cadena_sql .= "paginas_revista = '" . $variable [9] . "', ";
				$cadena_sql .= "titulo_articulo = '" . $variable [10] . "', ";
				$cadena_sql .= "numero_autores = '" . $variable [11] . "', ";
				$cadena_sql .= "numero_autores_ud = '" . $variable [12] . "', ";
				$cadena_sql .= "fecha_publicacion = '" . $variable [13] . "', ";
				$cadena_sql .= "acta_numero = '" . $variable [14] . "', ";
				$cadena_sql .= "fecha_acto = '" . $variable [15] . "', ";
				$cadena_sql .= "numero_caso = '" . $variable [16] . "', ";
				$cadena_sql .= "puntaje = '" . $variable [17] . "', ";
				$cadena_sql .= "detalledocencia = '" . $variable [18] . "' ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_indexacion_revista ='" . $variable [0] . "' ";
				break;
		}
		
		return $cadenaSql;
	}
}

?>
