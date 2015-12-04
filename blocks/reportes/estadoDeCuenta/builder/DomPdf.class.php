<?php

//namespace blocks\docentes\planDeTrabajo\builder\componentes;

if (! isset ( $GLOBALS ['autorizado'] )) {
	include ('index.php');
	exit ();
}

include_once ("HtmlBaseMod.class.php");
/**
 * Para calendario:
 * $atributos['destino'] String Identificador del objeto HTML
 * $atributos['id'] TipoVariable Comentario
 */
class DomPdf extends HtmlBaseMod{

    function calendario($atributos) {
        
        $this->setAtributos ( $atributos );
        
        $this->campoSeguro();
        
        $this->cadenaHTML = '';
        
        $final='';
    
        $this->cadenaHTML .= $this->createCalendar();
        
        return $this->cadenaHTML.$final;
    
    }
    
	private function createCalendar(){    
    	// $htmlModal = file_get_contents('page-content-wrapper.html.php', true);
    	$html = $this->parsePhpHtml('html/dompdf.html.php');
    	
    	$rutaSara = $this->miConfigurador->getVariableConfiguracion ( 'raizDocumento' );
    	$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( 'rutaBloque' );
    	
    	require_once( $rutaSara."/plugin/dompdf/dompdf_config.inc.php");
    	
		$dompdf = new DOMPDF();
    	$dompdf->load_html($html);
    	$dompdf->render();
    	//$dompdf->stream("sample.pdf");
    	file_put_contents($this->atributos['destino'], $dompdf->output());
		echo $rutaBloque.'Brochure.pdf';
    	
    	return $html;
    }  
    
}