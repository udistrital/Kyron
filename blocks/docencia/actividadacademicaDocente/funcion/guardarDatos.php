<?php


// var_dump($_REQUEST);
// var_dump($_POST);
// var_dump($_FILES);
// exit();




if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
	
	$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" )."/blocks/docencia/";
	$rutaBloque .= $esteBloque ['nombre'];
	
	
	
	$host=$this->miConfigurador->getVariableConfiguracion ( "host" )."/kyron/blocks/docencia/".$esteBloque['nombre'];
// 	echo $host;exit;
	

	
	
	if ($_FILES ) {
		// obtenemos los datos del archivo
		$tamano = $_FILES["horario"]['size'];
		$tipo = $_FILES["horario"]['type'];
		$archivo1 = $_FILES["horario"]['name'];
		$prefijo = substr(md5(uniqid(rand())),0,6);
		 
		if ($archivo1 != "") {
			// guardamos el archivo a la carpeta files
			$destino1 =  $rutaBloque."/archivoHorario/".$prefijo."_".$archivo1;
			if (copy($_FILES['horario']['tmp_name'],$destino1)) {
				$status = "Archivo subido: <b>".$archivo1."</b>";
				$destino1 =  $host."/archivoHorario/".$prefijo."_".$archivo1;

// 				echo $status;
			} else {
				$status = "Error al subir el archivo";
			}
		} else {
			$status = "Error al subir archivo";
		}
	}
	
	


	// obtenemos los datos del archivo
	$tamano = $_FILES["syllabus"]['size'];
	$tipo = $_FILES["syllabus"]['type'];
	$archivo2 = $_FILES["syllabus"]['name'];
	$prefijo = substr(md5(uniqid(rand())),0,6);
		
	if ($archivo2 != "") {
		// guardamos el archivo a la carpeta files
		$destino2 =  $rutaBloque."/archivoSyllabus/".$prefijo."_".$archivo2;
		if (copy($_FILES['syllabus']['tmp_name'],$destino2)) {
			$status = "Archivo subido: <b>".$archivo2."</b>";
			$destino2 =  $host."/archivoSyllabus/".$prefijo."_".$archivo2;
	
// 							echo $status;exit;
		} else {
			$status = "Error al subir el archivo";
		}
	} else {
		$status = "Error al subir archivo";
	}
	
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "docencia";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	$arregloDatos = array (
			$_REQUEST ['identificacionFinal'],
			$_REQUEST ['asignatura'],
			$_REQUEST ['inthora'],
			$_REQUEST ['numestud'],
			$destino1,
			$archivo1,
			$destino2,
			$archivo2 
	);
	 
	$this->cadena_sql = $this->sql->cadena_sql ( "insertarActividadAC", $arregloDatos );
	$sql=$this->sql->cadena_sql ( "insertarActividadAC", $arregloDatos );
		
	$resultadoExperiencia = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
	if ($resultadoExperiencia) {
		$this->funcion->redireccionar ( 'inserto', $_REQUEST ['docente'] );
	} else {
		$this->funcion->redireccionar ( 'noInserto', $_REQUEST ['docente'] );
	}
}
?>