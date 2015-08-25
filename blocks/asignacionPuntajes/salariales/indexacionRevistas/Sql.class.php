<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlindexacionRevistas extends sql {
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
			
			case "contexto" :
				
				$cadena_sql = "SELECT id_contexto, descripcion_contexto ";
				$cadena_sql .= "FROM docencia.contexto_entidad  ";
				$cadena_sql .= "ORDER BY  id_contexto";
				break;
			
                        case "buscarProyectos" :

                            $cadena_sql = "SELECT codigo_proyecto, nombre_proyecto ";
                            $cadena_sql .= "FROM docencia.proyectocurricular ";
                            $cadena_sql .= " WHERE id_facultad = '".$variable."' ";
                            $cadena_sql .= "ORDER BY nombre_proyecto";
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
			
			case "buscarCategoria_revista" :
				
				$cadena_sql = "SELECT item_id, ";
				$cadena_sql .= "item_nombre, ";
				$cadena_sql .= "item_descripcion ";
				$cadena_sql .= "FROM docencia.parametros_indexacion ";
				$cadena_sql .= " WHERE item_idparametro=3  ";
				$cadena_sql .= "ORDER BY item_id";
				break;
			
			case "buscarCategoria_revista2" :
				
				$cadena_sql = "SELECT item_id, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM docencia.parametros_indexacion ";
				$cadena_sql .= " WHERE item_idparametro=2  ";
				$cadena_sql .= "ORDER BY item_id";
				break;
			
			case "buscarUniversidad" :
				
				$cadena_sql = "SELECT id_universidad, nombre_universidad ";
				$cadena_sql .= "FROM docencia.universidades ";
				$cadena_sql .= "ORDER BY nombre_universidad";
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
			
			case "insertarIndexacion" :
				$cadena_sql = "INSERT INTO docencia.indexacion_revistas( ";
				$cadena_sql .= "id_revista_docente, revista_nombre, revista_tipo, pais_publicacion, ";
				$cadena_sql .= "revista_indexacion, ";
				$cadena_sql .= "numero_issn, anno_publicacion, volumen_revista, numero_volumen, paginas_revista, ";
				$cadena_sql .= "titulo_articulo, numero_autores, numero_autores_ud, fecha_publicacion, ";
				$cadena_sql .= "acta_numero, fecha_acto, numero_caso, puntaje, detalledocencia) ";
				$cadena_sql .= " VALUES (" . $variable [0] . ",";
				$cadena_sql .= " '" . $variable [1] . "',";
				$cadena_sql .= " '" . $variable [2] . "',";
				$cadena_sql .= "'" . $variable [3] . "',";
				$cadena_sql .= " '" . $variable [4] . "',";
				$cadena_sql .= " " . $variable [5] . ",";
				$cadena_sql .= " '" . $variable [6] . "',";
				$cadena_sql .= " '" . $variable [7] . "',";
				$cadena_sql .= " '" . $variable [8] . "',";
				$cadena_sql .= " '" . $variable [9] . "',";
				$cadena_sql .= " '" . $variable [10] . "',";
				$cadena_sql .= " '" . $variable [11] . "',";
				$cadena_sql .= " '" . $variable [12] . "',";
				$cadena_sql .= "' " . $variable [13] . "' ,";
				$cadena_sql .= "' " . $variable [14] . "',";
				$cadena_sql .= " '" . $variable [15] . "',";
				$cadena_sql .= "' " . $variable [16] . "',";
				$cadena_sql .= " '" . $variable [17] . "',";
				$cadena_sql .= " '" . $variable [18] . "')";
				break;		
							
			case "consultarIndexacion" :
				
				$cadena_sql = "SELECT  id_indexacion_revista, id_revista_docente, ";
				$cadena_sql .= " informacion_nombres, informacion_apellidos,  ";
				$cadena_sql .= " revista_nombre, titulo_articulo, paisnombre,   ";
				$cadena_sql .= "item_nombre, numero_issn, ";
				$cadena_sql .= "anno_publicacion, ";
				$cadena_sql .= " volumen_revista, numero_volumen, paginas_revista, fecha_publicacion ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= "JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.indexacion_revistas ON id_revista_docente = dependencia_iddocente ";
				$cadena_sql .= "LEFT JOIN docencia.parametros_indexacion ON item_id = revista_indexacion ";
				$cadena_sql .= "LEFT JOIN docencia.pais_kyron ON paiscodigo = pais_publicacion ";
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
			
			case "consultarRevistas" :
				
				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= "id_indexacion_revista, revista_nombre, revista_tipo, item_nombre,   ";
				$cadena_sql .= "numero_issn, anno_publicacion, volumen_revista, numero_volumen,  ";
				$cadena_sql .= "paginas_revista, numero_autores, acta_numero, numero_caso, fecha_publicacion,  ";
				$cadena_sql .= "puntaje, titulo_articulo, fecha_acto, numero_autores_ud, id_revista_docente,  ";
				$cadena_sql .= "pais_publicacion, detalledocencia, revista_indexacion  ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.indexacion_revistas ON id_revista_docente = dependencia_iddocente ";
				$cadena_sql .= "LEFT JOIN docencia.parametros_indexacion ON item_id = revista_indexacion ";
				$cadena_sql .= "LEFT JOIN docencia.pais_kyron ON paiscodigo = pais_publicacion  ";
				$cadena_sql .= "WHERE id_indexacion_revista =" . $variable;
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
			
			case "consultarDocente" :
				
				$cadena_sql = "SELECT informacion_numeroidentificacion, ";
				$cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
				$cadena_sql .= "FROM docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
				break;
			
			case "actualizarIndexacion" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= "docencia.indexacion_revistas ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "revista_nombre = '" . $variable [1] . "', ";
				$cadena_sql .= "revista_tipo = '" . $variable [2] . "', ";
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
