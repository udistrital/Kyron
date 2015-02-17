<?
include_once("core/manager/Configurador.class.php");

class FronteraEstadoCuenta{

	var $ruta;
	var $sql;
	var $funcion;
	var $lenguaje;
	var $formulario;
	
	var $miConfigurador;
	
	function __construct()
	{
	
		$this->miConfigurador=Configurador::singleton();
	}

	public function setRuta($unaRuta){
		$this->ruta=$unaRuta;
	}

	public function setLenguaje($lenguaje){
		$this->lenguaje=$lenguaje;
	}

	public function setFormulario($formulario){
		$this->formulario=$formulario;
	}

	function frontera()
	{
		$this->html();
	}

	function setSql($a)
	{
		$this->sql=$a;

	}

	function setFuncion($funcion)
	{
		$this->funcion=$funcion;

	}

	function html()
	{
            if(isset($_REQUEST['usuario']) && $_REQUEST['usuario']!='')
            {
                $usuario = $_REQUEST['usuario'];
                
            }else
                {
                    $rutaDecod = $this->miConfigurador->fabricaConexiones->crypto->decodificar($_REQUEST['data']);

                    $datos = explode('&', $rutaDecod);

                    $usu = explode('=',$datos[3]);
                    $usuario = $usu[1];

                    
                }
                    $conexion="condor";                
                    $esteRecursoDBCondor=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

                    if(!$esteRecursoDBCondor){

                        //Este se considera un error fatal
                        exit;

                    }
                
                $cadena_sql=$this->sql->cadena_sql("validarSesion",$usuario);
                $registro=$esteRecursoDBCondor->ejecutarAcceso($cadena_sql,"busqueda");
                
                if(!is_array($registro))
                {
                    $indice=$this->miConfigurador->getVariableConfiguracion("host").$this->miConfigurador->getVariableConfiguracion("siteCondor");
                    echo "<script>alert('No existe una sesion creada, por favor ingrese con usuario y clave')</script>";
                    echo "<script>location.replace('".$indice."')</script>";
                    exit;
                }
            
		
		include_once("core/builder/FormularioHtml.class.php");
		
		$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");
		
		
		$this->miFormulario=new formularioHtml();
		
		if(isset($_REQUEST['opcion'])){

			$accion=$_REQUEST['opcion'];



			switch($accion){
                                case "formReporte":
					include_once($this->ruta."/formulario/formReporte.php");
					break;
				case "formReporteRealizado":
					include_once($this->ruta."/formulario/formReporteRealizado.php");
					break;
				case "confirmar":
					include_once($this->ruta."/formulario/confirmar.php");
					break;
				case "nuevo":
					include_once($this->ruta."formulario/nuevo.php");
					break;
				case "generarReporte":
					include_once($this->ruta."/funcion/generarReporte.php");
					break;
				case "corregir":
					include_once($this->ruta."/formulario/corregir.php");
					break;
				case "mostrar":
					include_once($this->ruta."/formulario/mostrar.php");
					break;

				case "confirmarEditar":
					include_once($this->ruta."/formulario/confirmarEditar.php");
					break;
			}
		}else{
			$accion="nuevo";
			include_once($this->ruta."/formulario/nuevo.php");
		}


	}





}
?>