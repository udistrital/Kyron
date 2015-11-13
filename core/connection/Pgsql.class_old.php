<?php

/**
 * UNIVERSIDAD DISTRITAL Francisco Jose de Caldas 
 * Copyright: Vea el archivo LICENCIA.txt que viene con la distribucion
 */

/**
 * Esta clase esta disennada para administrar todas las tareas
 * relacionadas con la base de datos POSTGRESQL.
 *
 * @name pgsql.class.php
 * @author Edwin Mauricio Sánchez, PAulo César Coronado, Karen Palacios
 * @version Última revisión 24 de septiembre de 2014
 * @subpackage
 *
 *
 *
 *
 * @package clase
 * @copyright
 *
 *
 *
 *
 * @version 1.0
 * @author Paulo Cesar Coronado
 * @link http://computo.udistrital.edu.co
 *      
 */

/**
 *
 *
 *
 *
 *
 * Atributos
 *
 * @access private
 * @param $servidor URL
 *            del servidor de bases de datos.
 * @param $db Nombre
 *            de la base de datos
 * @param $usuario Usuario
 *            de la base de datos
 * @param $clave Clave
 *            de acceso al servidor de bases de datos
 * @param $enlace Identificador
 *            del enlace a la base de datos
 * @param $dbms Nombre
 *            del DBMS POSTGRES
 * @param $cadenaSql Clausula
 *            SQL a ejecutar
 * @param $error Mensaje
 *            de error devuelto por el DBMS
 * @param $numero Número
 *            de registros a devolver en una consulta
 * @param $conteo Número
 *            de registros que existen en una consulta
 * @param $registro Matriz
 *            para almacenar los resultados de una búsqueda
 * @param $campo Número
 *            de campos que devuelve una consulta
 *            TO DO Implementar la funcionalidad en DBMS POSTGRESQL
 *            *****************************************************************************
 */

/**
 *
 *
 *
 *
 *
 * Métodos
 *
 * @access public
 *        
 * @name db_admin
 *       Constructor. Define los valores por defecto
 * @name especificar_db
 *       Especifica a través de código el nombre de la base de datos
 * @name especificar_usuario
 *       Especifica a través de código el nombre del usuario de la DB
 * @name especificar_clave
 *       Especifica a través de código la clave de acceso al servidor de DB
 * @name especificar_servidor
 *       Especificar a través de código la URL del servidor de DB
 * @name especificar_dbms
 *       Especificar a través de código el nombre del DBMS
 * @name especificar_enlace
 *       Especificar el recurso de enlace a la DBMS
 * @name conectar_db
 *       Conecta a un DBMS
 * @name probar_conexion
 *       Con la cual se realizan acciones que prueban la validez de la conexión
 * @name desconectar_db
 *       Libera la conexion al DBMS
 * @name ejecutar_acceso_db
 *       Ejecuta clausulas SQL de tipo INSERT, UPDATE, DELETE
 * @name obtener_error
 *       Devuelve el mensaje de error generado por el DBMS
 * @name obtener_conteo_dbregistro_db
 *       Devuelve el número de registros que tiene una consulta
 * @name registro_db
 *       Ejecuta clausulas SQL de tipo SELECT
 * @name getRegistroDb
 *       Devuelve el resultado de una consulta como una matriz bidimensional
 * @name obtener_error
 *       Realiza una consulta SQL y la guarda en una matriz bidimensional
 *      
 */
class Pgsql extends ConectorDb {
    
    /**
     * * Atributos: **
     */
    /**
     *
     * @access privado
     */
    // codificacion php
    private $charset = 'utf8';
    
    /**
     * * Fin de sección Atributos: **
     */
    
    /**
     *
     * @name conectar_db
     * @return void
     * @access public
     */
    function conectar_db() {
        
        $this->enlace = pg_connect ( "host=" . $this->servidor . " port=" . $this->puerto . " dbname=" . $this->db . " user=" . $this->usuario . " password=" . $this->clave );
        
        if ($this->enlace) {
            // linea de codificacion de caracteres.
            pg_set_client_encoding ( $this->enlace, $this->charset );
            
            //Utilizar un esquema específico para toda la sesión
            if($this->dbesquema!=''){
            	$this->ejecutar_acceso_db('SET search_path TO '.$this->dbesquema);
            }
            return $this->enlace;
        } else {
            $this->error = "PGSQL: Imposible conectar a la base de datos.";
            return false;
        }
    
    }
    // Fin del método conectar_db
    
    /**
     *
     * @name probar_conexion
     * @return void
     * @access public
     */
    function probar_conexion() {
        
        return $this->enlace;
    
    }
    // Fin del método probar_conexion
    
    /**
     *
     * @name desconectar_db
     * @param
     *            resource enlace
     * @return void
     * @access public
     */
    function desconectar_db() {
        
        mysql_close ( $this->enlace );
    
    }
    // Fin del método desconectar_db
    function ejecutarAcceso($cadena, $tipo = "", $numeroRegistros = 0) {
        
        if (! is_resource ( $this->enlace ) && $this->enlace == "") {
            error_log ( "NO HAY ACCESO A LA BASE DE DATOS!!!" );
            return FALSE;
        }
        
        $cadena = $this->tratarCadena ( $cadena );
        
        if ($tipo == "busqueda") {
            $esteRegistro = $this->ejecutar_busqueda ( $cadena, $numeroRegistros );
            if (isset ( $this->configuracion ["debugMode"] ) && $this->configuracion ["debugMode"] == 1 && ! $esteRegistro) {
                error_log ( "El registro esta vacio!!! " . $cadena );
            }
            
            return $esteRegistro;
        } else {
            return $this->ejecutar_acceso_db ( $cadena );
        }
    
    }
    
