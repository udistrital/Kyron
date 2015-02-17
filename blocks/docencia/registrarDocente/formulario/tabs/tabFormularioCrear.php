<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$miSesion = Sesion::singleton ();

$nombreFormulario = $esteBloque ["nombre"];

include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton ();
$valorCodificado .= "&action=" . $esteBloque ['nombre'];
$valorCodificado .= "&opcion=guardarDatos";
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado = $cripto->codificar ( $valorCodificado );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";

$tab = 1;
// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = $nombreFormulario;
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario ( "inicio", $atributos );

$conexion = "docencia";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

$atributos["id"] = "paso1";
$atributos["leyenda"] = "Consultar Funcionario";
echo $this->miFormulario->agrupacion("inicio",$atributos);

$atributos ["id"] = "divMensaje";
$atributos ["estilo"] = "marcoBotones";
// $atributos["estiloEnLinea"]="display:none";
echo $this->miFormulario->division ( "inicio", $atributos );

$esteCampo = "mensajeValidacion";
$atributos ["id"] = $esteCampo; // Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
$atributos ["etiqueta"] = "";
$atributos ["estilo"] = "centrar";
$atributos ["tipo"] = "warning";
$atributos ["mensaje"] = $this->lenguaje->getCadena ( $esteCampo );
echo $this->miFormulario->cuadroMensaje ( $atributos );
unset ( $atributos );

// ------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division ( "fin" );

$esteCampo = "tipoDocumento";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
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
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "tipoDocumento" );
$atributos ["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista ( $atributos );

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "identificacionDocente";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 15;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, minSize[1],maxSize[15], custom[onlyNumberSp]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );   

// ------------------Control Lista Desplegable------------------------------
/*
$esteCampo = "codigoInterno";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 15;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = false;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "minSize[1],maxSize[8], custom[onlyNumberSp]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );
*/
// ------------------Division para los botones-------------------------
$atributos ["id"] = "botones";
$atributos ["estilo"] = "marcoBotones";
echo $this->miFormulario->division ( "inicio", $atributos );

// -------------Control Boton-----------------------
$esteCampo = "botonValidar";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["tipo"] = "boton";
$atributos ["onclick"] = "validarFuncionario()";
$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["nombreFormulario"] = $nombreFormulario;
echo $this->miFormulario->campoBoton ( $atributos );
unset ( $atributos );
// -------------Fin Control Boton----------------------

// ------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division ( "fin" );

// ------------------Division para los botones-------------------------
$atributos ["id"] = "infoFuncionario";
$atributos ["estiloEnLinea"] = "display:none";
echo $this->miFormulario->division ( "inicio", $atributos );

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "codigo";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["obligatorio"] = true;
$atributos ["tabIndex"] = $tab ++;
$atributos ["tamanno"] = 15;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 200;
$atributos ["validar"] = "required";
$atributos ["deshabilitado"] = true;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );
// ------------------Control Lista Desplegable------------------------------
$esteCampo = "nombre";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["obligatorio"] = true;
$atributos ["tabIndex"] = $tab ++;
$atributos ["tamanno"] = 60;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 200;
$atributos ["validar"] = "required";
$atributos ["deshabilitado"] = true;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );
// ------------------Control Lista Desplegable------------------------------
$esteCampo = "apellido";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["obligatorio"] = true;
$atributos ["tabIndex"] = $tab ++;
$atributos ["tamanno"] = 60;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 200;
$atributos ["validar"] = "required";
$atributos ["deshabilitado"] = true;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );
// ------------------Control Lista Desplegable------------------------------
$esteCampo = "fecha_nac";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["obligatorio"] = true;
$atributos ["tabIndex"] = $tab ++;
$atributos ["tamanno"] = 15;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 200;
$atributos ["validar"] = "required";
$atributos ["deshabilitado"] = true;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );
// ------------------Control Lista Desplegable------------------------------
$esteCampo = "direccion";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["obligatorio"] = true;
$atributos ["tabIndex"] = $tab ++;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 200;
$atributos ["validar"] = "required";
$atributos ["deshabilitado"] = true;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );
// ------------------Control Lista Desplegable------------------------------
$esteCampo = "telefono";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["obligatorio"] = true;
$atributos ["tabIndex"] = $tab ++;
$atributos ["tamanno"] = 15;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 200;
$atributos ["validar"] = "required";
$atributos ["deshabilitado"] = true;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );
// ------------------Control Lista Desplegable------------------------------
$esteCampo = "celular";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["obligatorio"] = true;
$atributos ["tabIndex"] = $tab ++;
$atributos ["tamanno"] = 15;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 200;
$atributos ["validar"] = "required";
$atributos ["deshabilitado"] = true;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );
// ------------------Control Lista Desplegable------------------------------
$esteCampo = "correo";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["obligatorio"] = true;
$atributos ["tabIndex"] = $tab ++;
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 200;
$atributos ["validar"] = "required";
$atributos ["deshabilitado"] = true;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// ------------------Control Hidden------------------------------
$esteCampo = "ciudad";
$atributos ["id"] = $esteCampo;
$atributos ["tipo"] = "hidden";
$atributos ["tabIndex"] = $tab ++;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// ------------------Control Hidden------------------------------
$esteCampo = "sexo";
$atributos ["id"] = $esteCampo;
$atributos ["tipo"] = "hidden";
$atributos ["tabIndex"] = $tab ++;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// ------------------Control Hidden------------------------------
$esteCampo = "estado_civil";
$atributos ["id"] = $esteCampo;
$atributos ["tipo"] = "hidden";
$atributos ["tabIndex"] = $tab ++;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );


// ------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division ( "fin" );

