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

$esteCampo = "grupoModificar";
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

$id_libro = $_REQUEST ['id_libro'];

$cadena_sql = $this->sql->cadena_sql ( "consultarLibroModificar", $id_libro );
$resultadoLibros = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

$atributos ["id"] = "divDatos";
$atributos ["estilo"] = "marcoBotones";
// $atributos["estiloEnLinea"]="display:none";
// echo $this->miFormulario->division("inicio",$atributos);

$esteCampo = "docente";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = $resultadoLibros [0] [0];
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
$atributos ["deshabilitado"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarNombreDocente" );
$atributos ["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista ( $atributos );
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
$atributos ["valor"] = $resultadoLibros [0] [2];
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "tipo_libro";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = $resultadoLibros [0] [3];
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
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "tipoLibro" );
$atributos ["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

$atributos ["id"] = "div_entidadCertifica";
$atributos ["estilo"] = "";

if ($resultadoLibros [0] [3] != 1) {
	$atributos ["estiloEnLinea"] = "display:none";
}
echo $this->miFormulario->division ( "inicio", $atributos );
// ------------------Control Lista Desplegable------------------------------
$esteCampo = "entidadCertifica";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = $resultadoLibros [0] [4];
$atributos ["evento"] = 2;
$atributos ["columnas"] = 1;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "200px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = false;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "universidad" );
// echo $atributos["cadena_sql"];exit;
$atributos ["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

echo $this->miFormulario->division ( "fin" );

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
$atributos ["valor"] = $resultadoLibros [0] [5];
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
$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30], custom[onlyNumberSp]";
$atributos ["valor"] = $resultadoLibros [0] [6];
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
$atributos ["validar"] = "required, minSize[1],min[0],maxSize[30], custom[onlyNumberSp]";
$atributos ["valor"] = $resultadoLibros [0] [7];
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "editorial";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = $resultadoLibros [0] [8];
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
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "editorial" );
$atributos ["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

$esteCampo = "anio_libro";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 5;
$atributos ["ancho"] = 350;
$atributos ["etiquetaObligatorio"] = true;
$atributos ["deshabilitado"] = true;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required";
$atributos ["categoria"] = "fecha";
$atributos ["valor"] = $resultadoLibros [0] [9];
;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

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
$atributos ["valor"] = $resultadoLibros [0] [10];
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
$atributos ["valor"] = $resultadoLibros [0] [11];
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
$atributos ["valor"] = $resultadoLibros [0] [12];
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

$esteCampo = "grupoEvaluadores";
$atributos ["id"] = $esteCampo;
$atributos ["estilo"] = "jqueryui";
$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
echo $this->miFormulario->marcoAgrupacion ( "inicio", $atributos );
unset ( $atributos );

$cadena_sql = $this->sql->cadena_sql ( "consultarEvaluadoresLibros", $id_libro );
$resultadoEvaluadoresLibros = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

// ------------------Control Lista Desplegable------------------------------
$esteCampo = "numEvaluadores";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = count ( $resultadoEvaluadoresLibros );
$atributos ["evento"] = 2;
$atributos ["columnas"] = "1";
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["ancho"] = "110px";
$atributos ["estilo"] = "jqueryui";
$atributos ["etiquetaObligatorio"] = true;
$atributos ["validar"] = "required";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["obligatorio"] = true;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos ---------
$atributos ["cadena_sql"] = array (
		array (
				'2',
				'2' 
		),
		array (
				'3',
				'3' 
		) 
);
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

for($j = 0; $j < 3; $j ++) {
	if (isset ( $resultadoEvaluadoresLibros [$j] ['id_revisores'] ) && $resultadoEvaluadoresLibros [$j] ['id_revisores'] != '') {
		$atributos ["id"] = "divEv" . ($j + 1);
		$atributos ["estilo"] = "anchoColumna1";
		echo $this->miFormulario->division ( "inicio", $atributos );
		
		$atributos ["id"] = "id_revisor" . ($j + 1); // No cambiar este nombre
		$atributos ["tipo"] = "hidden";
		$atributos ["valor"] = $resultadoEvaluadoresLibros [$j] ['id_revisores'];
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		$esteCampo = "idenEvaluador" . ($j + 1);
		$atributos ["id"] = $esteCampo;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["obligatorio"] = false;
		$atributos ["tamanno"] = 30;
		$atributos ["columnas"] = 2;
		$atributos ["etiquetaObligatorio"] = false;
		$atributos ["tipo"] = "";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["anchoEtiqueta"] = 250;
		$atributos ["validar"] = "required, minSize[6], maxSize[50],custom[number], min[000001] ";
		$atributos ["valor"] = $resultadoEvaluadoresLibros [$j] ['revisor_iden'];
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		$esteCampo = "nomEvaluador" . ($j + 1);
		$atributos ["id"] = $esteCampo;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["obligatorio"] = false;
		$atributos ["tamanno"] = 30;
		$atributos ["columnas"] = 2;
		$atributos ["etiquetaObligatorio"] = false;
		$atributos ["tipo"] = "";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["anchoEtiqueta"] = 250;
		$atributos ["validar"] = "required, minSize[6], maxSize[50]";
		$atributos ["valor"] = $resultadoEvaluadoresLibros [$j] ['revisor_nombre'];
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ------------------Control Lista Desplegable------------------------------
		$esteCampo = "uniEvaluador" . ($j + 1);
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = $resultadoEvaluadoresLibros [$j] ['revisor_institucion'];
		$atributos ["evento"] = 2;
		$atributos ["columnas"] = 2;
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["ancho"] = "200px";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiquetaObligatorio"] = false;
		$atributos ["validar"] = "required";
		$atributos ["anchoEtiqueta"] = 250;
		$atributos ["obligatorio"] = true;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos ---------
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "universidad" );
		// echo $atributos["cadena_sql"];exit;
		$atributos ["baseDatos"] = "estructura";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		$esteCampo = "puntEvaluador" . ($j + 1);
		$atributos ["id"] = $esteCampo;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["obligatorio"] = false;
		$atributos ["tamanno"] = 10;
		$atributos ["columnas"] = 2;
		$atributos ["etiquetaObligatorio"] = false;
		$atributos ["tipo"] = "";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["anchoEtiqueta"] = 250;
		$atributos ["validar"] = "required, minSize[1],min[0.1],max[100],custom[number]";
		$atributos ["valor"] = $resultadoEvaluadoresLibros [$j] ['revisor_puntaje'];
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		echo $this->miFormulario->division ( "fin" );
	} else {
		$atributos ["id"] = "divEv" . ($j + 1);
		$atributos ["estilo"] = "anchoColumna1";
		if ($j > 1) {
			$atributos ["estiloEnLinea"] = "display:none";
		}
		echo $this->miFormulario->division ( "inicio", $atributos );
		
		$esteCampo = "idenEvaluador" . ($j + 1);
		$atributos ["id"] = $esteCampo;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["obligatorio"] = false;
		$atributos ["tamanno"] = 30;
		$atributos ["columnas"] = 2;
		$atributos ["etiquetaObligatorio"] = false;
		$atributos ["tipo"] = "";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["anchoEtiqueta"] = 250;
		$atributos ["validar"] = "required, minSize[6], maxSize[50],custom[number], min[000001] ";
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		$esteCampo = "nomEvaluador" . ($j + 1);
		$atributos ["id"] = $esteCampo;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["obligatorio"] = false;
		$atributos ["tamanno"] = 30;
		$atributos ["columnas"] = 2;
		$atributos ["etiquetaObligatorio"] = false;
		$atributos ["tipo"] = "";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["anchoEtiqueta"] = 250;
		$atributos ["validar"] = "required, minSize[6], maxSize[50]";
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ------------------Control Lista Desplegable------------------------------
		$esteCampo = "uniEvaluador" . ($j + 1);
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = - 1;
		$atributos ["evento"] = 2;
		$atributos ["columnas"] = 2;
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["ancho"] = "200px";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiquetaObligatorio"] = false;
		$atributos ["validar"] = "required";
		$atributos ["anchoEtiqueta"] = 250;
		$atributos ["obligatorio"] = true;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos ---------
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "universidad" );
		// echo $atributos["cadena_sql"];exit;
		$atributos ["baseDatos"] = "estructura";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		$esteCampo = "puntEvaluador" . ($j + 1);
		$atributos ["id"] = $esteCampo;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["obligatorio"] = false;
		$atributos ["tamanno"] = 10;
		$atributos ["columnas"] = 2;
		$atributos ["etiquetaObligatorio"] = false;
		$atributos ["tipo"] = "";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["anchoEtiqueta"] = 250;
		$atributos ["validar"] = "required, minSize[1],min[0.1],max[100],custom[number]";
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		echo $this->miFormulario->division ( "fin" );
	}
}

echo $this->miFormulario->marcoAgrupacion ( "fin" );
unset ( $atributos );

switch ($resultadoLibros [0] [3]) {
	case 1 :
		
		$puntMax = ", max[20]";
		
		break;
	case 2 :
		
		$puntMax = ", max[15]";
		
		break;
	case 3 :
		
		$puntMax = ", max[15]";
		
		break;
}

$esteCampo = "puntaje";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = 5;
$atributos ["columnas"] = 1;
$atributos ["etiquetaObligatorio"] = false;
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["anchoEtiqueta"] = 350;
$atributos ["validar"] = "required, custom[number], condRequired[contexto], min[0.1]" . $puntMax;
$atributos ["categoria"] = "";
$atributos ["valor"] = $resultadoLibros [0] [13];
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
$atributos ["valor"] = $resultadoLibros [0] ['detalledocencia'];
echo $this->miFormulario->campoTextArea($atributos);
unset($atributos);

// ------------------Fin Division para los botones-------------------------
// echo $this->miFormulario->division("fin");

// ------------------Division para los botones-------------------------
$atributos ["id"] = "botones";
$atributos ["estilo"] = "marcoBotones";
echo $this->miFormulario->division ( "inicio", $atributos );

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

// -------------Control Boton-----------------------
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
