<?php

namespace asignacionPuntajes\salariales\direccionTrabajosDeGrado\funcion;

use asignacionPuntajes\salariales\direccionTrabajosDeGrado\funcion\redireccionar;

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
		
		$_REQUEST['numeroAutores'] = 0;
		
		for($i=1; $i<=3; $i++){
			if($_REQUEST['nombreEstudiante' . $i] != "" && $_REQUEST['codigoEstudiante' . $i]){
				$_REQUEST['numeroAutores']++;
			}
		}
		//Se consultan los estudiantes en la base de datos para comparar con lo que se desean regsitrar
		$cadena_sql = $this->miSql->getCadenaSql ( "publicacionEstudiantesActualizar", $_REQUEST['identificadorDireccion'] );
		$estudiantes = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
		
		for($i=0; $i<count($estudiantes); $i++){
			$existeEstudiante = 0;
			for($j=1; $j<=3; $j++){
				if(!($estudiantes[$i]['nombre_estudiante']== $_REQUEST['nombreEstudiante'.$j] && $estudiantes[$i]['codigo_estudiante']== $_REQUEST['codigoEstudiante'.$j])){
					if($estudiantes[$i]['nombre_estudiante']== $_REQUEST['nombreEstudiante'.$j] || $estudiantes[$i]['codigo_estudiante']== $_REQUEST['codigoEstudiante'.$j]){
						$arregloEstudiante = array (
								'id_direccion_trabajogrado' => $_REQUEST['identificadorDireccion'],
								'old_nombre_estudiante' => $estudiantes[$i]['nombre_estudiante'],
								'old_codigo_estudiante' => $estudiantes[$i]['codigo_estudiante'],
								'nombre_estudiante' => $_REQUEST['nombreEstudiante'.$j],
								'codigo_estudiante' => $_REQUEST['codigoEstudiante'.$j]
						);
							
						$cadenaSql = $this->miSql->getCadenaSql ( 'actualizarEstudiante', $arregloEstudiante );
						$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );
						$existeEstudiante++;
					}else{
						$arregloEstudiante = array (
								'id_direccion_trabajogrado' => $_REQUEST['identificadorDireccion'],
								'nombre_estudiante' => $_REQUEST['nombreEstudiante'.$j],
								'codigo_estudiante' => $_REQUEST['codigoEstudiante'.$j]
						);
							
						$cadenaSql = $this->miSql->getCadenaSql ( 'registroEstudiantes', $arregloEstudiante );
						$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "insertar" );						
					}
				}else{
					$existeEstudiante++;
				}
			}
			if($existeEstudiante==0){
				$arregloEstudiante = array (
						'id_direccion_trabajogrado' => $_REQUEST['identificadorDireccion'],
						'old_nombre_estudiante' => $estudiantes[$i]['nombre_estudiante'],
						'old_codigo_estudiante' => $estudiantes[$i]['codigo_estudiante']						
				);
					
				$cadenaSql = $this->miSql->getCadenaSql ( 'actualizarEstudianteEliminar', $arregloEstudiante );
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );
			}
		}

		$arregloDatos = array (
			'id_docenteRegistrar' => $_REQUEST['id_docenteRegistrar'],
			'tituloTrabajo' => $_REQUEST['nombre'],
			'anno' => $_REQUEST['anno'],
			'tipoTrabajo' => $_REQUEST['tipo'],
			'categoriaTrabajo' => $_REQUEST['categoria'],
			'numeroAutores' => $_REQUEST['numeroAutores'],
			'numeroActa' => $_REQUEST['numeroActa'],
			'fechaActa' => $_REQUEST['fechaActa'],
			'numeroCasoActa' => $_REQUEST['numeroCasoActa'],
			'puntaje' => $_REQUEST['puntaje'],
			'id_direccion_trabajo' => $_REQUEST['identificadorDireccion']
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'actualizar', $arregloDatos );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );

		if ($resultado) {
			redireccion::redireccionar ( 'actualizo',  $_REQUEST['docenteRegistrar']);
			exit ();
		} else {
			redireccion::redireccionar ( 'noActualizo',  $_REQUEST['docenteRegistrar'] );
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
