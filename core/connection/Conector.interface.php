<?php

interface Conector {
    /**
     *
     * @name conectar_db
     * @return void
     * @access public
     */
    function conectar_db();
    
    /**
     *
     * @name probar_conexion
     * @return void
     * @access public
     */
    function probar_conexion();
    
    function logger($datosConfiguracion, $idUsuario, $evento);
    
    /**
     *
     * @name desconectar_db
     * @param
     *            resource enlace
     * @return void
     * @access public
     */
    function desconectar_db();
    
    /**
     *
     * @name ejecutar_acceso_db
     * @param
     *            string cadena_sql
     * @param
     *            string tipo
     *            Tipo de acceso a realizar. Puede ser una consulta (búsqueda), una definición de datos (ddl)
     *            o insercion, borrado y atualización (accion)
     * @return Array boolean NULL en caso de éxito, false en caso de no tener resultados, NULL en caso de error de acceso.
     * @access public
     */
    function ejecutarAcceso($cadenaSql, $tipo = "", $numeroRegistros = 0);
    
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
    function obtener_error();
    
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
    function registro_db($cadenaSql, $numero = 0);
    
    function obtenerCadenaListadoTablas($variable);
    
    function ultimo_insertado($enlace = "");
    
    /**
     *
     * @name transaccion
     * @return boolean resultado
     * @access public
     */
    function transaccion($clausulas);
    
    function limpiarVariables($variables);
    
    /**
     *
     * @name tratarCadena
     * @return boolean resultado
     * @access public
     */
    function tratarCadena($cadena);

}

?>