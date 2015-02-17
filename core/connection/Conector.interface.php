<?php


 interface Conector{
 	
 	/**
 	 *
 	 * @name obtener_enlace
 	 * @return void
 	 * @access public
 	 */
 	
 	function getEnlace();
 	
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
 	
 	function logger($configuracion,$id_usuario,$evento);
 	
 	/**
 	 *
 	 * @name desconectar_db
 	 * @param resource enlace
 	 * @return void
 	 * @access public
 	 */
 	function desconectar_db();
 	
 	/**
 	 * @name ejecutar_acceso_db
 	 * @param string cadena_sql
 	 * @param string tipo
 	 * Tipo de acceso a realizar. Puede ser una consulta (búsqueda), una definición de datos (ddl)
 	 * o insercion, borrado y atualización (accion)
 	 * @return Array|boolean|NULL El registro en caso de éxito, false en caso de no tener resultados, NULL en caso de error de acceso.
 	 * @access public
 	 */
 	
 	function ejecutarAcceso($cadena_sql,$tipo="",$numeroRegistros=0);
 	
 	/**
 	 * @name obtener_error
 	 * @param string cadena_sql
 	 * @param string conexion_id
 	 * @return boolean
 	 * @access public
 	 */
 	
 	function obtener_error();
 	/**
 	 * @name registro_db
 	 * @param string cadena_sql
 	 * @param int numero
 	 * @return boolean
 	 * @access public
 	 */
 	
 	function registro_db($cadena_sql,$numero=0);
 	
 	
 	
 	/**
 	 * @name getRegistroDb
 	 * @return registro []
 	 * @access public
 	 */
 	
 	function getRegistroDb();
 	/**
 	 * @name obtener_conteo_db
 	 * @return int conteo
 	 * @access public
 	 */
 	function getConteo();
 	
 	function obtenerCadenaListadoTablas($variable);
 	
 	function ultimo_insertado($enlace="");
 	
 	/**
 	 * @name transaccion
 	 * @return boolean resultado
 	 * @access public
 	 */
 	function transaccion($insert,$delete);
 	
 	
 	function limpiarVariables($variables);
 	
 	/**
 	 * @name tratarCadena
 	 * @return boolean resultado
 	 * @access public
 	 */
 	function tratarCadena($cadena);
 	
 	/**
 	 * @name especificar_db
 	 * @param string nombre_db
 	 * @return void
 	 * @access public
 	 */
 	
 	function especificar_db( $nombre_db );
 	
 	/**
 	 * @name especificar_usuario
 	 * @param string usuario_db
 	 * @return void
 	 * @access public
 	*/
 	function especificar_usuario( $usuario_db );
 	
 	/**
 	 * @name especificar_clave
 	 * @param string nombre_db
 	 * @return void
 	 * @access public
 	*/
 	function especificar_clave( $clave_db );
 	
 	/**
 	 *
 	 * @name especificar_servidor
 	 * @param string servidor_db
 	 * @return void
 	 * @access public
 	*/
 	function especificar_servidor( $servidor_db );
 	/**
 	 *
 	 * @name especificar_dbms
 	 *@param string dbms
 	 * @return void
 	 * @access public
 	*/
 	
 	function especificar_dbsys( $sistema );
 	
 	/**
 	 *
 	 * @name especificar_enlace
 	 *@param resource enlace
 	 * @return void
 	 * @access public
 	*/
 	
 	function especificar_enlace($enlace );
 	
 	
 }


?>