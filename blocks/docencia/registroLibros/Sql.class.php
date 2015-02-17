<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlRegistroLibros extends sql {
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
			
			case "tipoLibro" :
				
				$cadena_sql = "SELECT id_tipo_libro, tipo_libro ";
				$cadena_sql .= "FROM docencia.tipo_libro ";
				$cadena_sql .= "ORDER BY id_tipo_libro";
				break;
			
			case "editorial" :
				
				$cadena_sql = "SELECT id_editorial, nombre_editorial ";
				$cadena_sql .= "FROM docencia.editoriales ";
				$cadena_sql .= "ORDER BY id_editorial";
				break;
			
			case "categoriaLibro" :
				
				$cadena_sql = "SELECT id_cate_libro, desc_cate_libro ";
				$cadena_sql .= "FROM docencia.categoria_libro ";
				$cadena_sql .= "ORDER BY id_cate_libro";
				break;
			
			case "tipo_entidad" :
				
				$cadena_sql = "SELECT id_tipo, desc_tipo_enti ";
				$cadena_sql .= "FROM docencia.tipo_entidad ";
				$cadena_sql .= "ORDER BY id_tipo";
				break;
			
			case "tipo_titulo" :
				
				$cadena_sql = "SELECT id_nivel, descripcion_nivel ";
				$cadena_sql .= "FROM docencia.nivel_formacion ";
				$cadena_sql .= "ORDER BY id_nivel";
				break;
			
			case "universidad" :
				
				$cadena_sql = "SELECT id_universidad, nombre_universidad ";
				$cadena_sql .= "FROM docencia.universidades ";
				$cadena_sql .= "WHERE id_universidad>-1 ";
				$cadena_sql .= "ORDER BY nombre_universidad";
				break;
			
			case "pais" :
				
				$cadena_sql = "SELECT paiscodigo, paisnombre ";
				$cadena_sql .= "FROM pais ";
				$cadena_sql .= "ORDER BY paisnombre";
				break;
			

			case "consultarDocente" :
				
				$cadena_sql = "SELECT informacion_numeroidentificacion, ";
				$cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
				$cadena_sql .= "FROM docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
				break;
			case "insertarLibro" :
				
				$cadena_sql = "INSERT INTO docencia.registro_libros( ";
				$cadena_sql .= "id_docente, titulo, id_tipo_libro, id_entidad, codigo_numeracion, ";
				$cadena_sql .= "nume_autores, nume_autores_ud, editorial, annio, nume_acta, fech_acta, ";
				$cadena_sql .= "nume_caso, puntaje, detalledocencia) ";
				$cadena_sql .= " VALUES (" . $variable [0] . ",";
				$cadena_sql .= " '" . $variable [1] . "',";
				$cadena_sql .= " " . $variable [2] . ",";
				$cadena_sql .= " " . $variable [3] . ",";
				$cadena_sql .= " '" . $variable [4] . "',";
				$cadena_sql .= " '" . $variable [5] . "',";
				$cadena_sql .= " '" . $variable [6] . "',";
				$cadena_sql .= " '" . $variable [7] . "',";
				$cadena_sql .= " '" . $variable [8] . "',";
				$cadena_sql .= " '" . $variable [9] . "',";
				$cadena_sql .= " '" . $variable [10] . "',";
				$cadena_sql .= " '" . $variable [11] . "',";
				$cadena_sql .= " '" . $variable [12] . "',";
				$cadena_sql .= " '" . $variable [13] . "')";
				$cadena_sql .= " RETURNING  id_libro ";
				
				break;
			
			case "actualizarLibros" :
				
				$cadena_sql = " UPDATE docencia.registro_libros ";
				$cadena_sql .= " SET ";
				$cadena_sql .= " titulo ='" . $variable [1] . "', ";
				$cadena_sql .= " id_tipo_libro ='" . $variable [2] . "', ";
				$cadena_sql .= " id_entidad = ".$variable[3].", ";
				$cadena_sql .= " codigo_numeracion ='" . $variable [4] . "', ";
				$cadena_sql .= " nume_autores ='" . $variable [5] . "', ";
				$cadena_sql .= " nume_autores_ud ='" . $variable [6] . "', ";
				$cadena_sql .= " editorial ='" . $variable [7] . "', ";
				$cadena_sql .= " annio ='" . $variable [8] . "', ";
				$cadena_sql .= " nume_acta ='" . $variable [9] . "', ";
				$cadena_sql .= " fech_acta ='" . $variable [10] . "', ";
				$cadena_sql .= " nume_caso ='" . $variable [11] . "', ";
				$cadena_sql .= " puntaje ='" . $variable [12] . "', ";
				$cadena_sql .= " detalledocencia ='" . $variable [13] . "' ";
				$cadena_sql .= "WHERE id_libro=" . $variable [0];
				
				break;
			
			case "insertEva" :
				
				$cadena_sql = "INSERT INTO docencia.revisores_libros( ";
				$cadena_sql .= "id_libro, revisor_iden, revisor_nombre, revisor_institucion, revisor_puntaje, estado) ";
				$cadena_sql .= " VALUES (" . $variable1 . ",";
				$cadena_sql .= "'" . $variable [0] . "',";
				$cadena_sql .= "'" . $variable [1] . "',";
				$cadena_sql .= "'" . $variable [2] . "',";
				$cadena_sql .= "" . $variable [3] . ",";
				$cadena_sql .= "'AC')";
				
				break;
			
			case "actualizarEvaluador" :
				
				$cadena_sql = " UPDATE docencia.revisores_libros ";
				$cadena_sql .= " SET ";
				$cadena_sql .= " revisor_iden ='" . $variable [2] . "', ";
				$cadena_sql .= " revisor_nombre ='" . $variable [3] . "', ";
				$cadena_sql .= " revisor_institucion ='" . $variable [4] . "', ";
				$cadena_sql .= " revisor_puntaje ='" . $variable [5] . "' ";
				$cadena_sql .= " WHERE id_libro=" . $variable [0];
				$cadena_sql .= " AND id_revisores=" . $variable [1];
				
				break;
			
			case "inhabilitarEvaluador" :
				
				$cadena_sql = " UPDATE docencia.revisores_libros ";
				$cadena_sql .= " SET ";
				$cadena_sql .= " estado ='IN' ";
				$cadena_sql .= " WHERE id_libro=" . $variable [0];
				$cadena_sql .= " AND id_revisores=" . $variable [1];
				
				break;
			
			case "insertarNuevoEvaluador" :
				
				$cadena_sql = "INSERT INTO docencia.revisores_libros( ";
				$cadena_sql .= "id_libro, revisor_iden, revisor_nombre, revisor_institucion, revisor_puntaje, estado) ";
				$cadena_sql .= " VALUES (" . $variable [0] . ",";
				$cadena_sql .= "'" . $variable [2] . "',";
				$cadena_sql .= "'" . $variable [3] . "',";
				$cadena_sql .= "'" . $variable [4] . "',";
				$cadena_sql .= "" . $variable [5] . ",";
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
			
			case "consultarLibros" :
				
				$cadena_sql = "SELECT DISTINCT  ";
				$cadena_sql .= "id_docente,informacion_nombres, informacion_apellidos, id_libro, titulo, rl.id_tipo_libro, tipo_libro, ";
				$cadena_sql .= "id_entidad, codigo_numeracion, nume_autores, nume_autores_ud, editorial,  ";
				$cadena_sql .= "annio, nume_acta, fech_acta, nume_caso, puntaje, detalledocencia ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= "JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.registro_libros as rl ON id_docente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.tipo_libro as tl ON tl.id_tipo_libro = rl.id_tipo_libro ";
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
			
			case "consultarLibroModificar" :
				
				$cadena_sql = "SELECT DISTINCT  ";
				$cadena_sql .= "id_docente, id_libro, titulo, id_tipo_libro, ";
				$cadena_sql .= "id_entidad, codigo_numeracion, nume_autores, nume_autores_ud, editorial,  ";
				$cadena_sql .= "annio, nume_acta, fech_acta, nume_caso, puntaje, detalledocencia ";
				$cadena_sql .= "FROM docencia.registro_libros ";
				$cadena_sql .= "WHERE id_libro = " . $variable;
				
				break;
			
			case "consultarEvaluadoresLibros" :
				
				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= " id_revisores, id_libro, revisor_iden, revisor_nombre, revisor_institucion, revisor_puntaje  ";
				$cadena_sql .= "FROM docencia.revisores_libros ";
				$cadena_sql .= " WHERE id_libro=" . $variable;
				$cadena_sql .= " AND estado= 'AC'";
				
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
		}
		return $cadena_sql;
	}
}
?>
