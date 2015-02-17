<?php
$indice=0;
$estilo[$indice++]="barraSuperior.css";
$rutaBloque=$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");

//echo "<br> ruta bloque ";var_dump($this->miConfigurador->getConfiguracion());

foreach ($estilo as $nombre){
    
    //echo "<link rel='stylesheet' type='text/css' href='".$rutaBloque."/css/".$nombre."'>\n";	
    echo "<link rel='stylesheet' type='text/css' href='http://localhost/GearBox/blocks/certificacion/barraSuperior/css/".$nombre."'>\n";	
}
?>