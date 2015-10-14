<?php


if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
/**
 * Este script está incluido en el método html de la clase Frontera.class.php.
 *
 * La ruta absoluta del bloque está definida en $this->ruta
 */

$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton ();
$valorCodificado = "action=" . $esteBloque ["nombre"];
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];

$valorCodificado = $cripto->codificar ( $valorCodificado );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";

// ------------------Division para las pestañas-------------------------
$atributos ["id"] = "tabs";
$atributos ["estilo"] = "";

echo $this->miFormulario->division ( "inicio", $atributos );
unset ( $atributos );
{
	// -------------------- Listado de Pestañas (Como lista No Ordenada) -------------------------------

	$items = array (
			"tabConsultar" => $this->lenguaje->getCadena ( 'tabConsultar' ),
			"tabIngresar" => $this->lenguaje->getCadena ( 'tabIngresar' ) 
	);
	$atributos ["items"] = $items;
	$atributos ["estilo"] = "";
	$atributos ["pestañas"] = "true";
	echo $this->miFormulario->listaNoOrdenada ( $atributos );
	
	$esteCampo = "tabConsultar";
	$atributos ['id'] = $esteCampo;
	$atributos ["estilo"] = "";
	$atributos ['tipoEtiqueta'] = 'inicio';
	echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
	unset ( $atributos );
	{
		
		include ($this->ruta . "formulario/tabs/tabConsultar.php");
		
		// -----------------Fin Division para la pestaña 2-------------------------
	}
	echo $this->miFormulario->agrupacion ( 'fin' );
	
	$esteCampo = "tabIngresar";
	$atributos ['id'] = $esteCampo;
	$atributos ["estilo"] = "";
	$atributos ['tipoEtiqueta'] = 'inicio';
	echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
	unset ( $atributos );
	{
		
		include ($this->ruta . "formulario/tabs/tabRegistrar.php");
		// -----------------Fin Division para la pestaña 1-------------------------
	}
	echo $this->miFormulario->agrupacion ( 'fin' );
}
echo $this->miFormulario->division ( "fin" );

?>
