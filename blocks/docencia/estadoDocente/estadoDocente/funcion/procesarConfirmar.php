<?
echo "-->Procesar confirmar";exit;
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {

	
	
	
	$configuracion ['id_sesion'] = "123";
	$conexion = "configuracion";
	$this->cadena_sql = $this->sql->cadena_sql ( "rescatarTemp", "123" );
	// echo $this->cadena_sql ;exit;
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	//var_dump($esteRecursoDB);exit;
	$resultado = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );
	$datosConfirmar = array (
			"numIdentificacion",
			"tipoIdentificacion",
			"nombres",
			"apellidos",
			"genero",
			"fechaNacimiento",
			"paisNacimiento",
			"ciudadNacimiento",
			"codigoInterno",
			"fechaIngreso",
			"resolucionNombramiento",
			"dedicacion",
			"fechaInicioAño",
			"documentoPrueba",
			"documentoFinal",
			"documentoConcepto",
			"facultad",
			"proyectoCurricular",
			"categoriaActual",
			"correoInstitucional",
			"correoPersonal",
			"direccionResidencia",
			"telefonoFijo",
			"telefonoCelular",
			"telefonoadicional",
			"numeroActa",
			"fechaActa",
			"numeroCaso"
			
	);
	// echo "procesar confirmar";
	// var_dump ( $datosConfirmar );
	// exit ();
	
	if ($resultado == null) {
		echo "...Se ha presentado un error...";
		exit ();
	}
	
	$i = 0;
	
	foreach ( $resultado as $key => $value ) {
		$campo = trim ( $value ["campo"] );
		if (in_array ( $campo, $datosConfirmar )) {
			$datos [$campo] = $value ["valor"];
			$i ++;
		}
	}
	$this->guardarRegistro($datos);
}
?>