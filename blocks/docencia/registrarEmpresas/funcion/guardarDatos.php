<?php
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	$miSesion = Sesion::singleton();

	$conexion="estructura";
	$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

	$arregloDatos = array($_REQUEST['docente'],
			$_REQUEST['enterpriseName'],
			$_REQUEST['economicsField'],
			$_REQUEST['commerceChamber'],
			$_REQUEST['registerNIT'],
			$_REQUEST['institutionalCode'],
			$_REQUEST['technologyField'],
			$_REQUEST['numeActa'],
			$_REQUEST['fechaActa'],
			$_REQUEST['numeCaso'],
			$_REQUEST['puntaje']);

	$estaLinea = $this->cadena_sql = $this->sql->cadena_sql("insertarEmpresa", $arregloDatos);
	$resultadoEmpresa = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");

	$arregloLogEvento = array (
			'registrar_empresa',
			$arregloDatos,
			$miSesion->getSesionUsuarioId (),
			$_SERVER ['REMOTE_ADDR'],
			$_SERVER ['HTTP_USER_AGENT']
	);

	$argumento = json_encode ( $arregloLogEvento );
	$arregloFinalLogEvento = array (
			$miSesion->getSesionUsuarioId (),
			$argumento
	);

	$cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
	$registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );


	if($resultadoEmpresa)
	{
		$this->funcion->redireccionar('inserto',$_REQUEST['docente']);
	}else
	{
		$this->funcion->redireccionar('noInserto',$_REQUEST['docente']);
	}



}
?>