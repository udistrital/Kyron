<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
	
            /*var_dump($_REQUEST);
            exit;*/
			//1. Borrar todos los registros que pertenezcan a la misma sesion
            $variable["fecha"]=time();
            if(!isset($configuracion["id_sesion"])||$configuracion["id_sesion"]==0){
                $configuracion["id_sesion"]=$variable["fecha"];
            }

            $cadena_sql=$this->sql->cadena_sql("eliminarTemp",$configuracion["id_sesion"]);
            
            /**
             * La conexiòn que se debe utilizar es la principal de SARA
             */
            $conexion="estructura";
            $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
            $resultado=$esteRecursoDB->ejecutarAcceso($cadena_sql,"acceso");

            //2. Insertar Borrador
            $elBloque=$this->miConfigurador->getVariableConfiguracion("esteBloque");
            
            $variable["formulario"]=$elBloque["nombre"];

            $cadena_sql=$this->sql->cadena_sql("insertarTemp",$variable);
            $resultado=$esteRecursoDB->ejecutarAcceso($cadena_sql,"acceso");
            if($resultado==true){

                    $this->funcion->redireccionar("confirmarDocente","" );
            }else{
                    echo "OOOPS!!!!. DB Engine Access Error";
                    exit;
            }

    }
?>