<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqltraduccionesDocente extends sql {
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
                            
                        case "buscarProyectos" :

                            $cadena_sql = "SELECT codigo_proyecto, nombre_proyecto ";
                            $cadena_sql .= "FROM docencia.proyectocurricular ";
                            $cadena_sql .= " WHERE id_facultad = '".$variable."' ";
                            $cadena_sql .= "ORDER BY nombre_proyecto";
                            break;   
			
			case "tipo_obra" :
				
				$cadena_sql = "SELECT id_tipo_obra, decr_obra_artistica ";
				$cadena_sql .= "FROM docencia.tipo_obra_artistica ";
				$cadena_sql .= "ORDER BY id_tipo_obra;";
				break;
			
			case "repTraducciones" :
				
				$cadena_sql = "	SELECT count(*) as repeticiones ";
				$cadena_sql .= "FROM docencia.traduccion_docente  ";
				$cadena_sql .= "WHERE id_docente = '" . $variable [0] . "' ";
				$cadena_sql .= "AND titulo_traduccion = '" . $variable [1] . "' ";
				
				break;
			
			case "repModificarTraducciones" :
				
				$cadena_sql = "	Select id_traduccion as identificador ";
				$cadena_sql .= "FROM docencia.traduccion_docente  ";
				$cadena_sql .= "WHERE id_docente = '" . $variable [0] . "' ";
				$cadena_sql .= "AND titulo_traduccion = '" . $variable [1] . "' ";

				
			 break;
			
			case "numTraducciones" :
				
				$cadena_sql = "	SELECT count(*) numeroTraducc ";
				$cadena_sql .= "FROM docencia.traduccion_docente  ";
				$cadena_sql .= "WHERE id_docente = '" . $variable [0] . "' ";
				$cadena_sql .= "AND fecha BETWEEN '" . $variable [2] . "-01-01' AND '" . $variable [2] . "-12-31' ";
				
				break;
			
			case "tipo_revista" :
				
				$cadena_sql = "SELECT id_tipo_revista_trd, descr_tipo_revista_trd   ";
				$cadena_sql .= "FROM docencia.tipo_revista_trd  ";
				$cadena_sql .= "ORDER BY id_tipo_revista_trd; ";
				break;
			
			case "tipo_traducc" :
				
				$cadena_sql = "SELECT id_tipo_traduccion, descr_tipo_traduccion   ";
				$cadena_sql .= "FROM docencia.tipo_traduccion  ";
				$cadena_sql .= "ORDER BY id_tipo_traduccion;";
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
			
			case "insertarTraduccion" :
				
				$cadena_sql = "INSERT INTO docencia.traduccion_docente( ";
				$cadena_sql .= "id_docente, titulo_publicacion, titulo_traduccion, revista_traduccion,  ";
				$cadena_sql .= "	tipo_traduccion, num_revista, volumen, anior, tipo_revista, ";
				$cadena_sql .= "	nom_libro, editorial, aniol, fecha, nume_acta, fech_acta, nume_caso,puntaje, detalledocencia )";
				$cadena_sql .= " VALUES ('" . $variable [0] . "',";
				$cadena_sql .= " '" . $variable [1] . "',";
				$cadena_sql .= "'" . $variable [2] . "',";
				$cadena_sql .= " '" . $variable [3] . "',";
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
				$cadena_sql .= " '" . $variable [14] . "',";
				$cadena_sql .= " '" . $variable [15] . "',";
				$cadena_sql .= " '" . $variable [16] . "',";
				$cadena_sql .= " '" . $variable [17] . "')";
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
			
			case "consultarTraduccion" :
				
				$cadena_sql = "SELECT DISTINCT id_docente,";
				$cadena_sql .= " titulo_publicacion, titulo_traduccion, ";
				$cadena_sql .= "revista_traduccion, tipo_traduccion, num_revista, volumen, anior, ";
				$cadena_sql .= "nom_libro, editorial, aniol, fecha, nume_acta, fech_acta, nume_caso, ";
				$cadena_sql .= "puntaje, tipo_revista, detalledocencia ";
				$cadena_sql .= "FROM docencia.traduccion_docente ";
				$cadena_sql .= "WHERE id_traduccion =" . $variable;
				
				break;
			
			case "consultar" :
				
				$cadena_sql = "SELECT DISTINCT id_traduccion, ";
				$cadena_sql .= "id_docente, titulo_publicacion, titulo_traduccion,descr_tipo_traduccion,  ";
				$cadena_sql .= " fecha, nume_acta, fech_acta, nume_caso, puntaje,  ";
				$cadena_sql .= " informacion_nombres, informacion_apellidos, ";
				$cadena_sql .= "case WHEN tipo_traduccion ='1' THEN nom_libro ";
				$cadena_sql .= "WHEN tipo_traduccion ='2' THEN revista_traduccion END  AS tipo_publicacion ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "LEFT JOIN docencia.traduccion_docente ON id_docente = dependencia_iddocente ";
				$cadena_sql .= "LEFT JOIN docencia.tipo_traduccion ON  id_tipo_traduccion= tipo_traduccion  ";
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
			
			case "consultarDocente" :
				
				$cadena_sql = "SELECT informacion_numeroidentificacion, ";
				$cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
				$cadena_sql .= "FROM docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
				break;
			
			case "actualizarTraduccion" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= "docencia.traduccion_docente ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "titulo_publicacion = '" . $variable [1] . "', ";
				$cadena_sql .= "titulo_traduccion = '" . $variable [2] . "', ";
				$cadena_sql .= "revista_traduccion = '" . $variable [3] . "', ";
				$cadena_sql .= "tipo_traduccion = '" . $variable [4] . "', ";
				$cadena_sql .= "num_revista = '" . $variable [5] . "', ";
				$cadena_sql .= "volumen = '" . $variable [6] . "', ";
				$cadena_sql .= "anior = '" . $variable [7] . "', ";
				$cadena_sql .= "nom_libro = '" . $variable [9] . "', ";
				$cadena_sql .= "editorial = '" . $variable [10] . "', ";
				$cadena_sql .= "aniol = '" . $variable [11] . "', ";
				$cadena_sql .= "fecha = '" . $variable [12] . "', ";
				$cadena_sql .= "nume_acta = '" . $variable [13] . "', ";
				$cadena_sql .= "fech_acta = '" . $variable [14] . "', ";
				$cadena_sql .= "nume_caso = '" . $variable [15] . "', ";
				$cadena_sql .= "puntaje = '" . $variable [16] . "', ";
				$cadena_sql .= "detalledocencia = '" . $variable [17] . "', ";
				$cadena_sql .= "tipo_revista = '" . $variable [8] . "' ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_traduccion ='" . $variable [0] . "' ";
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
