<?
include_once("core/manager/Configurador.class.php");

class FronteragenerarReporte{

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
		
		include_once("core/builder/FormularioHtml.class.php");
		
		$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");
		
		
		$this->miFormulario=new formularioHtml();
		
		if(isset($_REQUEST['opcion'])){

			$accion=$_REQUEST['opcion'];



			switch($accion){
				case "imprimir":
					include_once($this->ruta."/formulario/imprimir.php");
					break;
				case "verificar":
					include_once($this->ruta."/formulario/verificar.php");
					break;
				case "confirmar":
					include_once($this->ruta."/formulario/confirmar.php");
					break;
				case "nuevo":
					include_once($this->ruta."formulario/nuevo.php");
					break;
				case "editar":
					include_once($this->ruta."/formulario/editar.php");
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