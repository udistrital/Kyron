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
    	$rutaSara = $this->miConfigurador->getVariableConfiguracion ( 'raizDocumento' );
    	$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( 'rutaBloque' );
    	$rutaUrlBloque = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' );
    	
    	$this->atributos['rutaBloque'] = $rutaBloque;
    	$html = $this->parsePhpHtml('html/'.$this->atributos['origen']);
    	
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
    	
    	$rutaPDF = $rutaBloque.'/builder/pdf/';
    	$files = glob($rutaPDF.$this->atributos['destino'].'*.pdf');
    	foreach ($files as $file){
    		unlink($file);
    	}
    	
    	foreach (glob($rutaPDF."*") as $file) {    	
    		/*** if file is 1 hours (3600 seconds) old then delete it ***/
    		if (filemtime($file) < time() - 3600) {
    			unlink($file);
    		}
    	}
    	
    	$randomName = $this->miConfigurador->fabricaConexiones->crypto->codificar (time());
    	$randomName = $this->atributos['destino'].'-'.$randomName.'.pdf';
    	
    	$rutaPDF = $rutaPDF.$randomName;
    	 
    	file_put_contents($rutaPDF, $dompdf->output());    	
    	
    	$rutaUrlPDF = $rutaUrlBloque.'builder/pdf/'.$randomName;
    	
    	if(!(isset($this->atributos['showHTML'])&&$this->atributos['showHTML']==true)){
    		$html = '<object data="'.$rutaUrlPDF.'" type="application/pdf">
		        <embed src="'.$rutaUrlPDF.'" type="application/pdf" />
		    </object>';
    	}
    	
    	
		$html .= '<br /><div class="marcoBotones">
					<a class="ui-button ui-state-default ui-corner-all ui-button-text-only" href="'.$rutaUrlPDF.'">Descargar Reporte en PDF</a>
				</div>';
		    	
    	return $html;
    }  
    
}