<?php

namespace asignacionPuntajes\salariales\indexacionRevistas;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class Sql extends \Sql {
	var $miConfigurador;
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
	}
	function getCadenaSql($tipo, $variable = "") {
		
		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		
		switch ($tipo) {
			
			/**
			 * Clausulas genéricas.
			 * se espera que estén en todos los formularios
			 * que utilicen esta plantilla
			 */
			case "iniciarTransaccion" :
				$cadenaSql = "START TRANSACTION";
				break;
			
			case "finalizarTransaccion" :
				$cadenaSql = "COMMIT";
				break;
			
			case "cancelarTransaccion" :
				$cadenaSql = "ROLLBACK";
				break;
			
			case "eliminarTemp" :
				
				$cadenaSql = "DELETE ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= $prefijo . "tempFormulario ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "id_sesion = '" . $variable . "' ";
				break;
			
			case "insertarTemp" :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= $prefijo . "tempFormulario ";
				$cadenaSql .= "( ";
				$cadenaSql .= "id_sesion, ";
				$cadenaSql .= "formulario, ";
				$cadenaSql .= "campo, ";
				$cadenaSql .= "valor, ";
				$cadenaSql .= "fecha ";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				
				foreach ( $_REQUEST as $clave => $valor ) {
					$cadenaSql .= "( ";
					$cadenaSql .= "'" . $idSesion . "', ";
					$cadenaSql .= "'" . $variable ['formulario'] . "', ";
					$cadenaSql .= "'" . $clave . "', ";
					$cadenaSql .= "'" . $valor . "', ";
					$cadenaSql .= "'" . $variable ['fecha'] . "' ";
					$cadenaSql .= "),";
				}
				
				$cadenaSql = substr ( $cadenaSql, 0, (strlen ( $cadenaSql ) - 1) );
				break;
			
			case "rescatarTemp" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "id_sesion, ";
				$cadenaSql .= "formulario, ";
				$cadenaSql .= "campo, ";
				$cadenaSql .= "valor, ";
				$cadenaSql .= "fecha ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= $prefijo . "tempFormulario ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "id_sesion='" . $idSesion . "'";
				break;
			
			/* Consultas del desarrollo */
			case "facultad" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_facultad,";
				$cadenaSql .= "	nombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.facultad";
				break;
				
			case "proyectoCurricular" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_proyectocurricular,";
				$cadenaSql .= "	nombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.proyectocurricular";
				$cadenaSql .= " WHERE estado=true";
				break;
				
			case "entidadCertificadora" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_universidad,";
				$cadenaSql .= "	nombre_universidad";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.universidad";
				$cadenaSql .= " WHERE estado=true";
				$cadenaSql .= " AND id_universidad != -1";
				break;
				
			case "editorial" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_editorial,";
				$cadenaSql .= "	nombre_editorial";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.editorial";
				$cadenaSql .= " WHERE estado=true";
				$cadenaSql .= " AND id_editorial != -1";
				break;
				
			case "tipo" :
				$cadenaSql = "select";
				$cadenaSql .= " id_tipo_tecnicaysoftware, nombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_tecnicaysoftware ORDER BY";
				$cadenaSql .= " nombre ASC";
				break;
				
			case "docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido AS value, ";
				$cadenaSql.=" documento_docente AS data ";
				$cadenaSql.=" FROM ";
				$cadenaSql.=" docencia.docente WHERE documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido ";
				$cadenaSql.=" LIKE '%" . $variable . "%' AND estado=true LIMIT 10;";
				break;
			
			case "consultarProduccion" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.documento_docente||' - '||dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" pts.nombre AS nombre_produccion,";
				$cadenaSql.=" ti.id_tipo_tecnicaysoftware AS id_tipo_libro,";
				$cadenaSql.=" ti.nombre AS nombre_tipo_libro,";
				$cadenaSql.=" pts.numero_certificado AS certificado_producto,";
				$cadenaSql.=" pts.anno_produccion AS anno_produccion,";
				$cadenaSql.=" pts.numero_acta AS numero_acta,";
				$cadenaSql.=" pts.fecha_acta AS fecha_acta,";
				$cadenaSql.=" pts.numero_caso AS numero_caso,";
				$cadenaSql.=" pts.puntaje AS puntaje,";
				$cadenaSql.=" pts.normatividad AS normatividad";
				$cadenaSql.=" FROM docencia.produccion_tecnicaysoftware AS pts";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente = pts.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.tipo_tecnicaysoftware AS ti ON ti.id_tipo_tecnicaysoftware = pts.id_tipo_tecnicaysoftware";
				$cadenaSql.=" WHERE pts.estado=true";
				$cadenaSql.=" AND dc.estado=true";
				$cadenaSql.=" AND pts.documento_docente = '".$variable ['documento_docente']."'";
				$cadenaSql.=" AND pts.numero_certificado = '".$variable ['numero_certificado']."'";
				break;
					
			case "consultarEvaluador" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" ept.documento_evaluador AS documento_evaluador,";
				$cadenaSql.=" ept.nombre AS nombre_evaluador,";
				$cadenaSql.=" ept.id_universidad AS id_entidad_certificadora,";
				$cadenaSql.=" un.nombre_universidad AS entidad_certificadora,";
				$cadenaSql.=" ept.puntaje AS puntaje,";
				$cadenaSql.=" ept.normatividad AS normatividad";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.evaluador_produccion_tecnicaysoftware AS ept";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS un ON un.id_universidad = ept.id_universidad";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" ept.estado=true";
				$cadenaSql.=" AND ept.documento_docente = '".$variable ['documento_docente']."'";
				$cadenaSql.=" AND ept.numero_certificado = '".$variable ['numero_certificado']."'";
				break;
				
			case "consultar" :			
				$cadenaSql=" SELECT";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.documento_docente||' - '||dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" pts.nombre AS nombre_produccion,";
				$cadenaSql.=" ti.nombre AS nombre_tipo_libro,";
				$cadenaSql.=" pts.numero_certificado AS numero_certificado,";
				$cadenaSql.=" pts.anno_produccion AS anno_produccion,";
				$cadenaSql.=" pts.numero_acta AS numero_acta,";
				$cadenaSql.=" pts.fecha_acta AS fecha_acta,";
				$cadenaSql.=" pts.numero_caso AS numero_caso,";
				$cadenaSql.=" pts.puntaje AS puntaje,";
				$cadenaSql.=" pts.normatividad AS normatividad";
				$cadenaSql.=" FROM docencia.produccion_tecnicaysoftware AS pts";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente = pts.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.tipo_tecnicaysoftware AS ti ON ti.id_tipo_tecnicaysoftware = pts.id_tipo_tecnicaysoftware";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON dc_pc.documento_docente=pts.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.proyectocurricular AS pc ON pc.id_proyectocurricular=dc_pc.id_proyectocurricular";
				$cadenaSql.=" LEFT JOIN docencia.facultad AS fc ON fc.id_facultad=pc.id_facultad";
				$cadenaSql.=" WHERE pts.estado=true";
				$cadenaSql.=" AND dc.estado=true";
				$cadenaSql.=" AND dc_pc.estado=true";
				$cadenaSql.=" AND pc.estado=true";				
				if ($variable ['documento_docente'] != '') {
					$cadenaSql .= " AND dc.documento_docente = '" . $variable ['documento_docente'] . "'";
				}
				if ($variable ['id_facultad'] != '') {
					$cadenaSql .= " AND fc.id_facultad = '" . $variable ['id_facultad'] . "'";
				}
				if ($variable ['id_proyectocurricular'] != '') {
					$cadenaSql .= " AND pc.id_proyectocurricular = '" . $variable ['id_proyectocurricular'] . "'";
				}
				break;
				
				
			case "insertar" :
				$cadenaSql='';
				for($i = 1; $i <= 3; $i++){
					$evaluadorExiste =  $variable ['documentoEvaluador'.$i] != '' &&
										$variable ['nombreEvaluador'.$i] != '' &&
										$variable ['entidadCertificadora'.$i] != '' &&
										$variable ['puntajeSugeridoEvaluador'.$i] != '';
					if($i == 1 && $evaluadorExiste){
						$cadenaSql=" with rows as (";
					}
					if($i == 1){
						$cadenaSql.=" INSERT INTO docencia.produccion_tecnicaysoftware (";
						$cadenaSql.=" documento_docente, ";
						$cadenaSql.=" nombre, ";
						$cadenaSql.=" id_tipo_tecnicaysoftware, ";
						$cadenaSql.=" numero_certificado, ";
						$cadenaSql.=" anno_produccion,";
						$cadenaSql.=" numero_acta,";
						$cadenaSql.=" fecha_acta, ";
						$cadenaSql.=" numero_caso, ";
						$cadenaSql.=" puntaje, ";
						$cadenaSql.=" normatividad ";
						$cadenaSql.=" )";
						$cadenaSql.=" VALUES (";
						$cadenaSql.=" '" . $variable ['id_docenteRegistrar'] . "',";
						$cadenaSql.=" '" . $variable ['nombre'] . "',";
						$cadenaSql.=" '" . $variable ['tipo'] . "',";
						$cadenaSql.=" '" . $variable ['numeroCertificado'] . "',";
						$cadenaSql.=" '" . $variable ['annoProduccion'] . "',";
						$cadenaSql.=" '" . $variable ['numeroActa'] . "',";
						$cadenaSql.=" '" . $variable ['fechaActa'] . "',";
						$cadenaSql.=" '" . $variable ['numeroCasoActa'] . "',";
						$cadenaSql.=" '" . $variable ['puntaje'] . "',";
						$cadenaSql.=" '" . $variable ['normatividad'] . "'";
						$cadenaSql.=" ) ";
					}
					if($i == 1 && $evaluadorExiste){
						$cadenaSql.=" returning documento_docente, numero_certificado";
						$cadenaSql.=" )";
						$cadenaSql.=" INSERT INTO docencia.evaluador_produccion_tecnicaysoftware (";
						$cadenaSql.=" documento_evaluador,";
						$cadenaSql.=" nombre,";
						$cadenaSql.=" numero_certificado,";
						$cadenaSql.=" documento_docente,";
						$cadenaSql.=" id_universidad,";
						$cadenaSql.=" puntaje";
						$cadenaSql.=" )";
						$cadenaSql.=" VALUES ";
					}
					if($evaluadorExiste){
						$cadenaSql.=" (";
						$cadenaSql.=" '" . $variable ['documentoEvaluador'.$i] . "',";
						$cadenaSql.=" '" . $variable ['nombreEvaluador'.$i] . "',";
						$cadenaSql.=" (SELECT numero_certificado FROM rows),";
						$cadenaSql.=" (SELECT documento_docente FROM rows),";
						$cadenaSql.=" '" . $variable ['entidadCertificadora'.$i] . "',";
						$cadenaSql.=" '" . $variable ['puntajeSugeridoEvaluador'.$i] . "'";
						$cadenaSql.=" ),";
					}
				}
				$cadenaSql = substr ($cadenaSql, 0, -1);
				$cadenaSql.=" ;";
				break;
				
			case "actualizarProduccion" :
				$cadenaSql=" UPDATE docencia.produccion_tecnicaysoftware";
				$cadenaSql.=" SET";
				$cadenaSql.=" documento_docente = '" . $variable ['id_docenteRegistrar'] . "',";
				$cadenaSql.=" nombre = '" . $variable ['nombre'] . "',";
				$cadenaSql.=" id_tipo_tecnicaysoftware = '" . $variable ['tipo'] . "',";
				$cadenaSql.=" numero_certificado = '" . $variable ['numeroCertificado'] . "',";
				$cadenaSql.=" anno_produccion = '" . $variable ['annoProduccion'] . "',";
				$cadenaSql.=" numero_acta = '" . $variable ['numeroActa'] . "',";
				$cadenaSql.=" fecha_acta = '" . $variable ['fechaActa'] . "', ";
				$cadenaSql.=" numero_caso = '" . $variable ['numeroCasoActa'] . "', ";
				$cadenaSql.=" puntaje = '" . $variable ['puntaje'] . "', ";
				$cadenaSql.=" normatividad = '" . $variable ['normatividad'] . "'";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" documento_docente = '" . $variable ['old_id_docenteRegistrar'] . "'";
				$cadenaSql.=" AND numero_certificado = '" . $variable ['old_numero_certificado'] . "'";
				$cadenaSql.=" ;";
				break;
				
			case "insertarEvaluador" :
				$cadenaSql=" INSERT INTO docencia.evaluador_produccion_tecnicaysoftware (";
				$cadenaSql.=" documento_evaluador,";
				$cadenaSql.=" nombre,";
				$cadenaSql.=" numero_certificado,";
				$cadenaSql.=" documento_docente,";
				$cadenaSql.=" id_universidad,";
				$cadenaSql.=" puntaje";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES (";
				$cadenaSql.=" '" . $variable ['documento_evaluador'] . "',";
				$cadenaSql.=" '" . $variable ['nombre'] . "',";
				$cadenaSql.=" '" . $variable ['numero_certificado'] . "',";
				$cadenaSql.=" '" . $variable ['documento_docente'] . "',";
				$cadenaSql.=" '" . $variable ['id_universidad'] . "',";
				$cadenaSql.=" '" . $variable ['puntaje'] . "',";
				$cadenaSql.=" '" . $variable ['normatividad'] . "'";
				$cadenaSql.=" );";
				break;
				
			case "actualizarEvaluador" :
				$cadenaSql=" UPDATE";
				$cadenaSql.=" docencia.evaluador_produccion_tecnicaysoftware";
				$cadenaSql.=" SET";
				$cadenaSql.=" documento_evaluador = '" . $variable ['documento_evaluador'] . "',";
				$cadenaSql.=" nombre = '" . $variable ['nombre'] . "',";
				$cadenaSql.=" numero_certificado = '" . $variable ['numero_certificado'] . "',";
				$cadenaSql.=" documento_docente = '" . $variable ['documento_docente'] . "',";
				$cadenaSql.=" id_universidad = '" . $variable ['id_universidad'] . "',";
				$cadenaSql.=" puntaje = '" . $variable ['puntaje'] . "',";
				$cadenaSql.=" normatividad = '" . $variable ['normatividad'] . "'";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" documento_evaluador = '" . $variable ['old_documento_evaluador'] . "'";
				$cadenaSql.=" AND numero_certificado = '" . $variable ['old_numero_certificado'] . "'";
				$cadenaSql.=" AND documento_docente = '" . $variable ['old_documento_docente'] . "'";
				$cadenaSql.=" ;";
				break;
		}
		
		return $cadenaSql;
	}
}

?>
