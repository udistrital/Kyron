<?php

namespace asignacionPuntajes\salariales\produccionDeLibros;

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
				$cadenaSql .= "	nombre_facultad";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.facultades";
				break;
				
			case "proyectoCurricular" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_facultad,";
				$cadenaSql .= "	nombre_proyecto";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.proyectocurricular";
				break;
				
			case "pais" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_pais,";
				$cadenaSql .= "	nombre_pais";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.pais";
				$cadenaSql .= " WHERE";
				$cadenaSql .= " lower(nombre_pais) != 'colombia'";
				break;
				
			case "categoria_revista" :
				$cadenaSql = "select";
				$cadenaSql .= " id_tipo_indexacion,";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.categoria_revista";
				$cadenaSql .= " WHERE";
				$cadenaSql .= " contexto_revista =" . $variable;
				break;
				
			case "docente" :
				$cadenaSql = "SELECT informacion_numeroidentificacion||' - '||informacion_nombres AS  value, informacion_numeroidentificacion  AS data ";
				$cadenaSql .= " FROM docencia.docente_informacion";
				$cadenaSql .= " WHERE cast(informacion_numeroidentificacion as text) LIKE '%" . $variable . "%'";
				$cadenaSql .= " OR informacion_nombres LIKE '%" . $variable . "%' LIMIT 10;";
				
				break;
				
			case "consultarIndexacion" :			
				$cadenaSql = "SELECT  id_indexacion_revista, id_revista_docente, ";
				$cadenaSql .= " informacion_nombres, informacion_apellidos,  ";
				$cadenaSql .= " revista_nombre, titulo_articulo, paisnombre,   ";
				$cadenaSql .= "item_nombre, numero_issn, ";
				$cadenaSql .= "anno_publicacion, ";
				$cadenaSql .= " volumen_revista, numero_volumen, paginas_revista, fecha_publicacion ";
				$cadenaSql .= "FROM docencia.dependencia_docente ";
				$cadenaSql .= "JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
				$cadenaSql .= "JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadenaSql .= "JOIN docencia.indexacion_revistas ON id_revista_docente = dependencia_iddocente ";
				$cadenaSql .= "LEFT JOIN docencia.parametros_indexacion ON item_id = revista_indexacion ";
				$cadenaSql .= "LEFT JOIN docencia.pais_kyron ON paiscodigo = pais_publicacion ";
				$cadenaSql .= "WHERE 1=1";
// 				if ($variable [0] != '') {
// 					$cadena_sql .= " AND dependencia_iddocente = '" . $variable [0] . "'";
// 				}
// 				if ($variable [1] != '') {
// 					$cadena_sql .= " AND dependencia_facultad = '" . $variable [1] . "'";
// 				}
// 				if ($variable [2] != '') {
// 					$cadena_sql .= " AND dependencia_proyectocurricular = '" . $variable [2] . "'";
// 				}
				break;
						
		}
		
		return $cadenaSql;
	}
}

?>
