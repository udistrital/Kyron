<?php
//------------------Division para las pestañas-------------------------
$atributos["id"]="slidePrincipal";
$atributos["estilo"]="";
echo $this->miFormulario->division("inicio",$atributos);
unset($atributos);
echo $this->miFormulario->division("fin");

