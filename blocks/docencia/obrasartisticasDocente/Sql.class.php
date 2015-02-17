<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlobrasartisticasDocente extends sql {
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
                            
                        case "buscarProyectos" :

                            $cadena_sql = "SELECT codigo_proyecto, nombre_proyecto ";
                            $cadena_sql .= "FROM docencia.proyectocurricular ";
                            $cadena_sql .= " WHERE id_facultad = '".$variable."' ";
                            $cadena_sql .= "ORDER BY nombre_proyecto";
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
			
			case "insertarObra" :
				
				$cadena_sql = "INSERT INTO docencia.obras_docente( ";
				$cadena_sql .= "id_docente, tipo_obra, titulo_obra, certifica, anio_obra, contexto_obra, ";
				$cadena_sql .= " nume_acta, fech_acta, nume_caso,puntaje, detalledocencia) ";
				$cadena_sql .= " VALUES ('" . $variable [0] . "',";
				$cadena_sql .= " '" . $variable [1] . "',";
				$cadena_sql .= "' " . $variable [2] . "',";
				$cadena_sql .= " '" . $variable [3] . "',";
				$cadena_sql .= " '" . $variable [4] . "',";
				$cadena_sql .= " '" . $variable [5] . "',";
				$cadena_sql .= " '" . $variable [6] . "',";
				$cadena_sql .= " '" . $variable [7] . "',";
				$cadena_sql .= " '" . $variable [8] . "',";
				$cadena_sql .= " '" . $variable [9] . "',";
				$cadena_sql .= " '" . $variable [10] . "')";
				
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
			
			case "consultarDocente" :
				
				$cadena_sql = "SELECT informacion_numeroidentificacion, ";
				$cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
				$cadena_sql .= "FROM docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
				break;
			
			case "validarCantidad" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "COUNT(*) ";
				$cadena_sql .= "FROM docencia.obras_docente ";
				$cadena_sql .= "WHERE id_docente = '". $variable[0]. "'";
				$cadena_sql .= " AND anio_obra = '". $variable[1]. "'";
				
				break;
			
			case "consultarObra" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "tipo_obra ,titulo_obra, certifica, anio_obra, contexto_obra, ";
				$cadena_sql .= " nume_acta, fech_acta, nume_caso,puntaje, detalledocencia ";
				$cadena_sql .= "FROM docencia.obras_docente ";
				$cadena_sql .= "WHERE id_obras = '". $variable. "'";
				
				break;
			
			case "consultarExperiencia" :
				
				$cadena_sql = "SELECT DISTINCT id_docente,";
				$cadena_sql .= "decr_obra_artistica ,titulo_obra, certifica, anio_obra, descripcion_contexto, ";
				$cadena_sql .= " nume_acta, fech_acta, nume_caso,puntaje, ";
				$cadena_sql .= " informacion_nombres, informacion_apellidos,id_obras, detalledocencia ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= "JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.obras_docente ON id_docente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.contexto_obra ON id_contexto= contexto_obra ";
				$cadena_sql .= " JOIN docencia.tipo_obra_artistica  ON id_tipo_obra = tipo_obra ";
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
				

			
			case "actualizarObra" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= "docencia.obras_docente ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "tipo_obra = '" . $variable [1] . "', ";
				$cadena_sql .= "titulo_obra = '" . $variable [2] . "', ";
				$cadena_sql .= "certifica = '" . $variable [3] . "', ";
				$cadena_sql .= "contexto_obra = '" . $variable [5] . "', ";
				$cadena_sql .= "anio_obra = '" . $variable [4] . "', ";
				$cadena_sql .= "nume_acta = '" . $variable [6] . "', ";
				$cadena_sql .= "fech_acta = '" . $variable [7] . "', ";
				$cadena_sql .= "nume_caso = '" . $variable [8] . "', ";
				$cadena_sql .= "puntaje = '" . $variable [9] . "', ";
				$cadena_sql .= "detalledocencia = '" . $variable [10] . "' ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_obras ='" . $variable [0] . "' ";
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
			 * Clausulas g	enéricas.
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
