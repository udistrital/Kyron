<?php

namespace asignacionPuntajes\salariales\indexacionRevistas\funcion;

use asignacionPuntajes\salariales\indexacionRevistas\funcion\redireccionar;

include_once ('redireccionar.php');
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class RegistrarIndexacionRevista {
	
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miFuncion;
	var $miSql;
	var $conexion;
	
	function __construct($lenguaje, $sql, $funcion) {
		
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
		$this->miFuncion = $funcion;
	}
	function procesarFormulario() {

		$conexion = "docencia";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/asignacionPuntajes/salariales/";
		$rutaBloque .= $esteBloque ['nombre'];
		$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/asignacionPuntajes/salariales/" . $esteBloque ['nombre'];
		
// 		var_dump($_REQUEST);
// 		$fechaActual = date ( 'Y-m-d' );
		
// 		$fechaReinicio = date ( "Y-m-d", mktime ( 0, 0, 0, 1, 1, date ( 'Y' ) ) );
		
// 		if ($fechaActual == $fechaReinicio) {
			
// 			$cadenaSql = $this->miSql->getCadenaSql ( 'consultaConsecutivo', $fechaReinicio );
// 			$consecutivo = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
			
// 			if (isset ( $consecutivo ) && $consecutivo == false) {
// 				$cadenaSql = $this->miSql->getCadenaSql ( 'reiniciarConsecutivo' );
// 				$consecutivo = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso" );
// 			}
// 		}
		
// 		$i = 0;
		
// 		switch ($_REQUEST ['clase']) {
			
// 			case '1' :
				
// 				// $observacion = $_REQUEST ['observaciones_reposicion'];
// 				$entrada = $_REQUEST ['id_entradaR'];
// 				$salida = $_REQUEST ['id_salidaR'];
				
// 				break;
			
// 			case '2' :
// 				// $observacion = $_REQUEST ['observaciones_donacion'];
// 				foreach ( $_FILES as $key => $values ) {
					
// 					$archivo [$i] = $_FILES [$key];
// 					$i ++;
// 				}
				
// 				$archivo = $archivo [0];
				
// 				$_REQUEST ['fecha_contrato'] = '';
// 				$_REQUEST ['numero_contrato'] = '';
// 				$_REQUEST ['tipo_contrato'] = '';
				
// 				break;
			
// 			case '3' :
				
// 				// $observacion = $_REQUEST ['observaciones_sobrante'];
// 				// $entrada = $_REQUEST ['id_entradaS'];
// 				// $salida = $_REQUEST ['id_salidaS'];
				
// 				foreach ( $_FILES as $key => $values ) {
					
// 					$archivo [$i] = $_FILES [$key];
// 					$i ++;
// 				}
				
// 				$archivo = $archivo [1];
// 				$_REQUEST ['id_ordenador'] = '';
// 				$_REQUEST ['tipo_ordenador'] = '';
// 				$_REQUEST ['identificacion_ordenador']='';
// 				$_REQUEST ['id_proveedor'] = '';
// 				$_REQUEST ['fecha_contrato'] = '';
// 				$_REQUEST ['numero_contrato'] = '';
// 				$_REQUEST ['tipo_contrato'] = '';
// 				$_REQUEST ['numero_factura'] = '';
// 				$_REQUEST ['fecha_factura'] = '';
// 				break;
			
// 			case '4' :
// 				// $observacion = $_REQUEST ['observaciones_produccion'];
// 				foreach ( $_FILES as $key => $values ) {
					
// 					$archivo [$i] = $_FILES [$key];
// 					$i ++;
// 				}
				
// 				$archivo = $archivo [2];
				
// 				$_REQUEST ['id_proveedor'] = '';
// 				$_REQUEST ['fecha_contrato'] = '';
// 				$_REQUEST ['numero_contrato'] = '';
// 				$_REQUEST ['tipo_contrato'] = '';
// 				$_REQUEST ['numero_factura'] = '';
// 				$_REQUEST ['fecha_factura'] = '';
				
// 				break;
			
// 			case '5' :
				
// 				// $observacion = $_REQUEST ['observaciones_recuperacion'];
// 				foreach ( $_FILES as $key => $values ) {
					
// 					$archivo [$i] = $_FILES [$key];
// 					$i ++;
// 				}
				
// 				$archivo = $archivo [3];
				
// 				$_REQUEST ['id_proveedor'] = '';
// 				$_REQUEST ['fecha_contrato'] = '';
// 				$_REQUEST ['numero_contrato'] = '';
// 				$_REQUEST ['tipo_contrato'] = '';
// 				$_REQUEST ['numero_factura'] = '';
// 				$_REQUEST ['fecha_factura'] = '';
				
				
// 				break;
			
// 			case '6' :
				
// 				// $observacion = $_REQUEST ['observaciones_adquisicion'];
// 				foreach ( $_FILES as $key => $values ) {
					
// 					$archivo [$i] = $_FILES [$key];
// 					$i ++;
// 				}
				
// 				$archivo = $archivo [4];
// 				break;
			
// 			// $observacion = $_REQUEST ['observaciones_avance'];
// 			case '7' :
// 				foreach ( $_FILES as $key => $values ) {
					
// 					$archivo [$i] = $_FILES [$key];
// 					$i ++;
// 				}
				
// 				$archivo = $archivo [5];
				
// 				$_REQUEST ['fecha_contrato'] = '';
// 				$_REQUEST ['numero_contrato'] = '';
// 				$_REQUEST ['tipo_contrato'] = '';
				
				
// 				break;
// 		}
		
// 		if (isset ( $archivo )) {
// 			// obtenemos los datos del archivo
// 			$tamano = $archivo ['size'];
// 			$tipo = $archivo ['type'];
// 			$archivo1 = $archivo ['name'];
// 			$prefijo = substr ( md5 ( uniqid ( rand () ) ), 0, 6 );
			
// 			if ($archivo1 != "") {
// 				// guardamos el archivo a la carpeta files
// 				$destino1 = $rutaBloque . "/actas/" . $prefijo . "_" . $archivo1;
// 				if (copy ( $archivo ['tmp_name'], $destino1 )) {
// 					$status = "Archivo subido: <b>" . $archivo1 . "</b>";
// 					$destino1 = $host . "/actas/" . $prefijo . "_" . $archivo1;
// 				} else {
// 					$status = "Error al subir el archivo 1";
// 				}
// 			} else {
// 				$status = "Error al subir archivo 2";
// 			}
			
// 			$arreglo = array (
// 					$destino1,
// 					$archivo1 
// 			);
// 		}
		
// 		$arreglo_clase = array (
// 				$observacion = 'NULL',
// 				(isset ( $entrada )) ? $entrada : 0,
// 				(isset ( $salida )) ? $salida : 0,
// 				($_REQUEST ['clase'] == 1) ? $_REQUEST ['id_hurtoR'] : 0,
// 				0,
// 				0,
// 				(isset ( $destino1 )) ? $destino1 : 'NULL',
// 				(isset ( $archivo1 )) ? $archivo1 : 'NULL' 
// 		);
		
// 		$cadenaSql = $this->miSql->getCadenaSql ( 'insertarInformación', $arreglo_clase );
// 		$info_clase = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		
// 		$cadenaSql = $this->miSql->getCadenaSql ( 'idMaximoEntrada' );
// 		$idEntradamax = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		
// 		$idEntradamax = $idEntradamax [0] [0] + 1;
		
// 		$fechaActual = date ( 'Y-m-d' );
// 		$anio_vigencia = date ( 'Y' );
		
// 		$arregloDatos = array (
// 				$fechaActual,
// 				$anio_vigencia,
// 				$_REQUEST ['clase'],
// 				$info_clase [0] [0],
// 				($_REQUEST ['tipo_contrato'] != '') ? $_REQUEST ['tipo_contrato'] : NULL,
// 				($_REQUEST ['numero_contrato'] != '') ? $_REQUEST ['numero_contrato'] : NULL,
// 				($_REQUEST ['fecha_contrato'] != '') ? $_REQUEST ['fecha_contrato'] : NULL,
// 				($_REQUEST ['id_proveedor'] != '') ? $_REQUEST ['id_proveedor'] : NULL, // donacion
// 				($_REQUEST ['numero_factura'] != '') ? $_REQUEST ['numero_factura'] : NULL, // donacion
// 				($_REQUEST ['fecha_factura'] != '') ? $_REQUEST ['fecha_factura'] : NULL, // donacion
// 				$_REQUEST ['observaciones_entrada'],
// 				$_REQUEST ['numero_acta'],
// 				($_REQUEST ['id_ordenador'] == '') ? NULL : $_REQUEST ['id_ordenador'], // obligatorio donacion
// 				$_REQUEST ['sede'], // obligatorio
// 				$_REQUEST ['dependencia'], // obligatorio
// 				$_REQUEST ['supervisor'],
// 				($_REQUEST ['tipo_ordenador'] == '') ? NULL : $_REQUEST ['tipo_ordenador'], // obligatorio donacion
// 				($_REQUEST ['identificacion_ordenador'] == '') ? NULL : $_REQUEST ['identificacion_ordenador'], // obligatorio donacion
// 				$idEntradamax 
// 		);
// 		var_dump($_REQUEST);exit;
		$arregloDatos = array (
			$_REQUEST['id_docenteRegistrar'],
			$_REQUEST['nombreRevista'],
			$_REQUEST['contextoRevista'],
			$_REQUEST['pais'],
			$_REQUEST['categoria'],
			$_REQUEST['issnRevista'],
			$_REQUEST['annoRevista'],
			$_REQUEST['volumenRevista'],
			$_REQUEST['numeroRevista'],
			$_REQUEST['paginasRevista'],
			$_REQUEST['tituloArticuloRevista'],
			$_REQUEST['numeroAutoresRevista'],
			$_REQUEST['numeroAutoresUniversidad'],
			$_REQUEST['fechaPublicacionrevista'],
			$_REQUEST['numeroActaRevista'],
			$_REQUEST['fechaActaRevista'],
			$_REQUEST['numeroCasoActaRevista'],
			$_REQUEST['puntajeRevistas']
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'insertarIndexacion', $arregloDatos );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "insertar" );

		if ($resultado) {
			redireccion::redireccionar ( 'inserto',  $_REQUEST['docenteRegistrar']);
			exit ();
		} else {
			redireccion::redireccionar ( 'noInserto' );
			exit ();
		}
	}
	
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}

$miRegistrador = new RegistrarIndexacionRevista ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();

?>
