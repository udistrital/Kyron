<?php

require_once("core/manager/Configurador.class.php");
require_once("core/builder/builderSql.class.php");


class ArmadorPagina{

	var $miConfigurador;
	var $generadorClausulas;
	var $host;
	var $sitio;
	var $raizDocumentos;
	var $bloques;

	var $seccionesDeclaradas;

	function __construct(){

		$this->miConfigurador=Configurador::singleton();
		$this->generadorClausulas=BuilderSql::singleton();
		$this->host=$this->miConfigurador->getVariableConfiguracion("host");
		$this->sitio=$this->miConfigurador->getVariableConfiguracion("site");
		$this->raizDocumentos=$this->miConfigurador->getVariableConfiguracion("raizDocumento");
	}

	function armarHTML($registroBloques){

		$this->bloques=$registroBloques;

		if($this->miConfigurador->getVariableConfiguracion("cache")) {

			//De forma predeterminada las paginas del aplicativo no tienen cache
			header("Cache-Control: cache");
			// header("Expires: Sat, 20 Jun 1974 10:00:00 GMT");
		}else
		{
			if(isset($_REQUEST['opcion']) && $_REQUEST['opcion'] == 'mostrarMensaje')
			{
				
			}else
			{
				header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
				header("Cache-Control: no-store, no-cache, must-revalidate");
				header("Cache-Control: post-check=0, pre-check=0", false);
				header("Pragma: no-cache");
			}
		}

		$this->raizDocumento=$this->miConfigurador->getVariableConfiguracion("raizDocumento");

		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> ';
		echo "\n<html lang='es'>\n";
		$this->encabezadoPagina();
		$this->cuerpoPagina();
		echo "</html>\n";
	}

	private function encabezadoPagina(){
		$htmlPagina="<head>\n";
		$htmlPagina.="<title>".$this->miConfigurador->getVariableConfiguracion("nombreAplicativo")."</title>\n";
		$htmlPagina.="<meta http-equiv='Content-Type' content='text/html; charset=utf-8' >\n";
		$htmlPagina.="<link rel='shortcut icon' href='".$this->host.$this->sitio."/"."favicon.ico' >\n";
		echo $htmlPagina;

		//Incluir estilos
		include_once("theme/basico/Estilo.php");

		// Enlazar los estilos definidos en cada bloque
		foreach($this->bloques as $unBloque){
			$this->incluirEstilosBloque($unBloque);
		}

		//Funciones javascript globales del aplicativo
		include_once("plugin/scripts/Script.php");

		// Insertar las funciones js definidas en cada bloque
		foreach($this->bloques as $unBloque){
			$this->incluirFuncionesBloque($unBloque);
		}

		// Para las páginas que requieren jquery
		if(isset($_REQUEST["jquery"])){
				
			$this->incluirFuncionReady($unBloque);
		}

		echo "</head>\n";
	}



	private function cuerpoPagina() {

		$this->seccionesDeclaradas=array(0,0,0,0,0);

		foreach($this->bloques as $unBloque){

			$posicion=ord($unBloque["seccion"])-65;
			$this->seccionesDeclaradas[$posicion]=$unBloque["seccion"];
		}

		echo "<body>\n";
		echo "<div id='marcoGeneral'>\n";

		if(in_array("A", $this->seccionesDeclaradas,true)){
			$this->armarSeccionAmplia("A");
		};

		if(in_array("B", $this->seccionesDeclaradas,true)){
			$this->armarSeccionLateral("B");
		}
		if(in_array("C", $this->seccionesDeclaradas,true)){
			$this->armarSeccionCentral();
		}
		if(in_array("D", $this->seccionesDeclaradas,true)){
			$this->armarSeccionLateral("D");
		}
		if(in_array("E", $this->seccionesDeclaradas,true)){
			$this->armarSeccionAmplia("E");
		}

		echo "</div>\n";
		echo "</body>\n";

	}


	private function armarSeccionAmplia($seccion){
		//Este tipo de secciones ocupan todo el ancho de la página
		echo "<div id='seccionAmplia'>\n";
		foreach($this->bloques as $unBloque){
			if($unBloque["seccion"]==$seccion){
				$this->incluirBloque($unBloque);
			}
		}
		echo "</div>\n";
	}

	private function armarSeccionLateral($seccion){

		if($seccion=="B"){
			$otraSeccion="D";
		}else{
			$otraSeccion="B";
		}

		//Este tipo de secciones ocupan un ancho variable dependiendo si las otras secciones están declaradas

		//Si ninguna de las otras secciones están declaradas entonces ocupa todo el ancho de la página
		if(!in_array("C", $this->seccionesDeclaradas) && !in_array($otraSeccion, $this->seccionesDeclaradas)){

			echo "<div id='seccionAmplia'>\n";

		}else{
			//Si la otra sección está declarada pero la sección central no, entonces ocupa la mitad de la página

			if(!in_array("C", $this->seccionesDeclaradas) && in_array($otraSeccion, $this->seccionesDeclaradas)){
				echo "<div id='seccionMitad'>\n";
			}else{
				echo "<div id='seccion".$seccion."'>\n";
			}
		}

		foreach($this->bloques as $unBloque){
			if($unBloque["seccion"]==$seccion){
				$this->incluirBloque($unBloque);
			}
		}

		echo "</div>\n";

	}

