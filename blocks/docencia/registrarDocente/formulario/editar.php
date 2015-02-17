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

$nombreFormulario = $esteBloque ["nombre"];

include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton ();
//$valorCodificado ="pagina=registrarDocente";
$valorCodificado = "action=".$esteBloque ["nombre"];
$valorCodificado .= "&solicitud=procesarNuevo";
$valorCodificado .= "&bloque=".$esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=".$esteBloque ["grupo"];
$valorCodificado = $cripto->codificar ( $valorCodificado );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";

$datosConfirmar = array (
		"numIdentificacion",
		"tipoIdentificacion",
		"nombres",
		"apellidos",
		"genero",
		"fechaNacimiento",
		"paisNacimiento",
		"ciudadNacimiento",
		"codigoInterno",
		"fechaIngreso",
		"resolucionNombramiento",
		"documentoResolucion",
		"dedicacion",
		"fechaInicioAño",
		"documentoPrueba",
		"documentoFinal",
		"documentoConcepto",
		"facultad",
		"proyectoCurricular",
		"categoriaActual",
		"correoInstitucional",
		"direccionResidencia",
		"telefonoFijo",
		"telefonoCelular",
		"telefonoadicional",
		"numeroActa",
		"fechaActa",
		"numeroCaso"
);

$conexion = "configuracion";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
$cadena_sql = $this->sql->cadena_sql ( "rescatarTemp", "123" );
$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );




$totalRegistros = $esteRecursoDB->getConteo ();

if ($totalRegistros > 0) {

	for($i = 0; $i < $totalRegistros; $i ++) {

		$variable [trim ( $resultado [$i] ["campo"] )] = $resultado [$i] ["valor"];
	}
}



//

$tab = 1;

// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = $nombreFormulario;
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario ( "inicio", $atributos );

// -----------------Inicio de Conjunto de Controles----------------------------------------
$esteCampo = "marcoDatosBasicos";
$atributos ["estilo"] = "jqueryui";
$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
echo $this->miFormulario->marcoAGrupacion ( "inicio", $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "numIdentificacion";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]=$variable[$esteCampo];
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// -------------Control cuadroTexto-----------------------
$esteCampo = "tipoIdentificacion";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = 0; // 9
$atributos ["evento"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["estilo"] = "jqueryui";
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscartipoidentificacion" );
$atributos ["baseDatos"] = "docencia";

echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );



// -------------Control cuadroTexto-----------------------
$esteCampo = "nombres";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "10";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]=$variable[$esteCampo];;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "apellidos";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "10";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]=$variable[$esteCampo];;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "genero";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = 0; // 9
$atributos ["evento"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["estilo"] = "jqueryui";
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscargenero" );
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "fechaNacimiento";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=false;
$atributos["tamanno"]="10";
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"]="minSize[3]";
$atributos["categoria"]="fecha";
$atributos["valor"]=$variable[$esteCampo];; //Para evitar un error al validar un datepicker
echo $this->miFormulario->campoCuadroTexto($atributos);
// //-------------Control cuadroTexto-----------------------
$esteCampo = "paisNacimiento";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = 0; // 9
$atributos ["evento"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["estilo"] = "jqueryui";
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarpais" );
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "ciudadNacimiento";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = 0; // 9
$atributos ["evento"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["estilo"] = "jqueryui";
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarciudad" );
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );



// //Fin de Conjunto de Controles
echo $this->miFormulario->marcoAGrupacion ( "fin" );

// -----------------Inicio de Conjunto de Controles----------------------------------------
$esteCampo = "marcoDocentes";
$atributos ["estilo"] = "jqueryui";
$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
echo $this->miFormulario->marcoAGrupacion ( "inicio", $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "codigoInterno";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]=$variable[$esteCampo];;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "fechaIngreso";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=false;
$atributos["tamanno"]="10";
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"]="minSize[3]";
$atributos["categoria"]="fecha";
$atributos["valor"]=$variable[$esteCampo];; //Para evitar un error al validar un datepicker
echo $this->miFormulario->campoCuadroTexto($atributos);                              

// //-------------Control cuadroTexto-----------------------
$esteCampo = "resolucionNombramiento";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]=$variable[$esteCampo];;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "documentoResolucion";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]=$variable[$esteCampo];;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );


