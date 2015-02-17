<?php
/**
 * @todo Es necesario actualizar esta clase para manejar i18n utilizando gettext
 * 
 * @author paulo
 *
 */
//require_once("plugin/php-gettext/gettext.inc");


class Lenguaje{
	
	private static $instance;
	
	private $cadena;	
	
	var $idioma;
	
	
	
	public static function singleton($idioma="")
	{
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className($idioma);
		}
		return self::$instance;
	}
	
	private function __construct($idioma=""){
		
		if($idioma!=""){
			$miIdioma=$idioma;
		}else{
			$miIdioma="es_es";
		}
		include("core/locale/".$miIdioma."/LC_MESSAGES/Mensaje.page.php");
		
	}

	public function getCadena($opcion=""){
		$opcion=trim($opcion);
		if(isset($this->idioma[$opcion])){
			return $this->idioma[$opcion];
		}else{
			return $this->idioma["noDefinido"];
		}		
	}
	
}

?>