<?php
//echo "Nickthor";exit;
if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$nombreFormulario = "registrarDocente";

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");

// $valorCodificado = "action=".$esteBloque ["nombre"];
// $valorCodificado .= "&solicitud=procesarNuevo";
// $valorCodificado .= "&bloque=".$esteBloque ["id_bloque"];
// $valorCodificado .= "&bloqueGrupo=".$esteBloque ["grupo"];




include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton ();
//$valorCodificado ="pagina=registrarDocente";
$valorCodificado = "action=" . $esteBloque ["nombre"];
$valorCodificado.="&solicitud=nuevo";
$valorCodificado.="&bloque=".$esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
$valorCodificado=$this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

$tab=1;

//-------------------------------Mensaje-------------------------------------
$esteCampo="mensajeAdvertencia";
$atributos["id"]="mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
$atributos["etiqueta"]="";
$atributos["estilo"]="";
$atributos["tipo"]="validation";
$atributos["valor"] = $_REQUEST["mensaje"];
//$atributos["valor"] = $_REQUEST["error"];
$atributos["mensaje"]=$this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->cuadroMensaje($atributos);

//echo "<div class='" . $_REQUEST["error"] . "'>" . $_REQUEST["mensaje"] . "</div>";

//---------------Inicio Formulario (<form>)--------------------------------
$nombreFormulario = "registrarDocente";
$atributos["id"]=$nombreFormulario;
$atributos["tipoFormulario"]="multipart/form-data";
$atributos["metodo"]="POST";
$atributos["nombreFormulario"]=$nombreFormulario;
$verificarFormulario="1";
echo $this->miFormulario->formulario("inicio",$atributos);
unset($atributos);

//------------------Division para los botones-------------------------
$atributos["id"]="botones";
$atributos["estilo"]="marcoBotones";
echo $this->miFormulario->division("inicio",$atributos);

// //-------------Control Boton-----------------------
// $esteCampo="botonVolver";
// $atributos["verificar"]="";
// $atributos["tipo"]="boton";
// $atributos["id"]=$esteCampo;
// $atributos["cancelar"]="true";
// $atributos["tabIndex"]=$tab++;
// $atributos["valor"]=$this->lenguaje->getCadena($esteCampo);
// $atributos["nombreFormulario"]=$nombreFormulario;
// echo $this->miFormulario->campoBoton($atributos);
// unset($atributos);
// //-------------Fin Control Boton----------------------

// //------------------Fin Division para los botones-------------------------
// echo $this->miFormulario->division("fin");

// //-------------Control cuadroTexto con campos ocultos-----------------------
// //Para pasar variables entre formularios o enviar datos para validar sesiones
// $atributos["id"]="formSaraData"; //No cambiar este nombre
// $atributos["tipo"]="hidden";
// $atributos["obligatorio"]=false;
// $atributos["etiqueta"]="";
// $atributos["valor"]=$valorCodificado;
// echo $this->miFormulario->campoCuadroTexto($atributos);
// unset($atributos);
$esteCampo = "botonVolver";
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


//Fin del Formulario
echo $this->miFormulario->formulario("fin");



?>