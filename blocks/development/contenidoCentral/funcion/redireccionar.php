<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	$miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");
	switch($opcion)
	{

		
		case "indexUsuario":
			$variable="pagina=indexUsuario";
			$variable.="&opcion=mostrar";
			$variable.="&redireccionar=true";
			$variable.="&mensaje=bienvenida";
			$variable.="&usuario=".$valor["id_usuario"];
			$variable.="&tiempo=".time();
			$variable.="&sesionID=".$valor["sesionID"];
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