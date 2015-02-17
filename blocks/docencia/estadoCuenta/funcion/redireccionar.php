<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	$miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");
	switch($opcion)
	{

		case "confirmarNuevo":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=confirmar";
			if($valor!=""){
				$variable.="&id_sesion=".$valor;
			}
			break;

		case "confirmacionEditar":
			$variable="pagina=conductorAdministrador";
			$variable.="&opcion=confirmarEditar";
			if($valor!=""){
				$variable.="&registro=".$valor;
			}
			break;

                case "exitoReporte":
			$variable="pagina=estadoCuenta";
			$variable.="&opcion=formReporteRealizado";                        
			//$variable.="&bloque=estadoCuenta";
                        //$variable.="&action=estadoCuenta";
			$variable.="&mensaje=exitoRegistro";
                        $variable.="&identificacion=".$_REQUEST['identificacion'];
                        $variable.="&usuario=".$_REQUEST['usuario'];

			break;        

		case "exitoRegistro":
			$variable="pagina=inscripcionConferencia";
			$variable.="&opcion=mostrar";
			$variable.="&mensaje=exitoRegistro";
			$variable.="&registro=".$configuracion["idRegistrado"];

			break;

		case "falloRegistro":
			$variable="pagina=adminParticipante";
			$variable.="&opcion=mostrar";
			$variable.="&mensaje=falloRegistro";
			break;

		case "exitoEdicion":
			$variable="pagina=adminParticipante";
			$variable.="&opcion=mostrar";
			$variable.="&mensaje=exitoEdicion";
			break;

		case "falloEdicion":
			$variable="pagina=adminParticipante";
			$variable.="&opcion=mostrar";
			$variable.="&mensaje=falloRegistro";
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