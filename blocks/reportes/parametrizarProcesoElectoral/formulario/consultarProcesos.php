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

//validamos los datos que llegan

if(isset($_REQUEST['nombreProceso']) && $_REQUEST['nombreProceso']!='')
    {
        $nombreProceso = $_REQUEST['nombreProceso'];
    }else
        {
            $nombreProceso = "";
        }
if(isset($_REQUEST['fechaInicio']) && $_REQUEST['fechaInicio']!='')
    {
        $fechaInicioProceso = $_REQUEST['fechaInicio'];
    }else
        {
            $fechaInicioProceso = "";
        }
if(isset($_REQUEST['tipovotacion']) && $_REQUEST['tipovotacion']!='')
    {    
        $tipoVotacionProceso = $_REQUEST['tipovotacion'];
    }

    $arreglo = array($nombreProceso,$fechaInicioProceso,$tipoVotacionProceso);

$cadena_sql = $this->sql->cadena_sql("idioma", $arreglo);
$resultadoIdioma = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");    
   
$cadena_sql = $this->sql->cadena_sql("consultarProcesos", $arreglo);
$resultadoProcesos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

if($resultadoProcesos)
{	
    //-----------------Inicio de Conjunto de Controles----------------------------------------
        $esteCampo = "marcoDatosResultadoParametrizar";
        $atributos["estilo"] = "jqueryui";
        $atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
        //echo $this->miFormulario->marcoAgrupacion("inicio", $atributos);
        unset($atributos);
    
        echo "<table id='tablaProcesos'>";
        
        echo "<thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Final</th>                    
                    <th>Cantidad Elecciones</th>
                    <th>Parametrizar</th>
                </tr>
            </thead>
            <tbody>";
        
        for($i=0;$i<count($resultadoProcesos);$i++)
        {
            $variable = "pagina=parametrizarProcesoElectoral"; //pendiente la pagina para modificar parametro                                                        
            $variable.= "&opcion=parametrizar";
            $variable.= "&usuario=" . $miSesion->getSesionUsuarioId();
            $variable.= "&proceso=" .$resultadoProcesos[$i][7];
            $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);
            
            $mostrarHtml = "<tr>
                    <td>".$resultadoProcesos[$i][0]."</td>
                    <td>".$resultadoProcesos[$i][2]."</td>
                    <td>".$resultadoProcesos[$i][3]."</td>
                    <td>".$resultadoProcesos[$i][5]."</td>
                    <td>";
            
            if($resultadoProcesos[$i][8] < date('Y-m-d H:m:s'))
                {
                    $mostrarHtml .= "El proceso no se puede parametrizar, ya inicio la elección";
                }else{
                        $mostrarHtml .= "<a href='".$variable."'>                        
                                            <img src='".$rutaBloque."/images/edit.png' width='15px'> 
                                        </a>";
                    }
                        
                $mostrarHtml .= "</td>
                </tr>";
                echo $mostrarHtml;
                unset($mostrarHtml);
                unset($variable);
        }
               
        echo "</tbody>";
        
        echo "</table>";
        
        //Fin de Conjunto de Controles
        //echo $this->miFormulario->marcoAgrupacion("fin");
   
}else
{
        $nombreFormulario=$esteBloque["nombre"];
                include_once("core/crypto/Encriptador.class.php");
        $cripto=Encriptador::singleton();
        $directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

        $miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");

        $tab=1;
        //---------------Inicio Formulario (<form>)--------------------------------
        $atributos["id"]=$nombreFormulario;
        $atributos["tipoFormulario"]="multipart/form-data";
        $atributos["metodo"]="POST";
        $atributos["nombreFormulario"]=$nombreFormulario;
        $verificarFormulario="1";
        echo $this->miFormulario->formulario("inicio",$atributos);
        
	$atributos["id"]="divNoEncontroEgresado";
	$atributos["estilo"]="marcoBotones";
   //$atributos["estiloEnLinea"]="display:none"; 
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo = "noEncontroProcesos";
	$atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
	$atributos["etiqueta"] = "";
	$atributos["estilo"] = "centrar";
	$atributos["tipo"] = 'error';
	$atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);;
	echo $this->miFormulario->cuadroMensaje($atributos);
    unset($atributos); 
    
        $valorCodificado="pagina=".$miPaginaActual;
        $valorCodificado.="&bloque=".$esteBloque["id_bloque"];
        $valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
        $valorCodificado=$cripto->codificar($valorCodificado);
	//-------------Fin Control Boton----------------------
	
	//------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");
        //------------------Division para los botones-------------------------
	$atributos["id"]="botones";
	$atributos["estilo"]="marcoBotones";
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo = "regresar";
	$atributos["id"]=$esteCampo;
	$atributos["tabIndex"]=$tab++;
	$atributos["tipo"]="boton";
	$atributos["estilo"]="jquery";
	$atributos["verificar"]="true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
	$atributos["tipoSubmit"]="jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
	$atributos["valor"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["nombreFormulario"]=$nombreFormulario;
	echo $this->miFormulario->campoBoton($atributos);
	unset($atributos);
	//-------------Fin Control Boton----------------------
	
	
	//------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");
    
	//-------------Control cuadroTexto con campos ocultos-----------------------
	//Para pasar variables entre formularios o enviar datos para validar sesiones
	$atributos["id"]="formSaraData"; //No cambiar este nombre
	$atributos["tipo"]="hidden";
	$atributos["obligatorio"]=false;
	$atributos["etiqueta"]="";
	$atributos["valor"]=$valorCodificado;
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);
	
        //Fin del Formulario
        echo $this->miFormulario->formulario("fin");
}
    

?>