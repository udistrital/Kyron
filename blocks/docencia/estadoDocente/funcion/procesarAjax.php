<?php
if (isset ( $_REQUEST ['numIdentificacion'] )) {
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena = $this->sql->cadena_sql ( "ConsultarNumIdentificacion", $_REQUEST ['numIdentificacion'] );
	$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
	$respuesta = json_encode ( $registro );
	echo $respuesta;
} else if (isset ( $_REQUEST ['Categoria'] )) {
	
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena = $this->sql->cadena_sql ( "ConsultarCategoria", $_REQUEST ['Categoria'] );
	$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
	$respuesta = json_encode ( $registro );
	echo $respuesta;
} else if (isset ( $_REQUEST ['Facultad'] )) {
	
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena = $this->sql->cadena_sql ( "ConsultarFacultad", $_REQUEST ['Facultad'] );
	$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
	$respuesta = json_encode ( $registro );
	echo $respuesta;
} else if (isset ( $_REQUEST ['PrCurricular'] )) {
	
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena = $this->sql->cadena_sql ( "ConsultarProyectoCurricular", $_REQUEST ['PrCurricular'] );
	$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
	$respuesta = json_encode ( $registro );
	echo $respuesta;
} else if (isset ( $_REQUEST ['CategoriaT'] ) and isset ( $_REQUEST ['FacultadT'] ) and isset ( $_REQUEST ['ProyectoT'] )) {
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena = $this->sql->cadena_sql ( "ConsultarCategoriaFacultadProyecto", $_REQUEST ['CategoriaT'], $_REQUEST ['FacultadT'], $_REQUEST ['ProyectoT'] );
	$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
	$respuesta = json_encode ( $registro );
	echo $respuesta;
} else if (isset ( $_REQUEST ['CategoriaT'] ) and isset ( $_REQUEST ['FacultadT'] )) {
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena = $this->sql->cadena_sql ( "ConsultarCategoriaFacultad", $_REQUEST ['CategoriaT'], $_REQUEST ['FacultadT'] );
	$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
	$respuesta = json_encode ( $registro );
	echo $respuesta;
}else if (isset ( $_REQUEST ['CategoriaT'] ) and isset ( $_REQUEST ['ProyectoT'] )) {
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena = $this->sql->cadena_sql ( "ConsultarCategoriaProyecto", $_REQUEST ['CategoriaT'], '', $_REQUEST ['ProyectoT'] );
	$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
	$respuesta = json_encode ( $registro );
	echo $respuesta;
}else if (isset ( $_REQUEST ['FacultadT'] ) and isset ( $_REQUEST ['ProyectoT'] )) {
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena = $this->sql->cadena_sql ( "ConsultarFacultadProyecto", '' ,$_REQUEST ['FacultadT'], $_REQUEST ['ProyectoT'] );
	$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
	$respuesta = json_encode ( $registro );
	echo $respuesta;
}


?>