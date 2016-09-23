<?php

namespace hojaDeVida\titulosAcademicos;

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

			case "tipo_titulo_academico" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_tipo_titulo_academico,";
				$cadenaSql .= "	tipo";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_titulo_academico ORDER BY id_tipo_titulo_academico";
				break;
					
			case "entidadInstitucion" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_universidad,";
				$cadenaSql .= "	nombre_universidad";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.universidad";
				$cadenaSql .= " WHERE estado=true";
				break;
				
			case "pais" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " paiscodigo,";
				$cadenaSql .= "	paisnombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.pais";
				$cadenaSql .= " order by paisnombre";
				break;
			case "modalidad_titulo_academico" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_modalidad_titulo_academico,";
				$cadenaSql .= "	modalidad";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.modalidad_titulo_academico ORDER BY id_modalidad_titulo_academico";
				break;
				
			case "docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido AS value, ";
				$cadenaSql.=" documento_docente AS data ";
				$cadenaSql.=" FROM ";
				$cadenaSql.=" docencia.docente WHERE documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido ";
				$cadenaSql.=" LIKE '%" . $variable . "%' AND estado = true LIMIT 10;";
				break;
								
			case "consultar" :			
				$cadenaSql=" SELECT";
				$cadenaSql.=" ta.id_titulo_academico AS id_titulo_academico,";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" tta.tipo AS tipo,";
				$cadenaSql.=" ta.titulo AS titulo,";
				$cadenaSql.=" un.nombre_universidad AS universidad,";
				$cadenaSql.=" pa.paisnombre AS pais,";
				$cadenaSql.=" ta.anno AS anno,";
				$cadenaSql.=" mta.modalidad AS modalidad,";
				$cadenaSql.=" ta.resolucion AS resolucion,";
				$cadenaSql.=" ta.fecha_resolucion AS fecha_resolucion,";
				$cadenaSql.=" ta.entidad_convalidacion AS entidad_convalidacion,";
				$cadenaSql.=" ta.numero_acta AS numero_acta,";
				$cadenaSql.=" ta.fecha_acta AS fecha_acta,";
				$cadenaSql.=" ta.numero_caso AS numero_caso,";
				$cadenaSql.=" ta.puntaje AS puntaje";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.titulo_academico AS ta";
				$cadenaSql.=" LEFT JOIN docencia.tipo_titulo_academico AS tta ON tta.id_tipo_titulo_academico=ta.id_tipo_titulo_academico";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS un ON un.id_universidad=ta.id_universidad";
				$cadenaSql.=" LEFT JOIN docencia.pais AS pa ON pa.paiscodigo=ta.paiscodigo";
				$cadenaSql.=" LEFT JOIN docencia.modalidad_titulo_academico AS mta ON mta.id_modalidad_titulo_academico=ta.id_modalidad_titulo_academico";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente=ta.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON dc_pc.documento_docente=ta.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.proyectocurricular AS pc ON dc_pc.id_proyectocurricular=pc.id_proyectocurricular";
				$cadenaSql.=" LEFT JOIN docencia.facultad AS fc ON pc.id_facultad=fc.id_facultad";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" ta.estado=true";
				$cadenaSql.=" AND dc.estado=true";
				$cadenaSql.=" AND pc.estado=true";
				$cadenaSql.=" AND dc_pc.estado=true";
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
				
			case "registrar" :
				$cadenaSql=" INSERT INTO docencia.titulo_academico";
				$cadenaSql.=" (";
				$cadenaSql.=" documento_docente,";
				$cadenaSql.=" id_tipo_titulo_academico,";
				$cadenaSql.=" titulo,";
				$cadenaSql.=" id_universidad,";
				$cadenaSql.=" paiscodigo,";
				$cadenaSql.=" anno,";
				$cadenaSql.=" id_modalidad_titulo_academico,";
				$cadenaSql.=" resolucion,";
				$cadenaSql.=" fecha_resolucion,";
				$cadenaSql.=" entidad_convalidacion,";
				$cadenaSql.=" numero_acta,";
				$cadenaSql.=" fecha_acta,";
				$cadenaSql.=" numero_caso,";
				$cadenaSql.=" puntaje";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES";
				$cadenaSql.=" (";
				$cadenaSql.=" '" . $variable['id_docenteRegistrar']. "',";
				$cadenaSql.=" '" . $variable['tipo']. "',";
				$cadenaSql.=" '" . $variable['titulo']. "',";
				$cadenaSql.=" '" . $variable['entidad']. "',";
				$cadenaSql.=" '" . $variable['pais']. "',";
				$cadenaSql.=" '" . $variable['anno']. "',";
				$cadenaSql.=" '" . $variable['modalidad']. "',";
				$cadenaSql.=" '" . $variable['resolucion']. "',";
				$cadenaSql.=" '" . $variable['fechaResolucion']. "',";
				$cadenaSql.=" '" . $variable['entidadConvalidacion']. "',";
				$cadenaSql.=" '" . $variable['numeroActa']. "',";
				$cadenaSql.=" '" . $variable['fechaActa']. "',";
				$cadenaSql.=" '" . $variable['numeroCasoActa']. "',";
				$cadenaSql.=" '" . $variable['puntaje']. "'";
				$cadenaSql.=" );";
				break;
				
			case "consultaActualizar" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" ta.id_titulo_academico AS id_titulo_academico,";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" ta.id_tipo_titulo_academico AS id_tipo_titulo_academico,";
				$cadenaSql.=" tta.tipo AS tipo,";
				$cadenaSql.=" ta.titulo AS titulo,";
				$cadenaSql.=" ta.id_universidad AS id_universidad,";
				$cadenaSql.=" un.nombre_universidad AS universidad,";
				$cadenaSql.=" ta.paiscodigo AS paiscodigo,";
				$cadenaSql.=" pa.paisnombre AS pais,";
				$cadenaSql.=" ta.anno AS anno,";
				$cadenaSql.=" mta.id_modalidad_titulo_academico AS id_modalidad_titulo_academico,";
				$cadenaSql.=" mta.modalidad AS modalidad,";
				$cadenaSql.=" ta.resolucion AS resolucion,";
				$cadenaSql.=" ta.fecha_resolucion AS fecha_resolucion,";
				$cadenaSql.=" ta.entidad_convalidacion AS entidad_convalidacion,";
				$cadenaSql.=" ta.numero_acta AS numero_acta,";
				$cadenaSql.=" ta.fecha_acta AS fecha_acta,";
				$cadenaSql.=" ta.numero_caso AS numero_caso,";
				$cadenaSql.=" ta.puntaje AS puntaje";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.titulo_academico AS ta";
				$cadenaSql.=" LEFT JOIN docencia.tipo_titulo_academico AS tta ON tta.id_tipo_titulo_academico=ta.id_tipo_titulo_academico";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS un ON un.id_universidad=ta.id_universidad";
				$cadenaSql.=" LEFT JOIN docencia.pais AS pa ON pa.paiscodigo=ta.paiscodigo";
				$cadenaSql.=" LEFT JOIN docencia.modalidad_titulo_academico AS mta ON mta.id_modalidad_titulo_academico=ta.id_modalidad_titulo_academico";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente=ta.documento_docente";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" ta.estado=true";
				$cadenaSql.=" and ta.id_titulo_academico ='" . $variable['id_titulo_academico']. "'";
				break;
				
			case "actualizar" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "docencia.titulo_academico ";
				$cadenaSql .= "SET ";
				$cadenaSql.=" documento_docente='" . $variable ['id_docenteRegistrar'] . "',";
				$cadenaSql.=" id_tipo_titulo_academico='" . $variable ['tipo'] . "',";
				$cadenaSql.=" titulo='" . $variable ['titulo'] . "',";
				$cadenaSql.=" id_universidad='" . $variable ['entidad'] . "',";
				$cadenaSql.=" paiscodigo='" . $variable ['pais'] . "',";
				$cadenaSql.=" anno='" . $variable ['anno'] . "',";
				$cadenaSql.=" id_modalidad_titulo_academico='" . $variable ['modalidad'] . "',";
				$cadenaSql.=" resolucion='" . $variable ['resolucion'] . "',";
				$cadenaSql.=" fecha_resolucion='" . $variable ['fechaResolucion'] . "',";
				$cadenaSql.=" entidad_convalidacion='" . $variable ['entidadConvalidacion'] . "',";
				$cadenaSql.=" numero_acta='" . $variable ['numeroActa'] . "',";
				$cadenaSql.=" fecha_acta='" . $variable ['fechaActa'] . "',";
				$cadenaSql.=" numero_caso='" . $variable ['numeroCasoActa'] . "',";
				$cadenaSql.=" puntaje='" . $variable ['puntaje'] . "'";
				$cadenaSql .= " WHERE";
				$cadenaSql .= " id_titulo_academico ='" . $variable ['id_titulo_academico'] . "' ";
				$cadenaSql .= " AND estado=true ";
				break;
		}
		
		return $cadenaSql;
	}
}

?>
