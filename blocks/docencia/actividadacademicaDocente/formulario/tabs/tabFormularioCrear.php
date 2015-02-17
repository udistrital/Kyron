<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$miSesion = Sesion::singleton ();

$nombreFormulario = $esteBloque ["nombre"];

include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton ();
$valorCodificado .= "&action=" . $esteBloque ['nombre'];
$valorCodificado .= "&opcion=guardarDatos";
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
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

$conexion = "docencia";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

$atributos ["id"] = "freeow";
$atributos ["estilo"] = "freeow freeow-top-right";
$atributos ["estiloEnLinea"] = "display:block";
echo $this->miFormulario->division ( "inicio", $atributos );

echo $this->miFormulario->division ( "fin" );

$esteCampo = "identificacionFinal";
$atributos ["id"] = $esteCampo; // No cambiar este nombre
$atributos ["tipo"] = "hidden";
$atributos ["obligatorio"] = false;
$atributos ["etiqueta"] = "";
$atributos ["valor"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "docente";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = false;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 250;
$atributos ["validar"] = "required, minSize[5]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );



$esteCampo = "asignatura";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = false;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, minSize[1]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "inthora";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = false;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, minSize[1]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );



$esteCampo = "numestud";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = false;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, minSize[1]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// ------------------Fin Division para los botones-------------------------
// echo $this->miFormulario->division("fin");
// ------------------Division para los botones-------------------------
$atributos ["id"] = "botones";
$atributos ["estilo"] = "marcoBotones";
echo $this->miFormulario->division ( "inicio", $atributos );


$atributos ["estilo"] = "textoIzquierda";
$esteCampo = "horario";
$atributos ["id"] = $esteCampo; // No cambiar este nombre
$atributos ["tipo"] = "file";
$atributos ["obligatorio"] = false;
$atributos ["tabIndex"] = $tab ++;
$atributos ["columnas"] = 2;
$atributos ["anchoEtiqueta"] = 350;
$atributos ["tamanno"] =500000;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["valor"] = $valorCodificado;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );


echo $this->miFormulario->division ( "fin" );


// ------------------Division para los botones-------------------------
$atributos ["id"] = "botones";
$atributos ["estilo"] = "marcoBotones";
echo $this->miFormulario->division ( "inicio", $atributos );


// -------------Control cuadroTexto con campos ocultos-----------------------
// Para pasar variables entre formularios o enviar datos para validar sesiones
$esteCampo = "syllabus";
$atributos ["id"] = $esteCampo; // No cambiar este nombre
$atributos ["tipo"] = "file";
$atributos ["obligatorio"] = false;
$atributos ["estilo"] = "textoIzquierda";
$atributos ["tabIndex"] = $tab ++;
$atributos ["columnas"] = 2;
$atributos ["anchoEtiqueta"] = 350;
$atributos ["tamanno"] =500000;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["valor"] = $valorCodificado;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

echo $this->miFormulario->division ( "fin" );


// ------------------Division para los botones-------------------------
$atributos ["id"] = "botones";
$atributos ["estilo"] = "marcoBotones";
echo $this->miFormulario->division ( "inicio", $atributos );




// -------------Control Boton-----------------------
$esteCampo = "botonAceptar";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["tipo"] = "boton";
$atributos ["estilo"] = "textoCentrar";
$atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
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
