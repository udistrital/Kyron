<?php

namespace asignacionPuntajes\salariales\experienciaCalificada;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar recefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case prececida por la palabra sql
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
				
			case "tipoExperiencia" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_tipo_experiencia_calificada,";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM";
				$cadenaSql .= " docencia.tipo_experiencia_calificada";
				$cadenaSql .= " WHERE  id_tipo_experiencia_calificada != -1";
				break;
				
			case "resolucionEmitidaPor" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_tipo_emisor_resolucion,";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_emisor_resolucion";
				$cadenaSql .= " WHERE  id_tipo_emisor_resolucion != -1";
				break;
				
			case "docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido AS value, ";
				$cadenaSql.=" documento_docente AS data ";
				$cadenaSql.=" FROM ";
				$cadenaSql.=" docencia.docente WHERE documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido ";
				$cadenaSql.=" LIKE '%" . $variable . "%' AND estado=true LIMIT 10;";
				break;
								
			case "consultar" :			
				$cadenaSql=" select ";
				$cadenaSql.=" ec.id_experiencia_calificada as id_experiencia, ";
				$cadenaSql.=" ec.documento_docente, ";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente, ";
				$cadenaSql.=" tec.descripcion as tipó_experiencia,";
				$cadenaSql.=" ec.numero_resolucion,";
				$cadenaSql.=" ter.descripcion emisor_resolucion,";
				$cadenaSql.=" ec.fecha_resolucion,";
				$cadenaSql.=" ec.numero_acta,";
				$cadenaSql.=" ec.fecha_acta,";
				$cadenaSql.=" ec.puntaje as puntaje ";
				$cadenaSql.=" from ";
				$cadenaSql.=" docencia.experiencia_calificada ec ";
				$cadenaSql.=" left join docencia.docente dc on ec.documento_docente=dc.documento_docente ";
				$cadenaSql.=" left join docencia.docente_proyectocurricular dc_pc on ec.documento_docente=dc_pc.documento_docente ";
				$cadenaSql.=" left join docencia.proyectocurricular pc on dc_pc.id_proyectocurricular=pc.id_proyectocurricular ";
				$cadenaSql.=" left join docencia.facultad fc on pc.id_facultad=fc.id_facultad ";
				$cadenaSql.=" left join docencia.tipo_experiencia_calificada tec on tec.id_tipo_experiencia_calificada = ec.id_tipo_experiencia_calificada ";
				$cadenaSql.=" left join docencia.tipo_emisor_resolucion ter on ter.id_tipo_emisor_resolucion = ec.id_tipo_emisor_resolucion ";
				$cadenaSql.=" where ";
				$cadenaSql.=" ec.estado=true ";
				$cadenaSql.=" and dc.estado=true ";
				$cadenaSql.=" and pc.estado=true ";
				$cadenaSql.=" and dc_pc.estado=true";
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
				$cadenaSql = "INSERT INTO docencia.experiencia_calificada( ";
				$cadenaSql .= "documento_docente, id_tipo_experiencia_calificada, numero_resolucion, ";
				$cadenaSql .= "id_tipo_emisor_resolucion, fecha_resolucion, numero_acta, fecha_acta, puntaje, normatividad) ";
				$cadenaSql .= " VALUES (" . $variable ['id_docenteRegistrar'] . ",";
				$cadenaSql .= " " . $variable ['tipoExperiencia'] . ",";
				$cadenaSql .= " '" . $variable ['numeroResolucion'] . "',";
				$cadenaSql .= "'" . $variable ['resolucionEmitidaPor'] . "',";
				$cadenaSql .= " '" . $variable ['annoResolucion'] . "',";
				$cadenaSql .= " '" . $variable ['numeroActa'] . "',";
				$cadenaSql .= " '" . $variable ['fechaActa'] . "',";
				$cadenaSql .= " '" . $variable ['puntaje'] . "',";
				$cadenaSql .= " '" . $variable ['normatividad'] . "')";
				break;				
				
			case "publicacionActualizar" :
				$cadenaSql=" SELECT ec.id_experiencia_calificada, ec.documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente,";
				$cadenaSql.=" ec.id_tipo_experiencia_calificada tipo_experiencia, ";
				$cadenaSql.=" ec.numero_resolucion, ";
				$cadenaSql.=" ec.id_tipo_emisor_resolucion emisor_resolucion, ";
				$cadenaSql.=" ec.fecha_resolucion, ";
				$cadenaSql.=" ec.numero_acta, ";
				$cadenaSql.=" ec.fecha_acta, ";
				$cadenaSql.=" ec.puntaje, ";
				$cadenaSql.=" ec.normatividad ";
				$cadenaSql.=" FROM docencia.experiencia_calificada as ec ";
				$cadenaSql.=" left join docencia.docente dc on ec.documento_docente=dc.documento_docente ";
				$cadenaSql.=" WHERE ec.documento_docente ='" . $variable['documento_docente']. "'";
				$cadenaSql.=" and ec.id_experiencia_calificada ='" . $variable['identificadorExperiencia']. "'";
				break;
				
			case "actualizar" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "docencia.experiencia_calificada ";
				$cadenaSql .= "SET ";
				$cadenaSql .= "id_tipo_experiencia_calificada = " . $variable ['tipoExperiencia'] . ", ";
				$cadenaSql .= "numero_resolucion = '" . $variable ['numeroResolucion'] . "', ";
				$cadenaSql .= "id_tipo_emisor_resolucion = '" . $variable ['resolucionEmitidaPor'] . "', ";
				$cadenaSql .= "fecha_resolucion = '" . $variable ['annoResolucion'] . "', ";
				$cadenaSql .= "numero_acta = '" . $variable ['numeroActa'] . "', ";
				$cadenaSql .= "fecha_acta = '" . $variable ['fechaActa'] . "', ";
				$cadenaSql .= "puntaje = '" . $variable ['puntaje'] . "', ";
				$cadenaSql .= "normatividad = '" . $variable ['normatividad'] . "' ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "documento_docente ='" . $variable ['id_docenteRegistrar'] . "' ";
				$cadenaSql .= "and id_experiencia_calificada ='" . $variable ['identificadorExperiencia'] . "' ";
				$cadenaSql .= "and estado=true";
				break;
				
		}
		
		return $cadenaSql;
	}
}

?>
