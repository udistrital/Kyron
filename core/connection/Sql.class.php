<?php

include_once("core/manager/Configurador.class.php");


class Sql
{
	
	
	var $miConfigurador;
	
		/**
     * @name sql 
	 * @return void
	 * @access public
	 *@comment Constructor 
	 */
	
	function __construct(){
		$this->miConfigurador=Configurador::singleton();
	}
	
	
	function sql()
	{
		/*Cada DBMS tiene asociado unos delimitadores y un esquema con la arquitectura de datos. 
		
		Las diferentes propiedades se acceden como:
			$propiedad=$this->propiedades_dbms[dbms][propiedad]
		
		TO DO: matriz con otros DBMS para soportarlos.
		*/
			$this->propiedades_dbms = array( 'mysql'=> array('etiqueta'=> 'MySQL 3.x',	'arquitectura'=> 'mysql', 'delimitador'=> ';;;','delimitador_basico'	=> ';;;','comentario' => '#'));
		
	
		
		
		
	}
	
	function limpiarVariables($variable,$conexion){
		
		$recursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);		
		return	$recursoDB->limpiarVariable($variable);
		
	}
	

		/**
     * @name remover_marcas 
	 * @return void
	 * @access public
	 *@comment $archivo pasado por referencia de tal forma que la función modifica su contenido removiendo
	 *                     los comentarios que se encuentren. 
	 */

		function remover_marcas(&$archivo_sql,$dbms)
		{
			
			/*Guardamos en la matriz lineas cada una de las lineas que constituye la arquitectura de la base de datos*/	
			$lineas = explode("\n", $archivo_sql);
			$archivo_sql = "";
			$simbolo=$this->propiedades_dbms[$dbms]['comentario'];
			$contar_lineas = count($lineas);
			
			for($contador = 0; $contador < $contar_lineas; $contador++)
			{
				$this->cadena=trim($lineas[$contador]);
				
				if($this->cadena)
				{
					
				$comparacion=strstr($this->cadena,$simbolo);
				
				 
				}
				else
				{
						$comparacion=TRUE;
					}
				if( !$comparacion )
				{
					//echo $this->cadena.'<br>';
					$archivo_sql .=$this->cadena."\n";
				}
		
			}
		
			unset($lineas);
			return $archivo_sql;
		}/*Fin de la función remover_comentarios*/
		
		
		/**
     * @name rescatar_cadena_sql 
	 * @return void
	 * @access public
	 *@comment Rompe el archivo sql en tantas instrucciones sql como delimitadores existan
	 */
		function rescatar_cadena_sql($sql, $dbms)
		{
			
			$delimitador=$this->propiedades_dbms[$dbms]['delimitador'];
			/*Guarda en una matriz las diferentes sentencias SQL halladas*/
			$instruccion = explode($delimitador, $sql);
			$sql="";
			$contar_lineas = count($instruccion);
			$comentario = FALSE;
			$contador_2=0;
			for($contador = 0; $contador < $contar_lineas; $contador++)
			{
				
				if(strlen($instruccion[$contador])>5)
				{
				$sql[$contador_2]=trim($instruccion[$contador]). "\n";
				$contador_2++;
				//echo $sql[$contador_2];
				}
			
			}			
			
			
			
			return $sql;
	
		}
}
?>
