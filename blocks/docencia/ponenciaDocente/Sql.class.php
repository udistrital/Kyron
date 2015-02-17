<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlponenciaDocente extends sql {
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
				$cadena_sql .= "FROM docencia.contexto_ponencia  ";
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
				$cadena_sql .= "FROM docencia.pais_kyron ";
				break;
			
			case "paises_del_mundo" :
				
				$cadena_sql = "SELECT paiscodigo, paisnombre ";
				$cadena_sql .= "FROM docencia.pais_kyron ";
				$cadena_sql .= "WHERE paiscodigo<>'COL'";
				$cadena_sql .= "ORDER BY paisnombre";
				break;
			
			case "ciudades_colombia" :
				
				$cadena_sql = "SELECT ciudadid, ciudadnombre ";
				$cadena_sql .= "FROM docencia.ciudad_kyron ";
				$cadena_sql .= "WHERE paiscodigo='COL'";
				$cadena_sql .= "ORDER BY paiscodigo";
				break;
			
			case "ciudades_del_mundo" :
				
				$cadena_sql = "SELECT ciudadid, ciudadnombre ";
				$cadena_sql .= "FROM docencia.ciudad_kyron ";
				$cadena_sql .= "WHERE paiscodigo<>'COL'";
				$cadena_sql .= "ORDER BY ciudadnombre";
				break;
			
			case "docentePonencia" :
				
				$cadena_sql = "	SELECT id_docente ";
				$cadena_sql .= "FROM docencia.ponencia_docente  ";
				$cadena_sql .= "WHERE id_ponencia = '" . $variable . "' ";
				break;

			case "numPonencias" :
				
				$cadena_sql = "	SELECT count(*) ";
				$cadena_sql .= "FROM docencia.ponencia_docente  ";
				$cadena_sql .= "WHERE id_docente = '" . $variable[0] . "' ";
				$cadena_sql .= "AND fecha BETWEEN '" . $variable[2] . "-01-01' AND '" . $variable[2] . "-12-31' ";
				break;

			case "numPonenciasContexto" :
				
				$cadena_sql = "	SELECT count(*) ";
				$cadena_sql .= "FROM docencia.ponencia_docente  ";
				$cadena_sql .= "WHERE id_docente = '" . $variable[0] . "' ";
				$cadena_sql .= "AND contexto_ponencia = '" . $variable[1] . "' ";
				$cadena_sql .= "AND fecha BETWEEN '" . $variable[2] . "-01-01' AND '" . $variable[2] . "-12-31' ";
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
			
			case "insertarPonencia" :
				
				$cadena_sql = "INSERT INTO  docencia.ponencia_docente( ";
				$cadena_sql .= "id_docente, nombre_ponencia, autores_ponencia, fecha, contexto_ponencia,";
				$cadena_sql .= "	evento_ponencia, ciudad, pais_ponencia, nume_certificado, nume_acta, fech_acta, nume_caso, puntaje, detalledocencia, autoresud)";
				$cadena_sql .= " VALUES ('" . $variable [0] . "',";
				$cadena_sql .= " '" . $variable [1] . "',";
				$cadena_sql .= " '" . $variable [2] . "',";
				$cadena_sql .= "' " . $variable [3] . "',";
				$cadena_sql .= " '" . $variable [4] . "',";
				$cadena_sql .= " '" . $variable [5] . "',";
				$cadena_sql .= " '" . $variable [6] . "',";
				$cadena_sql .= " '" . $variable [7] . "',";
				$cadena_sql .= " '" . $variable [8] . "',";
				$cadena_sql .= " '" . $variable [9] . "',";
				$cadena_sql .= " '" . $variable [10] . "',";
				$cadena_sql .= " '" . $variable [11] . "',";
				$cadena_sql .= " '" . $variable [12] . "',";
				$cadena_sql .= " '" . $variable [13] . "',";
				$cadena_sql .= " '" . $variable [14] . "')";
				
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
				$cadena_sql .= $variable [0] . ", ";
				$cadena_sql .= "'" . $variable [1] . "', ";
				$cadena_sql .= "'" . time () . "') ";
				break;
			
			case "consultar" :
				
				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= "id_ponencia, id_docente, nombre_ponencia, fecha, descripcion_contexto,  ";
				$cadena_sql .= "evento_ponencia, ciudadnombre, nume_certificado, nume_acta, fech_acta,   ";
				$cadena_sql .= "nume_caso, puntaje, autores_ponencia, paisnombre,  ";
				$cadena_sql .= " informacion_nombres, informacion_apellidos, detalledocencia, autoresud ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= "JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "LEFT JOIN docencia.ponencia_docente ON id_docente = dependencia_iddocente ";
				$cadena_sql .= "LEFT JOIN docencia.contexto_ponencia ON id_contexto= contexto_ponencia  ";
				$cadena_sql .= "LEFT JOIN docencia.pais_kyron ON paiscodigo = pais_ponencia  ";
				$cadena_sql .= "LEFT JOIN docencia.ciudad_kyron ON ciudadid = ciudad  ";
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
			
			case "consultarPonencia" :
				
				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= "id_ponencia, id_docente, nombre_ponencia, fecha, contexto_ponencia,  ";
				$cadena_sql .= "evento_ponencia, ciudad, nume_certificado, nume_acta, fech_acta,   ";
				$cadena_sql .= "nume_caso, puntaje, autores_ponencia, pais_ponencia,  ";
				$cadena_sql .= " informacion_nombres, informacion_apellidos, detalledocencia, autoresud ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.ponencia_docente ON id_docente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.contexto_ponencia ON id_contexto= contexto_ponencia  ";
				$cadena_sql .= "JOIN docencia.pais_kyron ON paiscodigo = pais_ponencia  ";
				$cadena_sql .= "JOIN docencia.ciudad_kyron ON ciudadid = ciudad  ";
				$cadena_sql .= "WHERE id_ponencia=" . $variable;
				break;

				
			case "consultarDocente" :
				
				$cadena_sql = "SELECT informacion_numeroidentificacion, ";
				$cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
				$cadena_sql .= "FROM docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
				break;
			
			case "actualizarPonencia" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= "docencia.ponencia_docente ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "nombre_ponencia = '" . $variable [1] . "', ";
				$cadena_sql .= "fecha = '" . $variable [3] . "', ";
				$cadena_sql .= "contexto_ponencia = '" . $variable [4] . "', ";
				$cadena_sql .= "evento_ponencia = '" . $variable [5] . "', ";
				$cadena_sql .= "nume_certificado = '" . $variable [8] . "', ";
				$cadena_sql .= "nume_acta = '" . $variable [9] . "', ";
				$cadena_sql .= "fech_acta = '" . $variable [10] . "', ";
				$cadena_sql .= "nume_caso = '" . $variable [11] . "', ";
				$cadena_sql .= "puntaje = '" . $variable [12] . "', ";
				$cadena_sql .= "autores_ponencia = '" . $variable [2] . "', ";
				$cadena_sql .= "pais_ponencia = '" . $variable [7] . "', ";
				$cadena_sql .= "ciudad = '" . $variable [6] . "', ";
				$cadena_sql .= "detalledocencia = '" . $variable [13] . "', ";
				$cadena_sql .= "autoresud = '" . $variable [14] . "' ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_ponencia ='" . $variable [0] . "' ";
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
