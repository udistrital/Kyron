<?php

namespace cargaMasiva\funcion;

use cargaMasiva\funcion\redireccionar;

include_once ('redireccionar.php');
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class EliminarRegistro {
	
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
		
		//$cadenaSql.=" llaves_primarias_valor ='" . $variable ['llaves_primarias_valor'] . "'";
		//var_dump($_REQUEST);
		$tabla = $_REQUEST['tabla'];
		$tabla = str_replace('\\\_', '_', $tabla);
		
		$condicion = $_REQUEST['condicion'];
		$condicion = str_replace('\\\_', '_', $condicion);
		$arregloDatos = array (
			'tabla' => $tabla,
			'condicion' => $condicion
		);
		
		//var_dump($arregloDatos);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'eliminar_de_tabla', $arregloDatos );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );
		
		if (!$resultado) {
			//Si la consulta falla, se intenta eliminar registros conexos.
			$prellaves = explode(" AND ", $condicion);
			$condicion_column_name = '';
			$llaves = array();
			foreach( $prellaves as $key => $value ){
				$arreglo = explode('=', $value);
				$llaves[$arreglo[0]] = $arreglo[1];
				$condicion_column_name .= "column_name='" . $arreglo[0] . "' OR ";
			}
			
			$condicion_column_name = substr($condicion_column_name, 0, -4);//Quita el ultimo ' OR '
			
			$arregloDatos2 = array (
				'tabla' => $tabla,
				'condicion_column_name' => $condicion_column_name
			);

			$cadenaSql = $this->miSql->getCadenaSql ( 'tablas_restricciones_de_tabla', $arregloDatos2 );
			$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
				
			if ($resultado) {
				//retorno muchas tablas
				for($i = 0; $i < count ( $resultado ); $i ++) {
					//Elimina los resultados en las tablas.
					$tabla2 = $resultado[$i]['table_name'];
					
					$arregloDatos2 = array (
							'tabla' => $tabla2,
							'condicion' => $condicion
					);
					$cadenaSql = $this->miSql->getCadenaSql ( 'eliminar_de_tabla', $arregloDatos2 );
					$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'actualizar' );
					if (!$resultado) {
						// Si esta eliminacion falló.
						redireccion::redireccionar ( 'noActualizo', $condicion_column_name );
						exit ();
					}
				}

				//Despues de eliminar las restricciones re intenta eliminar
				$cadenaSql = $this->miSql->getCadenaSql ( 'eliminar_de_tabla', $arregloDatos );
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );				
			} else {
			    // Si aún el resultado es que NO puede eliminarlo, porque NO encontró tablas, se intenta con otro tipo de búsqueda de relaciones
			    $cadenaSql = $this->miSql->getCadenaSql ( 'tablas_restricciones_de_tabla_2', $tabla );
			    $resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
			    if ($resultado) {
			        //retorno muchas tablas
			        for($i = 0; $i < count ( $resultado ); $i ++) {
			            //Elimina los resultados en las tablas.
			            $tabla2 = $resultado[$i]['table_name'];
			            $column_name2 = $resultado[$i]['column_name'];
			            $foreign_column_name = $resultado[$i]['foreign_column_name'];
			            $condicion2 = str_replace($foreign_column_name, $column_name2, $condicion);
			            $arregloDatos2 = array (
			                'tabla' => $tabla2,
			                'condicion' => $condicion2
			            );
			            $cadenaSql = $this->miSql->getCadenaSql ( 'eliminar_de_tabla', $arregloDatos2 );
			            $resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'actualizar' );
			            if (!$resultado) {
			                // Si esta eliminacion falló.
			                redireccion::redireccionar ( 'noActualizo', $condicion_column_name );
			                exit ();
			            }
			            //Despues de eliminar las restricciones por SEGUNDA vez re intenta eliminar
			            $cadenaSql = $this->miSql->getCadenaSql ( 'eliminar_de_tabla', $arregloDatos );
			            $resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );	
			        }
			    } else {
			        //no retorno tablas
			        redireccion::redireccionar ( 'noActualizo', $condicion );
			        exit ();
			    }
			    
				//no retorno tablas
				redireccion::redireccionar ( 'noActualizo', $condicion );
				exit ();
			}
		}
		
		if ($resultado) {
			redireccion::redireccionar ( 'actualizo',  $condicion );
			exit ();
		} else {
			redireccion::redireccionar ( 'noActualizo', $condicion );
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

$miRegistrador = new EliminarRegistro ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();

?>
