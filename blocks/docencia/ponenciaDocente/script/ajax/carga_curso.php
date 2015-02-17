<?php

    include_once("core/manager/Configurador.class.php");
    $this->miConfigurador=Configurador::singleton();
    
   //echo "Hola";
    /*print_r($this->miConfigurador);
    exit;
    $url=$this->miConfigurador->getVariableConfiguracion("host");
    $url.=$this->miConfigurador->getVariableConfiguracion("site");
    $url.="/index.php?";

    $ruta=$this->miConfigurador->getVariableConfiguracion("raizDocumento");
    $ruta.="/blocks/".$esteBloque["grupo"]."/".$esteBloque["nombre"]."/";

    include_once($ruta."/locale/es_es/Mensaje.php");


    $conexion = "docente";
    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    if (!$esteRecursoDB) {
            //Este se considera un error fatal
            exit;
    }
    
    //aca realiza la conexion
    $proyecto = $_REQUEST["proyecto"];
    //realizamos la consulta
        
    $cadena_sql = $this->sql->cadena_sql("buscarNombreDocente", $proyecto);
    $registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
    
    if(!is_array($registro))
        {
            echo "<option value='' selected>--Sin registros--</option>";
        }else
        {
        	for($j=0;$j<count($registro);$j++)
	        {
                    echo "<option value='".$registro[$j][0]."'>".utf8_decode($registro[$j][1])."</option>";            
	        }
        }
    
    
*/   
?>