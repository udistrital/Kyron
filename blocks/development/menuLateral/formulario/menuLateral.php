<?php

$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );


$esteCampo='desenlace';
$item = $esteCampo;
$items [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items [$item] ['icono'] = 'ui-icon-circle-triangle-e'; // El li es un enlace directo
$items [$item] ['toolTip'] = $this->lenguaje->getCadena ( $esteCampo . 'Tooltip' );
$enlace = 'pagina=desenlace';
$enlace .= '&development=true';
$items [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );


$item = 'codificador';
$items [$item] ['nombre'] = 'Codificador';
$items [$item] ['enlace'] = true; // El <li> es un enlace directo
$items [$item] ['icono'] = 'ui-icon-circle-triangle-e'; // El <li> es un enlace directo
$enlace = 'pagina=codificador';
$enlace .= '&development=true';
$items [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );


$item = 'registro';
$items [$item] ['nombre'] = 'Registro';
$items [$item] ['enlace'] = true; // El <li> es un enlace directo
$items [$item] ['icono'] = 'ui-icon-circle-triangle-e'; // El <li> es un enlace directo
$enlace = 'pagina=registro';
$enlace .= '&development=true';
$items [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

$item = 'plugin';
$items [$item] ['nombre'] = 'Agregar Plugin';
$items [$item] ['enlace'] = true; // El <li> es un enlace directo
$items [$item] ['icono'] = 'ui-icon-circle-triangle-e'; // El <li> es un enlace directo
$enlace = 'pagina=plugin';
$enlace .= '&development=true';
$items [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

$item = 'constructor';
$items [$item] ['nombre'] = 'Constructor';
$items [$item] ['enlace'] = true; // El <li> es un enlace directo
$items [$item] ['icono'] = 'ui-icon-circle-triangle-e'; // El <li> es un enlace directo
$enlace = 'pagina=constructor';
$enlace .= '&development=true';
$items [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );


$item = 'cruder';
$items [$item] ['nombre'] = 'CRUDer';
$items [$item] ['enlace'] = true; // El <li> es un enlace directo
$items [$item] ['icono'] = 'ui-icon-circle-triangle-e'; // El <li> es un enlace directo
$enlace = 'pagina=cruder';
$enlace .= '&development=true';
$items [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

$item = 'saraFormCreator';
$items [$item] ['nombre'] = 'SARA Form Creator';
$items [$item] ['enlace'] = true; // El <li> es un enlace directo
$items [$item] ['icono'] = 'ui-icon-circle-triangle-e'; // El <li> es un enlace directo
$enlace = 'pagina=saraFormCreator';
$enlace .= '&development=true';
$items [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

$item = 'formatearSQL';
$items [$item] ['nombre'] = 'Formatear SQL';
$items [$item] ['enlace'] = true; // El <li> es un enlace directo
$items [$item] ['icono'] = 'ui-icon-circle-triangle-e'; // El <li> es un enlace directo
$enlace = 'pagina=formatearSQL';
$enlace .= '&development=true';
$items [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

// Atributos generales para la lista
$atributos ['id'] = 'menuLateral';
$atributos ['estilo'] = 'jqueryui';
$atributos ["enlaces"] = true;
$atributos ['items'] = $items;
$atributos ['menu'] = true;

echo $this->miFormulario->listaNoOrdenada ( $atributos );

?>