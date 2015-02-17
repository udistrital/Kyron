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

include_once("core/crypto/Encriptador.class.php");
$cripto=Encriptador::singleton();
$valorCodificado="pagina=registrarSolicitud";
$valorCodificado.="&opcion=confirmar";
$valorCodificado.="&bloque=".$esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
$valorCodificado=$cripto->codificar($valorCodificado);
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

//

$tab=1;

/*****************************************************************************/
$conexion = "solicitud";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
$cadena_sql = $this->sql->cadena_sql("buscarTipEstado", "");
$resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
$resultado = $resultado[0];
/*****************************************************************************/

//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"]=$nombreFormulario;
$atributos["tipoFormulario"]="multipart/form-data";
$atributos["metodo"]="POST";
$atributos["nombreFormulario"]=$nombreFormulario;
$verificarFormulario="1";
echo $this->miFormulario->formulario("inicio",$atributos);

//-----------------Inicio de Conjunto de Controles----------------------------------------
$esteCampo="marcoDatosBasicos";
$atributos["estilo"]="jqueryui";
$atributos["leyenda"]=$this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->marcoAGrupacion("inicio",$atributos);

//-------------Control cuadroTexto-----------------------
// $esteCampo="usuarioSolicitante";
// $atributos["id"]=$esteCampo;
// $atributos["tabIndex"]=$tab++;
// $atributos["seleccion"]=0;//9
// $atributos["evento"]=2;
// $atributos["limitar"]=false;
// $atributos["tamanno"]=1;
// $atributos["estilo"]="jqueryui";
// $atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
// //-----De donde rescatar los datos -------ependencia in /usr/lo--
// $atributos["cadena_sql"]=$this->sql->cadena_sql("buscarUsuario");
// $atributos["baseDatos"]="inventario";
// echo $this->miFormulario->campoCuadroLista($atributos);

// //-------------Control cuadroTexto-----------------------
$esteCampo="usuarioSolicitante";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]="";
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["columnas"]="2";
$atributos["validar"]="required";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo="cargoSolicitante";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]="";
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["columnas"]="2";
$atributos["validar"]="required";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
// $esteCampo="sedeSolicitante";
// $atributos["id"]=$esteCampo;
// $atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
// $atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
// $atributos["tabIndex"]=$tab++;
// $atributos["obligatorio"]=true;
// $atributos["tamanno"]="";
// $atributos["tipo"]="";
// $atributos["estilo"]="jqueryui";
// $atributos["columnas"]="2";
// $atributos["validar"]="required";
// echo $this->miFormulario->campoCuadroTexto($atributos);
// unset($atributos);

//-------------Control cuadroTexto---Sedes-----------------------
$esteCampo="sedeSolicitante";
$atributos["id"]=$esteCampo;
$atributos["tabIndex"]=$tab++;
$atributos["seleccion"]=0;//9
$atributos["evento"]=2;
$atributos["limitar"]=false;
$atributos["tamanno"]=1;
$atributos["estilo"]="jqueryui";
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
//-----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos["cadena_sql"]=$this->sql->cadena_sql("buscarSedes");
$atributos["baseDatos"]="inventario";
echo $this->miFormulario->campoCuadroLista($atributos);

// //-------------Control cuadroTexto-----------------------
// $esteCampo="dependenciaSolicitante";
// $atributos["id"]=$esteCampo;
// $atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
// $atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
// $atributos["tabIndex"]=$tab++;
// $atributos["obligatorio"]=true;
// $atributos["tamanno"]="";
// $atributos["tipo"]="";
// $atributos["estilo"]="jqueryui";
// $atributos["columnas"]="2";
// $atributos["validar"]="required";
// echo $this->miFormulario->campoCuadroTexto($atributos);
// unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo="dependenciaSolicitante";
$atributos["id"]=$esteCampo;
$atributos["tabIndex"]=$tab++;
$atributos["seleccion"]=0;//110
$atributos["evento"]=2;
$atributos["limitar"]=false;
$atributos["tamanno"]=1;
$atributos["estilo"]="jqueryui";
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
//-----De donde rescatar los datos ---------
$atributos["cadena_sql"]=$this->sql->cadena_sql("buscarDependencia");
$atributos["baseDatos"]="inventario";
echo $this->miFormulario->campoCuadroLista($atributos);

// //-------------Control cuadroTexto-----------------------
$esteCampo="jefeDependenciaSolicitante";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]="";
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["columnas"]="2";
$atributos["validar"]="required";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
// $esteCampo="jefeDependenciaSolicitante";
// $atributos["id"]=$esteCampo;
// $atributos["tabIndex"]=$tab++;
// $atributos["seleccion"]=0;//110
// $atributos["evento"]=2;
// $atributos["limitar"]=false;
// $atributos["tamanno"]=1;
// $atributos["estilo"]="jqueryui";
// $atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
// //-----De donde rescatar los datos ---------
// $atributos["cadena_sql"]=$this->sql->cadena_sql("buscarUsuario");
// $atributos["baseDatos"]="inventario";
// echo $this->miFormulario->campoCuadroLista($atributos);

