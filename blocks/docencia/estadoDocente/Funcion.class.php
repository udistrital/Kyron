<?php

// var_dump($_REQUEST);exit;
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/builder/InspectorHTML.class.php");
include_once ("core/builder/Mensaje.class.php");
include_once ("core/crypto/Encriptador.class.php");

// Esta clase contiene la logica de negocio del bloque y extiende a la clase funcion general la cual encapsula los
// metodos mas utilizados en la aplicacion

// Para evitar redefiniciones de clases el nombre de la clase del archivo funcion debe corresponder al nombre del bloque
// en camel case precedido por la palabra Funcion
class FuncionestadoDocente {
	var $sql;
	var $funcion;
	var $lenguaje;
	var $ruta;
	var $miConfigurador;
	var $miInspectorHTML;
	var $error;
	var $miRecursoDB;
	var $crypto;
	function action() {
		
// 		var_dump($_REQUEST);EXIT;
		// Evitar que se ingrese codigo HTML y PHP en los campos de texto
		// Campos que se quieren excluir de la limpieza de código. Formato: nombreCampo1|nombreCampo2|nombreCampo3
		$excluir = "";
		$_REQUEST = $this->miInspectorHTML->limpiarPHPHTML ( $_REQUEST );
		if ((! isset ( $_REQUEST ["solicitud"] ) && ! isset ( $_REQUEST ["procesarAjax"] )) || (isset ( $_REQUEST [""] ) && ($_REQUEST ["solicitud"] == "nuevo" || $_REQUEST ["solicitud"] == "editar"))) {
			
			// Realizar una validación específica para los campos de este formulario:
			$validacion = $this->verificarCampos ();
			
			if ($validacion == false) {
				// Instanciar a la clase pagina con mensaje de correcion de datos
				echo "Datos Incorrectos";
			} else {
				
				// Validar las variables para evitar un tipo insercion de SQL
				$_REQUEST = $this->miInspectorHTML->limpiarSQL ( $_REQUEST );
				
				if (! isset ( $_REQUEST ['solicitud'] ) || $_REQUEST ["solicitud"] == "nuevo") {
					
					$this->procesarNuevo ();
				} else {
					
					if ($_REQUEST ["solicitud"] == "editar") {
						$this->editar ();
					}
				}
			}
		} else {
			
			if (isset ( $_REQUEST ["procesarAjax"] )) {
				$this->procesarAjax ();
			} else {
				
				
				
				if ($_REQUEST ["solicitud"] == "confirmar") {
					$this->confirmar ();
				} elseif ($_REQUEST ["solicitud"] == "procesarNuevo") {

					$this->procesarNuevo ();
				} elseif ($_REQUEST ["solicitud"] == "procesarModificarEstado") {
					
					$this->procesarModificar ();
				} elseif ($_REQUEST ["solicitud"] == "historico" && $_REQUEST ["tiporeporte"] =='1') {
					
					$this->historicoPDF ( );
				} elseif ($_REQUEST ["solicitud"] == "historico" && $_REQUEST ["tiporeporte"] =='2') {
					
					$this->historicoExcel ( );
				} elseif ($_REQUEST ["solicitud"] == "procesarNuevo" && isset ( $_REQUEST ["botonHistorico"] ) && $_REQUEST ["botonHistorico"] == 'true' && ! isset ( $_REQUEST ['docentesTodos'] )) {
					
					$this->procesarMostrarHistorico ( $_REQUEST );
				} elseif ($_REQUEST ["solicitud"] == "procesarNuevo" && isset ( $_REQUEST ["botonHistorico"] ) && $_REQUEST ["botonHistorico"] == 'true' && isset ( $_REQUEST ['docentesTodos'] ) && $_REQUEST ['docentesTodos'] == 'on') {
					
					$this->procesarMostrarHistoricoGeneral ( $_REQUEST );
				} elseif ($_REQUEST ["solicitud"] == "procesarCertificado" && isset ( $_REQUEST ["botonPDF"] ) && $_REQUEST ["botonPDF"] == 'true') {
					
					$this->procesarCerfificado ( $_REQUEST ['datos'] );
				} elseif ($_REQUEST ["solicitud"] == "procesarCertificado" && isset ( $_REQUEST ["botonExcel"] ) && $_REQUEST ["botonExcel"] == 'true' && $_REQUEST ['botonPDF'] = 'false') {
					
					$this->procesarCerfificadoExcel ( $_REQUEST ['datos'] );
				} elseif ($_REQUEST ["solicitud"] == "procesarCertificadoGeneral" && isset ( $_REQUEST ["botonPDF"] ) && $_REQUEST ["botonPDF"] == 'true') {
					
					$this->procesarCerfificadoGeneral ( $_REQUEST ['datos'] );
				} elseif ($_REQUEST ["solicitud"] == "procesarCertificadoGeneral" && isset ( $_REQUEST ["botonExcel"] ) && $_REQUEST ["botonExcel"] == 'true' && $_REQUEST ['botonPDF'] = 'false') {
					
					$this->procesarCerfificadoExcelGeneral ( $_REQUEST ['datos'] );
				} elseif ($_REQUEST ["solicitud"] == "procesarEditarEstado") {
					
					$this->procesarEditarEstado ();
				} elseif ($_REQUEST ["solicitud"] == "procesarEditarEstadoModificar") {
					
					$this->procesarEditarEstadoModificar ( $_REQUEST ['datos'] );
				} else {
					
					if ($_REQUEST ["solicitud"] == "procesarConfirmar") {
						
						$this->procesarConfirmar ();
					} elseif ($_REQUEST ["solicitud"] == "procesarNuevo") {
						// echo "Procesar Nuevo";exit;
						$this->procesarNuevo ();
					} else {
						if ($_REQUEST ["solicitud"] == "confirmarEditar") {
							$this->confirmarEditar ();
						}
					}
				}
			}
		}
	}
	function __construct() {
		$this->miConfigurador = Configurador::singleton ();
		
		$this->miInspectorHTML = InspectorHTML::singleton ();
		
		$this->ruta = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
		
		$this->miMensaje = Mensaje::singleton ();
		
		$conexion = "aplicativo";
		$this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		if (! $this->miRecursoDB) {
			
			$this->miConfigurador->fabricaConexiones->setRecursoDB ( $conexion, "tabla" );
			$this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		}
	}
	public function setRuta($unaRuta) {
		$this->ruta = $unaRuta;
		// Incluir las funciones
	}
	function verificarCampos() {
		include_once ($this->ruta . "/funcion/verificarCampos.php");
		if ($this->error == true) {
			return false;
		} else {
			return true;
		}
	}
	
	
	function historicoExcel() {
		include_once ($this->ruta . "/funcion/historicoExcel.php");
	}
	function historicoPDF() {
		include_once ($this->ruta . "/funcion/historicoPDF.php");
	}
	function procesarModificar() {
		include_once ($this->ruta . "/funcion/procesarEditarModificar.php");
	}
	function procesarConfirmar() {
		include_once ($this->ruta . "/funcion/procesarConfirmar.php");
	}
	function verificarRegistro() {
		include_once ($this->ruta . "/funcion/verificarRegistro.php");
	}
	function procesarCerfificado($datos) {
		include_once ($this->ruta . "/funcion/reportePDF.php");
	}
	function procesarCerfificadoGeneral($datos) {
		include_once ($this->ruta . "/funcion/reportePDFGeneral.php");
	}
	function procesarCerfificadoExcel($datos) {
		include_once ($this->ruta . "/funcion/reporteExcel.php");
	}
	function procesarCerfificadoExcelGeneral($datos) {
		include_once ($this->ruta . "/funcion/reporteExcelGeneral.php");
	}
	function procesarMostrarHistorico($datos) {
		include_once ($this->ruta . "/funcion/procesarMostrarHistorico.php");
	}
	function procesarMostrarHistoricoGeneral($datos) {
		include_once ($this->ruta . "/funcion/procesarMostrarHistoricoGeneral.php");
	}
	function procesarMostrarInfoDocenteModificar($datos) {
		include_once ($this->ruta . "/funcion/procesarMostrarInfoDocenteModificar.php");
	}
	function procesarEditarEstadoModificar($datos) {
		include_once ($this->ruta . "/funcion/procesarEditarModificar.php");
	}
	function procesarMostrarInfoDocente($datos) {
		include_once ($this->ruta . "/funcion/procesarMostrarInfoDocente.php");
	}
	function procesarEditarEstado() {
		include_once ($this->ruta . "/funcion/procesarEditarEstado.php");
	}
	function procesarNuevo() {
		include_once ($this->ruta . "/funcion/procesarNuevo.php");
	}
	function guardarRegistro($datos) {
		include_once ($this->ruta . "/funcion/guardarRegistro.php");
	}
	function confirmar() {
		include_once ($this->ruta . "/funcion/confirmar.php");
	}
	function confirmarEditar() {
		include_once ($this->ruta . "/funcion/procesarConfirmarEditar.php");
	}
	function editar() {
		include_once ($this->ruta . "/funcion/procesarEditar.php");
	}
	function procesarAjax() {
		include_once ($this->ruta . "/funcion/procesarAjax.php");
	}
	function redireccionar($solicitud, $datos) {
		include_once ($this->ruta . "/funcion/redireccionar.php");
	}
	
	/**
	 * Métodos de acceso
	 *
	 * @param unknown $a        	
	 */
	function setSql($a) {
		$this->sql = $a;
	}
	function setFuncion($funcion) {
		$this->funcion = $funcion;
	}
	public function setLenguaje($lenguaje) {
		$this->lenguaje = $lenguaje;
	}
	public function setFormulario($formulario) {
		$this->formulario = $formulario;
	}
}
?>