	private function armarSeccionCentral(){

		//Si las secciones laterales no están definidas entonces la sección central ocupa todo el ancho de la página
            
                
		if(!in_array("B", $this->seccionesDeclaradas,true) && !in_array("D", $this->seccionesDeclaradas,true)){

			echo "<div id='seccionAmplia'>\n";

		}else{
                    
                    

			if((in_array("B", $this->seccionesDeclaradas,true) && !in_array("D", $this->seccionesDeclaradas,true))||
					(!in_array("B", $this->seccionesDeclaradas,true) && in_array("D", $this->seccionesDeclaradas,true))

			){
				echo "<div id='seccionCentralAmpliada'>\n";
			}else{
				echo "<div id='seccionCentral'>\n";
					
			}
		}

		foreach($this->bloques as $unBloque){
			if($unBloque["seccion"]=="C"){
				$this->incluirBloque($unBloque);
			}
		}

		echo "</div>\n";

	}


	private function incluirBloque($unBloque){

		foreach($unBloque as $clave=>$valor){
			$unBloque[$clave]=trim($valor);
		}

		if($unBloque["grupo"]==""){
			$archivo=$this->raizDocumentos."/blocks/".$unBloque["nombre"]."/bloque.php";
		}else{
			$archivo=$this->raizDocumentos."/blocks/".$unBloque["grupo"]."/".$unBloque["nombre"]."/bloque.php";
		}
		include($archivo);
	}

	private function incluirEstilosBloque($unBloque){

		foreach($unBloque as $clave=>$valor){
			$unBloque[$clave]=trim($valor);
		}

		if($unBloque["grupo"]==""){
			$archivo=$this->raizDocumentos."/blocks/".$unBloque["nombre"]."/css/Estilo.php";
		}else{
			$archivo=$this->raizDocumentos."/blocks/".$unBloque["grupo"]."/".$unBloque["nombre"]."/css/Estilo.php";
		}

		if(file_exists($archivo)){
			include_once($archivo);
		}
	}


	private function incluirFuncionesBloque($esteBloque){

		foreach($esteBloque as $clave=>$valor){
			$esteBloque[$clave]=trim($valor);
		}

		if($esteBloque["grupo"]==""){
			$archivo=$this->raizDocumentos."/blocks/".$esteBloque["nombre"]."/script/Script.php";
		}else{
			$archivo=$this->raizDocumentos."/blocks/".$esteBloque["grupo"]."/".$esteBloque["nombre"]."/script/Script.php";
		}

		if(file_exists($archivo)){

			include_once($archivo);
		}
	}

	function incluirFuncionReady($unBloque){
		
		/**
		 * Esta función registra funciones javascript para la página. Tales funciones están declartadas en cada bloque
		 * y pueden venir directamente en un archivo ready.js o procesadas a partir de un archivo ready.php. Depende
		 * del programador decidir cual de las dos opciones (o las dos) implementar. 
		 */

		echo "<script type='text/javascript'>\n";
		echo "$(document).ready(function(){\n";

		foreach($this->bloques as $unBloque){

			foreach($unBloque as $clave=>$valor){
				$unBloque[$clave]=trim($valor);
			}

			if($unBloque["grupo"]==""){
				$archivo=$this->raizDocumentos."/blocks/".$unBloque["nombre"]."/script/ready.js";
				$archivoPHP=$this->raizDocumentos."/blocks/".$unBloque["nombre"]."/script/ready.php";
			}else{
				$archivo=$this->raizDocumentos."/blocks/".$unBloque["grupo"]."/".$unBloque["nombre"]."/script/ready.js";
				$archivoPHP=$this->raizDocumentos."/blocks/".$unBloque["grupo"]."/".$unBloque["nombre"]."/script/ready.php";
			}

			if(file_exists($archivo)){					
				include($archivo);
				echo "\n";					
			}
			
			if(file_exists($archivoPHP)){
				include($archivoPHP);
				echo "\n";
			}
		}
		echo "});\n";
		echo "</script>\n";

	}





	private function armar_no_pagina($seccion,$cadena) {
		$this->la_cadena=$cadena.' AND '.$this->miConfigurador->configuracion["prefijo"].'bloque_pagina.seccion="'.$seccion.'" ORDER BY '.$this->miConfigurador->configuracion["prefijo"].'bloque_pagina.posicion ASC';
		$this->base->registro_db($this->la_cadena,0);
		$this->armar_registro=$this->base->getRegistroDb();
		$this->total=$this->base->obtener_conteo_db();
		if($this->total>0) {


			for($this->contador=0;$this->contador<$this->total;$this->contador++) {

				$this->id_bloque=$this->armar_registro[$this->contador][0];
				$this->incluir=$this->armar_registro[$this->contador][4];
				include($this->miConfigurador->configuracion["raiz_documento"].$this->miConfigurador->configuracion["bloques"]."/".$this->incluir."/bloque.php");


			}


		}
		return TRUE;

	}
}
