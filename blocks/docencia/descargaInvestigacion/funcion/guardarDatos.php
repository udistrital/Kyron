<?php
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
	 
	$miSesion = Sesion::singleton();

        $conexion="estructura";
	$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        
	$arregloDatos = array($_REQUEST['numeActa'],
                              $_REQUEST['horasDescarga'],
                              $_REQUEST['codigoDescarga'],
                              $_REQUEST['docente'],
                              $_REQUEST['dependenciaDescarga']);
	
	$solution = $this->cadena_sql = $this->sql->cadena_sql("insertarDescarga", $arregloDatos);
	$resultadoDescarga = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
	
	$arregloLogEvento = array (
			'descarga_investigacion',
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
	
	
	if($resultadoDescarga)
	{	
		$this->funcion->redireccionar('inserto',$_REQUEST['docente']);
	}else
	{
		$this->funcion->redireccionar('noInserto',$_REQUEST['docente']);
	}



}
?>