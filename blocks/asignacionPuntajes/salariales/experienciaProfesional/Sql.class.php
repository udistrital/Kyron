<?php

namespace asignacionPuntajes\salariales\experienciaProfesional;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar repefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precepida por la palabra sql
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
				$cadenaSql .= " AND  id_universidad != -1";				
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
				$cadenaSql.=" LIKE '%" . $variable . "%' AND estado=true LIMIT 10;";
				break;
								
			case "consultar" :			
				$cadenaSql=" select ";
				$cadenaSql.=" ep.id_experiencia_profesional as id_experiencia, ";
				$cadenaSql.=" ep.documento_docente, ";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente, ";
				$cadenaSql.=" un.nombre_universidad as entidad,";
				$cadenaSql.=" ep.otra_entidad,";
				$cadenaSql.=" ep.cargo,";
				$cadenaSql.=" ep.fecha_inicio,";
				$cadenaSql.=" ep.fecha_finalizacion,";
				$cadenaSql.=" ep.dias_experiencia,";
				$cadenaSql.=" ep.numero_acta,";
				$cadenaSql.=" ep.fecha_acta,";
				$cadenaSql.=" ep.caso_acta,";
				$cadenaSql.=" ep.puntaje as puntaje ";
				$cadenaSql.=" from ";
				$cadenaSql.=" docencia.experiencia_profesional ep ";
				$cadenaSql.=" left join docencia.docente dc on ep.documento_docente=dc.documento_docente ";
				$cadenaSql.=" left join docencia.docente_proyectocurricular dc_pc on ep.documento_docente=dc_pc.documento_docente ";
				$cadenaSql.=" left join docencia.proyectocurricular pc on dc_pc.id_proyectocurricular=pc.id_proyectocurricular ";
				$cadenaSql.=" left join docencia.facultad fc on pc.id_facultad=fc.id_facultad ";
				$cadenaSql.=" left join docencia.universidad un on un.id_universidad = ep.id_universidad ";
				$cadenaSql.=" where ";
				$cadenaSql.=" ep.estado=true ";
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
				$cadenaSql = "INSERT INTO docencia.experiencia_profesional( ";
				$cadenaSql .= "documento_docente, id_universidad, otra_entidad, cargo, ";
				$cadenaSql .= "fecha_inicio, fecha_finalizacion, dias_experiencia, numero_acta, fecha_acta, caso_acta, puntaje, normatividad) ";
				$cadenaSql .= " VALUES (" . $variable ['id_docenteRegistrar'] . ",";
				$cadenaSql .= " " . $variable ['entidadInstitucion'] . ",";
				$cadenaSql .= " '" . $variable ['otraEntidad'] . "',";
				$cadenaSql .= "'" . $variable ['cargo'] . "',";
				$cadenaSql .= " '" . $variable ['fechaInicio'] . "',";
				$cadenaSql .= " '" . $variable ['fechaFinalizacion'] . "',";
				$cadenaSql .= " '" . $variable ['duracionExperiencia'] . "',";
				$cadenaSql .= " '" . $variable ['numeroActa'] . "',";
				$cadenaSql .= " '" . $variable ['fechaActa'] . "',";
				$cadenaSql .= "' " . $variable ['numeroCasoActa'] . "',";
				$cadenaSql .= "' " . $variable ['puntaje'] . "',";
				$cadenaSql .= " '" . $variable ['normatividad'] . "')";
				break;				
				
			case "publicacionActualizar" :
				$cadenaSql=" SELECT ep.id_experiencia_profesional, ep.documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente,";
				$cadenaSql.=" ep.id_universidad, ";
				$cadenaSql.=" ep.otra_entidad, ";
				$cadenaSql.=" ep.cargo, ";
				$cadenaSql.=" ep.fecha_inicio, ";
				$cadenaSql.=" ep.fecha_finalizacion, ";
				$cadenaSql.=" ep.dias_experiencia, ";
				$cadenaSql.=" ep.numero_acta, ";
				$cadenaSql.=" ep.fecha_acta, ";
				$cadenaSql.=" ep.caso_acta, ";
				$cadenaSql.=" ep.puntaje, ";
				$cadenaSql.=" ep.normatividad ";
				$cadenaSql.=" FROM docencia.experiencia_profesional as ep ";
				$cadenaSql.=" left join docencia.docente dc on ep.documento_docente=dc.documento_docente ";
				$cadenaSql.=" WHERE ep.documento_docente ='" . $variable['documento_docente']. "'";
				$cadenaSql.=" and ep.id_experiencia_profesional ='" . $variable['identificadorExperiencia']. "'";
				break;
				
			case "actualizar" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "docencia.experiencia_profesional ";
				$cadenaSql .= "SET ";
				$cadenaSql .= "id_universidad = " . $variable ['entidadInstitucion'] . ", ";
				$cadenaSql .= "otra_entidad = '" . $variable ['otraEntidad'] . "', ";
				$cadenaSql .= "cargo = '" . $variable ['cargo'] . "', ";
				$cadenaSql .= "fecha_inicio = '" . $variable ['fechaInicio'] . "', ";
				$cadenaSql .= "fecha_finalizacion = '" . $variable ['fechaFinalizacion'] . "', ";
				$cadenaSql .= "dias_experiencia = '" . $variable ['duracionExperiencia'] . "', ";
				$cadenaSql .= "numero_acta = '" . $variable ['numeroActa'] . "', ";
				$cadenaSql .= "fecha_acta = '" . $variable ['fechaActa'] . "', ";
				$cadenaSql .= "caso_acta = '" . $variable ['numeroCasoActa'] . "', ";
				$cadenaSql .= "puntaje = '" . $variable ['puntaje'] . "', ";
				$cadenaSql .= "normatividad = '" . $variable ['normatividad'] . "' ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "documento_docente ='" . $variable ['id_docenteRegistrar'] . "' ";
				$cadenaSql .= "and id_experiencia_profesional ='" . $variable ['identificadorExperiencia'] . "' ";
				$cadenaSql .= "and estado=true";
				break;
				
		}
		
		return $cadenaSql;
	}
}

?>
