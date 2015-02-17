<?php

// var_dump($_REQUEST);exit;
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
/**
 * Este script está incluido en el método html de la clase Frontera.class.php.
 *
 * La ruta absoluta del bloque está definida en $this->ruta
 */
// _______________________________________________________________________

$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
$nombreFormulario = $esteBloque ["nombre"];

$conexion = "docencia2";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
$cadena_sql1 = $this->sql->cadena_sql ( "Consultar Estado Docente", $_REQUEST ['datos'] );
$cadena_sql2 = $this->sql->cadena_sql ( "Consultar Nombre Docente", $_REQUEST ['datos'] );

$resultado1 = $esteRecursoDB->ejecutarAcceso ( $cadena_sql1, "busqueda" );
$resultado2 = $esteRecursoDB->ejecutarAcceso ( $cadena_sql2, "busqueda" );



$cadena_sql3=  $this->sql->cadena_sql ( "Consultar Nombre Documento Soporte", $resultado1 [0] ['documentosoporte'] );
$resultado3 = $esteRecursoDB->ejecutarAcceso ( $cadena_sql3, "busqueda" );




$datosConfirmar = array (
		"Nombre" => $resultado2 [0] ['nombre'],
		"EstadoActual" => $resultado1 [0] ['estado'],
		"EstadoComplementario" => $resultado1 [0] ['estadocomplentario'],
		"DocumentoSoporte" => $resultado3 [0] ['documentosoporte_nombrearchivo'],
		"FechaInicio" => $resultado1 [0] ['fechainicio'],
		"FechaTerminacion" => $resultado1 [0] ['fechaterminacion'] 
);







// _______________________________________________________________________

include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton ();
// $valorCodificado ="pagina=registrarDocente";
$valorCodificado = "action=" . $esteBloque ["nombre"];
$valorCodificado .= "&solicitud=procesarEditarEstadoModificar";
$valorCodificado .= "&datos=" . $_REQUEST ['datos'];
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado = $cripto->codificar ( $valorCodificado );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";

//

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
$atributos ["leyenda"] = "Docente : " . $datosConfirmar ['Nombre'];
echo $this->miFormulario->marcoAGrupacion ( "inicio", $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "seleccionEstado";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = 0; // 9
$atributos ["evento"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["estilo"] = "jqueryui";
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccionEstado" );
$atributos ["baseDatos"] = "docencia2";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

{ // ---------------Inicio Formulario (<form>)--------------------------------
	$atributos ["id"] = "ParametrosEstado";
	$atributos ["estilo"] = "campoAreaContenido";
	$atributos ["estiloEnLinea"] = "display:block";
	$verificarFormulario = "1";
	echo $this->miFormulario->division ( "inicio", $atributos );
	{
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "seleccionEstadoComplemetario";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = 0; // 9
		$atributos ["evento"] = 2;
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos -------ependencia in /usr/lo--
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccionEstadoComplementario" );
		$atributos ["baseDatos"] = "docencia2";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		// -------------Control cuadroTexto-----------------------
		$esteCampo = "DocumentoSoporte";
		$atributos ["id"] = $esteCampo;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["obligatorio"] = true;
		$atributos ["tamanno"] = "20";
		$atributos ["tipo"] = "";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["columnas"] = "1";
		$atributos ["validar"] = "required";
		$atributos ["valor"] = $datosConfirmar ['DocumentoSoporte'];
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "fechaInicioE";
		$atributos ["id"] = $esteCampo;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["obligatorio"] = false;
		$atributos ["tamanno"] = "10";
		$atributos ["tipo"] = "";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["columnas"] = "1"; // El control ocupa 32% del tamaño del formulario
		$atributos ["validar"] = "minSize[3]";
		$atributos ["categoria"] = "fecha";
		$atributos ["valor"] = 'Documento ';
		$atributos ["valor"] = $datosConfirmar ['FechaInicio'];
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "fechaTerminacionE";
		$atributos ["id"] = $esteCampo;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["obligatorio"] = false;
		$atributos ["tamanno"] = "10";
		$atributos ["tipo"] = "";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["columnas"] = "1"; // El control ocupa 32% del tamaño del formulario
		$atributos ["validar"] = "minSize[3]";
		$atributos ["categoria"] = "fecha";
		$atributos ["valor"] = $datosConfirmar ['FechaTerminacion'];
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
	}
	echo $this->miFormulario->division ( "fin" );
}

echo $this->miFormulario->marcoAGrupacion ( "fin" );

// ------------------Division para los botones-------------------------
$atributos ["id"] = "botones";
$atributos ["estilo"] = "marcoBotones";
echo $this->miFormulario->division ( "inicio", $atributos );

// -------------Control Boton-----------------------
$esteCampo = "botonCorregirEstado";
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

$esteCampo = "botonCancelar";
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

// Fin del Formulario
echo $this->miFormulario->formulario ( "fin" );
?>
