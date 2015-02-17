<?php

/**
 * * Importante: Si se desean los datos del bloque estos se encuentran en el arreglo $esteBloque
 */
$directorioImagenes = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/images";

$conexion = "docencia";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


if (!$esteRecursoDB) {
	//Este se considera un error fatal
	exit;
}
switch($_REQUEST["funcion"]){

	case "#docente":
		
            $cadena_sql = $this->sql->cadena_sql("buscarNombreDocente", $_REQUEST["name_startsWith"]);
            $registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
            
            if($registro)
                {
                    //Para autocomplete
                    $respuesta = '[';

                    foreach ($registro as $fila) {
                            $respuesta.='{';
                            $respuesta.='"label":"' . $fila[0] . ' - ' . $fila[1] . '",';
                            $respuesta.='"value":"' . $fila[0] . '"';
                            $respuesta.='},';
                    }

                    $respuesta = substr($respuesta, 0, strlen($respuesta) - 1);
                    $respuesta.=']';
                }else
                    {
                        $respuesta='[{"label":"No encontrado","value":"-1"}]';
                    }
		
        break;
        
        case "#docenteConsulta":
		
            $cadena_sql = $this->sql->cadena_sql("buscarNombreDocente", $_REQUEST["name_startsWith"]);
            $registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
            
            if($registro)
                {
                    //Para autocomplete
                    $respuesta = '[';

                    foreach ($registro as $fila) {
                            $respuesta.='{';
                            $respuesta.='"label":"' . $fila[0] . ' - ' . $fila[1] . '",';
                            $respuesta.='"value":"' . $fila[0] . '"';
                            $respuesta.='},';
                    }

                    $respuesta = substr($respuesta, 0, strlen($respuesta) - 1);
                    $respuesta.=']';
                }else
                    {
                        $respuesta='[{"label":"No encontrado","value":"-1"}]';
                    }
		
        break;
        
}

echo $respuesta;
?>