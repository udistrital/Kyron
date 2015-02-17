<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlactividadacademicaDocente extends sql {
	var $miConfigurador;
	function __construct() {
		$this->miConfigurador = Configurador::singleton ();
	}
	function cadena_sql($tipo, $variable = "") {
		
		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		
		switch ($tipo) {
			
			case "tipo_entidad" :
				
				$cadena_sql = "SELECT id_tipo, desc_tipo_enti ";
				$cadena_sql .= "FROM docencia.tipo_entidad ";
				$cadena_sql .= "ORDER BY id_tipo";
				break;
			
			case "contexto" :
				
				$cadena_sql = "SELECT id_contexto, descripcion_contexto ";
				$cadena_sql .= "FROM docencia.contexto_obra  ";
				$cadena_sql .= "ORDER BY  id_contexto";
				break;
			
			case "tipo_obra" :
				
				$cadena_sql = "SELECT id_tipo_obra, decr_obra_artistica ";
				$cadena_sql .= "FROM docencia.tipo_obra_artistica ";
				$cadena_sql .= "ORDER BY id_tipo_obra";
				break;
			
			case "tipo_titulo" :
				
				$cadena_sql = "SELECT id_nivel, descripcion_nivel ";
				$cadena_sql .= "FROM docencia.nivel_formacion ";
				$cadena_sql .= "ORDER BY id_nivel";
				break;
			
			case "universidad" :
				
				$cadena_sql = "SELECT id_universidad, nombre_universidad ";
				$cadena_sql .= "FROM docencia.universidades ";
				$cadena_sql .= "ORDER BY nombre_universidad";
				break;
			
			case "pais" :
				
				$cadena_sql = "SELECT paiscodigo, paisnombre ";
				$cadena_sql .= "FROM pais ";
				$cadena_sql .= "ORDER BY paisnombre";
				break;
			
			case "buscarNombreDocente" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "informacion_numeroidentificacion, ";
				$cadena_sql .= "UPPER(informacion_nombres)|| ' ' ||UPPER(informacion_apellidos) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.docente_informacion ";
				
				if (is_numeric ( $variable )) {
					$cadena_sql .= "WHERE ";
					$cadena_sql .= "informacion_numeroidentificacion like '%" . strtoupper ( trim ( $variable ) ) . "%' ";
				} else {
					$cadena_sql .= "WHERE ";
					$cadena_sql .= "UPPER(informacion_nombres) like '%" . strtoupper ( trim ( $variable ) ) . "%' ";
					$cadena_sql .= "OR ";
					$cadena_sql .= "UPPER(informacion_apellidos) like '%" . strtoupper ( trim ( $variable ) ) . "%' ";
				}
				$cadena_sql .= "AND ";
				$cadena_sql .= "informacion_estadoregistro = TRUE  ";
				
				break;
			

				
			
			case "insertarActividadAC" :
				
				
				
				$cadena_sql = "INSERT INTO docencia.actividadac_docente( ";
				$cadena_sql .= " id_docente, asignatura, inthoraria, num_estudiantes,  ";
				$cadena_sql .= "	ruta_horario, nombre_horario, ruta_syllabus, nombre_syllabus) ";
				$cadena_sql .= " VALUES ('" . $variable [0] . "',";
				$cadena_sql .= " '" . $variable [1] . "',";
				$cadena_sql .= "' " . $variable [2] . "',";
				$cadena_sql .= " '" . $variable [3] . "',";
				$cadena_sql .= " '" . $variable [4] . "',";
				$cadena_sql .= " '" . $variable [5] . "',";
				$cadena_sql .= " '" . $variable [6] . "',";
				$cadena_sql .= " '" . $variable [7] . "')";
				
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
			
			case "categoria" :
				
				$cadena_sql = "SELECT item_parametro, item_nombre ";
				$cadena_sql .= "FROM docencia.item_parametro ";
				$cadena_sql .= "WHERE item_idparametro = 1";
				break;
	
			
// 				SELECT id_actividadac, id_docente, asignatura, inthoraria, num_estudiantes,
// 				ruta_horario, nombre_horario, ruta_syllabus, nombre_syllabus
// 				FROM docencia.actividadac_docente;
				
				
			case "consultar" :
				
				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= "id_docente,asignatura, inthoraria, num_estudiantes,  ";
				$cadena_sql .= "ruta_horario, nombre_horario, ruta_syllabus, nombre_syllabus, ";
				$cadena_sql .= " informacion_nombres, informacion_apellidos ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.actividadac_docente ON id_docente = dependencia_iddocente ";
// 				$cadena_sql .= " JOIN docencia.tipo_obra_artistica  ON id_tipo_obra = tipo_obra ";
				$cadena_sql .= "WHERE 1=1";
				if ($variable [0] != '') {
					$cadena_sql .= " AND dependencia_iddocente = '" . $variable [0] . "'";
				}
				if ($variable [1] != '') {
					$cadena_sql .= " AND dependencia_facultad = '" . $variable [1] . "'";
				}
				if ($variable [2] != '') {
					$cadena_sql .= " AND dependencia_proyectocurricular = '" . $variable [2] . "'";
				}
				if ($variable [3] != '') {
					$cadena_sql .= " AND categoria_estado = '" . $variable [3] . "'";
				}
				
				break;
			
			// case "consultarExperiencia" :
			
			// $cadena_sql = "SELECT DISTINCT id_docente, nombre_universidad , ";
			// $cadena_sql .= " fecha_inicio, fecha_fin, nume_acta, fech_acta, nume_caso, duracion,puntaje, ";
			// $cadena_sql .= " informacion_nombres, informacion_apellidos ";
			// $cadena_sql .= "FROM docencia.dependencia_docente ";
			// $cadena_sql .= "JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
			// $cadena_sql .= "JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
			// $cadena_sql .= "JOIN docencia.experiencia_profesional ON id_docente = dependencia_iddocente ";
			// $cadena_sql .= "JOIN docencia.universidades ON id_universidad = entidad ";
			// $cadena_sql .= "WHERE 1=1";
			// if ($variable [0] != '') {
			// $cadena_sql .= " AND dependencia_iddocente = '" . $variable [0] . "'";
			// }
			// if ($variable [1] != '') {
			// $cadena_sql .= " AND dependencia_facultad = '" . $variable [1] . "'";
			// }
			// if ($variable [2] != '') {
			// $cadena_sql .= " AND dependencia_proyectocurricular = '" . $variable [2] . "'";
			// }
			// if ($variable [3] != '') {
			// $cadena_sql .= " AND categoria_estado = '" . $variable [3] . "'";
			// }
			
			// break;
			/**
			 * Clausulas genéricas.
			 * se espera que estén en todos los formularios
			 * que utilicen esta plantilla
			 */
			
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
