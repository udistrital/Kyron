<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
        
	$miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");

        switch($opcion)
	{

		case "mostrarMensaje":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mostrarMensaje";
			$variable.="&mensaje=".$datos["mensaje"];
			$variable.="&error=".$datos["error"];
			break;

		case "paginaPrincipal":
			$variable="pagina=index";
			break;


	}

	foreach($_REQUEST as $clave=>$valor)
	{
		unset($_REQUEST[$clave]);

	}

	$enlace=$this->miConfigurador->getVariableConfiguracion("enlace");
	$variable=$this->miConfigurador->fabricaConexiones->crypto->codificar($variable);

	$_REQUEST[$enlace]=$variable;
	$_REQUEST["recargar"]=true;

}

?>