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

$miPaginaActual = $this->miConfigurador->getVariableConfiguracion("pagina");

$nombreFormulario = $esteBloque ["nombre"];


set_include_path('blocks/docencia/gestorReportes/script/reportico');

$tab = 1;


include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton();
$valorCodificado = "&opcion=nuevo";
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado = $cripto->codificar($valorCodificado);

//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"] = $nombreFormulario;
$atributos["tipoFormulario"] = "multipart/form-data";
$atributos["metodo"] = "POST";
$atributos["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario("inicio", $atributos); {

//-------------Control Mensaje-----------------------
}

// ------------------Division para los botones-------------------------


require_once('blocks/docencia/gestorReportes/script/reportico/reportico.php');
// Set the timezone according to system defaults
date_default_timezone_set(@date_default_timezone_get());

// Reserver 100Mb for running
ini_set("memory_limit", "100M");

// Allow a good time for long reports to run. Set to 0 to allow unlimited time
ini_set("max_execution_time", "90");



$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


$cadena_sql = $this->sql->cadena_sql("consultarDB", $conexion);
$acceso_bd = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

define('SW_FRAMEWORK_DB_DRIVER', 'pdo_mysql');
define('SW_FRAMEWORK_DB_USER', "'" . $acceso_bd[0] ["usuario"] . "'");
define('SW_FRAMEWORK_DB_PASSWORD', "'" . $acceso_bd[0] ["password"] . "'");
define('SW_FRAMEWORK_DB_HOST', "'" . $acceso_bd[0] ["servidor"] . "'"); // Use ip:port to specifiy a non standard port
define('SW_FRAMEWORK_DB_DATABASE', "'" . $acceso_bd[0] ["db"] . "'");


$reporte = new reportico();
$reporte->initial_project = "kyron";
$reporte->embedded_report = true;



$reporte->execute();

// Modificamos el archivo swutil.php para obtener el path correctamente, línea 956
//swoutput linea 3216
//Fin del Formulario
echo $this->miFormulario->formulario("fin");
 ob_end_flush();
?>