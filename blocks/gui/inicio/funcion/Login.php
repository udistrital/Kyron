<?php

class Login {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $conexion;
	var $host;
	var $site;
	var $miAutenticador;
	
	function __construct($lenguaje, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->host = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$this->hostSSO = $this->miConfigurador->getVariableConfiguracion ( "hostSSO" );
		$this->SPSSO = $this->miConfigurador->getVariableConfiguracion ( "SPSSO" );
		$this->site = $this->miConfigurador->getVariableConfiguracion ( "site" );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
		$this->miAutenticador = \Autenticador::singleton ();
	}
	function procesarFormulario() {
		$saml_lib_path = '/var/simplesamlphp/lib/_autoload.php';
		
		require_once ($saml_lib_path);
		
		// $aplication_base_url = 'http://10.20.0.38/splocal/';
		$aplication_base_url = $this->hostSSO.$this->site.'/';
		$source = $this->SPSSO; // Fuente de autenticación definida en el authsources del SP
		
		$as = new SimpleSAML_Auth_Simple ( $source ); // Se pasa como parametro la fuente de autenticación
		
		$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
		//Enlace al que se dirije una vez logueado
		$valorCodificado = "pagina=bienvenido";
		//$valorCodificado .= "&autenticado=true";
		$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
		$enlace = $directorio.'='.$valorCodificado;
		$login_params = array (
				'ReturnTo' => $enlace 
		);
		if($as->isAuthenticated()){
			header('Location: '.$enlace);			
		} else {
			$as->requireAuth ( $login_params );
		}
		$atributos = $as->getAttributes();
		
		return $atributos;
	}
}

$miProcesador = new Login ( $this->lenguaje, $this->sql );
$miProcesador->procesarFormulario();
?>