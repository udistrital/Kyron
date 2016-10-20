<?php

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$nombreFormulario='ActualizarDatos';

$directorioImagenes = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/images";

$nombreAplicativo = $this->miConfigurador->getVariableConfiguracion("nombreAplicativo");


$atributos["id"] = "divPrincipal";
$atributos["estilo"] = "divPrincipal";
echo $this->miFormulario->division("inicio", $atributos);

?>
<div id='imgKyron' class="imgKyron">
    <img src="<?php echo $directorioImagenes."/kyron1.png"?>" width="110px">
    
</div>
<?php
$miSesion = Sesion::singleton();
var_dump($directorioImagenes);
$conexion = 'estructura';
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
	
// $cadena_sql = $this->sql->cadena_sql("datosUsuario", $miSesion->getSesionUsuarioId());
// $resultadoUser = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$atributos["id"] = "divDatos";
$atributos["estilo"] = "divDatos";
echo $this->miFormulario->division("inicio", $atributos);

echo $resultadoUser[0]['nombre']." ".$resultadoUser[0]['apellido'];

?>

<div id="clockDiv"></div>    
<input type="hidden" id="horaServidor" name="horaServidor" value="<?php echo date('d M Y G:i:s');?>">
<?
echo $this->miFormulario->division("fin"); 

echo $this->miFormulario->division("fin"); 

   
?>



