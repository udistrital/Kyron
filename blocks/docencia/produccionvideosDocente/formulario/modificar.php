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

$id_video = $_REQUEST['idvideo'];

$cadena_sql = $this->sql->cadena_sql ( "consultarVideo", $id_video );
$resultadoVideos = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

    $atributos ["id"] = "divDatos";
    $atributos ["estilo"] = "";
    // $atributos["estiloEnLinea"]="display:none";
    echo $this->miFormulario->division("inicio",$atributos);
        
    // ------------------Control Lista Desplegable------------------------------
    $esteCampo = "docente";
    $atributos ["id"] = $esteCampo;
    $atributos ["tipo"] = "hidden";
    $atributos ["valor"] = $resultadoVideos [0] ['id_docente'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );
    
    // ------------------Control Lista Desplegable------------------------------
    $esteCampo = "titulo_video";
    $atributos ["id"] = $esteCampo;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["obligatorio"] = true;
    $atributos ["tamanno"] = 50;
    $atributos ["columnas"] = 1;
    $atributos ["etiquetaObligatorio"] = false;
    $atributos ["tipo"] = "";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["anchoEtiqueta"] = 350;
    $atributos ["validar"] = "required, minSize[6], maxSize[120]";
    $atributos ["categoria"] = "";
    $atributos ["valor"] = $resultadoVideos [0] ['titulo_video'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );

    // ------------------Control Lista Desplegable------------------------------
    $esteCampo = "numAuto";
    $atributos ["id"] = $esteCampo;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["obligatorio"] = true;
    $atributos ["tamanno"] = 30;
    $atributos ["columnas"] = 1;
    $atributos ["etiquetaObligatorio"] = false;
    $atributos ["tipo"] = "";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["anchoEtiqueta"] = 350;
    $atributos ["validar"] = "required, minSize[1], maxSize[50],custom[onlyNumberSp]";
    $atributos ["categoria"] = "";
    $atributos ["valor"] = $resultadoVideos [0] ['nume_auto'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    
    // ------------------Control Lista Desplegable------------------------------
    $esteCampo = "numAutoUD";
    $atributos ["id"] = $esteCampo;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["obligatorio"] = true;
    $atributos ["tamanno"] = 30;
    $atributos ["columnas"] = 1;
    $atributos ["etiquetaObligatorio"] = false;
    $atributos ["tipo"] = "";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["anchoEtiqueta"] = 350;
    $atributos ["validar"] = "required, minSize[1], maxSize[50],custom[onlyNumberSp]";
    $atributos ["categoria"] = "";
    $atributos ["valor"] = $resultadoVideos [0] ['nume_autoud'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );

    $esteCampo = "fechaVideo";
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
    $atributos ["valor"] = $resultadoVideos [0] ['fech_video'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );

    // ------------------Control Lista Desplegable------------------------------
    $esteCampo = "impacto";
    $atributos ["id"] = $esteCampo;
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["seleccion"] = $resultadoVideos [0] ['impacto'];
    $atributos ["evento"] = 2;
    $atributos ["columnas"] = "1";
    $atributos ["limitar"] = false;
    $atributos ["tamanno"] = 1;
    $atributos ["ancho"] = "350px";
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
    
    // ------------------Control Lista Desplegable------------------------------
    $esteCampo = "caracter";
    $atributos ["id"] = $esteCampo;
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["seleccion"] = $resultadoVideos [0] ['caracter'];
    $atributos ["evento"] = 2;
    $atributos ["columnas"] = "1";
    $atributos ["limitar"] = false;
    $atributos ["tamanno"] = 1;
    $atributos ["ancho"] = "350px";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["etiquetaObligatorio"] = true;
    $atributos ["validar"] = "required";
    $atributos ["anchoEtiqueta"] = 350;
    $atributos ["obligatorio"] = true;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    // -----De donde rescatar los datos ---------
    $atributos ["cadena_sql"] = array(array('1','Científico, Técnico Artístico, Humorístico o Pedagógico.'),array('2','Documental'));
    $atributos ["baseDatos"] = "estructura";
    echo $this->miFormulario->campoCuadroLista ( $atributos );
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
    $atributos ["anchoEtiqueta"] = 350;
    $atributos ["validar"] = "required, minSize[1], min[1], maxSize[30]";
    $atributos ["categoria"] = "";
    $atributos ["valor"] = $resultadoVideos [0] ['nume_acta'];
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
    $atributos ["anchoEtiqueta"] = 350;
    $atributos ["validar"] = "required";
    $atributos ["categoria"] = "fecha";
    $atributos ["valor"] = $resultadoVideos [0] ['fech_acta'];
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
    $atributos ["anchoEtiqueta"] = 350;
    $atributos ["validar"] = "required, minSize[1], maxSize[18],custom[onlyNumberSp]";
    $atributos ["categoria"] = "";
    $atributos ["valor"] = $resultadoVideos [0] ['nume_caso'];
    echo $this->miFormulario->campoCuadroTexto ( $atributos );
    unset ( $atributos );
        
    $esteCampo = "grupoEvaluadores";
    $atributos ["id"] = $esteCampo;
    $atributos ["estilo"] = "jqueryui";
    $atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
    echo $this->miFormulario->marcoAgrupacion ( "inicio",$atributos );
    unset ( $atributos );
    
    $cadena_sql = $this->sql->cadena_sql ( "consultarEvaluadoresVideo", $id_video );
    $resultadoEvaluadoresVideos = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

    // ------------------Control Lista Desplegable------------------------------
    $esteCampo = "numEvaluadores";
    $atributos ["id"] = $esteCampo;
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["seleccion"] = count($resultadoEvaluadoresVideos);
    $atributos ["evento"] = 2;
    $atributos ["columnas"] = "1";
    $atributos ["limitar"] = false;
    $atributos ["tamanno"] = 1;
    $atributos ["ancho"] = "110px";
    $atributos ["estilo"] = "jqueryui";
    $atributos ["etiquetaObligatorio"] = true;
    $atributos ["validar"] = "required";
    $atributos ["anchoEtiqueta"] = 350;
    $atributos ["obligatorio"] = true;
    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
    // -----De donde rescatar los datos ---------
    $atributos ["cadena_sql"] = array(array('2','2'),array('3','3'));
    $atributos ["baseDatos"] = "estructura";
    echo $this->miFormulario->campoCuadroLista ( $atributos );
    unset ( $atributos );

    for($j=0;$j<3;$j++)
    {
        if(isset($resultadoEvaluadoresVideos[$j]['id_revisores']) && $resultadoEvaluadoresVideos[$j]['id_revisores'] != '')
            {
                $atributos ["id"] = "divEv".($j+1);
                $atributos ["estilo"] = "anchoColumna1";
                echo $this->miFormulario->division("inicio",$atributos);
                
                // -------------Control cuadroTexto con campos ocultos-----------------------
                $atributos ["id"] = "id_revisor".($j+1); 
                $atributos ["tipo"] = "hidden";
                $atributos ["obligatorio"] = false;
                $atributos ["etiqueta"] = "";
                $atributos ["valor"] = $resultadoEvaluadoresVideos[$j]['id_revisores'];
                echo $this->miFormulario->campoCuadroTexto ( $atributos );
                unset ( $atributos );

                $esteCampo = "nomEvaluador".($j+1);
                $atributos ["id"] = $esteCampo;
                $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
                $atributos ["tabIndex"] = $tab ++;
                $atributos ["obligatorio"] = false;
                $atributos ["tamanno"] = 30;
                $atributos ["columnas"] = 3;
                $atributos ["etiquetaObligatorio"] = false;
                $atributos ["tipo"] = "";
                $atributos ["estilo"] = "jqueryui";
                $atributos ["anchoEtiqueta"] = 200;
                $atributos ["validar"] = "required, minSize[6], maxSize[50]";
                $atributos ["valor"] = $resultadoEvaluadoresVideos[$j]['revisor_autor'];
                $atributos ["categoria"] = "";
                echo $this->miFormulario->campoCuadroTexto ( $atributos );
                unset ( $atributos );

                // ------------------Control Lista Desplegable------------------------------
                $esteCampo = "uniEvaluador".($j+1);
                $atributos ["id"] = $esteCampo;
                $atributos ["tabIndex"] = $tab ++;
                $atributos ["seleccion"] = $resultadoEvaluadoresVideos[$j]['revisor_institucion'];
                $atributos ["evento"] = 2;
                $atributos ["columnas"] = 3;
                $atributos ["limitar"] = false;
                $atributos ["tamanno"] = 1;
                $atributos ["ancho"] = "200px";
                $atributos ["estilo"] = "jqueryui";
                $atributos ["etiquetaObligatorio"] = false;
                $atributos ["validar"] = "required";
                $atributos ["anchoEtiqueta"] = 200;
                $atributos ["obligatorio"] = true;
                $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                // -----De donde rescatar los datos ---------
                $atributos ["cadena_sql"] = $this->sql->cadena_sql ( "universidad" );
                // echo $atributos["cadena_sql"];exit;
                $atributos ["baseDatos"] = "estructura";
                echo $this->miFormulario->campoCuadroLista ( $atributos );
                unset ( $atributos );

                $esteCampo = "puntEvaluador".($j+1);
                $atributos ["id"] = $esteCampo;
                $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
                $atributos ["tabIndex"] = $tab ++;
                $atributos ["obligatorio"] = false;
                $atributos ["tamanno"] = 10;
                $atributos ["columnas"] = 3;
                $atributos ["etiquetaObligatorio"] = false;
                $atributos ["tipo"] = "";
                $atributos ["estilo"] = "jqueryui";
                $atributos ["anchoEtiqueta"] = 155;
                $atributos ["validar"] = "required, minSize[1],custom[number]";
                $atributos ["valor"] = $resultadoEvaluadoresVideos[$j]['revisor_puntaje'];
                $atributos ["categoria"] = "";
                echo $this->miFormulario->campoCuadroTexto ( $atributos );
                unset ( $atributos );

                echo $this->miFormulario->division("fin");
            }else
                {
                    $atributos ["id"] = "divEv".($j+1);
                    $atributos ["estilo"] = "anchoColumna1";
                    if($j>1)
                        {
                            $atributos["estiloEnLinea"]="display:none";
                        }  
                    echo $this->miFormulario->division("inicio",$atributos);


                    $esteCampo = "nomEvaluador".($j+1);
                    $atributos ["id"] = $esteCampo;
                    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                    $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
                    $atributos ["tabIndex"] = $tab ++;
                    $atributos ["obligatorio"] = false;
                    $atributos ["tamanno"] = 30;
                    $atributos ["columnas"] = 3;
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ["tipo"] = "";
                    $atributos ["estilo"] = "jqueryui";
                    $atributos ["anchoEtiqueta"] = 200;
                    $atributos ["validar"] = "required, minSize[6], maxSize[50]";
                    $atributos ["categoria"] = "";
                    echo $this->miFormulario->campoCuadroTexto ( $atributos );
                    unset ( $atributos );

                    // ------------------Control Lista Desplegable------------------------------
                    $esteCampo = "uniEvaluador".($j+1);
                    $atributos ["id"] = $esteCampo;
                    $atributos ["tabIndex"] = $tab ++;
                    $atributos ["evento"] = 2;
                    $atributos ["columnas"] = 3;
                    $atributos ["limitar"] = false;
                    $atributos ["tamanno"] = 1;
                    $atributos ["ancho"] = "200px";
                    $atributos ["estilo"] = "jqueryui";
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ["validar"] = "required";
                    $atributos ["anchoEtiqueta"] = 200;
                    $atributos ["obligatorio"] = true;
                    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                    // -----De donde rescatar los datos ---------
                    $atributos ["cadena_sql"] = $this->sql->cadena_sql ( "universidad" );
                    // echo $atributos["cadena_sql"];exit;
                    $atributos ["baseDatos"] = "estructura";
                    echo $this->miFormulario->campoCuadroLista ( $atributos );
                    unset ( $atributos );

                    $esteCampo = "puntEvaluador".($j+1);
                    $atributos ["id"] = $esteCampo;
                    $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                    $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
                    $atributos ["tabIndex"] = $tab ++;
                    $atributos ["obligatorio"] = false;
                    $atributos ["tamanno"] = 10;
                    $atributos ["columnas"] = 3;
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ["tipo"] = "";
                    $atributos ["estilo"] = "jqueryui";
                    $atributos ["anchoEtiqueta"] = 155;
                    $atributos ["validar"] = "required, minSize[1],custom[number]";
                    $atributos ["categoria"] = "";
                    echo $this->miFormulario->campoCuadroTexto ( $atributos );
                    unset ( $atributos );

                    echo $this->miFormulario->division("fin");
                
                }
    }
    
    
    echo $this->miFormulario->marcoAgrupacion ( "fin" );
    unset ( $atributos );
    
    if($resultadoVideos[0]['impacto'] == 1)
        {
            $puntMax = ", max[7]";
        }else
            {
                $puntMax = ", max[12]";
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
    $atributos ["anchoEtiqueta"] = 350;
    $atributos ["validar"] = "required, custom[number], condRequired[impacto], ".$puntMax;
    $atributos ["categoria"] = "";
    $atributos ["valor"] = $resultadoVideos[0]['puntaje'];
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
    $atributos ["valor"] = $resultadoVideos [0] ['detalledocencia'];
    echo $this->miFormulario->campoTextArea($atributos);
    unset($atributos);
    
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
