<?
 function usuarioAntiguo($configuracion,$acceso_db)
{
        $valor=$_REQUEST['solicitud'];
        $cadena_sql=sqlRegistroUsuario($configuracion, "inscripcionGrado",$valor);
        $acceso_db->registro_db($cadena_sql,0);
        $registro=$acceso_db->obtener_registro_db();
        $campos=$acceso_db->obtener_conteo_db();
        if($campos>0)
        {
                unset($valor);
                if($resultado==TRUE){
                        if(!isset($_REQUEST["admin"])){
                                //$this->enviar_correo($configuracion);
                                reset($_REQUEST);
                                while(list($clave,$valor)=each($_REQUEST)){
                                        unset($_REQUEST[$clave]);

                                }
                                redireccionarInscripcion($configuracion, "indice");
                        }else{
                                redireccionarInscripcion($configuracion,"administracion");
                        }
                }else{

                }


        }else{
                echo "<h1>Error de Acceso</h1>Por favor contacte con el administrador del sistema.";
        }
}

?>