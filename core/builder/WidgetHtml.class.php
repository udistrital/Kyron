<?php

include_once("core/manager/Configurador.class.php");

/**
 * Contiene las definiciones de los diferentes controles HTML
 *
 * @author	Paulo Cesar Coronado
 * @version	1.0.0.0, 29/12/2011
 * @package 	framework:BCK:estandar
 * @copyright Universidad Distrital F.J.C
 * @license	GPL Version 3.0 o posterior
 *
 */
class WidgetHtml {
    /** Aggregations: */
    /** Compositions: */
    /*     * * Attributes: ** */

    /**
     * Miembros privados de la clase
     * @access private
     */
    var $conexion_id;
    var $cuadro_registro;
    var $cuadro_campos;
    var $cuadro_miniRegistro;
    var $cadena_html;
    var $configuracion;
    var $atributos;
    var $miConfigurador;

    /**
     * @name html
     * constructor
     */
    function html() {
        
    }

//Fin del método session

    function enlace_wiki($cadena, $titulo = "", $configuracion, $el_enlace = "") {
        if ($el_enlace != "") {
            $enlace_wiki = "<a class='wiki' href='" . $configuracion["wikipedia"] . $cadena . "' title='" . $titulo . "'>" . $el_enlace . "</a>";
        } else {
            $enlace_wiki = "<a class='wiki' href='" . $configuracion["wikipedia"] . $cadena . "' title='" . $titulo . "'>" . $cadena . "</a>";
        }
        return $enlace_wiki;
    }

    //================================== Funciones Cuadro Lista ==================================

    /**
     * @name cuadro_lista
     * @param string $cuadro_sql  Clausula SQL desde donde se extraen los valores de la lista
     * @param string $nombre      Nombre del control que se va a crear
     * @param string $configuracion
     * @param int    $seleccion   id (o nombre??) del elemento seleccionado en la lista
     * @param int    $evento      Evento javascript  que desencadena el control
     * @return void
     * @access public
     */
    function __construct() {

        $this->miConfigurador = Configurador::singleton();
    }

    //IMPORTANTE!!!!!!!!!!!
    //Si la seleccion==-1 entonces se muestra una linea vacia al inicio de la lista
    //Si la seleccion <-1 entonces se seleccciona el primer registro devuelto en la busqueda
    //Cuando se pase un registro explicito debe ser una matriz de tres dimensiones. En cada dimension
    //debe tener:
    //$resultado[indice][valor][etiqueta_a_mostrar]

