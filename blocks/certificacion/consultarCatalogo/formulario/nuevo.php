<?php
$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site")."/blocks/administrativos/gestionAdministrativos/";
//$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/evaldocentes/inicioEvaldocente/";
//$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];
$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$nombreFormulario = $esteBloque["nombre"];

$conexion = "funcionario";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
                                        
if (!$esteRecursoDB) {

    echo "//Este se considera un error fatal";
    exit;
}
$variable['usuario']=$_REQUEST['usuario'];
$cadena_sql = $this->sql->cadena_sql("buscarUsuario", $variable);
$registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$cadena_sql = $this->sql->cadena_sql("anioper", $variable);
$resultAnioPer = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$ano=$resultAnioPer[0][0];
$per=$resultAnioPer[0][1];

//------------------Division para las pestañas-------------------------
$atributos["id"] = "tabs";
$atributos["estilo"] = "";
echo $this->miFormulario->division("inicio", $atributos);
unset($atributos);

////-------------------------------Mensaje-------------------------------------
$tipo = 'message';
$mensaje = "<center><span class='textoNegrita textoGrande textoCentrar'><br>CERTIFICADO DE INGRESOS Y RETENCIONES</span></center><br>
            <span class='textoNegrita textoPequeno textoCentrar'>Nombre: ".$registro[0][0]."</span><br>
            <span class='textoNegrita textoPequeno textoCentrar'>Identificación: ".$registro[0][1]."</span><br>
            <p class='textoJustificar'>
                Seleccione el a&ntilde;o, haga Click en la imagen del PDF para generar el certificado de ingresos y retenciones.
            </p> ";


$esteCampo = "mensaje";
$atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
$atributos["etiqueta"] = "";
$atributos["estilo"] = "centrar";
$atributos["tipo"] = $tipo;
$atributos["mensaje"] = $mensaje;
echo $this->miFormulario->cuadroMensaje($atributos);
unset($atributos);

if($registro)
{	
        echo "<table id='tablaCertificados'>";
        
        echo "<thead>
                <tr>
                    <th>Año</th>
                    <th>Certificado</th>
               </tr>
            </thead>
            <tbody>";
        
        for($i=$ano; $i>=$ano-2; $i--)
	{
            $variables ="pagina=gestionAdministrativos"; //pendiente la pagina para modificar parametro                                                        
            $variables.="&opcion=certificadoIngresosRetenciones";
            $variables.="&action=".$esteBloque["nombre"];
            $variables.="&usuario=".$_REQUEST['usuario'];
            $variables.="&anio=".$i;
            $variables.="&tipo=".$_REQUEST['tipo'];
            $variables.="&bloque=".$esteBloque["id_bloque"];
            $variables.="&bloqueGrupo=".$esteBloque["grupo"];
            $variables = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variables, $directorio);    
            echo "<tr>
                    <td align='center'>".$i."</td>
                    <td align='center'><a href='".$variables."'>               
                    <img src='".$rutaBloque."images/pdf.png' width='25px'> 
                    </a></td>    
                </tr>";
           
        }
               
        echo "</tbody>";
        
}else
{
	$atributos["id"]="divNoEncontroRegistro";
	$atributos["estilo"]="marcoBotones";
        //$atributos["estiloEnLinea"]="display:none"; 
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo = "noEncontroRegistro";
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

echo $this->miFormulario->division("fin");







