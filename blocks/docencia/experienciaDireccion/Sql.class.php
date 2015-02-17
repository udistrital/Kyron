<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlexperienciaDireccion extends sql {
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
		
		switch ($tipo) {
			
			case "tipo_entidad" :
				
				$cadena_sql = "SELECT id_tipo, desc_tipo_enti ";
				$cadena_sql .= "FROM docencia.tipo_entidad ";
				$cadena_sql .= "ORDER BY id_tipo";
				break;
			
			case "universidad" :
				
				$cadena_sql = "SELECT id_universidad, nombre_universidad ";
				$cadena_sql .= "FROM docencia.universidades ";
				$cadena_sql .= "ORDER BY id_universidad";
				break;
			
			case "tipo" :
				
				$cadena_sql = "SELECT id_tipodireccion, nombre_tipodireccion ";
				$cadena_sql .= "FROM docencia.direccion_tipo ";
				$cadena_sql .= "ORDER BY id_tipodireccion";
				break;
		
			case "buscarNombreDocente" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "informacion_numeroidentificacion, ";
				$cadena_sql .= "informacion_numeroidentificacion || ' - ' || UPPER(informacion_nombres)|| ' ' ||UPPER(informacion_apellidos) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.docente_informacion ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "informacion_estadoregistro = TRUE  ";
                                
                                if($variable != '')
                                    {
                                        if(is_numeric($variable))
                                        {
                                            $cadena_sql .= " AND  informacion_numeroidentificacion like '%".$variable."%'  ";
                                        }else
                                            {
                                                $cadena_sql .= " AND  ((UPPER(informacion_nombres) like '%".strtoupper($variable)."%') OR (UPPER(informacion_apellidos) like '%".strtoupper($variable)."%'))  ";
                                            }
                                    }
                                
				
				break;
			
			case "consultarDocente" :
				
				$cadena_sql = "SELECT informacion_numeroidentificacion, ";
				$cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
				$cadena_sql .= "FROM docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
				break;
			
			case "insertarExperiencia" :
				
				$cadena_sql = "INSERT INTO docencia.experiencia_direccion_acade( ";
				$cadena_sql .= "id_docente, entidad, otra_entidad, tipo_entidad, ";
				$cadena_sql .= "num_horas, fecha_inicio, fecha_fin, duracion_dias, nume_acta, ";
				$cadena_sql .= "fecha_acta, nume_caso, puntaje, detalledocencia)";
				$cadena_sql .= " VALUES (" . $variable [0] . ",";
				$cadena_sql .= " '" . $variable [1] . "',";
				$cadena_sql .= " '" . $variable [2] . "',";
				$cadena_sql .= " '" . $variable [3] . "',";
				$cadena_sql .= " '" . $variable [4] . "',";
				$cadena_sql .= " '" . $variable [5] . "',";
				$cadena_sql .= " '" . $variable [6] . "',";
				$cadena_sql .= " '" . $variable [7] . "',";
				$cadena_sql .= " '" . $variable [8] . "',";
				$cadena_sql .= " '" . $variable [9] . "',";
				$cadena_sql .= " '" . $variable [10] . "',";
				$cadena_sql .= " '" . $variable [11] . "',";
				$cadena_sql .= " '" . $variable [12] . "')";
				
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
			
			case "consultarExperienciaModificar" :
				$cadena_sql = "SELECT  id_docente, entidad, otra_entidad, tipo_entidad,";
				$cadena_sql .= "num_horas, fecha_inicio, fecha_fin, duracion_dias, nume_acta,";
				$cadena_sql .= "fecha_acta, nume_caso, puntaje, detalledocencia ";
				$cadena_sql .= "FROM docencia.experiencia_direccion_acade ";
				$cadena_sql .= "WHERE id_experiencia='" . $variable . "';";
				break;
			
			case "consultarAutores" :
				$cadena_sql = "SELECT id_autors";
				$cadena_sql .= "  FROM docencia.autors_direccion ";
				$cadena_sql .= "WHERE id_direccion='" . $variable . "';";
				
				break;
			
			case "consultarExperiencia" :
				
				$cadena_sql = "SELECT DISTINCT id_docente,
									case WHEN entidad ='0' THEN otra_entidad
                                 WHEN entidad != '0' THEN nombre_universidad  ELSE otra_entidad  END  AS entidad, desc_tipo_enti , ";
				$cadena_sql .= "num_horas, fecha_inicio, fecha_fin, duracion_dias, nume_acta, ";
				$cadena_sql .= "fecha_acta, nume_caso, puntaje,";
				$cadena_sql .= " informacion_nombres, informacion_apellidos, id_experiencia ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.experiencia_direccion_acade ON id_docente = dependencia_iddocente ";
				$cadena_sql .= "LEFT JOIN docencia.tipo_entidad ON  id_tipo=tipo_entidad ";
				$cadena_sql .= "LEFT  JOIN docencia.universidades ON id_universidad = entidad ";
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
				$cadena_sql .= " ORDER BY id_experiencia";
				
				break;
			
			case "actualizarExperiencia" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= "docencia.experiencia_direccion_acade ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "entidad = '" . $variable [1] . "', ";
				$cadena_sql .= "otra_entidad = '" . $variable [2] . "', ";
				$cadena_sql .= "tipo_entidad = '" . $variable [3] . "', ";
				$cadena_sql .= "num_horas = '" . $variable [4] . "', ";
				$cadena_sql .= "fecha_inicio = '" . $variable [5] . "', ";
				$cadena_sql .= "fecha_fin = '" . $variable [6] . "', ";
				$cadena_sql .= "duracion_dias = '" . $variable [7] . "', ";
				$cadena_sql .= "nume_acta = '" . $variable [8] . "', ";
				$cadena_sql .= "fecha_acta = '" . $variable [9] . "', ";
				$cadena_sql .= "nume_caso = '" . $variable [10] . "', ";
				$cadena_sql .= "puntaje = '" . $variable [11] . "', ";
				$cadena_sql .= "detalledocencia = '" . $variable [12] . "' ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_experiencia ='" . $variable [0] . "' ";
				break;
			
			case "atualizarautor" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= "docencia.autors_direccion ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "nom_autor = '" . $variable [0] . "' ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_direccion ='" . $variable1 . "' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "id_autors ='" . $variable2 . "' ";
				
				break;
			
			//
			
			// UPDATE docencia.autors_direccion
			// SET id_autors=?, id_direccion=?, nom_autor=?
			// WHERE <condition>;
			
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