    function cuadro_lista($atributos) {

        $this->atributos = $atributos;
        
        if(isset($this->atributos["nombre"]) && $this->atributos["nombre"] != '')
            {
                $nombre = $this->atributos["nombre"];
            }else
                {
                    $nombre = $this->atributos["id"];
                }
        
        if (isset($this->atributos["seleccion"])) {
            $seleccion = $this->atributos["seleccion"];
        } else {
            $seleccion = -1;
        }

        $limitar = $this->atributos["limitar"];
        $tab = $this->atributos["tabIndex"];
        $id = $this->atributos["id"];
        $tamanno = $this->atributos["tamanno"];

        if (isset($this->atributos["otraOpcion"])) {
            $otraOpcion = $this->atributos["otraOpcion"];
        }

        //Invocar la funcion que rescata el registro de los valores que se mostraran en la lista
        $resultado = $this->rescatarRegistroCuadroLista();
        
        $this->cadena_html = "";

        if ($resultado) {

            $mi_evento = $this->definirEvento();
            $mi_evento = $atributos["evento"];
            
            if ($id == "") {
                if (isset($atributos["deshabilitado"]) && $atributos["deshabilitado"] == true) {
                    $this->cadena_html = "<select disabled";
                } else {
                    $this->cadena_html = "<select ";
                }
            } else {
                if (isset($atributos["deshabilitado"]) && $atributos["deshabilitado"] == true) {
                    $this->cadena_html = "<select disabled id='" . $id . "' ";
                }else {
                $this->cadena_html = "<select id='" . $id . "' ";}
            }

           
            
            if (isset($atributos["estilo"]) && $atributos["estilo"] == "jqueryui") {

                $this->cadena_html.=" class='selectboxdiv ";
            }else
                {
                    $this->cadena_html.=" class='";
                }
            
             //Si se utiliza jQuery-Validation-Engine
            if (isset($atributos["validar"])) {

                $this->cadena_html.=" validate[" . $atributos["validar"] . "] ";                
               
            }
            $this->cadena_html.="'";                
             

            if (isset($this->atributos["ancho"])) {
                $this->cadena_html.=" style='width:" . $this->atributos["ancho"] . "' ";
            }

            //Si se especifica que puede ser multiple
            if (isset($this->atributos["multiple"]) && $this->atributos["multiple"] = true) {
                $this->cadena_html.=" multiple \n";
            }
            
            $this->cadena_html.="name='" . $nombre . "' size='" . $tamanno . "' " . $mi_evento . " tabindex='" . $tab . "'>\n";

            //Si no se especifica una seleccion se agrega un espacio en blanco
            if ($seleccion == -1) {
                $this->cadena_html.="<option value='' selected='true'>Seleccione... </option>\n";
            }

            //Si el control esta asociado a otro control que aparece si no hay un valor en la lista
            if (isset($otraOpcion)) {
                if ($seleccion == "ttg") {
                    $this->cadena_html.="<option value='ttg' selected='true'>" . $this->atributos["otraOpcionEtiqueta"] . "</option>\n";
                } else {
                    $this->cadena_html.="<option value='ttg'>" . $this->atributos["otraOpcionEtiqueta"] . "</option>\n";
                }
            }

            $this->listadoInicialCuadroLista();
            $this->opcionesCuadroLista();

            $this->cadena_html.="</select>\n";
        } else {
            $this->cadena_html.="No Data";
        }

        return $this->cadena_html;
    }

//Fin del método cuadro lista

    private function opcionesCuadroLista() {

        if (isset($this->atributos["seleccion"])) {
            $seleccion = $this->atributos["seleccion"];
        } else {
            $seleccion = -1;
        }

        $limitar = $this->atributos["limitar"];
        //Recorrer todos los registros devueltos

        for ($j = 0; $j < $this->cuadro_campos; $j++) {

            $this->cuadro_contenido = "";

            if ($j == 0) {
                $this->keys = array_keys($this->cuadro_registro[0]);
                $i = 0;
                $this->columnas = 0;
                foreach ($this->keys as $clave => $valor) {
                    if (is_string($valor)) {
                        $this->columnas++;
                    }
                    //echo $clave."->".$valor."<br>";
                }
            }

            if ($seleccion < 0 && $j == 0) {
                if ($limitar == 1) {
                    $this->cadena_html.="<option value='" . $this->cuadro_registro[$j][0] . "' >" . substr($this->cuadro_registro[$j][1], 0, 20) . "</option>\n";
                } else {
                    $this->cadena_html.="<option value='" . $this->cuadro_registro[$j][0] . "' >" . htmlentities($this->cuadro_registro[$j][1]) . "</option>\n";
                }
            } else {
                if ($limitar == 1) {
                    if ($this->cuadro_registro[$j][0] == $seleccion) {
                        $this->cadena_html.="<option value='" . $this->cuadro_registro[$j][0] . "' selected='true'>" . substr($this->cuadro_registro[$j][1], 0, 20) . "</option>\n";
                    } else {
                        $this->cadena_html.="<option value='" . $this->cuadro_registro[$j][0] . "'>" . substr($this->cuadro_registro[$j][1], 0, 20) . "</option>\n";
                    }
                } else {
                    if ($this->cuadro_registro[$j][0] == $seleccion) {
                        $this->cadena_html.="<option value='" . $this->cuadro_registro[$j][0] . "' selected='true'>" . htmlentities($this->cuadro_registro[$j][1]) . "</option>\n";
                    } else {
                        $this->cadena_html.="<option value='" . $this->cuadro_registro[$j][0] . "'>" . htmlentities($this->cuadro_registro[$j][1]) . "</option>\n";
                    }
                }
            }
        }
    }

