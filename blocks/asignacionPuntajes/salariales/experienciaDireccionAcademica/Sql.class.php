<?php

namespace asignacionPuntajes\salariales\experienciaDireccionAcademica;

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
				$cadenaSql=" select ";
				$cadenaSql.=" eda.id_experiencia_direccion_academica as id_experiencia, ";
				$cadenaSql.=" eda.documento_docente, ";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente, ";
				$cadenaSql.=" un.nombre_universidad as entidad,";
				$cadenaSql.=" te.nombre_tipo_entidad,";
				$cadenaSql.=" eda.otra_entidad,";
				$cadenaSql.=" eda.horas_semana,";
				$cadenaSql.=" eda.fecha_inicio,";
				$cadenaSql.=" eda.fecha_finalizacion,";
				$cadenaSql.=" eda.dias_experiencia,";
				$cadenaSql.=" eda.numero_acta,";
				$cadenaSql.=" eda.fecha_acta,";
				$cadenaSql.=" eda.caso_acta,";
				$cadenaSql.=" eda.puntaje as puntaje ";
				$cadenaSql.=" from ";
				$cadenaSql.=" docencia.experiencia_direccion_academica eda ";
				$cadenaSql.=" left join docencia.docente dc on eda.documento_docente=dc.documento_docente ";
				$cadenaSql.=" left join docencia.docente_proyectocurricular dc_pc on eda.documento_docente=dc_pc.documento_docente ";
				$cadenaSql.=" left join docencia.proyectocurricular pc on dc_pc.id_proyectocurricular=pc.id_proyectocurricular ";
				$cadenaSql.=" left join docencia.facultad fc on pc.id_facultad=fc.id_facultad ";
				$cadenaSql.=" left join docencia.universidad un on un.id_universidad = eda.id_universidad ";
				$cadenaSql.=" left join docencia.tipo_entidad te on eda.id_tipo_entidad = te.id_tipo_entidad";
				$cadenaSql.=" where ";
				$cadenaSql.=" eda.estado=true ";
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
				$cadenaSql = "INSERT INTO docencia.experiencia_direccion_academica( ";
				$cadenaSql .= "documento_docente, id_universidad, otra_entidad, id_tipo_entidad, ";
				$cadenaSql .= "horas_semana, fecha_inicio, fecha_finalizacion, dias_experiencia, numero_acta, fecha_acta, caso_acta, puntaje) ";
				$cadenaSql .= " VALUES (" . $variable ['id_docenteRegistrar'] . ",";
				$cadenaSql .= " " . $variable ['entidadInstitucion'] . ",";
				$cadenaSql .= " '" . $variable ['otraEntidad'] . "',";
				$cadenaSql .= "'" . $variable ['tipoEntidad'] . "',";
				$cadenaSql .= " '" . $variable ['horasPorSemana'] . "',";
				$cadenaSql .= " '" . $variable ['fechaInicio'] . "',";
				$cadenaSql .= " '" . $variable ['fechaFinalizacion'] . "',";
				$cadenaSql .= " '" . $variable ['duracionExperiencia'] . "',";
				$cadenaSql .= " '" . $variable ['numeroActa'] . "',";
				$cadenaSql .= " '" . $variable ['fechaActa'] . "',";
				$cadenaSql .= "' " . $variable ['numeroCasoActa'] . "',";
				$cadenaSql .= " '" . $variable ['puntaje'] . "')";
				break;				
				
			case "publicacionActualizar" :
				$cadenaSql=" SELECT eda.id_experiencia_direccion_academica, eda.documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente,";
				$cadenaSql.=" eda.id_universidad, ";
				$cadenaSql.=" eda.otra_entidad, ";
				$cadenaSql.=" eda.id_tipo_entidad, ";
				$cadenaSql.=" eda.horas_semana, ";
				$cadenaSql.=" eda.fecha_inicio, ";
				$cadenaSql.=" eda.fecha_finalizacion, ";
				$cadenaSql.=" eda.dias_experiencia, ";
				$cadenaSql.=" eda.numero_acta, ";
				$cadenaSql.=" eda.fecha_acta, ";
				$cadenaSql.=" eda.caso_acta, ";
				$cadenaSql.=" eda.puntaje ";
				$cadenaSql.=" FROM docencia.experiencia_direccion_academica as eda ";
				$cadenaSql.=" left join docencia.docente dc on eda.documento_docente=dc.documento_docente ";
				$cadenaSql.=" WHERE eda.documento_docente ='" . $variable['documento_docente']. "'";
				$cadenaSql.=" and eda.id_experiencia_direccion_academica ='" . $variable['identificadorExperiencia']. "'";
				break;
				
			case "actualizar" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "docencia.experiencia_direccion_academica ";
				$cadenaSql .= "SET ";
				$cadenaSql .= "id_universidad = " . $variable ['entidadInstitucion'] . ", ";
				$cadenaSql .= "otra_entidad = '" . $variable ['otraEntidad'] . "', ";
				$cadenaSql .= "id_tipo_entidad = '" . $variable ['tipoEntidad'] . "', ";
				$cadenaSql .= "horas_semana = '" . $variable ['horasPorSemana'] . "', ";
				$cadenaSql .= "fecha_inicio = '" . $variable ['fechaInicio'] . "', ";
				$cadenaSql .= "fecha_finalizacion = '" . $variable ['fechaFinalizacion'] . "', ";
				$cadenaSql .= "dias_experiencia = '" . $variable ['duracionExperiencia'] . "', ";
				$cadenaSql .= "numero_acta = '" . $variable ['numeroActa'] . "', ";
				$cadenaSql .= "fecha_acta = '" . $variable ['fechaActa'] . "', ";
				$cadenaSql .= "caso_acta = '" . $variable ['numeroCasoActa'] . "', ";
				$cadenaSql .= "puntaje = '" . $variable ['puntaje'] . "' ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "documento_docente ='" . $variable ['id_docenteRegistrar'] . "' ";
				$cadenaSql .= "and id_experiencia_direccion_academica ='" . $variable ['identificadorExperiencia'] . "' ";
				$cadenaSql .= "and estado=true";
				break;
				
		}
		
		return $cadenaSql;
	}
}

?>
