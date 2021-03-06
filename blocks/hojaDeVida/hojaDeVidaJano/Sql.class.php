<?php

namespace hojaDeVida\hojaDeVidaJano;

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
				
			case "entidadInstitucion" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_universidad,";
				$cadenaSql .= "	nombre_universidad";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.universidad";
				$cadenaSql .= " WHERE estado=true";
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
				$cadenaSql.=" LIKE '%" . $variable . "%' AND estado = true LIMIT 10;";				
				break;
								
			case "consultar" :			
				$cadenaSql=" SELECT";
				$cadenaSql.=" cd.id AS id,";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" tcd.nombre AS tipo_categoria_docente,";
				$cadenaSql.=" mcd.nombre AS motivo_categoria_docente,";
				$cadenaSql.=" cd.nombre_produccion AS nombre_produccion,";
				$cadenaSql.=" cd.nombre_titulo AS nombre_titulo,";
				$cadenaSql.=" cd.numero_acta AS numero_acta,";
				$cadenaSql.=" cd.fecha_acta AS fecha_acta,";
				$cadenaSql.=" cd.numero_caso AS numero_caso,";
				$cadenaSql.=" cd.puntaje AS puntaje";
				//$cadenaSql.=" cc.normatividad AS normatividad";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.categoria_docente AS cd";
				$cadenaSql.=" LEFT JOIN docencia.tipo_categoria_docente AS tcd ON tcd.id=cd.tipo_categoria_docente";
				$cadenaSql.=" LEFT JOIN docencia.motivo_categoria_docente AS mcd ON mcd.id=cd.motivo_categoria_docente";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente=cd.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON dc.documento_docente=dc_pc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.proyectocurricular AS pc ON dc_pc.id_proyectocurricular=pc.id_proyectocurricular";
				$cadenaSql.=" LEFT JOIN docencia.facultad AS fc ON pc.id_facultad=fc.id_facultad";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" cd.estado=true";
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
				
			case "tipo_categoria_docente" :
				$cadenaSql = " SELECT";
				$cadenaSql .= " id,";
				$cadenaSql .= "	nombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_categoria_docente";
// 				$cadenaSql .= " WHERE";
// 				$cadenaSql .= " id =" . $variable;
				$cadenaSql .= " ORDER BY nombre ASC;";
				break;
				
			case "motivo_categoria_docente" :
				$cadenaSql = " SELECT";
				$cadenaSql .= " id,";
				$cadenaSql .= "	nombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.motivo_categoria_docente";
				// 				$cadenaSql .= " WHERE";
				// 				$cadenaSql .= " id =" . $variable;
				$cadenaSql .= " ORDER BY nombre ASC;";
				break;
				
			case "registrar" :
				$cadenaSql=" INSERT INTO docencia.categoria_docente";
				$cadenaSql.=" (";
				$cadenaSql.=" documento_docente,";
				$cadenaSql.=" tipo_categoria_docente,";
				$cadenaSql.=" motivo_categoria_docente,";
				$cadenaSql.=" nombre_produccion,";
				$cadenaSql.=" nombre_titulo,";
				$cadenaSql.=" numero_acta,";
				$cadenaSql.=" fecha_acta,";
				$cadenaSql.=" numero_caso,";
				$cadenaSql.=" puntaje";
// 				$cadenaSql.=" normatividad";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES";
				$cadenaSql.=" (";
				$cadenaSql.=" '" . $variable['id_docenteRegistrar']. "',";
				$cadenaSql.=" '" . $variable['tipoCategoria']. "',";
				$cadenaSql.=" '" . $variable['motivoCategoria']. "',";
				$cadenaSql.=" '" . $variable['nombreProduccion']. "',";
				$cadenaSql.=" '" . $variable['nombreTitulo']. "',";
				$cadenaSql.=" '" . $variable['numeroActa']. "',";
				$cadenaSql.=" '" . $variable['fechaActa']. "',";
				$cadenaSql.=" '" . $variable['numeroCasoActa']. "',";
				$cadenaSql.=" '" . $variable['puntaje']. "'";
// 				$cadenaSql.=" '" . $variable['normatividad']. "'";
				$cadenaSql.=" );";
				break;		
				
			case "consultaActualizar" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" cd.id AS id,";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" cd.tipo_categoria_docente AS tipo_categoria_docente,";
				$cadenaSql.=" tcd.nombre AS tipo,";
				$cadenaSql.=" cd.motivo_categoria_docente AS motivo_categoria_docente,";
				$cadenaSql.=" mcd.nombre AS motivo,";
				$cadenaSql.=" cd.nombre_produccion AS nombre_produccion,";
				$cadenaSql.=" cd.nombre_titulo AS nombre_titulo,";
				$cadenaSql.=" cd.numero_acta AS numero_acta,";
				$cadenaSql.=" cd.fecha_acta AS fecha_acta,";
				$cadenaSql.=" cd.numero_caso AS numero_caso,";
				$cadenaSql.=" cd.puntaje AS puntaje";
				//$cadenaSql.=" cd.normatividad AS normatividad";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.categoria_docente AS cd";
				$cadenaSql.=" LEFT JOIN docencia.tipo_categoria_docente AS tcd ON tcd.id=cd.tipo_categoria_docente";
				$cadenaSql.=" LEFT JOIN docencia.motivo_categoria_docente AS mcd ON mcd.id=cd.motivo_categoria_docente";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente=cd.documento_docente";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" cd.estado=true";
				$cadenaSql.=" AND dc.estado=true";
				$cadenaSql.=" AND cd.id ='" . $variable['id']. "'";
				$cadenaSql.=" ;";
				break;
				
			case "actualizar" :
				$cadenaSql=" UPDATE docencia.categoria_docente";
				$cadenaSql.=" SET";
				$cadenaSql.=" documento_docente='" . $variable['id_docenteRegistrar']. "',";
				$cadenaSql.=" tipo_categoria_docente='" . $variable['tipoCategoria']. "',";
				$cadenaSql.=" motivo_categoria_docente='" . $variable['motivoCategoria']. "',";
				$cadenaSql.=" nombre_produccion='" . $variable['nombreProduccion']. "',";
				$cadenaSql.=" nombre_titulo='" . $variable['nombreTitulo']. "',";
				$cadenaSql.=" numero_acta='" . $variable['numeroActa']. "',";
				$cadenaSql.=" fecha_acta='" . $variable['fechaActa']. "',";
				$cadenaSql.=" numero_caso='" . $variable['numeroCasoActa']. "',";
				$cadenaSql.=" puntaje='" . $variable['puntaje']. "'";
				//$cadenaSql.=" normatividad='" . $variable['normatividad']. "'";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" id='" . $variable ['id'] . "'";
				$cadenaSql.=" AND estado=true";
				$cadenaSql.=" ;";
				break;
				
		}
		
		return $cadenaSql;
	}
}

?>
