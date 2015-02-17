<?
/*
 ############################################################################
#    UNIVERSIDAD DISTRITAL Francisco Jose de Caldas                        #
#    Copyright: Vea el archivo LICENCIA.txt que viene con la distribucion  #
############################################################################
*/
/***************************************************************************
 * @name          pgsql.class.php
* @author        Karen Palacios
* @revision      Última revisión 26 de Octubre de 2012
****************************************************************************
* @subpackage
* @package	clase
* @copyright
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link			http://computo.udistrital.edu.co
* @description  Esta clase esta disennada para administrar todas las tareas
*               relacionadas con la base de datos POSTGRESQL.
*
******************************************************************************/


/*****************************************************************************
 *Atributos
*
*@access private
*@param  $servidor
*		URL del servidor de bases de datos.
*@param  $db
*		Nombre de la base de datos
*@param  $usuario
*		Usuario de la base de datos
*@param  $clave
*		Clave de acceso al servidor de bases de datos
*@param  $enlace
*		Identificador del enlace a la base de datos
*@param  $dbms
*		Nombre del DBMS POSTGRES
*@param  $cadena_sql
*		Clausula SQL a ejecutar
*@param  $error
*		Mensaje de error devuelto por el DBMS
*@param  $numero
*		Número de registros a devolver en una consulta
*@param  $conteo
*		Número de registros que existen en una consulta
*@param  $registro
*		Matriz para almacenar los resultados de una búsqueda
*@param  $campo
*		Número de campos que devuelve una consulta
*TO DO    	Implementar la funcionalidad en DBMS POSTGRESQL
*******************************************************************************/

/*****************************************************************************
 *Métodos
*
*@access public
*
* @name db_admin
*	 Constructor. Define los valores por defecto
* @name especificar_db
*	 Especifica a través de código el nombre de la base de datos
* @name especificar_usuario
*	 Especifica a través de código el nombre del usuario de la DB
* @name especificar_clave
*	 Especifica a través de código la clave de acceso al servidor de DB
* @name especificar_servidor
*	 Especificar a través de código la URL del servidor de DB
* @name especificar_dbms
*	 Especificar a través de código el nombre del DBMS
* @name especificar_enlace
*	 Especificar el recurso de enlace a la DBMS
* @name conectar_db
*	 Conecta a un DBMS
* @name probar_conexion
*	 Con la cual se realizan acciones que prueban la validez de la conexión
* @name desconectar_db
*	 Libera la conexion al DBMS
* @name ejecutar_acceso_db
*	 Ejecuta clausulas SQL de tipo INSERT, UPDATE, DELETE
* @name obtener_error
*	 Devuelve el mensaje de error generado por el DBMS
* @name obtener_conteo_dbregistro_db
*	 Devuelve el número de registros que tiene una consulta
* @name registro_db
*	 Ejecuta clausulas SQL de tipo SELECT
* @name getRegistroDb
*	 Devuelve el resultado de una consulta como una matriz bidimensional
* @name obtener_error
*	 Realiza una consulta SQL y la guarda en una matriz bidimensional
*
******************************************************************************/

class pgsql implements Conector
{
	/*** Atributos: ***/
	/**
	 *
	 * @access privado
	 */
	private $servidor;
	private $puerto;
	private $db;
	private $usuario;
	private $clave;
	private $enlace;
	private $dbsys;
	private $cadena_sql;
	private $error;
	private $numero;
	private $conteo;
	private $registro;
	private $campo;
	private $charset='utf8';//codificacion php

	/*** Fin de sección Atributos: ***/

	/**
	 * @name especificar_db
	 * @param string nombre_db
	 * @return void
	 * @access public
	 */

	function especificar_db( $nombre_db )
	{
		$this->db = $nombre_db;
	} // Fin del método especificar_db

	/**
	 * @name especificar_usuario
	 * @param string usuario_db
	 * @return void
	 * @access public
	 */
	function especificar_usuario( $usuario_db )
	{
		$this->usuario = $usuario_db;
	} // Fin del método especificar_usuario


	/**
	 * @name especificar_clave
	 * @param string nombre_db
	 * @return void
	 * @access public
	 */
	function especificar_clave( $clave_db )
	{
		$this->clave = $clave_db;
	} // Fin del método especificar_clave

	/**
	 *
	 * @name especificar_servidor
	 * @param string servidor_db
	 * @return void
	 * @access public
	 */
	function especificar_servidor( $servidor_db )
	{
		$this->servidor = $servidor_db;
	} // Fin del método especificar_servidor

	/**
	 *
	 * @name especificar_dbms
	 *@param string dbms
	 * @return void
	 * @access public
	 */

