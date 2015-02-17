<?php
if(!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}else
{

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

$nombreFormulario=$esteBloque["nombre"];

include_once("core/crypto/Encriptador.class.php");
$cripto=Encriptador::singleton();
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

$miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");

if(isset($_REQUEST ['docente']))
    {
        $conexion = "estructura";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
        $consultarDocente = $this->cadena_sql = $this->sql->cadena_sql ( "consultarDocente", $_REQUEST ['docente'] );
        $resultadoConsulta = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );
    }
    
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
	
if($_REQUEST['mensaje'] == 'confirma')
	{
            $tipo = 'success';
            $mensaje = "Se agrego Dirección de Trabajo de Grado para ".$_REQUEST ['docente'].". Presione el botón Continuar.";
            $boton = "continuar";
            
            $valorCodificado="pagina=".$miPaginaActual;
            $valorCodificado.="&opcion=nuevo"; 
            $valorCodificado.="&bloque=".$esteBloque["id_bloque"];
            $valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
            $valorCodificado=$cripto->codificar($valorCodificado);
                
	}else if($_REQUEST['mensaje'] == 'error')
	{
            $tipo = 'error';
            $mensaje = "No se pudo guardar  Dirección de Trabajo de Grado  para el docente ".$_REQUEST ['docente'].". Intente de nuevo mas tarde.";
            $boton = "regresar";
                        
            $valorCodificado="pagina=".$miPaginaActual;
            $valorCodificado.="&opcion=nuevo"; 
            $valorCodificado.="&bloque=".$esteBloque["id_bloque"];
            $valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
            $valorCodificado=$cripto->codificar($valorCodificado);
	}else if($_REQUEST['mensaje'] == 'mensajeActualizar')
	{
           $tipo = 'success';
            $mensaje = "Se actualizo  Dirección de Trabajo de Grado del Docente  ".$resultadoConsulta[0]['nombres'].". Presione el botón Continuar.";
            $boton = "continuar";
            
            $valorCodificado="pagina=".$miPaginaActual;
            $valorCodificado.="&opcion=nuevo"; 
            $valorCodificado.="&bloque=".$esteBloque["id_bloque"];
            $valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
            $valorCodificado=$cripto->codificar($valorCodificado);
            
	}else if($_REQUEST['mensaje'] == 'maxDireccion')
	{
            $tipo = 'error';
            $mensaje = "No se puede registrar la Dirección de Trabajo de Grado del docente ".$resultadoConsulta[0]['nombres'].".<br>Maximo número de Direcciones Trabajo de Grado por año.";
            $boton = "regresar";
                        
            $valorCodificado="pagina=".$miPaginaActual;
            $valorCodificado.="&opcion=nuevo"; 
            $valorCodificado.="&bloque=".$esteBloque["id_bloque"];
            $valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
            $valorCodificado=$cripto->codificar($valorCodificado);
	}else if($_REQUEST['mensaje'] == 'mensajenoActualizar')
	{
            $tipo = 'error';
            $mensaje = "No se pudo actualizar  Dirección de Trabajo de Grado del docente ".$resultadoConsulta[0]['nombres'].".";
            $boton = "regresar";
                        
            $valorCodificado="pagina=".$miPaginaActual;
            $valorCodificado.="&opcion=nuevo"; 
            $valorCodificado.="&bloque=".$esteBloque["id_bloque"];
            $valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
            $valorCodificado=$cripto->codificar($valorCodificado);
	}else if($_REQUEST['mensaje'] == 'noDatosDocente')
	{
            $tipo = 'error';
            $mensaje = "Error en el documento del docente. No es un documento valido.";
            $boton = "regresar";
                        
            $valorCodificado="pagina=".$miPaginaActual;
            $valorCodificado.="&opcion=nuevo"; 
            $valorCodificado.="&bloque=".$esteBloque["id_bloque"];
            $valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
            $valorCodificado=$cripto->codificar($valorCodificado);
	}
        
        
	$esteCampo = "mensajeFinal";
        $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
        $atributos["etiqueta"] = "";
        $atributos["estilo"] = "centrar";
        $atributos["tipo"] = $tipo;
        $atributos["mensaje"] = $mensaje;
        echo $this->miFormulario->cuadroMensaje($atributos);
        unset($atributos); 
        
        //------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");
        
        //------------------Division para los botones-------------------------
	$atributos["id"]="botones";
	$atributos["estilo"]="marcoBotones";
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo = $boton;
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