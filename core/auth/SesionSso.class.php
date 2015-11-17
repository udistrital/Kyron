<?php

class SesionSSO {

	
	var $miSql;
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
    	$this->sesionUsuario = Sesion::singleton ();
    	$this->configurador = \Configurador::singleton ();
    	$this->site = $this->configurador->getVariableConfiguracion ( "site" );
    	$this->hostSSO = $this->configurador->getVariableConfiguracion ( "hostSSO" );
    	$this->SPSSO = $this->configurador->getVariableConfiguracion ( "SPSSO" );
    }
    
    function setTiempoExpiracion($valor) {
    	
    	$this->sesionUsuario->setSesionExpiracion($valor);
    
    }
    
    function getSesionExpiracion() {
    
    	return $this->sesionUsuario->getSesionExpiracion();
    
    }

    /**
     *
     * @name sesiones Verifica la existencia de una sesion válida en la máquina del cliente
     * @param
     *            string nombre_db
     * @return void
     * @access public
     */
    function verificarSesion($pagina) {

        $resultado = true;
        //if($this->sesionUsuario->getSesionUsuarioId());die;
        // Se eliminan las sesiones expiradas
        //$this->borrarSesionExpirada();
        $resultado = $this->crearSesion();
        
        $resultado = $this->verificarRolesPagina($resultado['perfil'],$pagina);
        
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
		
		$this->sesionUsuario->crearSesion($atributos['usuario'][0]);
		
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
    
    function verificarRolesPagina($perfiles,$pagina){
    	$cadenaSql = $this->sesionUsuario->miSql->getCadenaSql("verificarEnlaceUsuario", $pagina);
    	//Se busca en la tabla _menu_rol_enlace si la página pertenece al perfil.
    	$roles = $this->sesionUsuario->miConexion->ejecutarAcceso($cadenaSql,"busqueda");
    	foreach ($perfiles as $perfil){
    		foreach ($roles as $rol){
    			if($rol[0]==$perfil){
    				return true;
    			}
    		}
    	}
    	return false;
    }

}

?>
