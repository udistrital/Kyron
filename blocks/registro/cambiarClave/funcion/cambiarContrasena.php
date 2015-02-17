<?php
if ($_REQUEST ["contrasena"] == $_REQUEST ["contrasenaConfirm"]) {
	
	$_REQUEST ["contrasena"]= $this->miConfigurador->fabricaConexiones->crypto->codificarClave($_REQUEST ['contrasena'] );
	$_REQUEST ["contrasenaActual"]= $this->miConfigurador->fabricaConexiones->crypto->codificarClave($_REQUEST ['contrasenaActual'] );
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	$cadena_sql = $this->sql->cadena_sql ( "buscarUsuario", $usuario );	
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, 'busqueda' );
	
        if($resultado)
            {
                if ($resultado && $_REQUEST ['contrasenaActual']==$resultado[0]['clave']){
			
		$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "modificaClaveMySQL", $usuario );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
		
                    if ($resultado == true) {
                            $mensaje = " <p><b>...Su contraseña ha sido modificada exitosamente...</b></p>";
                            $error = "exito";
                    } else {
                            $mensaje = "...Oops, se ha presentado un error, por favor intente nuevamente o contacte al administrador del sistema... ";
                            $error = "error";
                    }
                } else {
                    $cadena_sql = trim ( $this->cadena_sql = $this->sql->cadena_sql ( "cancelarTransaccion", "" ) );
                    $resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "" );
                    $mensaje = "La contraseña actual no es correcta, por favor intente nuevamente ";
                    $error = "error";
                    }
            }else
                {
                    $cadena_sql = $this->sql->cadena_sql ( "buscarUsuarioCenso", $usuario );
                    $resultadoCenso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, 'busqueda' );
                    
                    if ($resultadoCenso && $_REQUEST ['contrasenaActual']==$resultadoCenso[0]['clave']){
			
                    $cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "modificaClaveMySQLCenso", $usuario );
                    $resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );

                        if ($resultado == true) {
                                $mensaje = " <p><b>...Su contraseña ha sido modificada exitosamente...</b></p>";
                                $error = "exito";
                        } else {
                                $mensaje = "...Oops, se ha presentado un error, por favor intente nuevamente o contacte al administrador del sistema... ";
                                $error = "error";
                        }
                    } else {
                        $cadena_sql = trim ( $this->cadena_sql = $this->sql->cadena_sql ( "cancelarTransaccion", "" ) );
                        $resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "" );
                        $mensaje = "La contraseña actual no es correcta, por favor intente nuevamente ";
                        $error = "error";
                        }
                }
	
} else {
	$mensaje = "...Las contraseñas deben ser iguales... ";
	$error = "error";
}

$datos = array (
		"mensaje" => $mensaje,
		"error" => $error 
);

$this->redireccionar ( "mostrarMensaje", $datos );
?>
