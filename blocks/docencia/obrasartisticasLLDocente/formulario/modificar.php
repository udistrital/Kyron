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

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

$id_obra = $_REQUEST['id_obra'];

$cadena_sql = $this->sql->cadena_sql ( "consultarObraModificar", $id_obra );
$resultadoObra = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

$atributos ["id"] = "divDatos";
    $atributos ["estilo"] = "";
    // $atributos["estiloEnLinea"]="display:none";
    echo $this->miFormulario->division("inicio",$atributos);
    
    $atributos ["id"] = "id_obra"; // No cambiar este nombre
    $atributos ["tipo"] = "hidden";
    $atributos ["valor"] = $id_obra;
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );

    $esteCampo = "docente"; 
    $atributos ["id"] = $esteCampo;
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["seleccion"] = $resultadoObra[0]['id_docente'];
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
    $atributos ["deshabilitado"] = true;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    // -----De donde rescatar los datos ---------
    $atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarNombreDocente" );
    $atributos ["baseDatos"] = "estructura";
    echo $this->miFormulario->campoCuadroLista ( $atributos );
    unset ( $atributos );

    // ------------------Control Lista Desplegable------------------------------
    $esteCampo = "tipo_obra_artistica";
    $atributos ["id"] = $esteCampo;
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["seleccion"] = $resultadoObra[0]['tipo_obra'];
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
    $atributos ["cadena_sql"] = $this->sql->cadena_sql ( "tipo_obra" );
    $atributos ["baseDatos"] = "estructura";
    echo $this->miFormulario->campoCuadroLista ( $atributos );
    unset ( $atributos );

    $esteCampo = "titulo_obra";
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
    $atributos ["validar"] = "required, minSize[5], maxSize[250]";
    $atributos ["valor"] = $resultadoObra[0]['titulo_obra'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );


    $esteCampo = "medio_publi";
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
    $atributos ["validar"] = "required, minSize[1], maxSize[250]";
    $atributos ["valor"] = $resultadoObra[0]['medio_public'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );




    $esteCampo = "fechaObra";
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
    $atributos ["anchoEtiqueta"] = 300;
    $atributos ["validar"] = "required";
    $atributos ["categoria"] = "fecha";
    $atributos ["valor"] = $resultadoObra[0]['fecha_obra'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );

    $esteCampo = "numeActa";
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
    $atributos ["validar"] = "required, minSize[1], maxSize[30]";
    $atributos ["valor"] = $resultadoObra[0]['nume_acta'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );

    $esteCampo = "fechaActa";
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
    $atributos ["anchoEtiqueta"] = 300;
    $atributos ["validar"] = "required";
    $atributos ["categoria"] = "fecha";
    $atributos ["valor"] = $resultadoObra[0]['fech_acta'];
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
    $atributos ["etiquetaObligatorio"] = false;
    $atributos ["tipo"] = "";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["anchoEtiqueta"] = 300;
    $atributos ["validar"] = "required, minSize[1], maxSize[30],custom[onlyNumberSp]";
    $atributos ["valor"] = $resultadoObra[0]['nume_caso'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );
    
    switch($resultadoObra[0]['tipo_obra'])
    {
        case 1:
            
            $puntMax = ', max[72]';
            
            break;
        case 2:
            
            $puntMax = ', max[48]';
            
            break;
        case 3:
            
            $puntMax = ', max[48]';
            
            break;
    }

    $esteCampo = "puntaje";
    $atributos ["id"] = $esteCampo;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["obligatorio"] = true;
    $atributos ["tamanno"] = 5;
    $atributos ["columnas"] = 1;
    $atributos ["etiquetaObligatorio"] = false;
    $atributos ["tipo"] = "";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["anchoEtiqueta"] = 300;
    $atributos ["validar"] = "required, custom[number], condRequired[tipo_obra_artistica], min[0.1]".$puntMax;
    $atributos ["deshabilitado"] = false;
    $atributos ["valor"] = $resultadoObra[0]['puntaje'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );

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
    $atributos["anchoEtiqueta"] = 300;
    $atributos["validar"]="required";
    $atributos["categoria"]="";
    $atributos ["valor"] = $resultadoObra [0] ['detalledocencia'];
    echo $this->miFormulario->campoTextArea($atributos);
    unset($atributos);	
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
