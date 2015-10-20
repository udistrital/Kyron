<?php
//Se establece el espacio de nombre
namespace gui\accesoIncorrecto\formulario;
// Se verifica si el usuario está autorizado
if (!isset($GLOBALS['autorizado'])) {
	include ('../index.php');
	exit();
}

class Form {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	function __construct($lenguaje, $formulario) {
		$this -> miConfigurador = \Configurador::singleton();

		$this -> miConfigurador -> fabricaConexiones -> setRecursoDB('principal');

		$this -> lenguaje = $lenguaje;

		$this -> miFormulario = $formulario;
	}

	function miForm() {
		// Rescatar los datos de este bloque
		$esteBloque = $this -> miConfigurador -> getVariableConfiguracion("esteBloque");
		echo '
			<table align="center" width="80%" cellpadding="7" border=0>
			<tr><td>
			<table width="100%" align="center"><tr>
			<td><img src="/error/escud.gif" WIDTH=120 HEIGHT=150></td>
			<td >
			<h1 align="center">UNIVERSIDAD DISTRITAL <br>"FRANCISCO JOS&Eacute; DE CALDAS"</h1><br>
			<h2 align="center">OFICINA ASESORA DE SISTEMAS.</h2></td>
			<td><img src="/error/oas.png" WIDTH=100 HEIGHT=100></td>			
			</tr></table>			
			</td>			
			</tr>
			<tr>
			<td bgcolor="#DC011B" valign="middle">
			<h1 align="center"><blink>LA PAGINA NO EXISTE<blink></h1>
			
			</td>
			</tr>
			<tr>
			<td align="center"><h3>Se ha creado un registro de acceso ilegal desde la direcci&oacute;n: <b>'.$_SERVER['REMOTE_ADDR'].'</b>.</h3></td>
			</tr>
			<tr>
			<td align="center">
			Si considera que esto es un error por favor comuniquese con el administrador del sistema.
			</td>
			</tr>
			<tr>
			<td style="font-size:12;" align="center">
			<hr>
			Ambiente de desarrollo para aplicaciones web.<br>
			Universidad Distrital Francisco Jos&eacute; de Caldas. <br>
			Oficina Asesora de Sistemas
			</td>
			</tr>
			</table>
		';	
	}

	function mensaje() {

		// Si existe algun tipo de error en el login aparece el siguiente mensaje
		$mensaje = $this -> miConfigurador -> getVariableConfiguracion('mostrarMensaje');
		$this -> miConfigurador -> setVariableConfiguracion('mostrarMensaje', null);

		if ($mensaje) {
			$tipoMensaje = $this -> miConfigurador -> getVariableConfiguracion('tipoMensaje');
			if ($tipoMensaje == 'json') {

				$atributos['mensaje'] = $mensaje;
				$atributos['json'] = true;
			} else {
				$atributos['mensaje'] = $this -> lenguaje -> getCadena($mensaje);
			}
			// ------------------Division para los botones-------------------------
			$atributos['id'] = 'divMensaje';
			$atributos['estilo'] = 'marcoBotones';
			echo $this -> miFormulario -> division("inicio", $atributos);

			// -------------Control texto-----------------------
			$esteCampo = 'mostrarMensaje';
			$atributos["tamanno"] = '';
			$atributos["estilo"] = 'information';
			$atributos["etiqueta"] = '';
			$atributos["columnas"] = '';
			// El control ocupa 47% del tamaño del formulario
			echo $this -> miFormulario -> campoMensaje($atributos);
			unset($atributos);

			// ------------------Fin Division para los botones-------------------------
			echo $this -> miFormulario -> division("fin");
		}
	}

}

$miSeleccionador = new Form($this -> lenguaje, $this -> miFormulario);

$miSeleccionador -> mensaje();

$miSeleccionador -> miForm();
?>