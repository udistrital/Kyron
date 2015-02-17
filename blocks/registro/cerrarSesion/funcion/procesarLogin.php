<?php

//$this->miConfigurador->fabricaConexiones->crypto->codificar(

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
} else {
    //1. Verificar que el usuario esté registrado en el sistema
    $variable["usuario"] = $_REQUEST["usuario"];

    /**
     * @todo En entornos de producción la clave debe codificarse utilizando un objeto de la clase Codificador
     */
    $variable["clave"] = $_REQUEST["clave"];


    /* $conexion="aplicativo";
      $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion); */

    $conexion = "estructura";
    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


    if (!$esteRecursoDB) {

        //Este se considera un error fatal
        exit;
    }

    $cadena_sql = $this->sql->cadena_sql("buscarUsuario", $variable);
    $registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
           

    if ($registro) {

        $clave = $this->miConfigurador->fabricaConexiones->crypto->decodificar($registro[0]['clave']);
                
		if ($clave == $variable["clave"]) {
			
            //1. Crear una sesión de trabajo
            $estaSesion = $this->miSesion->crearSesion($registro[0]["id_usuario"]);
            
            if ($estaSesion) {
                
                $registro[0]["sesionID"] = $estaSesion;
                //Redirigir a la página principal del usuario, en el arreglo $registro se encuentran los datos de la sesion:
                $this->funcion->redireccionar("indexUsuario", $registro[0]);
                return true;
            }
        } else {
            // Redirigir a la página de inicio con mensaje de error en usuario/clave
            $this->funcion->redireccionar("paginaPrincipal");
        }
    }
}
?>