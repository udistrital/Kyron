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
    	if(isset($atributos ['downloadPDF'])){
			return $this->downloadPdf();
		} else if(isset($atributos ['returnBase64'])){
			$this->cadenaHTML .= $this->createPdfBase64();
		} else {
			$this->cadenaHTML .= $this->createDomPdf();
		}
		       
        return $this->cadenaHTML.$final;
    
    }
	
	public function downloadPdf($atributos) {
		$this->miConfigurador = \Configurador::singleton();    	
    	$this->setAtributos ( $atributos );    	
    	$this->atributos['raizDocumento'] = $this->miConfigurador->getVariableConfiguracion ( 'raizDocumento' );
		
		require_once( $this->atributos['raizDocumento']."/plugin/dompdf/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
		$dompdf->load_html($this->atributos['html']);
		$dompdf->render();
		$dompdf->stream($this->atributos ['destino']);
		
	}
	
	private function html2pdf($html){
		require_once( $this->atributos['raizDocumento']."/plugin/dompdf/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
    	$dompdf->load_html($html);
    	try{
    		$dompdf->render();
    	}catch(Exception $e){
    		echo $html;
    		die($e->getMessage());
    	}
		return $dompdf->output();
	}
	
	private function createPdfBase64() {
    	//Se convierte el pdf a base 64
    	$pdf = $this->html2pdf($this->atributos['html']);
    	$pdfBase64 = base64_encode($dompdf->output());
		return $pdfBase64;
	}
	
	private function createDomPdf(){
		//Se carga la plantilla de un archivo html.php    	
    	$html = $this->parsePhpHtml('html/'.$this->atributos['plantilla']);
		
		/*
    	 * Si esta variable está establecida, se genera un enlace de generación de PDF asíncrono.
    	 */
    	if(isset($this->atributos['enlaceAjax'])){
    		$htmlAjax = '<br />
    		<div class="marcoBotones">
	    		<form action="'.$this->atributos['enlaceAjax'].'" method="post" target="_blank">
	    			<input type="hidden" name="html" value="'.$this->miConfigurador->fabricaConexiones->crypto->codificar($html).'"/>
				    <input type="submit" id="boton'.$this->atributos['id'].'" class="ui-button ui-state-default ui-corner-all ui-button-text-only" value="Descargar Reporte en PDF">
				</form>				
			</div>';
			return $htmlAjax;
			/**
			 * Para que esta opción funcione es necesario crear un servicio Ajax (en el archivo procesarAjax.php) y en este poner:
			 	$html = $_REQUEST['html'];
				$html = str_replace('\_', '_', $html);
				$html = $this->miConfigurador->fabricaConexiones->crypto->decodificar($html);
				$miFormulario = new FormularioHtml();
				$atributos ['html'] = $html;
				$atributos ['destino'] = 'reporteEstadoDeCuenta.pdf';
				//Imprime el PDF en pantalla
				$miFormulario->downloadPdf ( $atributos );
			 */
    	}
		
		//Se convierte el html a pdf en base64
		$pdf = $this->html2pdf($html);
    	$pdfBase64 = base64_encode($pdf);
    	//Se crea un nombre de variable base 64 para javascript 	
    	$idComponenteBase64 = 'base64'.$this->atributos['id'];
    	
    	$scriptHTML = '';
		
		/*
    	 * Si esta variable está establecida, se imprime el pdf en pantalla junto con un botón de descarga,
    	 * de lo contrario simplemente se ve el html y el botón de descarga.
    	 */
    	if(isset($this->atributos['showHTML'])&&$this->atributos['showHTML']==true){
			$html = $html;
    	} else {
    		$html = '';
    	}
		
		/*
    	 * Si se desea mostrar el PDF en la página
    	 */
		if(isset($this->atributos['showPDF'])&&$this->atributos['showPDF']==true) {
    		$html .= '
    		<object id="'.$this->atributos['id'].'" style="width:100%;min-height:1058px;height:100%;" data="" type="application/pdf">
 		        <embed style="width:100%;min-height:1058px;height:100%;" src="" type="application/pdf" />
 		    </object>';
    		//Se muestra un botón en pantalla con el cual se puede descargar el pdf generado
    		$scriptHTML .= '
			document.getElementById("'.$this->atributos['id'].'").setAttribute("data",'.$idComponenteBase64.');
			if(document.getElementById("'.$this->atributos['id'].'").getElementsByTagName("embed")[0]){
				document.getElementById("'.$this->atributos['id'].'").getElementsByTagName("embed")[0].setAttribute("src",'.$idComponenteBase64.');
			}';
    	}
		/**
		 * Si se desea mostrar un botón de descarga
		 */
    	if(isset($this->atributos['showButton'])&&$this->atributos['showButton']==true) {   		
    		$html .= '<br />
    		<div class="marcoBotones">
				<a id="boton'.$this->atributos['id'].'" target="_blank" class="ui-button ui-state-default ui-corner-all ui-button-text-only" href="">Descargar Reporte en PDF</a>
			</div>';
			    		
    		$scriptHTML .= '
    		document.getElementById("boton'.$this->atributos['id'].'").setAttribute("href",'.$idComponenteBase64.');';
    	} else {
    		
		}
		
		$scriptHTML = '
    		<script type="text/javascript">
    			var '.$idComponenteBase64.'="data:application/pdf;base64,'.$pdfBase64.'";
    			'. $scriptHTML .'
    		</script>';
		
		$html .= $scriptHTML;
    	
    	return $html;
    }  
    
}