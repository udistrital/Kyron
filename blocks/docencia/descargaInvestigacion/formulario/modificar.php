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

$id_descarga = $_REQUEST ['idDescarga'];

$cadena_sql = $this->sql->cadena_sql ( "consultarDescargas", $id_descarga );
$resultadoDescarga = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

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
                                
                                $esteCampo = "docente";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["seleccion"] = $resultadoDescarga[0]['docente_descarga'];
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
				$esteCampo = "dependenciaDescarga";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["seleccion"] = $resultadoDescarga [0] ['dependencia_descarga'];
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
				$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "proyectos" );
				$atributos ["baseDatos"] = "estructura";
				echo $this->miFormulario->campoCuadroLista ( $atributos );
				unset ( $atributos );
				
				// ------------------Control Lista Desplegable------------------------------
				$esteCampo = "horasDescarga";
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
				$atributos ["validar"] = "required, min[1], minSize[1], custom[onlyNumberSp], max[168], maxSize[30]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultadoDescarga [0] ['horas_descarga'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "codigoDescarga";
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
				$atributos ["validar"] = "required, min[1], minSize[1], custom[onlyNumberSp], maxSize[30]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultadoDescarga [0] ['codigo_descarga'];
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
				$atributos ["anchoEtiqueta"] = 350;
				$atributos ["validar"] = "required, min[1], minSize[1], custom[onlyNumberSp], maxSize[30]";
				$atributos ["categoria"] = "";
				$atributos ["valor"] = $resultadoDescarga [0] ['numacta_descarga'];
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
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
