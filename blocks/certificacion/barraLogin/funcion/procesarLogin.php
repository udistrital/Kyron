<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
		
	//1. Verificar que el usuario esté registrado en el sistema
	$token=strrev(($this->miConfigurador->getVariableConfiguracion("enlace")));
	
	if(isset($_REQUEST[$token."usuario"]) && isset($_REQUEST[$token."clave"])){
		
		$variable["usuario"]=$_REQUEST[$token."usuario"];
                $variable["clave"]=md5($_REQUEST[$token."clave"]);
                
		
		/**
		 * La conexión que se debe utilizar es la principal del aplicativo (usualmente una registrada en dbms)
		 */
		/*$conexion="aplicativo";
		$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);*/                
                
                $conexion="oracle";
                $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
                                
                
                if(!$esteRecursoDB){
                
                    //Este se considera un error fatal
                    exit;
                    
                }               
                
                $cadena_sql=$this->sql->cadena_sql("buscarUsuario",$variable);
                
                $registro=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
		
                if($registro){
                    
			//Tener en cuenta que la clausla SQL deberá generar un campo llamado CLAVE y uno llamado USUARIOID
			
			if($this->miConfigurador->fabricaConexiones->crypto->decodificar($registro[0]["CLAVE"])==$clave){
				
				//1. Crear una sesión de trabajo
				
				$this->miSesion->crearSesion($registro[0]["USUARIOID"]);
				
				
				
				//Redirigir a la página principal del usuario 				
				$this->funcion->redireccionar("indexUsuario",$registro[0]);
				return true;				
			}			
		}	
		
		// Redirigir a la página de inicio con mensaje de error en usuario/clave				
		$this->funcion->redireccionar("paginaPrincipal",$usuario);
		
	}
}

 

?>