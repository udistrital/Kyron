<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}


$esteBloque=$this->miConfigurador->getVariableConfiguracion("esteBloque");
$nombreFormulario=$esteBloque["nombre"];
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";


//---------------Inicio División (<div>)--------------------------------
$esteCampo="content";
$atributos["id"]=$esteCampo;
$atributos["estilo"]=$esteCampo;
echo $this->miFormulario->division("inicio",$atributos);

//---------------Inicio División (<div>)--------------------------------
$esteCampo="border_box";
$atributos["id"]=$esteCampo;
$atributos["estilo"]=$esteCampo;
echo $this->miFormulario->division("inicio",$atributos);

//---------------Inicio División (<div>)--------------------------------
$esteCampo="box_skitter";
$atributos["id"]=$esteCampo;
$atributos["estilo"]=$esteCampo;
echo $this->miFormulario->division("inicio",$atributos);

include_once("listado.page.php");

//---------------Fin División (</div>)--------------------------------
echo $this->miFormulario->division("fin");

//---------------Fin División (</div>)--------------------------------
echo $this->miFormulario->division("fin");

//---------------Fin División (</div>)--------------------------------
echo $this->miFormulario->division("fin");

?>