// ------------------Division para los botones-------------------------
$atributos ["id"] = "errorWs";
$atributos ["estiloEnLinea"] = "display:none";
echo $this->miFormulario->division ( "inicio", $atributos );

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "errorCampo";
$atributos ["id"] = $esteCampo;
$atributos ["estilo"] = "error";
$atributos ["tamanno"] = "pequenno";
$atributos ["mensaje"] = "Verifique todos los campos";
echo $this->miFormulario->campoMensaje( $atributos );
unset ( $atributos );

// ------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division ( "fin" );


echo $this->miFormulario->agrupacion("fin");

$atributos["id"] = "paso2";
$atributos["leyenda"] = "Información del Docente";
echo $this->miFormulario->agrupacion("inicio",$atributos);

// //-------------Control cuadroTexto-----------------------
$esteCampo = "fechaIngreso";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=false;
$atributos["tamanno"]=10;
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos ["anchoEtiqueta"] = 400;
$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"]="required, minSize[3]";
$atributos["categoria"]="fecha";
echo $this->miFormulario->campoCuadroTexto($atributos);                              

// //-------------Control cuadroTexto-----------------------
$esteCampo = "resolucionNombramiento";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tipo"] = "";
$atributos["tamanno"]=10;
$atributos ["anchoEtiqueta"] = 400;
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required, minSize[1], maxSize[25], custom[onlyNumberSp]";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "documentoResolucion";
$atributos ["id"] = $esteCampo; // No cambiar este nombre
$atributos ["tipo"] = "file";
$atributos ["obligatorio"] = false;
$atributos ["estilo"] = "jqueryui";
$atributos ["tabIndex"] = $tab ++;
$atributos ["columnas"] = 1;
$atributos ["anchoEtiqueta"] = 400;
$atributos ["validar"] = "required";
$atributos ["tamanno"] =500000;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["valor"] = $valorCodificado;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );


// //-------------Control cuadroTexto-----------------------
$esteCampo = "dedicacion";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = - 1;
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "200px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 400;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscardedicacion" );
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "fechaInicio";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=false;
$atributos["tamanno"]="10";
$atributos["tipo"]="";
$atributos["tamanno"]=10;
$atributos ["anchoEtiqueta"] = 400;
$atributos["estilo"]="jqueryui";
$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"]="required, minSize[3]";
$atributos["categoria"]="fecha";

echo $this->miFormulario->campoCuadroTexto($atributos);                              

// //-------------Control cuadroTexto-----------------------
$esteCampo = "documentoPrueba";
$atributos ["id"] = $esteCampo; // No cambiar este nombre
$atributos ["tipo"] = "file";
$atributos ["obligatorio"] = false;
$atributos ["estilo"] = "jqueryui";
$atributos ["tabIndex"] = $tab ++;
$atributos ["columnas"] = 1;
$atributos ["anchoEtiqueta"] = 400;
$atributos ["validar"] = "required";
$atributos ["tamanno"] =500000;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["valor"] = $valorCodificado;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "documentoFinal";
$atributos ["id"] = $esteCampo; // No cambiar este nombre
$atributos ["tipo"] = "file";
$atributos ["obligatorio"] = false;
$atributos ["estilo"] = "jqueryui";
$atributos ["tabIndex"] = $tab ++;
$atributos ["columnas"] = 1;
$atributos ["anchoEtiqueta"] = 400;
$atributos ["validar"] = "required";
$atributos ["tamanno"] =500000;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["valor"] = $valorCodificado;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "documentoConcepto";
$atributos ["id"] = $esteCampo; // No cambiar este nombre
$atributos ["tipo"] = "file";
$atributos ["obligatorio"] = false;
$atributos ["estilo"] = "jqueryui";
$atributos ["tabIndex"] = $tab ++;
$atributos ["columnas"] = 1;
$atributos ["anchoEtiqueta"] = 400;
$atributos ["validar"] = "required";
$atributos ["tamanno"] =500000;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["valor"] = $valorCodificado;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );



echo $this->miFormulario->agrupacion("fin");

$atributos["id"] = "paso3";
$atributos["leyenda"] = "Información Adicional";
echo $this->miFormulario->agrupacion("inicio",$atributos);


// //-------------Control cuadroTexto-----------------------
$esteCampo = "facultadCrear";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = - 1;
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "200px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarfacultad" );
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "proyectoCurricular";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = - 1;
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "200px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarproyectoc" );
$atributos ["baseDatos"] = "docencia";

echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "categoriaActual";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = - 1;
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "200px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarCategoria" );
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );


// //-------------Control cuadroTexto-----------------------
$esteCampo = "correoInstitucional";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["etiquetaObligatorio"] = true;
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = 40;
$atributos ["anchoEtiqueta"] = 350;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "required, custom[email], maxSize[40]";
$atributos["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

$esteCampo = "numeActa";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 29;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30], custom[onlyNumberSp]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "fechaActa";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 8;
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

$esteCampo = "numeCaso";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 29;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30],custom[onlyNumberSp]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

echo $this->miFormulario->agrupacion("fin");

// ------------------Division para los botones-------------------------
$atributos ["id"] = "botones";
$atributos ["estilo"] = "marcoBotones";
echo $this->miFormulario->division ( "inicio", $atributos );

// -------------Control Boton-----------------------
$esteCampo = "botonGuardar";
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

// ------------------Fin Division para los botones-------------------------
// echo $this->miFormulario->division("fin");



// -------------Control cuadroTexto con campos ocultos-----------------------
// Para pasar variables entre formularios o enviar datos para validar sesiones
$atributos ["id"] = "formSaraData"; // No cambiar este nombre
$atributos ["tipo"] = "hidden";
$atributos ["obligatorio"] = false;
$atributos ["etiqueta"] = "";
$atributos ["valor"] = $valorCodificado;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// Fin del Formulario
echo $this->miFormulario->formulario ( "fin" );

?>
