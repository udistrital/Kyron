<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

$nombreFormulario=$esteBloque["nombre"];

include_once("core/crypto/Encriptador.class.php");
$cripto=Encriptador::singleton();
$valorCodificado.="&action=".$esteBloque['nombre'];
$valorCodificado.="&opcion=guardarDatos";
$valorCodificado.="&bloque=".$esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
$valorCodificado=$cripto->codificar($valorCodificado);
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

$tab=1;
//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"]=$nombreFormulario;
$atributos["tipoFormulario"]="multipart/form-data";
$atributos["metodo"]="POST";
$atributos["nombreFormulario"]=$nombreFormulario;
$verificarFormulario="1";
echo $this->miFormulario->formulario("inicio",$atributos);

$conexion="estructuro";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

?>
<?php 
$atributos["id"]="divDatos";
$atributos["estilo"]="marcoBotones";
//$atributos["estiloEnLinea"]="display:none";
//echo $this->miFormulario->division("inicio",$atributos);

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "identificacionFinalCrear";
$atributos ["id"] = $esteCampo;				
$atributos ["tipo"] = "hidden";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "docente";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 55;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = false;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "minSize[3], maxSize[2000]";
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );


// ------------------Control Lista Desplegable------------------------------
$esteCampo = "nombre_revista";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, minSize[6], maxSize[2000]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "contexto_entidad";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["seleccion"] = - 1;
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "250px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "contexto" );
// echo $atributos["cadena_sql"];exit;
$atributos ["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

{
	// ---------------Inicio Formulario (<form>)--------------------------------
	$atributos ["id"] = "seleccionpais1";
	$atributos ["estilo"] = "campoTexto";
	$atributos ["estiloEnLinea"] = "display:none";
	$verificarFormulario = "1";
	echo $this->miFormulario->division ( "inicio", $atributos );

	$esteCampo = "pais1";
	$atributos ["id"] = $esteCampo;
	$atributos ["tabIndex"] = $tab ++;
	$atributos ["obligatorio"] = true;
	$atributos ["seleccion"] = -1;
	$atributos ["evento"] = 2;
	$atributos ["columnas"] = "1";
	$atributos ["limitar"] = false;
	$atributos ["tamanno"] = 1;
	$atributos ["ancho"] = "250px";
	$atributos ["estilo"] = "jqueryui";
	$atributos ["etiquetaObligatorio"] = true;
	$atributos ["validar"] = "required";
	$atributos ["anchoEtiqueta"] = 350;
	$atributos ["obligatorio"] = true;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	// -----De donde rescatar los datos ---------
	$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "pais" );
	// echo $atributos["cadena_sql"];exit;
	$atributos ["baseDatos"] = "estructura";
	echo $this->miFormulario->campoCuadroLista ( $atributos );
	unset ( $atributos );

	$esteCampo = "indexacion";
	$atributos ["id"] = $esteCampo;
	$atributos ["tabIndex"] = $tab ++;
	$atributos ["obligatorio"] = true;
	$atributos ["seleccion"] = - 1;
	$atributos ["evento"] = 2;
	$atributos ["columnas"] = "1";
	$atributos ["limitar"] = false;
	$atributos ["tamanno"] = 1;
	$atributos ["ancho"] = "250px";
	$atributos ["estilo"] = "jqueryui";
	$atributos ["etiquetaObligatorio"] = true;
	$atributos ["validar"] = "required";
	$atributos ["anchoEtiqueta"] = 350;
	$atributos ["obligatorio"] = true;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	// -----De donde rescatar los datos ---------
	$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarCategoria_revista" );
	// var_dump($atributos ["cadena_sql"]);
	$atributos ["baseDatos"] = "estructura";
	// var_dump($atributos ["baseDatos"]);exit;
	echo $this->miFormulario->campoCuadroLista ( $atributos );
	unset ( $atributos );
	echo $this->miFormulario->division ( "fin" );
}
// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = "seleccionpais";
$atributos ["estilo"] = "campoTexo";
$atributos ["estiloEnLinea"] = "display:none";
$verificarFormulario = "1";
echo $this->miFormulario->division ( "inicio", $atributos );

