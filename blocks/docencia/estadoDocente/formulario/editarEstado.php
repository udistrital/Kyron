<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
/**
 * Este script está incluido en el método html de la clase Frontera.class.php.
 *
 * La ruta absoluta del bloque está definida en $this->ruta
 */

$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

{
	$tab = 1;
	
	include_once ("core/crypto/Encriptador.class.php");
	$cripto = Encriptador::singleton ();
	$valorCodificado = "&solicitud=nuevo";
	$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
	$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
	$valorCodificado = $cripto->codificar ( $valorCodificado );
	
	// ---------------Inicio Formulario (<form>)--------------------------------
	$atributos ["id"] = "salida";
	$atributos ["tipoFormulario"] = "multipart/form-data";
	$atributos ["metodo"] = "POST";
	$atributos ["nombreFormulario"] = "salida";
	$verificarFormulario = "1";
	echo $this->miFormulario->formulario ( "inicio", $atributos );
	
	// ------------------Division para los botones-------------------------
	$atributos ["id"] = "botones";
	$atributos ["estilo"] = "marcoBotones";
	echo $this->miFormulario->division ( "inicio", $atributos );
	
	// -------------Control Boton-----------------------
	$esteCampo = "botonvolver";
	$atributos ["id"] = $esteCampo;
	$atributos ["tabIndex"] = $tab ++;
	$atributos ["tipo"] = "boton";
	$atributos ["estilo"] = "";
	$atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
	$atributos ["tipoSubmit"] = "jquery"; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
	$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["nombreFormulario"] = "salida";
	echo $this->miFormulario->campoBoton ( $atributos );
	unset ( $atributos );
	// -------------Fin Control Boton----------------------
	
	// ------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division ( "fin" );
	
	// -------------Control cuadroTexto con campos ocultos-----------------------
	// Para pasar variables entre formularios o enviar datos para validar sesiones
	$atributos ["id"] = "formSaraData"; // No cambiar este nombre
	$atributos ["tipo"] = "hidden";
	$atributos ["obligatorio"] = false;
	$atributos ["etiqueta"] = "";
	$atributos ["valor"] = $valorCodificado;
	echo $this->miFormulario->campoCuadroTexto ( $atributos );
	unset ( $atributos );
	
	echo $this->miFormulario->formulario ( "fin" );
}

$nombreFormulario = $esteBloque ["nombre"];
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
$cadena = $this->sql->cadena_sql ( "consultarDocente", $_REQUEST ['identificacion'] );
$docente = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );

include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton ();

$valorCodificado = "action=" . $esteBloque ["nombre"];
$valorCodificado .= "&solicitud=procesarEditarEstado";
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado .= "&identificacionDocente=" . $docente [0] [0];
$valorCodificado = $cripto->codificar ( $valorCodificado );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";

$tab = 1;

// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = $nombreFormulario;
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario ( "inicio", $atributos );

// -----------------Inicio de Conjunto de Controles----------------------------------------
$esteCampo = "marcoDatosBasicos";
$atributos ["estilo"] = "jqueryui";
$atributos ["leyenda"] = "Docente : " . $docente [0] [1] . "<br>Identificación: " . $docente [0] [0];
echo $this->miFormulario->marcoAGrupacion ( "inicio", $atributos );

$atributos ["id"] = "ventana";
$atributos ["estiloEnLinea"] = "display:block";
$verificarFormulario = "1";
echo $this->miFormulario->division ( "inicio", $atributos );
// //-------------Control cuadroTexto-----------------------
$esteCampo = "seleccionEstado";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = - 1;
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "245px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 330;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccionEstado" );
$atributos ["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

{ // ---------------Inicio Formulario (<form>)--------------------------------
	$atributos ["id"] = "ParametrosEstado";
	$atributos ["estiloEnLinea"] = "display:none";
	$verificarFormulario = "1";
	echo $this->miFormulario->division ( "inicio", $atributos );
	{
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "seleccionEstadoComplemetario";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = - 1;
		$atributos ["evento"] = 2;
		$atributos ["columnas"] = "1";
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["ancho"] = "245px";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ["validar"] = "required";
		$atributos ["anchoEtiqueta"] = 330;
		$atributos ["obligatorio"] = true;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos ---------
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccionEstadoComplementario" );
		$atributos ["baseDatos"] = "estructura";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		echo $this->miFormulario->division ( "fin" );
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "fechaInicioE";
		$atributos ["id"] = $esteCampo;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["obligatorio"] = false;
		$atributos ["tamanno"] = "8";
		$atributos ["anchoEtiqueta"] = 330;
		$atributos ["tipo"] = "";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["columnas"] = "1"; // El control ocupa 32% del tamaño del formulario
		$atributos ["validar"] = "required";
		$atributos ["categoria"] = "fecha";
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "fechaTerminacionE";
		$atributos ["id"] = $esteCampo;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["obligatorio"] = false;
		$atributos ["tamanno"] = "8";
		$atributos ["anchoEtiqueta"] = 330;
		$atributos ["tipo"] = "";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["columnas"] = "1"; // El control ocupa 32% del tamaño del formulario
		$atributos ["validar"] = "required";
		$atributos ["categoria"] = "fecha";
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "botones";
		$atributos ["estilo"] = "marcoBotones";
		echo $this->miFormulario->division ( "inicio", $atributos );
		
		$esteCampo = "DocumentoSoporte";
		$atributos ["id"] = $esteCampo; // No cambiar este nombre
		$atributos ["tipo"] = "file";
		$atributos ["obligatorio"] = true;
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["columnas"] = 2;
		$atributos ["estilo"] = "textoIzquierda";
		$atributos ["anchoEtiqueta"] = 300;
		$atributos ["tamanno"] = 500000;
		$atributos ["validar"] = "required";
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["valor"] = $valorCodificado;
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		echo $this->miFormulario->division ( "fin" );
	}
	echo $this->miFormulario->division ( "fin" );
}

$atributos ["id"] = "botones";
$atributos ["estilo"] = "marcoBotones";
echo $this->miFormulario->division ( "inicio", $atributos );

// -------------Control Boton-----------------------
$esteCampo = "botonGuardarEstado";
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

// ------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division ( "fin" );

echo $this->miFormulario->marcoAGrupacion ( "fin" );

// ------------------Division para los botones-------------------------

// -------------Control cuadroTexto con campos ocultos-----------------------
// Para pasar variables entre formularios o enviar datos para validar sesiones
$atributos ["id"] = "formSaraData"; // No cambiar este nombre
$atributos ["tipo"] = "hidden";
$atributos ["obligatorio"] = false;
$atributos ["etiqueta"] = "";
$atributos ["valor"] = $valorCodificado;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// Fin del Formulario
echo $this->miFormulario->formulario ( "fin" );
?>
