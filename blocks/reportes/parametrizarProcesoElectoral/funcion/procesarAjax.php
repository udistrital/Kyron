<?php

/**
 * * Importante: Si se desean los datos del bloque estos se encuentran en el arreglo $esteBloque
 */
$directorioImagenes = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/images";

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


if (!$esteRecursoDB) {
	//Este se considera un error fatal
	exit;
}
switch($_REQUEST["funcion"]){

	case "#guardarEleccion":
		
            echo "<pre>";
            print_r($_REQUEST);
            echo "</pre>";
            exit;
            
		$idUsuario = $_REQUEST['idUsuario'];
		$texto = $_REQUEST['texto'];
		
		$arreglo = array($idUsuario, $texto);
		$cadena_sql = $this->sql->cadena_sql("insertarNota", $arreglo);
		$registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");
		
		$cadena_sql = $this->sql->cadena_sql("consultarNotas", $idUsuario);
		$registroNotas = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
				
		
		$respuesta = "<table width='100%' class='jqueryui' border='1'>";	
		$respuesta .= "<tr>";
		$respuesta .= "<th>ID</th>";
		$respuesta .= "<th>Fecha</th>";
		$respuesta .= "<th>Nota</th>";
		$respuesta .= "</tr>";	
		
		for($i=0;$i<count($registroNotas);$i++)
		{
			$respuesta .= "<tr>";
			$respuesta .= "<td align='center'>".$registroNotas[$i][0]."</td>";
			$respuesta .= "<td align='center'>".$registroNotas[$i][1]."</td>";
			$respuesta .= "<td align='center'>".$registroNotas[$i][2]."</td>";
			$respuesta .= "</tr>";	
		}
		break;
            
       
        
        
}

echo $respuesta;
?>