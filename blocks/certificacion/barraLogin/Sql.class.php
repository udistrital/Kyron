<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlbarraLogin extends sql {
	
	
	var $miConfigurador;
	
	
	function __construct(){
		$this->miConfigurador=Configurador::singleton();
	}
	

	function cadena_sql($tipo,$variable="") {
		 
		/**
		 * 1. Revisar las variables para evitar SQL Injection
		 *
		 */
		
		$prefijo=$this->miConfigurador->getVariableConfiguracion("prefijo");
		$idSesion=$this->miConfigurador->getVariableConfiguracion("id_sesion");
		 
		switch($tipo) {
			 
			/**
			 * Clausulas específicas
			 */
			 
			case "buscarUsuario":
				$cadena_sql="SELECT ";
				$cadena_sql.="CLA_CODIGO, ";
                                $cadena_sql.="CLA_CLAVE, ";
                                $cadena_sql.="CLA_TIPO_USU, ";
                                $cadena_sql.="CLA_ESTADO ";
				$cadena_sql.="FROM ";
				$cadena_sql.="GECLAVES ";
				$cadena_sql.="WHERE ";
                                $cadena_sql.="CLA_CODIGO ='".$variable["usuario"]."' ";
                                $cadena_sql.="AND ";
                                $cadena_sql.="CLA_CLAVE ='".$variable["clave"]."' ";
				break;


			case "setIngresoLog":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo."registradoConferencia ";
				$cadena_sql.="( ";
				$cadena_sql.="`idRegistrado`, ";
				$cadena_sql.="`nombre`, ";
				$cadena_sql.="`apellido`, ";
				$cadena_sql.="`identificacion`, ";
				$cadena_sql.="`codigo`, ";
				$cadena_sql.="`correo`, ";
				$cadena_sql.="`tipo`, ";
				$cadena_sql.="`fecha` ";
				$cadena_sql.=") ";
				$cadena_sql.="VALUES ";
				$cadena_sql.="( ";
				$cadena_sql.="NULL, ";
				$cadena_sql.="'".$variable['nombre']."', ";
				$cadena_sql.="'".$variable['apellido']."', ";
				$cadena_sql.="'".$variable['identificacion']."', ";
				$cadena_sql.="'".$variable['codigo']."', ";
				$cadena_sql.="'".$variable['correo']."', ";
				$cadena_sql.="'0', ";
				$cadena_sql.="'".time()."' ";
				$cadena_sql.=")";
				break;

			case "iniciarTransaccion":
				$cadena_sql="START TRANSACTION";
				break;

			case "finalizarTransaccion":
				$cadena_sql="COMMIT";
				break;

			case "cancelarTransaccion":
				$cadena_sql="ROLLBACK";
				break;


			case "eliminarTemp":

				$cadena_sql="DELETE ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."tempFormulario ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_sesion = '".$variable."' ";
				break;

		}
		//echo $cadena_sql;
		return $cadena_sql;

	}
}
?>
