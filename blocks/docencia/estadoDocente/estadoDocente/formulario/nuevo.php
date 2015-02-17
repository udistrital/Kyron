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
// $valorCodificado ="pagina=registrarDocente";
$valorCodificado = "action=" . $esteBloque ["nombre"];
$valorCodificado .= "&solicitud=procesarNuevo";
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado = $cripto->codificar ( $valorCodificado );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";

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
$esteCampo = "seleccion";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["seleccion"] = 0; // 9
$atributos ["evento"] = 2;
$atributos ["limitar"] = false;
$atributos ["tamanno"] = 1;
$atributos ["estilo"] = "jqueryui";
$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
// -----De donde rescatar los datos -------ependencia in /usr/lo--
$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccionfiltrado" );
$atributos ["baseDatos"] = "docencia2";
echo $this->miFormulario->campoCuadroLista ( $atributos );
unset ( $atributos );

{ // ---------------Inicio Formulario (<form>)--------------------------------
	$atributos ["id"] = "numeroCedula";
	$atributos ["estilo"] = "campoAreaContenido";
	$atributos ["estiloEnLinea"] = "display:none";
	$verificarFormulario = "1";
	echo $this->miFormulario->division ( "inicio", $atributos );
	{
		// -------------Control cuadroTexto----------------------
		$esteCampo = "numeroIdentificacion";
		$atributos ["id"] = $esteCampo;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["obligatorio"] = true;
		$atributos ["tamanno"] = "10";
		$atributos ["tipo"] = "";
		$atributos ["estilo"] = "jqueryui";
		$atributos ["columnas"] = "1";
		$atributos ["validar"] = "required";
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "seleccionnumerocedula";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = 0; // 9
		$atributos ["evento"] = 2;
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos -------ependencia in /usr/lo--
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccionfiltrado" );
		$atributos ["baseDatos"] = "";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		 
	}
	echo $this->miFormulario->division ( "fin" );
}

{ // ---------------Inicio Formulario (<form>)--------------------------------
	$atributos ["id"] = "categoria";
	$atributos ["estilo"] = "campoAreaContenido";
	$atributos ["estiloEnLinea"] = "display:none";
	$verificarFormulario = "1";
	echo $this->miFormulario->division ( "inicio", $atributos );
	{
		
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "seleccioncategoria";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = 0; // 9
		$atributos ["evento"] = 2;
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos -------ependencia in /usr/lo--
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccioncategoria" );
		$atributos ["baseDatos"] = "docencia2";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "selecciondocente1";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = 0; // 9
		$atributos ["evento"] = 2;
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos -------ependencia in /usr/lo--
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccionfiltrado" );
		$atributos ["baseDatos"] = "";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
	
	}
	echo $this->miFormulario->division ( "fin" );
}

{ // ---------------Inicio Formulario (<form>)--------------------------------
	$atributos ["id"] = "facultad";
	$atributos ["estilo"] = "campoAreaContenido";
	$atributos ["estiloEnLinea"] = "display:none";
	$verificarFormulario = "1";
	echo $this->miFormulario->division ( "inicio", $atributos );
	{
		
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "seleccionfacultad";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = 0; // 9
		$atributos ["evento"] = 2;
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos -------ependencia in /usr/lo--
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccionfacultad" );
		$atributos ["baseDatos"] = "docencia2";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "selecciondocente2";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = 0; // 9
		$atributos ["evento"] = 2;
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos -------ependencia in /usr/lo--
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccionfiltrado" );
		$atributos ["baseDatos"] = "";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		
	}
	echo $this->miFormulario->division ( "fin" );
}

{ // ---------------Inicio Formulario (<form>)--------------------------------
	$atributos ["id"] = "proyectoCurricular";
	$atributos ["estilo"] = "campoAreaContenido";
	$atributos ["estiloEnLinea"] = "display:none";
	$verificarFormulario = "1";
	echo $this->miFormulario->division ( "inicio", $atributos );
	{
		
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "seleccionProyectoCurricular";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = 0; // 9
		$atributos ["evento"] = 2;
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos -------ependencia in /usr/lo--
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccionProyectoCurricular" );
		$atributos ["baseDatos"] = "docencia2";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "selecciondocente3";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = 0; // 9
		$atributos ["evento"] = 2;
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos -------ependencia in /usr/lo--
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccionfiltrado" );
		$atributos ["baseDatos"] = "";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
				
	}
	echo $this->miFormulario->division ( "fin" );
}

{ // ---------------Inicio Formulario (<form>)--------------------------------
	$atributos ["id"] = "todosparametros";
	$atributos ["estilo"] = "campoAreaContenido";
	$atributos ["estiloEnLinea"] = "display:none";
	$verificarFormulario = "1";
	echo $this->miFormulario->division ( "inicio", $atributos );
	{
		

		
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "seleccioncategoriaT";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = 0; // 9
		$atributos ["evento"] = 2;
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos -------ependencia in /usr/lo--
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccioncategoria" );
		$atributos ["baseDatos"] = "docencia2";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "seleccionfacultadT";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = 0; // 9
		$atributos ["evento"] = 2;
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos -------ependencia in /usr/lo--
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccionfacultad" );
		$atributos ["baseDatos"] = "docencia2";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "seleccionProyectoCurricularT";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = 0; // 9
		$atributos ["evento"] = 2;
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos -------ependencia in /usr/lo--
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccionProyectoCurricular" );
		$atributos ["baseDatos"] = "docencia2";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		// //-------------Control cuadroTexto-----------------------
		$esteCampo = "selecciondocente4";
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["seleccion"] = 0; // 9
		$atributos ["evento"] = 2;
		$atributos ["limitar"] = false;
		$atributos ["tamanno"] = 1;
		$atributos ["estilo"] = "jqueryui";
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// -----De donde rescatar los datos -------ependencia in /usr/lo--
		$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "seleccionfiltrado" );
		$atributos ["baseDatos"] = "";
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		
		
		
		
		//------------------ Check Box ------------------------------
		$esteCampo = "docentesTodos";
		$atributos["id"] = $esteCampo;
		$atributos["nombre"] = $esteCampo;
		$atributos["tabIndex"] = $tab++;
		$atributos["columnas"] = '1';
		$atributos["etiquetaObligatorio"] = true;
		$atributos["anchoEtiqueta"] = 50;
		$atributos["validar"] = "required";
// 		$atributos["obligatorio"] = true;
		$atributos["etiqueta"] = "Ver Historico del Resultado de la Consulta ";
		echo $this->miFormulario->campoCuadroSeleccion($atributos);
		unset($atributos);

	}
	echo $this->miFormulario->division ( "fin" );
}



echo $this->miFormulario->marcoAGrupacion ( "fin" );

// ------------------Division para los botones-------------------------
$atributos ["id"] = "botones";
$atributos ["estilo"] = "marcoBotones";
echo $this->miFormulario->division ( "inicio", $atributos );

// -------------Control Boton-----------------------
$esteCampo = "botonHistorico";
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

$esteCampo = "botonModificar";
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
