<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqltecSofDocente extends sql {
	var $miConfigurador;
	function __construct() {
		$this->miConfigurador = Configurador::singleton ();
	}
	function cadena_sql($tipo, $variable = "", $variable2 = "") {
		
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
				$cadena_sql .= "FROM docencia.contexto_entidad  ";
				$cadena_sql .= "ORDER BY  id_contexto";
				break;
			
			case "tipo_titulo" :
				
				$cadena_sql = "SELECT id_nivel, descripcion_nivel ";
				$cadena_sql .= "FROM docencia.nivel_formacion ";
				$cadena_sql .= "ORDER BY id_nivel";
				break;
			
			case "consultarEvaluadores" :
				
				$cadena_sql = "SELECT id_evaluador  ";
				$cadena_sql .= "FROM docencia.evaluador_tec_sotf ";
				$cadena_sql .= "WHERE id_tecn_soft='" . $variable . "'";
				
				break;
			
			case "universidad" :
				
				$cadena_sql = "SELECT id_universidad, nombre_universidad ";
				$cadena_sql .= "FROM docencia.universidades ";
				$cadena_sql .= "ORDER BY nombre_universidad";
				break;
			
			case "tipo_produccion" :
				
				$cadena_sql = "SELECT id_tipo_producc, descr_tipo_producc ";
				$cadena_sql .= "FROM docencia.tipo_produc_teg_soft ";
				$cadena_sql .= "ORDER BY id_tipo_producc ASC";
				
				break;
			
			case "numeroEvaluadores" :
				
				$cadena_sql = "SELECT id_num_evaluadores, descripcion_num_evaluadores ";
				$cadena_sql .= "FROM docencia.num_evaluadores ";
				$cadena_sql .= "ORDER BY id_num_evaluadores";
				break;
			
			case "numTecSoft" :
				
				$cadena_sql = "	SELECT count(*) ";
				$cadena_sql .= "FROM docencia.tecn_sotf_docente  ";
				$cadena_sql .= "WHERE id_docente = '" . $variable [0] . "' ";
				$cadena_sql .= "AND fech_produccion BETWEEN '" . $variable [1] . "-01-01' AND '" . $variable [1] . "-12-31' ";
				$cadena_sql .= "AND id_tecn_soft != '".$variable [2]."' ";
				
				break;
			
			case "fechaActualizar" :
				
				$cadena_sql = "	SELECT count(*) ";
				$cadena_sql .= "FROM docencia.tecn_sotf_docente  ";
				$cadena_sql .= "WHERE id_docente = '" . $variable [0] . "' ";
				$cadena_sql .= "AND fech_produccion='" . $variable [1] . "'";
				
				break;
			
			case "consultarDocente" :
				
				$cadena_sql = "SELECT informacion_numeroidentificacion, ";
				$cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
				$cadena_sql .= "FROM docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
				break;
                            
                        case "buscarProyectos" :

                            $cadena_sql = "SELECT codigo_proyecto, nombre_proyecto ";
                            $cadena_sql .= "FROM docencia.proyectocurricular ";
                            $cadena_sql .= " WHERE id_facultad = '".$variable."' ";
                            $cadena_sql .= "ORDER BY nombre_proyecto";
                            break;    
                        
                        case "idActualizar" :
				
				$cadena_sql = "SELECT fech_produccion FROM  docencia.tecn_sotf_docente ";
                                $cadena_sql .= "WHERE id_tecn_soft='" . $variable . "'";
				
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
			
			case "insertarTecSoft" :
				
				$cadena_sql = "INSERT INTO docencia.tecn_sotf_docente(";
				$cadena_sql .= " id_docente, tipo_produccion,nume_certificado, nume_evaluadores,fech_produccion, nume_acta, ";
				$cadena_sql .= "fech_acta, nume_caso, puntaje, detalledocencia) ";
				$cadena_sql .= " VALUES ('" . $variable [0] . "',";
				$cadena_sql .= " '" . $variable [1] . "',";
				$cadena_sql .= "' " . $variable [2] . "',";
				$cadena_sql .= " '" . $variable [3] . "',";
				$cadena_sql .= " '" . $variable [4] . "',";
				$cadena_sql .= " '" . $variable [5] . "',";
				$cadena_sql .= " '" . $variable [6] . "',";
				$cadena_sql .= " '" . $variable [7] . "',";
				$cadena_sql .= " '" . $variable [8] . "', ";
				$cadena_sql .= " '" . $variable [9] . "') ";
				$cadena_sql .= "  RETURNING id_tecn_soft";
				
				
				break;
			
			case "insertarEvaluadores" :
				
				$cadena_sql = "INSERT INTO 	docencia.evaluador_tec_sotf(";
				$cadena_sql .= " id_tecn_soft, identificacion_evaluador, nombre_evaluador, institucion_evaluador, puntaje_evaluador)";
				$cadena_sql .= " VALUES ('" . $variable2 . "',";
				$cadena_sql .= " '" . $variable [0] . "',";
				$cadena_sql .= " '" . $variable [1] . "', ";
				$cadena_sql .= " '" . $variable [2] . "', ";
				$cadena_sql .= " '" . $variable [3] . "') ";
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
			
			case "consultarEvaluadorestecsoftModificar" :
				
				$cadena_sql = "SELECT identificacion_evaluador, nombre_evaluador, institucion_evaluador, puntaje_evaluador ";
				$cadena_sql .= "FROM docencia.evaluador_tec_sotf ";
				$cadena_sql .= "WHERE id_tecn_soft='" . $variable . "'";
				
				break;
			
			case "consultartecsoftModificar" :
				
				$cadena_sql = "SELECT id_tecn_soft, id_docente, tipo_produccion, nume_certificado,";
				$cadena_sql .= "nume_evaluadores, nume_acta, fech_acta, nume_caso, puntaje,fech_produccion, detalledocencia ";
				$cadena_sql .= "FROM docencia.tecn_sotf_docente ";
				$cadena_sql .= "WHERE id_tecn_soft='" . $variable . "'";
				break;
			
			case "consultarExperiencia" :
				
				$cadena_sql = "SELECT DISTINCT id_docente,";
				$cadena_sql .= "descr_tipo_producc, ";
				$cadena_sql .= "nume_certificado, nume_evaluadores,nume_acta,fech_acta, nume_caso,puntaje, ";
				$cadena_sql .= "informacion_nombres, informacion_apellidos,id_tecn_soft,fech_produccion ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= "LEFT JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
				$cadena_sql .= "LEFT JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= " JOIN docencia.tecn_sotf_docente ON id_docente = dependencia_iddocente ";
				$cadena_sql .= " JOIN docencia.tipo_produc_teg_soft  ON id_tipo_producc  = tipo_produccion ";
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
				
				break;
			
			case "actualizarTecSoft" :
				
				$cadena_sql = "UPDATE docencia.tecn_sotf_docente ";
				$cadena_sql .= "SET tipo_produccion='" . $variable [1] . "',";
				$cadena_sql .= "nume_certificado='" . $variable [2] . "',";
				$cadena_sql .= "nume_evaluadores='" . $variable [3] . "',";
				$cadena_sql .= "fech_produccion='" . $variable [4] . "',";
				$cadena_sql .= "nume_acta='" . $variable [5] . "',";
				$cadena_sql .= "fech_acta='" . $variable [6] . "',";
				$cadena_sql .= "nume_caso='" . $variable [7] . "',";
				$cadena_sql .= "puntaje='" . $variable [8] . "', ";
				$cadena_sql .= "detalledocencia='" . $variable [9] . "' ";
				$cadena_sql .= "WHERE id_tecn_soft='" . $variable [0] . "'";
				
				break;
			
			case "actualizarEvaluadores" :

                                $cadena_sql = "UPDATE docencia.evaluador_tec_sotf ";
				$cadena_sql .= "SET identificacion_evaluador='" . $variable [0] . "',";
				$cadena_sql .= "nombre_evaluador='" . $variable [1] . "', ";
				$cadena_sql .= "institucion_evaluador='" . $variable [2] . "', ";
				$cadena_sql .= "puntaje_evaluador='" . $variable [3] . "' ";
				$cadena_sql .= "WHERE id_evaluador='" . $variable2 . "'";
				
				break;
			
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
