<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

//
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorioIndex = $this->miConfigurador->getVariableConfiguracion("host");
$directorioIndex.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorioIndex.=$this->miConfigurador->getVariableConfiguracion("enlace");

$tab=1;
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";
//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"]=$nombreFormulario;
$atributos["tipoFormulario"]="multipart/form-data";
$atributos["metodo"]="POST";
$atributos["nombreFormulario"]=$nombreFormulario;
$verificarFormulario="1";
echo $this->miFormulario->formulario("inicio",$atributos);

//-----------------Inicio de Conjunto de Controles----------------------------------------
$esteCampo="descargar";
$atributos["estilo"]="jqueryui";
$atributos["leyenda"]=$this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->marcoAGrupacion("inicio",$atributos);

//validamos si existe una sesion activa desde condor
$conexion="docente";                
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

if(!$esteRecursoDB){

        //Este se considera un error fatal
        exit;

}

$cadena_sql=$this->sql->cadena_sql("validarDocente",$_REQUEST['identificacion']);

$registro=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

if(is_array($registro))
    {
    $cedulaCod = base64_encode($_REQUEST['identificacion']);
    $ruta = "http://10.20.0.38:8080/birt/frameset?__report=Docencia/cuentas.rptdesign&__format=pdf&cedula=".$_REQUEST['identificacion'];

    ?>
<div id="reporte" name="reporte" width="100%">
    <iframe src="<?php echo $ruta?>" width="100%" height="350px">
    
    </iframe>
</div>
    
    <?
    }else
        {
            ?>
            <table class="tablaContenido2" align="center" >
                <tr>
                    <td align="center">
                        <div class="margen2 centrar">
                            El documento digitado no pertenece a un docente activo.
                        </div>
                    </td>       
                </tr>
            </table>

            <?
        }





//Fin de Conjunto de Controles
echo $this->miFormulario->marcoAGrupacion("fin");

//----------------------Fin Conjunto de Controles--------------------------------------



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


?>