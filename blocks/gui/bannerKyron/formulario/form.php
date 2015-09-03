<?php
namespace gui\bannerKyron\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Formulario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	
	function __construct($lenguaje, $formulario) {
		
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;		
		
	}
	
	function formulario() {
		
		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		 
		$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
		 
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
		$rutaBloque .= $esteBloque ['grupo'] . '/' . $esteBloque ['nombre'];
		
		// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
		/**
		 * Atributos que deben ser aplicados a todos los controles de este formulario.
		 * Se utiliza un arreglo
		 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		 *
		 * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
		 * $atributos= array_merge($atributos,$atributosGlobales);
		 */
// 		$atributosGlobales ['campoSeguro'] = 'true';
// 		$_REQUEST ['tiempo'] = time ();
		
		// -------------------------------------------------------------------------------------------------
		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = 'multipart/form-data';
		
		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';
		
		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$tab = 1;
		
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );
		unset ( $atributos );
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		
		$atributos ["id"] = "bannerBackground";
        echo $this->miFormulario->division("inicio", $atributos);
        unset($atributos);
        
	        $atributos ["id"] = "bannerImagen";
	        echo $this->miFormulario->division("inicio", $atributos);
	        unset($atributos);
	        
		        // ---------------- CONTROL: Imagen --------------------------------------------------------
		        $esteCampo = 'bannerSuperior';
		        $atributos ['id'] = $esteCampo;
		        $atributos ['nombre'] = $esteCampo;
		        $atributos ['estiloMarco'] = '';
		        $atributos ["imagen"] = $rutaBloque . "/imagenes/kyron.png";
		        $atributos ['alto'] = 150;
		        $atributos ['ancho'] = 125;
		        $atributos ["borde"] = 0;
		        $atributos ['tabIndex'] = $tab++;
		        echo $this->miFormulario->campoImagen($atributos);
		        unset($atributos);
		        //--------------------FIN CONTROL: Imagen--------------------------------------------------------
	                  
        	echo $this->miFormulario->division("fin");
        
	      	$atributos ["id"] = "bannerDatos";
	      	echo $this->miFormulario->division("inicio", $atributos);
	      	unset($atributos);
	      	
		      	// ---------------- CONTROL: Campo de Texto Funcionario--------------------------------------------------------
		      	
		      	$esteCampo = 'campoUsuario';
		      	$atributos ["id"] = $esteCampo;
		      	$atributos ["estilo"] = $esteCampo;
		      	$atributos ['columnas'] = 1;
		      	$atributos ["estilo"] = $esteCampo;
		      	$atributos ['texto'] = 'Administrador'; // Aqui se deberealizar la consulta  para mostrar el usuario del sistema.
		      	$atributos ['tabIndex'] = $tab++;
		      	echo $this->miFormulario->campoTexto($atributos);
		      	unset($atributos);
		      	 
		      	//--------------------FIN CONTROL: Campo de Texto Funcionario--------------------------------------------------------
	      	
		      	// ---------------- CONTROL: Campo de Texto Fecha--------------------------------------------------------
	      		setlocale(LC_ALL, "es_ES");
		      	$fecha = strftime("%A %d de %B del %Y");
		      	
		      	$esteCampo = 'campoFechaSistema';
		      	$atributos ["id"] = $esteCampo;
		      	$atributos ["estilo"] = $esteCampo;
		      	$atributos ['columnas'] = 1;
		      	$atributos ["estilo"] = $esteCampo;
		      	$atributos ['texto'] = utf8_encode(ucwords($fecha));
		      	$atributos ['tabIndex'] = $tab++;
		      	echo $this->miFormulario->campoTexto($atributos);
		      	unset($atributos);
		      	
		      	//--------------------FIN CONTROL: Campo de Texto Fecha--------------------------------------------------------
	      	      	
		      	$atributos ["id"] = "bannerReloj";
		      	echo $this->miFormulario->division("inicio", $atributos);
		      	unset($atributos);
		      		// ---------------- CONTROL: Campo de Texto Hora--------------------------------------------------------
			      	$esteCampo = 'campoHora';
			      	$atributos ["id"] = $esteCampo;
			      	$atributos ["estilo"] = $esteCampo;
			      	$atributos ['columnas'] = 1;
			      	$atributos ["estilo"] = $esteCampo;
			      	$atributos ['texto'] = '';
			      	$atributos ['tabIndex'] = $tab++;
			      	echo $this->miFormulario->campoTexto($atributos);
			      	unset($atributos);
	
		      		//--------------------FIN CONTROL: Campo de Texto Hora--------------------------------------------------------
		      		      	
		      	echo $this->miFormulario->division("fin");
	      	
	    echo $this->miFormulario->division("fin");    
	    
	    echo $this->miFormulario->division("fin");
	      	 
	      	
		      	 
		   	//--------------------FIN CONTROL: Campo de Texto Mensaje Pie Página--------------------------------------------------------
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );
	
	}
	
}


$miFormulario = new Formulario ( $this->lenguaje, $this->miFormulario);

$miFormulario->formulario ();
?>