    /**
     *
     * @name obtener_error
     * @param
     *            string cadena_sql
     * @param
     *            string conexion_id
     * @return boolean
     * @access public
     */
    function obtener_error() {
        
        return $this->error;
    
    }
    // Fin del método obtener_error
    
    /**
     *
     * @name registro_db
     * @param
     *            string cadena_sql
     * @param
     *            int numero
     * @return boolean
     * @access public
     */
    function registro_db($cadena, $numeroRegistros = 0) {
        
        if (! is_resource ( $this->enlace )) {
            return FALSE;
        }
        /**
         * La variable $numeroRegistros determina cuantos registros debe regresar la consulta.
         * Si es 0 indica que debe retornar todos los registros.
         */
        
        @$busqueda = pg_query ( $this->enlace, $cadena );
        if ($busqueda) {
            return $this->procesarResultado ( $busqueda, $numeroRegistros );
        } else {
            unset ( $this->registro );
            $this->error = pg_last_error ( $this->enlace );
            return 0;
        }
    
    }
    // Fin del método registro_db
    
    private function procesarResultado($busqueda, $numeroRegistros) {
        unset ( $this->registro );
        
        @$this->campo = pg_num_fields ( $busqueda );
        @$this->conteo = pg_num_rows ( $busqueda );
        
        if ($numeroRegistros == 0) {
            
            $numeroRegistros = $this->conteo;
        }
        
        $salida = pg_fetch_array ( $busqueda );
        
        if ($salida) {
            
            $this->keys = array_keys ( $salida );
            $i = 0;
            
            /**
             * Obtener el nombre de las columnas
             */
            foreach ( $this->keys as $clave => $valor ) {
                if (is_string ( $valor )) {
                    $this->claves [$i] = $valor;
                    $i ++;
                }
            }
            
            // /Recorrer el resultado y guardarlo en un arreglo
            $j=0;
            do{
                
                for($unCampo = 0; $unCampo < $this->campo; $unCampo ++) {
                    $this->registro [$j] [$unCampo] = $salida [$unCampo];
                    $this->registro [$j] [$this->claves [$unCampo]] = $salida [$unCampo];
                }
                $j++;
                
            }while($salida = pg_fetch_array ( $busqueda ));
            @pg_free_result ( $busqueda );
            
            return $this->conteo;
        }
        
        return false;
    }
    
    function obtenerCadenaListadoTablas($variable = '') {
        
        return "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public';";
    
    }
    
    /**
     * /**
     *
     * @name transaccion
     * @return boolean resultado
     * @access public
     */
    function transaccion($clausulas) {
        
        $acceso = true;
        
        pg_query ( $this->enlace, 'BEGIN' );
        $this->instrucciones = count ( $clausulas );
        for($contador = 0; $contador < $this->instrucciones; $contador ++) {
            $acceso &= $this->ejecutar_acceso_db ( $clausulas [$contador] );
        }
        
        if ($acceso) {
            $resultado = pg_query ( $this->enlace, 'COMMIT' );
        } else {
            pg_query ( $this->enlace . 'ROLLBACK' );
            $resultado = false;
        }
        
        return $resultado;
    
    }
    // Fin del método transaccion
    
    /**
     * Funcion para preprocesar la creacion de clausulas sql;
     */
    function limpiarVariables($variables) {
        
        if (is_array ( $variables )) {
            $dimcount = 1;
            if (is_array ( reset ( $variables ) )) {
                $dimcount ++;
            }
            
            if ($dimcount == 1) {
                
                foreach ( $variables as $key => $value ) {
                    $variables [$key] = pg_escape_string ( $value );
                }
            }
        } else {
            $variables = pg_escape_string ( $variables );
        }
        
        return $variables;
    
    }
    
    /**
     *
     * @name db_admin
     *      
     */
    function __construct($registro) {
        
        $this->servidor = $registro ["dbdns"];
        $this->db = $registro ["dbnombre"];
        $this->puerto = isset ( $registro ['dbpuerto'] ) ? $registro ['dbpuerto'] : 5432;
        $this->usuario = $registro ["dbusuario"];
        $this->clave = $registro ["dbclave"];
        $this->dbsys = $registro ["dbsys"];
        $this->dbesquema = isset ( $registro ['dbesquema'])?$registro ['dbesquema']:''; 
        
        $this->enlace = $this->conectar_db ();
    
    }
    // Fin del método db_admin
    private function ejecutar_busqueda($cadena, $numeroRegistros = 0) {
        
        $this->registro_db ( $cadena, $numeroRegistros );
        return $this->getRegistroDb ();
    
    }
    
    /**
     *
     * @name ejecutar_acceso_db
     * @param
     *            string cadena_sql
     * @param
     *            string conexion_id
     * @return boolean
     * @access private
     */
    private function ejecutar_acceso_db($cadena) {
        
        if (!@pg_query ( $this->enlace, $cadena )) {
            $this->error = pg_last_error ( $this->enlace );
            return FALSE;            
        } else {
            return TRUE;
        }
    
    }
    
    function tratarCadena($cadena) {
        
        return str_replace ( "<AUTOINCREMENT>", "DEFAULT", $cadena );
    
    }
    
    /**
     * Elimina espacios en blanco
     *
     * @name trim_value
     * @param string $value            
     * @return array
     * @access public
     */
    function trim_value(&$value) {
        
        $value = trim ( $value );
    
    }

}
// Fin de la clase db_admin

?>