    /**
     *
     * Para cuadros de lista que tienen al inicio un conjunto de los datos "mas populares"; luego de estos datos saldra el listado completo
     * @name listadoInicialCuadroLista
     * @param none
     * @category funciones para crear cuadros de lista
     * @access private
     * @return none
     */
    private function listadoInicialCuadroLista() {

        if (isset($miniRegistro)) {
            for ($i = 0; $i < $totalMiniRegistro; $i++) {
                $this->cuadro_contenido = "";
                if ($i == 0) {
                    $keys = array_keys($miniRegistro[0]);
                    $fila = 0;
                    $columnas = 0;
                    foreach ($keys as $clave => $valor) {
                        if (is_string($valor)) {
                            $columnas++;
                        }
                        //echo $clave."->".$valor."<br>";
                    }
                }

                //Si ningun registro es seleccionado
                if ($seleccion < 0 && $i == 0) {
                    if ($limitar == 1) {
                        $this->cadena_html.="<option class='texto_negrita' value='" . $miniRegistro[$i][0] . "' selected='true'>" . substr($miniRegistro[$i][1], 0, 20) . "</option>\n";
                    } else {
                        $this->cadena_html.="<option class='texto_negrita' value='" . $miniRegistro[$i][0] . "' selected='true'>" . $miniRegistro[$i][1] . "</option>\n";
                    }
                } else {
                    if ($limitar == 1) {
                        if ($miniRegistro[$i][0] == $seleccion) {
                            $this->cadena_html.="<option class='texto_negrita' value='" . $miniRegistro[$i][0] . "' selected='true'>" . substr($miniRegistro[$i][1], 0, 20) . "</option>\n";
                            $seleccion = time();
                        } else {
                            $this->cadena_html.="<option class='texto_negrita' value='" . $miniRegistro[$i][0] . "'>" . substr($miniRegistro[$i][1], 0, 20) . "</option>\n";
                        }
                    } else {
                        if ($miniRegistro[$i][0] == $seleccion) {
                            $this->cadena_html.="<option class='texto_negrita' value='" . $miniRegistro[$i][0] . "' selected='true'>" . htmlentities($miniRegistro[$i][1]) . "</option>\n";
                            $seleccion = time();
                        } else {
                            $this->cadena_html.="<option class='texto_negrita' value='" . $miniRegistro[$i][0] . "'>" . htmlentities($miniRegistro[$i][1]) . "</option>\n";
                        }
                    }
                }
            }
            $this->cadena_html.="<option value='-1'></option>\n";
            $this->cadena_html.="<option value='-1'>--------------</option>\n";
            $this->cadena_html.="<option value='-1'></option>\n";
        }
    }

    /**
     *
     * De acuerdo a los atributos, define el tipo de evento asociado al control cuadro de lista.
     * @name definirEvento
     * @param none
     * @category funciones para crear cuadros de lista
     * @access private
     * @return string
     */
    private function definirEvento() {

        $evento = $this->atributos["evento"];

        switch ($evento) {
            case 1:
                $mi_evento = 'onchange="this.form.submit()"';
                break;

            case 2 :
                $this->control = explode("|", $this->configuracion["ajax_control"]);
                $mi_evento = "onchange=\"" . $this->configuracion["ajax_function"];
                $mi_evento.="(";
                foreach ($this->control as $miControl) {
                    $mi_evento.="document.getElementById('" . $miControl . "').value,";
                }
                $mi_evento = substr($mi_evento, 0, (strlen($mi_evento) - 1));
                $mi_evento.=")\"";
                break;

            default:
                $mi_evento = "";
        }
        return $mi_evento;
    }

