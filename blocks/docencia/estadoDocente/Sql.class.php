<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlestadoDocente extends sql {
	var $miConfigurador;
	function __construct() {
		$this->miConfigurador = Configurador::singleton ();
	}
	function cadena_sql($tipo, $variable = "", $variable1 = "", $variable2 = "") {
		
		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		$idSesion = '123';
		
		switch ($tipo) {
			
			/**
			 * Clausulas específicas
			 */
			
			case "consultarDocente" :
				
				$cadena_sql = "SELECT informacion_numeroidentificacion as Indentificacion, ";
				$cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
				$cadena_sql .= "FROM docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
				break;
			
			case "categoria" :
				
				$cadena_sql = "SELECT item_parametro, item_nombre ";
				$cadena_sql .= "FROM docencia.item_parametro ";
				$cadena_sql .= "WHERE item_idparametro = 1";
				break;
			
			case "facultad" :
				
				$cadena_sql = "SELECT codigo_facultad, nombre_facultad ";
				$cadena_sql .= "FROM docencia.facultades ";
				$cadena_sql .= "ORDER BY nombre_facultad";
				break;
			
			case "proyectos" :
				
				$cadena_sql = "SELECT codigo_proyecto, nombre_proyecto ";
				$cadena_sql .= "FROM docencia.proyectocurricular ";
				$cadena_sql .= "ORDER BY nombre_proyecto";
				break;
			
			case "buscarNombreDocente" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "informacion_numeroidentificacion, ";
				$cadena_sql .= "informacion_numeroidentificacion || ' - ' || UPPER(informacion_nombres)|| ' ' ||UPPER(informacion_apellidos) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.docente_informacion ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "informacion_estadoregistro = TRUE  ";
				break;
			
			case "seleccionEstado" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "id_parametro, ";
				$cadena_sql .= "nombre_parametro ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= " docencia.parametro_estado ";
				
				break;
			
			case "seleccionEstadoComplementario" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "id_parametro_compl, ";
				$cadena_sql .= "nombre_parametro ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= " docencia.parametro_estado_complementario ";
				
				break;
			
			case "ConsultarNumIdentificacion" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= " informacion_numeroidentificacion, ";
				$cadena_sql .= " informacion_nombres||''|| informacion_apellidos as nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= " docencia.docente_informacion  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "informacion_numeroidentificacion='" . $variable . "'";
				$cadena_sql .= "AND ";
				$cadena_sql .= "informacion_estadoregistro='TRUE';";
				
				break;
			
			case "Consultar Estado Modificar" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= " estado, ";
				$cadena_sql .= " estadocomplementario, ";
				$cadena_sql .= " fechainicioestado, ";
				$cadena_sql .= " fechaterminacionestado, ";
				$cadena_sql .= " ruta_soporte, ";
				$cadena_sql .= " nombre_soporte ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= " docencia.docente_estado  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_estado='" . $variable . "'";
				
				break;
			
			case "Guardar Estado Docente" :
				
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= "docencia.docente_estado";
				$cadena_sql .= "( ";
				$cadena_sql .= "iddocente, ";
				$cadena_sql .= "estado, ";
				$cadena_sql .= "estadocomplementario, ";
				$cadena_sql .= "fechainicioestado, ";
				$cadena_sql .= "fechaterminacionestado, ";
				$cadena_sql .= "ruta_soporte, ";
				$cadena_sql .= "nombre_soporte, ";
				$cadena_sql .= "estadoregistro, ";
				$cadena_sql .= "fecharegistro  ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable [0] . "', ";
				$cadena_sql .= "'" . $variable [1] . "', ";
				$cadena_sql .= "'" . $variable [2] . "', ";
				$cadena_sql .= "'" . $variable [3] . "', ";
				$cadena_sql .= "'" . $variable [4] . "', ";
				$cadena_sql .= "'" . $variable [5] . "', ";
				$cadena_sql .= "'" . $variable [6] . "', ";
				$cadena_sql .= "'" . $variable [8] . "', ";
				$cadena_sql .= "'" . $variable [7] . "' ";
				$cadena_sql .= ") ";
				// echo $cadena_sql;exit;
				break;
			
			// -----------------------------------------------------------------------------------
			
			case "Consultar Estado Docente" :
				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= "iddocente,  ";
				$cadena_sql .= "es.nombre_parametro estado,  ";
				$cadena_sql .= "CASE estadocomplementario WHEN '0' THEN 'No Aplica' ELSE com.nombre_parametro END estadocomplentario,  ";
				$cadena_sql .= "CASE ruta_soporte WHEN 'NULL' THEN 'No Aplica' ELSE ruta_soporte END ruta,  ";
				$cadena_sql .= "CASE nombre_soporte WHEN 'NULL' THEN 'No Aplica' ELSE nombre_soporte END nombre_ruta,  ";
				$cadena_sql .= "fechainicioestado fechainicio,  ";		
				$cadena_sql .= "fechaterminacionestado fechaterminacion, ";
				$cadena_sql .= "informacion_nombres, informacion_apellidos,id_estado  ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= "JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.docente_estado ON iddocente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.parametro_estado as es ON id_parametro = estado ";
				$cadena_sql .= "LEFT JOIN docencia.parametro_estado_complementario as com ON id_parametro_compl = estadocomplementario ";
				$cadena_sql .= "WHERE 1=1 ";
				$cadena_sql .= "AND   ";
				$cadena_sql .= "estadoregistro='true' ";
				
				if ($variable [0] != '') {
					$cadena_sql .= " AND dependencia_iddocente = '" . $variable [0] . "'";
				}
				if ($variable [1] != '') {
					$cadena_sql .= " AND dependencia_facultad = '" . $variable [1] . "'";
				}
				if ($variable [2] != '') {
					$cadena_sql .= " AND dependencia_proyectocurricular = '" . $variable [2] . "'";
				}
 				
				break;
			
			case "Consultar Historico Docente" :
				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= "iddocente,  ";
				$cadena_sql .= "es.nombre_parametro estado,  ";
				$cadena_sql .= "CASE estadocomplementario WHEN '0' THEN 'No Aplica' ELSE com.nombre_parametro END estadocomplentario,  ";
				$cadena_sql .= "CASE ruta_soporte WHEN 'NULL' THEN 'No Aplica' ELSE ruta_soporte END ruta,  ";
				$cadena_sql .= "CASE nombre_soporte WHEN 'NULL' THEN 'No Aplica' ELSE nombre_soporte END nombre_ruta,  ";
				$cadena_sql .= "fechainicioestado fechainicio,  ";
				$cadena_sql .= "fechaterminacionestado fechaterminacion, ";
				$cadena_sql .= "informacion_nombres, informacion_apellidos,id_estado,fecharegistro  ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= "JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.docente_estado ON iddocente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.parametro_estado as es ON id_parametro = estado ";
				$cadena_sql .= "LEFT JOIN docencia.parametro_estado_complementario as com ON id_parametro_compl = estadocomplementario ";
				$cadena_sql .= "WHERE 1=1 ";
				$cadena_sql .= " AND dependencia_iddocente = '" . $variable . "' ORDER BY  id_estado ASC ";
				
				break;
	
			
			case "Consultar Historico Docente Excel" :
				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= "iddocente,informacion_nombres||' '||informacion_apellidos,  ";
				$cadena_sql .= "es.nombre_parametro estado,  ";
				$cadena_sql .= "CASE estadocomplementario WHEN '0' THEN 'No Aplica' ELSE com.nombre_parametro END estadocomplentario,  ";
				$cadena_sql .= "CASE nombre_soporte WHEN 'NULL' THEN 'No Aplica' ELSE nombre_soporte END nombre_ruta,  ";
				$cadena_sql .= "fechainicioestado fechainicio,  ";
				$cadena_sql .= "fechaterminacionestado fechaterminacion, ";
				$cadena_sql .= "fecharegistro  ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= "JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.docente_estado ON iddocente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.parametro_estado as es ON id_parametro = estado ";
				$cadena_sql .= "LEFT JOIN docencia.parametro_estado_complementario as com ON id_parametro_compl = estadocomplementario ";
				$cadena_sql .= "WHERE 1=1 ";
				$cadena_sql .= " AND dependencia_iddocente = '" . $variable . "' ORDER BY  fecharegistro ASC ";
				
				break;
			
			case "Actualizar Registro Estado Actual" :
				
				$cadena_sql = "UPDATE docencia.docente_estado ";
				$cadena_sql .= "SET  estadoregistro='0' ";
				$cadena_sql .= "WHERE iddocente='" . $variable . "'  ";
				$cadena_sql .= "AND  estadoregistro=' 1' ";
				
				break;
			
			case "Actualizar Estado Docente" :
				
				$cadena_sql = "UPDATE docencia.docente_estado ";
				$cadena_sql .= "SET  estado='" . $variable [1] . "',";
				$cadena_sql .= " estadocomplementario='" . $variable [2] . "', ";
				if ($variable [3] == 'NULL') {
					$cadena_sql .= " fechainicioestado='0001-01-01', ";
					$cadena_sql .= " fechaterminacionestado='0001-01-01', ";
				} else {
					$cadena_sql .= " fechainicioestado='" . $variable [3] . "', ";
					$cadena_sql .= " fechaterminacionestado='" . $variable [4] . "', ";
				}
				$cadena_sql .= " ruta_soporte='" . $variable [5] . "', ";
				$cadena_sql .= " nombre_soporte='" . $variable [6] . "', ";
				$cadena_sql .= " fecharegistro='" . $variable [7] . "'  ";
				$cadena_sql .= "WHERE id_estado='" . $variable [0] . "'  ";
				
				break;
			
			case "Consultar Nombre Docente" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= " informacion_nombres||' '||informacion_apellidos AS nombre  ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.docente_informacion ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "informacion_iddocente='" . $variable . "' ";
				$cadena_sql .= "AND   ";
				$cadena_sql .= "informacion_estadoregistro='true' ";
				
				break;
			// ---------------------------------------------------------------------------------------------------
			
			case "Guardar Documento Soporte Estado" :
				
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= "docencia.documento_soporte_estado";
				$cadena_sql .= "( ";
				$cadena_sql .= "documentosoporte_nombrearchivo, ";
				$cadena_sql .= "documentosoporte_ruta, ";
				$cadena_sql .= "documentosoporte_formato, ";
				$cadena_sql .= "documentosoporte_autor ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable ['nombre'] . "', ";
				$cadena_sql .= "'" . $variable ['ruta'] . "', ";
				$cadena_sql .= "'" . $variable ['formato'] . "', ";
				$cadena_sql .= "'" . $variable ['Autor'] . "' ";
				$cadena_sql .= ") ";
				$cadena_sql .= "RETURNING id_documentosoporte as identificador ;";
				break;
			
			case "Actualizar Historico Estado" :
				
				$cadena_sql = "	UPDATE ";
				$cadena_sql .= "docencia.docente_estado ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "estadodocente_estadoregistro='false'  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "estadodocente_iddocente='" . $variable . "' ";
				$cadena_sql .= "AND   ";
				$cadena_sql .= "estadodocente_estadoregistro='true'";
				break;
	
			

	
	
			// ------------------------------------------------------------
			
		
			
			/**
			 * Clausulas genéricas.
			 * se espera que estén en todos los formularios
			 * que utilicen esta plantilla
			 */
			
			case "registrarEvento" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= $prefijo . "logger( ";
				$cadena_sql .= "id_usuario, ";
				$cadena_sql .= "evento, ";
				$cadena_sql .= "fecha) ";
				$cadena_sql .= "VALUES( ";
				$cadena_sql .= $variable [0] . ", ";
				$cadena_sql .= "'" . $variable [1] . "', ";
				$cadena_sql .= "'" . time () . "') ";
				break;
			
			case "iniciarTransaccion" :
				$cadena_sql = "START TRANSACTION";
				break;
			
			case "finalizarTransaccion" :
				$cadena_sql = "COMMIT";
				break;
			
			case "cancelarTransaccion" :
				$cadena_sql = "ROLLBACK";
				break;
			
			case "eliminarTemp" :
				
				$cadena_sql = "DELETE ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo . "tempFormulario ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_sesion = '" . $variable . "' ";
				break;
			
			case "insertarTemp" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= $prefijo . "tempFormulario ";
				$cadena_sql .= "( ";
				$cadena_sql .= "id_sesion, ";
				$cadena_sql .= "formulario, ";
				$cadena_sql .= "campo, ";
				$cadena_sql .= "valor, ";
				$cadena_sql .= "fecha ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				
				foreach ( $_REQUEST as $clave => $valor ) {
					$cadena_sql .= "( ";
					$cadena_sql .= "'" . $idSesion . "', ";
					$cadena_sql .= "'" . $variable ['formulario'] . "', ";
					$cadena_sql .= "'" . $clave . "', ";
					$cadena_sql .= "'" . $valor . "', ";
					$cadena_sql .= "'" . $variable ['fecha'] . "' ";
					$cadena_sql .= "),";
				}
				
				$cadena_sql = substr ( $cadena_sql, 0, (strlen ( $cadena_sql ) - 1) );
				break;
			
			case "rescatarTemp" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "id_sesion, ";
				$cadena_sql .= "formulario, ";
				$cadena_sql .= "campo, ";
				$cadena_sql .= "valor, ";
				$cadena_sql .= "fecha ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo . "tempFormulario ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_sesion='" . $idSesion . "'";
				break;
		}
		
		return $cadena_sql;
	}
}
?>
