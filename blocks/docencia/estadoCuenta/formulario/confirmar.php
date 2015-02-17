<?

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

$miBloque=$this->miConfigurador->getVariableConfiguracion("esteBloque");
$indice=$this->miConfigurador->getVariableConfiguracion("host").$this->miConfigurador->getVariableConfiguracion("site")."/index.php?";
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

$tab=1;


$valorCodificado="action=".$miBloque["nombre"];
$valorCodificado.="&opcion=confirmar";
$valorCodificado.="&bloque=".$miBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=".$miBloque["grupo"];
/**
 * @todo Corregir esto cuando se mejore la gestión de sesiones
 */
//$valorCodificado.="&id_sesion=".$configuracion["id_sesion"];


$valorCodificado=$this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

$this->cadena_sql=$this->sql->cadena_sql("rescatarTemp");

/**
 * La conexiòn que se debe utilizar es la principal de SARA
*/
$conexion="configuracion";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


$resultado=$esteRecursoDB->ejecutarAcceso($this->cadena_sql,"busqueda");

$totalRegistros=$esteRecursoDB->getConteo();

if($totalRegistros>0) {
	
	for($i=0;$i<$totalRegistros;$i++) {

		$variable[trim($resultado[$i]["campo"])]=$resultado[$i]["valor"];
	}

	//------------------Division General-------------------------
	$atributos["id"]="";

	//Formulario para nuevos registros de usuario
	$atributos["tipoFormulario"]="multipart/form-data";
	$atributos["metodo"]="POST";
	$atributos["estilo"]="formularioConJqgrid";
	$atributos["nombreFormulario"]=$miBloque["nombre"];
	echo $this->miFormulario->marcoFormulario("inicio",$atributos);


	//-------------Mostrar Datos a Confirmar-----------------------

	foreach($variable as $clave=>$valor){

		$esteCampo=$clave;

		//-------------Control cuadroTexto-----------------------

		$atributos["tamanno"]="";
		$atributos["estilo"]="jqueryui";
		$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
		$atributos["texto"]=$valor;
		echo $this->miFormulario->campoTexto($atributos);

	}

	//------------------Division para los botones-------------------------
	$atributos["id"]="botones";
	$atributos["estilo"]="marcoBotones";
	echo $this->miFormulario->division("inicio",$atributos);

	//-------------Control Boton-----------------------
	$esteCampo="botonAceptar";
	$atributos["id"]=$esteCampo;
	$atributos["verificar"]="";
	$atributos["verificarFormulario"]="1";
	$atributos["tipo"]="boton";
	$atributos["estilo"]="";
	$atributos["tabIndex"]=$tab++;
	$atributos["valor"]=$this->lenguaje->getCadena($esteCampo);
	echo $this->miFormulario->campoBoton($atributos);
	//-------------Fin Control Boton----------------------

	//-------------Control Boton-----------------------
	$esteCampo="botonCancelar";
	$atributos["id"]=$esteCampo;
	$atributos["verificar"]="";
	$atributos["tipo"]="boton";
	$atributos["tabIndex"]=$tab++;
	$atributos["valor"]=$this->lenguaje->getCadena($esteCampo);
	echo $this->miFormulario->campoBoton($atributos);
	//-------------Fin Control Boton----------------------

	//------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin",$atributos);

	//-------------Control cuadroTexto con campos ocultos-----------------------
	$atributos["id"]="formSaraData";
	$atributos["tipo"]="hidden";
	$atributos["etiqueta"]="";
	$atributos["valor"]=$valorCodificado;
	echo $this->miFormulario->campoCuadroTexto($atributos);


	//-------------------Fin Division-------------------------------
	echo $this->miFormulario->marcoFormulario("fin",$atributos);
}
//----------Grilla con lo elementos 
?>
<script type="text/javascript">
<?php echo "var datos=".$variable["grillaElementos"].";"?>
</script>
 <div id="jqgridConfirmarElementos" class="validationEngineContainer">
 <table id="gridConfirmarElementos"></table>
 </div>
 <div id="paginadorConfirmarElementos"></div><br/>