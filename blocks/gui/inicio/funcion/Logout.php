<?php

class Logout {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $conexion;
	var $host;
	var $site;
	
	
	function __construct($lenguaje, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->host = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$this->hostSSO = $this->miConfigurador->getVariableConfiguracion ( "hostSSO" );
		$this->SPSSO = $this->miConfigurador->getVariableConfiguracion ( "SPSSO" );
		$this->site = $this->miConfigurador->getVariableConfiguracion ( "site" );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
	}
	function procesarFormulario() {
		$saml_lib_path = '/var/simplesamlphp/lib/_autoload.php';
		
		require_once ($saml_lib_path);
		
		// $aplication_base_url = 'http://10.20.0.38/splocal/';
		$aplication_base_url = $this->hostSSO.$this->site.'/';
		$source = $this->SPSSO; // Fuente de autenticación definida en el authsources del SP
		
		$auth = new SimpleSAML_Auth_Simple ( $source ); // Se pasa como parametro la fuente de autenticación
		
		$auth->logout ( $aplication_base_url . 'index.php' );
				
		return true;
	}
}

$miProcesador = new Logout ( $this->lenguaje, $this->sql );
$miProcesador->procesarFormulario();
?>