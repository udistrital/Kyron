<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$miSesion = Sesion::singleton ();

$nombreFormulario = $esteBloque ["nombre"];

include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton ();
$valorCodificado = "&action=" . $esteBloque ['nombre'];
$valorCodificado .= "&opcion=actualizarDatos";
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado = $cripto->codificar ( $valorCodificado );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";

$tab = 1;

$esteCampo = "CuadroModificarRegistros";
$atributos ["id"] = $esteCampo;
$atributos ["estilo"] = "jqueryui";
$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
echo $this->miFormulario->marcoAgrupacion ( "inicio", $atributos );
unset ( $atributos );

// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = $nombreFormulario;
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario ( "inicio", $atributos );

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

$id_capitulo = $_REQUEST ['idCapitulo'];

$cadena_sql = $this->sql->cadena_sql ( "consultarCapituloModificar", $id_capitulo );
$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

// var_dump ( $resultado );
// exit ();

$cadena_sql = $this->sql->cadena_sql ( "consultarEvaluadoresModificar", $id_capitulo );

$resultadoEvauadores = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

// var_dump ( $resultadoEvauadores );

switch ($resultado [0] ['num_evaluadores']) {
	case '1' :
		
		$mostrar1 = "display:block";
		$mostrar2 = "display:none";
		$mostrar3 = "display:none";
		
		$evaluador1 = $resultadoEvauadores [0] [0];
		$universidad1 = $resultadoEvauadores [0] [1];
		$puntaje1 = $resultadoEvauadores [0] [2];
		
		$evaluador2 = " ";
		$universidad2 = - 1;
		$puntaje2 = "";
		
		$evaluador3 = " ";
		$universidad3 = - 1;
		$puntaje3 = " ";
		break;
	case '2' :
		$mostrar1 = "display:block";
		$mostrar2 = "display:block";
		$mostrar3 = "display:none";
		
		$evaluador1 = $resultadoEvauadores [0] [0];
		$universidad1 = $resultadoEvauadores [0] [1];
		$puntaje1 = $resultadoEvauadores [0] [2];
		
		$evaluador2 = $resultadoEvauadores [1] [0];
		$universidad2 = $resultadoEvauadores [1] [1];
		$puntaje2 = $resultadoEvauadores [1] [2];
		
		$evaluador3 = " ";
		$universidad3 = - 1;
		$puntaje3 = " ";
		
		break;
	case '3' :
		$mostrar1 = "display:block";
		$mostrar2 = "display:block";
		$mostrar3 = "display:block";
		
		$evaluador1 = $resultadoEvauadores [0] [0];
		$universidad1 = $resultadoEvauadores [0] [1];
		$puntaje1 = $resultadoEvauadores [0] [2];
		
		$evaluador2 = $resultadoEvauadores [1] [0];
		$universidad2 = $resultadoEvauadores [1] [1];
		$puntaje2 = $resultadoEvauadores [1] [2];
		
		$evaluador3 = $resultadoEvauadores [2] [0];
		$universidad3 = $resultadoEvauadores [2] [1];
		$puntaje3 = $resultadoEvauadores [2] [2];
		
		break;
}

// if ($resultado [0] ['puntaje_direccion'] == 'NULL') {

// $valorPuntaje = ' ';
// } else {

// $valorPuntaje = $resultado [0] ['puntaje_direccion'];
// }