	function especificar_dbsys( $sistema )
	{
		$this->dbsys = $sistema;

	} // Fin del método especificar_dbsys

	/**
	 *
	 * @name especificar_enlace
	 *@param resource enlace
	 * @return void
	 * @access public
	 */

	function especificar_enlace($enlace )
	{
		if(is_resource($enlace))
		{
			$this->enlace = $enlace;
		}
	} // Fin del método especificar_enlace


	/**
	 *
	 * @name obtener_enlace
	 * @return void
	 * @access public
	 */

	function getEnlace()
	{
		return $this->enlace;

	} // Fin del método obtener_enlace


	/**
	 *
	 * @name conectar_db
	 * @return void
	 * @access public
	 */
	function conectar_db()
	{
		$this->enlace=pg_connect("host=".$this->servidor." port=".$this->puerto." dbname=".$this->db." user=".$this->usuario." password=".$this->clave);

		if($this->enlace){
			pg_set_client_encoding($this->enlace,$this->charset);//linea de codificacion de caracteres.
			return $this->enlace;

		}
		else
		{
			$this->error = "PGSQL: Imposible conectar a la base de datos.";
			return false;
		}


	} // Fin del método conectar_db

	/**
	 *
	 * @name probar_conexion
	 * @return void
	 * @access public
	 */
	function probar_conexion()
	{

		if($this->enlace==TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}


	} // Fin del método probar_conexion

	function logger($configuracion,$id_usuario,$evento)
	{
		$this->cadena_sql = "INSERT INTO ";
		$this->cadena_sql.= "".$configuracion["prefijo"]."logger ";
		$this->cadena_sql.= "( ";
		$this->cadena_sql.= "`id_usuario` ,";
		$this->cadena_sql.= " `evento` , ";
		$this->cadena_sql.= "`fecha`  ";
		$this->cadena_sql.= ") ";
		$this->cadena_sql.= "VALUES (";
		$this->cadena_sql.= $id_usuario."," ;
		$this->cadena_sql.= "'".$evento."'," ;
		$this->cadena_sql.= "'".time()."'" ;
		$this->cadena_sql.=")";
		//echo $this->cadena_sql;
		$this->ejecutar_acceso_db($this->cadena_sql);
		unset($this->db_sel);
		return TRUE;

	}


	/**
	 *
	 * @name desconectar_db
	 * @param resource enlace
	 * @return void
	 * @access public
	 */
	function desconectar_db()
	{
		mysql_close($this->enlace);

	} //Fin del método desconectar_db


	/**
	 * @name ejecutar_acceso_db
	 * @param string cadena_sql
	 * @param string conexion_id
	 * @return boolean
	 * @access private
	 */

