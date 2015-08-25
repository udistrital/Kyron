<?php

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class Formulario {

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

    function formulario() {

        /**
         * IMPORTANTE: Este formulario está utilizando jquery.
         * Por tanto en el archivo ready.php se delaran algunas funciones js
         * que lo complementan.
         */
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
        $conexion = "inventarios";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


        $atributosGlobales ['campoSeguro'] = 'true';
        $_REQUEST ['tiempo'] = time();

        // -------------------------------------------------------------------------------------------------
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
        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo);

        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = true;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->formulario($atributos);
        unset($atributos); {
            // ------------------CONTROL: Lista desplegable -----------------------------------------------------

            $esteCampo = 'tipoCargueConsulta';
            $atributos ['columnas'] = 2;
            $atributos ['nombre'] = $esteCampo;
            $atributos ['id'] = $esteCampo;
            $atributos ['seleccion'] = - 1;
            $atributos ['evento'] = '';
            $atributos ['deshabilitado'] = false;
            $atributos ["etiquetaObligatorio"] = false;
            $atributos ['tab'] = $tab;
            $atributos ['tamanno'] = 1;
            $atributos ['estilo'] = 'jqueryui';
            $atributos ['validar'] = '';
            $atributos ['limitar'] = false;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ['anchoEtiqueta'] = 180;

            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("clase_entrada");
            $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
            $atributos ['matrizItems'] = $matrizItems;

            // Utilizar lo siguiente cuando no se pase un arreglo:
            // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
            // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
            $tab ++;
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroLista($atributos);
            unset($atributos);

            // ----------------- fin control html --------------------------//
            // ---------------------------- inicio control html --------------------//

            $esteCampo = 'numero_entradaConsulta';
            $atributos ['nombre'] = $esteCampo;
            $atributos ['id'] = $esteCampo;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ["etiquetaObligatorio"] = false;
            $atributos ['tab'] = $tab ++;
            $atributos ['seleccion'] = - 1;
            $atributos ['anchoEtiqueta'] = 235;
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
            $atributos ['validar'] = " ";
            $atributos ['limitar'] = false;
            // $atributos ['anchoCaja'] = 35;
            $atributos ['miEvento'] = '';
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscar_entradas");
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

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------

            $esteCampo = 'tipoDocumentoConsulta';
            $atributos ['nombre'] = $esteCampo;
            $atributos ['id'] = $esteCampo;
            $atributos ['seleccion'] = - 1;
            $atributos ['evento'] = '';
            $atributos ['columnas'] = 1;
            $atributos ['deshabilitado'] = false;
            $atributos ["etiquetaObligatorio"] = false;
            $atributos ['tab'] = $tab;
            $atributos ['tamanno'] = 1;
            $atributos ['estilo'] = 'jqueryui';
            $atributos ['validar'] = ' ';
            $atributos ['limitar'] = false;
            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos ['anchoEtiqueta'] = 180;

            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_documento");
            $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

            $atributos ['matrizItems'] = $matrizItems;

            // Utilizar lo siguiente cuando no se pase un arreglo:
            // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
            // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
            $tab ++;
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroLista($atributos);
            unset($atributos);

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
            $esteCampo = 'fecha_inicio';
            $atributos ['id'] = $esteCampo;
            $atributos ['nombre'] = $esteCampo;
            $atributos ['tipo'] = 'text';
            $atributos ['estilo'] = 'jqueryui';
            $atributos ['marco'] = true;
            $atributos ['estiloMarco'] = '';
            $atributos ["etiquetaObligatorio"] = false;
            $atributos ['columnas'] = 2;
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
            $atributos ['deshabilitado'] = false;
            $atributos ['tamanno'] = 8;
            $atributos ['maximoTamanno'] = '';
            $atributos ['anchoEtiqueta'] = 180;
            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
            $esteCampo = 'fecha_final';
            $atributos ['id'] = $esteCampo;
            $atributos ['nombre'] = $esteCampo;
            $atributos ['tipo'] = 'text';
            $atributos ['estilo'] = 'jqueryui';
            $atributos ['marco'] = true;
            $atributos ['estiloMarco'] = '';
            $atributos ["etiquetaObligatorio"] = false;
            $atributos ['columnas'] = 2;
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
            $atributos ['deshabilitado'] = false;
            $atributos ['tamanno'] = 8;
            $atributos ['maximoTamanno'] = '';
            $atributos ['anchoEtiqueta'] = 235;
            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);

            // ------------------Division para los botones-------------------------
            $atributos ["id"] = "botones";
            $atributos ["estilo"] = "marcoBotones";
            echo $this->miFormulario->division("inicio", $atributos); {
                // -----------------CONTROL: Botón ----------------------------------------------------------------
                $esteCampo = 'botonConsultar';
                $atributos ["id"] = $esteCampo;
                $atributos ["tabIndex"] = $tab;
                $atributos ["tipo"] = 'boton';
                // submit: no se coloca si se desea un tipo button genérico
                $atributos ['submit'] = 'true';
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
                unset($atributos);
                // -----------------FIN CONTROL: Botón -----------------------------------------------------------
            }
            // ------------------Fin Division para los botones-------------------------
            echo $this->miFormulario->division("fin");

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

            $valorCodificado = "pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
            $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
            $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
            $valorCodificado .= "&opcion=consultar";
            /**
             * SARA permite que los nombres de los campos sean dinámicos.
             * Para ello utiliza la hora en que es creado el formulario para
             * codificar el nombre de cada campo.
             */
            $valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];

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

            // ----------------FIN SECCION: Paso de variables -------------------------------------------------
            // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
            // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
            // Se debe declarar el mismo atributo de marco con que se inició el formulario.
        }
        $atributos ['marco'] = true;
        $atributos ['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario($atributos);

        return true;
    }

    function mensaje() {

        // Si existe algun tipo de error en el login aparece el siguiente mensaje
        $mensaje = $this->miConfigurador->getVariableConfiguracion('mostrarMensaje');
        $this->miConfigurador->setVariableConfiguracion('mostrarMensaje', null);

        if ($mensaje) {

            $tipoMensaje = $this->miConfigurador->getVariableConfiguracion('tipoMensaje');

            if ($tipoMensaje == 'json') {

                $atributos ['mensaje'] = $mensaje;
                $atributos ['json'] = true;
            } else {
                $atributos ['mensaje'] = $this->lenguaje->getCadena($mensaje);
            }
            // -------------Control texto-----------------------
            $esteCampo = 'divMensaje';
            $atributos ['id'] = $esteCampo;
            $atributos ["tamanno"] = '';
            $atributos ["estilo"] = 'information';
            $atributos ["etiqueta"] = '';
            $atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
            echo $this->miFormulario->campoMensaje($atributos);
            unset($atributos);
        }

        return true;
    }

}

$miFormulario = new Formulario($this->lenguaje, $this->miFormulario, $this->sql);

$miFormulario->formulario();
?>