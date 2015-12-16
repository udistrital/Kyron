<?php

//namespace blocks\docentes\planDeTrabajo\builder\componentes;

if (! isset ( $GLOBALS ['autorizado'] ) && ! isset($_POST['download'])) {
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
    	
        $this->cadenaHTML = '';
        
        $final='';
    
        $this->cadenaHTML .= $this->createDom();
        
        return $this->cadenaHTML.$final;
    
    }
    
	private function createDom(){    

    	$html = $this->parsePhpHtml('html/'.$this->atributos['plantilla']);    	
    	
    	if(isset($this->atributos['onlyHTML'])&&$this->atributos['onlyHTML']==true){
    		
    		$rutaUrlPDF = $this->atributos['rutaUrlBloque'].'builder/DomPdf.class.php';
    		$valorCodificado = 'plantilla=' . base64_encode($this->atributos['plantilla']);
    		$valorCodificado .= 'datos_docente=' . base64_encode($this->atributos['datos_docente']);
    		$valorCodificado .= 'items=' . base64_encode(serialize($this->atributos['items']));
    		$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
    		$html .= '<br />
    			<div class="marcoBotones">
					<button class="ui-button ui-state-default ui-corner-all ui-button-text-only" onclick="descargarPDF'.$this->atributos['id'].'()">Descargar Reporte en PDF</button>
					<script type="text/javascript">
					//Importante que la función se llame cargar elemento.
					var descargarPDF'.$this->atributos['id'].' = function() {
						var f = document.createElement("form");
						f.setAttribute("method","post");
						f.setAttribute("action","'.$rutaUrlPDF.'");
						
						var i = document.createElement("input"); //input element, text
						i.setAttribute("type","text");
						i.setAttribute("name","download");
						i.setAttribute("value","'.$valorCodificado.'");
						f.appendChild(i);
						document.getElementsByTagName("body")[0].appendChild(f);
						//window.open("", "TheWindow");
						f.submit();
					};
					</script>
				</div>';
    	}
    	return $html;
    }
    
    public function dowloadPdf($atributos) {
    	
    	$contentPDF = $this->createPdf($atributos);
  	
    	header('Content-Type: application/pdf');
    	header('Content-Length: '.strlen( $content ));
    	header('Content-disposition: inline; filename="' . $name . '"');
    	header('Cache-Control: public, must-revalidate, max-age=0');
    	header('Pragma: public');
    	header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    	header("Content-type:application/pdf");
    	header("Content-Disposition:attachment;filename='docente.pdf'");    	
    
    	echo $contentPDF;
    
    	return true;
    
    }
    
    private function createPdf($atributos){
    	
    	$html = $this->pdf($atributos);
    	
    	require_once( $this->atributos['raizDocumento']."/plugin/dompdf/dompdf_config.inc.php");
    	
    	$dompdf = new DOMPDF();
    	$dompdf->load_html($html);
    	try{
    		$dompdf->render();
    	}catch(Exception $e){
    		echo $html;
    		die($e->getMessage());
    	}
    	 
    	$pdf = $dompdf->output();
    	
    	return $pdf;
    }
    
}