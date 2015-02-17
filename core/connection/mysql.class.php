<?php
/***************************************************************************
 * SARA
* Copyright (c) 2013
* UNIVERSIDAD DISTRITAL Francisco José de Caldas
*
****************************************************************************/


//IMPORTANTE
//Cada base de datos MYSQL que este registrada en el sistema debe tener un nombre de usuario diferente
//Se recomienda que se manejen diferentes perfiles por cada subsistema

class mysql implements Conector
{
	/*** Atributos: ***/
	/**
	 *
	 * @access privado
	 */
	var $servidor;
	var $db;
	var $usuario;
	var $clave;
	var $enlace;
	var $dbsys;
	var $cadena_sql;
	var $error;
	var $numero;
	var $conteo;
	var $registro;
	var $campo;


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
	 * @return voidreturn new $db($configuracion);
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


		$this->enlace=mysqli_connect($this->servidor, $this->usuario, $this->clave);
		
		
		if($this->enlace){

			$base=mysqli_select_db($this->enlace, $this->db);
			if($base){
				return $this->enlace;
			}else{
				$this->error=mysqli_errno();
			}


		}else{
			
			$this->error = mysqli_errno();
			
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
		mysqli_close($this->enlace);

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
		if(!$this->enlace->query($cadena_sql))
		{
			$this->error= $this->enlace->errno;
			return false;
		}
		else
		{
			return true;
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
		if(!is_object($this->enlace)){
			error_log("NO HAY ACCESO A LA BASE DE DATOS!!!");
			return NULL;
		}
		
		$busqueda=$this->enlace->query($cadena_sql);
		
		if($busqueda){
			
			unset($this->registro);
			$this->campo = $busqueda->field_count;
			$this->conteo = $busqueda->num_rows;
			
			if($numero==0){

				$numero=$this->conteo;
			}

			for($j=0; $j<$numero; $j++){
				$salida = $busqueda->fetch_array(MYSQLI_BOTH);

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
			$busqueda->free();
			return $this->conteo;
		}else
		{
			unset($this->registro);
			$this->error =mysqli_error();
			return 0;
		}
	}// Fin del método registro_db


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
		}else{

			return false;
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
		if($enlace!=""){
			return mysqli_insert_id($enlace);
		}else{
			return mysqli_insert_id($this->enlace);
		}
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
                if(is_string($registro)){
                    $registro = array_map('trim', $registro);                    
                }		
		
		$this->servidor = $registro["dbdns"];
		$this->db = $registro["dbnombre"];
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


	function vaciar_temporales($configuracion,$sesion)
	{
		$this->esta_sesion=$sesion;
		$this->cadena_sql="DELETE ";
		$this->cadena_sql.="FROM ";
		$this->cadena_sql.=$configuracion["prefijo"]."registrado_borrador ";
		$this->cadena_sql.="WHERE ";
		$this->cadena_sql.="identificador<".(time()-3600);
		$this->ejecutar_acceso_db($this->cadena_sql);

	}

	//Funcion para preprocesar la creacion de clausulas sql;
	function limpiarVariables($variables)
	{
		if(is_array($variables))
		{
			foreach ($variables as $key => $value)
			{
				$variables[$key]=mysqli_real_escape_string($value);
			}
		}
		else
		{
			$variables=mysqli_real_escape_string($variables);
		}

		return $variables;
	}



	function tratarCadena($cadena){

		$cadena=str_replace("<AUTOINCREMENT>", "NULL", $cadena);



		return $cadena;
	}


	//Funcion para el acceso a las bases de datos

	function ejecutarAcceso($cadena_sql,$tipo="",$numeroRegistros=0)
	{
		if(!is_object($this->enlace)){
			error_log("NO HAY ACCESO A LA BASE DE DATOS!!!");
			return "error";
		}

		$cadena_sql=$this->tratarCadena($cadena_sql);

		if($tipo=="busqueda"){
			$esteRegistro=$this->ejecutar_busqueda($cadena_sql, $numeroRegistros);
			return $esteRegistro;
		}else{
			$resultado=$this->ejecutar_acceso_db($cadena_sql);
			return $resultado;
		}
	}

	function obtenerCadenaListadoTablas($variable){
		return "SHOW TABLES FROM ".$variable;
	}





}//Fin de la clase db_admin

?>