?>
    <?php
				$atributos ["id"] = "CuadroModificarRegistros";
				$atributos ["estilo"] = "";
				// $atributos["estiloEnLinea"]="display:none";
				echo $this->miFormulario->division ( "inicio", $atributos );
				
				$esteCampo = "identificacion";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["seleccion"] = $resultado [0] ['id_docente'];
				$atributos ["evento"] = 2;
				$atributos ["columnas"] = "1";
				$atributos ["limitar"] = false;
				$atributos ["tamanno"] = 1;
				$atributos ["ancho"] = "450px";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["validar"] = "required";
				$atributos ["anchoEtiqueta"] = 350;
				$atributos ["obligatorio"] = true;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				// -----De donde rescatar los datos ---------
				$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarNombreDocente" );
				$atributos ["baseDatos"] = "estructura";
				echo $this->miFormulario->campoCuadroLista ( $atributos );
				
				{ // ------------------Control Lista Desplegable------------------------------
					$esteCampo = "titulocapitulo";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 40;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["validar"] = "required, minSize[3],maxSize[2000]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] = $resultado [0] ['titulo_capitulo'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					// ------------------Control Lista Desplegable------------------------------
					$esteCampo = "titulolibro";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 40;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["validar"] = "required, minSize[3],maxSize[2000]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] = $resultado [0] ['titulo_libro'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					// ------------------Control Lista Desplegable------------------------------
					$esteCampo = "tipo_libro";
					$atributos ["id"] = $esteCampo;
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["seleccion"] = $resultado [0] ['tipo_libro'];
					$atributos ["evento"] = 2;
					$atributos ["columnas"] = "1";
					$atributos ["limitar"] = false;
					$atributos ["tamanno"] = 1;
					$atributos ["ancho"] = "250px";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["validar"] = "required";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["obligatorio"] = true;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					// -----De donde rescatar los datos ---------
					$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "tipo_libro" );
					$atributos ["baseDatos"] = "estructura";
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "codigo_numeracion";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 15;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["validar"] = "required, minSize[10],min[1],maxSize[15], custom[onlyNumberSp]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] = $resultado [0] ['codigo_nunm'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					// ------------------Control Lista Desplegable------------------------------
					$esteCampo = "editorial";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 40;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["validar"] = "required, minSize[3],maxSize[2000]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] = $resultado [0] ['editorial'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "anio_libro";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;$atributos ["valor"] = $resultadoEvauadores [0] [0];
					$atributos ["tamanno"] = 5;
					$atributos ["ancho"] = 350;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["deshabilitado"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["validar"] = "required";
					$atributos ["categoria"] = "fecha";
					$atributos ["valor"] = $resultado [0] ['anio_libro'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "volumen";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 15;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30], custom[onlyNumberSp]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] = $resultado [0] ['volumen'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "num_autores_cap";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 15;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["validar"] = "minSize[1],min[1],maxSize[30], custom[onlyNumberSp]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] = $resultado [0] ['num_autor_cap'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "num_autores_universidad";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 15;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["validar"] = "minSize[1],min[0],maxSize[30], custom[onlyNumberSp]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] = $resultado [0] ['num_autor_cap_univ'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "num_autores_libro";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 15;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["validar"] = "minSize[1],min[1],maxSize[30], custom[onlyNumberSp]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] = $resultado [0] ['num_autor_libro'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "num_autores_libro_universidad";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 15;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["validar"] = "minSize[1],min[0],maxSize[30], custom[onlyNumberSp]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] = $resultado [0] ['num_autor_libro_univ'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					{
						
						$esteCampo = "grupoEvaludadores";
						$atributos ["id"] = $esteCampo;
						$atributos ["estilo"] = "jqueryui";
						$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
						echo $this->miFormulario->marcoAgrupacion ( "inicio", $atributos );
						unset ( $atributos );
						
						// ------------------Control Lista Desplegable------------------------------
						$esteCampo = "numEvaluadores";
						$atributos ["id"] = $esteCampo;
						$atributos ["tabIndex"] = $tab ++;
						$atributos ["seleccion"] = $resultado [0] ['num_evaluadores'];
						$atributos ["evento"] = 2;
						$atributos ["columnas"] = "1";
						$atributos ["limitar"] = false;
						$atributos ["tamanno"] = 1;
						$atributos ["ancho"] = "130px";
						$atributos ["estilo"] = "jqueryui";
						$atributos ["etiquetaObligatorio"] = true;
						$atributos ["validar"] = "required";
						$atributos ["anchoEtiqueta"] = 350;
						$atributos ["obligatorio"] = true;
						$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
						// -----De donde rescatar los datos ---------
						$atributos ["cadena_sql"] = array (
								array (
										'1',
										'1' 
								),
								array (
										'2',
										'2' 
								),
								array (
										'3',
										'3' 
								) 
						);
						$atributos ["baseDatos"] = "estructura";
						echo $this->miFormulario->campoCuadroLista ( $atributos );
						unset ( $atributos );
						
						$atributos ["id"] = "divEv1";
						$atributos ["estilo"] = "anchoColumna1";
						$atributos ["estiloEnLinea"] = $mostrar1;
						echo $this->miFormulario->division ( "inicio", $atributos );
						
						$esteCampo = "nomEvaluador1";
						$atributos ["id"] = $esteCampo;
						$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
						$atributos ["tabIndex"] = $tab ++;
						$atributos ["obligatorio"] = false;
						$atributos ["tamanno"] = 30;
						$atributos ["columnas"] = 3;
						$atributos ["etiquetaObligatorio"] = false;
						$atributos ["tipo"] = "";
						$atributos ["estilo"] = "jqueryui";
						$atributos ["anchoEtiqueta"] = 200;
						$atributos ["validar"] = "required, minSize[6], maxSize[50]";
						$atributos ["categoria"] = "";
						$atributos ["valor"] = $evaluador1;
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						
						// ------------------Control Lista Desplegable------------------------------
						$esteCampo = "uniEvaluador1";
						$atributos ["id"] = $esteCampo;
						$atributos ["tabIndex"] = $tab ++;
						$atributos ["seleccion"] = $universidad1;
						$atributos ["evento"] = 2;
						$atributos ["columnas"] = 3;
						$atributos ["limitar"] = false;
						$atributos ["tamanno"] = 1;
						$atributos ["ancho"] = "200px";
						$atributos ["estilo"] = "jqueryui";
						$atributos ["etiquetaObligatorio"] = false;
						$atributos ["validar"] = "required";
						$atributos ["anchoEtiqueta"] = 200;
						$atributos ["obligatorio"] = true;
						$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
						// -----De donde rescatar los datos ---------
						$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "universidad" );
						// echo $atributos["cadena_sql"];exit;
						$atributos ["baseDatos"] = "estructura";
						echo $this->miFormulario->campoCuadroLista ( $atributos );
						unset ( $atributos );
						
						$esteCampo = "puntEvaluador1";
						$atributos ["id"] = $esteCampo;
						$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
						$atributos ["tabIndex"] = $tab ++;
						$atributos ["obligatorio"] = false;
						$atributos ["tamanno"] = 10;
						$atributos ["columnas"] = 3;
						$atributos ["etiquetaObligatorio"] = false;
						$atributos ["tipo"] = "";
						$atributos ["estilo"] = "jqueryui";
						$atributos ["anchoEtiqueta"] = 155;
						$atributos ["validar"] = "required, minSize[1],min[0.1],max[100],custom[number]";
						$atributos ["categoria"] = "";
						$atributos ["valor"] = $puntaje1;
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						
						echo $this->miFormulario->division ( "fin" );
						
						$atributos ["id"] = "divEv2";
						$atributos ["estilo"] = "anchoColumna1";
						$atributos ["estiloEnLinea"] = $mostrar2;
						echo $this->miFormulario->division ( "inicio", $atributos );
						
						$esteCampo = "nomEvaluador2";
						$atributos ["id"] = $esteCampo;
						$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
						$atributos ["tabIndex"] = $tab ++;
						$atributos ["obligatorio"] = false;
						$atributos ["tamanno"] = 30;
						$atributos ["columnas"] = 3;
						$atributos ["etiquetaObligatorio"] = false;
						$atributos ["tipo"] = "";
						$atributos ["estilo"] = "jqueryui";
						$atributos ["anchoEtiqueta"] = 200;
						$atributos ["validar"] = "required, minSize[6], maxSize[50]";
						$atributos ["categoria"] = "";
						$atributos ["valor"] = $evaluador2;
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						
						// ------------------Control Lista Desplegable------------------------------
						$esteCampo = "uniEvaluador2";
						$atributos ["id"] = $esteCampo;
						$atributos ["tabIndex"] = $tab ++;
						$atributos ["seleccion"] = $universidad2;
						$atributos ["evento"] = 2;
						$atributos ["columnas"] = 3;
						$atributos ["limitar"] = false;
						$atributos ["tamanno"] = 1;
						$atributos ["ancho"] = "200px";
						$atributos ["estilo"] = "jqueryui";
						$atributos ["etiquetaObligatorio"] = false;
						$atributos ["validar"] = "required";
						$atributos ["anchoEtiqueta"] = 200;
						$atributos ["obligatorio"] = true;
						$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
						// -----De donde rescatar los datos ---------
						$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "universidad" );
						// echo $atributos["cadena_sql"];exit;
						$atributos ["baseDatos"] = "estructura";
						echo $this->miFormulario->campoCuadroLista ( $atributos );
						unset ( $atributos );
						
						$esteCampo = "puntEvaluador2";
						$atributos ["id"] = $esteCampo;
						$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
						$atributos ["tabIndex"] = $tab ++;
						$atributos ["obligatorio"] = false;
						$atributos ["tamanno"] = 10;
						$atributos ["columnas"] = 3;
						$atributos ["etiquetaObligatorio"] = false;
						$atributos ["tipo"] = "";
						$atributos ["estilo"] = "jqueryui";
						$atributos ["anchoEtiqueta"] = 155;
						$atributos ["validar"] = "required, minSize[1],min[0.1],max[100],custom[number]";
						$atributos ["categoria"] = "";
						$atributos ["valor"] = $puntaje2;
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						
						echo $this->miFormulario->division ( "fin" );
						
						$atributos ["id"] = "divEv3";
						$atributos ["estilo"] = "anchoColumna1";
						$atributos ["estiloEnLinea"] = $mostrar3;
						echo $this->miFormulario->division ( "inicio", $atributos );
						
						$esteCampo = "nomEvaluador3";
						$atributos ["id"] = $esteCampo;
						$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
						$atributos ["tabIndex"] = $tab ++;
						$atributos ["obligatorio"] = false;
						$atributos ["tamanno"] = 30;
						$atributos ["columnas"] = 3;
						$atributos ["etiquetaObligatorio"] = false;
						$atributos ["tipo"] = "";
						$atributos ["estilo"] = "jqueryui";
						$atributos ["anchoEtiqueta"] = 200;
						$atributos ["validar"] = "required, minSize[6], maxSize[2000]";
						$atributos ["categoria"] = "";
						$atributos ["valor"] = $evaluador3;
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						
						// ------------------Control Lista Desplegable------------------------------
						$esteCampo = "uniEvaluador3";
						$atributos ["id"] = $esteCampo;
						$atributos ["tabIndex"] = $tab ++;
						$atributos ["seleccion"] = $universidad3;
						$atributos ["evento"] = 2;
						$atributos ["columnas"] = 3;
						$atributos ["limitar"] = false;
						$atributos ["tamanno"] = 1;
						$atributos ["ancho"] = "200px";
						$atributos ["estilo"] = "jqueryui";
						$atributos ["etiquetaObligatorio"] = false;
						$atributos ["validar"] = "required";
						$atributos ["anchoEtiqueta"] = 200;
						$atributos ["obligatorio"] = true;
						$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
						// -----De donde rescatar los datos ---------
						$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "universidad" );
						// echo $atributos["cadena_sql"];exit;
						$atributos ["baseDatos"] = "estructura";
						echo $this->miFormulario->campoCuadroLista ( $atributos );
						unset ( $atributos );
						
						$esteCampo = "puntEvaluador3";
						$atributos ["id"] = $esteCampo;
						$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
						$atributos ["tabIndex"] = $tab ++;
						$atributos ["obligatorio"] = false;
						$atributos ["tamanno"] = 10;
						$atributos ["columnas"] = 3;
						$atributos ["etiquetaObligatorio"] = false;
						$atributos ["tipo"] = "";
						$atributos ["estilo"] = "jqueryui";
						$atributos ["anchoEtiqueta"] = 155;
						$atributos ["validar"] = "required, minSize[1],min[0.1],max[100],custom[number]";
						$atributos ["categoria"] = "";
						$atributos ["valor"] = $puntaje3;
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						
						echo $this->miFormulario->division ( "fin" );
						
						echo $this->miFormulario->marcoAgrupacion ( "fin" );
						unset ( $atributos );
					}
					
					$esteCampo = "numeActa";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 15;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] = $resultado [0] ['numacta'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "fechaActa";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 8;
					$atributos ["ancho"] = 350;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["deshabilitado"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["validar"] = "required";
					$atributos ["categoria"] = "fecha";
					$atributos ["valor"] = $resultado [0] ['fechacta'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "numeCaso";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 15;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30],custom[onlyNumberSp]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] = $resultado [0] ['numcaso'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "puntaje";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 10;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 350;
					$atributos ["validar"] = "required, minSize[1],min[0.1],custom[number]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] = $resultado [0] ['puntaje'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
                                        

                                        $esteCampo="detalleDocencia";
                                        $atributos["id"]=$esteCampo;
                                        $atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
                                        $atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
                                        $atributos["tabIndex"]=$tab++;
                                        $atributos["obligatorio"]=true;
                                        $atributos["etiquetaObligatorio"] = false;
                                        $atributos["tipo"]="";
                                        $atributos["columnas"] = 100;
                                        $atributos["filas"] = 5;
                                        $atributos["estilo"]="jqueryui";
                                        $atributos["anchoEtiqueta"] = 300;
                                        $atributos["validar"]="required";
                                        $atributos["categoria"]="";
                                        $atributos ["valor"] = $resultado [0] ['detalledocencia'];
                                        echo $this->miFormulario->campoTextArea($atributos);
                                        unset($atributos);
				}
				
				// ------------------Fin Division para los botones-------------------------
				// echo $this->miFormulario->division("fin");
				
				// ------------------Division para los botones-------------------------
				$atributos ["id"] = "botones";
				$atributos ["estilo"] = "marcoBotones";
				echo $this->miFormulario->division ( "inicio", $atributos );
				
				$esteCampo = "botonCancelar";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["tipo"] = "boton";
				$atributos ["estilo"] = "";
				$atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
				$atributos ["tipoSubmit"] = "jquery"; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
				$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["nombreFormulario"] = $nombreFormulario;
				echo $this->miFormulario->campoBoton ( $atributos );
				unset ( $atributos );
				// -------------Control Boton-----------------------
				$esteCampo = "botonAceptar";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["tipo"] = "boton";
				$atributos ["estilo"] = "";
				$atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
				$atributos ["tipoSubmit"] = "jquery"; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
				$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["nombreFormulario"] = $nombreFormulario;
				echo $this->miFormulario->campoBoton ( $atributos );
				unset ( $atributos );
				// -------------Fin Control Boton----------------------
				
				// ------------------Fin Division para los botones-------------------------
				echo $this->miFormulario->division ( "fin" );
				
				// -------------Control cuadroTexto con campos ocultos-----------------------
				// Para pasar variables entre formularios o enviar datos para validar sesiones
				$atributos ["id"] = "formSaraData"; // No cambiar este nombre
				$atributos ["tipo"] = "hidden";
				$atributos ["obligatorio"] = false;
				$atributos ["etiqueta"] = "";
				$atributos ["valor"] = $valorCodificado;
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				// Fin del Formulario
				echo $this->miFormulario->formulario ( "fin" );
				
				echo $this->miFormulario->marcoAgrupacion ( "fin" );
				
				?>
