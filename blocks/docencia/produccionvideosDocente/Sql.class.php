<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlproduccionvideosDocente extends sql {
	var $miConfigurador;
	function __construct() {
		$this->miConfigurador = Configurador::singleton ();
	}
	function cadena_sql($tipo, $variable = "", $variable1 = "") {

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
                            
                        case "buscarProyectos" :

                            $cadena_sql = "SELECT codigo_proyecto, nombre_proyecto ";
                            $cadena_sql .= "FROM docencia.proyectocurricular ";
                            $cadena_sql .= " WHERE id_facultad = '".$variable."' ";
                            $cadena_sql .= "ORDER BY nombre_proyecto";
                            break;    
					
			case "pertenecia" :

				$cadena_sql = "SELECT id_perteneciente, descripcion_perteneciente ";
				$cadena_sql .= "FROM docencia.perteneciente ";
				$cadena_sql .= "ORDER BY id_perteneciente";
				break;
					
			case "numeroAutores" :

				$cadena_sql = "SELECT id_num_evaluadores, descripcion_num_evaluadores ";
				$cadena_sql .= "FROM docencia.num_evaluadores ";
				$cadena_sql .= "WHERE parametro=1 ";
				$cadena_sql .= "ORDER BY id_num_evaluadores";
				break;
					
			case "numeroEvaluadores" :

				$cadena_sql = "SELECT id_num_evaluadores, descripcion_num_evaluadores ";
				$cadena_sql .= "FROM docencia.num_evaluadores ";
				$cadena_sql .= "WHERE parametro=2 ";
				$cadena_sql .= "ORDER BY id_num_evaluadores";
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

				$cadena_sql = "SELECT id_pais, nombre_pais ";
				$cadena_sql .= "FROM docencia.pais ";
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
					
			case "insertarvideo" :

				$cadena_sql = "INSERT INTO docencia.prvideos_docente( ";
				$cadena_sql .= " id_docente, titulo_video, nume_auto, nume_autoud, fech_video, impacto, ";
				$cadena_sql .= " caracter, nume_acta, fech_acta, nume_caso, puntaje, detalledocencia) ";
				$cadena_sql .= " VALUES ('" . $variable [0] . "',";
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
				$cadena_sql .= " '" . $variable [11] . "')";
				$cadena_sql .= " RETURNING  id_prvideos ";

				break;
					
			case "insertarautor" :

				$cadena_sql = "INSERT INTO docencia.autors_videos( ";
				$cadena_sql .= "id_videos, nom_autor,univer_distrital, estado) ";
				$cadena_sql .= " VALUES ('" . $variable1 . "',";
				$cadena_sql .= " '" . $variable [0] . "',";
				$cadena_sql .= " '" . $variable [1] . "',";
				$cadena_sql .= " 'AC')";

				break;
					
			case "insertEva" :

				$cadena_sql = "INSERT INTO docencia.revisores_videos( ";
				$cadena_sql .= "id_videos, revisor_autor, revisor_institucion, revisor_puntaje, estado) ";
				$cadena_sql .= " VALUES ('" . $variable1 . "',";
				$cadena_sql .= "' " . $variable [0] . "',";
				$cadena_sql .= "' " . $variable [1] . "',";
				$cadena_sql .= "' " . $variable [2] . "',";
				$cadena_sql .= "'AC')";

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

			case "registrarEvento" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= $prefijo . "logger( ";
				$cadena_sql .= "id_usuario, ";
				$cadena_sql .= "evento, ";
				$cadena_sql .= "fecha) ";
				$cadena_sql .= "VALUES( ";
				$cadena_sql .= $variable[0].", ";
				$cadena_sql .= "'" . $variable[1] . "', ";
				$cadena_sql .= "'" . time () . "') ";
				break;
					
				// SELECT id_prvideos, id_docente, titulo_video, fech_video, contexto,
				// nume_acta, fech_acta, nume_caso, puntaje
				// FROM docencia.prvideos_docente;
				
			case "consultar" :
				$cadena_sql = "SELECT DISTINCT id_docente,";
				$cadena_sql .= " titulo_video, fech_video, descripcion_contexto,  ";
				$cadena_sql .= "nume_acta, fech_acta, nume_caso, puntaje,  ";
				$cadena_sql .= " informacion_nombres, informacion_apellidos, id_prvideos  ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= "JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.prvideos_docente ON id_docente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.contexto_obra ON id_contexto= impacto  ";
				// $cadena_sql .= "JOIN docencia.pais ON id_pais= pais ";
				// $cadena_sql .= " JOIN docencia.tipo_obra_artistica ON id_tipo_obra = tipo_obra ";
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
					
			case "consultarVideo" :

				$cadena_sql = "SELECT DISTINCT id_docente,";
				$cadena_sql .= " titulo_video, fech_video,  ";
				$cadena_sql .= "nume_acta, fech_acta, nume_caso, puntaje,  ";
				$cadena_sql .= " informacion_nombres, informacion_apellidos, id_prvideos, impacto, detalledocencia, nume_auto, nume_autoud, caracter ";
                                $cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= "JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.prvideos_docente ON id_docente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.contexto_obra ON id_contexto= impacto  ";
				$cadena_sql .= "WHERE id_prvideos=" . $variable;

				break;
                            
                            case "consultarAutoresVideo" :

				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= " id_autors, id_videos, nom_autor, univer_distrital  ";
				$cadena_sql .= "FROM docencia.autors_videos ";
				$cadena_sql .= " WHERE id_videos=" . $variable;
				$cadena_sql .= " AND estado= 'AC'";

				break;
                            
                            case "consultarEvaluadoresVideo" :

				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= " id_videos, id_revisores, revisor_autor,revisor_institucion,revisor_puntaje ";
				$cadena_sql .= " FROM docencia.revisores_videos ";
				$cadena_sql .= " WHERE id_videos=" . $variable;
				$cadena_sql .= " AND estado='AC'";

				break;
                            
                            case "consultarDocente" :
				
				$cadena_sql = "SELECT informacion_numeroidentificacion, ";
				$cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
				$cadena_sql .= "FROM docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
				break;
                            
                            case "actualizarVideos" :
                                
				$cadena_sql = " UPDATE docencia.prvideos_docente ";
				$cadena_sql .= " SET ";
				$cadena_sql .= " titulo_video ='".$variable[1]."', ";
				$cadena_sql .= " nume_auto ='".$variable[2]."', ";
				$cadena_sql .= " nume_autoud ='".$variable[3]."', ";
				$cadena_sql .= " fech_video ='".$variable[4]."', ";
				$cadena_sql .= " impacto ='".$variable[5]."', ";
				$cadena_sql .= " caracter ='".$variable[6]."', ";
				$cadena_sql .= " nume_acta ='".$variable[7]."', ";
				$cadena_sql .= " fech_acta ='".$variable[8]."', ";
				$cadena_sql .= " nume_caso ='".$variable[9]."', ";
				$cadena_sql .= " puntaje ='".$variable[10]."', ";
				$cadena_sql .= " detalledocencia ='".$variable[11]."' ";
				$cadena_sql .= "WHERE id_prvideos=" . $variable[0];

				break;
                            
                            case "actualizarAutor" :

                                $cadena_sql = " UPDATE docencia.autors_videos ";
				$cadena_sql .= " SET ";
				$cadena_sql .= " nom_autor ='".$variable[2]."', ";
				$cadena_sql .= " univer_distrital ='".$variable[3]."' ";
				$cadena_sql .= " WHERE id_videos=" . $variable[0];
				$cadena_sql .= " AND id_autors=" . $variable[1];

				break;
                            
                            case "inhabilitarAutor" :

                                $cadena_sql = " UPDATE docencia.autors_videos ";
				$cadena_sql .= " SET ";
				$cadena_sql .= " estado ='IN' ";
				$cadena_sql .= " WHERE id_videos=" . $variable[0];
				$cadena_sql .= " AND id_autors=" . $variable[1];

				break;
					
                            case "insertarNuevoAutor" :

				$cadena_sql = "INSERT INTO docencia.autors_videos( ";
				$cadena_sql .= "id_videos, nom_autor,univer_distrital, estado) ";
				$cadena_sql .= " VALUES ('" . $variable[0] . "',";
				$cadena_sql .= " '" . $variable [1] . "',";
				$cadena_sql .= " '" . $variable [2] . "',";
				$cadena_sql .= " 'AC')";

				break;
                            
                            case "actualizarEvaluador" :

                                $cadena_sql = " UPDATE docencia.revisores_videos ";
				$cadena_sql .= " SET "; 	 	
				$cadena_sql .= " revisor_autor ='".$variable[2]."', ";
				$cadena_sql .= " revisor_institucion ='".$variable[3]."', ";
				$cadena_sql .= " revisor_puntaje ='".$variable[4]."' ";
				$cadena_sql .= " WHERE id_videos=" . $variable[0]; 	 	
				$cadena_sql .= " AND id_revisores=" . $variable[1];

				break;
                            
                            case "inhabilitarEvaluador" :

                                $cadena_sql = " UPDATE docencia.revisores_videos ";
				$cadena_sql .= " SET ";
				$cadena_sql .= " estado ='IN' ";
				$cadena_sql .= " WHERE id_videos=" . $variable[0];
				$cadena_sql .= " AND id_revisores=" . $variable[1];

				break;
				
                            case "insertarNuevoEvaluador" :

				$cadena_sql = "INSERT INTO docencia.revisores_videos( ";
				$cadena_sql .= "id_videos, revisor_autor, revisor_institucion, revisor_puntaje, estado) ";
				$cadena_sql .= " VALUES ('" . $variable[0] . "',";
				$cadena_sql .= " '" . $variable [1] . "',";
				$cadena_sql .= " '" . $variable [2] . "',";
				$cadena_sql .= " '" . $variable [3] . "',";
				$cadena_sql .= " 'AC')";

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
