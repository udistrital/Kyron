<?php
// var_dump($_REQUEST);
// exit ();
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
        
        
        $conexionEstructura = "estructura";
	$esteRecursoDBEstructura = $this->miConfigurador->fabricaConexiones->getRecursoDB ($conexionEstructura );
	
	if($_REQUEST["codigoNumeracion"]==1){
	
	$arregloDatos = array (
			$_REQUEST ['docente'],
			$_REQUEST ['tituloPublicacion'],
			$_REQUEST ['fechaPublicacion'],
			$_REQUEST ['codigoNumeracion'],
			$_REQUEST ['revistaPublicacion'],
			$_REQUEST ['num_revista'],
			$_REQUEST ['volumen'],
			$_REQUEST ['anioR'],
			$_REQUEST ['categoria_revista'],
			$_REQUEST ['nom_libro']='NULL',
			$_REQUEST ['editorial']='NULL',
			$_REQUEST ['anioL']='NULL',
			$_REQUEST ['numeActa'],
			$_REQUEST ['fechaActa'],
			$_REQUEST ['numeCaso'],
			$_REQUEST ['puntaje'] 
	);
	
	}else if($_REQUEST["codigoNumeracion"]==2){		
		$arregloDatos = array (
				$_REQUEST ['docente'],
				$_REQUEST ['tituloPublicacion'],
				$_REQUEST ['fechaPublicacion'],
				$_REQUEST ['codigoNumeracion'],
				$_REQUEST ['revistaPublicacion']='NULL',
				$_REQUEST ['num_revista']='NULL',
				$_REQUEST ['volumen']='NULL',
				$_REQUEST ['anioR']='NULL',
				$_REQUEST ['categoria_revista']='NULL',
				$_REQUEST ['nom_libro'],
				$_REQUEST ['editorial'],
				$_REQUEST ['anioL'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['puntaje']
		);
	}
	

	$this->cadena_sql = $this->sql->cadena_sql ( "insertarPublicacion", $arregloDatos );

	$resultadoExperiencia = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );

        $arregloLogEvento = array (
                        'publ_impr_univ_docente',
                        $arregloDatos,
                        $miSesion->getSesionUsuarioId(),
                        $_SERVER ['REMOTE_ADDR'],
                        $_SERVER ['HTTP_USER_AGENT'] 
        );

        $argumento = json_encode ( $arregloLogEvento );
        $arregloFinalLogEvento = array($miSesion->getSesionUsuarioId(), $argumento);
        
        $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
        $registroAcceso = $esteRecursoDBEstructura->ejecutarAcceso ( $cadena_sql, "acceso" );
        
	if ($resultadoExperiencia) {
		$this->funcion->redireccionar ( 'inserto', $_REQUEST['docente'] );
	} else {
		$this->funcion->redireccionar ( 'noInserto',$_REQUEST['docente'] );
	}
}
?>