    /**
     *
     * Define el registro de datos a partir del cual se construira el cuadro de lista
     * @name rescatarRegistroCuadroLista
     * @param none
     * @access private
     * @return none
     */
    private function rescatarRegistroCuadroLista() {
        //Si no se ha pasado una tabla de valores, entonces debe realizarse una busqueda con la opcion determinada
        //Si se ha pasado una tabla de valores, entonces se utiliza esa tabla y no se hacen consultas
        $cuadro_sql = $this->atributos["cadena_sql"];
        
        if (!is_array($cuadro_sql)) {


            //Si no se ha definido de donde tomar los datos se utiliza la base de datos definida en config.inc

            if (!isset($this->atributos["baseDatos"]) || (isset($this->atributos["baseDatos"]) && $this->atributos["baseDatos"] == "")) {
                $this->atributos["baseDatos"] = "configuracion";
            }

            $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($this->atributos["baseDatos"]);
            if (!$esteRecursoDB) {
                //Esto se considera un error fatal
                exit;
            }

            $this->cuadro_registro = $esteRecursoDB->ejecutarAcceso($cuadro_sql, "busqueda");


            if ($this->cuadro_registro) {

                $this->cuadro_campos = $esteRecursoDB->getConteo();

                //En el caso que se requiera una minilista de opciones al principio
                if (isset($this->atributos["subcadena_sql"])) {

                    $this->cuadro_miniRegistro = $esteRecursoDB->ejecutarAcceso($this->atributos["subcadena_sql"], "busqueda");
                    if ($this->cuadro_registro) {
                        return true;
                    }
                }
                return true;
            }

            return false;
        } else {
            $this->cuadro_registro = $cuadro_sql;
            $this->cuadro_campos = count($cuadro_sql);
            return true;           
        }
    }

// Fin del metodo rescatarRegistro
    //================================== Fin de las Funciones Cuadro Lista ==================================



    function cuadro_texto($configuracion, $atributos) {

        if (!isset($atributos["tipo"]) || $atributos["tipo"] != "hidden") {

            //--------------Atributo class --------------------------------
            if (isset($atributos["estilo"]) && $atributos["estilo"] != "") {

                if ($atributos["estilo"] == "jqueryui") {
                    $this->mi_cuadro = "<input class='ui-widget ui-widget-content ui-corner-all ";
                } else {
                    $this->mi_cuadro = "<input class='" . $atributos["estilo"] . " ";
                }
            } else {
                $this->mi_cuadro = "<input class='cuadroTexto ";
            }


            //Si se utiliza jQuery-Validation-Engine
            if (isset($atributos["validar"])) {
                $this->mi_cuadro.=" validate[" . $atributos["validar"] . "] ";
                //Si se utiliza jQuery-Validation-Engine
                if (isset($atributos["categoria"]) && $atributos["categoria"] = "fecha") {
                    $this->mi_cuadro.="datepicker ";
                }
            }

            $this->mi_cuadro.="' ";
            
            if (isset($atributos["place"])) {
                    $this->mi_cuadro.="placeholder='".$atributos["place"]."'";
            }

            //----------- Fin del atributo class ----------------------------

            if (isset($atributos["tipo"]) && $atributos["tipo"] != "") {
                $this->mi_cuadro.="type='" . $atributos["tipo"] . "' ";
            } else {
                $this->mi_cuadro.="type='text' ";
            }

            if (isset($atributos["titulo"]) && $atributos["titulo"] != "") {
                $this->mi_cuadro.="title='" . $atributos["titulo"] . "' ";
            }

            if (isset($atributos["deshabilitado"]) && $atributos["deshabilitado"] == true) {
                $this->mi_cuadro.="readonly='readonly' ";
            }

            if (isset($atributos["name"]) && $atributos["name"] != "") {
                $this->mi_cuadro.="name='" . $atributos["name"] . "' ";
            } else {
                $this->mi_cuadro.="name='" . $atributos["id"] . "' ";
            }


            $this->mi_cuadro.="id='" . $atributos["id"] . "' ";

            if (isset($atributos["valor"])) {
                $this->mi_cuadro.="value='" . $atributos["valor"] . "' ";
            }


            if (isset($atributos["tamanno"])) {
                $this->mi_cuadro.="size='" . $atributos["tamanno"] . "' ";
            } else {
                $this->mi_cuadro.="size='50' ";
            }


            if (isset($atributos["maximoTamanno"])) {
                $this->mi_cuadro.="maxlength='" . $atributos["maximoTamanno"] . "' ";
            } else {
                $this->mi_cuadro.="maxlength='100' ";
            }

            //Si se utiliza ketchup
            if (isset($atributos["data-validate"])) {
                $this->mi_cuadro.="data-validate='validate(" . $atributos["data-validate"] . ")' ";
            }
            
            //Si utiliza algun evento especial
            if (isset($atributos["evento"])) {
                $this->mi_cuadro.=" " . $atributos["evento"] . " ";
            }

            $this->mi_cuadro.="tabindex='" . $atributos["tabIndex"] . "' ";
            $this->mi_cuadro.=">\n";
        } else {

            $this->mi_cuadro = "<input type='hidden' ";
            $this->mi_cuadro.="name='" . $atributos["id"] . "' ";
            $this->mi_cuadro.="id='" . $atributos["id"] . "' ";
            if (isset($atributos["valor"])) {
                $this->mi_cuadro.="value='" . $atributos["valor"] . "' ";
            }
            $this->mi_cuadro.=">\n";
        }
        return $this->mi_cuadro;
    }

