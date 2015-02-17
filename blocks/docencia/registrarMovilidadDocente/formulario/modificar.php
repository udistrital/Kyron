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
$valorCodificado = "&action=" . $esteBloque ['nombre'];
$valorCodificado .= "&opcion=actualizarDatos";
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado = $cripto->codificar ( $valorCodificado );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";

$tab = 1;


$esteCampo = "grupoModificar";
$atributos ["id"] = $esteCampo;
$atributos ["estilo"] = "jqueryui";
$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
echo $this->miFormulario->marcoAgrupacion ( "inicio",$atributos );
unset ( $atributos );

// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = $nombreFormulario;
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario ( "inicio", $atributos );

$conexion = "docencia";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

$id_movilidad = $_REQUEST['id_movilidad'];

$cadena_sql = $this->sql->cadena_sql ( "consultarMovilidad", $id_movilidad );
$resultadoMovilidad = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );


?>
    <?php
    $atributos ["id"] = "divDatos";
    $atributos ["estilo"] = "";
    // $atributos["estiloEnLinea"]="display:none";
    echo $this->miFormulario->division("inicio",$atributos);
        
    
    $esteCampo = "mensajeGeneralActualizar";
    $atributos ["id"] = $esteCampo; // Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
    $atributos ["etiqueta"] = "";
    $atributos ["estilo"] = "centrar";
    $atributos ["tipo"] = "warning";
    $atributos ["mensaje"] = $this->lenguaje->getCadena ( $esteCampo );
    echo $this->miFormulario->cuadroMensaje ( $atributos );
    unset ( $atributos );
    
    // ------------------Control Lista Desplegable------------------------------
    $esteCampo = "docente";
    $atributos ["id"] = $esteCampo;
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["seleccion"] = $resultadoMovilidad[0]['id_docente'];
    $atributos ["evento"] = 2;
    $atributos ["columnas"] = "1";
    $atributos ["limitar"] = false;
    $atributos ["tamanno"] = 1;
    $atributos ["ancho"] = "400px";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["etiquetaObligatorio"] = true;
    $atributos ["validar"] = "required";
    $atributos ["anchoEtiqueta"] = 300;
    $atributos ["obligatorio"] = true;
    $atributos ["deshabilitado"] = true;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    // -----De donde rescatar los datos ---------
    $atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarNombreDocente" );
    $atributos ["baseDatos"] = "estructura";
    echo $this->miFormulario->campoCuadroLista ( $atributos );
    unset ( $atributos );

$atributos ["id"] = "divTiquetes";
$atributos ["estilo"] = "anchoColumna1";
echo $this->miFormulario->division("inicio",$atributos);

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "tiquetesDep";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = $resultadoMovilidad[0]['tiquetesdep'];
$atributos ["evento"] = 2;
$atributos ["columnas"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "400px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = false;
$atributos ["anchoEtiqueta"] = 300;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "facultades" );
// echo $atributos["cadena_sql"];exit;
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "tiquetesEnt";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = $resultadoMovilidad[0]['tiquetesent'];
$atributos ["evento"] = 2;
$atributos ["columnas"] = 2; 
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "400px"; 
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = false;
$atributos ["anchoEtiqueta"] = 300;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "universidad" );
// echo $atributos["cadena_sql"];exit;
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

echo $this->miFormulario->division("fin");

$atributos ["id"] = "divInscripcion";
$atributos ["estilo"] = "anchoColumna1";
echo $this->miFormulario->division("inicio",$atributos);

$esteCampo = "inscripcionDep";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = $resultadoMovilidad[0]['inscripciondep'];
$atributos ["evento"] = 2;
$atributos ["columnas"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "400px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = false;
$atributos ["anchoEtiqueta"] = 300;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "facultades" );
// echo $atributos["cadena_sql"];exit;
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

$esteCampo = "inscripcionEnt";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = $resultadoMovilidad[0]['inscripcionent'];
$atributos ["evento"] = 2;
$atributos ["columnas"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "400px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = false;
$atributos ["anchoEtiqueta"] = 300;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "universidad" );
// echo $atributos["cadena_sql"];exit;
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

echo $this->miFormulario->division("fin");

$atributos ["id"] = "divViaticos";
$atributos ["estilo"] = "anchoColumna1";
echo $this->miFormulario->division("inicio",$atributos);

$esteCampo = "viaticosDep";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = $resultadoMovilidad[0]['viaticosdep'];
$atributos ["evento"] = 2;
$atributos ["columnas"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "400px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = false;
$atributos ["anchoEtiqueta"] = 300;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "facultades" );
// echo $atributos["cadena_sql"];exit;
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

$esteCampo = "viaticosEnt";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = $resultadoMovilidad[0]['viaticosent'];
$atributos ["evento"] = 2;
$atributos ["columnas"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "400px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = false;
$atributos ["anchoEtiqueta"] = 300;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "universidad" );
// echo $atributos["cadena_sql"];exit;
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

echo $this->miFormulario->division("fin");

$atributos ["id"] = "divViaticos";
$atributos ["estilo"] = "anchoColumna1";
echo $this->miFormulario->division("inicio",$atributos);

$esteCampo = "ponenciaPresentar";
$atributos ["id"] = $esteCampo; // No cambiar este nombre
$atributos ["tipo"] = "file";
$atributos ["obligatorio"] = false;
$atributos ["estilo"] = "jqueryui";
$atributos ["tabIndex"] = $tab ++;
$atributos ["columnas"] = 1;
$atributos ["anchoEtiqueta"] = 300;
$atributos ["tamanno"] =500000;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );

echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// -------------Control cuadroTexto con campos ocultos-----------------------
// Para pasar variables entre formularios o enviar datos para validar sesiones
$esteCampo = "documentoAceptacion";
$atributos ["id"] = $esteCampo; // No cambiar este nombre
$atributos ["tipo"] = "file";
$atributos ["obligatorio"] = false;
$atributos ["estilo"] = "jqueryui";
$atributos ["tabIndex"] = $tab ++;
$atributos ["columnas"] = 1;
$atributos ["anchoEtiqueta"] = 300;
$atributos ["tamanno"] =500000;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["valor"] = $valorCodificado;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

echo $this->miFormulario->division("fin");

// ------------------Division para los botones-------------------------
$atributos ["id"] = "botones";
$atributos ["estilo"] = "marcoBotones";
echo $this->miFormulario->division ( "inicio", $atributos );
				
    // ------------------Fin Division para los botones-------------------------
    // echo $this->miFormulario->division("fin");

    // ------------------Division para los botones-------------------------
    $atributos ["id"] = "botones";
    $atributos ["estilo"] = "marcoBotones";
    echo $this->miFormulario->division ( "inicio", $atributos );

    // -------------Control Boton-----------------------
    $esteCampo = "botonCancelar";
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
    
    echo $this->miFormulario->marcoAgrupacion ( "fin" );

    ?>
