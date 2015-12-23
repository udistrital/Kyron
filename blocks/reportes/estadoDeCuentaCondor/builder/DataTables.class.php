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
class DataTablesPlugin extends HtmlBaseMod{
	
	var $miConfigurador;
	/*
	 * Este nombre no puede ser igual al de la clase
	 */
    public function tabla($atributos) {
    	
    	$this->miConfigurador = \Configurador::singleton();
    	
    	$this->setAtributos ( $atributos );
    	
    	$this->atributos['raizDocumento'] = $this->miConfigurador->getVariableConfiguracion ( 'raizDocumento' );
    	$this->atributos['rutaBloque'] = $this->miConfigurador->getVariableConfiguracion ( 'rutaBloque' );
    	$this->atributos['rutaUrlBloque'] = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' );
        
        $this->campoSeguro();
        
        $this->cadenaHTML = '';
        
        $final='';
    
        $this->cadenaHTML .= $this->createDataTables();
        
        return $this->cadenaHTML.$final;
    
    }
    
	private function createDataTables(){
		//Se carga la plantilla de un archivo html.php    	
    	$html = $this->parsePhpHtml('html/dataTables.html.php');
    	return $html;
    }  
    
}