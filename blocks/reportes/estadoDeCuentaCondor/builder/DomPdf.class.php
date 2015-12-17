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
    	
    	$this->atributos['raizDocumento'] = $this->miConfigurador->getVariableConfiguracion ( 'raizDocumento' );
    	$this->atributos['rutaBloque'] = $this->miConfigurador->getVariableConfiguracion ( 'rutaBloque' );
    	$this->atributos['rutaUrlBloque'] = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' );
        
        $this->campoSeguro();
        
        $this->cadenaHTML = '';
        
        $final='';
    
        $this->cadenaHTML .= $this->createDomPdf();
        
        return $this->cadenaHTML.$final;
    
    }
    
	private function createDomPdf(){
		//Se carga la plantilla de un archivo html.php    	
    	$html = $this->parsePhpHtml('html/'.$this->atributos['plantilla']);
    	//se carga el plugin dompdf
    	require_once( $this->atributos['raizDocumento']."/plugin/dompdf/dompdf_config.inc.php");
    	//Se crea una instancia de la clase, si la renderización genera error, este se imprime en pantalla
		$dompdf = new DOMPDF();
    	$dompdf->load_html($html);
    	try{
    		$dompdf->render();
    	}catch(Exception $e){
    		echo $html;
    		die($e->getMessage());
    	}
    	//$dompdf->stream("sample.pdf");
    	
    	//Se eliminan los archivos pdf que comiencen con el índice del archivo destino
    	//los archivos se guardan en el directorio builder/pdf
    	$rutaPDF = $this->atributos['rutaBloque'].'/builder/pdf/';
    	$files = glob($rutaPDF.$this->atributos['destino'].'*.pdf');
    	foreach ($files as $file){
    		unlink($file);
    	}
    	//Como forma de resguardar recursos de disco, se pretende eliminar los archivos que tienen más de una hora de creados
    	foreach (glob($rutaPDF."*") as $file) {    	
    		/*** if file is 1 hours (3600 seconds) old then delete it ***/
    		if (filemtime($file) < time() - 3600) {
    			unlink($file);
    		}
    	}
    	
    	//Se crea un nombre aleatorio volviendo al "destino" un índice del nombre del pdf
    	$randomName = $this->miConfigurador->fabricaConexiones->crypto->codificar (time());
    	$randomName = $this->atributos['destino'].'-'.$randomName.'.pdf';
    	
    	//Se guarda el pdf en la ruta especificada y con el nombre especificado
    	$rutaPDF = $rutaPDF.$randomName;
    	file_put_contents($rutaPDF, $dompdf->output());    	
    	
    	//Si se elige mostrar el html, se imprime éste en pantalla, de lo contrario imprimirá un frame con el pdf
    	$rutaUrlPDF = $this->atributos['rutaUrlBloque'].'builder/pdf/'.$randomName;
    	
    	if(!(isset($this->atributos['showHTML'])&&$this->atributos['showHTML']==true)){
    		$html = '<object style="width:100%;min-height:1058px;height:100%;" data="'.$rutaUrlPDF.'" type="application/pdf">
		        <embed style="width:100%;height:100%;" src="'.$rutaUrlPDF.'" type="application/pdf" />
		    </object>';
    	}
    	
    	//Se muestra un botón en pantalla con el cual se puede descargar el pdf generado
		$html .= '<br /><div class="marcoBotones">
					<a target="_blank" class="ui-button ui-state-default ui-corner-all ui-button-text-only" href="'.$rutaUrlPDF.'">Descargar Reporte en PDF</a>
				</div>';
		    	
    	return $html;
    }  
    
}