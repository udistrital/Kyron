<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	$miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");
	switch($opcion)
	{
			
		case "indexAdministrador":
			$variable="pagina=indexAdministrador";
			$variable.="&redireccionar=true";
			$variable.="&mensaje=bienvenida";
			$variable.="&usuario=".$valor["id_usuario"];
			$variable.="&tiempo=".time();
			break;	
			
		case "indexSecretaria":
			$variable="pagina=indexSecretaria";
			$variable.="&redireccionar=true";
			$variable.="&mensaje=bienvenida";
			$variable.="&usuario=".$valor["id_usuario"];
			$variable.="&tiempo=".time();
			break;	
                    
		case "indexJefe":
			$variable="pagina=indexJefe";
			$variable.="&redireccionar=true";
			$variable.="&mensaje=bienvenida";
			$variable.="&usuario=".$valor["id_usuario"];
			$variable.="&tiempo=".time();
			break;			

		case "paginaPrincipal":
			$variable="pagina=index";
			if(isset($valor) && $valor!='')
			{
				$variable.="&error=".$valor;
			}
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