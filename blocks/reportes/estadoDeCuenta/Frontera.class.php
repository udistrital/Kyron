<?php

namespace reportes\estadoDeCuenta;

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

include_once ("core/manager/Configurador.class.php");

/*
 * Sirve para agregar al core de SARA la funcionalidad de plantillas con domPDF
 */
include_once("core/builder/FormularioHtml.class.php");

if (class_exists ( '\FormularioHtml' )) {
	class FormularioHtml extends \FormularioHtml {
		function __construct() {
			/**
			 * Se agregan los componentes hechos con Boostrap para SARA
			 */
			require_once ($this->ruta . "builder/DomPdf.class.php");
			// use blocks\docentes\planDeTrabajo\builder\componentes;
			//Se llama a la clase constructor del padre
			parent::__construct ();
			//Se llama a las funciones que están dentro de la clase y se agregan al formulario
			$this->aggregate ( 'DomPdfPlugin' );
			//Se termina la agregación
		}
	}
}

class Frontera {

    var $ruta;
    var $sql;
    var $funcion;
    var $lenguaje;
    var $formulario;
    var $miConfigurador;

    function __construct() {

        $this->miConfigurador = \Configurador::singleton();
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

    function frontera() {
        $this->html();
    }

    function setSql($a) {
        $this->sql = $a;
    }

    function setFuncion($funcion) {
        $this->funcion = $funcion;
    }

    function html() {

        $this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");
        $this->miFormulario = new FormularioHtml();

        if (isset($_REQUEST['opcion'])) {

            switch ($_REQUEST['opcion']) {

                case "mensaje":
                    include_once($this->ruta . "/formulario/mensaje.php");
                    break;
                
                case "consultar":
                    include_once($this->ruta . "/formulario/consultar.php");
                    break;
                
                case "nuevo":
                     include_once($this->ruta . "/formulario/formulario.php");
                    break;
                
                 case "modificar":
                     include_once($this->ruta . "/formulario/modificar.php");
                    break;
            }
        } else {
            $_REQUEST['opcion'] = "mostrar";
            include_once($this->ruta . "/formulario/formulario.php");
        }
    }

}

?>
