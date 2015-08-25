<?php

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class registrarForm {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miSql;

    function __construct($lenguaje, $formulario, $sql) {
        $this->miConfigurador = \Configurador::singleton();

        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;

        $this->miSql = $sql;
    }

    function miForm() {
        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

        // ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
        /**
         * Atributos que deben ser aplicados a todos los controles de este formulario.
         * Se utiliza un arreglo
         * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
         *
         * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
         * $atributos= array_merge($atributos,$atributosGlobales);
         */
        $atributosGlobales ['campoSeguro'] = 'true';
        $_REQUEST ['tiempo'] = time();

        // -------------------------------------------------------------------------------------------------
        $conexion = "inventarios";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


        // Limpia Items Tabla temporal
        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
        $esteCampo = $esteBloque ['nombre'];
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        // Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
        $atributos ['tipoFormulario'] = 'multipart/form-data';
        // Si no se coloca, entonces toma el valor predeterminado 'POST'
        $atributos ['metodo'] = 'POST';
        // Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
        $atributos ['action'] = 'index.php';
        // $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = true;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos);
        // ---------------- SECCION: Controles del Formulario -----------------------------------------------

        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Radicación Documentos Soporte para Entrada";
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);

        //--------------------------- CONTROL AGRUPACIÓN ---------------------//
        $esteCampo = "AgrupacionCriterios";
        $atributos ['id'] = $esteCampo;
        $atributos ['leyenda'] = "Selección Criterios";
        echo $this->miFormulario->agrupacion('inicio', $atributos);
        {
//------------------CONTROL: Lista desplegable -----------------------------------------------------

            $esteCampo = 'tipoCargue';
            $atributos ['columnas'] = 1;
            $atributos ['nombre'] = $esteCampo;
            $atributos ['id'] = $esteCampo;
            $atributos ['seleccion'] = - 1;
            $atributos ['evento'] = '';
            $atributos ['deshabilitado'] = false;
            $atributos ["etiquetaObligatorio"] = true;
            $atributos ['tab'] = $tab;
            $atributos ['tamanno'] = 1;
            $atributos ['estilo'] = 'jqueryui';
            $atributos ['validar'] = '';
            $atributos ['limitar'] = false;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ['anchoEtiqueta'] = 220;

            //$atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipoCargue");
            //$matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
            $matrizItems=array(
             
                array(1,'Avances'),
                array(3,'Orden de Compra'),
                array(4,'Contratos (Vicerectoría)'),
            );
            $atributos ['matrizItems'] = $matrizItems;

            // Utilizar lo siguiente cuando no se pase un arreglo:
            // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
            // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
            $tab ++;
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroLista($atributos);
            unset($atributos);

            //----------------- fin control html --------------------------//
            //---------------------------- inicio control html --------------------//

            $esteCampo = 'numero_entrada';
            $atributos ['nombre'] = $esteCampo;
            $atributos ['id'] = $esteCampo;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ["etiquetaObligatorio"] = true;
            $atributos ['tab'] = $tab ++;
            $atributos ['seleccion'] = - 1;
            $atributos ['anchoEtiqueta'] = 220;
            $atributos ['evento'] = '';
            if (isset($_REQUEST [$esteCampo])) {
                $atributos ['valor'] = $_REQUEST [$esteCampo];
            } else {
                $atributos ['valor'] = '';
            }
            $atributos ['deshabilitado'] = false;
            $atributos ['columnas'] = 2;
            $atributos ['tamanno'] = 1;
            $atributos ['ajax_function'] = "";
            $atributos ['ajax_control'] = $esteCampo;
            $atributos ['estilo'] = "jqueryui";
            $atributos ['validar'] = "required";
            $atributos ['limitar'] = true;
            $atributos ['anchoCaja'] = 24;
            $atributos ['miEvento'] = '';
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscar_entradas");
            $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
            $atributos ['matrizItems'] = $matrizItems;
            // $atributos['miniRegistro']=;
            $atributos ['baseDatos'] = "inventarios";
            // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroLista($atributos);
            unset($atributos);

            //----------------- fin control html --------------------------//
            //---------------------------- inicio control html --------------------//
            $esteCampo = 'vigencia_entrada';
            $atributos ['nombre'] = $esteCampo;
            $atributos ['id'] = $esteCampo;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ["etiquetaObligatorio"] = false;
            $atributos ['tab'] = $tab ++;
            $atributos ['seleccion'] = - 1;
            $atributos ['anchoEtiqueta'] = 220;
            $atributos ['evento'] = '';
            if (isset($_REQUEST [$esteCampo])) {
                $atributos ['valor'] = $_REQUEST [$esteCampo];
            } else {
                $atributos ['valor'] = '';
            }
            $atributos ['deshabilitado'] = false;
            $atributos ['columnas'] = 2;
            $atributos ['tamanno'] = 1;
            $atributos ['ajax_function'] = "";
            $atributos ['ajax_control'] = $esteCampo;
            $atributos ['estilo'] = "jqueryui";
            $atributos ['validar'] = "required";
            $atributos ['limitar'] = true;
            $atributos ['anchoCaja'] = 24;
            $atributos ['miEvento'] = '';
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("vigencia_entrada");
            $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

            $arreglo = array(
                array(
                    '',
                    'Sin Entradas Registradas'
                )
            );


            $matrizItems = $matrizItems[0][0] != '' ? $matrizItems : $arreglo;
            $atributos ['matrizItems'] = $matrizItems;
            // $atributos['miniRegistro']=;
            $atributos ['baseDatos'] = "inventarios";
            // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroLista($atributos);
            unset($atributos);
        }
        echo $this->miFormulario->agrupacion("fin");
        unset($atributos);



        //----------------------- INICIO AGRUPACION CONTROL ---------------------------//
        $esteCampo = "AgrupacionCargue";
        $atributos ['id'] = $esteCampo;
        $atributos ['leyenda'] = "Carga de Documentos";
        echo $this->miFormulario->agrupacion('inicio', $atributos);
        {

            //--------------------- CONTROL INICIO DIVISIÓN 1----------------------------//
            $atributos ["id"] = "resolucionD";
            $atributos ["estiloEnLinea"] = "display:none";
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->division("inicio", $atributos);
            unset($atributos); {
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'resolucionDocumento';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'file';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['estiloMarco'] = '';
                $atributos ["etiquetaObligatorio"] = false;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = 0;
                $atributos ['tabIndex'] = $tab;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['validar'] = '';

                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['valor'] = $_REQUEST[$esteCampo];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = false;
                $atributos ['tamanno'] = 200;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 220;
                $tab ++;

// Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
            }
            echo $this->miFormulario->division("fin");
            unset($atributos);
            //---------------------------- CONTROL FIN DIVISIÓN ------------------------------//
            //            //--------------------- CONTROL INICIO DIVISIÓN 1----------------------------//
            $atributos ["id"] = "contratoD";
            $atributos ["estiloEnLinea"] = "display:none";
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->division("inicio", $atributos);
            unset($atributos); {
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'contratoDocumento';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'file';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['estiloMarco'] = '';
                $atributos ["etiquetaObligatorio"] =false;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = 0;
                $atributos ['tabIndex'] = $tab;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['validar'] = '';

                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['valor'] = $_REQUEST[$esteCampo];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = false;
                $atributos ['tamanno'] = 200;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 220;
                $tab ++;

// Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
            }
            echo $this->miFormulario->division("fin");
            unset($atributos);
            //---------------------------- CONTROL FIN DIVISIÓN ------------------------------//
            //            //--------------------- CONTROL INICIO DIVISIÓN 1----------------------------//
            $atributos ["id"] = "ordenD";
            $atributos ["estiloEnLinea"] = "display:none";
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->division("inicio", $atributos);
            unset($atributos); {
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'ordenDocumento';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'file';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['estiloMarco'] = '';
                $atributos ["etiquetaObligatorio"] = false;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = 0;
                $atributos ['tabIndex'] = $tab;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['validar'] = '';

                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['valor'] = $_REQUEST[$esteCampo];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = false;
                $atributos ['tamanno'] = 200;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 220;
                $tab ++;

// Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
            }
            echo $this->miFormulario->division("fin");
            unset($atributos);
            //---------------------------- CONTROL FIN DIVISIÓN ------------------------------//
            //     //--------------------- CONTROL INICIO DIVISIÓN 2----------------------------//
            $atributos ["id"] = "facturaD";
            $atributos ["estiloEnLinea"] = "display:none";
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->division("inicio", $atributos);
            unset($atributos); {
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'facturaDocumento';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'file';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['estiloMarco'] = '';
                $atributos ["etiquetaObligatorio"] = false;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = 0;
                $atributos ['tabIndex'] = $tab;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['validar'] = '';

                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['valor'] = $_REQUEST [$esteCampo];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = true;
                $atributos ['tamanno'] = 200;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 220;
                $tab ++;

// Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
            }
            echo $this->miFormulario->division("fin");
            unset($atributos);
//------------------CONTROL: Lista desplegable -----------------------------------------------------
            //---------------------------- CONTROL FIN DIVISIÓN ------------------------------//
            //--------------------- CONTROL INICIO DIVISIÓN 3----------------------------//
            $atributos ["id"] = "cartaD";
            $atributos ["estiloEnLinea"] = "display:none";
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->division("inicio", $atributos);
            unset($atributos); {
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'cartaDocumento';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'file';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['estiloMarco'] = '';
                $atributos ["etiquetaObligatorio"] = false;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = 0;
                $atributos ['tabIndex'] = $tab;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['validar'] = '';

                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['valor'] = $_REQUEST[$esteCampo];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = false;
                $atributos ['tamanno'] = 200;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 220;
                $tab ++;

// Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
            }
            echo $this->miFormulario->division("fin");
            unset($atributos);
//------------------CONTROL: Lista desplegable -----------------------------------------------------
            //---------------------------- CONTROL FIN DIVISIÓN ------------------------------//
            //     //--------------------- CONTROL INICIO DIVISIÓN 4----------------------------//
            $atributos ["id"] = "satisfaccionD";
            $atributos ["estiloEnLinea"] = "display:none";
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->division("inicio", $atributos);
            unset($atributos);
            {
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'satisfaccionDocumento';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'file';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['estiloMarco'] = '';
                $atributos ["etiquetaObligatorio"] = false;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = 0;
                $atributos ['tabIndex'] = $tab;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['validar'] = '';

                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['valor'] = $_REQUEST [$esteCampo];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = true;
                $atributos ['tamanno'] = 200;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 220;
                $tab ++;

// Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
            }
            echo $this->miFormulario->division("fin");
            unset($atributos);
//------------------CONTROL: Lista desplegable -----------------------------------------------------
            //---------------------------- CONTROL FIN DIVISIÓN ------------------------------//
            //--------------------- CONTROL INICIO DIVISIÓN 3----------------------------//
            $atributos ["id"] = "actaD";
            $atributos ["estiloEnLinea"] = "display:none";
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->division("inicio", $atributos);
            unset($atributos); {
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'actaRecibidoDocumento';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'file';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['estiloMarco'] = '';
                $atributos ["etiquetaObligatorio"] = true;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = 0;
                $atributos ['tabIndex'] = $tab;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['validar'] = 'required';

                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['valor'] = $_REQUEST[$esteCampo];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = false;
                $atributos ['tamanno'] = 200;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 220;
                $tab ++;

// Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
            }
            echo $this->miFormulario->division("fin");
            unset($atributos);
//------------------CONTROL: Lista desplegable -----------------------------------------------------
            //---------------------------- CONTROL FIN DIVISIÓN ------------------------------//
        }
        echo $this->miFormulario->agrupacion("fin");
        unset($atributos);


        //----------------------FIN CONTROL AGRUPACIÓN---------------------------------//
        //--------------------- FIN CONTROL HTML ------------------------------------------//
        // ------------------Division para los botones-------------------------
        $atributos ["id"] = "botones";
        $atributos ["estilo"] = "marcoBotones";
        echo $this->miFormulario->division("inicio", $atributos);

        // -----------------CONTROL: Botón ----------------------------------------------------------------
        $esteCampo = 'botonAceptar';
        $atributos ["id"] = $esteCampo;
        $atributos ["tabIndex"] = $tab;
        $atributos ["tipo"] = 'boton';
        // submit: no se coloca si se desea un tipo button genérico
        $atributos ['submit'] = true;
        $atributos ["estiloMarco"] = '';
        $atributos ["estiloBoton"] = 'jqueryui';
        // verificar: true para verificar el formulario antes de pasarlo al servidor.
        $atributos ["verificar"] = '';
        $atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
        $atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoBoton($atributos);
        // -----------------FIN CONTROL: Botón -----------------------------------------------------------
        // ---------------------------------------------------------
        // ------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");

        echo $this->miFormulario->marcoAgrupacion('fin');

        // ------------------- SECCION: Paso de variables ------------------------------------------------

        /**
         * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
         * SARA permite realizar esto a través de tres
         * mecanismos:
         * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
         * la base de datos.
         * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
         * formsara, cuyo valor será una cadena codificada que contiene las variables.
         * (c) a través de campos ocultos en los formularios. (deprecated)
         */
        // En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
        // Paso 1: crear el listado de variables
        $valorCodificado = "actionBloque=" . $esteBloque ["nombre"];
        $valorCodificado.= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado.= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado.= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado.= "&opcion=registroCargue";
        /**
         * SARA permite que los nombres de los campos sean dinámicos.
         * Para ello utiliza la hora en que es creado el formulario para
         * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
         * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
         * (b) asociando el tiempo en que se está creando el formulario
         */
        $valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
        $valorCodificado .= "&tiempo=" . time();
        // Paso 2: codificar la cadena resultante
        $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

        $atributos ["id"] = "formSaraData"; // No cambiar este nombre
        $atributos ["tipo"] = "hidden";
        $atributos ['estilo'] = '';
        $atributos ["obligatorio"] = false;
        $atributos ['marco'] = true;
        $atributos ["etiqueta"] = "";
        $atributos ["valor"] = $valorCodificado;
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);

        $atributos ['marco'] = true;
        $atributos ['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario($atributos);
    }

}

$miSeleccionador = new registrarForm($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->miForm();
?>
