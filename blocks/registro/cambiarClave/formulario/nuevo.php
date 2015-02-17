<?php 

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}
/**
 * Este script está incluido en el método html de la clase Frontera.class.php.
 * 
 *  La ruta absoluta del bloque está definida en $this->ruta
 */

$esteBloque=$this->miConfigurador->getVariableConfiguracion("esteBloque");
$nombreFormulario=$esteBloque["nombre"];

$valorCodificado="pagina=cambiarClave";
$valorCodificado.="&action=".$esteBloque["nombre"];
$valorCodificado.="&opcion=cambiarClave";
$valorCodificado.="&usuario=".isset($_REQUEST["usuario"]);
$valorCodificado.="&bloque=".$esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
$valorCodificado=$this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);





$tab=1;

//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"]=$nombreFormulario;
$atributos["tipoFormulario"]="multipart/form-data";
$atributos["metodo"]="POST";
$atributos["nombreFormulario"]=$nombreFormulario;
$verificarFormulario="1";
echo $this->miFormulario->formulario("inicio",$atributos);
unset($atributos);

//------------------Division para las pestañas-------------------------
$atributos["id"]="tabs";
$atributos["estilo"]="jqueryui";
echo $this->miFormulario->division("inicio",$atributos);
unset($atributos);

//-------------------------------Mensaje-------------------------------------
$esteCampo="mensajeCambiarClave";
$atributos["id"]=$esteCampo;
$atributos["obligatorio"]=false;
$atributos["estilo"]="jqueryui";
$atributos["etiqueta"]="simple";
$atributos["mensaje"]=$this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->campoMensaje($atributos);

//-------------Control texto-----------------------
$esteCampo="datosUsuario";
$atributos["tamanno"]="";
$atributos["estilo"]="jqueryui";
$atributos["etiqueta"]="";
$atributos["texto"]=$this->lenguaje->getCadena($esteCampo);
$atributos["columnas"]=""; //El control ocupa 47% del tamaño del formulario
echo $this->miFormulario->campoTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo="contrasenaActual";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]="15";
$atributos["tipo"]="password";
$atributos["estilo"]="jqueryui";
$atributos["validar"]="required, min[6]";
$atributos["categoria"]="";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo="contrasena";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]="15";
$atributos["tipo"]="password";
$atributos["estilo"]="jqueryui";
$atributos["validar"]="required, min[6]";

echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo="contrasenaConfirm";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]="15";
$atributos["tipo"]="password";
$atributos["estilo"]="jqueryui";
$atributos["validar"]="required, min[6], equals[contrasena]";

echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//----------------------Fin Conjunto de Controles--------------------------------------


//------------------Division para los botones-------------------------
$atributos["id"]="botones";
$atributos["estilo"]="marcoBotones";
echo $this->miFormulario->division("inicio",$atributos);

//-------------Control Boton-----------------------
$esteCampo="botonGuardar";
$atributos["id"]=$esteCampo;
$atributos["tabIndex"]=$tab++;
$atributos["tipo"]="boton";
$atributos["estilo"]="";
$atributos["verificar"]="true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
$atributos["tipoSubmit"]="jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
$atributos["valor"]=$this->lenguaje->getCadena($esteCampo);
$atributos["nombreFormulario"]=$nombreFormulario;
echo $this->miFormulario->campoBoton($atributos);
unset($atributos);
//-------------Fin Control Boton----------------------

//------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");

//-------------Control cuadroTexto con campos ocultos-----------------------
//Para pasar variables entre formularios o enviar datos para validar sesiones
$atributos["id"]="formSaraData"; //No cambiar este nombre
$atributos["tipo"]="hidden";
$atributos["obligatorio"]=false;
$atributos["etiqueta"]="";
$atributos["valor"]=$valorCodificado;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//------------------Fin Division para las pestañas-------------------------
echo $this->miFormulario->division("fin");

//Fin del Formulario
echo $this->miFormulario->formulario("fin");



?>
