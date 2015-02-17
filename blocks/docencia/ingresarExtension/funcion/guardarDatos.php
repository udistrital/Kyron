<?php
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
    
    
    
        $rutaBloque=$this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
	         
	if ($_FILES ) {
		// obtenemos los datos del archivo
		$tamano = $_FILES["soporte"]['size'];
		$tipo = $_FILES["soporte"]['type'];
		$archivo1 = $_FILES["soporte"]['name'];
		$prefijo = substr(md5(uniqid(rand())),0,6);
		 
		if ($archivo1 != "") {
			// guardamos el archivo a la carpeta files
			$destino1 =  $rutaBloque."/archivos/".$prefijo."_".$archivo1;
			if (copy($_FILES['soporte']['tmp_name'],$destino1)) {
				$status = "Archivo subido: <b>".$archivo1."</b>";
				$destino1 =  $rutaBloque."/archivos/".$prefijo."_".$archivo1;

// 				echo $status;exit;
			} else {
				$status = "Error al subir el archivo";
			}
		} else {
			$status = "Error al subir archivo";
		}
	}
	 
	$miSesion = Sesion::singleton();

        $conexion="docencia";
	$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
                
	$arregloDatos = array($_REQUEST['docente'],
                              $_REQUEST['nombreCurso'],
                              $_REQUEST['monto'],
                              $_REQUEST['recibio'],
                              $_REQUEST['fechaInicio'],
                              $_REQUEST['fechaFinalizacion'],
                              $_REQUEST['duracion'],
                              $destino1,
                              $archivo1);
	
	$this->cadena_sql = $this->sql->cadena_sql("insertarExtension", $arregloDatos);
	$resultadoTitulo = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");

        $arregloLogEvento = array (
                        'ingresar_extension',
                        $arregloDatos,
                        $miSesion->getSesionUsuarioId(),
                        $_SERVER ['REMOTE_ADDR'],
                        $_SERVER ['HTTP_USER_AGENT'] 
        );

        $argumento = json_encode ( $arregloLogEvento );
        $arregloFinalLogEvento = array($miSesion->getSesionUsuarioId(), $argumento);
        
        $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
        $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
	
	
	if($resultadoTitulo)
	{	
		$this->funcion->redireccionar('inserto',$_REQUEST['docente']);
	}else
	{
		$this->funcion->redireccionar('noInserto',$_REQUEST['docente']);
	}



}
?>