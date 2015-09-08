<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

// ------------------Division para las pestañas-------------------------
$atributos ["id"] = "tabs";
$atributos ["estilo"] = "";

echo $this->miFormulario->division ( "inicio", $atributos );
unset ( $atributos );

// -------------------- Listado de Pestañas (Como lista No Ordenada) -------------------------------

$items = array (
	"tabConsultarLibros" => $this->lenguaje->getCadena ( "consultarLibros" ),
	"tabRegistrarLibros" => $this->lenguaje->getCadena ( "registrarLibros" ) 
);


$atributos ["items"] = $items;
$atributos ["estilo"] = "";
$atributos ["pestañas"] = "true";
echo $this->miFormulario->listaNoOrdenada ( $atributos );

$esteCampo = "tabConsultarRevistas";
$atributos ['id'] = $esteCampo;
$atributos ["estilo"] = "";
$atributos ['tipoEtiqueta'] = 'inicio';
echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
unset ( $atributos );

require ($this->ruta . "formulario/tabs/tabConsultar.php");
	
// -----------------Fin Division para la pestaña 2-------------------------
echo $this->miFormulario->agrupacion ( 'fin' );

$esteCampo = "tabRegistrarLibros";
$atributos ['id'] = $esteCampo;
$atributos ["estilo"] = "";
$atributos ['tipoEtiqueta'] = 'inicio';
echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
unset ( $atributos );		

require ($this->ruta . "formulario/tabs/tabRegistrar.php");

// -----------------Fin Division para la pestaña 1-------------------------
echo $this->miFormulario->agrupacion ( 'fin' );

echo $this->miFormulario->division ( "fin" );

?>
