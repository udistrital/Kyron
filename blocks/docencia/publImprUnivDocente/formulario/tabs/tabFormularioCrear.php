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

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );



$atributos ["id"] = "divDatos";
$atributos ["estilo"] = "marcoBotones";
// $atributos["estiloEnLinea"]="display:none";
// echo $this->miFormulario->division("inicio",$atributos);

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "docente";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = -1;
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "450px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 300;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarNombreDocente" );
$atributos ["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

$esteCampo = "tituloPublicacion";
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
$atributos ["anchoEtiqueta"] = 300;
$atributos ["validar"] = "required, minSize[6], maxSize[2000]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "fechaPublicacion";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "40";
$atributos ["ancho"] = 350;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["deshabilitado"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 300;
$atributos ["validar"] = "required";
$atributos ["categoria"] = "fecha";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "codigoNumeracion";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = - 1;
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "340px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 300;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "numPublicaciones" );
$atributos ["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = "Trevista";
$atributos ["estilo"] = "campoTexto";
$atributos ["estiloEnLinea"] = "display:none";
$verificarFormulario = "1";
echo $this->miFormulario->division ( "inicio", $atributos );

$esteCampo = "revistaPublicacion";
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
$atributos ["anchoEtiqueta"] = 300;
$atributos ["validar"] = "required, minSize[6],maxSixe[2000]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "num_revista";
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
$atributos ["anchoEtiqueta"] = 300;
$atributos ["validar"] = "required, minSize[1],maxSize[15],custom[onlyNumberSp]";
$atributos ["categoria"] = "";
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
$atributos ["anchoEtiqueta"] = 300;
$atributos ["validar"] = "required, minSize[1],maxSize[15],custom[onlyNumberSp]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "anioR";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 4;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 300;
$atributos ["validar"] = "required";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "categoria_revista";
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
$atributos ["anchoEtiqueta"] = 300;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "tipo_revista" );
$atributos ["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

echo $this->miFormulario->division ( "fin" );

$atributos ["id"] = "Tlibro";
$atributos ["estilo"] = "campoTexto";
$atributos ["estiloEnLinea"] = "display:none";
$verificarFormulario = "1";
echo $this->miFormulario->division ( "inicio", $atributos );

$esteCampo = "nom_libro";
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
$atributos ["anchoEtiqueta"] = 300;
$atributos ["validar"] = "required, minSize[6],maxSize[2000]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "editorial";
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
$atributos ["anchoEtiqueta"] = 300;
$atributos ["validar"] = "required, minSize[1],maxSize[2000]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "anioL";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 4;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 300;
$atributos ["validar"] = "required, minSize[4], maxSize[4],custom[onlyNumberSp]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );
echo $this->miFormulario->division ( "fin" );

$esteCampo = "numeActa";
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
$atributos ["anchoEtiqueta"] = 300;
$atributos ["validar"] = "required, minSize[1],maxSize[15],custom[onlyNumberSp]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "fechaActa";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "33";
$atributos ["ancho"] = 10;	
$atributos ["etiquetaObligatorio"] = true;
$atributos ["deshabilitado"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 300;
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
$atributos ["tamanno"] = 40;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 300;
$atributos ["validar"] = "required, minSize[1],maxSize[15],custom[onlyNumberSp]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "puntaje";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 5;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 300;
$atributos ["validar"] = "required, custom[number],min[0.1],max[60]";
$atributos ["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// ------------------Fin Division para los botones-------------------------
// echo $this->miFormulario->division("fin");

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
