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

$id_inter = $_REQUEST ['idInterpretacion'];

$cadena_sql = $this->sql->cadena_sql ( "consultarInterpretacionDocenteModificar", $id_inter );
$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

?>
    <?php
				$atributos ["id"] = "CuadroModificarRegistros";
				$atributos ["estilo"] = "";
				// $atributos["estiloEnLinea"]="display:none";
				echo $this->miFormulario->division ( "inicio", $atributos );
				
				$esteCampo = "identificacion";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["seleccion"] = $_REQUEST ['identificacion'];
				$atributos ["evento"] = 2;
				$atributos ["columnas"] = "1";
				$atributos ["limitar"] = false;
				$atributos ["tamanno"] = 1;
				$atributos ["ancho"] = "400px";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["validar"] = "required";
				$atributos ["anchoEtiqueta"] = 330;
				$atributos ["obligatorio"] = true;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				// -----De donde rescatar los datos ---------
				$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarNombreDocente" );
				$atributos ["baseDatos"] = "estructura";
				echo $this->miFormulario->campoCuadroLista ( $atributos );
				unset ( $atributos );
				
				// ------------------Control Lista Desplegable------------------------------
				$esteCampo = "tituloInterpretacion";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = 40;
				$atributos ["columnas"] = 1;
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 330;
				$atributos ["validar"] = "required, minSize[6],maxSize[2000]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultado [0]['titulo_interpretacion'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "entidad";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["seleccion"] = $resultado[0]['entidad_interpretacion'];
				$atributos ["evento"] = 2;
				$atributos ["columnas"] = "1";
				$atributos ["limitar"] = false;
				$atributos ["tamanno"] = 1;
				$atributos ["ancho"] = "250px";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["validar"] = "required";
				$atributos ["anchoEtiqueta"] = 330;
				$atributos ["obligatorio"] = true;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				// -----De donde rescatar los datos ---------
				$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "universidad" );
				$atributos ["baseDatos"] = "estructura";
				echo $this->miFormulario->campoCuadroLista ( $atributos );
				unset ( $atributos );
				
				// ------------------Control Lista Desplegable------------------------------
				$esteCampo = "numPresentacion";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = 30;
				$atributos ["columnas"] = 1;
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 330;
				$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30],custom[onlyNumberSp]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultado [0]['numpres_interpretacion'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "fechPresentacion";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = "8";
				$atributos ["ancho"] = 350;
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ["deshabilitado"] = true;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 330;
				$atributos ["validar"] = "required";
				$atributos ["categoria"] = "fecha";
				$atributos ["valor"] = $resultado [0]['fecha_intepretacion'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "autorPresentacion";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = 30;
				$atributos ["columnas"] = 1;
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 330;
				$atributos ["validar"] = "required, minSize[6],maxSize[2000]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultado [0]['autor_interpretacion'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "numeActa";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = 30;
				$atributos ["columnas"] = 1;
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 330;
				$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30],custom[onlyNumberSp]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultado [0] ['numacta_interpretacion'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "fechaActa";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = "8";
				$atributos ["ancho"] = 350;
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ["deshabilitado"] = true;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 330;
				$atributos ["validar"] = "required";
				$atributos ["categoria"] = "fecha";
				$atributos ["valor"] = $resultado [0]['fechacta_interpretacion'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "numeCaso";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = 30;
				$atributos ["columnas"] = 1;
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 330;
				$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30],custom[onlyNumberSp]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultado [0]['numcaso_interpretacion'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "puntaje";
				$atributos ["id"] = $esteCampo;
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = 8;
				$atributos ["columnas"] = 1;
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 330;
				$atributos ["validar"] = "required, custom[number],min[0.1], max[48]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultado [0]['puntaje_interpretacion'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
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
