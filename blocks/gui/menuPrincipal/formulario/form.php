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

$enlaces[$this->lenguaje->getCadena ( 'hojaVida' )]=array(		
		$this->lenguaje->getCadena ( 'crearDocente' ) => '#',
		$this->lenguaje->getCadena ( 'titulosAcademicos' ) => '#',
		$this->lenguaje->getCadena ( 'sinTitulosAcademicos' ) => '#',
		$this->lenguaje->getCadena ( 'consultarActividadDocente' ) => '#',		
);

$enlaces[$this->lenguaje->getCadena ( 'asignacionPuntajes' )]=array(
		'columnas' => array(
				'columna1' => array(
					'title'=>$this->lenguaje->getCadena ( 'tituloSalariales' ),
					$this->lenguaje->getCadena ( 'capituloLibros' ) => '#',
					$this->lenguaje->getCadena ( 'cartasEditor' ) => '#',
					$this->lenguaje->getCadena ( 'direccionTrabajosGrado' ) => '#',
					$this->lenguaje->getCadena ( 'experienciaDireccionAcademica' ) => '#',
					$this->lenguaje->getCadena ( 'experienciaInvestigacion' ) => '#',
					$this->lenguaje->getCadena ( 'experienciaDocencia' ) => '#',
					$this->lenguaje->getCadena ( 'experienciaProfesional' ) => '#',
					$this->lenguaje->getCadena ( 'experienciaCalificada' ) => '#',
					$this->lenguaje->getCadena ( 'excelenciaAcademica' ) => '#',
					$this->lenguaje->getCadena ( 'revistasindexadas' ) => '#',
					$this->lenguaje->getCadena ( 'comunicacionCorta' ) => '#',
					$this->lenguaje->getCadena ( 'obrasArtisticasDocente' ) => '#',
					$this->lenguaje->getCadena ( 'patentes' ) => '#',
					$this->lenguaje->getCadena ( 'PremiosDocente' ) => '#',
					$this->lenguaje->getCadena ( 'produccionVideosDocente' ) => '#',
					$this->lenguaje->getCadena ( 'produccionLibros' ) => '#',
					$this->lenguaje->getCadena ( 'traducciones' ) => '#',
					$this->lenguaje->getCadena ( 'registroTecnicaSoftware' ) => '#',
				),
				'columna2' => array(
						'title'=>$this->lenguaje->getCadena ( 'tituloBonificacion' ),
						$this->lenguaje->getCadena ( 'crearDocente' ) => '#',
						$this->lenguaje->getCadena ( 'titulosAcademicos' ) => '#',
						$this->lenguaje->getCadena ( 'sinTitulosAcademicos' ) => '#',
						$this->lenguaje->getCadena ( 'consultarActividadDocente' ) => '#',
				),
				'columna3' => array(
						'title'=>$this->lenguaje->getCadena ( 'tituloNovedades' ),
						$this->lenguaje->getCadena ( 'crearDocente' ) => '#',
						$this->lenguaje->getCadena ( 'titulosAcademicos' ) => '#',
						$this->lenguaje->getCadena ( 'sinTitulosAcademicos' ) => '#',
						$this->lenguaje->getCadena ( 'consultarActividadDocente' ) => '#',
				),
		),
);

$enlaces[$this->lenguaje->getCadena ( 'reportesDocencia' )]=array(
		'title'=>$this->lenguaje->getCadena ( 'tituloConsultaReportes' ),
		$this->lenguaje->getCadena ( 'consultaReportes' ) => '#',
		$this->lenguaje->getCadena ( 'estadoCuentaDocente' ) => '#',		
);

$atributos ['enlaces'] = $enlaces;

$crearMenu = new Dibujar ();
echo $crearMenu->html ( $atributos );

?>