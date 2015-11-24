<?php

namespace asignacionPuntajes\salariales\patentes;

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

			case "tipo_patente" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_tipo_patente,";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_patente";
				$cadenaSql .= " WHERE id_tipo_patente != -1";
				
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
				
			case "pais" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " paiscodigo,";
				$cadenaSql .= "	paisnombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.pais";
				$cadenaSql .= " order by paisnombre";
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
				$cadenaSql.=" pat.id_patente, ";
				$cadenaSql.=" pat.documento_docente, ";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente,";
				$cadenaSql.=" pat.titulo_patente, ";
				$cadenaSql.=" tp.descripcion as tipo_patente,";
				$cadenaSql.=" pat.concepto_patente,";
				$cadenaSql.=" un.nombre_universidad as entidad,";
				$cadenaSql.=" pi.paisnombre as pais,";
				$cadenaSql.=" pat.anno_obtencion,";
				$cadenaSql.=" pat.puntaje";
				$cadenaSql.=" from ";
				$cadenaSql.=" docencia.patente pat ";
				$cadenaSql.=" left join docencia.docente dc on pat.documento_docente=dc.documento_docente ";
				$cadenaSql.=" left join docencia.docente_proyectocurricular dc_pc on pat.documento_docente=dc_pc.documento_docente ";
				$cadenaSql.=" left join docencia.proyectocurricular pc on dc_pc.id_proyectocurricular=pc.id_proyectocurricular ";
				$cadenaSql.=" left join docencia.facultad fc on pc.id_facultad=fc.id_facultad ";
				$cadenaSql.=" left join docencia.tipo_patente tp on pat.id_tipo_patente=tp.id_tipo_patente ";
				$cadenaSql.=" left join docencia.universidad un on pat.id_universidad=un.id_universidad ";
				$cadenaSql.=" left join docencia.pais pi on pat.paiscodigo=pi.paiscodigo ";
				$cadenaSql.=" where pat.estado=true";
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
				$cadenaSql = "INSERT INTO docencia.patente( ";
				$cadenaSql .= "documento_docente, id_tipo_patente, titulo_patente, id_universidad, ";
				$cadenaSql .= "paiscodigo, anno_obtencion,concepto_patente, numero_registro, ";
				$cadenaSql .= "numero_acta, fecha_acta, numero_caso, puntaje, normatividad) ";
				$cadenaSql .= " VALUES (" . $variable ['id_docenteRegistrar'] . ",";
				$cadenaSql .= " '" . $variable ['tipoPatente'] . "',";
				$cadenaSql .= " '" . $variable ['tituloPatente'] . "',";
				$cadenaSql .= "'" . $variable ['entidadPatente'] . "',";
				$cadenaSql .= " '" . $variable ['pais'] . "',";
				$cadenaSql .= " '" . $variable ['anno'] . "',";
				$cadenaSql .= " '" . $variable ['conceptoPatente'] . "',";
				$cadenaSql .= " '" . $variable ['numeroRegistro'] . "',";
				$cadenaSql .= "' " . $variable ['numeroActa'] . "',";
				$cadenaSql .= " '" . $variable ['fechaActa'] . "',";
				$cadenaSql .= "' " . $variable ['numeroCasoActa'] . "',";
				$cadenaSql .= "' " . $variable ['puntaje'] . "',";
				$cadenaSql .= " '" . $variable ['normatividad'] . "')";
				break;
				
			case "publicacionActualizar" :
				$cadenaSql=" SELECT pat.documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente,";
				$cadenaSql.=" pat.id_tipo_patente, ";
				$cadenaSql.=" pat.titulo_patente, ";
				$cadenaSql.=" pat.id_universidad, ";
				$cadenaSql.=" pat.paiscodigo, ";
				$cadenaSql.=" pat.anno_obtencion, ";
				$cadenaSql.=" pat.concepto_patente, ";
				$cadenaSql.=" pat.numero_registro, ";
				$cadenaSql.=" pat.numero_acta, ";
				$cadenaSql.=" pat.fecha_acta, ";
				$cadenaSql.=" pat.numero_caso, ";
				$cadenaSql.=" pat.puntaje, ";
				$cadenaSql.=" pat.normatividad ";
				$cadenaSql.=" FROM docencia.patente pat ";
				$cadenaSql.=" left join docencia.docente dc on pat.documento_docente=dc.documento_docente ";
				$cadenaSql.=" WHERE pat.documento_docente ='" . $variable['documento_docente']. "'";
				$cadenaSql.=" and pat.estado=true";
				$cadenaSql.=" and pat.id_patente ='" . $variable['identificadorPatente']. "'";
				break;
				
			case "actualizar" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "docencia.patente ";
				$cadenaSql .= "SET ";
				$cadenaSql .= "id_tipo_patente = '" . $variable ['tipoPatente'] . "', ";
				$cadenaSql .= "titulo_patente = '" . $variable ['tituloPatente'] . "', ";
				$cadenaSql .= "id_universidad = '" . $variable ['entidadPatente'] . "', ";
				$cadenaSql .= "paiscodigo = '" . $variable ['pais'] . "', ";
				$cadenaSql .= "anno_obtencion = '" . $variable ['anno'] . "', ";
				$cadenaSql .= "concepto_patente = '" . $variable ['conceptoPatente'] . "', ";
				$cadenaSql .= "numero_registro = '" . $variable ['numeroRegistro'] . "', ";
				$cadenaSql .= "numero_acta = '" . $variable ['numeroActa'] . "', ";
				$cadenaSql .= "fecha_acta = '" . $variable ['fechaActa'] . "', ";
				$cadenaSql .= "numero_caso = '" . $variable ['numeroCasoActa'] . "', ";
				$cadenaSql .= "puntaje = '" . $variable ['puntaje'] . "', ";
				$cadenaSql .= "normatividad = '" . $variable ['normatividad'] . "'";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "documento_docente ='" . $variable ['id_docenteRegistrar'] . "' ";
				$cadenaSql .= "and id_patente ='" . $variable ['identificadorPatente_old'] . "' ";
				break;
		}
		
		return $cadenaSql;
	}
}

?>
