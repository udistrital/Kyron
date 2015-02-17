<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

        $_REQUEST["id_sesion"]=$this->rescatarNumeroSesion($configuracion);

        
        //1. Borrar todos los registros que pertenezcan a la misma sesion
        $cadena_sql=$this->sql->cadena_sql($configuracion, "eliminarTemp");
        $resultado=$this->ejecutarSQL($configuracion, $cadena_sql,"acceso",$configuracion["db_principal"]);

        
        //2. Insertar Borrador
        $variable["fecha"]=time();
        $variable["formulario"]=$this->formulario;
        $cadena_sql=$this->sql->cadena_sql($configuracion, "insertarTemp",$variable);
        $resultado=$this->ejecutarSQL($configuracion, $cadena_sql,"acceso",$configuracion["db_principal"]);
        if($resultado==true){

                if(isset($configuracion["sesionAcceso"])){

                        switch($configuracion["sesionAcceso"]){

                            case 1:
                                $this->funcion->redireccionar($configuracion, "confirmacionAdminEditar",$_REQUEST["registro"]);
                                break;
                        }

                    }else{
                        echo "Opss!!1 Imposible editar el registro.";
                    }
        }else{
                echo "OOOPS!!!!. DB Engine Access Error";
                exit;
        }

    }
?>