    function area_texto($configuracion, $atributos) {

        $this->mi_cuadro = "<textarea ";

        if (isset($atributos["deshabilitado"]) && $atributos["deshabilitado"] == true) {
            $this->mi_cuadro.="readonly='1' ";
        }

        if (isset($atributos["name"]) && $atributos["name"] != "") {
            $this->mi_cuadro.="name='" . $atributos["name"] . "' ";
        } else {
            $this->mi_cuadro.="name='" . $atributos["id"] . "' ";
        }


        $this->mi_cuadro.="id='" . $atributos["id"] . "' ";

        if (isset($atributos["columnas"])) {
            $this->mi_cuadro.="cols='" . $atributos["columnas"] . "' ";
        } else {
            $this->mi_cuadro.="cols='50' ";
        }

        if (isset($atributos["filas"])) {
            $this->mi_cuadro.="rows='" . $atributos["filas"] . "' ";
        } else {
            $this->mi_cuadro.="rows='2' ";
        }

        if (isset($atributos["estiloArea"]) && $atributos["estiloArea"] != "") {
            $this->mi_cuadro.="class='" . $atributos["estiloArea"] . "' ";
        } else {
            $this->mi_cuadro.="class='areaTexto' ";
        }

        $this->mi_cuadro.="tabindex='" . $atributos["tabIndex"] . "' ";
        $this->mi_cuadro.=">\n";
        if (isset($atributos["valor"])) {
            $this->mi_cuadro.=$atributos["valor"];
        } else {
            $this->mi_cuadro.="";
        }
        $this->mi_cuadro.="</textarea>\n";

        if (isset($atributos["textoEnriquecido"]) && $atributos["textoEnriquecido"] == true) {
            $this->mi_cuadro.="<script type=\"text/javascript\">\n";
            $this->mi_cuadro.="mis_botones='" . $configuracion["host"] . $configuracion["site"] . $configuracion["grafico"] . "/textarea/';\n";
            $this->mi_cuadro.="archivo_css='" . $configuracion["host"] . $configuracion["site"] . $configuracion["estilo"] . "/basico/estilo.php';\n";
            $this->mi_cuadro.="editor_html('" . $atributos["id"] . "', 'bold italic underline | left center right | number bullet | wikilink');";
            $this->mi_cuadro.="\n</script>";
        }

        return $this->mi_cuadro;
    }