$esteCampo = "pais";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["seleccion"] = - 1;
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "250px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "paises_del_mundo" );
// echo $atributos["cadena_sql"];exit;
$atributos ["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

$esteCampo = "indexacionInternacional";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["seleccion"] = - 1;
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "250px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarCategoria_revista2" );
// var_dump($atributos ["cadena_sql"]);
$atributos ["baseDatos"] = "estructura";
// var_dump($atributos ["baseDatos"]);exit;
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );
echo $this->miFormulario->division ( "fin" );

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "institucion";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["seleccion"] = - 1;
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "250px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarUniversidad" );
$atributos ["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

$esteCampo = "ISSN";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, min[1], custom[onlyNumberSp], minSize[10], maxSize[15]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "año";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required";
$atributos ["categoria"] = "fecha";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "volumen";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, custom[onlyNumberSp],min[1], maxSize[30]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "No";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, custom[onlyNumberSp], min[1], maxSize[30]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "paginas";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, custom[integer], custom[onlyNumberSp], min[1], maxSize[30]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "titulo_articulo";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, minSize[6], maxSize[2000]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "no_autores";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, custom[integer], maxSize[30], min[1]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "autoresUD";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, custom[onlyNumberSp], maxSize[30], min[1]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "fecha_publicacion";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "20";
$atributos ["ancho"] = 350;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["deshabilitado"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required";
$atributos ["categoria"] = "fecha";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo="numeActa";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]=40;
$atributos["columnas"] = 1;
$atributos["etiquetaObligatorio"] = true;
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["anchoEtiqueta"] = 350;
$atributos["validar"]="required, minSize[1], min[1], maxSize[30]";
$atributos["categoria"]="";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

$esteCampo="fechaActa";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]="20";
$atributos["ancho"] = 350;
$atributos["etiquetaObligatorio"] = true;
$atributos["deshabilitado"] = true;
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["anchoEtiqueta"] = 350;
$atributos["validar"]="required";
$atributos["categoria"]="fecha";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

$esteCampo="numeCaso";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]=40;
$atributos["columnas"] = 1;
$atributos["etiquetaObligatorio"] = true;
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["anchoEtiqueta"] = 350;
$atributos["validar"]="required, minSize[1],custom[onlyNumberSp], min[1], maxSize[30]";
$atributos["categoria"]="";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

$esteCampo="puntaje";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]=5;
$atributos["columnas"] = 1;
$atributos["etiquetaObligatorio"] = true;
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["anchoEtiqueta"] = 350;
$atributos["validar"]="required, custom[number],min[0.1]";
$atributos["categoria"]="";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);


$esteCampo="detalleDocencia";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["etiquetaObligatorio"] = false;
$atributos["tipo"]="";
$atributos["columnas"] = 100;
$atributos["filas"] = 5;
$atributos["estilo"]="jqueryui";
$atributos["anchoEtiqueta"] = 310;
$atributos["validar"]="required";
$atributos["categoria"]="";
echo $this->miFormulario->campoTextArea($atributos);
unset($atributos);


//------------------Fin Division para los botones-------------------------
//echo $this->miFormulario->division("fin");

// ------------------Division para los botones-------------------------
$atributos ["id"] = "botones";
$atributos ["estilo"] = "marcoBotones";
echo $this->miFormulario->division ( "inicio", $atributos );

// -------------Control Boton-----------------------
$esteCampo = "botonAceptar";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["tipo"] = "boton";
$atributos ["estilo"] = "";
$atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
$atributos ["tipoSubmit"] = "jquery"; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["nombreFormulario"] = $nombreFormulario;
echo $this->miFormulario->campoBoton ( $atributos );
unset ( $atributos );
// -------------Fin Control Boton----------------------

// ------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division ( "fin" );

//-------------Control cuadroTexto con campos ocultos-----------------------
//Para pasar variables entre formularios o enviar datos para validar sesiones
$atributos["id"]="formSaraData"; //No cambiar este nombre
$atributos["tipo"]="hidden";
$atributos["obligatorio"]=false;
$atributos["etiqueta"]="";
$atributos["valor"]=$valorCodificado;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//Fin del Formulario
echo $this->miFormulario->formulario("fin");


?>
