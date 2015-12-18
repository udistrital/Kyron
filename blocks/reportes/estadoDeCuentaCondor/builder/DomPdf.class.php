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
    	//Se convierte el pdf a base 64
    	$pdfBase64 = base64_encode($dompdf->output());
    	//Se crea un nombre de variable base 64 para javascript 	
    	$idComponenteBase64 = 'base64'.$this->atributos['id'];
    	
    	/*
    	 * Si esta variable está establecida, se imprime el pdf en pantalla junto con un botón de descarga,
    	 * de lo contrario simplemente se ve el html y el botón de descarga.
    	 */
    	if(!(isset($this->atributos['showHTML'])&&$this->atributos['showHTML']==true)){			
    		$html = '
    		<object id="'.$this->atributos['id'].'" style="width:100%;min-height:1058px;height:100%;" data="" type="application/pdf">
 		        <embed style="width:100%;min-height:1058px;height:100%;" src="" type="application/pdf" />
 		    </object>';
    		//Se muestra un botón en pantalla con el cual se puede descargar el pdf generado
    		$html .= '<br />
    		<div class="marcoBotones">
				<a id="boton'.$this->atributos['id'].'" target="_blank" class="ui-button ui-state-default ui-corner-all ui-button-text-only" href="">Descargar Reporte en PDF</a>
			</div>';
    		$html .= '
    		<script type="text/javascript">
    			var '.$idComponenteBase64.'="data:application/pdf;base64,'.$pdfBase64.'";
    			document.getElementById("boton'.$this->atributos['id'].'").setAttribute("href",'.$idComponenteBase64.');
    			document.getElementById("'.$this->atributos['id'].'").setAttribute("data",'.$idComponenteBase64.');
    			if(document.getElementById("'.$this->atributos['id'].'").getElementsByTagName("embed")[0]){
    				document.getElementById("'.$this->atributos['id'].'").getElementsByTagName("embed")[0].setAttribute("src",'.$idComponenteBase64.');
    			}
    		</script>';
    	} else {
    		//Se muestra un botón en pantalla con el cual se puede descargar el pdf generado
    		$html .= '<br />
    		<div class="marcoBotones">
				<a id="boton'.$this->atributos['id'].'" target="_blank" class="ui-button ui-state-default ui-corner-all ui-button-text-only" href="">Descargar Reporte en PDF</a>
			</div>';
    		
    		$html .= '
    		<script type="text/javascript">
    			var '.$idComponenteBase64.'="data:application/pdf;base64,'.$pdfBase64.'";
    			document.getElementById("boton'.$this->atributos['id'].'").setAttribute("href",'.$idComponenteBase64.');
    		</script>';
    	}
		    	
    	return $html;
    }  
    
}