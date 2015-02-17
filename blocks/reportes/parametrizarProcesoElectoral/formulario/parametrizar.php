<?

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

$nombreFormulario=$esteBloque["nombre"];

$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$proceso = $_REQUEST['proceso'];

$cadena_sql = $this->sql->cadena_sql("idioma", $proceso);
$resultadoIdioma = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");  

$cadena_sql = $this->sql->cadena_sql("datosProceso", $proceso);
$resultadoProceso = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda"); 
//var_dump($resultadoProceso);
if($resultadoProceso)
    {
        $atributos["id"]="divInfoProceso";
        $atributos["estilo"]="marcoBotones";
        //$atributos["estiloEnLinea"]="display:none"; 
        echo $this->miFormulario->division("inicio",$atributos);
        
        //-----------------Inicio de Conjunto de Controles----------------------------------------
        $esteCampo = "marcoDatosProceso";
        $atributos["estilo"] = "jqueryui";
        $atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
        echo $this->miFormulario->marcoAGrupacion("inicio", $atributos);
        unset($atributos);

        //-------------------------------Mensaje-------------------------------------
        $esteCampo="nombreProceso";
        $atributos["id"]=$esteCampo;
        $atributos["obligatorio"]=false;
        $atributos["estilo"]="textoTitulo textoJustificar";
        $atributos["columnas"]=1;
        $atributos["texto"]="Nombre proceso: ".$resultadoProceso[0]['nombre'];
        echo $this->miFormulario->campoTexto($atributos);
        //-------------------------------Mensaje-------------------------------------
        $esteCampo="fechaInicioProceso";
        $atributos["id"]=$esteCampo;
        $atributos["obligatorio"]=false;
        $atributos["estilo"]="textoTitulo textoJustificar";
        $atributos["columnas"]=1;
        $atributos["texto"]="Fecha Inicio: ".$resultadoProceso[0]['fechainicio'];
        echo $this->miFormulario->campoTexto($atributos);
        //-------------------------------Mensaje-------------------------------------
        $esteCampo="fechaFinProceso";
        $atributos["id"]=$esteCampo;
        $atributos["obligatorio"]=false;
        $atributos["estilo"]="textoTitulo textoJustificar";
        $atributos["columnas"]=1;
        $atributos["texto"]="Fecha Fin: ".$resultadoProceso[0]['fechafin'];
        echo $this->miFormulario->campoTexto($atributos);
        //-------------------------------Mensaje-------------------------------------
        $esteCampo="actoAdministrativo";
        $atributos["id"]=$esteCampo;
        $atributos["obligatorio"]=false;
        $atributos["estilo"]="textoTitulo textoJustificar";
        $atributos["columnas"]=1;
        $atributos["texto"]="Documento que autoriza el proceso: ".$resultadoProceso[0]['acto'];
        echo $this->miFormulario->campoTexto($atributos);
        //-------------------------------Mensaje-------------------------------------
        $esteCampo="cantidadElecciones";
        $atributos["id"]=$esteCampo;
        $atributos["obligatorio"]=false;
        $atributos["estilo"]="textoTitulo textoJustificar";
        $atributos["columnas"]=1;
        $atributos["texto"]="Cantidad de elecciones que pertenecen al proceso: ".$resultadoProceso[0]['cantidadelecciones'];
        echo $this->miFormulario->campoTexto($atributos);

        //Fin de Conjunto de Controles
        echo $this->miFormulario->marcoAGrupacion("fin");
        
        //-----------------Inicio de Conjunto de Controles----------------------------------------
        $esteCampo = "marcoDatosParametrizacion";
        $atributos["estilo"] = "jqueryui";
        $atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
        echo $this->miFormulario->marcoAGrupacion("inicio", $atributos);
        unset($atributos);
        
        //------------------Division para las pestañas-------------------------
        $atributos["id"]="tabs";
        $atributos["estilo"]="";
        echo $this->miFormulario->division("inicio",$atributos);
        unset($atributos);
                
        $cantidadElecciones = (int)$resultadoProceso[0]['cantidadelecciones'];
        
        for($i=0;$i<$cantidadElecciones;$i++)
        {
            $eleccionForm = ($i+1);
            $arrayEleccionForm = array($proceso, $eleccionForm);
            
            $this->cadena_sql = $this->sql->cadena_sql("consultaEleccion", $arrayEleccionForm);
            $resultadoEleccionForm = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");
                        
            if($resultadoEleccionForm)
                {
                    $items["tabEleccion".$i]=$resultadoEleccionForm[0]['nombre'];
                }else
                    {
                        $items["tabEleccion".$i]=$this->lenguaje->getCadena("tabEleccion")." ".($i+1);
                    }            
        }
        $atributos["items"]=$items;
        $atributos["estilo"]="jqueryui";
        $atributos["pestañas"]="true";
        echo $this->miFormulario->listaNoOrdenada($atributos);
            
        for($j=0;$j<$cantidadElecciones;$j++)
        {   unset($atributos);
            //------------------Division para la pestaña 2-------------------------
            $idEleccion = $j+1;
            $atributos["id"]="tabEleccion".$j;
            $atributos["estilo"]="";
            echo $this->miFormulario->division("inicio",$atributos);
            
            include($this->ruta."formulario/tabs/tabEleccion.php"); 
            
             //-----------------Fin Division para la pestaña 1-------------------------
            echo $this->miFormulario->division("fin");
            
        }
       
        //-----------------Fin Division para los tabs-------------------------
        echo $this->miFormulario->division("fin");
        
        //Fin de Conjunto de Controles
        echo $this->miFormulario->marcoAGrupacion("fin");
        

    }else
        {
            $atributos["id"]="divNoEncontroEgresado";
            $atributos["estilo"]="marcoBotones";
            //$atributos["estiloEnLinea"]="display:none"; 
            echo $this->miFormulario->division("inicio",$atributos);

            //-------------Control Boton-----------------------
            $esteCampo = "noEncontroEgresado";
            $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
            $atributos["etiqueta"] = "";
            $atributos["estilo"] = "centrar";
            $atributos["tipo"] = 'error';
            $atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);;
            echo $this->miFormulario->cuadroMensaje($atributos);
            unset($atributos); 
            //-------------Fin Control Boton----------------------

            //------------------Fin Division para los botones-------------------------
            echo $this->miFormulario->division("fin");
        }
    

?>