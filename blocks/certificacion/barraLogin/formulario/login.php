<?

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}


$esteBloque=$this->miConfigurador->getVariableConfiguracion("esteBloque");

$nombreFormulario="loginForm";

$token=strrev(($this->miConfigurador->getVariableConfiguracion("enlace")));

$valorCodificado="action=".$esteBloque["nombre"];
$valorCodificado.="&bloque=".$esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
$valorCodificado=$this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";
$tab=1;

//---------------Inicio División (<div>)--------------------------------
$esteCampo="bar";
$atributos["id"]=$esteCampo;
echo $this->miFormulario->division("inicio",$atributos);

//---------------Inicio División (<div>)--------------------------------
$atributos["id"]="container";
echo $this->miFormulario->division("inicio",$atributos);


//-----------------------Mensaje-----------------------------------------
$esteCampo="encabezadoBarra";
$atributos["id"]=$esteCampo;
$atributos["estilo"]=$esteCampo;
$atributos["tamanno"]="grande";
$atributos["mensaje"]=$this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->campoMensaje($atributos);
unset($atributos);


//---------------Inicio División (<div>)--------------------------------
$atributos["id"]="loginContainer";
echo $this->miFormulario->division("inicio",$atributos);


//--------------------  Enlace (<a>)-------------------------------------
$esteCampo="loginButton";
$atributos["id"]=$esteCampo;
$atributos["enlace"]="";
$atributos["enlaceTexto"]=$this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->enlace($atributos);

//---------------Inicio División (<div>)--------------------------------
$atributos["id"]="";
$atributos["estiloEnLinea"]="clear:both";
echo $this->miFormulario->division("inicio",$atributos);
unset($atributos);

//---------------Fin División (</div>)--------------------------------
echo $this->miFormulario->division("fin");


//---------------Inicio División (<div>)--------------------------------
$atributos["id"]="loginBox";
echo $this->miFormulario->division("inicio",$atributos);


//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"]=$nombreFormulario;
$atributos["tipoFormulario"]="multipart/form-data";
$atributos["metodo"]="POST";
$atributos["nombreFormulario"]=$nombreFormulario;
$verificarFormulario="1";
echo $this->miFormulario->formulario("inicio",$atributos);
unset($atributos);

// ---------------Agrupación (<fieldset>)-------------------------------
$atributos["id"]="bodyForm";
echo $this->miFormulario->agrupacion("inicio",$atributos);
unset($atributos);

//---------------Agrupación (<fieldset>)--------------------------------
$atributos="";
echo $this->miFormulario->agrupacion("inicio",$atributos);

//-------------Control cuadroTexto <input>-----------------------
$esteCampo=$token."usuario";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]="";
$atributos["tipo"]="";
$atributos["estilo"]="";
$atributos["sinDivision"]="true";
$atributos["data-validate"]="required, minlength(3)";
if(isset($_REQUEST["usuario"])){
	$atributos["valor"]=$_REQUEST["usuario"];
}
$atributos["nombreFormulario"]=$nombreFormulario;
echo $this->miFormulario->campoCuadroTexto($atributos);

//---------------Fin agrupación (</fielset>)--------------------------------
echo $this->miFormulario->agrupacion("fin");


//---------------Agrupación (<fieldset>)--------------------------------
echo $this->miFormulario->agrupacion("inicio",$atributos);

//-------------Control cuadroTexto <input>-----------------------
$esteCampo=$token."clave";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]="";
$atributos["tipo"]="password";
$atributos["estilo"]="";
$atributos["sinDivision"]="true";
$atributos["data-validate"]="required";
$atributos["valor"]="";
$atributos["nombreFormulario"]=$nombreFormulario;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);
//-------------Fin Control cuadroTexto----------------------


//---------------Fin agrupación (</fielset>)--------------------------------
echo $this->miFormulario->agrupacion("fin");


//-------------Control Botón-----------------------
$esteCampo="botonAceptar";
$atributos["id"]=$esteCampo;
$atributos["tabIndex"]=$tab++;
$atributos["tipo"]="submit";
$atributos["estilo"]="";
$atributos["verificar"]="";
$atributos["valor"]=$this->lenguaje->getCadena($esteCampo);
$atributos["sinDivision"]="true";
$atributos["nombreFormulario"]=$nombreFormulario;
$atributos["verificarFormulario"]=$verificarFormulario;
echo $this->miFormulario->campoBoton($atributos);
unset($atributos);
//-------------Fin Control Boton----------------------


//-------------Control checkBox-----------------------
$esteCampo=$token."checkbox";
$atributos["id"]=$esteCampo;
$atributos["tabIndex"]=$tab++;
$atributos["tipo"]="boton";
$atributos["estilo"]="";
$atributos["verificar"]="";
$atributos["sinDivision"]="true";
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->campoCuadroSeleccion($atributos);
unset($atributos);
//-------------Fin Control checkBox-----------------------


//-------------Control cuadroTexto con campos ocultos-----------------------
//Para pasar variables entre formularios o enviar datos para validar sesiones
$atributos["id"]="formSaraData"; //No cambiar este nombre
$atributos["tipo"]="hidden";
$atributos["obligatorio"]=false;
$atributos["etiqueta"]="";
$atributos["valor"]=$valorCodificado;
$atributos["sinDivision"]="true";
echo $this->miFormulario->campoCuadroTexto($atributos);
//-----------Fin controlcuadorTexto con campos ocultos ---------------------

//---------------Fin agrupación (</fielset>)--------------------------------
echo $this->miFormulario->agrupacion("fin");


//--------------------  Enlace (<a>)-------------------------------------
$esteCampo="enlaceRecordarClave";
$atributos["enlace"]="#";
$atributos["enlaceTexto"]=$this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->enlace($atributos);

//---------------Fin formulario (</form>)--------------------------------
$atributos["verificarFormulario"]=$verificarFormulario;
echo $this->miFormulario->formulario("fin", $atributos);

//---------------Fin División (</div>)--------------------------------
echo $this->miFormulario->division("fin");

//---------------Fin División (</div>)--------------------------------
echo $this->miFormulario->division("fin");

//---------------Fin División (</div>)--------------------------------
echo $this->miFormulario->division("fin");

//---------------Fin División (</div>)--------------------------------
echo $this->miFormulario->division("fin");

?>