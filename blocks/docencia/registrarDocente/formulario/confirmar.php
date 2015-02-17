<?


if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
$nombreFormulario = $esteBloque ["nombre"];

$indice = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";

include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton ();
// $valorCodificado ="pagina=registrarDocente";
$valorCodificado = "action=" . $esteBloque ["nombre"];
$valorCodificado .= "&solicitud=procesarConfirmar";
$valorCodificado .= "&bloque=" . $esteBloque ["nombre"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );

$tab = 1;

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
		"documentoResolucion",
		"dedicacion",
		"fechaInicioAño",
		"documentoPrueba",
		"documentoFinal",
		"documentoConcepto",
		"facultad",
		"proyectoCurricular",
		"categoriaActual",
		"correoInstitucional",
		"direccionResidencia",
		"telefonoFijo",
		"telefonoCelular",
		"telefonoadicional",
		"numeroActa",
		"fechaActa",
		"numeroCaso" 
);

$conexion = "configuracion";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
$cadena_sql = $this->sql->cadena_sql ( "rescatarTemp", "123" );
$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

$totalRegistros = $esteRecursoDB->getConteo ();

if ($totalRegistros > 0) {
	
	for($i = 0; $i < $totalRegistros; $i ++) {
		
		$variable [trim ( $resultado [$i] ["campo"] )] = $resultado [$i] ["valor"];
	}
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
	
	// -------------------------------Mensaje-------------------------------------
	$esteCampo = "mensajeConfirmar";
	$atributos ["id"] = "mensaje"; // Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
	$atributos ["etiqueta"] = "";
	$atributos ["estilo"] = "";
	$atributos ["tipo"] = "validation";
	$atributos ["mensaje"] = $this->lenguaje->getCadena ( $esteCampo );
	echo $this->miFormulario->cuadroMensaje ( $atributos );
	
	// ------------------Division para los botones-------------------------
	$atributos ["id"] = "botones";
	$atributos ["estilo"] = "marcoBotones";
	echo $this->miFormulario->division ( "inicio", $atributos );
	
	// -------------Control Boton-----------------------
	$esteCampo = "botonAceptar";
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
	// -------------Fin Control Boton----------------------
	


	// -------------Control Boton-----------------------
	$esteCampo = "botonEditar";
	$atributos ["verificar"] = "";
	$atributos ["tipo"] = "boton";
	$atributos ["id"] = $esteCampo;
	$atributos ["cancelar"] = "false";
	$atributos ["tabIndex"] = $tab ++;
	$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["nombreFormulario"] = $nombreFormulario;
	echo $this->miFormulario->campoBoton ( $atributos );
	unset ( $atributos );
	// -------------Fin Control Boton----------------------
	
	
	
	
	// -------------Control Boton-----------------------
	$esteCampo = "botonCancelar";
	$atributos ["verificar"] = "";
	$atributos ["tipo"] = "boton";
	$atributos ["id"] = $esteCampo;
	$atributos ["cancelar"] = "true";
	$atributos ["tabIndex"] = $tab ++;
	$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["nombreFormulario"] = $nombreFormulario;
	echo $this->miFormulario->campoBoton ( $atributos );
	unset ( $atributos );
	// -------------Fin Control Boton----------------------
	
	// ------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division ( "fin" );
	
	// -------------Mostrar Datos a Confirmar-----------------------
	
	// En este caso se va a mostrar un formulario de confirmación estilizado
	// en otros casos es más adecuado mostrar los datos como un listado.
	
	// -----------------Inicio de Conjunto de Controles----------------------------------------
	$esteCampo = "marcoDatosBasicos";
	$atributos ["estilo"] = "jqueryui";
	$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
	echo $this->miFormulario->marcoAGrupacion ( "inicio", $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "numIdentificacion";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "tipoIdentificacion";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	// ****************************** Invento *****************************************
	$conexion = "docencia";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->sql->cadena_sql ( "consultarIdentificacion", $variable [$esteCampo] );
	$solicitud_tip = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
	$solicitud_tip = $solicitud_tip [0];
	/**
	 * **************************************************************************
	 */
	$atributos ["texto"] = strtolower ( $solicitud_tip [1] );
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "nombres";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "apellidos";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "genero";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	// ****************************** Invento *****************************************
	$conexion = "docencia";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->sql->cadena_sql ( "consultarGenero", $variable [$esteCampo] );
	// var_dump($cadena_sql);exit;
	$solicitud_tip = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
	$solicitud_tip = $solicitud_tip [0];
	/**
	 * **************************************************************************
	 */
	$atributos ["texto"] = strtolower ( $solicitud_tip [1] );
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "fechaNacimiento";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "paisNacimiento";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	// ****************************** Invento *****************************************
	$conexion = "docencia";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->sql->cadena_sql ( "consultarpaisNacimiento", $variable [$esteCampo] );
	// var_dump($cadena_sql);exit;
	$solicitud_tip = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
	$solicitud_tip = $solicitud_tip [0];
	/**
	 * **************************************************************************
	 */
	$atributos ["texto"] = strtolower ( $solicitud_tip [1] );
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "ciudadNacimiento";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	// ****************************** Invento *****************************************
	$conexion = "docencia";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->sql->cadena_sql ( "consultarciudadNacimiento", $variable [$esteCampo] );
	$solicitud_tip = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
	$solicitud_tip = $solicitud_tip [0];
	/**
	 * **************************************************************************
	 */
	$atributos ["texto"] = strtolower ( $solicitud_tip [1] );
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	// Fin de Conjunto de Controles
	echo $this->miFormulario->marcoAGrupacion ( "fin" );
	
	// -----------------Inicio de Conjunto de Controles----------------------------------------
	$esteCampo = "marcoDocentes";
	$atributos ["estilo"] = "jqueryui";
	$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
	echo $this->miFormulario->marcoAGrupacion ( "inicio", $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "codigoInterno";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "fechaIngreso";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "resolucionNombramiento";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "documentoResolucion";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "dedicacion";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	// ****************************** Invento *****************************************
	$conexion = "docencia";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->sql->cadena_sql ( "consultarDedicacion", $variable [$esteCampo] );
	$solicitud_tip = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
	$solicitud_tip = $solicitud_tip [0];
	/**
	 * **************************************************************************
	 */
	$atributos ["texto"] = strtolower ( $solicitud_tip [1] );
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "fechaInicioAño";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "documentoPrueba";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "documentoFinal";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "documentoConcepto";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// Fin de Conjunto de Controles
	echo $this->miFormulario->marcoAGrupacion ( "fin" );
	
	// -----------------Inicio de Conjunto de Controles----------------------------------------
	$esteCampo = "marcoDependecia";
	$atributos ["estilo"] = "jqueryui";
	$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
	echo $this->miFormulario->marcoAGrupacion ( "inicio", $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "facultad";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	// ****************************** Invento *****************************************
	$conexion = "docencia";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->sql->cadena_sql ( "consultarFacultad", $variable [$esteCampo] );
	$solicitud_tip = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
	$solicitud_tip = $solicitud_tip [0];
	/**
	 * **************************************************************************
	 */
	$atributos ["texto"] = strtolower ( $solicitud_tip [1] );
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "proyectoCurricular";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	// ****************************** Invento *****************************************
	$conexion = "docencia";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->sql->cadena_sql ( "consultarProyecto", $variable [$esteCampo] );
	$solicitud_tip = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
	$solicitud_tip = $solicitud_tip [0];
	/**
	 * **************************************************************************
	 */
	$atributos ["texto"] = strtolower ( $solicitud_tip [1] );
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "categoriaActual";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	// ****************************** Invento *****************************************
	$conexion = "docencia";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->sql->cadena_sql ( "consultarCategoria", $variable [$esteCampo] );
	$solicitud_tip = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
	$solicitud_tip = $solicitud_tip [0];
	/**
	 * **************************************************************************
	 */
	$atributos ["texto"] = strtolower ( $solicitud_tip [1] );
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "correoInstitucional";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "correoPersonal";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "direccionResidencia";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "telefonoFijo";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "telefonoCelular";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "telefonoadicional";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "numeroActa";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "fechaActa";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	
	// -------------Control cuadroTexto-----------------------
	$esteCampo = "numeroCaso";
	$atributos ["id"] = $esteCampo;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
	$atributos ["estilo"] = "jqueryui";
	$atributos ["columnas"] = "1";
	$atributos ["texto"] = $variable [$esteCampo];
	echo $this->miFormulario->campoTexto ( $atributos );
	unset ( $atributos );
	// Fin de Conjunto de Controles
	echo $this->miFormulario->marcoAGrupacion ( "fin" );
	
	// ----------------------Fin Conjunto de Controles--------------------------------------
	
	// -------------Control cuadroTexto con campos ocultos-----------------------
	$atributos ["id"] = "formSaraData";
	$atributos ["tipo"] = "hidden";
	$atributos ["etiqueta"] = "";
	$atributos ["valor"] = $valorCodificado;
	echo $this->miFormulario->campoCuadroTexto ( $atributos );
	
	
	
	
	// -------------------Fin Division-------------------------------
	echo $this->miFormulario->marcoFormulario ( "fin", $atributos );
}
// ----------Grilla con lo elementos
?>