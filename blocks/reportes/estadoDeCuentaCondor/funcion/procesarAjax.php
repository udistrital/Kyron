<?php
namespace reportes\estadoDeCuentaCondor\funcion;

$_REQUEST['tiempo'] = time();
$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
require_once ($rutaBloque."builder/DomPdf.class.php");

if (class_exists ( '\FormularioHtml' )) {
	class FormularioHtml extends \FormularioHtml {
		function __construct() {
			/**
			 * Se agregan los componentes hechos para SARA
			 */
			//Se llama a la clase constructor del padre
			parent::__construct ();
			//Se llama a las funciones que están dentro de la clase y se agregan al formulario
			$this->aggregate ( 'DomPdfPlugin' );
			//Se termina la agregación
		}
	}
}

// 
// $conexion = "docencia";
// $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );


//Estas funciones se llaman desde ajax.php y estas a la vez realizan las consultas de Sql.class.php

switch ($_REQUEST ['funcion']) {
    case 'descargarPDF':
		$html = $_REQUEST['html'];
		$html = str_replace('\_', '_', $html);
		$html = $this->miConfigurador->fabricaConexiones->crypto->decodificar($html);
		$miFormulario = new FormularioHtml();
		$atributos ['html'] = $html;
		$atributos ['destino'] = 'reporteEstadoDeCuenta.pdf';
		//Imprime el PDF en pantalla
		$miFormulario->downloadPdf ( $atributos );
        break;
    default:
        die('Asigne la variable \'funcion\'');
}
?>