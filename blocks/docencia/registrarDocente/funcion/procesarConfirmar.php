<?



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
			"numeroCaso",
			"fechaSistema",
			"estadoRegistro"			
	);
	
	
	$resolucion = array (
			
			"nombre",
			"ruta",
			"formato",
			"autor"			

			
	);
	
	$resolucion["nombre"]="Cualquier nombre";
	$resolucion["ruta"]="/usr/local/apache/htdocs/Resolucion.pdf";
	$resolucion["formato"]="pdf";
	$resolucion["autor"]="Stiv Verdugo";
	

	
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
  $datos["fechaSistema"]= date("d/m/Y");
  $datos["estadoRegistro"]=1;
  

 	
 	if($datos["documentoPrueba"]){
 		$documentos[1]["nombre"]="documentoprueba";
 		$documentos[1]["ruta"]="/sdf/sdf/safd";
 		$documentos[1]["formato"]="pdf";
 		$documentos[1]["autor"]="stiv";
 		$documentos[1]["tipo"]=1;
 	
 	}
 	
 	if($datos["documentoFinal"]){
 		$documentos[2]["nombre"]="documentofinal";
 		$documentos[2]["ruta"]="/sdf/sdf/safd";
 		$documentos[2]["formato"]="pdf";
 		$documentos[2]["autor"]="stiv";
 		$documentos[2]["tipo"]=2;
 	
 	}
 	
 	if($datos["documentoConcepto"]){
 		$documentos[3]["nombre"]="documentoconcepto";
 		$documentos[3]["ruta"]="/sdf/sdf/safd";
 		$documentos[3]["formato"]="pdf";
 		$documentos[3]["autor"]="stiv";
 		$documentos[3]["tipo"]=3;
 	
 	}
 	

  
  $this->guardarRegistro($datos, $resolucion, $documentos);
}
?>