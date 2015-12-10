<?php

//namespace blocks\docentes\planDeTrabajo\builder\componentes;

if (! isset ( $GLOBALS ['autorizado'] )) {
	include ('index.php');
	exit ();
}

include_once ("HtmlBaseMod.class.php");
/**
 * Para calendario:
 * $atributos['destino'] Nombre del archivo destino
 * $atributos['origin'] Nombre del html de origen
 */
class DomPdfPlugin extends HtmlBaseMod{
	
	var $miConfigurador;
	/*
	 * Este nombre no puede ser igual al de la clase
	 */
    public function pdf($atributos) {
    	
    	$this->miConfigurador = \Configurador::singleton();
        
        $this->setAtributos ( $atributos );
        
        $this->campoSeguro();
        
        $this->cadenaHTML = '';
        
        $final='';
    
        $this->cadenaHTML .= $this->createDomPdf();
        
        return $this->cadenaHTML.$final;
    
    }
    
	private function createDomPdf(){    
    	// $htmlModal = file_get_contents('page-content-wrapper.html.php', true);
    	$html = $this->parsePhpHtml('html/'.$this->atributos['origen']);
    	
    	$rutaSara = $this->miConfigurador->getVariableConfiguracion ( 'raizDocumento' );
    	$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( 'rutaBloque' );
    	$rutaUrlBloque = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' );
    	
    	require_once( $rutaSara."/plugin/dompdf/dompdf_config.inc.php");
    	
		$dompdf = new DOMPDF();
    	$dompdf->load_html($html);
    	try{
    	$dompdf->render();
    	}catch(Exception $e){
    		echo $html;
    		die($e->getMessage());
    	}
    	//$dompdf->stream("sample.pdf");
    	$rutaPDF = $rutaBloque.'/builder/pdf/'.$this->atributos['destino'];
    	
    	file_put_contents($rutaPDF, $dompdf->output());
    	
    	$rutaUrlPDF = $rutaUrlBloque.'/builder/pdf/'.$this->atributos['destino'];
    	
    	$html = '<object data="'.$rutaUrlPDF.'" type="application/pdf">
	        <embed src="'.$rutaUrlPDF.'" type="application/pdf" />
	    </object>';
		$html .= '<br /><a href="'.$rutaUrlPDF.'">Descargar Reporte</a>';
		    	
    	return $html;
    }  
    
}