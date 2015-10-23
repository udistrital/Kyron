<?php

namespace asignacionPuntajes\salariales\cartasEditor;

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
				
			case "pais" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " paiscodigo,";
				$cadenaSql .= "	paisnombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.pais";
				if($variable == 0){
					$cadenaSql .= " WHERE paiscodigo = 'COL'";
				}elseif ($variable == 1){
					$cadenaSql .= " WHERE paiscodigo != 'COL'";
				}
				$cadenaSql .= "order by paisnombre";
				break;
				
			case "categoria_revista" :
				$cadenaSql = "select";
				$cadenaSql .= " id_tipo_indexacion,";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_indexacion";
				$cadenaSql .= " WHERE";
				$cadenaSql .= " id_contexto =" . $variable;
				break;
				
			case "docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido AS value, ";
				$cadenaSql.=" documento_docente AS data ";
				$cadenaSql.=" FROM ";
				$cadenaSql.=" docencia.docente WHERE documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido ";
				$cadenaSql.=" LIKE '%" . $variable . "%' LIMIT 10";
				$cadenaSql.=" AND estado = true;";
				break;
								
			case "consultar" :			
				$cadenaSql=" SELECT";
				$cadenaSql.=" tr.id_traduccion_libro AS id_traduccion_libro,";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" tr.titulo AS titulo_traduccion,";
				$cadenaSql.=" tr.nombre_autor_original AS nombre_autor_original,";
				$cadenaSql.=" tr.volumen AS volumen_traduccion,";
				$cadenaSql.=" tr.anno_traduccion AS anno_traduccion,";
				$cadenaSql.=" tr.anno_publicacion AS anno_publicacion,";
				$cadenaSql.=" tr.numero_acta AS numero_acta,";
				$cadenaSql.=" tr.fecha_acta AS fecha_acta,";
				$cadenaSql.=" tr.numero_caso AS numero_caso,";
				$cadenaSql.=" tr.puntaje AS puntaje,";
				$cadenaSql.=" tr.normatividad AS normatividad";
				$cadenaSql.=" FROM docencia.traduccion_libro AS tr";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente = tr.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON tr.documento_docente=dc_pc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.proyectocurricular AS pc ON dc_pc.id_proyectocurricular=pc.id_proyectocurricular";
				$cadenaSql.=" LEFT JOIN docencia.facultad AS fc ON pc.id_facultad=fc.id_facultad";
				$cadenaSql.=" WHERE tr.estado=true";
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
				$cadenaSql.=" ;";
				break;
				
			case "registrar" :
				$cadenaSql=" INSERT INTO docencia.traduccion_libro(";
				$cadenaSql.=" documento_docente,";
				$cadenaSql.=" titulo,";
				$cadenaSql.=" nombre_autor_original,";
				$cadenaSql.=" volumen,";
				$cadenaSql.=" anno_traduccion,";
				$cadenaSql.=" anno_publicacion,";
				$cadenaSql.=" numero_acta,";
				$cadenaSql.=" fecha_acta,";
				$cadenaSql.=" numero_caso,";
				$cadenaSql.=" puntaje,";
				$cadenaSql.=" normatividad";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES(";
				$cadenaSql.=" '".$variable['id_docenteRegistrar']."',";
				$cadenaSql.=" '".$variable['nombre']."',";
				$cadenaSql.=" '".$variable['nombreAutorOriginal']."',";
				$cadenaSql.=" '".$variable['volumen']."',";
				$cadenaSql.=" '".$variable['annoTraduccion']."',";
				$cadenaSql.=" '".$variable['annoPublicacion']."',";
				$cadenaSql.=" '".$variable['numeroActa']."',";
				$cadenaSql.=" '".$variable['fechaActa']."',";
				$cadenaSql.=" '".$variable['numeroCasoActa']."',";
				$cadenaSql.=" '".$variable['puntaje']."',";
				$cadenaSql.=" '".$variable['normatividad']."'";
				$cadenaSql.=" );";
				break;
				
			case "consultaModificar" :			
				$cadenaSql=" SELECT";
				$cadenaSql.=" tr.id_traduccion_libro AS id_traduccion_libro,";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" tr.titulo AS titulo_traduccion,";
				$cadenaSql.=" tr.nombre_autor_original AS nombre_autor_original,";
				$cadenaSql.=" tr.volumen AS volumen_traduccion,";
				$cadenaSql.=" tr.anno_traduccion AS anno_traduccion,";
				$cadenaSql.=" tr.anno_publicacion AS anno_publicacion,";
				$cadenaSql.=" tr.numero_acta AS numero_acta,";
				$cadenaSql.=" tr.fecha_acta AS fecha_acta,";
				$cadenaSql.=" tr.numero_caso AS numero_caso,";
				$cadenaSql.=" tr.puntaje AS puntaje,";
				$cadenaSql.=" tr.normatividad AS normatividad";
				$cadenaSql.=" FROM docencia.traduccion_libro AS tr";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente = tr.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON tr.documento_docente=dc_pc.documento_docente";
				$cadenaSql.=" WHERE tr.estado=true";
				$cadenaSql.=" AND dc.estado=true";
				$cadenaSql.=" AND tr.id_traduccion_libro = '".$variable ['id_traduccion_libro']."';";
				break;
				
			case "actualizar" :
				$cadenaSql="UPDATE ";
				$cadenaSql.="docencia.traduccion_libro ";
				$cadenaSql.="SET ";
				$cadenaSql.=" documento_docente='".$variable['id_docenteRegistrar']."',";
				$cadenaSql.=" titulo='".$variable['nombre']."',";
				$cadenaSql.=" nombre_autor_original='".$variable['nombreAutorOriginal']."',";
				$cadenaSql.=" volumen='".$variable['volumen']."',";
				$cadenaSql.=" anno_traduccion='".$variable['annoTraduccion']."',";
				$cadenaSql.=" anno_publicacion='".$variable['annoPublicacion']."',";
				$cadenaSql.=" numero_acta='".$variable['numeroActa']."',";
				$cadenaSql.=" fecha_acta='".$variable['fechaActa']."',";
				$cadenaSql.=" numero_caso='".$variable['numeroCasoActa']."',";
				$cadenaSql.=" puntaje='".$variable['puntaje']."',";
				$cadenaSql.=" normatividad='".$variable['normatividad']."'";
				$cadenaSql.= "WHERE ";
				$cadenaSql.= "id_traduccion_libro ='".$variable ['old_id_traduccion_libro']."';";
				break;
		}
		
		return $cadenaSql;
	}
}

?>
