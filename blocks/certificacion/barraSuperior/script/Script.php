<?php

$indice=0;
$funcion[$indice++]="login.js";

$rutaBloque=$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");


foreach ($funcion as $nombre){
	echo "<script type='text/javascript' src='".$rutaBloque."/script/".$nombre."'></script>";
}

?>
