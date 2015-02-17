<?php
/**
 * Página para mostrar mensajes de error fatales dentro de la aplicación. Se ejecuta completa pues se espera que solo se
 * muestre en casos extremos.
 *
 * @author	Paulo Cesar Coronado
 * @version	0.0.0.2, 25/03/2012
 * @package 	framework:BCK:instalacion
 * @copyright Universidad Distrital F.J.C
 * @license	GPL Version 3.0 o posterior
 *
 */


if(!$this->miConfigurador->getVariableConfiguracion("estilo")){
	
	$this->miConfigurador->setVariableConfiguracion("estilo","basico");
}

if(!$this->miConfigurador->getVariableConfiguracion("idioma")){
	$this->miConfigurador->setVariableConfiguracion("idioma", "es_es");
}

/**
 * I18n
 */

$miIdioma=$this->miConfigurador->getVariableConfiguracion("raizDocumento")."/core/locale/";
$miIdioma.=$this->miConfigurador->getVariableConfiguracion("idioma")."/LC_MESSAGES/Mensaje.page.php";
include $miIdioma;

$indice=strpos($_SERVER["REQUEST_URI"], "/index.php");

if($indice===false){
	$indice=strpos($_SERVER["REQUEST_URI"], "/",1);

}
$sitio=substr($_SERVER["REQUEST_URI"],0,$indice);

$_REQUEST["jquery"]=true;
?>
<html>
<head>
<title></title>
<?php include_once $this->miConfigurador->getVariableConfiguracion("raizDocumento")."/plugin/scripts/Script.php"?>
<script>
$(window).load(function() {
	$("#mensaje").fadeIn(1000);
	
});

	  
	
</script>
<?php include_once $this->miConfigurador->getVariableConfiguracion("raizDocumento")."/theme/".$this->miConfigurador->getVariableConfiguracion("estilo")."/Estilo.php"?>

<meta content="text/html;" http-equiv="content-type" charset="utf-8">
</head>
<body>
	<div id="mensaje" class="<?php echo $tipoMensaje ?> shadow ocultar" ><?php
		echo $this->idioma[$mensaje];
		
	?></div>
</body>
</html>
