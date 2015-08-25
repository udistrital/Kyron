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
        $tiempo = $_REQUEST['tiempo'];

// -------------------------------------------------------------------------------------------------
        $conexion = "inventarios";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $conexion2 = "sicapital";
        $esteRecursoDB2 = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion2);
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
        $atributos ['marco'] = false;
        $tab = 1;
// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos);
        {
// ---------------- SECCION: Controles del Formulario -----------------------------------------------

            $esteCampo = "marcoDatosBasicos";
            $atributos ['id'] = $esteCampo;
            $atributos ["estilo"] = "jqueryui";
            $atributos ['tipoEtiqueta'] = 'inicio';
            $atributos ["leyenda"] = "Entradas por Compras";
            echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
            unset($atributos);
            {


                $esteCampo = "AgrupacionActa";
                $atributos ['id'] = $esteCampo;
                $atributos ['leyenda'] = "Cargue de Documentos";
                echo $this->miFormulario->agrupacion('inicio', $atributos);
                {

// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'ordenDocumento';
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
// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'facturaDocumento';
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
// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'satisfaccionDocumento';
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


                    echo $this->miFormulario->agrupacion('fin');

                    $esteCampo = "descripcionFactura";
                    $atributos ['id'] = $esteCampo;
                    $atributos ['leyenda'] = $this->lenguaje->getCadena($esteCampo);
                    echo $this->miFormulario->agrupacion('inicio', $atributos);
                    {
                        ?>
                        <center>
                            <table id="tablaContenido">
                                <tr>
                                    <td>&nbsp</td>
                                </tr>
                            </table>
                            <div id="barraNavegacion"></div>
                        </center>
                        <?php

                    }
                    echo $this->miFormulario->agrupacion('fin');
                    unset($atributos);
                }

//------------------------------ Nueva Agrupación -------------------------------------------------//
                $esteCampo = "AgrupacionActa";
                $atributos ['id'] = $esteCampo;
                $atributos ['leyenda'] = "Registro de Información";
                echo $this->miFormulario->agrupacion('inicio', $atributos);
                {
// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'fecha_recibido';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 1;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1],maxSize[10]';

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = date('Y-m-d');
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 220;
                    $tab ++;

// Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------

                 // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
               $esteCampo = 'nitproveedor';
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
                    $atributos ['anchoEtiqueta'] = 213;
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("proveedores");
                    $matrizItems = $esteRecursoDB2->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;

                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
                    // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------

// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'valorFacturas';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 1;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1],maxSize[15],custom[onlyNumberSp]';

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = false;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 220;
                    $tab ++;

// Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------


                    echo $this->miFormulario->agrupacion('fin');
                }

// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------

                }

// ------------------Division para los botones-------------------------
                $atributos ["id"] = "botones";
                $atributos ["estilo"] = "marcoBotones";
                echo $this->miFormulario->division("inicio", $atributos);

// -----------------CONTROL: Botón ----------------------------------------------------------------
                $esteCampo = 'botonAceptar';
                $atributos ["id"] = $esteCampo;
                $atributos ["tabIndex"] = $tab;
                $atributos ["tipo"] = '';
// submit: no se coloca si se desea un tipo button genérico
                $atributos ['submit'] = 'true';
                $atributos ["estiloMarco"] = '';
                $atributos ["estiloBoton"] = 'jqueryui';
// verificar: true para verificar el formulario antes de pasarlo al servidor.
                $atributos ["verificar"] = '';
                $atributos ["tipoSubmit"] = 'jqueryui'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                $atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
                $tab ++;

// Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoBoton($atributos);
// -----------------FIN CONTROL: Botón -----------------------------------------------------------
// // -----------------CONTROL: Botón ----------------------------------------------------------------
// $esteCampo = 'botonCancelar';
// $atributos ["id"] = $esteCampo;
// $atributos ["tabIndex"] = $tab;
// $atributos ["tipo"] = 'boton';
// // submit: no se coloca si se desea un tipo button genérico
// $atributos ['submit'] = true;
// $atributos ["estiloMarco"] = '';
// $atributos ["estiloBoton"] = 'jqueryui';
// // verificar: true para verificar el formulario antes de pasarlo al servidor.
// $atributos ["verificar"] = '';
// $atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
// $atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
// $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
// $tab ++;
// // Aplica atributos globales al control
// $atributos = array_merge ( $atributos, $atributosGlobales );
// echo $this->miFormulario->campoBoton ( $atributos );

                echo $this->miFormulario->marcoAgrupacion('fin');

// ---------------- SECCION: División ----------------------------------------------------------
                $esteCampo = 'division1';
                $atributos ['id'] = $esteCampo;
                $atributos ['estilo'] = 'general';
                echo $this->miFormulario->division("inicio", $atributos);

// ---------------- FIN SECCION: División ----------------------------------------------------------
                echo $this->miFormulario->division('fin');

// ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
// ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
// Se debe declarar el mismo atributo de marco con que se inició el formulario.
            }

// -----------------FIN CONTROL: Botón -----------------------------------------------------------
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

            $valorCodificado = "actionBloque=" . $esteBloque ["nombre"];
            $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
            $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
            $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
            $valorCodificado .= "&opcion=registrarCompra";
            $valorCodificado .= "&seccion=" . $tiempo;
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

            return true;
        }
    }


$miSeleccionador = new registrarForm($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->miForm();
?>
