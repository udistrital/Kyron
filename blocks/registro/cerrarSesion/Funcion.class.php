<?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/auth/Sesion.class.php");
include_once("core/builder/InspectorHTML.class.php");
include_once("core/builder/Mensaje.class.php");
include_once("core/crypto/Encriptador.class.php");

//Esta clase contiene la logica de negocio del bloque y extiende a la clase funcion general la cual encapsula los
//metodos mas utilizados en la aplicacion

//Para evitar redefiniciones de clases el nombre de la clase del archivo funcion debe corresponder al nombre del bloque
//en camel case precedido por la palabra Funcion

class FuncionCerrarSesion
{

	var $sql;
	var $funcion;
	var $lenguaje;
	var $ruta;
	var $miConfigurador;
	var $miInspectorHTML;
	var $error;
	var $miRecursoDB;
	var $crypto;



	function verificarCampos(){
		include_once($this->ruta."/funcion/verificarCampos.php");
		return $resultado;
	}


	function verificarRegistro()
	{
		include_once($this->ruta."/funcion/verificarRegistro.php");
	}


	function procesarLogin(){
		include_once($this->ruta."/funcion/procesarLogin.php");
	}
	
	function redireccionar($opcion, $valor=""){
		include_once($this->ruta."/funcion/redireccionar.php");
	}

	function action()
	{
		var_dump($_REQUEST);
		//Evitar que se ingrese codigo HTML y PHP en los campos de texto
		//Campos que se quieren excluir de la limpieza de código. Formato: nombreCampo1|nombreCampo2|nombreCampo3
		$excluir="";
		$_REQUEST=$this->miInspectorHTML->limpiarPHPHTML($_REQUEST);

		//Realizar una validación específica para los campos de este formulario:
		$validacion=$this->verificarCampos();
			
		if($validacion==false){
			//Instanciar a la clase pagina con mensaje de correcion de datos
			$this->miMensaje->mostrarMensaje("errorDatos");

		}else{
			//Validar las variables para evitar un tipo  insercion de SQL
			$_REQUEST=$this->miInspectorHTML->limpiarSQL($_REQUEST);

			$this->procesarLogin();
				
		}
	}


	function __construct()
	{

		$this->miConfigurador=Configurador::singleton();

		$this->miInspectorHTML=InspectorHTML::singleton();
			
		$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");

		$this->miMensaje=Mensaje::singleton();
		
		$this->miSesion=Sesion::singleton();
	}

	public function setRuta($unaRuta){
		$this->ruta=$unaRuta;
		//Incluir las funciones
	}

	function setSql($a)
	{
		$this->sql=$a;
	}

	function setFuncion($funcion)
	{
		$this->funcion=$funcion;
	}

	public function setLenguaje($lenguaje)
	{
		$this->lenguaje=$lenguaje;
	}

	public function setFormulario($formulario){
		$this->formulario=$formulario;
	}

}
?>
