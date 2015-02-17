<?php
/**
 * Pagina.class.php
 * 
 *  Implementa el patrón Fachada para el paquete builder.
 */

require_once("core/manager/Configurador.class.php");
require_once("core/builder/builderSql.class.php");
require_once("core/builder/ArmadorPagina.class.php");
require_once("core/builder/ProcesadorPagina.class.php");
include_once("core/crypto/Encriptador.class.php");


class Pagina
{

	var $miConfigurador;

	var $recursoDB;

	var $pagina;
	
	var $generadorClausulas;
	
	var $tipoError;
	
	var $armadorPagina;
	
	var $cripto;


	function __construct()
	{
		$this->miConfigurador=Configurador::singleton();
		
		$this->generadorClausulas=BuilderSql::singleton();
		
		$this->armadorPagina=new ArmadorPagina();
		
		$this->procesadorPagina=new ProcesadorPagina();
		
		$this->cripto=Encriptador::singleton();
		

		/**
		 * El recurso de conexión que utilizan los objetos de esta clase es "configuracion"
		 * y corresponde a la base de datos registrada en el archivo config.inc.php
		*/


	}

	function inicializarPagina($pagina){

		$this->recursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB("configuracion");

		if($this->recursoDB){

			$this->especificar_pagina($pagina);
			
			
			
			//La variable POST formSaraData contiene información codificada
			
			if(isset($_REQUEST["formSaraData"])){
				$cadena=$this->cripto->decodificar_url($_REQUEST["formSaraData"]);
			}
			
			
			if(!isset($_REQUEST['action']))
			{
				return $this->mostrar_pagina();
			}
			else
			{
				
				return $this->procesar_pagina();
			}

		}

		return false;
	}


	function especificar_pagina($nombre){
		$this->pagina=$nombre;
	}



	function mostrar_pagina()
	{
		//1. Buscar los bloques que constituyen la página
		$cadenaSql=$this->generadorClausulas->cadenaSql("bloquesPagina",$this->pagina);		
		if($cadenaSql){
			$registro=$this->recursoDB->ejecutarAcceso($cadenaSql,"busqueda");
			$totalRegistros=$this->recursoDB->getConteo();
			
			if($totalRegistros>0) {
				
				if(isset($registro[0]["parametro"]) && trim($registro[0]["parametro"])!=""){
					
					$parametros=explode("&",trim($registro[0]["parametro"]));
					foreach($parametros as $valor) {
						$elParametro=explode("=",$valor);
						$_REQUEST[$elParametro[0]]=$elParametro[1];					
					}
					
				}
				$this->armadorPagina->armarHTML($registro);				
				return true;
			}else{
				$this->tipoError="paginaSinBloques";
				return false;
			}
		}
		
		
		
	}
	
	function procesar_pagina(){
		
		$this->procesadorPagina->procesarPagina();
		
		return true;
	}
	
	function getError(){
		return $this->tipoError;
	}


}



?>
