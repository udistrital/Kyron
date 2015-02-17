<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlestadoDocente extends sql {
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
		$idSesion = '123';
		
		switch ($tipo) {
			
			/**
			 * Clausulas específicas
			 */
			
			case "seleccionEstado" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "id_parametro_estado, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= " docencia.parametro_estado ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= " id_item_parametro_estado='1' ";
				break;
			
			case "seleccionEstadoComplementario" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "id_parametro_estado, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= " docencia.parametro_estado ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= " id_item_parametro_estado='2' ";
				break;
			
			case "seleccionfiltrado" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "id_itemparametro, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametro ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= " item_idparametro='5' ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "id_itemparametro ASC ; ";
				break;
			
			case "seleccioncategoria" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "id_itemparametro, ";
				$cadena_sql .= "item_nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametro ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= " item_idparametro='1' ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "id_itemparametro ASC ; ";
				break;
			
			case "seleccionfacultad" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "codigo_facultad, ";
				$cadena_sql .= "nombre_facultad ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= " docencia.facultades  ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "codigo_facultad ASC ; ";
				
				break;
			
			case "seleccionProyectoCurricular" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "codigo_proyecto, ";
				$cadena_sql .= "nombre_proyecto ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= " docencia.proyectocurricular   ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "codigo_proyecto ASC ; ";
				break;
			
			case "ConsultarNumIdentificacion" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= " informacion_numeroidentificacion, ";
				$cadena_sql .= " informacion_nombres||''|| informacion_apellidos as nombre ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= " docencia.docente_informacion  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "informacion_numeroidentificacion='" . $variable . "'";
				$cadena_sql .= "AND ";
				$cadena_sql .= "informacion_estadoregistro='TRUE';";
				
				break;
			
			case "ConsultarCategoria" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= " cd.categoria_iddocente, ";
				$cadena_sql .= " dc.informacion_nombres||''||dc.informacion_apellidos as nombre  ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= " docencia.categoria_docente cd ";
				$cadena_sql .= "INNER JOIN   ";
				$cadena_sql .= " docencia.docente_informacion dc on (cd.categoria_iddocente=dc.informacion_iddocente)  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "cd.categoria_estado='" . $variable . "'  ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "cd.categoria_estadoregistro='TRUE' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "dc.informacion_estadoregistro='TRUE' ";
				
				break;
			
			case "ConsultarFacultad" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= " cd.dependencia_iddocente, ";
				$cadena_sql .= "dc.informacion_nombres||''||dc.informacion_apellidos as nombre   ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.dependencia_docente cd  ";
				$cadena_sql .= "INNER JOIN   ";
				$cadena_sql .= "  docencia.docente_informacion dc on (cd.dependencia_iddocente=dc.informacion_iddocente)  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "dependencia_facultad='" . $variable . "'  ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "cd.dependencia_estadoregistro ='TRUE' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "dc.informacion_estadoregistro='TRUE' ";
				
				break;
			
			case "ConsultarProyectoCurricular" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= " cd.dependencia_iddocente, ";
				$cadena_sql .= "dc.informacion_nombres||''||dc.informacion_apellidos as nombre   ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.dependencia_docente cd  ";
				$cadena_sql .= "INNER JOIN   ";
				$cadena_sql .= "  docencia.docente_informacion dc on (cd.dependencia_iddocente=dc.informacion_iddocente)  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "dependencia_proyectocurricular='" . $variable . "'  ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "cd.dependencia_estadoregistro ='TRUE' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "dc.informacion_estadoregistro='TRUE' ";
				
				break;
			
			// ------------------------------------werwerwe------------------------------------
			case "ConsultarCategoriaFacultadProyecto" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= " cd.categoria_iddocente as id_docente, ";
				$cadena_sql .= " dc.informacion_nombres||''||dc.informacion_apellidos as nombre  ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= " docencia.categoria_docente cd ";
				$cadena_sql .= "INNER JOIN   ";
				$cadena_sql .= " docencia.docente_informacion dc on (cd.categoria_iddocente=dc.informacion_iddocente)  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "cd.categoria_estado='" . $variable . "'  ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "cd.categoria_estadoregistro='TRUE' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "dc.informacion_estadoregistro='TRUE' ";
				$cadena_sql .= "INTERSECT ";
				$cadena_sql .= "SELECT ";
				$cadena_sql .= " cd.dependencia_iddocente, ";
				$cadena_sql .= "dc.informacion_nombres||''||dc.informacion_apellidos as nombre   ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.dependencia_docente cd  ";
				$cadena_sql .= "INNER JOIN   ";
				$cadena_sql .= "  docencia.docente_informacion dc on (cd.dependencia_iddocente=dc.informacion_iddocente)  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "dependencia_facultad='" . $variable1 . "'  ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "cd.dependencia_estadoregistro ='TRUE' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "dc.informacion_estadoregistro='TRUE' ";
				$cadena_sql .= "INTERSECT ";
				$cadena_sql .= "SELECT ";
				$cadena_sql .= " cd.dependencia_iddocente, ";
				$cadena_sql .= "dc.informacion_nombres||''||dc.informacion_apellidos as nombre   ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.dependencia_docente cd  ";
				$cadena_sql .= "INNER JOIN   ";
				$cadena_sql .= "  docencia.docente_informacion dc on (cd.dependencia_iddocente=dc.informacion_iddocente)  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "dependencia_proyectocurricular='" . $variable2 . "'  ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "cd.dependencia_estadoregistro ='TRUE' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "dc.informacion_estadoregistro='TRUE' ";
				
				break;
			
			case "ConsultarCategoriaFacultad" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= " cd.categoria_iddocente as id_docente, ";
				$cadena_sql .= " dc.informacion_nombres||''||dc.informacion_apellidos as nombre  ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= " docencia.categoria_docente cd ";
				$cadena_sql .= "INNER JOIN   ";
				$cadena_sql .= " docencia.docente_informacion dc on (cd.categoria_iddocente=dc.informacion_iddocente)  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "cd.categoria_estado='" . $variable . "'  ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "cd.categoria_estadoregistro='TRUE' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "dc.informacion_estadoregistro='TRUE' ";
				$cadena_sql .= "INTERSECT ";
				$cadena_sql .= "SELECT ";
				$cadena_sql .= " cd.dependencia_iddocente, ";
				$cadena_sql .= "dc.informacion_nombres||''||dc.informacion_apellidos as nombre   ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.dependencia_docente cd  ";
				$cadena_sql .= "INNER JOIN   ";
				$cadena_sql .= "  docencia.docente_informacion dc on (cd.dependencia_iddocente=dc.informacion_iddocente)  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "dependencia_facultad='" . $variable1 . "'  ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "cd.dependencia_estadoregistro ='TRUE' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "dc.informacion_estadoregistro='TRUE' ";
				break;
			
			case "ConsultarCategoriaProyecto" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= " cd.categoria_iddocente as id_docente, ";
				$cadena_sql .= " dc.informacion_nombres||''||dc.informacion_apellidos as nombre  ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= " docencia.categoria_docente cd ";
				$cadena_sql .= "INNER JOIN   ";
				$cadena_sql .= " docencia.docente_informacion dc on (cd.categoria_iddocente=dc.informacion_iddocente)  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "cd.categoria_estado='" . $variable . "'  ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "cd.categoria_estadoregistro='TRUE' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "dc.informacion_estadoregistro='TRUE' ";
				$cadena_sql .= "INTERSECT ";
				$cadena_sql .= "SELECT ";
				$cadena_sql .= " cd.dependencia_iddocente, ";
				$cadena_sql .= "dc.informacion_nombres||''||dc.informacion_apellidos as nombre   ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.dependencia_docente cd  ";
				$cadena_sql .= "INNER JOIN   ";
				$cadena_sql .= "  docencia.docente_informacion dc on (cd.dependencia_iddocente=dc.informacion_iddocente)  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "dependencia_proyectocurricular='" . $variable2 . "'  ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "cd.dependencia_estadoregistro ='TRUE' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "dc.informacion_estadoregistro='TRUE' ";
				
				break;
			
			case "ConsultarFacultadProyecto" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= " cd.dependencia_iddocente as id_docente, ";
				$cadena_sql .= "dc.informacion_nombres||''||dc.informacion_apellidos as nombre   ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.dependencia_docente cd  ";
				$cadena_sql .= "INNER JOIN   ";
				$cadena_sql .= "  docencia.docente_informacion dc on (cd.dependencia_iddocente=dc.informacion_iddocente)  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "dependencia_facultad='" . $variable1 . "'  ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "cd.dependencia_estadoregistro ='TRUE' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "dc.informacion_estadoregistro='TRUE' ";
				$cadena_sql .= "INTERSECT ";
				$cadena_sql .= "SELECT ";
				$cadena_sql .= " cd.dependencia_iddocente, ";
				$cadena_sql .= "dc.informacion_nombres||''||dc.informacion_apellidos as nombre   ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.dependencia_docente cd  ";
				$cadena_sql .= "INNER JOIN   ";
				$cadena_sql .= "  docencia.docente_informacion dc on (cd.dependencia_iddocente=dc.informacion_iddocente)  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "dependencia_proyectocurricular='" . $variable2 . "'  ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "cd.dependencia_estadoregistro ='TRUE' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "dc.informacion_estadoregistro='TRUE' ";
				
				break;
			// -----------------------------------------------------------------------------------
			case "Consultar Estado Docente" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "estadodocente_estado  estado,  ";
				$cadena_sql .= "estadodocente_estadocomplementario estadocomplentario,  ";
				$cadena_sql .= "estadodocente_iddocumentosoporte  documentosoporte,  ";
				$cadena_sql .= "estadodocente_fechainicioestado fechainicio,  ";
				$cadena_sql .= "estadodocente_fechaterminacionestado fechaterminacion ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.docente_estado ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "estadodocente_iddocente='" . $variable . "' ";
				$cadena_sql .= "AND   ";
				$cadena_sql .= "estadodocente_estadoregistro='true' ";
				
				break;
			
			case "Consultar Nombre Docente" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= " informacion_nombres||' '||informacion_apellidos AS nombre  ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.docente_informacion ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "informacion_iddocente='" . $variable . "' ";
				$cadena_sql .= "AND   ";
				$cadena_sql .= "informacion_estadoregistro='true' ";
				
				break;
			
			case "Consultar Nombre Estado" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= " item_nombre  ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.parametro_estado ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_item_parametro_estado='1' ";
				$cadena_sql .= "AND   ";
				$cadena_sql .= "id_parametro_estado='" . $variable . "'";
				
				break;
			
			case "Consultar Nombre Estado Complementario" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= " item_nombre  ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.parametro_estado ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_item_parametro_estado='2' ";
				$cadena_sql .= "AND   ";
				$cadena_sql .= "id_parametro_estado='" . $variable . "'";
				
				break;
			
			case "Consultar Nombre Documento Soporte" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "documentosoporte_nombrearchivo  ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.documento_soporte_estado ";
				$cadena_sql .= "WHERE  ";
				$cadena_sql .= " id_documentosoporte='" . $variable . "'";
				
				break;
			
			case "Consultar Historico Docente" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "estadodocente_iddocentE,dc.informacion_nombres||''||dc.informacion_apellidos as nombre, ";
				$cadena_sql .= "es.item_nombre estado_docente, ";
				$cadena_sql .= "co.item_nombre estado_docente_com, ";
				$cadena_sql .= "doc.documentosoporte_nombrearchivo nombre_documento,  ";
				$cadena_sql .= "cd.estadodocente_fechainicioestado  fecha_inicio,   ";
				$cadena_sql .= "cd.estadodocente_fechaterminacionestado   fecha_terminacion,   ";
				$cadena_sql .= "  cd.estadodocente_fecharegistro fecha_registro_estado  ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.docente_estado cd  ";
				$cadena_sql .= "INNER JOIN  ";
				$cadena_sql .= "docencia.docente_informacion dc on (cd.estadodocente_iddocentE=dc.informacion_iddocente) ";
				$cadena_sql .= "INNER JOIN  ";
				$cadena_sql .= "docencia.parametro_estado es on (cd.estadodocente_estado=es.id_parametro_estado)  ";
				$cadena_sql .= "LEFT OUTER JOIN  ";
				$cadena_sql .= "docencia.parametro_estado co on (cd.estadodocente_estadocomplementario=co.id_parametro_estado)  ";
				$cadena_sql .= "LEFT OUTER JOIN  ";
				$cadena_sql .= "docencia.documento_soporte_estado doc on (cd.estadodocente_iddocumentosoporte=doc.id_documentosoporte)  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "estadodocente_iddocentE='" . $variable . "' ";
				$cadena_sql .= "AND  ";
				$cadena_sql .= "dc.informacion_estadoregistro='true' ";
				$cadena_sql .= "ORDER BY   ";
				$cadena_sql .= "cd.estadodocente_fecharegistro ASC ";
				
				break;
			
			case "Guardar Documento Soporte Estado" :
				
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= "docencia.documento_soporte_estado";
				$cadena_sql .= "( ";
				$cadena_sql .= "documentosoporte_nombrearchivo, ";
				$cadena_sql .= "documentosoporte_ruta, ";
				$cadena_sql .= "documentosoporte_formato, ";
				$cadena_sql .= "documentosoporte_autor ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable ['nombre'] . "', ";
				$cadena_sql .= "'" . $variable ['ruta'] . "', ";
				$cadena_sql .= "'" . $variable ['formato'] . "', ";
				$cadena_sql .= "'" . $variable ['Autor'] . "' ";
				$cadena_sql .= ") ";
				$cadena_sql .= "RETURNING id_documentosoporte as identificador ;";
				break;
			
			case "Actualizar Historico Estado" :
				
				$cadena_sql = "	UPDATE ";
				$cadena_sql .= "docencia.docente_estado ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "estadodocente_estadoregistro='false'  ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "estadodocente_iddocente='" . $variable . "' ";
				$cadena_sql .= "AND   ";
				$cadena_sql .= "estadodocente_estadoregistro='true'";
				break;
			
			case "GuardarEstadoDocente" :
				
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= "docencia.docente_estado";
				$cadena_sql .= "( ";
				$cadena_sql .= "estadodocente_estado, ";
				$cadena_sql .= "estadodocente_estadocomplementario, ";
				$cadena_sql .= "estadodocente_iddocumentosoporte, ";
				$cadena_sql .= "estadodocente_fechainicioestado, ";
				$cadena_sql .= "estadodocente_fechaterminacionestado, ";
				$cadena_sql .= "estadodocente_estadoregistro, ";
				$cadena_sql .= "estadodocente_fecharegistro, ";
				$cadena_sql .= "estadodocente_iddocente ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable ['EstadoDoc'] . "', ";
				$cadena_sql .= "'" . $variable ['EstadoComplementario'] . "', ";
				$cadena_sql .= "'" . $variable ['DocumentoSoporte'] . "', ";
				$cadena_sql .= "'" . $variable ['fechaInicio'] . "', ";
				$cadena_sql .= "'" . $variable ['fechaTerminacion'] . "', ";
				$cadena_sql .= "'" . $variable ['estadoRegistro'] . "', ";
				$cadena_sql .= "'" . $variable ['fechaRegistro'] . "', ";
				$cadena_sql .= "'" . $variable ['docente'] . "' ";
				$cadena_sql .= ") ";
				break;
			case "GuardarEstadoDocenteInactivo" :
				
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= "docencia.docente_estado";
				$cadena_sql .= "( ";
				$cadena_sql .= "estadodocente_estado, ";
				$cadena_sql .= "estadodocente_estadocomplementario, ";
				$cadena_sql .= "estadodocente_iddocumentosoporte, ";
				$cadena_sql .= "estadodocente_fechainicioestado, ";
				$cadena_sql .= "estadodocente_fechaterminacionestado, ";
				$cadena_sql .= "estadodocente_estadoregistro, ";
				$cadena_sql .= "estadodocente_fecharegistro, ";
				$cadena_sql .= "estadodocente_iddocente ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable ['EstadoDoc'] . "', ";
				$cadena_sql .= "null, ";
				$cadena_sql .= "null, ";
				$cadena_sql .= "null, ";
				$cadena_sql .= "null, ";
				$cadena_sql .= "'" . $variable ['estadoRegistro'] . "', ";
				$cadena_sql .= "'" . $variable ['fechaRegistro'] . "', ";
				$cadena_sql .= "'" . $variable ['docente'] . "' ";
				$cadena_sql .= ") ";
				break;
			
			case "Corregir  Documento Soporte Estado" :
				
				$cadena_sql = "UPDATE  ";
				$cadena_sql .= "docencia.documento_soporte_estado ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "documentosoporte_nombrearchivo='" . $variable . "' ";
				$cadena_sql .= "WHERE  ";
				$cadena_sql .= "id_documentosoporte='" . $variable1 . "';";
				break;
			
			case "Corregir Estado Docente" :
				
				$cadena_sql = "UPDATE  ";
				$cadena_sql .= "docencia.docente_estado ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "estadodocente_estado='" . $variable ['EstadoDoc'] . "', ";
				$cadena_sql .= "estadodocente_estadocomplementario='" . $variable ['EstadoComplementario'] . "', ";
				$cadena_sql .= "estadodocente_iddocumentosoporte='" . $variable ['DocumentoSoporte'] . "', ";
				$cadena_sql .= "estadodocente_fechainicioestado='" . $variable ['fechaInicio'] . "', ";
				$cadena_sql .= "estadodocente_fechaterminacionestado='" . $variable ['fechaTerminacion'] . "', ";
				$cadena_sql .= "estadodocente_fecharegistro='" . $variable ['fechaRegistro'] . "' ";
				$cadena_sql .= "WHERE  ";
				$cadena_sql .= "estadodocente_iddocente= '" . $variable ['docente'] . "' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "estadodocente_estadoregistro= 'TRUE' ";
				break;
			
			case "Corregir Estado Docente Inactivo" :
				
				$cadena_sql = "UPDATE  ";
				$cadena_sql .= "docencia.docente_estado ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "estadodocente_estado='" . $variable ['EstadoDoc'] . "', ";
				$cadena_sql .= "estadodocente_estadocomplementario=null, ";
				$cadena_sql .= "estadodocente_iddocumentosoporte=null, ";
				$cadena_sql .= "estadodocente_fechainicioestado=null, ";
				$cadena_sql .= "estadodocente_fechaterminacionestado=null, ";
				$cadena_sql .= "estadodocente_fecharegistro=null ";
				$cadena_sql .= "WHERE  ";
				$cadena_sql .= "estadodocente_iddocente= '" . $variable ['docente'] . "' ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "estadodocente_estadoregistro= 'TRUE' ";
				break;
			
			// ------------------------------------------------------------
			
			case "buscartipoidentificacion" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= "nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "idparametro = 1  ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "iditem_parametro ; ";
				break;
			
			case "buscargenero" :
				
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= "nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "idparametro=2 ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "iditem_parametro ; ";
				
				break;
			
			case "buscarpais" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= "nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "idparametro=3 ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "iditem_parametro ; ";
				
				break;
			
			case "buscarciudad" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= "nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "idparametro=4 ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "iditem_parametro ; ";
				
				break;
			
			case "buscardedicacion" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= "nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametro ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "idparametro_item=3 ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "iditem_parametro ; ";
				
				break;
			
			case "buscarfacultad" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= "nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametro ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "idparametro_item=2 ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "iditem_parametro ; ";
				
				break;
			
			case "buscarproyectoc" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= "nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametro ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "idparametro_item=4 ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "iditem_parametro ; ";
				
				break;
			
			case "categoriaActual" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= "nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametro ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "idparametro_item=1 ";
				$cadena_sql .= "ORDER BY  ";
				$cadena_sql .= "iditem_parametro ; ";
				
				break;
			
			case "CtipoIdentificacion" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= "nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "iditem_parametro='" . $variable . "'";
				break;
			
			case "Cgenero" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= "nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "iditem_parametro='" . $variable . "'";
				break;
			
			case "CpaisNacimiento" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= "nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "iditem_parametro='" . $variable . "'";
				break;
			
			case "CciudadNacimiento" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= "nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametropersonal ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "iditem_parametro='" . $variable . "'";
				break;
			
			case "Cdedicacion" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= " nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametro ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "iditem_parametro='" . $variable . "'";
				break;
			
			case "Cfacultad" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= " nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametro ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "iditem_parametro='" . $variable . "'";
				break;
			
			case "Cpcurricular" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= " nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametro ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "iditem_parametro='" . $variable . "'";
				break;
			
			case "Ccategoria" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "iditem_parametro, ";
				$cadena_sql .= " nombreitem ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.item_parametro ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "iditem_parametro='" . $variable . "'";
				break;
			
			case "guardarDocencia" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= "docencia.docente";
				$cadena_sql .= "( ";
				$cadena_sql .= "fechanacimiento, ";
				$cadena_sql .= "pais, ";
				$cadena_sql .= "ciudad, ";
				$cadena_sql .= "codigointerno ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable ['fechaNacimiento'] . "', ";
				$cadena_sql .= "'" . $variable ['paisNacimiento'] . "', ";
				$cadena_sql .= "'" . $variable ['ciudadNacimiento'] . "', ";
				$cadena_sql .= "'" . $variable ['codigoInterno'] . "' ";
				$cadena_sql .= ")";
				break;
			
			case "guardarDocencia" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= "docencia.docente";
				$cadena_sql .= "( ";
				$cadena_sql .= "fechanacimiento, ";
				$cadena_sql .= "pais, ";
				$cadena_sql .= "ciudad, ";
				$cadena_sql .= "codigointerno ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable ['fechaNacimiento'] . "', ";
				$cadena_sql .= "'" . $variable ['paisNacimiento'] . "', ";
				$cadena_sql .= "'" . $variable ['ciudadNacimiento'] . "', ";
				$cadena_sql .= "'" . $variable ['codigoInterno'] . "' ";
				$cadena_sql .= ")";
				break;
			
			case "guardarRegistro" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= "gestiondocencia_creardocente";
				$cadena_sql .= "( ";
				$cadena_sql .= "identificacion_docente, ";
				$cadena_sql .= "nombre_docente, ";
				$cadena_sql .= "apellido_docente, ";
				$cadena_sql .= "fechnac_docente, ";
				$cadena_sql .= "codigointerno_docente, ";
				$cadena_sql .= "fechingreso_docente, ";
				$cadena_sql .= "resonombramiento_docente, ";
				$cadena_sql .= "fechiniciopr_docente, ";
				$cadena_sql .= "dorpropuesta_docente,  ";
				$cadena_sql .= "docfinal_docente, ";
				$cadena_sql .= "docconcepto_docente,";
				$cadena_sql .= "corrinstitucional_docente,";
				$cadena_sql .= "corrpersonal_docente,";
				$cadena_sql .= "direccionresidencia_docente,";
				$cadena_sql .= "telefonofijo_docente,";
				$cadena_sql .= "telefonocel_docente,";
				$cadena_sql .= "telefonoadicional_docente,";
				$cadena_sql .= "numeroacta_docente,";
				$cadena_sql .= "fechacta_docente,";
				$cadena_sql .= "numerocaso_docente,";
				$cadena_sql .= "facultad_docente,";
				$cadena_sql .= "proyectocurricular_docente, ";
				$cadena_sql .= "tipodocumento_docente, ";
				$cadena_sql .= "genero_docente, ";
				$cadena_sql .= "paisnacimiento_docente, ";
				$cadena_sql .= "ciudadnacimiento_docente, ";
				$cadena_sql .= "dedicacion_docente, ";
				$cadena_sql .= "categoriaactual_docente ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				$cadena_sql .= "( ";
				$cadena_sql .= "'" . $variable ['numIdentificacion'] . "', ";
				$cadena_sql .= "'" . $variable ['nombres'] . "', ";
				$cadena_sql .= "'" . $variable ['apellidos'] . "', ";
				$cadena_sql .= "'" . $variable ['fechaNacimiento'] . "', ";
				$cadena_sql .= "'" . $variable ['codigoInterno'] . "', ";
				$cadena_sql .= "'" . $variable ['fechaIngreso'] . "', ";
				$cadena_sql .= "'" . $variable ['resolucionNombramiento'] . "', ";
				$cadena_sql .= "'" . $variable ['fechaInicioAño'] . "', ";
				$cadena_sql .= "'" . $variable ['documentoPrueba'] . "', ";
				$cadena_sql .= "'" . $variable ['documentoFinal'] . "', ";
				$cadena_sql .= "'" . $variable ['documentoConcepto'] . "', ";
				$cadena_sql .= "'" . $variable ['correoInstitucional'] . "', ";
				$cadena_sql .= "'" . $variable ['correoPersonal'] . "', ";
				$cadena_sql .= "'" . $variable ['direccionResidencia'] . "', ";
				$cadena_sql .= "'" . $variable ['telefonoFijo'] . "', ";
				$cadena_sql .= "'" . $variable ['telefonoCelular'] . "', ";
				$cadena_sql .= "'" . $variable ['telefonoadicional'] . "', ";
				$cadena_sql .= "'" . $variable ['numeroActa'] . "', ";
				$cadena_sql .= "'" . $variable ['fechaActa'] . "', ";
				$cadena_sql .= "'" . $variable ['numeroCaso'] . "', ";
				$cadena_sql .= "'" . $variable ['facultad'] . "', ";
				$cadena_sql .= "'" . $variable ['proyectoCurricular'] . "', ";
				$cadena_sql .= "'" . $variable ['tipoIdentificacion'] . "', ";
				$cadena_sql .= "'" . $variable ['genero'] . "', ";
				$cadena_sql .= "'" . $variable ['paisNacimiento'] . "', ";
				$cadena_sql .= "'" . $variable ['ciudadNacimiento'] . "', ";
				$cadena_sql .= "'" . $variable ['dedicacion'] . "', ";
				$cadena_sql .= "'" . $variable ['categoriaActual'] . "' ";
				$cadena_sql .= ")";
				break;
			
			case "actualizarRegistro" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= $prefijo . "conductor ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "`nombre` = '" . $variable ["nombre"] . "', ";
				$cadena_sql .= "`apellido` = '" . $variable ["apellido"] . "', ";
				$cadena_sql .= "`identificacion` = '" . $variable ["identificacion"] . "', ";
				$cadena_sql .= "`telefono` = '" . $variable ["telefono"] . "' ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "`idConductor` =" . $_REQUEST ["registro"] . " ";
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
