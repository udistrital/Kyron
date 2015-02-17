<?php

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

$nombreFormulario = $esteBloque ["nombre"] . "Consulta";

include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton();
$valorCodificado .= "&opcion=consultarExcelencia";
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado = $cripto->codificar($valorCodificado);
$directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque") . "/imagen/";

$tab = 1;
// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = $nombreFormulario;
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario("inicio", $atributos);

$conexion = "condor";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

?>
<?php

$atributos ["id"] = "divDatos";
$atributos ["estilo"] = "marcoBotones";
// $atributos["estiloEnLinea"]="display:none";
// echo $this->miFormulario->division("inicio",$atributos);

$atributos ["id"] = "divMensaje";
$atributos ["estilo"] = "marcoBotones";
// $atributos["estiloEnLinea"]="display:none";
echo $this->miFormulario->division("inicio", $atributos);

$esteCampo = "mensajeGeneral";
$atributos ["id"] = $esteCampo; // Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
$atributos ["etiqueta"] = "";
$atributos ["estilo"] = "centrar";
$atributos ["tipo"] = "warning";
$atributos ["mensaje"] = $this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->cuadroMensaje($atributos);
unset($atributos);

// ------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");

$esteCampo = "identificacionFinalConsulta";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = - 1;
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "450px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 310;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql("buscarNombreDocente");
$atributos ["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista($atributos);

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "facultad";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = - 1;
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "450px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 310;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql("facultad");
$atributos ["baseDatos"] = "condor";
echo $this->miFormulario->campoCuadroLista($atributos);
unset($atributos);

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "proyecto";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = - 1;
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "450px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 310;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql("proyectos");
$atributos ["baseDatos"] = "condor";
echo $this->miFormulario->campoCuadroLista($atributos);
unset($atributos);

// ------------------Fin Division para los botones-------------------------
// echo $this->miFormulario->division("fin");
// ------------------Division para los botones-------------------------
$atributos ["id"] = "botones";
$atributos ["estilo"] = "marcoBotones";
echo $this->miFormulario->division("inicio", $atributos);

// -------------Control Boton-----------------------
$esteCampo = "botonConsultar";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["tipo"] = "boton";
$atributos ["estilo"] = "";
$atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
$atributos ["tipoSubmit"] = "jquery"; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
$atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
$atributos ["nombreFormulario"] = $nombreFormulario;
echo $this->miFormulario->campoBoton($atributos);
unset($atributos);
// -------------Fin Control Boton----------------------
// ------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");

// -------------Control cuadroTexto con campos ocultos-----------------------
// Para pasar variables entre formularios o enviar datos para validar sesiones
$atributos ["id"] = "formSaraData"; // No cambiar este nombre
$atributos ["tipo"] = "hidden";
$atributos ["obligatorio"] = false;
$atributos ["etiqueta"] = "";
$atributos ["valor"] = $valorCodificado;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

// Fin del Formulario
echo $this->miFormulario->formulario("fin");
?>
