<?php

namespace asignacionPuntajes\salariales\direccionTrabajosDeGrado;

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
				
			case "tipoTrabajoGrado" :
				$cadenaSql = "select";
				$cadenaSql .= " id_tipo_trabajogrado as id_tipo,";
				$cadenaSql .= "	nombre_tipo_trabajogrado as nombre_tipo";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_trabajogrado";
				$cadenaSql .= " WHERE id_tipo_trabajogrado != -1";
				break;
				
			case "categoriaTrabajoGrado" :
				$cadenaSql = "select";
				$cadenaSql .= " id_categoria_trabajogrado as id_categoria,";
				$cadenaSql .= "	nombre_categoria_trabajogrado as nombre_categoria";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.categoria_trabajogrado";
				$cadenaSql .= " WHERE id_categoria_trabajogrado != -1";
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
				$cadenaSql=" select dtg.id_direccion_trabajogrado as id_direccion, dtg.documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente, ";
				$cadenaSql.=" dtg.titulo_trabajogrado as titulo, ";
				$cadenaSql.=" ctg.nombre_categoria_trabajogrado as categoria,";
				$cadenaSql.=" ttg.nombre_tipo_trabajogrado as tipo, ";
				$cadenaSql.=" dtg.anno_direccion as anno,";
				$cadenaSql.=" dtg.numero_acta as numero_acta,";
				$cadenaSql.=" dtg.fecha_acta as fecha_acta,";
				$cadenaSql.=" dtg.puntaje as puntaje,";
				$cadenaSql.=" dtg.normatividad as normatividad";
				$cadenaSql.=" from ";
				$cadenaSql.=" docencia.direccion_trabajogrado dtg ";
				$cadenaSql.=" left join docencia.docente dc on dtg.documento_docente=dc.documento_docente ";
				$cadenaSql.=" left join docencia.docente_proyectocurricular dc_pc on dtg.documento_docente=dc_pc.documento_docente ";
				$cadenaSql.=" left join docencia.proyectocurricular pc on dc_pc.id_proyectocurricular=pc.id_proyectocurricular ";
				$cadenaSql.=" left join docencia.facultad fc on pc.id_facultad=fc.id_facultad ";
				$cadenaSql.=" left join docencia.categoria_trabajogrado ctg on dtg.id_categoria_trabajogrado = ctg.id_categoria_trabajogrado ";
				$cadenaSql.=" left join docencia.tipo_trabajogrado ttg on dtg.id_tipo_trabajogrado = ttg.id_tipo_trabajogrado ";
				$cadenaSql.=" where ";
				$cadenaSql.=" dtg.estado=true";
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
				$cadenaSql = "INSERT INTO docencia.direccion_trabajogrado( ";
				$cadenaSql .= "documento_docente, titulo_trabajogrado, anno_direccion, id_tipo_trabajogrado, ";
				$cadenaSql .= "id_categoria_trabajogrado, numero_autores, numero_acta, fecha_acta, caso_acta, puntaje, normatividad) ";
				$cadenaSql .= " VALUES (" . $variable ['id_docenteRegistrar'] . ",";
				$cadenaSql .= " '" . $variable ['tituloTrabajo'] . "',";
				$cadenaSql .= " '" . $variable ['anno'] . "',";
				$cadenaSql .= "'" . $variable ['tipoTrabajo'] . "',";
				$cadenaSql .= " '" . $variable ['categoriaTrabajo'] . "',";
				$cadenaSql .= " '" . $variable ['numeroAutores'] . "',";
				$cadenaSql .= " '" . $variable ['numeroActa'] . "',";
				$cadenaSql .= " '" . $variable ['fechaActa'] . "',";
				$cadenaSql .= "' " . $variable ['numeroCasoActa'] . "',";
				$cadenaSql .= "' " . $variable ['puntaje'] . "',";
				$cadenaSql .= " '" . $variable ['normatividad'] . "')";
				$cadenaSql .= " returning id_direccion_trabajogrado";
				break;
				
			case "registroEstudiantes" :
				$cadenaSql = "INSERT INTO docencia.direccion_trabajogrado_estudiante( ";
				$cadenaSql .= "id_direccion_trabajogrado, nombre_estudiante, codigo_estudiante) ";
				$cadenaSql .= " VALUES (" . $variable ['id_direccion_trabajogrado'] . ",";
				$cadenaSql .= " '" . $variable ['nombre_estudiante'] . "',";
				$cadenaSql .= " '" . $variable ['codigo_estudiante'] . "')";
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
				$cadenaSql.=" dtg.puntaje, ";
				$cadenaSql.=" dtg.normatividad ";
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
				$cadenaSql .= "puntaje = '" . $variable ['puntaje'] . "', ";
				$cadenaSql .= "normatividad = '" . $variable ['normatividad'] . "'";
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