//-------------Control cuadroTexto-----------------------
// $esteCampo="dependenciaJefe";
// $atributos["id"]=$esteCampo;
// $atributos["tabIndex"]=$tab++;
// $atributos["seleccion"]=0;//110
// $atributos["evento"]=2;
// $atributos["limitar"]=false;
// $atributos["tamanno"]=1;
// $atributos["estilo"]="jqueryui";
// $atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
// //-----De donde rescatar los datos ---------
// $atributos["cadena_sql"]=$this->sql->cadena_sql("buscarJefeDependencia");
// $atributos["baseDatos"]="inventario";
// echo $this->miFormulario->campoCuadroLista($atributos);

//-------------Control cuadroTexto-----------------------
// $esteCampo="dependenciaJefe";
// $atributos["id"]=$esteCampo;
// $atributos["tabIndex"]=$tab++;
// $atributos["seleccion"]=0;//110
// $atributos["evento"]=2;
// $atributos["limitar"]=false;
// $atributos["tamanno"]=1;
// $atributos["estilo"]="jqueryui";
// $atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
// //-----De donde rescatar los datos ---------
// $atributos["cadena_sql"]=$this->sql->cadena_sql("buscarJefeDependencia");
// //var_dump($cadena_sql);exit;
// $atributos["baseDatos"]="inventario";
// echo $this->miFormulario->campoCuadroLista($atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo = "correoPrincipal";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["etiquetaObligatorio"] = true;
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = "40";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "required, custom[email], maxSize[40]";
$atributos["categoria"] = "";
$atributos["valor"] = "";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//Fin de Conjunto de Controles
echo $this->miFormulario->marcoAGrupacion("fin");

//-----------------Inicio de Conjunto de Controles----------------------------------------
$esteCampo="marcoDatos";
$atributos["estilo"]="jqueryui";
$atributos["leyenda"]=$this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->marcoAGrupacion("inicio",$atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo="fechaSolicitud";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
//$atributos["etiquetaObligatorio"]=true;
$atributos["tamanno"]="";
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["columnas"]="2"; //El control ocupa 47% del tamaño del formulario
$atributos["validar"]="required";
$atributos["categoria"]="";
$atributos["deshabilitado"]=true;
$atributos["valor"]=@date("d/m/y");
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo="tipoSolicitud";
$atributos["id"]=$esteCampo;
$atributos["tabIndex"]=$tab++;
$atributos["seleccion"]=0;
$atributos["evento"]=2;
$atributos["limitar"]=false;
$atributos["tamanno"]=1;
//usseless: El estilo en las listas desplegables se maneja registrando el widget menu en jquery
$atributos["estilo"]="jqueryui";
$atributos["columnas"]="2";
$atributos["ancho"]="60%";
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
//-----De donde rescatar los datos ---------
$atributos["cadena_sql"]=$this->sql->cadena_sql("buscarTipSolicitud");
$atributos["baseDatos"]="solicitud";
echo $this->miFormulario->campoCuadroLista($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo="idEstado";
$atributos["id"]=$esteCampo;
$atributos["tabIndex"]=$tab++;
$atributos["seleccion"]=2;
$atributos["evento"]=2;
$atributos["limitar"]=false;
$atributos["tamanno"]=1;
$atributos["estilo"]="jqueryui";
$atributos["deshabilitado"] = true;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
//-----De donde rescatar los datos ---------
$atributos["cadena_sql"]=$this->sql->cadena_sql("buscarEstado");
$atributos["baseDatos"]="solicitud";
echo $this->miFormulario->campoCuadroLista($atributos);

//Fin de Conjunto de Controles
echo $this->miFormulario->marcoAGrupacion("fin");

//-----------------Inicio de Conjunto de Controles----------------------------------------
$esteCampo="marcoAsunto";
$atributos["estilo"]="jqueryui";
$atributos["leyenda"]=$this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->marcoAGrupacion("inicio",$atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo="asuntoSolicitud";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]="20";
//$atributos["tipo"]="hidden";
$atributos["estilo"]="jqueryui";
$atributos["columnas"]="2";
$atributos["validar"]="required";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------

$esteCampo="observacion";
$atributos["id"]=$esteCampo;
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=false;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["columnas"]=40;
$atributos["filas"]=4;
$atributos["estilo"]="jqueryui";
echo $this->miFormulario->campoTextArea($atributos);
unset($atributos);

//Fin de Conjunto de Controles
echo $this->miFormulario->marcoAGrupacion("fin");

//------------------Division para los botones-------------------------
$atributos["id"]="botones";
$atributos["estilo"]="marcoBotones";
echo $this->miFormulario->division("inicio",$atributos);

//-------------Control Boton-----------------------
$esteCampo="botonAceptar";
$atributos["id"]=$esteCampo;
$atributos["tabIndex"]=$tab++;
$atributos["tipo"]="boton";
$atributos["estilo"]="";
$atributos["verificar"]=""; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
$atributos["tipoSubmit"]="jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
$atributos["valor"]=$this->lenguaje->getCadena($esteCampo);
$atributos["nombreFormulario"]=$nombreFormulario;
echo $this->miFormulario->campoBoton($atributos);
unset($atributos);
//-------------Fin Control Boton----------------------

$esteCampo = "botonCancelar";
$atributos["id"] = $esteCampo;
$atributos["tabIndex"] = $tab++;
$atributos["tipo"] = "boton";
$atributos["estilo"] = "";
$atributos["verificar"] = "true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
$atributos["tipoSubmit"] = "jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
$atributos["valor"] = $this->lenguaje->getCadena($esteCampo);
$atributos["nombreFormulario"] = $nombreFormulario;
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

//Fin del Formulario
echo $this->miFormulario->formulario("fin");
?>

