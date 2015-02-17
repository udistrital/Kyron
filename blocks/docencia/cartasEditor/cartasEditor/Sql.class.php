<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlCartasEditor extends sql {
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
				$cadena_sql .= "item_nombre, ";
				$cadena_sql .= "item_descripcion ";
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
			
			case "insertarCartas" :
				$cadena_sql = "INSERT INTO docencia.cartas_editor( ";
				$cadena_sql .= "id_docente, nombre, tipo_contexto, pais, ";
				$cadena_sql .= "indexacion, institucion,";
				$cadena_sql .= "issn, annio_publ, volumen, nro_revista, paginas, ";
				$cadena_sql .= "titulo_art, nro_autores, autores_ud, fecha_publ, ";
				$cadena_sql .= "nume_acta, fech_acta, nume_caso, puntaje, detalledocencia) ";
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
				$cadena_sql .= " '" . $variable [18] . "',";
				$cadena_sql .= " '" . $variable [19] . "')";
				break;
			
			case "consultarCartas" :
				
				$cadena_sql = "SELECT  id_docente,";
				$cadena_sql .= "indexacion, nombre, titulo_art, ";
				$cadena_sql .= "item_nombre,  ";
				$cadena_sql .= "nombre_universidad, issn, annio_publ, volumen, ";
				$cadena_sql .= "nro_revista, paginas, fecha_publ, ";
				$cadena_sql .= " informacion_nombres, informacion_apellidos,paisnombre, puntaje, id_carta, detalledocencia ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= "JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.cartas_editor ON id_docente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.parametros_indexacion ON item_id = indexacion ";
				$cadena_sql .= "JOIN docencia.universidades ON id_universidad = institucion ";
				$cadena_sql .= "JOIN docencia.pais_kyron ON paiscodigo = pais  ";
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
			
			case "consultarEditor" :
				
				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= "indexacion, nombre, tipo_contexto, item_nombre,   ";
				$cadena_sql .= "issn, annio_publ, volumen, nro_revista,  ";
				$cadena_sql .= "paginas, nro_autores, nume_acta, nume_caso, fecha_publ,  ";
				$cadena_sql .= "puntaje, titulo_art, fech_acta, autores_ud, id_docente,  ";
				$cadena_sql .= "paisnombre, nombre_universidad, detalledocencia  ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.cartas_editor ON id_docente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.parametros_indexacion ON item_id = indexacion ";
				$cadena_sql .= "JOIN docencia.universidades ON id_universidad = institucion ";
				$cadena_sql .= "JOIN docencia.pais_kyron ON paiscodigo = pais  ";
				$cadena_sql .= "WHERE id_carta =" . $variable;
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
			
			case "consultarCartas" :
				
				$cadena_sql = "SELECT DISTINCT id_docente, informacion_nombres, informacion_apellidos, ";
				$cadena_sql .= " titulo, autor, annio, revista, nume_acta, fech_acta, nume_caso, puntaje, detalledocencia ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= "JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.cartas_editor ON id_docente = dependencia_iddocente ";
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
			
			case "actualizarCarta" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= "docencia.cartas_editor ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "nombre = '" . $variable [1] . "', ";
				$cadena_sql .= "tipo_contexto = '" . $variable [2] . "', ";
				$cadena_sql .= "indexacion = '" . $variable [4] . "', ";
				$cadena_sql .= "pais = '" . $variable [3] . "', ";
				$cadena_sql .= "institucion = '" . $variable [5] . "', ";
				$cadena_sql .= "issn = '" . $variable [6] . "', ";
				$cadena_sql .= "annio_publ = '" . $variable [7] . "', ";
				$cadena_sql .= "volumen = '" . $variable [8] . "', ";
				$cadena_sql .= "nro_revista = '" . $variable [9] . "', ";
				$cadena_sql .= "paginas = '" . $variable [10] . "', ";
				$cadena_sql .= "titulo_art = '" . $variable [11] . "', ";
				$cadena_sql .= "nro_autores = '" . $variable [12] . "', ";
				$cadena_sql .= "autores_ud = '" . $variable [13] . "', ";
				$cadena_sql .= "fecha_publ = '" . $variable [14] . "', ";
				$cadena_sql .= "nume_acta = '" . $variable [15] . "', ";
				$cadena_sql .= "fech_acta = '" . $variable [16] . "', ";
				$cadena_sql .= "nume_caso = '" . $variable [17] . "', ";
				$cadena_sql .= "puntaje = '" . $variable [18] . "', ";
				$cadena_sql .= "detalledocencia = '" . $variable [19] . "' ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_carta ='" . $variable [0] . "' ";
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
