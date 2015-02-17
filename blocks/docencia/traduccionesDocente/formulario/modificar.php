<?php
// var_dump($_REQUEST);exit;
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
// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = $nombreFormulario;
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario ( "inicio", $atributos );

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

$idTraduccion = $_REQUEST ['idTraduccion'];

$cadena_sql = $this->sql->cadena_sql ( "consultarTraduccion", $idTraduccion );
// echo $cadena_sql;
$resultadoTraduccion = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
// var_dump ( $resultadoTraduccion );
// exit ();

if ($resultadoTraduccion [0] ['tipo_traduccion'] == 1) {
	
	$seleccionRevista = "display:none";
	$seleccionLibro = "display:block";
	
	$nom_libro = $resultadoTraduccion [0] ['nom_libro'];
	$editorial = $resultadoTraduccion [0] ['editorial'];
	$aniol = $resultadoTraduccion [0] ['aniol'];
	$num_revista = "";
	$volumen = "";
	$anior = "";
	$tipo_revista = "";
	$traduccion = "";
} else if ($resultadoTraduccion [0] ['tipo_traduccion'] == 2) {
	
	$seleccionRevista = "display:block";
	$seleccionLibro = "display:none";
	
	$nom_libro = "";
	$editorial = "";
	$aniol = "";
	$categoria_revista = "";
	
	$traduccion = $resultadoTraduccion [0] ['revista_traduccion'];
	$num_revista = $resultadoTraduccion [0] ['num_revista'];
	$volumen = $resultadoTraduccion [0] ['volumen'];
	$anior = $resultadoTraduccion [0] ['anior'];
	$tipo_revista = $resultadoTraduccion [0] ['tipo_revista'];
}

