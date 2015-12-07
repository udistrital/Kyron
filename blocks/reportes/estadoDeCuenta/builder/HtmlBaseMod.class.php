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
    	include($filename);
    	return trim(ob_get_clean());
    }
    //Recupera el html con sus reemplazos de PHP
    function parsePhpHtml($filename){
    	return $this->parsePhpFile($filename);
    }
    //Recupera el html con sus reemplazos de PHP
    function parsePhpJs($filename){
    	$js = "\n".$this->parsePhpFile($filename)."\n";
    	$js .= "<script type='text/javascript'>\n";
    	$js .= "var _arregloCreacionElementos = (typeof(_arregloCreacionElementos)=='object')?_arregloCreacionElementos:(new Array()); \n";
    	$js .= "_arregloCreacionElementos.push(cargarElemento);\n";
    	$js .="</script>\n";    			
    	return $js;
    }
    //Campo seguro que por ahora no hace nada
    function campoSeguro($campo = '') {
        
        if (isset ( $_REQUEST ['tiempo'] )) {
            $this->atributos ['tiempo'] = $_REQUEST ['tiempo'];
        }
        
        if (isset ( $this->atributos ['campoSeguro'] ) && $this->atributos ['campoSeguro'] && $this->atributos [self::ID] != 'formSaraData') {
            $this->atributos [self::ID] = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $this->atributos [self::ID] . $this->atributos ['tiempo'] );
            $this->atributos [self::NOMBRE] = $this->atributos [self::ID];
            if ($campo == 'form') {
                $_REQUEST ['formSecureId'] = $this->atributos [self::ID];
            }
        }
        
    }    
}
?>
