<?php

namespace asignacionPuntajes\salariales\obrasArtisticas;

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
				
			case "tipoObra" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_tipo_obra_artistica,";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_obra_artistica";
				$cadenaSql .= " WHERE id_tipo_obra_artistica != -1";
				break;
				
			case "contexto" :
				$cadenaSql = "select";
				$cadenaSql .= " id_contexto,";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.contexto";
				$cadenaSql .= " WHERE id_contexto != -1";
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
				$cadenaSql=" select ";
				$cadenaSql.=" oad.id_obra_artistica AS id_obra, oad.documento_docente, ";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente,";
				$cadenaSql.=" toa.descripcion AS tipo_obra, oad.titulo_obra AS titulo_obra,";
				$cadenaSql.=" oad.certificador, con.descripcion AS contexto,";
				$cadenaSql.=" oad.anno_obra, ";
				$cadenaSql.=" oad.numero_acta, ";
				$cadenaSql.=" oad.fecha_acta, ";
				$cadenaSql.=" oad.numero_caso, ";
				$cadenaSql.=" oad.puntaje, ";
				$cadenaSql.=" oad.normatividad ";
				$cadenaSql.=" from ";
				$cadenaSql.=" docencia.obra_artistica AS oad ";
				$cadenaSql.=" left join docencia.docente dc on oad.documento_docente=dc.documento_docente ";
				$cadenaSql.=" left join docencia.docente_proyectocurricular dc_pc on oad.documento_docente=dc_pc.documento_docente ";
				$cadenaSql.=" left join docencia.proyectocurricular pc on dc_pc.id_proyectocurricular=pc.id_proyectocurricular ";
				$cadenaSql.=" left join docencia.facultad fc on pc.id_facultad=fc.id_facultad ";
				$cadenaSql.=" left join docencia.tipo_obra_artistica AS toa on oad.id_tipo_obra_artistica=toa.id_tipo_obra_artistica ";
				$cadenaSql.=" left join docencia.contexto con ON con.id_contexto = oad.id_contexto";
				$cadenaSql.=" where oad.estado=true";
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
				$cadenaSql = "INSERT INTO docencia.obra_artistica( ";
				$cadenaSql .= "documento_docente, id_tipo_obra_artistica, titulo_obra, certificador, ";
				$cadenaSql .= "id_contexto, anno_obra, ";
				$cadenaSql .= "numero_acta, fecha_acta, numero_caso, puntaje, normatividad) ";
				$cadenaSql .= " VALUES (" . $variable ['id_docenteRegistrar'] . ",";
				$cadenaSql .= " '" . $variable ['tipoObraArt'] . "',";
				$cadenaSql .= " '" . $variable ['titulo'] . "',";
				$cadenaSql .= "'" . $variable ['certificador'] . "',";
				$cadenaSql .= " '" . $variable ['contexto'] . "',";
				$cadenaSql .= " '" . $variable ['anno'] . "',";
				$cadenaSql .= "' " . $variable ['numeroActa'] . "',";
				$cadenaSql .= " '" . $variable ['fechaActa'] . "',";
				$cadenaSql .= "' " . $variable ['numeroCasoActa'] . "',";
				$cadenaSql .= "' " . $variable ['puntaje'] . "',";
				$cadenaSql .= " '" . $variable ['normatividad'] . "')";
				break;
				
			case "publicacionActualizar" :
				$cadenaSql=" SELECT oad.documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente,";
				$cadenaSql.=" oad.id_tipo_obra_artistica AS tipo_obra, ";
				$cadenaSql.=" oad.titulo_obra, ";
				$cadenaSql.=" oad.certificador, ";
				$cadenaSql.=" oad.id_contexto AS contexto, ";
				$cadenaSql.=" oad.anno_obra, ";
				$cadenaSql.=" oad.numero_acta, ";
				$cadenaSql.=" oad.fecha_acta, ";
				$cadenaSql.=" oad.numero_caso, ";
				$cadenaSql.=" oad.puntaje, ";
				$cadenaSql.=" oad.normatividad ";
				$cadenaSql.=" FROM docencia.obra_artistica AS oad ";
				$cadenaSql.=" left join docencia.docente dc on oad.documento_docente=dc.documento_docente ";
				$cadenaSql.=" WHERE oad.documento_docente ='" . $variable['documento_docente']. "'";
				$cadenaSql.=" and oad.estado=true";
				$cadenaSql.=" and oad.id_obra_artistica ='" . $variable['identificadorObra']. "'";
				break;
				
			case "actualizar" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "docencia.obra_artistica ";
				$cadenaSql .= "SET ";
				$cadenaSql .= "id_tipo_obra_artistica = '" . $variable ['tipoObraArt'] . "', ";
				$cadenaSql .= "titulo_obra = '" . $variable ['titulo'] . "', ";
				$cadenaSql .= "certificador = '" . $variable ['certificador'] . "', ";
				$cadenaSql .= "id_contexto = '" . $variable ['contexto'] . "', ";
				$cadenaSql .= "anno_obra = '" . $variable ['anno'] . "', ";
				$cadenaSql .= "numero_acta = '" . $variable ['numeroActa'] . "', ";
				$cadenaSql .= "fecha_acta = '" . $variable ['fechaActa'] . "', ";
				$cadenaSql .= "numero_caso = '" . $variable ['numeroCasoActa'] . "', ";
				$cadenaSql .= "puntaje = '" . $variable ['puntaje'] . "', ";
				$cadenaSql .= "normatividad = '" . $variable ['normatividad'] . "'";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "documento_docente ='" . $variable ['id_docenteRegistrar'] . "' ";
				$cadenaSql .= "and id_obra_artistica ='" . $variable ['identificadorObra_old'] . "' ";
				break;
		}
		
		return $cadenaSql;
	}
}

?>