	private function ejecutar_acceso_db($cadena_sql)
	{

		if(!pg_query($this->enlace,$cadena_sql))
		{
			$this->error= pg_last_error($this->enlace);
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	/**
	 * @name obtener_error
	 * @param string cadena_sql
	 * @param string conexion_id
	 * @return boolean
	 * @access public
	 */

	function obtener_error()
	{

		return $this->error;

	}//Fin del método obtener_error

	/**
	 * @name registro_db
	 * @param string cadena_sql
	 * @param int numero
	 * @return boolean
	 * @access public
	 */
	function registro_db($cadena_sql,$numero=0)
	{
		if(!is_resource($this->enlace))
		{
			return FALSE;
		}

		@$busqueda=pg_query($this->enlace,$cadena_sql);
		if($busqueda)
		{
			unset($this->registro);
			@$this->campo = pg_num_fields($busqueda);
			@$this->conteo = pg_num_rows($busqueda);


			if($numero==0){
					
				$numero=$this->conteo;
			}

			for($j=0; $j<$numero; $j++){
				$salida = pg_fetch_array($busqueda);

					
				if($j==0){
					$this->keys=array_keys($salida);
					$i=0;
					foreach($this->keys as $clave=>$valor){
						if(is_string($valor)){
							$this->claves[$i++]=$valor;
						}
					}
				}
					
				for($un_campo=0; $un_campo<$this->campo; $un_campo++){
					$this->registro[$j][$un_campo] = $salida[$un_campo];
					$this->registro[$j][$this->claves[$un_campo]] = $salida[$un_campo];
				}
			}
			@pg_free_result($busqueda);
			return $this->conteo;

		}
		else
		{
			unset($this->registro);
			//echo "<br/>".$cadena_sql;
			$this->error =pg_last_error($this->enlace);
			return 0;
		}

	}// Fin del método registro_db

	/**Elimina espacios en blanco
	 * @name trim_value
	* @param string $value
	* @return array
	* @access public
	*/
	function trim_value(&$value){
		$value = trim($value);
	}

	/**
	 * @name getRegistroDb
	 * @return registro []
	 * @access public
	 */

	function getRegistroDb()
	{
		if(isset($this->registro))
		{
			return $this->registro;
		}
	}//Fin del método getRegistroDb


	/**
	 * @name obtener_conteo_db
	 * @return int conteo
	 * @access public
	 */
	function getConteo()
	{
		return $this->conteo;

	}//Fin del método obtener_conteo_db

	function ultimo_insertado($enlace="")
	{
		return pg_last_oid($enlace);
	}

	/**
	 * @name transaccion
	 * @return boolean resultado
	 * @access public
	 */
	function transaccion($insert,$delete)
	{

		$this->instrucciones=count($insert);

		for($contador=0;$contador<$this->instrucciones;$contador++)
		{
			/*echo $insert[$contador];*/
			$acceso=$this->ejecutar_acceso_db($insert[$contador]);

			if(!$acceso)
			{

				for($contador_2=0;$contador_2<$this->instrucciones;$contador_2++)
				{
					@$acceso=$this->ejecutar_acceso_db($delete[$contador_2]);
					/*echo $delete[$contador_2]."<br>";*/
				}
				return FALSE;
					
			}

		}
		return TRUE;

	}//Fin del método transaccion




	/**
	 * @name db_admin
	 *
	 */
	function __construct($registro)
	{
		$this->servidor = $registro["dbdns"];
		$this->db = $registro["dbnombre"];
		$this->puerto = isset($registro['dbpuerto'])?$registro['dbpuerto']:5432;
		$this->usuario = $registro["dbusuario"];
		$this->clave = $registro["dbclave"];
		$this->dbsys = $registro["dbsys"];


		$this->enlace=$this->conectar_db();

	}//Fin del método db_admin

	//F

	private function ejecutar_busqueda($cadena_sql, $numeroRegistros=0)
	{
		$this->registro_db($cadena_sql,$numeroRegistros);
		$registro=$this->getRegistroDb();
		return $registro;
	}


	/*function vaciar_temporales($configuracion,$sesion)
	 {
	$this->esta_sesion=$sesion;
	$this->cadena_sql="DELETE ";
	$this->cadena_sql.="FROM ";
	$this->cadena_sql.=$configuracion["prefijo"]."registrado_borrador ";
	$this->cadena_sql.="WHERE ";
	$this->cadena_sql.="identificador<".(time()-3600);
	$this->ejecutar_acceso_db($this->cadena_sql);

	}*/

	//Funcion para preprocesar la creacion de clausulas sql;
	function limpiarVariables($variables)
	{
		if(is_array($variables))
		{
			$dimcount = 1;
			if (is_array(reset($variables)))
			{
				$dimcount++;
					
			}


			if($dimcount==1)
			{
					

				foreach ($variables as $key => $value)
				{
					$variables[$key]=pg_escape_string($value);
				}
			}
		}
		else
		{
			$variables=pg_escape_string($variables);
		}

		return $variables;
	}



	function tratarCadena($cadena){

		$cadena=str_replace("<AUTOINCREMENT>", "DEFAULT", $cadena);
		return $cadena;
	}



	function ejecutarAcceso($cadena_sql,$tipo="", $numeroRegistros=0)
	{
		if(!is_resource($this->enlace) && $this->enlace==""){
			error_log("NO HAY ACCESO A LA BASE DE DATOS!!!");
			return FALSE;
		}

		$cadena_sql=$this->tratarCadena($cadena_sql);

		if($tipo=="busqueda"){
			$esteRegistro=$this->ejecutar_busqueda($cadena_sql,$numeroRegistros);
			if(isset($this->configuracion["debugMode"])
					&&$this->configuracion["debugMode"]==1
					&&$esteRegistro==false){
				error_log ("El registro esta vacio!!! ".$cadena_sql);
			}

			return $esteRegistro;
		}else{
			$resultado=$this->ejecutar_acceso_db($cadena_sql);
			return $resultado;
		}
	}

	function obtenerCadenaListadoTablas($variable){
		return "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public';";
	}

        function getServidor()
	{
		return $this->servidor;

	}
        function getPuerto()
	{
		return $this->puerto;

	}
        function getDB()
	{
		return $this->db;

	}
        function getUsuario()
	{
		return $this->usuario;

	}
        function getClave()
	{
		return $this->clave;

	}


}//Fin de la clase db_admin

?>
