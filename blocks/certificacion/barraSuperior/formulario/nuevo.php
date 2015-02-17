<?php
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];
?>
<div class="barra_separadora">
    <p class="textoNombre">Gestor de Certificados - Universidad Distrital 
        <img class="fotoUsuario" src="<? echo $rutaBloque . "/imagenesTemp/impresora.png" ?>">
    </p>        
</div>
