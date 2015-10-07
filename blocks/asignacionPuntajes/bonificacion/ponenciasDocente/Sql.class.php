<?php

namespace asignacionPuntajes\bonificacion\ponenciasDocente;

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
				$cadenaSql=" SELECT";
				$cadenaSql.=" po.id_ponencia AS id_ponencia,";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" po.titulo AS titulo,";
				$cadenaSql.=" po.numero_autores AS numero_autores,";
				$cadenaSql.=" po.numero_autores_ud AS numero_autores_ud,";
				$cadenaSql.=" po.fecha AS fecha,";
				$cadenaSql.=" ti.contexto AS contexto,";
				$cadenaSql.=" po.evento_presentacion AS evento_presentacion,";
				$cadenaSql.=" po.institucion_certificadora AS institucion_certificadora,";
				$cadenaSql.=" po.numero_acta AS numero_acta,";
				$cadenaSql.=" po.fecha_acta AS fecha_acta,";
				$cadenaSql.=" po.caso_acta AS caso_acta,";
				$cadenaSql.=" po.puntaje AS puntaje";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.ponencia AS po";
				$cadenaSql.=" LEFT JOIN docencia.contexto_ponencia AS ti ON ti.id_contexto_ponencia=po.id_contexto_ponencia";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON po.documento_docente=dc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON po.documento_docente=dc_pc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.proyectocurricular AS pc ON dc_pc.id_proyectocurricular=pc.id_proyectocurricular";
				$cadenaSql.=" LEFT JOIN docencia.facultad AS fc ON pc.id_facultad=fc.id_facultad";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" po.estado=true";
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
				
			case "categoria" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_contexto_ponencia,";
				$cadenaSql .= "	contexto";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.contexto_ponencia;";
				break;
				
			case "registrar" :
				$cadenaSql=" INSERT INTO docencia.ponencia";
				$cadenaSql.=" (";
				$cadenaSql.=" documento_docente,";
				$cadenaSql.=" titulo,";
				$cadenaSql.=" numero_autores,";
				$cadenaSql.=" numero_autores_ud,";
				$cadenaSql.=" fecha,";
				$cadenaSql.=" id_contexto_ponencia,";
				$cadenaSql.=" evento_presentacion,";
				$cadenaSql.=" institucion_certificadora,";
				$cadenaSql.=" numero_acta,";
				$cadenaSql.=" fecha_acta,";
				$cadenaSql.=" caso_acta,";
				$cadenaSql.=" puntaje";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES";
				$cadenaSql.=" (";
				$cadenaSql.=" '" . $variable ['id_docenteRegistrar'] . "',";
				$cadenaSql.=" '" . $variable ['titulo'] . "',";
				$cadenaSql.=" '" . $variable ['numeroAutores'] . "',";
				$cadenaSql.=" '" . $variable ['numeroAutoresUniversidad'] . "',";
				$cadenaSql.=" '" . $variable ['fecha'] . "',";
				$cadenaSql.=" '" . $variable ['categoria'] . "',";
				$cadenaSql.=" '" . $variable ['evento'] . "',";
				$cadenaSql.=" '" . $variable ['institucion'] . "',";
				$cadenaSql.=" '" . $variable ['numeroActa'] . "',";
				$cadenaSql.=" '" . $variable ['fechaActa'] . "',";
				$cadenaSql.=" '" . $variable ['numeroCasoActa'] . "',";
				$cadenaSql.=" '" . $variable ['puntaje'] . "'";
				$cadenaSql.=" );";
				break;		
				
			case "consultaActualizar" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" po.id_ponencia AS id_ponencia,";
				$cadenaSql.=" dc.documento_docente AS documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" po.titulo AS titulo,";
				$cadenaSql.=" po.numero_autores AS numero_autores,";
				$cadenaSql.=" po.numero_autores_ud AS numero_autores_ud,";
				$cadenaSql.=" po.fecha AS fecha,";
				$cadenaSql.=" ti.contexto AS contexto,";
				$cadenaSql.=" po.evento_presentacion AS evento_presentacion,";
				$cadenaSql.=" po.institucion_certificadora AS institucion_certificadora,";
				$cadenaSql.=" po.numero_acta AS numero_acta,";
				$cadenaSql.=" po.fecha_acta AS fecha_acta,";
				$cadenaSql.=" po.caso_acta AS caso_acta,";
				$cadenaSql.=" po.puntaje AS puntaje";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.ponencia AS po";
				$cadenaSql.=" LEFT JOIN docencia.contexto_ponencia AS ti ON ti.id_contexto_ponencia=po.id_contexto_ponencia";
				$cadenaSql.=" LEFT JOIN docencia.docente AS dc ON po.documento_docente=dc.documento_docente";
				$cadenaSql.=" WHERE po.id_ponencia ='" . $variable['id_ponencia']. "'";
				$cadenaSql.=" ;";
				break;
				
			case "actualizar" :
				$cadenaSql=" UPDATE docencia.ponencia";
				$cadenaSql.=" SET";
				$cadenaSql.=" documento_docente='" . $variable['id_docenteRegistrar']. "',";
				$cadenaSql.=" titulo='" . $variable['titulo']. "',";
				$cadenaSql.=" numero_autores='" . $variable['numeroAutores']. "',";
				$cadenaSql.=" numero_autores_ud='" . $variable['numeroAutoresUniversidad']. "',";
				$cadenaSql.=" fecha='" . $variable['fecha']. "',";
				$cadenaSql.=" id_contexto_ponencia='" . $variable['categoria']. "',";
				$cadenaSql.=" evento_presentacion='" . $variable['evento']. "',";
				$cadenaSql.=" institucion_certificadora='" . $variable['institucion']. "',";
				$cadenaSql.=" numero_acta='" . $variable['numeroActa']. "',";
				$cadenaSql.=" fecha_acta='" . $variable['fechaActa']. "',";
				$cadenaSql.=" caso_acta='" . $variable['numeroCasoActa']. "',";
				$cadenaSql.=" puntaje='" . $variable['puntaje']. "'";
				$cadenaSql.=" WHERE";
				$cadenaSql.=" id_ponencia='" . $variable ['id_ponencia'] . "'";
				$cadenaSql.=" AND estado=true";
				$cadenaSql.=" ;";
				break;
				
		}
		
		return $cadenaSql;
	}
}

?>
