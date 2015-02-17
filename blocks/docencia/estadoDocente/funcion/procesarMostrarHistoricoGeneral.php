<?

// var_dump ( $_REQUEST );
// var_dump ( $datos );
$conexion = "docencia2";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

if ($_REQUEST ['seleccioncategoriaT'] != 0) {
	
	if ($_REQUEST ['seleccionfacultadT'] != 0) {
		
		if ($_REQUEST ['seleccionProyectoCurricularT'] != 0) {
			
			$tipo = 'CategoriaT|FacultadT|ProyectoT';
			$cadena = $this->sql->cadena_sql ( "ConsultarCategoriaFacultadProyecto", $_REQUEST ['seleccioncategoriaT'], $_REQUEST ['seleccionfacultadT'], $_REQUEST ['seleccionProyectoCurricularT'] );
			$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
		} else {
			
			$tipo = 'CategoriaT|FacultadT';
			
			$cadena = $this->sql->cadena_sql ( "ConsultarCategoriaFacultad", $_REQUEST ['seleccioncategoriaT'], $_REQUEST ['seleccionfacultadT'] );
			
			$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
		}
	} else if ($_REQUEST ['seleccionProyectoCurricularT'] != 0) {
		
		$tipo = 'CategoriaT|ProyectoT';
		
		$cadena = $this->sql->cadena_sql ( "ConsultarCategoriaProyecto", $_REQUEST ['seleccioncategoriaT'], '', $_REQUEST ['seleccionProyectoCurricularT'] );
		$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
	}
} else if ($_REQUEST ['seleccionfacultadT'] != 0) 

{
	
	if ($_REQUEST ['seleccioncategoriaT'] != 0) 

	{
		
		if ($_REQUEST ['seleccionProyectoCurricularT'] != 0) {
			
			$tipo = 'CategoriaT|FacultadT|ProyectoT';
			$cadena = $this->sql->cadena_sql ( "ConsultarCategoriaFacultadProyecto", $_REQUEST ['seleccioncategoriaT'], $_REQUEST ['seleccionfacultadT'], $_REQUEST ['seleccionProyectoCurricularT'] );
			$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
		} else {
			
			$tipo = 'CategoriaT|FacultadT';
			$cadena = $this->sql->cadena_sql ( "ConsultarCategoriaFacultad", $_REQUEST ['seleccioncategoriaT'], $_REQUEST ['seleccionfacultadT'] );
			$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
		}
	} else if ($_REQUEST ['seleccionProyectoCurricularT'] != 0) {
		
		$tipo = 'FacultadT|ProyectoT';
		$cadena = $this->sql->cadena_sql ( "ConsultarFacultadProyecto", '', $_REQUEST ['seleccionfacultadT'], $_REQUEST ['seleccionProyectoCurricularT'] );
		$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
	}
} else if ($_REQUEST ['seleccionProyectoCurricularT'] != 0) {
	
	if ($_REQUEST ['seleccioncategoriaT'] != 0) 

	{
		
		if ($_REQUEST ['seleccionfacultadT'] != 0) {
			
			$tipo = 'CategoriaT|FacultadT|ProyectoT';
			$cadena = $this->sql->cadena_sql ( "ConsultarCategoriaFacultadProyecto", $_REQUEST ['seleccioncategoriaT'], $_REQUEST ['seleccionfacultadT'], $_REQUEST ['seleccionProyectoCurricularT'] );
			$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
		} else {
			
			$tipo = 'CategoriaT|ProyectoT';
			$cadena = $this->sql->cadena_sql ( "ConsultarCategoriaProyecto", $_REQUEST ['seleccioncategoriaT'], '', $_REQUEST ['seleccionProyectoCurricularT'] );
			$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
		}
	} else if ($_REQUEST ['seleccionProyectoCurricularT'] != 0) {
		
		$tipo = 'FacultadT|ProyectoT';
		$cadena = $this->sql->cadena_sql ( "ConsultarFacultadProyecto", '', $_REQUEST ['seleccionfacultadT'], $_REQUEST ['seleccionProyectoCurricularT'] );
		$registro = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
	}
}

$respuesta = json_encode ( $registro );

if ($registro == false) {
	echo "Se presentó un error en el sistema, contacte al administrador";
	exit ();
}

if ($registro == true) {
	
	$this->funcion->redireccionar ( "historicoGeneral", $respuesta );
} else {
	echo "OOOPS!!!!. DB Engine Access Error";
	exit ();
}

?>