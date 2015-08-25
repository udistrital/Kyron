<?php

namespace inventarios\radicarAsignar;

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
			 * Clausulas específicas
			 */
			case "buscarUsuario" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "FECHA_CREACION, ";
				$cadenaSql .= "PRIMER_NOMBRE ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "USUARIOS ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "`PRIMER_NOMBRE` ='" . $variable . "' ";
				break;
			
			case "insertarRegistro" :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= $prefijo . "registradoConferencia ";
				$cadenaSql .= "( ";
				$cadenaSql .= "`idRegistrado`, ";
				$cadenaSql .= "`nombre`, ";
				$cadenaSql .= "`apellido`, ";
				$cadenaSql .= "`identificacion`, ";
				$cadenaSql .= "`codigo`, ";
				$cadenaSql .= "`correo`, ";
				$cadenaSql .= "`tipo`, ";
				$cadenaSql .= "`fecha` ";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				$cadenaSql .= "( ";
				$cadenaSql .= "NULL, ";
				$cadenaSql .= "'" . $variable ['nombre'] . "', ";
				$cadenaSql .= "'" . $variable ['apellido'] . "', ";
				$cadenaSql .= "'" . $variable ['identificacion'] . "', ";
				$cadenaSql .= "'" . $variable ['codigo'] . "', ";
				$cadenaSql .= "'" . $variable ['correo'] . "', ";
				$cadenaSql .= "'0', ";
				$cadenaSql .= "'" . time () . "' ";
				$cadenaSql .= ")";
				break;
			
			case "actualizarRegistro" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= $prefijo . "conductor ";
				$cadenaSql .= "SET ";
				$cadenaSql .= "`nombre` = '" . $variable ["nombre"] . "', ";
				$cadenaSql .= "`apellido` = '" . $variable ["apellido"] . "', ";
				$cadenaSql .= "`identificacion` = '" . $variable ["identificacion"] . "', ";
				$cadenaSql .= "`telefono` = '" . $variable ["telefono"] . "' ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "`idConductor` =" . $_REQUEST ["registro"] . " ";
				break;
			
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
			
			// -----------------------------** Cláusulas del caso de uso**----------------------------------//
			
			case "tipoCargue" :
				$cadenaSql = " SELECT ";
				$cadenaSql .= " id_tipo,";
				$cadenaSql .= " descripcion ";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " arka_inventarios.tipo_contrato ";
				$cadenaSql .= " WHERE descripcion in('Avances', 'Contratos(ViceRectoria)', 'Orden Compras');";
				break;
			
			case "buscar_entradas" :
				$cadenaSql = " SELECT id_entrada valor,consecutivo||' - ('||entrada.vigencia||')' descripcion  ";
				$cadenaSql .= " FROM entrada; ";
				break;
			
			case "vigencia_entrada" :
				$cadenaSql = " SELECT DISTINCT vigencia, vigencia ";
				$cadenaSql .= " FROM entrada ";
				break;
			
			// **************** Para Compras *******************//
			case "registroDocumento_compra" :
				$cadenaSql = " INSERT INTO documento_radicarasignar_compra( ";
				$cadenaSql .= " compra_idunico, ";
				$cadenaSql .= " compra_idcompra, ";
				$cadenaSql .= " compra_nombre, ";
				$cadenaSql .= " compra_tipodoc,  ";
				$cadenaSql .= " compra_ruta, ";
				$cadenaSql .= " compra_fechar, ";
				$cadenaSql .= " compra_estado) ";
				$cadenaSql .= " VALUES ( ";
				$cadenaSql .= "'" . $variable ['id_unico'] . "',";
				$cadenaSql .= "'" . $variable ['id_asignar'] . "',";
				$cadenaSql .= "'" . $variable ['nombre_archivo'] . "',";
				$cadenaSql .= "'" . $variable ['tipo'] . "',";
				$cadenaSql .= "'" . $variable ['ruta'] . "',";
				$cadenaSql .= "'" . $variable ['fecha_registro'] . "',";
				$cadenaSql .= "'" . $variable ['estado'] . "' ); ";
				break;
			
			case "actualizarDocumento_compra" :
				$cadenaSql = " UPDATE documento_radicarasignar_compra ";
				$cadenaSql .= " SET compra_idunico='" . $variable ['id_unico'] . "', ";
				$cadenaSql .= " compra_idcompra='" . $variable ['id_asignar'] . "', ";
				$cadenaSql .= " compra_nombre='" . $variable ['nombre_archivo'] . "', ";
				$cadenaSql .= " compra_tipodoc='" . $variable ['tipo'] . "',  ";
				$cadenaSql .= " compra_ruta='" . $variable ['ruta'] . "', ";
				$cadenaSql .= " compra_fechar='" . $variable ['fecha_registro'] . "' ";
				$cadenaSql .= " WHERE  ";
				$cadenaSql .= " compra_idcompra='" . $variable ['id_asignar'] . "' ";
				$cadenaSql .= "RETURNING  compra_idcompra; ";
				break;
			
			case "insertarAsignar_compra" :
				$cadenaSql = " INSERT INTO registro_radicarasignar_compra( ";
				$cadenaSql .= " compra_fecharecibido,  ";
				$cadenaSql .= " compra_numeroentrada,  ";
				$cadenaSql .= " compra_vigencia, ";
				$cadenaSql .= " compra_fechar,   ";
				$cadenaSql .= " compra_estado)";
				$cadenaSql .= " VALUES (";
				$cadenaSql .= "'" . $variable ['fecha'] . "',";
				$cadenaSql .= "'" . $variable ['numero_entrada'] . "',";
				$cadenaSql .= "'" . $variable ['vigencia_entrada'] . "',";
				$cadenaSql .= "'" . $variable ['fecha'] . "',";
				$cadenaSql .= "'" . $variable ['estado'] . "') ";
				$cadenaSql .= "RETURNING  compra_idcompra; ";
				break;
			
			case "actualizarAsignar_compra" :
				$cadenaSql = " UPDATE registro_radicarasignar_compra ";
				$cadenaSql .= " SET compra_fecharecibido='" . $variable ['fecha'] . "',  ";
				$cadenaSql .= " compra_fechar='" . $variable ['fecha'] . "'   ";
				$cadenaSql .= " WHERE compra_numeroentrada='" . $variable ['numero_entrada'] . "'  ";
				$cadenaSql .= " AND compra_vigencia= '" . $variable ['vigencia_entrada'] . "'";
				$cadenaSql .= "RETURNING  compra_idcompra; ";
				break;
			
			case "consultarAsignar_compra" :
				$cadenaSql = " SELECT compra_numeroentrada,  ";
				$cadenaSql .= " compra_vigencia ";
				$cadenaSql .= " FROM registro_radicarasignar_compra ";
				$cadenaSql .= " WHERE compra_numeroentrada='" . $variable ['numero_entrada'] . "'  ";
				$cadenaSql .= " AND compra_vigencia= '" . $variable ['vigencia_entrada'] . "'";
				$cadenaSql .= " AND compra_estado='TRUE'";
				break;
			
			// ************** Para contratos ***************//
			case "registroDocumento_contrato" :
				$cadenaSql = " INSERT INTO documento_radicarasignar_contrato( ";
				$cadenaSql .= " contrato_idunico, ";
				$cadenaSql .= " contrato_idcontrato, ";
				$cadenaSql .= " contrato_nombre, ";
				$cadenaSql .= " contrato_tipodoc,  ";
				$cadenaSql .= " contrato_ruta, ";
				$cadenaSql .= " contrato_fechar, ";
				$cadenaSql .= " contrato_estado) ";
				$cadenaSql .= " VALUES ( ";
				$cadenaSql .= "'" . $variable ['id_unico'] . "',";
				$cadenaSql .= "'" . $variable ['id_asignar'] . "',";
				$cadenaSql .= "'" . $variable ['nombre_archivo'] . "',";
				$cadenaSql .= "'" . $variable ['tipo'] . "',";
				$cadenaSql .= "'" . $variable ['ruta'] . "',";
				$cadenaSql .= "'" . $variable ['fecha_registro'] . "',";
				$cadenaSql .= "'" . $variable ['estado'] . "' ); ";
				break;
			
			case "actualizarDocumento_contrato" :
				$cadenaSql = " UPDATE documento_radicarasignar_contrato SET ";
				$cadenaSql .= " contrato_idunico='" . $variable ['id_unico'] . "', ";
				$cadenaSql .= " contrato_idcontrato='" . $variable ['id_asignar'] . "', ";
				$cadenaSql .= " contrato_nombre='" . $variable ['nombre_archivo'] . "', ";
				$cadenaSql .= " contrato_tipodoc='" . $variable ['tipo'] . "',  ";
				$cadenaSql .= " contrato_ruta='" . $variable ['ruta'] . "', ";
				$cadenaSql .= " contrato_fechar='" . $variable ['fecha_registro'] . "', ";
				$cadenaSql .= " contrato_estado='" . $variable ['estado'] . "' ";
				$cadenaSql .= " WHERE ";
				$cadenaSql .= " contrato_idcontrato='" . $variable ['id_asignar'] . "' ";
				$cadenaSql .= "RETURNING  contrato_idcontrato; ";
				break;
			
			case "insertarAsignar_contrato" :
				$cadenaSql = " INSERT INTO registro_radicarasignar_contrato( ";
				$cadenaSql .= " contrato_fecharecibido,  ";
				$cadenaSql .= " contrato_numeroentrada,  ";
				$cadenaSql .= " contrato_vigencia, ";
				$cadenaSql .= " contrato_fechar,   ";
				$cadenaSql .= " contrato_estado)";
				$cadenaSql .= " VALUES (";
				$cadenaSql .= "'" . $variable ['fecha'] . "',";
				$cadenaSql .= "'" . $variable ['numero_entrada'] . "',";
				$cadenaSql .= "'" . $variable ['vigencia_entrada'] . "',";
				$cadenaSql .= "'" . $variable ['fecha'] . "',";
				$cadenaSql .= "'" . $variable ['estado'] . "') ";
				$cadenaSql .= "RETURNING  contrato_idcontrato; ";
				break;
			
			case "actualizarAsignar_contrato" :
				$cadenaSql = " UPDATE registro_radicarasignar_contrato ";
				$cadenaSql .= " SET contrato_fecharecibido='" . $variable ['fecha'] . "',  ";
				$cadenaSql .= " contrato_fechar='" . $variable ['fecha'] . "'   ";
				$cadenaSql .= " WHERE contrato_estado='TRUE' ";
				$cadenaSql .= " AND contrato_numeroentrada='" . $variable ['numero_entrada'] . "'";
				$cadenaSql .= " AND contrato_vigencia='" . $variable ['vigencia_entrada'] . "' ";
				$cadenaSql .= "RETURNING  contrato_idcontrato; ";
				break;
			
			case "consultarAsignar_contrato" :
				$cadenaSql = "  SELECT ";
				$cadenaSql .= " contrato_numeroentrada,  ";
				$cadenaSql .= " contrato_vigencia, ";
				$cadenaSql .= " contrato_estado";
				$cadenaSql .= " FROM registro_radicarasignar_contrato ";
				$cadenaSql .= " WHERE ";
				$cadenaSql .= " contrato_numeroentrada='" . $variable ['numero_entrada'] . "' ";
				$cadenaSql .= " AND contrato_vigencia='" . $variable ['vigencia_entrada'] . "' ";
				$cadenaSql .= " AND contrato_estado='TRUE' ";
				break;
			
			// ************** Para Avances***************//
			case "registroDocumento_Avance" :
				$cadenaSql = " INSERT INTO documento_radicarasignar_avance( ";
				$cadenaSql .= " avance_idunico, ";
				$cadenaSql .= " avance_idavance, ";
				$cadenaSql .= " avance_nombre, ";
				$cadenaSql .= " avance_tipodoc,  ";
				$cadenaSql .= " avance_ruta, ";
				$cadenaSql .= " avance_fechar, ";
				$cadenaSql .= " avance_estado) ";
				$cadenaSql .= " VALUES ( ";
				$cadenaSql .= "'" . $variable ['id_unico'] . "',";
				$cadenaSql .= "'" . $variable ['id_asignar'] . "',";
				$cadenaSql .= "'" . $variable ['nombre_archivo'] . "',";
				$cadenaSql .= "'" . $variable ['tipo'] . "',";
				$cadenaSql .= "'" . $variable ['ruta'] . "',";
				$cadenaSql .= "'" . $variable ['fecha_registro'] . "',";
				$cadenaSql .= "'" . $variable ['estado'] . "' ); ";
				break;
			
			case "actualizarDocumento_Avance" :
				$cadenaSql = " UPDATE documento_radicarasignar_avance SET ";
				$cadenaSql .= " avance_idunico='" . $variable ['id_unico'] . "', ";
				$cadenaSql .= " avance_nombre='" . $variable ['nombre_archivo'] . "', ";
				$cadenaSql .= " avance_tipodoc='" . $variable ['tipo'] . "',  ";
				$cadenaSql .= " avance_ruta='" . $variable ['ruta'] . "', ";
				$cadenaSql .= " avance_fechar='" . $variable ['fecha_registro'] . "' ";
				$cadenaSql .= " WHERE ";
				$cadenaSql .= " avance_idavance='" . $variable ['id_asignar'] . "' ";
				break;
			
			case "actualizarAsignar_Avance" :
				$cadenaSql = " UPDATE registro_radicarasignar_avance ";
				$cadenaSql .= " SET avance_fecharecibido='" . $variable ['fecha'] . "',  ";
				$cadenaSql .= " avance_fechar='" . $variable ['fecha'] . "'   ";
				$cadenaSql .= " WHERE ";
				$cadenaSql .= " avance_numeroentrada='" . $variable ['numero_entrada'] . "' ";
				$cadenaSql .= " AND avance_vigenciaentrada='" . $variable ['vigencia_entrada'] . "' ";
				$cadenaSql .= " AND avance_estado='TRUE' ";
				$cadenaSql .= "RETURNING  avance_idavance; ";
				break;
			
			case "consultarAsignar_Avance" :
				$cadenaSql = "  SELECT ";
				$cadenaSql .= " avance_numeroentrada,  ";
				$cadenaSql .= " avance_vigenciaentrada, ";
				$cadenaSql .= " avance_estado";
				$cadenaSql .= " FROM registro_radicarasignar_avance ";
				$cadenaSql .= " WHERE ";
				$cadenaSql .= " avance_numeroentrada='" . $variable ['numero_entrada'] . "' ";
				$cadenaSql .= " AND avance_vigenciaentrada='" . $variable ['vigencia_entrada'] . "' ";
				$cadenaSql .= " AND avance_estado='TRUE' ";
				break;
			
			// Consultas de Oracle para rescate de información de Sicapital
			/*
			 * case "dependencias":
			 * $cadenaSql = "SELECT DEP_IDENTIFICADOR, ";
			 * $cadenaSql.= " DEP_IDENTIFICADOR ||' '|| DEP_DEPENDENCIA ";
			 * //$cadenaSql .= " DEP_DIRECCION,DEP_TELEFONO ";F
			 * $cadenaSql.= " FROM DEPENDENCIAS ";
			 * break;
			 */
			
			case "dependencias" :
				$cadenaSql = "SELECT elemento_codigo, elemento_codigo || ' -  ' || elemento_nombre ";
				$cadenaSql .= "FROM dependencia.catalogo_elemento; ";
				break;
			
			case "proveedores" :
				$cadenaSql = "SELECT PRO_NIT,PRO_NIT ||' '|| PRO_RAZON_SOCIAL";
				$cadenaSql .= " FROM PROVEEDORES ";
				break;
			
			case "select_proveedor" :
				$cadenaSql = "SELECT PRO_RAZON_SOCIAL";
				$cadenaSql .= " FROM PROVEEDORES ";
				$cadenaSql .= " WHERE PRO_NIT='" . $variable . "' ";
				break;
			
			case "contratistas" :
				$cadenaSql = "SELECT CON_IDENTIFICACION,CON_IDENTIFICACION ||' '|| CON_NOMBRE ";
				/*
				 * $cadenaSql .= " CON_CARGO, ";
				 * $cadenaSql .= " CON_DIRECCION, ";
				 * $cadenaSql .= " CON_TELEFONO ";
				 */
				$cadenaSql .= " FROM CONTRATISTAS ";
				break;
			
			case "id_contrato" :
				$cadenaSql = " SELECT id_contrato, id_contrato || ' - '|| numero_contrato ";
				$cadenaSql .= " FROM contratos; ";
				break;
			
			case "tipo_contrato" :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "id_tipo, descripcion  ";
				$cadenaSql .= "FROM tipo_contrato ";
				$cadenaSql .= "WHERE  id_tipo > 0;";
				
				break;
			
			case "clase_entrada" :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "id_clase, descripcion  ";
				$cadenaSql .= "FROM clase_entrada;";
				
				break;
			
			case "tipo_documento" :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "id_tipo_documento, descripcion  ";
				$cadenaSql .= "FROM tipo_documento;";
				
				break;
			
			case "registrarRadicacion" :
				$cadenaSql = " INSERT INTO radicacion_document_entrada( ";
				$cadenaSql .= " fecha_registro,  ";
				$cadenaSql .= " clase_entrada,  ";
				$cadenaSql .= " id_entrada, ";
				$cadenaSql .= " tipo_documento,   ";
				$cadenaSql .= " tipo_contrato,   ";
				$cadenaSql .= " nombre_soporte,   ";
				$cadenaSql .= " enlace_soporte)";
				$cadenaSql .= " VALUES (";
				$cadenaSql .= "'" . $variable [0] . "',";
				$cadenaSql .= "'" . $variable [1] . "',";
				$cadenaSql .= "'" . $variable [2] . "',";
				$cadenaSql .= "'" . $variable [3] . "',";
				$cadenaSql .= "'" . $variable [4] . "',";
				$cadenaSql .= "'" . $variable [5] . "',";
				$cadenaSql .= "'" . $variable [6] . "') ";
				$cadenaSql .= "RETURNING  id_radicacion; ";
				
				break;
			
			case "buscar_entradas" :
				$cadenaSql = " SELECT id_entrada valor,consecutivo||' - ('||entrada.vigencia||')' descripcion  ";
				$cadenaSql .= " FROM entrada; ";
				break;
			
			case "consultarSoportes" :
				$cadenaSql = "SELECT DISTINCT ";
				$cadenaSql .= "rad.*, en.consecutivo||' - ('||en.vigencia||')' entrada,
							     ce.descripcion claseentrada, td.descripcion tipodocumento, tc.descripcion tipocontrato ";
				$cadenaSql .= "FROM radicacion_document_entrada rad ";
				$cadenaSql .= "JOIN entrada en ON en.id_entrada = rad.id_entrada ";
				$cadenaSql .= "JOIN clase_entrada ce ON ce.id_clase = rad.clase_entrada ";
				$cadenaSql .= "JOIN tipo_documento td ON td.id_tipo_documento = rad.tipo_documento ";
				$cadenaSql .= "JOIN tipo_contrato tc ON tc.id_tipo = rad.tipo_contrato ";
				$cadenaSql .= "WHERE 1 = 1 ";
				$cadenaSql .= "AND rad.estado_registro = TRUE ";
				if ($variable ['clase_entrada'] != '') {
					$cadenaSql .= " AND rad.clase_entrada = '" . $variable ['clase_entrada'] . "' ";
				}
				if ($variable ['numero_entrada'] != '') {
					$cadenaSql .= " AND rad.id_entrada = '" . $variable ['numero_entrada'] . "' ";
				}
				if ($variable ['tipo_documento'] != '') {
					$cadenaSql .= " AND rad.tipo_documento = '" . $variable ['tipo_documento'] . "' ";
				}
				
				if ($variable ['fecha_inicial'] != '') {
					$cadenaSql .= " AND rad.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
					$cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
				}
				
				$cadenaSql .= " ; ";
				
				break;
		}
		return $cadenaSql;
	}
}

?>
