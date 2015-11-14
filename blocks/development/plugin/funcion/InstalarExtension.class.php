<?php

namespace development\plugin\funcion;

class InstalarExtension {
    
    var $miConfigurador;
    var $lenguaje;
        
    function __construct($lenguaje) {
        
       	$this->miConfigurador = \Configurador::singleton ();
        $this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
        $this->lenguaje = $lenguaje;            
    }
    
    function instalarPorUrl($url) {
    	echo 'hi:<a href="'.$url.'">Link</a>'.;die;
    }
}

