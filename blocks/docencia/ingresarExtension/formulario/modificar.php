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

$id_extension = $_REQUEST['id_extension'];

$cadena_sql = $this->sql->cadena_sql ( "consultarExtensionEsp", $id_extension );
$resultadoExtension = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );


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
    $atributos ["seleccion"] = $resultadoExtension[0]['docente_extension'];
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

// ------------------Control Lista Desplegable------------------------------
    $esteCampo = "nombreCurso";
    $atributos ["id"] = $esteCampo;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["obligatorio"] = true;
    $atributos ["tamanno"] = 40;
    $atributos ["columnas"] = 1;
    $atributos ["etiquetaObligatorio"] = false;
    $atributos ["tipo"] = "";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["anchoEtiqueta"] = 300;
    $atributos ["validar"] = "required, minSize[3], maxSize[200]";
    $atributos ["valor"] = $resultadoExtension[0]['curso_extension'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );

    // ------------------Control Lista Desplegable------------------------------
    $esteCampo = "monto";				
    $atributos ["id"] = $esteCampo;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["obligatorio"] = true;
    $atributos ["tamanno"] = 40;
    $atributos ["columnas"] = 1;
    $atributos ["etiquetaObligatorio"] = false;
    $atributos ["tipo"] = "";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["anchoEtiqueta"] = 300;
    $atributos ["validar"] = "required, minSize[1], custom[onlyNumberSp]";
    $atributos ["categoria"] = "";
    $atributos ["valor"] = $resultadoExtension[0]['monto_extension'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );

    $esteCampo = "recibio";
    $atributos ["id"] = $esteCampo;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["obligatorio"] = true;
    $atributos ["tamanno"] = 40;
    $atributos ["columnas"] = 1;
    $atributos ["etiquetaObligatorio"] = false;
    $atributos ["tipo"] = "";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["anchoEtiqueta"] = 300;
    $atributos ["validar"] = "required, minSize[1]";
    $atributos ["valor"] = $resultadoExtension[0]['recibio_extension'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );

    $esteCampo = "fechaInicio";
    $atributos ["id"] = $esteCampo;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["obligatorio"] = true;
    $atributos ["tamanno"] = "20";
    $atributos ["ancho"] = 350;
    $atributos ["etiquetaObligatorio"] = false;
    $atributos ["deshabilitado"] = true;
    $atributos ["tipo"] = "";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["anchoEtiqueta"] = 300;
    $atributos ["validar"] = "required";
    $atributos ["categoria"] = "fecha";
    $atributos ["valor"] = $resultadoExtension[0]['inifecha_extension'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );

    $esteCampo = "fechaFinalizacion";
    $atributos ["id"] = $esteCampo;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["obligatorio"] = true;
    $atributos ["tamanno"] = "20";
    $atributos ["ancho"] = 350;
    $atributos ["etiquetaObligatorio"] = false;
    $atributos ["deshabilitado"] = true;
    $atributos ["tipo"] = "";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["anchoEtiqueta"] = 300;
    $atributos ["validar"] = "required";
    $atributos ["categoria"] = "fecha";
    $atributos ["valor"] = $resultadoExtension[0]['finfecha_extension'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );

    $esteCampo = "duracion";
    $atributos ["id"] = $esteCampo;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["obligatorio"] = true;
    $atributos ["tamanno"] = 10;
    $atributos ["columnas"] = 1;
    $atributos ["etiquetaObligatorio"] = false;
    $atributos ["deshabilitado"] = true;
    $atributos ["tipo"] = "";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["anchoEtiqueta"] = 300;
    $atributos ["validar"] = "required, minSize[1]";
    $atributos ["categoria"] = "";
    $atributos ["valor"] = $resultadoExtension[0]['duracion_extension'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );

    // ------------------Control Lista Desplegable------------------------------
    $esteCampo = "soporte";
    $atributos ["id"] = $esteCampo;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["obligatorio"] = true;
    $atributos ["tamanno"] = 50000;
    $atributos ["columnas"] = 1;
    $atributos ["etiquetaObligatorio"] = false;
    $atributos ["tipo"] = "file";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["anchoEtiqueta"] = 300;
    $atributos ["categoria"] = "";
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );

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
