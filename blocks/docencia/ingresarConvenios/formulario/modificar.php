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
// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = $nombreFormulario;
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario ( "inicio", $atributos );

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

$cadena_sql = $this->sql->cadena_sql ( "consultarConvenioModificar", $_REQUEST ['idConvenio'] );

$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

// var_dump ( $resultado );

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
				
				$esteCampo = "identificacion";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["seleccion"] = $resultado [0] ['id_docente'];
				$atributos ["evento"] = 2;
				$atributos ["columnas"] = "1";
				$atributos ["limitar"] = false;
				$atributos ["tamanno"] = 1;
				$atributos ["ancho"] = "357px";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["validar"] = "required";
				$atributos ["anchoEtiqueta"] = 315;
				$atributos ["obligatorio"] = true;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				// -----De donde rescatar los datos ---------
				$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarNombreDocente" );
				$atributos ["baseDatos"] = "estructura";
				echo $this->miFormulario->campoCuadroLista ( $atributos );
				
				// ------------------Control Lista Desplegable------------------------------
				$esteCampo = "nombre_convenio";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = 43;
				$atributos ["columnas"] = 1;
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 315;
				$atributos ["validar"] = "required, minSize[6], maxSize[2000]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultado [0] ['convenio_nombre'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "monto_convenio";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = 20;
				$atributos ["columnas"] = 1;
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 315;
				$atributos ["validar"] = "required, custom[number],min[1],maxSize[30]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultado [0] ['convenio_monto'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "rol_docente";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["seleccion"] = $resultado [0] ['convenio_rol'];
				$atributos ["evento"] = 2;
				$atributos ["columnas"] = "1";
				$atributos ["limitar"] = false;
				$atributos ["tamanno"] = 1;
				$atributos ["ancho"] = "180px";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["validar"] = "required";
				$atributos ["anchoEtiqueta"] = 315;
				$atributos ["obligatorio"] = true;
				$atributos ["validar"] = "required";
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				// -----De donde rescatar los datos ---------
				$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "rol_convenio" );
				$atributos ["baseDatos"] = "estructura";
				echo $this->miFormulario->campoCuadroLista ( $atributos );
				unset ( $atributos );
				
				

				$esteCampo = "nom_documento";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = 31;
				$atributos ["columnas"] = 1;
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 315;
				$atributos ["validar"] = "required, custom[number],min[1],maxSize[30]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultado[0]['nombre_documento'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );

				
				// ------------------Control Lista Desplegable------------------------------
				$esteCampo = "actualizarDoc";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["seleccion"] = 1;
				$atributos ["evento"] = 2;
				$atributos ["columnas"] = 1;
				$atributos ["limitar"] = false;
				$atributos ["tamanno"] = 1;
				$atributos ["ancho"] = "60px";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ["validar"] = "required";
				$atributos ["anchoEtiqueta"] = 315;
				$atributos ["obligatorio"] = true;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				// -----De donde rescatar los datos ---------
				$atributos ["cadena_sql"] = array (
						array (
								'1',
								'No'
						),
						array (
								'2',
								'Si'
						)
				);
				$atributos ["baseDatos"] = "estructura";
				echo $this->miFormulario->campoCuadroLista ( $atributos );
				unset ( $atributos );
				
				$atributos ["id"] = "cargaDoc";
				$atributos ["estilo"] = "jqueryui";
				echo $this->miFormulario->division ( "inicio", $atributos );
				// ------------------Fin Division para los botones-------------------------
				// echo $this->miFormulario->division("fin");
				// ------------------Division para los botones-------------------------
				$atributos ["id"] = "botones";
				$atributos ["estilo"] = "marcoBotones";
				echo $this->miFormulario->division ( "inicio", $atributos );
				
				$esteCampo = "documento_soporte";
				$atributos ["id"] = $esteCampo; // No cambiar este nombre
				$atributos ["tipo"] = "file";
				$atributos ["obligatorio"] = false;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["columnas"] = 2;
				$atributos ["estilo"] = "textoIzquierda";
				$atributos ["anchoEtiqueta"] = 290;
				$atributos ["tamanno"] = 500000;
				$atributos ["validar"] = "required";
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["valor"] = $resultado[0]['nombre_documento'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				echo $this->miFormulario->division ( "fin" );
				
				
				echo $this->miFormulario->division ( "fin" );
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
