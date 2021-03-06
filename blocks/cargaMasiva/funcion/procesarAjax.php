<?php
namespace reportes\estadoDeCuentaCondor\funcion;
use reportes\estadoDeCuentaCondor\Sql;
use core\general\ValidadorCampos;

$host = $this->miConfigurador->getVariableConfiguracion ( "host" );

header('Access-Control-Allow-Origin: '.$host.'');

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
	case 'guardarObservacion':
		$_REQUEST['llaves_primarias_valor'] = str_replace('\\_', '_', $_REQUEST['llaves_primarias_valor']);
		$_REQUEST['llaves_primarias_valor'] = $this->miConfigurador->fabricaConexiones->crypto->decodificar($_REQUEST['llaves_primarias_valor']);
		
		include_once ('core/general/ValidadorCampos.class.php');
		$miValidador = new ValidadorCampos();
		
		$valido = $miValidador->validarTipo($_REQUEST['observacion'],'onlyLetterNumberSpPunt');
		$valido = $valido && $miValidador->validarTipo($_REQUEST['verificado'],'boleano');
		
		if (!$valido) {
			header('Content-Type: text/json; charset=utf-8');
			echo json_encode(array("errorType"=>"custom","errorMessage"=>"El campo observacion sólo debe contener elementos alfanuméricos, espacios, comas y punto."));
			exit ();
		}
		
		$conexion = "docencia";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		$cadenaSql = $this->sql->getCadenaSql ( 'registrar_observacion', $_REQUEST );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "insertar" );
		if ($resultado) {
			header('Content-Type: text/json; charset=utf-8');
			echo json_encode(true);
			exit ();
		} else {
			$cadenaSql = $this->sql->getCadenaSql ( 'actualizar_observacion', $_REQUEST );
			$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );
			header('Content-Type: text/json; charset=utf-8');
			if ($resultado) {
				echo json_encode(true);
			} else {
				echo json_encode(array("errorType"=>"registry or update","errorMessage"=>"Algo anda mal, no se pudo realizar el registro de la observación."));
			}
			exit ();
		}
		return true;
        break;
    case 'consultarDocente':
    	$conexion = "docencia";
    	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
    	
    	//Esta Función es la que permite ir realizando las consultas a medida que se van ingresando caracteres ya sean números o letras en el campo docentes.
    	   
    	if ($_REQUEST ['funcion'] == 'consultarDocente') {
    		$cadenaSql = $this->sql->getCadenaSql ( 'docente', $_GET ['query'] );
    		$resultadoItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
    		echo '{"suggestions":' . json_encode ( $resultadoItems ) . '}';
    	}
    	break;
    default:
        die('Asigne la variable \'funcion\'');
}

?>