<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlcapituloLibros extends sql {
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
			
			case "tipo_libro" :
				
				$cadena_sql = "SELECT id_tipo_libro, tipo_libro  ";
				$cadena_sql .= "FROM docencia.tipo_libro ";
				$cadena_sql .= "ORDER BY id_tipo_libro";
				break;
			
                         case "buscarProyectos" :

                            $cadena_sql = "SELECT codigo_proyecto, nombre_proyecto ";
                            $cadena_sql .= "FROM docencia.proyectocurricular ";
                            $cadena_sql .= " WHERE id_facultad = '".$variable."' ";
                            $cadena_sql .= "ORDER BY nombre_proyecto";
                            break;    
                            
			case "universidad" :
				
				$cadena_sql = "SELECT id_universidad, nombre_universidad ";
				$cadena_sql .= "FROM docencia.universidades ";
				$cadena_sql .= "WHERE id_universidad >-1 ";
				$cadena_sql .= "ORDER BY nombre_universidad";
				break;
			
			case "tipo" :
				
				$cadena_sql = "SELECT id_tipodireccion, nombre_tipodireccion ";
				$cadena_sql .= "FROM docencia.direccion_tipo ";
				$cadena_sql .= "ORDER BY id_tipodireccion";
				break;
			
			case "categoria" :
				
				$cadena_sql = "SELECT id_categoriadireccion, nombre_categoriadireccion ";
				$cadena_sql .= "FROM docencia.direccion_categoria ";
				$cadena_sql .= "ORDER BY id_categoriadireccion";
				break;
			
			case "numDireccion" :
				
				$cadena_sql = "	SELECT count(*) ";
				$cadena_sql .= "FROM docencia.direccion_trabajos  ";
				$cadena_sql .= "WHERE docente_direccion = '" . $variable [0] . "' ";
				$cadena_sql .= "AND anio_direccion ='" . $variable [1] . "' ";
				
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
			
			case "insertarEvaluador" :
				
				$cadena_sql = "INSERT INTO docencia.evaluador_capitulos( ";
				$cadena_sql .= "id_capitulo, nom_evaluador, enti_univer, puntaje)";
				$cadena_sql .= " VALUES ('" . $variable1 . "',";
				$cadena_sql .= " '" . $variable [0] . "',";
				$cadena_sql .= " '" . $variable [1] . "',";
				$cadena_sql .= " '" . $variable [2] . "')";
				
				break;
			
			case "insertarCapitulo" :
				
				$cadena_sql = "INSERT INTO docencia.capitulo_libros(";
				$cadena_sql .= " id_docente, titulo_capitulo, titulo_libro, tipo_libro, ";
				$cadena_sql .= "codigo_nunm, editorial, anio_libro, volumen, num_autor_cap, num_autor_cap_univ, ";
				$cadena_sql .= "num_autor_libro, num_autor_libro_univ, num_evaluadores, numacta, ";
				$cadena_sql .= "fechacta, numcaso, puntaje, detalledocencia) ";
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
				$cadena_sql .= " '" . $variable [12] . "',";
				$cadena_sql .= " '" . $variable [13] . "',";
				$cadena_sql .= " '" . $variable [14] . "',";
				$cadena_sql .= " '" . $variable [15] . "',";
				$cadena_sql .= " '" . $variable [16] . "',";
				$cadena_sql .= " '" . $variable [17] . "')";
				$cadena_sql .= " RETURNING id_capitulo ";
				
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
			
			case "consultarEvaluadoresModificar" :
				$cadena_sql = " SELECT  nom_evaluador, enti_univer, puntaje";
				$cadena_sql .= "   FROM docencia.evaluador_capitulos ";
				$cadena_sql .= "WHERE id_capitulo='" . $variable . "';";
				
				break;
			
			case "consultarCapituloModificar" :
				$cadena_sql = "SELECT  id_docente, titulo_capitulo, titulo_libro, tipo_libro,";
				$cadena_sql .= "codigo_nunm, editorial, anio_libro, volumen, num_autor_cap, num_autor_cap_univ,";
				$cadena_sql .= "num_autor_libro, num_autor_libro_univ, num_evaluadores, numacta,";
				$cadena_sql .= "fechacta, numcaso, puntaje, detalledocencia ";
				$cadena_sql .= "  FROM docencia.capitulo_libros ";
				$cadena_sql .= "WHERE id_capitulo='" . $variable . "';";
				
				break;
			
			case "consultarEvaluadores" :
				$cadena_sql = "SELECT id_evaluador ";
				$cadena_sql .= "FROM docencia.evaluador_capitulos ";
				$cadena_sql .= "WHERE id_capitulo='" . $variable . "';";
				
				break;
			
			case "consultarCapitulo" :
				
				$cadena_sql = "SELECT DISTINCT  id_docente, titulo_capitulo, titulo_libro, docencia.tipo_libro.tipo_libro, ";
				$cadena_sql .= "codigo_nunm, editorial, anio_libro, volumen, num_autor_cap, num_autor_cap_univ, ";
				$cadena_sql .= "num_autor_libro, num_autor_libro_univ, num_evaluadores, numacta,fechacta, numcaso, puntaje, ";
				$cadena_sql .= " informacion_nombres, informacion_apellidos, id_capitulo ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= " JOIN docencia.capitulo_libros ON id_docente = dependencia_iddocente ";
				$cadena_sql .= " LEFT JOIN docencia.tipo_libro  ON id_tipo_libro = docencia.capitulo_libros.tipo_libro ";
				
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
				$cadena_sql .= "ORDER BY id_capitulo";
				break;
			
			// UPDATE docencia.capitulo_libros
			// SET id_capitulo=?, id_docente=?, titulo_capitulo=?, titulo_libro=?,
			// tipo_libro=?, codigo_nunm=?, editorial=?, anio_libro=?, volumen=?,
			// num_autor_cap=?, num_autor_cap_univ=?, num_autor_libro=?, num_autor_libro_univ=?,
			// num_evaluadores=?, numacta=?, fechacta=?, numcaso=?, puntaje=?
			// WHERE <condition>;
			
			case "actualizarCapitulo" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= "docencia.capitulo_libros ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "titulo_capitulo = '" . $variable [1] . "', ";
				$cadena_sql .= "titulo_libro = '" . $variable [2] . "', ";
				$cadena_sql .= "tipo_libro = '" . $variable [3] . "', ";
				$cadena_sql .= "codigo_nunm = '" . $variable [4] . "', ";
				$cadena_sql .= "editorial = '" . $variable [5] . "', ";
				$cadena_sql .= "anio_libro = '" . $variable [6] . "', ";
				$cadena_sql .= "volumen = '" . $variable [7] . "', ";
				$cadena_sql .= "num_autor_cap = '" . $variable [8] . "', ";
				$cadena_sql .= "num_autor_cap_univ = '" . $variable [9] . "', ";
				$cadena_sql .= "num_autor_libro = '" . $variable [10] . "', ";
				$cadena_sql .= "num_autor_libro_univ = '" . $variable [11] . "', ";
				$cadena_sql .= "num_evaluadores = '" . $variable [12] . "', ";
				$cadena_sql .= "numacta = '" . $variable [13] . "', ";
				$cadena_sql .= "fechacta = '" . $variable [14] . "', ";
				$cadena_sql .= "numcaso = '" . $variable [15] . "', ";
				$cadena_sql .= "puntaje = '" . $variable [16] . "', ";
				$cadena_sql .= "detalledocencia = '" . $variable [17] . "' ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_capitulo ='" . $variable [0] . "' ";
				
				break;
			
			// UPDATE docencia.evaluador_capitulos
			// SET id_evaluador=?, id_capitulo=?, nom_evaluador=?, enti_univer=?,
			// puntaje=?
			// WHERE <condition>;
			
			case "actualizarEvaluador" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= "docencia.evaluador_capitulos ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "nom_evaluador = '" . $variable [0] . "', ";
				$cadena_sql .= "enti_univer = '" . $variable [1] . "', ";
				$cadena_sql .= "puntaje = '" . $variable [2] . "'  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_capitulo ='" . $variable1 . "' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "id_evaluador ='" . $variable2 . "' ";
				
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
