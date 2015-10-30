<?php

namespace asignacionPuntajes\bonificacion\traduccionDeArticulos;

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
				
			case "tipo_traduccion_articulo" :
				$cadenaSql = "select";
				$cadenaSql .= " id_tipo_traduccion_articulo,";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_traduccion_articulo";
				$cadenaSql .= " WHERE id_tipo_traduccion_articulo>0";
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
				$cadenaSql.=" tra.id_traduccion_articulo AS id_traduccion_articulo,";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" tra.titulo_publicacion AS titulo_publicacion,";
				$cadenaSql.=" tra.titulo_traduccion AS titulo_traduccion,";
				$cadenaSql.=" ttra.id_tipo_traduccion_articulo AS id_tipo_traduccion_articulo,";
				$cadenaSql.=" ttra.descripcion AS tipo_traduccion_articulo,";
				$cadenaSql.=" tra.fecha_traduccion AS fecha_traduccion,";
				$cadenaSql.=" tra.numero_acta AS numero_acta,";
				$cadenaSql.=" tra.fecha_acta AS fecha_acta,";
				$cadenaSql.=" tra.numero_caso AS numero_caso,";
				$cadenaSql.=" tra.puntaje AS puntaje,";
				$cadenaSql.=" tra.normatividad AS normatividad";
				$cadenaSql.=" FROM docencia.traduccion_articulo AS tra";
				$cadenaSql.=" LEFT JOIN docencia.tipo_traduccion_articulo AS ttra ON ttra.id_tipo_traduccion_articulo = tra.id_tipo_traduccion_articulo";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente = tra.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON tra.documento_docente=dc_pc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.proyectocurricular AS pc ON dc_pc.id_proyectocurricular=pc.id_proyectocurricular";
				$cadenaSql.=" LEFT JOIN docencia.facultad AS fc ON pc.id_facultad=fc.id_facultad";
				$cadenaSql.=" WHERE tra.estado=true";
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
				break;
				
			case "registrar" :
				$cadenaSql=" INSERT INTO docencia.traduccion_articulo(";
				$cadenaSql.=" documento_docente,";
				$cadenaSql.=" titulo_publicacion,";
				$cadenaSql.=" titulo_traduccion,";
				$cadenaSql.=" id_tipo_traduccion_articulo,";
				$cadenaSql.=" fecha_traduccion,";
				$cadenaSql.=" numero_acta,";
				$cadenaSql.=" fecha_acta,";
				$cadenaSql.=" numero_caso,";
				$cadenaSql.=" puntaje,";
				$cadenaSql.=" normatividad";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES(";
				$cadenaSql.=" '".$variable['id_docenteRegistrar']."',";
				$cadenaSql.=" '".$variable['tituloPublicacion']."',";
				$cadenaSql.=" '".$variable['tituloTraduccion']."',";
				$cadenaSql.=" '".$variable['tipoPublicacion']."',";
				$cadenaSql.=" '".$variable['fechaTraduccion']."',";
				$cadenaSql.=" '".$variable['numeroActa']."',";
				$cadenaSql.=" '".$variable['fechaActa']."',";
				$cadenaSql.=" '".$variable['numeroCasoActa']."',";
				$cadenaSql.=" '".$variable['puntaje']."',";
				$cadenaSql.=" '".$variable['normatividad']."'";
				$cadenaSql.=" );";
				break;
				
			case "consultaModificar" :			
				$cadenaSql=" SELECT";
				$cadenaSql.=" tra.id_traduccion_articulo AS id_traduccion_articulo,";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" tra.titulo_publicacion AS titulo_publicacion,";
				$cadenaSql.=" tra.titulo_traduccion AS titulo_traduccion,";
				$cadenaSql.=" tra.id_tipo_traduccion_articulo AS id_tipo_traduccion_articulo,";
				$cadenaSql.=" tra.fecha_traduccion AS fecha_traduccion,";
				$cadenaSql.=" tra.numero_acta AS numero_acta,";
				$cadenaSql.=" tra.fecha_acta AS fecha_acta,";
				$cadenaSql.=" tra.numero_caso AS numero_caso,";
				$cadenaSql.=" tra.normatividad AS normatividad,";
				$cadenaSql.=" tra.puntaje AS puntaje";
				$cadenaSql.=" FROM docencia.traduccion_articulo AS tra";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON dc.documento_docente = tra.documento_docente";
				$cadenaSql.=" WHERE tra.estado=true";
				$cadenaSql.=" AND dc.estado=true";
				$cadenaSql.=" AND tra.id_traduccion_articulo = '".$variable ['id_traduccion_articulo']."';";
				break;
				
			case "actualizar" :
				$cadenaSql=" UPDATE";
				$cadenaSql.=" docencia.traduccion_articulo";
				$cadenaSql.=" SET ";
				$cadenaSql.=" documento_docente='".$variable ['id_docenteRegistrar']."',";
				$cadenaSql.=" titulo_publicacion='".$variable ['tituloPublicacion']."',";
				$cadenaSql.=" titulo_traduccion='".$variable ['tituloTraduccion']."',";
				$cadenaSql.=" id_tipo_traduccion_articulo='".$variable ['tipoPublicacion']."',";
				$cadenaSql.=" fecha_traduccion='".$variable ['fechaTraduccion']."',";
				$cadenaSql.=" numero_acta='".$variable ['numeroActa']."',";
				$cadenaSql.=" fecha_acta='".$variable ['fechaActa']."',";
				$cadenaSql.=" numero_caso='".$variable ['numeroCasoActa']."',";
				$cadenaSql.=" puntaje='".$variable ['puntaje']."',";
				$cadenaSql.=" normatividad='".$variable ['normatividad']."'";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" id_traduccion_articulo='".$variable ['id_traduccion_articulo']."'";
				$cadenaSql.=" ;";
				break;
		}
		
		return $cadenaSql;
	}
}

?>