    function etiqueta($atributos) {
        $this->mi_etiqueta = "";

        if (!isset($atributos["sinDivision"])) {
            if (isset($atributos["anchoEtiqueta"])) {

                $this->mi_etiqueta.="<div style='float:left; width:" . $atributos["anchoEtiqueta"] . "px' ";
            } else {
                $this->mi_etiqueta.="<div style='float:left; width:120px' ";
            }

            if (isset($atributos["estiloEtiqueta"])) {
                $this->mi_etiqueta.="class='" . $atributos["estiloEtiqueta"] . "'>";
            } else {
                $this->mi_etiqueta.=">";
            }
        }

        $this->mi_etiqueta.="<label for='" . $atributos["id"] . "' >";
        $this->mi_etiqueta.=$atributos["etiqueta"] . "</label>\n";

        if (isset($atributos["etiquetaObligatorio"]) && $atributos["etiquetaObligatorio"] == true) {
            $this->mi_etiqueta.="<span class='texto_rojo texto_pie'>* </span>";
        } else {
            if (!isset($atributos["sinDivision"]) && (isset($atributos["estilo"]) && $atributos["estilo"] != "jqueryui")) {
                $this->mi_etiqueta.="<span style='white-space:pre;'> </span>";
            }
        }


        if (!isset($atributos["sinDivision"])) {
            $this->mi_etiqueta.="</div>\n";
        }


        return $this->mi_etiqueta;
    }

    function boton($configuracion, $atributos) {

        if ($atributos["tipo"] == "boton") {
            $this->cadenaBoton = "<button ";
            $this->cadenaBoton.="value='" . $atributos["valor"] . "' ";
            $this->cadenaBoton.="id='" . $atributos["id"] . "A' ";
            $this->cadenaBoton.="tabindex='" . $atributos["tabIndex"] . "' ";
            $this->cadenaBoton.="type='button' ";

            if (!isset($atributos["onsubmit"])) {
                $atributos["onsubmit"] = "";
            }


            if (!isset($atributos["cancelar"]) && (isset($atributos["verificarFormulario"]) && $atributos["verificarFormulario"] != "")) {
                $this->cadenaBoton.="onclick=\"if(" . $atributos["verificarFormulario"] . "){document.forms['" . $atributos["nombreFormulario"] . "'].elements['" . $atributos["id"] . "'].value='true';";
                if (isset($atributos["tipoSubmit"]) && $atributos["tipoSubmit"] == "jquery") {
                    $this->cadenaBoton.=" $(this).closest('form').submit();";
                } else {
                    $this->cadenaBoton.="document.forms['" . $atributos["nombreFormulario"] . "'].submit()";
                }
                $this->cadenaBoton.="}else{this.disabled=false;false}\">" . $atributos["valor"] . "</button>\n";
                //El cuadro de Texto asociado
                $atributos["id"] = $atributos["id"];
                $atributos["tipo"] = "hidden";
                $atributos["obligatorio"] = false;
                $atributos["etiqueta"] = "";
                $atributos["valor"] = "false";
                $this->cadenaBoton.= $this->cuadro_texto($configuracion, $atributos);
            } else {
                

                if (isset($atributos["tipoSubmit"]) && $atributos["tipoSubmit"] == "jquery") {
                    //Utilizar esto para garantizar que se procesan los controladores de eventos de javascript al momento de enviar el form
                    $this->cadenaBoton.="onclick=\"document.forms['" . $atributos["nombreFormulario"] . "'].elements['" . $atributos["id"] . "'].value='true';";
                    $this->cadenaBoton.=" $(this).closest('form').submit();";
                } else if(!isset($atributos["onclick"])) {
                	$this->cadenaBoton.="onclick=\"document.forms['" . $atributos["nombreFormulario"] . "'].elements['" . $atributos["id"] . "'].value='true';";
                    $this->cadenaBoton.="document.forms['" . $atributos["nombreFormulario"] . "'].submit()";					
                }

				if(isset($atributos["onclick"]) && $atributos["onclick"] != '')
				{
					$this->cadenaBoton.="onclick=\" " . $atributos["onclick"] . "\" ";
				}

                $this->cadenaBoton.="\">" . $atributos["valor"] . "</button>\n";

                //El cuadro de Texto asociado
                $atributos["id"] = $atributos["id"];
                $atributos["tipo"] = "hidden";
                $atributos["obligatorio"] = false;
                $atributos["etiqueta"] = "";
                $atributos["valor"] = "false";
                $this->cadenaBoton.= $this->cuadro_texto($configuracion, $atributos);
            }
        } else {

            $this->cadenaBoton = "<input ";
            $this->cadenaBoton.="value='" . $atributos["valor"] . "' ";
            $this->cadenaBoton.="name='" . $atributos["id"] . "' ";
            $this->cadenaBoton.="id='" . $atributos["id"] . "' ";
            $this->cadenaBoton.="tabindex='" . $atributos["tabIndex"] . "' ";
            $this->cadenaBoton.="type='submit' ";
            $this->cadenaBoton.=">\n";
        }
        return $this->cadenaBoton;
    }

