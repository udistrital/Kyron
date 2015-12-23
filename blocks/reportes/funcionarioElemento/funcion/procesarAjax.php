<?php

// var_dump($_REQUEST);exit;
use inventarios\gestionElementos\modificarElemento\Sql;

include_once ("core/builder/FormularioHtml.class.php");

$this->ruta = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );

$this->miFormulario = new \FormularioHtml ();

$atributosGlobales ['campoSeguro'] = 'true';
$conexion = "inventarios";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . '/' . $esteBloque ['nombre'];

$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );

if ($_REQUEST ['funcion'] == 'Consulta') {
	$arreglo = unserialize ( $_REQUEST ['arreglo'] );
	
	$cadenaSql = $this->sql->getCadenaSql ( 'consultarElemento', $arreglo );
	
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
	
	$cadenaSql = $this->sql->getCadenaSql ( "Verificar_Periodo" );
	$resultado_periodo = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
	$tab = 1;
	
	for($i = 0; $i < count ( $resultado ); $i ++) {
		
		if (isset ( $_REQUEST ['accesoCondor'] ) && $_REQUEST ['accesoCondor'] == 'true') {
			$VariableDetalles = "pagina=elementoDetalle";
		} else {
			$VariableDetalles = "pagina=detalleElemento";
		}
		
		// pendiente la pagina para modificar parametro
		$VariableDetalles .= "&opcion=detalle";
		$VariableDetalles .= "&elemento=" . $resultado [$i] ['identificador_elemento_individual'];
		$VariableDetalles .= "&funcionario=" . $arreglo ['funcionario'];
		$VariableDetalles .= "&usuario=" . $_REQUEST ['usuario'];
		$VariableDetalles .= "&periodo=" . $resultado_periodo [0] [0];
		if (isset ( $_REQUEST ['accesoCondor'] ) && $_REQUEST ['accesoCondor'] == 'true') {
			$VariableDetalles .= "&accesoCondor=true";
		}
		
		$VariableDetalles = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $VariableDetalles, $directorio );
		
		$VariableObservaciones = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
		$VariableObservaciones .= "&opcion=observaciones";
		$VariableObservaciones .= "&elemento_individual=" . $resultado [$i] ['identificador_elemento_individual'];
		$VariableObservaciones .= "&funcionario=" . $arreglo ['funcionario'];
		$VariableObservaciones .= "&placa=" . $resultado [$i] ['placa'];
		$VariableObservaciones .= "&usuario=" . $_REQUEST ['usuario'];
		$VariableObservaciones .= "&periodo=" . $resultado_periodo [0] [0];
		if (isset ( $_REQUEST ['accesoCondor'] ) && $_REQUEST ['accesoCondor'] == 'true') {
			$VariableObservaciones .= "&accesoCondor=true";
		}
		
		$VariableObservaciones = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $VariableObservaciones, $directorio );
		
		$identificaciones_elementos [] = $resultado [$i] ['identificador_elemento_individual'];
		
		$nombre = 'item_' . $i;
		$atributos ['id'] = $nombre;
		$atributos ['nombre'] = $nombre;
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = true;
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['columnas'] = 1;
		$atributos ['dobleLinea'] = 1;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = '';
		$atributos ['seleccionado'] = ($resultado [$i] ['confirmada_existencia'] == 't') ? true : false;
		$atributos ['evento'] = 'onclick';
		$atributos ['eventoFuncion'] = ' verificarElementos(this.form)';
		$atributos ['valor'] = $resultado [$i] ['identificador_elemento_individual'];
		$atributos ['deshabilitado'] = false;
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		
		$item = ($resultado [$i] ['tipo_confirmada'] == 1) ? '&#8730 ' : $this->miFormulario->campoCuadroSeleccion ( $atributos );
		
		$resultadoFinal [] = array (
				'tipobien' => "<center>" . $resultado [$i] ['nombre_tipo_bienes'] . "</center>",
				'placa' => "<center>" . $resultado [$i] ['placa'] . "</center>",
				'descripcion' => "<center>" . $resultado [$i] ['descripcion_elemento'] . "</center>",
				'sede' => "<center>" . $resultado [$i] ['sede'] . "</center>",
				'dependencia' => "<center>" . $resultado [$i] ['dependencia'] . "</center>",
				'espaciofisico' => "<center>" . $resultado [$i] ['espaciofisico'] . "</center>",
				'estadoelemento' => "<center>" . $resultado [$i] ['estado_bien'] . "</center>",
				'contratista' => "<center>" . $resultado [$i] ['contratista'] . "</center>",
				'detalle' => "<center><a href='" . $VariableDetalles . "'><u>Ver Detalles</u></a></center>",
				'observaciones' => "<center><a href='" . $VariableObservaciones . "'>&#9658; &blk34;</a></center>",
				'verificacion' => "<center>" . $item . "</center>" 
		);
	}
	
	$total = count ( $resultadoFinal );
	
	$resultado = json_encode ( $resultadoFinal );
	
	$resultado = '{
                "recordsTotal":' . $total . ',
                "recordsFiltered":' . $total . ',
				"data":' . $resultado . '}';
	
	echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultarDependencia') {
	
	$cadenaSql = $this->sql->getCadenaSql ( 'dependenciasConsultadas', $_REQUEST ['valor'] );
	
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
	
	$resultado = json_encode ( $resultado );
	
	echo $resultado;
}

if ($_REQUEST ['funcion'] == 'SeleccionTipoBien') {
	
	$cadenaSql = $this->sql->getCadenaSql ( 'ConsultaTipoBien', $_REQUEST ['valor'] );
	$resultadoItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
	$resultadoItems = $resultadoItems [0];
	
	echo json_encode ( $resultadoItems );
}

if ($_REQUEST ['funcion'] == 'consultarUbicacion') {
	
	$cadenaSql = $this->sql->getCadenaSql ( 'ubicacionesConsultadas', array (
			$_REQUEST ['valorD'],
			$_REQUEST ['valorS'] 
	) );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
	
	$resultado = json_encode ( $resultado );
	
	echo $resultado;
}

?>