?>
    <?php
				$atributos ["id"] = "divDatos";
				$atributos ["estilo"] = "marcoBotones";
				// $atributos["estiloEnLinea"]="display:none";
				// echo $this->miFormulario->division("inicio",$atributos);
				
				// -----------------Inicio de Conjunto de Controles----------------------------------------
				$esteCampo = "marcoDatosModificar";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
				echo $this->miFormulario->marcoAgrupacion ( "inicio", $atributos );
				
				$esteCampo = "titulo_publicacion";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = 55;
				$atributos ["columnas"] = 1;
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["validar"] = "required, minSize[6], maxSize[2000]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultadoTraduccion [0] ['titulo_publicacion'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
                                
                                $esteCampo = "titulo_traduccionAnterior";
				$atributos ["id"] = $esteCampo;
				$atributos ["tipo"] = "hidden";
				$atributos ["valor"] = $resultadoTraduccion [0] ['titulo_traduccion'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "titulo_traduccion";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = 55;
				$atributos ["columnas"] = 1;
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["validar"] = "required, minSize[6],maxSize[2000]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultadoTraduccion [0] ['titulo_traduccion'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				// ------------------Control Lista Desplegable------------------------------
				$esteCampo = "tipo_traducc";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["seleccion"] = $resultadoTraduccion [0] ['tipo_traduccion'];
				$atributos ["evento"] = 2;
				$atributos ["columnas"] = "1";
				$atributos ["limitar"] = false;
				$atributos ["tamanno"] = 1;
				$atributos ["ancho"] = "325px";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["validar"] = "required";
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["obligatorio"] = true;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				// -----De donde rescatar los datos ---------
				$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "tipo_traducc" );
				$atributos ["baseDatos"] = "estructura";
				echo $this->miFormulario->campoCuadroLista ( $atributos );
				unset ( $atributos );
				
				// ---------------Inicio Formulario (<form>)--------------------------------
				$atributos ["id"] = "Trevista";
				$atributos ["estilo"] = "campoTexto";
				$atributos ["estiloEnLinea"] = $seleccionRevista;
				$verificarFormulario = "1";
				echo $this->miFormulario->division ( "inicio", $atributos );
				
				$esteCampo = "revista";
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
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["validar"] = "required, minSize[6], maxSize[2000]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $traduccion;
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "num_revista";
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
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["validar"] = "required, minSize[1],min[1],custom[onlyNumberSp], maxSize[30]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $num_revista;
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "volumen";
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
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["validar"] = "required, minSize[1],min[1],custom[onlyNumberSp], maxSize[30]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $volumen;
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "anioR";
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
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["validar"] = "required, minSize[4],maxSize[4],custom[onlyNumberSp]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $anior;
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				// ------------------Control Lista Desplegable------------------------------
				$esteCampo = "tipo_revista";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["seleccion"] = $resultadoTraduccion [0] ['tipo_revista'];
				$atributos ["evento"] = 2;
				$atributos ["columnas"] = "1";
				$atributos ["limitar"] = false;
				$atributos ["tamanno"] = 1;
				$atributos ["ancho"] = "250px";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["validar"] = "required";
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["obligatorio"] = true;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				// -----De donde rescatar los datos ---------
				$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "tipo_revista" );
				$atributos ["baseDatos"] = "estructura";
				echo $this->miFormulario->campoCuadroLista ( $atributos );
				unset ( $atributos );
				
				echo $this->miFormulario->division ( "fin" );
				
				$atributos ["id"] = "Tlibro";
				$atributos ["estilo"] = "campoTexto";
				$atributos ["estiloEnLinea"] = $seleccionLibro;
				$verificarFormulario = "1";
				echo $this->miFormulario->division ( "inicio", $atributos );
				
				$esteCampo = "nom_libro";
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
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["validar"] = "required, minSize[6],maxSize[2000]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $nom_libro;
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
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
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["validar"] = "required, minSize[6],maxSize[2000]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $editorial;
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "anioL";
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
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["validar"] = "required, minSize[4],maxSize[4],custom[onlyNumberSp]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $aniol;
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				echo $this->miFormulario->division ( "fin" );
				                                
                                $esteCampo = "fechaTraduccAnterior";
				$atributos ["id"] = $esteCampo;
				$atributos ["tipo"] = "hidden";
				$atributos ["valor"] = $resultadoTraduccion [0] ['fecha'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
                                
				$esteCampo = "fechaTraducc";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = "40";
				$atributos ["ancho"] = 350;
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["deshabilitado"] = true;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["validar"] = "required";
				$atributos ["categoria"] = "fecha";
				$atributos ["valor"] = $resultadoTraduccion [0] ['fecha'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "numeActa";
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
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["validar"] = "required, minSize[1],min[1], maxSize[30]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultadoTraduccion [0] ['nume_acta'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "fechaActa";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = "34";
				$atributos ["ancho"] = 40;
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["deshabilitado"] = true;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["validar"] = "required";
				$atributos ["categoria"] = "fecha";
				$atributos ["valor"] = $resultadoTraduccion [0] ['fech_acta'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "numeCaso";
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
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["validar"] = "required, minSize[1],min[1],custom[onlyNumberSp], maxSize[30]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultadoTraduccion [0] ['nume_caso'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "puntaje";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = 5;
				$atributos ["columnas"] = 1;
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 300;
				$atributos ["validar"] = "required, custom[number],min[0.1],max[36]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultadoTraduccion [0] ['puntaje'];
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
                                $atributos["anchoEtiqueta"] = 310;
                                $atributos["validar"]="required";
                                $atributos["categoria"]="";
                                $atributos ["valor"] = $resultadoTraduccion [0] ['detalledocencia'];
                                echo $this->miFormulario->campoTextArea($atributos);
                                unset($atributos);
				
				// ------------------Fin Division para los botones-------------------------
				// echo $this->miFormulario->division("fin");
				
				// ------------------Division para los botones-------------------------
				$atributos ["id"] = "botones";
				$atributos ["estilo"] = "marcoBotones";
				echo $this->miFormulario->division ( "inicio", $atributos );
				
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
				// -------------Fin Contr
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
				echo $this->miFormulario->marcoAgrupacion ( "fin" );
				
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