    #Funcion que genera listas desplegables con grupos de opciones
    #Matriz_items es un vector, donde la posicion cero y las posiciones pares corresponden a los labels de los grupos de opciones y las posiciones impares corresponden a las opciones por cada grupo.
    #Las posiciones impar contienen un vector con las opciones correspondientes al grupo de opciones

    function cuadro_listaGrupos($matriz_items, $nombre, $configuracion, $seleccion, $evento, $limitar, $tab = 0, $id) {
        include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/cadenas.class.php");
        $this->formato = new cadenas();
        $this->cuadro_registro = $matriz_items;
        $this->cuadro_campos = count($matriz_items);

        $this->mi_cuadro = "";

        if ($this->cuadro_campos > 0) {
            switch ($evento) {
                case 1:
                    $mi_evento = 'onchange="this.form.submit()"';
                    break;

                case 2 :
                    $mi_evento = "onchange=\"" . $configuracion["ajax_function"] . "(document.getElementById('" . $configuracion["ajax_control"] . "').value)\"";
                    break;
                case 3:
                    $mi_evento = 'disabled="yes"';
                    break;
                default:
                    $mi_evento = "";
            }#Cierre de switch($evento)
            #Si trae id para asignar
            if ($id != "") {
                $id = "id='" . $id . "'";
            }

            #Construye cuadro de seleccion
            $this->mi_cuadro = "<select name='" . $nombre . "' size='1' " . $mi_evento . " tabindex='" . $tab . "' " . $id . ">\n";

            #Si no se especifica una seleccion se agrega un espacio en blanco
            if ($seleccion < 0) {
                $this->mi_cuadro.="<option value=''>Seleccione </option>\n";
            }


            for ($this->grupos_contador = 0; $this->grupos_contador < $this->cuadro_campos - 1; $this->grupos_contador++) {
                if (!is_array($this->cuadro_registro[$this->grupos_contador]) && is_array($this->cuadro_registro[$this->grupos_contador + 1])) {
                    $this->valor = $this->cuadro_registro[$this->grupos_contador];
                    $this->mi_cuadro.="<optgroup ";
                    $this->mi_cuadro.="label='" . $this->valor . "'>";

                    #Almacena en otra variable el vector que viene en $this->cuadro_registro[$this->grupos_contador+1] para poderlo manipular
                    $this->opciones = $this->cuadro_registro[$this->grupos_contador + 1];

                    #Escribe las opciones del select
                    $this->opciones_num_campos = count($this->opciones);
                    $this->opciones_contador_valor = 0;
                    $this->opciones_contador_texto = 1;

                    while ($this->opciones_contador_texto < $this->opciones_num_campos) {

                        $this->mi_cuadro.="<option ";
                        $this->mi_cuadro.="value=" . $this->opciones[$this->opciones_contador_valor];

                        #Si debe seleccionar un registro especifico
                        if ($seleccion == $this->opciones[$this->opciones_contador_valor]) {
                            $this->mi_cuadro.=" selected='true'";
                        }
                        $this->mi_cuadro.=">";
                        $this->texto = $this->opciones[$this->opciones_contador_texto];

                        #Si debe limitar el texto en la visualizacion
                        if ($limitar == 1) {
                            $this->texto = $this->formato->unhtmlentities(substr($this->texto, 0, 20));
                        } else {
                            $this->texto = $this->formato->formatohtml($this->texto);
                        }
                        $this->mi_cuadro.=$this->texto;
                        $this->mi_cuadro.="</option>";


                        $this->opciones_contador_valor = $this->opciones_contador_valor + 2;
                        $this->opciones_contador_texto = $this->opciones_contador_texto + 2;
                    }

                    $this->mi_cuadro.="</optgroup>";
                    $this->grupos_contador + 1;
                }
            }#Cierre de for
            $this->mi_cuadro.="</select>\n";
        }#Cierre de if $this->cuadro_campos>0
        else {
            echo "Imposible rescatar los datos.";
        }

        return $this->mi_cuadro;
    }

#Cierre de funcion cuadro_listaGrupos

