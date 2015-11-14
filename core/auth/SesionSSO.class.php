<?php

class SesionSSO {

	
	var $sesionExpiracion;
	
	var $site;
	var $hostSSO;
	var $SPSSO;
	var $configurador;
    
    /**
     *
     * @name sesiones
     *       constructor
     */
    //private 
    function __construct() {
		//SET Session EXPIRATION
    	$this->configurador = \Configurador::singleton ();
    	$this->site = $this->configurador->getVariableConfiguracion ( "site" );
    	$this->hostSSO = $this->configurador->getVariableConfiguracion ( "hostSSO" );
    	$this->SPSSO = $this->configurador->getVariableConfiguracion ( "SPSSO" );
    }
    
    function setTiempoExpiracion($valor) {
    
    	$this->tiempoExpiracion = $valor;
    
    }
    
    function getSesionExpiracion() {
    
    	return $this->sesionExpiracion;
    
    }

    /**
     *
     * @name sesiones Verifica la existencia de una sesion válida en la máquina del cliente
     * @param
     *            string nombre_db
     * @return void
     * @access public
     */
    function verificarSesion() {

        $resultado = true;
		
        // Se eliminan las sesiones expiradas
        //$this->borrarSesionExpirada();
        
        
        $resultado = $this->crearSesion();
        
        return $resultado;
    }

    /* Fin de la función numero_sesion */

    /**
     * @METHOD crear_sesion
     *
     * Crea una nueva sesión en la base de datos.
     * @PARAM usuario_aplicativo
     * @PARAM nivel_acceso
     * @PARAM expiracion
     * @PARAM conexion_id
     *
     * @return boolean
     * @access public
     */
    function crearSesion() {
    	
        $saml_lib_path = '/var/simplesamlphp/lib/_autoload.php';
		
		require_once ($saml_lib_path);
		
		// $aplication_base_url = 'http://10.20.0.38/splocal/';
		$aplication_base_url = $this->hostSSO.$this->site.'/';
		$source = $this->SPSSO; // Fuente de autenticación definida en el authsources del SP
		
		$as = new SimpleSAML_Auth_Simple ( $source ); // Se pasa como parametro la fuente de autenticación
		
		$login_params = array (
				'ReturnTo' => $aplication_base_url . 'index.php' 
		);
		
		$as->requireAuth ( $login_params );
		$atributos = $as->getAttributes();
		
		return $atributos;
    }

    // Fin del método crear_sesion

    /**
     *
     * @name terminar_sesion_expirada
     * @return void
     * @access public
     */
    function terminarSesionExpirada() {

        $cadenaSql = $cadenaSql = $this->miSql->getCadenaSql("borrarSesionesExpiradas");

        return !$this->miConexion->ejecutarAcceso($cadenaSql);
    }

    // Fin del método terminar_sesion_expirada

    /**
     *
     * @name terminar_sesion
     * @return boolean
     * @access public
     */
    function terminarSesion($sesion) {
    	
    	$saml_lib_path = '/var/simplesamlphp/lib/_autoload.php';
    	
    	require_once ($saml_lib_path);
    	
    	// $aplication_base_url = 'http://10.20.0.38/splocal/';
    	$aplication_base_url = $this->hostSSO.$this->site.'/';
    	$source = $this->SPSSO; // Fuente de autenticación definida en el authsources del SP
    	
    	$auth = new SimpleSAML_Auth_Simple ( $source ); // Se pasa como parametro la fuente de autenticación
    	
    	$auth->logout ( $aplication_base_url . 'index.php' );
    	
    	return true;
    }
    
    // Fin del método terminar_sesion

}

?>
