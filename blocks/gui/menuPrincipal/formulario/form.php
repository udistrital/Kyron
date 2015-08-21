<?php
include_once ($this->ruta . "/builder/DibujarMenu.class.php");
use gui\menuPrincipal\builder\Dibujar;
// include_once ($this -> ruta . 'funcion/GetLink.php');
// use gui\menuPrincipal\funcion\GetLink;

$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

$esteBloque=$this->miConfigurador->getVariableConfiguracion ( 'esteBloque' );

$paginas = [ 
	'inicio',
	'hojaVida',
	'asignacionPuntajes',
	'reportesDocencia',
	'cerrarSesion',
];

$enlaces = array ();

foreach ( $paginas as $pagina ) {
	$enlace = 'pagina=' . $pagina;
	$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
	//$enlace = GetLink::obtener($pagina);
	$nombrePagina = $this->lenguaje->getCadena ( $pagina );
	$enlaces[$nombrePagina] = $enlace;
}

// $enlaces[$this->lenguaje->getCadena ( 'sesion' )]=array(
	
// 	'usuario registrado'=>'#',
// 	'logout'=>'#',
// );

$enlaces[$this->lenguaje->getCadena ( 'sesion' )]=array(		
		'columnas' => array(
			'columna1' => array(
				'title' => 'Nombre',
					'a' => 'ape',
					'tele' => 'Nombre',
					'direccion' => 'Nombre',
					'celular' => 'Nombre',
				'usuario registrado'=>'#',
				'logout'=>'#',
			),	
			'columna2' => array(
				'emmanuel'=>'#',
				'taborda'=>'#',
			),
			'columna3' => array(
				'emmanuel'=>'#',
				'taborda'=>'#',
			),
			
		),
);

$atributos ['enlaces'] = $enlaces;

$crearMenu = new Dibujar ();
echo $crearMenu->html ( $atributos );

?>