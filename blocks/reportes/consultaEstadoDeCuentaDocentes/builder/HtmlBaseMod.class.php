<?php
include_once ("core/manager/Configurador.class.php");

/**
 * Contiene las definiciones básicas de los metaComponentes de plugins
 */
class HtmlBaseMod {
    //Guarda el HTML que genera el componente.
    var $cadenaHTML;
    //Guarda los atributos con que se desea crear el objeto
    var $atributos;
    //Guarda la variable Configurador Singleto
    var $miConfigurador;
    
    //Configura la variable de Configurador Singleton
    function __construct() {
        
        $this->miConfigurador = Configurador::singleton ();
    
    }
    //Configura los atributos que se usan en el armado de Componentes
    function setAtributos($misAtributos) {
        
        $this->atributos = $misAtributos;
    
    }
    //Recupera el html con sus reemplazos de PHP
    function parsePhpFile($filename){
    	ob_start();
    	require ($filename);
    	return trim(ob_get_clean());
    }
    //Recupera el html con sus reemplazos de PHP
    function parsePhpHtml($filename){
    	return $this->parsePhpFile($filename);
    }
    //Recupera el html con sus reemplazos de PHP
    function parsePhpJs($filename){
    	$js = "\n".$this->parsePhpFile($filename)."\n";
    	$js .= "<script type='text/javascript'";
		$srcjs = "var _arregloCreacionElementos=(typeof(_arregloCreacionElementos)=='object')?";
		$srcjs .= "_arregloCreacionElementos:(new Array());";
		$srcjs .= "_arregloCreacionElementos.push(cargarElemento);";
    	$js .= " src='data:text/javascript;base64,".base64_encode($srcjs)."'>";
    	$js .="</script>\n";    			
    	return $js;
    }
    //Retorna el campo seguro con el id como codificación del id y tiempo
    function campoSeguro($campo = '') {
        
        if (isset ( $_REQUEST ['tiempo'] )) {
            $this->atributos ['tiempo'] = $_REQUEST ['tiempo'];
        }
        
        if ($campo != '') {
            return $this->miConfigurador->fabricaConexiones->crypto->codificar ( $campo . $this->atributos ['tiempo'] );
        } else {
        	return $this->miConfigurador->fabricaConexiones->crypto->codificar ( $this->atributos ['id'] . $this->atributos ['tiempo'] );
        }
    }    
}
?>
