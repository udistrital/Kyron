<?php

namespace asignacionPuntajes\bonificacion\estudiosPostDoctorales;

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
				$cadenaSql .= " AND id_universidad != -1";
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
				$cadenaSql=" SELECT";
				$cadenaSql.=" ep.id_estudio_postdoctoral_docente AS id_estudio_postdoctoral_docente,";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" un.nombre_universidad AS entidad,";
				$cadenaSql.=" ep.titulo_obtenido AS titulo_obtenido,";
				$cadenaSql.=" ep.fecha_obtencion AS fecha_obtencion,";
				$cadenaSql.=" ep.otra_entidad AS otra_entidad,";
				$cadenaSql.=" ep.annos_doctorado AS annos_doctorado,";
				$cadenaSql.=" ep.numero_acta AS numero_acta,";
				$cadenaSql.=" ep.fecha_acta AS fecha_acta,";
				$cadenaSql.=" ep.caso_acta AS caso_acta,";
				$cadenaSql.=" ep.puntaje AS puntaje";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.estudio_postdoctoral_docente AS ep";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON ep.documento_docente=dc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON ep.documento_docente=dc_pc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.proyectocurricular AS pc ON dc_pc.id_proyectocurricular=pc.id_proyectocurricular";
				$cadenaSql.=" LEFT JOIN docencia.facultad AS fc ON pc.id_facultad=fc.id_facultad";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS un ON un.id_universidad = ep.id_universidad";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" ep.estado=true";
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
				
			case "registrar" :
				$cadenaSql=" INSERT INTO docencia.estudio_postdoctoral_docente";
				$cadenaSql.=" (";
				$cadenaSql.=" documento_docente,";
				$cadenaSql.=" titulo_obtenido,";
				$cadenaSql.=" fecha_obtencion,";
				$cadenaSql.=" id_universidad,";
				$cadenaSql.=" otra_entidad,";
				$cadenaSql.=" annos_doctorado,";
				$cadenaSql.=" numero_acta,";
				$cadenaSql.=" fecha_acta,";
				$cadenaSql.=" caso_acta,";
				$cadenaSql.=" puntaje,";
				$cadenaSql.=" normatividad";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES";
				$cadenaSql.=" (";
				$cadenaSql.=" '" . $variable ['id_docenteRegistrar'] . "',";
				$cadenaSql.=" '" . $variable ['titulo'] . "',";
				$cadenaSql.=" '" . $variable ['fecha'] . "',";
				$cadenaSql.=" " . $variable ['entidad'] . ",";
				$cadenaSql.=" " . $variable ['otraEntidad'] . ",";
				$cadenaSql.=" '" . $variable ['annos'] . "',";
				$cadenaSql.=" '" . $variable ['numeroActa'] . "',";
				$cadenaSql.=" '" . $variable ['fechaActa'] . "',";
				$cadenaSql.=" '" . $variable ['numeroCasoActa'] . "',";
				$cadenaSql.=" '" . $variable ['puntaje'] . "',";
				$cadenaSql.=" '" . $variable ['normatividad'] . "'";
				$cadenaSql.=" )";
				$cadenaSql.=" ;";
				break;				
				
			case "consultaActualizar" :
				$cadenaSql=" SELECT ep.id_estudio_postdoctoral_docente AS id_estudio_postdoctoral_docente,";
				$cadenaSql.=" ep.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" ep.titulo_obtenido AS titulo_obtenido,";
				$cadenaSql.=" ep.fecha_obtencion AS fecha_obtencion,";
				$cadenaSql.=" ep.id_universidad AS id_universidad,";
				$cadenaSql.=" ep.otra_entidad AS otra_entidad,";
				$cadenaSql.=" ep.annos_doctorado AS annos_doctorado,";
				$cadenaSql.=" ep.numero_acta AS numero_acta,";
				$cadenaSql.=" ep.fecha_acta AS fecha_acta,";
				$cadenaSql.=" ep.caso_acta AS caso_acta,";
				$cadenaSql.=" ep.puntaje AS puntaje,";
				$cadenaSql.=" ep.normatividad AS normatividad";
				$cadenaSql.=" FROM docencia.estudio_postdoctoral_docente AS ep";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON ep.documento_docente=dc.documento_docente";
				$cadenaSql.=" WHERE ep.id_estudio_postdoctoral_docente ='" . $variable['id_estudio_postdoctoral_docente']. "'";
				$cadenaSql.=" ;";
				break;
				
			case "actualizar" :
				$cadenaSql=" UPDATE docencia.estudio_postdoctoral_docente";
				$cadenaSql.=" SET";
				$cadenaSql.=" documento_docente='" . $variable ['id_docenteRegistrar'] . "',";
				$cadenaSql.=" titulo_obtenido='" . $variable ['titulo'] . "',";
				$cadenaSql.=" fecha_obtencion='" . $variable ['fecha'] . "',";
				$cadenaSql.=" id_universidad=" . $variable ['entidad'] . ",";
				$cadenaSql.=" otra_entidad=" . $variable ['otraEntidad'] . ",";
				$cadenaSql.=" annos_doctorado='" . $variable ['annos'] . "',";
				$cadenaSql.=" numero_acta='" . $variable ['numeroActa'] . "',";
				$cadenaSql.=" fecha_acta='" . $variable ['fechaActa'] . "',";
				$cadenaSql.=" caso_acta='" . $variable ['numeroCasoActa'] . "',";
				$cadenaSql.=" puntaje='" . $variable ['puntaje'] . "',";
				$cadenaSql.=" normatividad='" . $variable ['normatividad'] . "'";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" id_estudio_postdoctoral_docente='" . $variable ['id_estudio_postdoctoral_docente'] . "'";
				$cadenaSql.=" AND estado=true";
				$cadenaSql.=" ;";
				break;
				
		}
		
		return $cadenaSql;
	}
}

?>
