<?php
include_once ("core/manager/Configurador.class.php");

// echo"llegamosfrontera";
// var_dump($_REQUEST);exit;
class FronteraestadoDocente {
	var $ruta;
	var $sql;
	var $funcion;
	var $lenguaje;
	var $formulario;
	var $miConfigurador;
	function __construct() {
		$this->miConfigurador = Configurador::singleton ();
	}
	public function setRuta($unaRuta) {
		$this->ruta = $unaRuta;
	}
	public function setLenguaje($lenguaje) {
		$this->lenguaje = $lenguaje;
	}
	public function setFormulario($formulario) {
		$this->formulario = $formulario;
	}
	function procesarNuevo() {
		include_once ($this->ruta . "formulario/procesarNuevo.php");
		break;
	}
	function frontera() {
		$this->html ();
	}
	function setSql($a) {
		$this->sql = $a;
	}
	function setFuncion($funcion) {
		$this->funcion = $funcion;
	}
	function html() {
		include_once ("core/builder/FormularioHtml.class.php");
		
		$this->ruta = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
		
		$this->miFormulario = new formularioHtml ();
		
		if (isset ( $_REQUEST ['solicitud'] )) {
			
			$accion = $_REQUEST ['solicitud'];
			
			switch ($accion) {
				
				case "nuevo" :
					include_once ($this->ruta . "/formulario/nuevo.php");
					break;
				
				case "mensaje" :
					include_once ($this->ruta . "/formulario/mensaje.php");
					break;
				
				case "consultar" :
					include_once ($this->ruta . "/formulario/consultar.php");
					break;
				
				case "mostrarInfo" :
					include_once ($this->ruta . "/formulario/mostrarInfoDocente.php");
					break;
				
				case "ModificarEstado" :
					
					include_once ($this->ruta . "/formulario/ModificarEstado.php");
					break;
				
				case "historicoEstadoDocente" :
					
					include_once ($this->ruta . "/formulario/historicoDocente.php");
					break;
				
				case "historicoDocenteGeneral" :
					
					include_once ($this->ruta . "/formulario/mostrarHistoricoGeneral.php");
					break;
				
				case "CambiarEstado" :
					
					include_once ($this->ruta . "/formulario/editarEstado.php");
					break;
				
				case "verificar" :
					include_once ($this->ruta . "/formulario/verificar.php");
					break;
				case "confirmar" :
					include_once ($this->ruta . "/formulario/confirmar.php");
					break;
				case "nuevo" :
					include_once ($this->ruta . "/formulario/nuevo.php");
					break;
				case "editar" :
					include_once ($this->ruta . "/formulario/editar.php");
					break;
				case "corregir" :
					include_once ($this->ruta . "/formulario/corregir.php");
					break;
				case "mostrar" :
					include_once ($this->ruta . "/formulario/mostrar.php");
					break;
				case "confirmarEditar" :
					include_once ($this->ruta . "/formulario/confirmarEditar.php");
					break;
				
				case "mostrarMensajeCorreccion" :
					include_once ($this->ruta . "formulario/mostrarMensajeCorrecion.php");
					break;
				case "mostrarMensaje" :
					include_once ($this->ruta . "formulario/mostrarMensaje.php");
					break;
			}
		} else {
			
			$accion = "nuevo";
			include_once ($this->ruta . "/formulario/nuevo.php");
		}
	}
}
?>