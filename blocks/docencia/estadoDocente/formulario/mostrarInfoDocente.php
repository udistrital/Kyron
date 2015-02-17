<?
echo " mostrar Info Docente Formulario->";
//  var_dump($_REQUEST);exit;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
// ECHO "LLEGAMOS";exit;
// var_dump($_REQUEST);exit;
$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
$nombreFormulario = $esteBloque ["nombre"];

$indice = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";
$conexion = "docencia2";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
$cadena_sql1 = $this->sql->cadena_sql ( "Consultar Estado Docente", $_REQUEST ['datos'] );
$cadena_sql2 = $this->sql->cadena_sql ( "Consultar Nombre Docente", $_REQUEST ['datos'] );

$resultado1 = $esteRecursoDB->ejecutarAcceso ( $cadena_sql1, "busqueda" );
$resultado2 = $esteRecursoDB->ejecutarAcceso ( $cadena_sql2, "busqueda" );

$datosConfirmar = array (
		"Nombre" => $resultado2 [0] ['nombre'],
		"EstadoActual" => $resultado1 [0] ['estado'],
		"EstadoComplementario" => $resultado1 [0] ['estadocomplentario'],
		"DocumentoSoporte" => $resultado1 [0] ['documentosoporte'],
		"FechaInicio" => $resultado1 [0] ['fechainicio'],
		"FechaTerminacion" => $resultado1 [0] ['fechaterminacion'] 
);



include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton ();
// $valorCodificado ="pagina=registrarDocente";
$valorCodificado = "action=" . $esteBloque ["nombre"];
$valorCodificado .= "&solicitud=procesarMostrarInfoDocente";
$valorCodificado .= "&datos=".$_REQUEST['datos'];
$valorCodificado .= "&bloque=" . $esteBloque ["nombre"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );

$tab = 1;

$conexion = "docencia2";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
$cadena_sql1 = $this->sql->cadena_sql ( "Consultar Estado Docente", $_REQUEST ['datos'] );
$cadena_sql2 = $this->sql->cadena_sql ( "Consultar Nombre Docente", $_REQUEST ['datos'] );

$resultado1 = $esteRecursoDB->ejecutarAcceso ( $cadena_sql1, "busqueda" );
$resultado2 = $esteRecursoDB->ejecutarAcceso ( $cadena_sql2, "busqueda" );

$datosConfirmar = array (
		"Nombre" => $resultado2 [0] ['nombre'],
		"EstadoActual" => $resultado1 [0] ['estado'],
		"EstadoComplementario" => $resultado1 [0] ['estadocomplentario'],
		"DocumentoSoporte" => $resultado1 [0] ['documentosoporte'],
		"FechaInicio" => $resultado1 [0] ['fechainicio'],
		"FechaTerminacion" => $resultado1 [0] ['fechaterminacion'] 
);

//  var_dump($datosConfirmar);exit;

// var_dump($resultado);exit;
$totalRegistros = $esteRecursoDB->getConteo ();

// if ($totalRegistros > 0) {

// for($i = 0; $i < $totalRegistros; $i ++) {

// $variable [trim ( $resultado [$i] ["campo"] )] = $resultado [$i] ["valor"];
// }
// echo "AdasdasDada";
// var_dump($variable);exit;

// ------------------Division General-------------------------
$atributos ["id"] = "";

// Formulario para nuevos registros de usuario
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["estilo"] = "formularioConJqgrid";
$atributos ["nombreFormulario"] = $esteBloque ["nombre"];
echo $this->miFormulario->marcoFormulario ( "inicio", $atributos );

// -----------------Inicio de Conjunto de Controles----------------------------------------
$esteCampo = "marcoDatosBasicos";
$atributos ["estilo"] = "jqueryui";
$atributos ["leyenda"] = $datosConfirmar ['Nombre'];
echo $this->miFormulario->marcoAGrupacion ( "inicio", $atributos );
unset ( $atributos );

// -------------Control cuadroTexto-----------------------
{
	$esteCampo = "estado";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	// ****************************** Invento *****************************************
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->sql->cadena_sql ( "Consultar Nombre Estado", $datosConfirmar ['EstadoActual'] );
	$solicitud_tip = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
	$solicitud_tip = $solicitud_tip [0];
	/**
	 * **************************************************************************
	 */
	$atributos ["texto"] = strtolower ( $solicitud_tip [0] );
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
}
// -------------Control cuadroTexto-----------------------
{
	$esteCampo = "estadoComplementario";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	// ****************************** Invento *****************************************
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->sql->cadena_sql ( "Consultar Nombre Estado Complementario", $datosConfirmar ['EstadoComplementario'] );
	$solicitud_tip = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
	$solicitud_tip = $solicitud_tip [0];
	/**
	 * **************************************************************************
	 */
	$atributos ["texto"] = strtolower ( $solicitud_tip [0] );
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
}


{ // -------------Control cuadroTexto-----------------------
	$esteCampo = "DocSoporte";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	// ****************************** Invento *****************************************
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->sql->cadena_sql ( "Consultar Nombre Documento Soporte", $datosConfirmar ['DocumentoSoporte'] );
	$solicitud_tip = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
	$solicitud_tip = $solicitud_tip [0];
	/**
	 * **************************************************************************
	 */
	$atributos ["texto"] = strtolower ( $solicitud_tip [0] );
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
}

{ // -------------Control cuadroTexto-----------------------
	$esteCampo = "FechaInicio";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $datosConfirmar [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
}

{ // -------------Control cuadroTexto-----------------------
	$esteCampo = "FechaTerminacion";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $datosConfirmar [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
}

{
	$atributos ["id"] = "botones";
	$atributos ["estilo"] = "marcoBotones";
	echo $this->miFormulario->division ( "inicio", $atributos );
	
	{ // -------------Control Boton-----------------------
		$esteCampo = "botonModificarEstado";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["tipo"] = "boton";
		$atributos ["estilo"] = "";
		$atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
		$atributos ["tipoSubmit"] = "jquery"; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
		$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["nombreFormulario"] = $nombreFormulario;
		echo $this->miFormulario->campoBoton ( $atributos );
		unset ( $atributos );
	} // -------------Fin Control Boton----------------------
	
	{
		$esteCampo = "botonCambiarEstado";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["tipo"] = "boton";
		$atributos ["estilo"] = "";
		$atributos ["verificar"] = "true"; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
		$atributos ["tipoSubmit"] = "jquery"; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
		$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["nombreFormulario"] = $nombreFormulario;
		echo $this->miFormulario->campoBoton ( $atributos );
		unset ( $atributos );
	} // -------------Fin Control Boton----------------------
	  
	// ------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division ( "fin" );
}
// -------------Control cuadroTexto con campos ocultos-----------------------
$atributos ["id"] = "formSaraData";
$atributos ["tipo"] = "hidden";
$atributos ["etiqueta"] = "";
$atributos ["valor"] = $valorCodificado;
echo $this->miFormulario->campoCuadroTexto ( $atributos );

// -------------------Fin Division-------------------------------
echo $this->miFormulario->marcoFormulario ( "fin", $atributos );

// ----------Grilla con lo elementos
?>