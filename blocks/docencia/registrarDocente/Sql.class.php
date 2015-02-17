<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlregistrarDocente extends sql {
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
				
				break;
                            
			case "tipoDocumento" :
				
				$cadena_sql = "SELECT id_tipo, nombre_tipo ";
				$cadena_sql .= "FROM docencia.tipo_identificacion ";
				$cadena_sql .= "WHERE estado = 'AC' ";
				$cadena_sql .= "ORDER BY nombre_tipo";
				break;
			
			case "consultarServicio" :
				
				$cadena_sql = "SELECT id_servicio, host, ruta ";
				$cadena_sql .= "FROM ". $prefijo . "servicios ";
				$cadena_sql .= "WHERE id_servicio = ".$variable;
				$cadena_sql .= "ORDER BY id_servicio";
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
			
                            
                        /**
			 * Clausulas específicas
			 */
			case "buscartipoidentificacion" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "item_id, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "item_idparametro = 1  ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "item_idparametro ; ";
				break;
			
			case "buscargenero" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "item_id, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "item_idparametro = 2  ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "item_idparametro ; ";
				break;
			
			case "buscarpais" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "item_id, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "item_idparametro = 3  ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "item_idparametro ; ";
				break;
			
			case "buscarciudad" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "item_id, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "item_idparametro = 4  ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "item_idparametro ; ";
				break;
			
			case "buscardedicacion" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "item_parametro, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametro ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "item_idparametro=3 ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "item_parametro ; ";
				
				break;
			
			case "buscarfacultad" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "codigo_facultad, ";
				$cadena_sql .= "nombre_facultad ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.facultades";
				
				break;
			
			case "buscarproyectoc" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "codigo_proyecto, ";
				$cadena_sql .= "nombre_proyecto ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.proyectocurricular ";
				break;
			
			case "buscarCategoria" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "item_parametro, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametro ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "item_idparametro=1 ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "item_parametro ; ";
				
				break;
			
			case "consultarIdentificacion" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "item_idparametro, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "item_id='" . $variable . "'";
				break;
			
			case "consultarGenero" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "item_idparametro, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "item_id='" . $variable . "'";
				break;
			
			case "consultarpaisNacimiento" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "item_idparametro, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "item_id='" . $variable . "'";
				break;
			
			case "consultarciudadNacimiento" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "item_idparametro, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "item_id='" . $variable . "'";
				break;
			
			case "consultarDedicacion" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "item_idparametro, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametro ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "item_parametro='" . $variable . "'";
				break;
				
			case "consultarFacultad" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "codigo_facultad,  ";
				$cadena_sql .= "nombre_facultad ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.facultades ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "codigo_facultad='" . $variable . "'";
				break;
		
				
			case "consultarProyecto" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "codigo_proyecto, ";
				$cadena_sql .= "nombre_proyecto ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.proyectocurricular ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "codigo_proyecto='" . $variable . "'";
				break;
			
			case "consultarCategoria" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "item_idparametro, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametro ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "item_parametro='" . $variable . "'";
				break;
			
                        case "consultaDocenteInformacion" : 
				$cadena_sql = "SELECT ";
				$cadena_sql .= "informacion_tipoidentificacion, ";
				$cadena_sql .= "informacion_numeroidentificacion  ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_tipoidentificacion = '".$variable[0]."'";
				$cadena_sql .= " AND informacion_numeroidentificacion = '".$variable[1]."'";
				
				break;    
			
			case "guardarDocenteInformacion" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= "docencia.docente_informacion";
				$cadena_sql .= "( ";
				$cadena_sql .= "informacion_tipoidentificacion, ";
				$cadena_sql .= "informacion_numeroidentificacion, ";
				$cadena_sql .= "informacion_nombres, ";
				$cadena_sql .= "informacion_apellidos, ";
				$cadena_sql .= "informacion_genero, ";
				$cadena_sql .= "informacion_estadoregistro, ";
				$cadena_sql .= "informacion_fechacambio ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable [0] . "', ";
				$cadena_sql .= "'" . $variable [1] . "', ";
				$cadena_sql .= "'" . $variable [2] . "', ";
				$cadena_sql .= "'" . $variable [3] . "', ";
				$cadena_sql .= "'" . $variable [4] . "', ";
				$cadena_sql .= "'" . $variable [5] . "', ";
				$cadena_sql .= "'" . $variable [6] . "' ";
				$cadena_sql .= ")";
				break;
			
			case "guardarDocenteInformacionInvariante" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= "docencia.docente_infoinvariante";
				$cadena_sql .= "( ";
				$cadena_sql .= "infoinvariante_pais, ";
				$cadena_sql .= "infoinvariante_ciudad, ";
				$cadena_sql .= "infoinvariante_codigointerno, ";
				$cadena_sql .= "infoinvariante_fechanacimiento, ";
				$cadena_sql .= "infoinvariante_iddocente ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable [0] . "', ";
				$cadena_sql .= "'" . $variable [1] . "', ";
				$cadena_sql .= "'" . $variable [2] . "', ";
				$cadena_sql .= "'" . $variable [3] . "', ";
				$cadena_sql .= "'" . $variable [4] . "' ";
				$cadena_sql .= ")";
				break;
			
						
			case "guardarVinculacionDocente" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= "docencia.vinculacion_docente";
				$cadena_sql .= "( ";
				$cadena_sql .= "vinculacion_iddocente, ";
				$cadena_sql .= "vinculacion_numeroresolucion, ";
				$cadena_sql .= "vinculacion_fechaingreso, ";
				$cadena_sql .= "vinculacion_dedicacion, ";
				$cadena_sql .= "documento_resolucion, ";
				$cadena_sql .= "documento_prueba, ";
				$cadena_sql .= "documento_final, ";
				$cadena_sql .= "documento_concepto ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable [0] . "', ";
				$cadena_sql .= "'" . $variable [1] . "', ";
				$cadena_sql .= "'" . $variable [2] . "', ";
				$cadena_sql .= "'" . $variable [3] . "', ";
				$cadena_sql .= "'" . $variable [4] . "', ";
				$cadena_sql .= "'" . $variable [5] . "', ";
				$cadena_sql .= "'" . $variable [6] . "', ";
				$cadena_sql .= "'" . $variable [7] . "' ";
				$cadena_sql .= ")";
				break;
					
			
			case "guardarDependenciaDocente" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= "docencia.dependencia_docente";
				$cadena_sql .= "( ";
				$cadena_sql .= "dependencia_iddocente, ";
				$cadena_sql .= "  dependencia_facultad, ";
				$cadena_sql .= "dependencia_proyectocurricular, ";
				$cadena_sql .= "dependencia_estadoregistro, ";
				$cadena_sql .= "dependencia_fecharegistro ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable [0] . "', ";
				$cadena_sql .= "'" . $variable [1] . "', ";
				$cadena_sql .= "'" . $variable [2] . "', ";
				$cadena_sql .= "'" . $variable [3] . "', ";
				$cadena_sql .= "'" . $variable [4] . "' ";
				$cadena_sql .= ")";
				break;
			
			case "guardarCategoriaDocente" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= "docencia.categoria_docente";
				$cadena_sql .= "( ";
				$cadena_sql .= " categoria_iddocente, ";
				$cadena_sql .= " categoria_estado, ";
				$cadena_sql .= "categoria_estadoregistro, ";
				$cadena_sql .= "categoria_fecharegistro ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable [0] . "', ";
				$cadena_sql .= "'" . $variable [1] . "', ";
				$cadena_sql .= "'" . $variable [2] . "', ";
				$cadena_sql .= "'" . $variable [3] . "' ";
				$cadena_sql .= ")";
				break;
			
			case "guardarInformacionDetalladaDocente" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= "docencia.docente_infodetalle";
				$cadena_sql .= "( ";
				$cadena_sql .= " docenteinf_iddocente, ";
				$cadena_sql .= " docenteinf_correoinstitucional, ";
				$cadena_sql .= "docenteinf_correopersonal,  ";
				$cadena_sql .= "docenteinf_direccionresidencia,  ";
				$cadena_sql .= "docenteinf_telefono,  ";
				$cadena_sql .= "docenteinf_telefonocelular,  ";
				$cadena_sql .= "docenteinf_telefonoadicional,  ";
				$cadena_sql .= "docenteinf_estadoregistro,  ";
				$cadena_sql .= "docenteinf_fecharegistro ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable [0] . "', ";
				$cadena_sql .= "'" . $variable [1] . "', ";
				$cadena_sql .= "'" . $variable [2] . "', ";
				$cadena_sql .= "'" . $variable [3] . "', ";
				$cadena_sql .= "'" . $variable [4] . "', ";
				$cadena_sql .= "'" . $variable [5] . "', ";
				$cadena_sql .= "'" . $variable [6] . "', ";
				$cadena_sql .= "'" . $variable [7] . "', ";
				$cadena_sql .= "'" . $variable [8] . "' ";
				$cadena_sql .= ")";
				break;
			
			case "guardarNombramientoDocente" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= " docencia.docente_nombramiento";
				$cadena_sql .= "( ";
				$cadena_sql .= "nombremiento_iddocente, ";
				$cadena_sql .= "nombremiento_numeroacta, ";
				$cadena_sql .= "nombremiento_fechaacta,  ";
				$cadena_sql .= "nombremiento_numerocaso";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable [0] . "', ";
				$cadena_sql .= "'" . $variable [1] . "', ";
				$cadena_sql .= "'" . $variable [2] . "', ";
				$cadena_sql .= "'" . $variable [3] . "' ";
				$cadena_sql .= ")";
				break;    
			
			case "guardarDocenteEstado" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= " docencia.docente_estado";
				$cadena_sql .= "( ";
				$cadena_sql .= "iddocente, ";
				$cadena_sql .= "estado, ";
				$cadena_sql .= "ruta_soporte, ";
				$cadena_sql .= "nombre_soporte, ";
				$cadena_sql .= "estadoregistro, ";
				$cadena_sql .= "fecharegistro";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable [0] . "', ";
				$cadena_sql .= "'" . $variable [1] . "', ";
				$cadena_sql .= "'" . $variable [2] . "', ";
				$cadena_sql .= "'" . $variable [3] . "', ";
				$cadena_sql .= "'" . $variable [4] . "', ";
				$cadena_sql .= "'" . $variable [5] . "' ";
				$cadena_sql .= ")";
				break;    
			case "consultarDocente" :
				
				$cadena_sql = "SELECT informacion_numeroidentificacion, ";
				$cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
				$cadena_sql .= "FROM docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
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
