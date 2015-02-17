<?

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$miBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$indice = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorioAjax = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque") . "script/ajax/";

$nombreFormulario = $miBloque["nombre"];
$tab = 1;

$valorCodificado = "action=" . $miBloque["nombre"];
$valorCodificado.="&opcion=confirmar";
$valorCodificado.="&bloque=" . $miBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=" . $miBloque["grupo"];

/**
 * @todo Verificar la sesión
 */
//$valorCodificado.="&id_sesion=".$configuracion["id_sesion"];


$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

$this->cadena_sql = $this->sql->cadena_sql("rescatarTemp");

/**
 * La conexiòn que se debe utilizar es la principal de SARA
 */
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$resultado = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");

$totalRegistros = $esteRecursoDB->getConteo();

if ($totalRegistros > 0) {

    for ($i = 0; $i < $totalRegistros; $i++) {

        $variable[trim($resultado[$i]["campo"])] = $resultado[$i]["valor"];
    }
    //include("");

    /**
     * Se debe realizar la conexion a oracle para consultar los datos del docente
     */
    $conexion = "docente";
    $esteRecursoDBOracle = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

    $this->cadena_sql = $this->sql->cadena_sql("datosDocente", $variable['identificacionFinal']);
    $resultado = $esteRecursoDBOracle->ejecutarAcceso($this->cadena_sql, "busqueda");
    //------------------Division General-------------------------
    $atributos["id"] = "";

    //Formulario para nuevos registros de usuario
    $atributos["tipoFormulario"] = "multipart/form-data";
    $atributos["metodo"] = "POST";
    $atributos["estilo"] = "formularioConJqgrid";
    $atributos["nombreFormulario"] = $miBloque["nombre"];
    echo $this->miFormulario->marcoFormulario("inicio", $atributos);



    //-------------Mostrar Datos a Confirmar-----------------------
    //En este caso se va a mostrar un formulario de confirmación estilizado
    //en otros casos es más adecuado mostrar los datos como un listado.
    //-----------------Inicio de Conjunto de Controles----------------------------------------
    $esteCampo = "marcoDatosBusqueda";
    $atributos["estilo"] = "jqueryui";
    $atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
    echo $this->miFormulario->marcoAGrupacion("inicio", $atributos);
    unset($atributos);

    //-------------Control cuadroTexto-----------------------

    $esteCampo = "textoDocente";
    $atributos["tamanno"] = "";
    $atributos["estilo"] = "jqueryui";
    $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
    $atributos["texto"] = $variable['nombreDoc'];
    echo $this->miFormulario->campoTexto($atributos);

    //-------------Control cuadroTexto-----------------------

    $esteCampo = "textoTipoVinculacion";
    $atributos["tamanno"] = "";
    $atributos["estilo"] = "jqueryui";
    $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
    $atributos["texto"] = $resultado[0]['TVI_NOMBRE'];
    echo $this->miFormulario->campoTexto($atributos);

    //-------------Control cuadroTexto-----------------------

    $esteCampo = "textoProyectoCurricular";
    $atributos["tamanno"] = "";
    $atributos["estilo"] = "jqueryui";
    $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
    $atributos["texto"] = $resultado[0]['CRA_NOMBRE'];
    ;
    echo $this->miFormulario->campoTexto($atributos);


    //Fin de Conjunto de Controles
    echo $this->miFormulario->marcoAGrupacion("fin");

    //-----------------Inicio de Conjunto de Controles----------------------------------------
    $esteCampo = "marcoDatosAsignatura";
    $atributos["estilo"] = "jqueryui";
    $atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
    echo $this->miFormulario->marcoAGrupacion("inicio", $atributos);
    unset($atributos);


    //-------------Control Lista Desplegable-----------------------
    $esteCampo = "proyecto";
    $atributos["id"] = $esteCampo;
    $atributos["tabIndex"] = $tab++;
    $atributos["seleccion"] = -1;
    //------------ Control Asociado --------------------------------
    $atributos["evento"] = 2; //IMPORTANTE: evento=2 le indica que utilice ajax para recargar otro control
    //$atributos["ajaxControl"]="curso"; //Nombre del control asociado.
    $atributos["ajaxFunction"] = "poblarCurso()"; //Función Ajax asociada
    // -------------------------------------------------------------
    $atributos["limitar"] = false;
    $atributos["tamanno"] = 1;
    $atributos["estilo"] = "jqueryui";
    $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
    //-----De donde rescatar los datos ---------
    $atributos["cadena_sql"] = $this->sql->cadena_sql("carreras", $variable['coordinador']);
    $atributos["baseDatos"] = "docente";
    echo $this->miFormulario->campoCuadroLista($atributos);
    unset($atributos);


    //-------------Control Lista Desplegable-----------------------
    $esteCampo = "curso";
    $atributos["id"] = $esteCampo;
    $atributos["tabIndex"] = $tab++;
    $atributos["seleccion"] = -1;
    //------------ Control Asociado --------------------------------
    //$atributos["evento"]=2; //IMPORTANTE: evento=2 le indica que utilice ajax para recargar otro control
    //$atributos["ajaxControl"]="curso"; //Nombre del control asociado.
    //$atributos["ajaxFunction"]="poblarCurso()"; //Función Ajax asociada
    // -------------------------------------------------------------
    $atributos["limitar"] = false;
    $atributos["tamanno"] = 1;
    $atributos["estilo"] = "jqueryui";
    $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
    //-----De donde rescatar los datos ---------
    //$atributos["cadena_sql"]=$this->sql->cadena_sql("carreras",$variable['coordinador']);
    //$atributos["baseDatos"]="docente";
    echo $this->miFormulario->campoCuadroLista($atributos);
    unset($atributos);


    //Fin de Conjunto de Controles
    echo $this->miFormulario->marcoAGrupacion("fin");

    
    
    
    
    ?>
    
<div name="horario" id="horario" style="display: none;" class="jqueryui"> 
     <?php
         //-----------------Inicio de Conjunto de Controles----------------------------------------
    $esteCampo = "marcoDatosAsignacion";
    $atributos["estilo"] = "jqueryui";
    $atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
    echo $this->miFormulario->marcoAGrupacion("inicio", $atributos);
    unset($atributos);
        
        ?>
    
    <div name="cuerpoAsignacion" id="cuerpoAsignacion" class="jqueryui">
        
    </div>
    <?php 
    //Fin de Conjunto de Controles
    echo $this->miFormulario->marcoAGrupacion("fin");
    ?>
    
    <?php
         //-----------------Inicio de Conjunto de Controles----------------------------------------
    $esteCampo = "marcoDatosHorario";
    $atributos["estilo"] = "jqueryui";
    $atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
    echo $this->miFormulario->marcoAGrupacion("inicio", $atributos);
    unset($atributos);
        
        ?>
    <div name="cuerpoHorario" id="cuerpoHorario" class="jqueryui">
        
    </div>
    <?php 
    //Fin de Conjunto de Controles
    echo $this->miFormulario->marcoAGrupacion("fin");
    ?>
</div>

    <?php
    //Fin de Conjunto de Controles
    echo $this->miFormulario->marcoAGrupacion("fin");
    
    //----------------------Fin Conjunto de Controles--------------------------------------
    //-------------Control cuadroTexto con campos ocultos-----------------------
    $atributos["id"] = "formSaraData";
    $atributos["tipo"] = "hidden";
    $atributos["etiqueta"] = "";
    $atributos["valor"] = $valorCodificado;
    echo $this->miFormulario->campoCuadroTexto($atributos);


    //-------------------Fin Division-------------------------------
    echo $this->miFormulario->marcoFormulario("fin", $atributos);
}
?>