// //-------------Control cuadroTexto-----------------------
$esteCampo = "dedicacion";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = 0; // 9
$atributos ["evento"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["estilo"] = "jqueryui";
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscardedicacion" );
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "fechaInicioAño";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=false;
$atributos["tamanno"]="10";
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"]="minSize[3]";
$atributos["categoria"]="fecha";
$atributos["valor"]=$variable[$esteCampo];;
 //Para evitar un error al validar un datepicker
echo $this->miFormulario->campoCuadroTexto($atributos);                              

// //-------------Control cuadroTexto-----------------------
$esteCampo = "documentoPrueba";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]=$variable[$esteCampo];;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "documentoFinal";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]=$variable[$esteCampo];;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "documentoConcepto";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]='DOCUMENTO';
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

echo $this->miFormulario->marcoAGrupacion ( "fin" );

// -----------------Inicio de Conjunto de Controles----------------------------------------
$esteCampo = "marcoDependecia";
$atributos ["estilo"] = "jqueryui";
$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
echo $this->miFormulario->marcoAGrupacion ( "inicio", $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "facultad";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = 0; // 9
$atributos ["evento"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["estilo"] = "jqueryui";
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarfacultad" );
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "proyectoCurricular";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = 0; // 9
$atributos ["evento"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["estilo"] = "jqueryui";
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarproyectoc" );
// $atributos ["baseDatos"] = "docencia";

echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "categoriaActual";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = 0; // 9
$atributos ["evento"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["estilo"] = "jqueryui";
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarCategoria" );
$atributos ["baseDatos"] = "docencia";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );


// //-------------Control cuadroTexto-----------------------
$esteCampo = "correoInstitucional";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["etiquetaObligatorio"] = true;
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = "40";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "required, custom[email], maxSize[40]";
$atributos["categoria"] = "";
$atributos["valor"] = $variable[$esteCampo];;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);


// //-------------Control cuadroTexto-----------------------
$esteCampo = "correoPersonal";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["etiquetaObligatorio"] = true;
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = "40";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "required, custom[email], maxSize[40]";
$atributos["categoria"] = "";
$atributos["valor"] =$variable[$esteCampo];;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);


// //-------------Control cuadroTexto-----------------------
$esteCampo = "direccionResidencia";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]=$variable[$esteCampo];;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );


// //-------------Control cuadroTexto-----------------------
$esteCampo = "telefonoFijo";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]=$variable[$esteCampo];;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "telefonoCelular";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]=$variable[$esteCampo];;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "telefonoadicional";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]=$variable[$esteCampo];;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

// //-------------Control cuadroTexto-----------------------
$esteCampo = "numeroActa";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]=$variable[$esteCampo];;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );

//-------------Control cuadroTexto-----------------------
$esteCampo="fechaActa";
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=false;
$atributos["tamanno"]="10";
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"]="minSize[3]";
$atributos["categoria"]="fecha";
$atributos["valor"]=$variable[$esteCampo];; //Para evitar un error al validar un datepicker
echo $this->miFormulario->campoCuadroTexto($atributos);


// //-------------Control cuadroTexto-----------------------
$esteCampo = "numeroCaso";
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["columnas"] = "1";
$atributos ["validar"] = "required";
$atributos["valor"]=$variable[$esteCampo];
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );



echo $this->miFormulario->marcoAGrupacion ( "fin" );

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

$esteCampo = "botonCancelar";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["tipo"] = "boton";
$atributos ["estilo"] = "";
$atributos ["verificar"] = "true"; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
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
?>
