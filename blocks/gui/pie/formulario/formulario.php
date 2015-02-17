<?php
//------------------Division-------------------------
$atributos["id"]="sabio";
$atributos["estilo"]="";
echo $this->miFormulario->division("inicio",$atributos);
unset($atributos);
//------------Fin de la División -----------------------
echo $this->miFormulario->division("fin");

//------------------Division-------------------------
$atributos["id"]="escudo";
$atributos["estilo"]="";
echo $this->miFormulario->division("inicio",$atributos);
unset($atributos);
//------------Fin de la División -----------------------
echo $this->miFormulario->division("fin");

//------------------Division-------------------------
$atributos["id"]="pie";
$atributos["estilo"]="";
echo $this->miFormulario->division("inicio",$atributos);
unset($atributos);

//-----------------Texto-----------------------------
$esteCampo='mensajePie';
$atributos["estilo"]="";
$atributos['texto']=$this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->campoTexto($atributos);
unset($atributos);


//------------Fin de la División -----------------------
echo $this->miFormulario->division("fin");