    function radioButton($configuracion, $atributos) {
        $this->miOpcion = "";
        $nombre = $atributos["id"];
        $id = "campo" . rand();

        if (isset($atributos["opciones"])) {
            $opciones = explode("|", $atributos["opciones"]);

            if (is_array($opciones)) {

                foreach ($opciones as $clave => $valor) {
                    $opcion = explode("&", $valor);
                    if ($opcion[0] != "") {
                        if ($opcion[0] != $atributos["seleccion"]) {
                        	$this->miOpcion.="<div>";
                            $this->miOpcion.="<input type='radio' id='" . $id . "' name='" . $nombre . "' value='" . $opcion[0] . "' />";
                            $this->miOpcion.="<label for='" . $id . "'>";
                            $this->miOpcion.=$opcion[1] . "";
                            $this->miOpcion.="</label>";
							$this->miOpcion.="</div>";
                        } else {
                        	$this->miOpcion.="<div>";
                            $this->miOpcion.="<input type='radio' id='" . $id . "' name='" . $nombre . "' value='" . $opcion[0] . "' checked /> ";
                            $this->miOpcion.="<label for='" . $id . "'>";
                            $this->miOpcion.=$opcion[1] . "";
                            $this->miOpcion.="</label>";
							$this->miOpcion.="</div>";
                        }
                    }
                }
            }
        } else {

            $this->miOpcion.="<input type='radio' ";
            $this->miOpcion.="name='" . $id . "' ";
            $this->miOpcion.="id='" . $id . "' ";

            $this->miOpcion.="value='" . $atributos["valor"] . "' ";

            if (isset($atributos["tabIndex"])) {
                $this->miOpcion.="tabindex='" . $atributos["tabIndex"] . "' ";
            }

            if (isset($atributos["seleccionado"]) && $atributos["seleccionado"] == true) {
                $this->miOpcion.="checked='true' ";
            }

            $this->miOpcion.="/> ";
            $this->miOpcion.="<label for='" . $id . "'>";
            $this->miOpcion.=$atributos["etiqueta"];
            $this->miOpcion.="</label>\n";
        }
        return $this->miOpcion;
    }

    function checkBox($configuracion, $atributos) {

        $this->miOpcion.="<label for='" . $atributos["id"] . "'>";


        $this->miOpcion.="<input type='checkbox' ";

        if (isset($atributos["id"])) {
            $this->miOpcion.="name='" . $atributos["id"] . "' ";
            $this->miOpcion.="id='" . $atributos["id"] . "' ";
        }

        if (isset($atributos["valor"])) {
            $this->miOpcion.="value='" . $atributos["valor"] . "' ";
        }

        if (isset($atributos["tabIndex"])) {
            $this->miOpcion.="tabindex='" . $atributos["tabIndex"] . "' ";
        }

        if (isset($atributos["evento"])) {
            $this->miOpcion.=$atributos["evento"] . "=\"" . $atributos["eventoFuncion"] . "\" ";
        }

        if (isset($atributos["seleccionado"]) && $atributos["seleccionado"] == true) {
            $this->miOpcion.="checked ";
        }

        $this->miOpcion.="/>";
        $this->miOpcion.=$atributos["etiqueta"];
        $this->miOpcion.="</label>\n";
        return $this->miOpcion;
    }

}

//Fin de la clase html
?>
