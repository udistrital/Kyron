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
    
    function instalarPorUrl($urlExtension) {
    	echo 'hi:<a href="'.$urlExtension.'">Link</a><br />';
    	$raizInstalacion = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" );
    	$path = $raizInstalacion . '/extensions';
    	if (is_dir($path)) {
    		echo '<p>(Warning) Directorio de Extensiones ya existe.</p>';
    	} else {
    		mkdir($path, 0755);
    	}
    	$filePath = $path.'/tempFile.tar.gz';    	
    	if (file_exists($filePath)){
    		unlink($filePath);
    	}
    	try{
    		$aContext = array(
    				'http' => array(
    						'proxy' => 'tcp://10.20.4.15:3128',
    						'request_fulluri' => true,
    				),
    		);
    		$cxContext = stream_context_create($aContext);
    		$content = file_get_contents($urlExtension, false, $cxContext);
    		file_put_contents($path.'/tempFile.tar.gz', $content);
    	} catch(Exception $e){
    		echo '<p>(Warning) No se detecta una conexión a internet desde el servidor.</p>';
    		echo '<p>Caught exception: ',  $e->getMessage(), '</p>';
    	}
    	try {
	    	system('tar -zxvf '.$filePath.' '.$path);
    	} catch (Exception $e) {
    		// handle errors
    	}
    	/*
    	 * Falta descomprimir, copiar al directorio, saber que directorio fue el que pasé, ejecutar Extension.php, pero antes de ejecutar mostrar el anuncio de éso.
    	 */
    	var_dump($_REQUEST);
    }
}

$miInstalador = new InstalarExtension ( $this->lenguaje );
