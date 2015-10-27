<?php

namespace asignacionPuntajes\bonificacion\publicacionesImpresas;

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
				$cadenaSql.=" LIKE '%" . $variable . "%' LIMIT 10;";				
				break;
								
			case "consultar" :			
				$cadenaSql=" SELECT";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" pi.titulo AS titulo,";
				$cadenaSql.=" pi.numero_issn AS numero_issn,";
				$cadenaSql.=" pi.nombre_revista AS nombre_revista,";
				$cadenaSql.=" pi.numero_revista AS numero_revista,";
				$cadenaSql.=" pi.volumen_revista AS volumen_revista,";
				$cadenaSql.=" pi.anno_revista AS anno_revista,";
				$cadenaSql.=" pi.id_tipo_indexacion AS id_tipo_indexacion,";
				$cadenaSql.=" ti.descripcion AS tipo_indexacion,";
				$cadenaSql.=" pi.numero_acta AS numero_acta,";
				$cadenaSql.=" pi.fecha_acta AS fecha_acta,";
				$cadenaSql.=" pi.numero_caso AS numero_caso,";
				$cadenaSql.=" pi.puntaje AS puntaje ,";
				$cadenaSql.=" pi.normatividad AS normatividad";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.publicacion_impresa AS pi";
				$cadenaSql.=" LEFT JOIN docencia.tipo_indexacion AS ti ON ti.id_tipo_indexacion=pi.id_tipo_indexacion";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON pi.documento_docente=dc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON pi.documento_docente=dc_pc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.proyectocurricular AS pc ON dc_pc.id_proyectocurricular=pc.id_proyectocurricular";
				$cadenaSql.=" LEFT JOIN docencia.facultad AS fc ON pc.id_facultad=fc.id_facultad";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" pi.estado=true";
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
				
			case "categoria_revista" :
				$cadenaSql = "select";
				$cadenaSql .= " id_tipo_indexacion,";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_indexacion";
				$cadenaSql .= " WHERE";
				$cadenaSql .= " id_contexto =" . $variable;
				break;
				
			case "registrar" :
				$cadenaSql=" INSERT INTO docencia.publicacion_impresa";
				$cadenaSql.=" (";
				$cadenaSql.=" documento_docente,";
				$cadenaSql.=" titulo,";
				$cadenaSql.=" numero_issn,";
				$cadenaSql.=" nombre_revista,";
				$cadenaSql.=" numero_revista,";
				$cadenaSql.=" volumen_revista,";
				$cadenaSql.=" anno_revista,";
				$cadenaSql.=" id_tipo_indexacion,";
				$cadenaSql.=" numero_acta,";
				$cadenaSql.=" fecha_acta,";
				$cadenaSql.=" numero_caso,";
				$cadenaSql.=" puntaje,";
				$cadenaSql.=" normatividad";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES";
				$cadenaSql.=" (";
				$cadenaSql.=" '" . $variable['id_docenteRegistrar']. "',";
				$cadenaSql.=" '" . $variable['titulo']. "',";
				$cadenaSql.=" '" . $variable['issn']. "',";
				$cadenaSql.=" '" . $variable['revista']. "',";
				$cadenaSql.=" '" . $variable['numeroRevista']. "',";
				$cadenaSql.=" '" . $variable['volumenRevista']. "',";
				$cadenaSql.=" '" . $variable['annoRevista']. "',";
				$cadenaSql.=" '" . $variable['categoria']. "',";
				$cadenaSql.=" '" . $variable['numeroActa']. "',";
				$cadenaSql.=" '" . $variable['fechaActa']. "',";
				$cadenaSql.=" '" . $variable['numeroCasoActa']. "',";
				$cadenaSql.=" '" . $variable['puntaje']. "',";
				$cadenaSql.=" '" . $variable['normatividad']. "'";
				$cadenaSql.=" );";
				break;		
				
			case "consultaActualizar" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" pi.titulo AS titulo,";
				$cadenaSql.=" pi.numero_issn AS numero_issn,";
				$cadenaSql.=" pi.nombre_revista AS nombre_revista,";
				$cadenaSql.=" pi.numero_revista AS numero_revista,";
				$cadenaSql.=" pi.volumen_revista AS volumen_revista,";
				$cadenaSql.=" pi.anno_revista AS anno_revista,";
				$cadenaSql.=" pi.id_tipo_indexacion AS id_tipo_indexacion,";
				$cadenaSql.=" ti.descripcion AS tipo_indexacion,";
				$cadenaSql.=" pi.numero_acta AS numero_acta,";
				$cadenaSql.=" pi.fecha_acta AS fecha_acta,";
				$cadenaSql.=" pi.numero_caso AS numero_caso,";
				$cadenaSql.=" pi.puntaje AS puntaje ,";
				$cadenaSql.=" pi.normatividad AS normatividad";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.publicacion_impresa AS pi";
				$cadenaSql.=" LEFT JOIN docencia.tipo_indexacion AS ti ON ti.id_tipo_indexacion=pi.id_tipo_indexacion";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente=pi.documento_docente";
				$cadenaSql.=" WHERE pi.numero_issn ='" . $variable['numero_issn']. "'";
				$cadenaSql.=" AND pi.documento_docente ='" . $variable['documento_docente']. "'";
				$cadenaSql.=" ;";
				break;
				
			case "actualizar" :
				$cadenaSql=" UPDATE docencia.publicacion_impresa";
				$cadenaSql.=" SET";
				$cadenaSql.=" documento_docente='" . $variable['id_docenteRegistrar']. "',";
				$cadenaSql.=" titulo='" . $variable['titulo']. "',";
				$cadenaSql.=" numero_issn='" . $variable['issn']. "',";
				$cadenaSql.=" nombre_revista='" . $variable['revista']. "',";
				$cadenaSql.=" numero_revista='" . $variable['numeroRevista']. "',";
				$cadenaSql.=" volumen_revista='" . $variable['volumenRevista']. "',";
				$cadenaSql.=" anno_revista='" . $variable['annoRevista']. "',";
				$cadenaSql.=" id_tipo_indexacion='" . $variable['categoria']. "',";
				$cadenaSql.=" numero_acta='" . $variable['numeroActa']. "',";
				$cadenaSql.=" fecha_acta='" . $variable['fechaActa']. "',";
				$cadenaSql.=" numero_caso='" . $variable['numeroCasoActa']. "',";
				$cadenaSql.=" puntaje='" . $variable['puntaje']. "',";
				$cadenaSql.=" normatividad='" . $variable['normatividad']. "'";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" numero_issn='" . $variable['old_issn']. "'";
				$cadenaSql.=" AND documento_docente='" . $variable['old_id_docenteRegistrar']. "'";
				$cadenaSql.=" AND estado=true";
				$cadenaSql.=" ;";
				break;
				
		}
		
		return $cadenaSql;
	}
}

?>
