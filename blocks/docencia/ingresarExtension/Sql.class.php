<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlingresarExtension extends sql {
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
			
			case "tipo_titulo" :
				
				$cadena_sql = "SELECT id_nivel, descripcion_nivel ";
				$cadena_sql .= "FROM docencia.nivel_formacion ";
				$cadena_sql .= "ORDER BY id_nivel";
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
			
			case "buscarNombreDocente" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "informacion_numeroidentificacion, ";
				$cadena_sql .= "UPPER(informacion_nombres)|| ' ' ||UPPER(informacion_apellidos) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.docente_informacion ";
				
				if (is_numeric ( $variable )) {
					$cadena_sql .= "WHERE ";
					$cadena_sql .= "informacion_numeroidentificacion like '%" . strtoupper ( trim ( $variable ) ) . "%' ";
				} else {
					$cadena_sql .= "WHERE ";
					$cadena_sql .= "UPPER(informacion_nombres) like '%" . strtoupper ( trim ( $variable ) ) . "%' ";
					$cadena_sql .= "OR ";
					$cadena_sql .= "UPPER(informacion_apellidos) like '%" . strtoupper ( trim ( $variable ) ) . "%' ";
				}
				$cadena_sql .= "AND ";
				$cadena_sql .= "informacion_estadoregistro = TRUE  ";
				
				break;       
				
			case "insertarExtension" :
				
				$cadena_sql = "INSERT INTO docencia.ingresar_extension( ";
				$cadena_sql .= "docente_extension, curso_extension, monto_extension, ";
				$cadena_sql .= "recibio_extension, inifecha_extension, finfecha_extension, duracion_extension, ";
				$cadena_sql .= "soporte_ruta, soporte_nombre) ";
				$cadena_sql .= " VALUES ('".$variable[0]."',";
				$cadena_sql .= " '".$variable[1]."',";
				$cadena_sql .= " ".$variable[2].",";
				$cadena_sql .= " '".$variable[3]."',";
				$cadena_sql .= " '".$variable[4]."',";
				$cadena_sql .= " '".$variable[5]."',";
				$cadena_sql .= " ".$variable[6].",";
				$cadena_sql .= " '".$variable[7]."',";
				$cadena_sql .= " '".$variable[8]."')";
				break;
				
			case "actualizarExtension" :
				
				$cadena_sql = "UPDATE docencia.ingresar_extension ";
				$cadena_sql .= " SET curso_extension = '".$variable[2]."', ";
				$cadena_sql .= " monto_extension = ".$variable[3].", ";
				$cadena_sql .= " recibio_extension = '".$variable[4]."', ";
				$cadena_sql .= " inifecha_extension = '".$variable[5]."', ";
				$cadena_sql .= " finfecha_extension = '".$variable[6]."', ";
				$cadena_sql .= " duracion_extension = ".$variable[7]." ";
                                
                                if($variable[8]!= '' && $variable[9] != '')
                                    {
                                        $cadena_sql .= ", soporte_ruta = '".$variable[8]."', ";
                                        $cadena_sql .= " soporte_nombre = '".$variable[9]."' ";
                                    }
                                    
                                $cadena_sql .= " WHERE id_extension = ".$variable[0];
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
			
			case "consultarExtension" :
								
				$cadena_sql = " SELECT DISTINCT id_extension, docente_extension, curso_extension, monto_extension, ";
				$cadena_sql .= " recibio_extension, inifecha_extension, finfecha_extension, ";
				$cadena_sql .= " duracion_extension, soporte_ruta, soporte_nombre, ";
				$cadena_sql .= " informacion_nombres, informacion_apellidos  ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= " JOIN docencia.ingresar_extension ON docente_extension = dependencia_iddocente ";
				$cadena_sql .= " WHERE 1=1";
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
                                
			case "consultarExtensionEsp" :
								
				$cadena_sql = " SELECT DISTINCT id_extension, docente_extension, curso_extension, monto_extension, ";
				$cadena_sql .= " recibio_extension, inifecha_extension, finfecha_extension, ";
				$cadena_sql .= " duracion_extension, soporte_ruta, soporte_nombre ";
				$cadena_sql .= " FROM docencia.ingresar_extension ";
				$cadena_sql .= " WHERE id_extension = ".$variable;
				
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
