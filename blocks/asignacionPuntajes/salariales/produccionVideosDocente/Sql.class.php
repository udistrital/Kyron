<?php

namespace asignacionPuntajes\salariales\produccionVideosDocente;

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
				
			case "tipoTrabajoGrado" :
				$cadenaSql = "select";
				$cadenaSql .= " id_tipo_trabajogrado as id_tipo,";
				$cadenaSql .= "	nombre_tipo_trabajogrado as nombre_tipo";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_trabajogrado";
				break;
				
			case "categoriaTrabajoGrado" :
				$cadenaSql = "select";
				$cadenaSql .= " id_categoria_trabajogrado as id_categoria,";
				$cadenaSql .= "	nombre_categoria_trabajogrado as nombre_categoria";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.categoria_trabajogrado";
				break;
				
			case "docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido AS value, ";
				$cadenaSql.=" documento_docente AS data ";
				$cadenaSql.=" FROM ";
				$cadenaSql.=" docencia.docente WHERE documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido ";
				$cadenaSql.=" LIKE '%" . $variable . "%' LIMIT 10;";
				break;
						
			case "contexto" :
				$cadenaSql = "select";
				$cadenaSql .= " id_contexto,";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.contexto";
				break;
				
			case "caracter" :
				$cadenaSql = "select";
				$cadenaSql .= " id_caracter_video,";
				$cadenaSql .= "	caracter_video";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.caracter_video";
				break;
					
			case "universidad_evaluador" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_universidad,";
				$cadenaSql .= "	nombre_universidad";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.universidad";
				break;
					
			case "consultar" :			
				$cadenaSql=" select pv.id_produccion_video, pv.documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente, ";
				$cadenaSql.=" pv.titulo_video, ";
				$cadenaSql.=" pv.fecha_realizacion,";
				$cadenaSql.=" ct.descripcion AS impacto, ";
				$cadenaSql.=" pv.numero_acta,";
				$cadenaSql.=" pv.fecha_acta,";
				$cadenaSql.=" pv.caso_acta,";
				$cadenaSql.=" pv.puntaje";
				$cadenaSql.=" from ";
				$cadenaSql.=" docencia.produccion_video AS pv ";
				$cadenaSql.=" left join docencia.docente dc on pv.documento_docente=dc.documento_docente ";
				$cadenaSql.=" left join docencia.docente_proyectocurricular dc_pc on pv.documento_docente=dc_pc.documento_docente ";
				$cadenaSql.=" left join docencia.proyectocurricular pc on dc_pc.id_proyectocurricular=pc.id_proyectocurricular ";
				$cadenaSql.=" left join docencia.facultad fc on pc.id_facultad=fc.id_facultad ";
				$cadenaSql.=" left join docencia.contexto ct on ct.id_contexto = pv.id_contexto ";
				$cadenaSql.=" where ";
				$cadenaSql.=" pv.estado=true";
				$cadenaSql.=" and dc.estado=true";
				$cadenaSql.=" and pc.estado=true";
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
				$cadenaSql = "INSERT INTO docencia.produccion_video( ";
				$cadenaSql .= "documento_docente, titulo_video, numero_autores, numero_autores_ud, ";
				$cadenaSql .= "fecha_realizacion, id_contexto, id_caracter_video, numero_evaluadores, numero_acta, fecha_acta, caso_acta, puntaje) ";
				$cadenaSql .= " VALUES (" . $variable ['id_docenteRegistrar'] . ",";
				$cadenaSql .= " '" . $variable ['tituloVideo'] . "',";
				$cadenaSql .= " '" . $variable ['numeroAutores'] . "',";
				$cadenaSql .= "'" . $variable ['numeroAutoresUd'] . "',";
				$cadenaSql .= " '" . $variable ['fechaRealizacion'] . "',";
				$cadenaSql .= " '" . $variable ['impacto'] . "',";
				$cadenaSql .= " '" . $variable ['caracter'] . "',";
				$cadenaSql .= " '" . $variable ['numeroAutores'] . "',";
				$cadenaSql .= " '" . $variable ['numeroActa'] . "',";
				$cadenaSql .= " '" . $variable ['fechaActa'] . "',";
				$cadenaSql .= "' " . $variable ['numeroCasoActa'] . "',";
				$cadenaSql .= " '" . $variable ['puntaje'] . "')";
				$cadenaSql .= " returning id_produccion_video";
				break;
				
			case "registroEstudiantes" :
				$cadenaSql = "INSERT INTO docencia.evaluador_produccion_video( ";
				$cadenaSql .= "id_produccion_video, nombre_evaluador, id_universidad, puntaje) ";
				$cadenaSql .= " VALUES (" . $variable ['id_produccion_video'] . ",";
				$cadenaSql .= " '" . $variable ['nombreEvaluador'] . "',";
				$cadenaSql .= " '" . $variable ['UniversidadEvaluador'] . "',";
				$cadenaSql .= " '" . $variable ['puntajeEvaluador'] . "')";
				break;
				
			case "publicacionActualizar" :
				$cadenaSql=" SELECT dtg.id_direccion_trabajogrado, dtg.documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente,";
				$cadenaSql.=" dtg.id_tipo_trabajogrado, ";
				$cadenaSql.=" dtg.id_categoria_trabajogrado, ";
				$cadenaSql.=" dtg.titulo_trabajogrado, ";
				$cadenaSql.=" dtg.numero_autores, ";
				$cadenaSql.=" dtg.anno_direccion, ";
				$cadenaSql.=" dtg.numero_acta, ";
				$cadenaSql.=" dtg.fecha_acta, ";
				$cadenaSql.=" dtg.caso_acta, ";
				$cadenaSql.=" dtg.puntaje ";
				$cadenaSql.=" FROM docencia.direccion_trabajogrado as dtg ";
				$cadenaSql.=" left join docencia.docente dc on dtg.documento_docente=dc.documento_docente ";
				$cadenaSql.=" WHERE dtg.documento_docente ='" . $variable['documento_docente']. "'";
				$cadenaSql.=" and dtg.id_direccion_trabajogrado ='" . $variable['identificadorDireccion']. "'";
				break;
				
			case "publicacionEstudiantesActualizar" :
				$cadenaSql=" select nombre_estudiante, ";
				$cadenaSql.=" codigo_estudiante ";
				$cadenaSql.=" from docencia.direccion_trabajogrado_estudiante ";
				$cadenaSql.=" where ";
				$cadenaSql.=" id_direccion_trabajogrado ="  . $variable;
				$cadenaSql.=" and estado = true";
				break;
				
			case "actualizar" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "docencia.direccion_trabajogrado ";
				$cadenaSql .= "SET ";
				$cadenaSql .= "id_tipo_trabajogrado = '" . $variable ['tipoTrabajo'] . "', ";
				$cadenaSql .= "id_categoria_trabajogrado = '" . $variable ['categoriaTrabajo'] . "', ";
				$cadenaSql .= "titulo_trabajogrado = '" . $variable ['tituloTrabajo'] . "', ";
				$cadenaSql .= "numero_autores = '" . $variable ['numeroAutores'] . "', ";
				$cadenaSql .= "anno_direccion = '" . $variable ['anno'] . "', ";
				$cadenaSql .= "numero_acta = '" . $variable ['numeroActa'] . "', ";
				$cadenaSql .= "fecha_acta = '" . $variable ['fechaActa'] . "', ";
				$cadenaSql .= "caso_acta = '" . $variable ['numeroCasoActa'] . "', ";
				$cadenaSql .= "puntaje = '" . $variable ['puntaje'] . "'";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "documento_docente ='" . $variable ['id_docenteRegistrar'] . "' ";
				$cadenaSql .= "and id_direccion_trabajogrado ='" . $variable ['id_direccion_trabajo'] . "' ";
				$cadenaSql .= "and estado=true";
				break;
				
			case "actualizarEstudiante" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "docencia.direccion_trabajogrado_estudiante ";
				$cadenaSql .= "SET ";
				$cadenaSql .= "nombre_estudiante ='" . $variable ['nombre_estudiante'] . "',";
				$cadenaSql .= "codigo_estudiante='" . $variable ['codigo_estudiante'] . "' ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "nombre_estudiante ='" . $variable ['old_nombre_estudiante'] . "' ";
				$cadenaSql .= "and codigo_estudiante='" . $variable ['old_codigo_estudiante'] . "' ";
				$cadenaSql .= "and id_direccion_trabajogrado ='" . $variable ['id_direccion_trabajogrado'] . "' ";
				break;
				
			case "actualizarEstudianteEliminar" ://cambiar estado a false
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "docencia.direccion_trabajogrado_estudiante ";
				$cadenaSql .= "SET ";
				$cadenaSql .= "estado =  false ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "nombre_estudiante ='" . $variable ['old_nombre_estudiante'] . "' ";
				$cadenaSql .= "and codigo_estudiante='" . $variable ['old_codigo_estudiante'] . "' ";
				$cadenaSql .= "and id_direccion_trabajogrado ='" . $variable ['id_direccion_trabajogrado'] . "' ";
				break;
		}
		
		return $cadenaSql;
	}
}

?>
