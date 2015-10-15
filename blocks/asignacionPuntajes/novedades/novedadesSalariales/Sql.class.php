<?php

namespace asignacionPuntajes\novedades\novedadesSalariales;

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
				break;
				
			case "entidadInstitucion" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_universidad,";
				$cadenaSql .= "	nombre_universidad";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.universidad";
				break;
				
			case "tipoEntidadInstitucion" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_tipo_entidad,";
				$cadenaSql .= "	nombre_tipo_entidad";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_entidad";
				break;
				
			case "docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido AS value, ";
				$cadenaSql.=" documento_docente AS data ";
				$cadenaSql.=" FROM ";
				$cadenaSql.=" docencia.docente WHERE documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido ";
				$cadenaSql.=" LIKE '%" . $variable . "%' LIMIT 10;";				
				break;
								
			case "consultar" :			
				$cadenaSql=" SELECT";
				$cadenaSql.=" no.id_novedad AS id_novedad,";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" no.descripcion AS descripcion,";
				$cadenaSql.=" no.id_tipo_novedad AS id_tipo_novedad,";
				$cadenaSql.=" tn.tipo_novedad AS tipo_novedad,";
				$cadenaSql.=" no.numero_acta AS numero_acta,";
				$cadenaSql.=" no.fecha_acta AS fecha_acta,";
				$cadenaSql.=" no.numero_caso AS numero_caso,";
				$cadenaSql.=" no.puntaje AS puntaje,";
				$cadenaSql.=" no.normatividad AS normatividad";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.novedad AS no";
				$cadenaSql.=" LEFT JOIN docencia.tipo_novedad AS tn ON tn.id_tipo_novedad=no.id_tipo_novedad";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente=no.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON dc.documento_docente=dc_pc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.proyectocurricular AS pc ON dc_pc.id_proyectocurricular=pc.id_proyectocurricular";
				$cadenaSql.=" LEFT JOIN docencia.facultad AS fc ON pc.id_facultad=fc.id_facultad";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" no.estado=true";
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
				$cadenaSql.=" ;";
				break;
				
			case "tipo_novedad" :
				$cadenaSql = "select";
				$cadenaSql .= " id_tipo_novedad,";
				$cadenaSql .= "	tipo_novedad";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_novedad";
				$cadenaSql .= " WHERE";
				$cadenaSql .= " id_categoria_novedad =" . $variable;
				$cadenaSql .= " order by tipo_novedad asc";
				break;
				
			case "registrar" :
				$cadenaSql=" INSERT INTO docencia.novedad";
				$cadenaSql.=" (";
				$cadenaSql.=" documento_docente,";
				$cadenaSql.=" descripcion,";
				$cadenaSql.=" id_tipo_novedad,";
				$cadenaSql.=" numero_acta,";
				$cadenaSql.=" fecha_acta,";
				$cadenaSql.=" numero_caso,";
				$cadenaSql.=" puntaje,";
				$cadenaSql.=" normatividad";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES";
				$cadenaSql.=" (";
				$cadenaSql.=" '" . $variable['id_docenteRegistrar']. "',";
				$cadenaSql.=" '" . $variable['descripcion']. "',";
				$cadenaSql.=" '" . $variable['tipo']. "',";
				$cadenaSql.=" '" . $variable['numeroActa']. "',";
				$cadenaSql.=" '" . $variable['fechaActa']. "',";
				$cadenaSql.=" '" . $variable['numeroCasoActa']. "',";
				$cadenaSql.=" '" . $variable['puntaje']. "',";
				$cadenaSql.=" '" . $variable['normatividad']. "'";
				$cadenaSql.=" );";
				break;		
				
			case "consultaActualizar" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" no.id_novedad AS id_novedad,";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" no.descripcion AS descripcion,";
				$cadenaSql.=" no.id_tipo_novedad AS id_tipo_novedad,";
				$cadenaSql.=" tn.tipo_novedad AS tipo_novedad,";
				$cadenaSql.=" no.numero_acta AS numero_acta,";
				$cadenaSql.=" no.fecha_acta AS fecha_acta,";
				$cadenaSql.=" no.numero_caso AS numero_caso,";
				$cadenaSql.=" no.puntaje AS puntaje,";
				$cadenaSql.=" no.normatividad AS normatividad";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.novedad AS no";
				$cadenaSql.=" LEFT JOIN docencia.tipo_novedad AS tn ON tn.id_tipo_novedad=no.id_tipo_novedad";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente=no.documento_docente";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" no.estado=true";
				$cadenaSql.=" AND dc.estado=true";
				$cadenaSql.=" AND no.id_novedad ='" . $variable['id_novedad']. "'";
				$cadenaSql.=" ;";
				break;
				
			case "actualizar" :
				$cadenaSql=" UPDATE docencia.novedad";
				$cadenaSql.=" SET";
				$cadenaSql.=" documento_docente='" . $variable['id_docenteRegistrar']. "',";
				$cadenaSql.=" descripcion='" . $variable['descripcion']. "',";
				$cadenaSql.=" id_tipo_novedad='" . $variable['tipo']. "',";
				$cadenaSql.=" numero_acta='" . $variable['numeroActa']. "',";
				$cadenaSql.=" fecha_acta='" . $variable['fechaActa']. "',";
				$cadenaSql.=" numero_caso='" . $variable['numeroCasoActa']. "',";
				$cadenaSql.=" puntaje='" . $variable['puntaje']. "',";
				$cadenaSql.=" normatividad='" . $variable['normatividad']. "'";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" id_novedad='" . $variable ['id_novedad'] . "'";
				$cadenaSql.=" AND estado=true";
				$cadenaSql.=" ;";
				break;
				
		}
		
		return $cadenaSql;
	}
}

?>
