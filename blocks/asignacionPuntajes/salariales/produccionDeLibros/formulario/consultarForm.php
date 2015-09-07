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

$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( "pagina" );

$nombreFormulario = $esteBloque ["nombre"];

$conexion = "inventarios";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

// validamos los datos que llegan



// $variable_fecha = $_REQUEST ['fechaRegistro'];

{
	$tab = 1;
	
	include_once ("core/crypto/Encriptador.class.php");
	$cripto = Encriptador::singleton ();
	
	// ---------------Inicio Formulario (<form>)--------------------------------
	$atributos ["id"] = $nombreFormulario;
	$atributos ["tipoFormulario"] = "multipart/form-data";
	$atributos ["metodo"] = "POST";
	$atributos ["nombreFormulario"] = $nombreFormulario;
	$atributos ["tipoEtiqueta"] = 'inicio';
	$verificarFormulario = "1";
	echo $this->miFormulario->formulario ( $atributos );
	
	
	$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		
	$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
	$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
	$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
		
	$variable = "pagina=" . $miPaginaActual;
	$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $directorio );
		
	// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
	$esteCampo = 'botonRegresar';
	$atributos ['id'] = $esteCampo;
	$atributos ['enlace'] = $variable;
	$atributos ['tabIndex'] = 1;
	$atributos ['estilo'] = 'textoSubtitulo';
	$atributos ['enlaceTexto'] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ['ancho'] = '10%';
	$atributos ['alto'] = '10%';
	$atributos ['redirLugar'] = true;
	echo $this->miFormulario->enlace ( $atributos );
		
	unset ( $atributos );
	
	
	
	$esteCampo = "Agrupacion";
	$atributos ['id'] = $esteCampo;
	$atributos ["estilo"] = "jqueryui";
	$atributos ['tipoEtiqueta'] = 'inicio';
	$atributos ['leyenda'] = "Registro Contratos";
	echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
	

	
	$valorCodificado = "pagina=" . $miPaginaActual;
	$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
	$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
	$valorCodificado = $cripto->codificar ( $valorCodificado );
	// -------------Control cuadroTexto con campos ocultos-----------------------
	// Para pasar variables entre formularios o enviar datos para validar sesiones
	$atributos ["id"] = "formSaraData"; // No cambiar este nombre
	$atributos ["tipo"] = "hidden";
	$atributos ["obligatorio"] = false;
	$atributos ["etiqueta"] = "";
	$atributos ["valor"] = $valorCodificado;
	echo $this->miFormulario->campoCuadroTexto ( $atributos );
	unset ( $atributos );

	
	
	
}

if (isset ( $_REQUEST ['num_contrato'] ) && $_REQUEST ['num_contrato'] != '') {
	$numeroContrato = $_REQUEST ['num_contrato'];
} else {
	$numeroContrato = '';
}

if (isset ( $_REQUEST ['fecha_inicio_c'] ) && $_REQUEST ['fecha_inicio_c'] != '') {
	// $fechaInicio = $_REQUEST ['fecha_inicio'];
	
	if ($_REQUEST ['fecha_final_c'] == '') {
		$esteCampo = "FechasError";
		$atributos ["id"] = $esteCampo; // Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
		$atributos ["etiqueta"] = '';
		$atributos ["estilo"] = "centrar";
		$atributos ["tipo"] = 'error';
		$atributos ["mensaje"] = $this->lenguaje->getCadena ( $esteCampo );
		
		echo $this->miFormulario->cuadroMensaje ( $atributos );
		unset ( $atributos );
		
		exit ();
	} else {
		
		$fechaInicio_C = $_REQUEST ['fecha_inicio_c'];
	}
} else {
	
	$fechaInicio_C = '';
}

if (isset ( $_REQUEST ['fecha_final_c'] ) && $_REQUEST ['fecha_final_c'] != '') {
	// $fechaInicio = $_REQUEST ['fecha_inicio'];
	
	if ($_REQUEST ['fecha_inicio_c'] == '') {
		$esteCampo = "FechasError";
		$atributos ["id"] = $esteCampo; // Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
		$atributos ["etiqueta"] = '';
		$atributos ["estilo"] = "centrar";
		$atributos ["tipo"] = 'error';
		$atributos ["mensaje"] = $this->lenguaje->getCadena ( $esteCampo );
		
		echo $this->miFormulario->cuadroMensaje ( $atributos );
		unset ( $atributos );
		
		exit ();
	} else {
		
		$fechaFin_C = $_REQUEST ['fecha_final_c'];
	}
} else {
	
	$fechaFin_C = '';
}

if (isset ( $_REQUEST ['fecha_inicio_r'] ) && $_REQUEST ['fecha_inicio_r'] != '') {
	// $fechaInicio = $_REQUEST ['fecha_inicio'];
	
	if ($_REQUEST ['fecha_final_r'] == '') {
		$esteCampo = "FechasError";
		$atributos ["id"] = $esteCampo; // Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
		$atributos ["etiqueta"] = '';
		$atributos ["estilo"] = "centrar";
		$atributos ["tipo"] = 'error';
		$atributos ["mensaje"] = $this->lenguaje->getCadena ( $esteCampo );
		
		echo $this->miFormulario->cuadroMensaje ( $atributos );
		unset ( $atributos );
		
		exit ();
	} else {
		
		$fechaInicio_R = $_REQUEST ['fecha_inicio_r'];
	}
} else {
	
	$fechaInicio_R = '';
}

if (isset ( $_REQUEST ['fecha_final_r'] ) && $_REQUEST ['fecha_final_r'] != '') {
	// $fechaInicio = $_REQUEST ['fecha_inicio'];
	
	if ($_REQUEST ['fecha_inicio_r'] == '') {
		$esteCampo = "FechasError";
		$atributos ["id"] = $esteCampo; // Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
		$atributos ["etiqueta"] = '';
		$atributos ["estilo"] = "centrar";
		$atributos ["tipo"] = 'error';
		$atributos ["mensaje"] = $this->lenguaje->getCadena ( $esteCampo );
		
		echo $this->miFormulario->cuadroMensaje ( $atributos );
		unset ( $atributos );
		
		exit ();
	} else {
		
		$fechaFin_R = $_REQUEST ['fecha_final_r'];
	}
} else {
	
	$fechaFin_R = '';
}

$arreglo = array (
		$numeroContrato,
		$fechaInicio_C,
		$fechaFin_C,
		$fechaInicio_R,
		$fechaFin_R 
);
unset($resultadoContratos);
$cadena_sql = $this->sql->cadena_sql ( "consultarContrato", $arreglo );

$resultadoContratos = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );


if ($resultadoContratos) {
	
	
	
	
	// -----------------Inicio de Conjunto de Controles----------------------------------------
	$esteCampo = "marcoDatosResultadoParametrizar";
	$atributos ["estilo"] = "jqueryui";
// 	$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
	echo $this->miFormulario->marcoAgrupacion("inicio", $atributos);
	unset ( $atributos );
	
	echo "<table id='tablaContratos'>";
	
	echo "<thead>
                <tr>
		     <th>Número Contrato</th>
			 <th>Identificación<br>Contratista</th>
             <th>Fecha Contrato</th>
			 <th>Fecha Registro</th>
             <th>Documento</th>
             <th>Modificar</th>
        	 </tr>
            </thead>
            <tbody>";
	
	for($i = 0; $i < count ( $resultadoContratos ); $i ++) {
		
		$variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
		$variable .= "&opcion=modificar";
		$variable .= "&contrato=" . $resultadoContratos [$i] [4];
		$variable .= "&nombre_contrato=" . $resultadoContratos [$i] [0];
		$variable .= "&identificador_contrato=" . $resultadoContratos [$i] [9];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $directorio );
		
		$mostrarHtml = "<tr>
					
				    <td><center>" . $resultadoContratos [$i] [6] . "</center></td>
                    <td><center>" . $resultadoContratos [$i] [5] . "</center></td>
                    <td><center>" . $resultadoContratos [$i] [7] . "</center></td>
                    <td><center>" . $resultadoContratos [$i] [8] . "</center></td>
                    <td><center><A HREF=\"" . $resultadoContratos [$i] [2] . "\" target=\"_blank\">" . $resultadoContratos [$i] [0] . "</A></center></td>
                    <td><center>
                        <a href='" . $variable . "'>                        
                            <img src='" . $rutaBloque . "/images/edit.png' width='15px'> 
                        </a>
                   </center></td>
                </tr>";
		echo $mostrarHtml;
		unset ( $mostrarHtml );
		unset ( $variable );
	}
	
	echo "</tbody>";
	
	echo "</table>";
	
	echo $this->miFormulario->agrupacion ( 'fin' );
	unset ( $atributos );
	
	
	// Fin de Conjunto de Controles
	// echo $this->miFormulario->marcoAgrupacion("fin");
} else {
	$nombreFormulario = $esteBloque ["nombre"];
	include_once ("core/crypto/Encriptador.class.php");
	$cripto = Encriptador::singleton ();
	$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";
	
	$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( "pagina" );
	
	$tab = 1;
	// ---------------Inicio Formulario (<form>)--------------------------------
	$atributos ["id"] = $nombreFormulario;
	$atributos ["tipoFormulario"] = "multipart/form-data";
	$atributos ["metodo"] = "POST";
	$atributos ["nombreFormulario"] = $nombreFormulario;
	$verificarFormulario = "1";
	$atributos ['marco'] = true;
	$atributos ['tipoEtiqueta'] = 'inicio';
	echo $this->miFormulario->formulario ( $atributos );
	
	$atributos ["id"] = "divNoEncontroEgresado";
	$atributos ["estilo"] = "marcoBotones";
	// $atributos["estiloEnLinea"]="display:none";
	echo $this->miFormulario->division ( "inicio", $atributos );
	
	// -------------Control Boton-----------------------
	$esteCampo = "noEncontroProcesos";
	$atributos ["id"] = $esteCampo; // Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
	$atributos ["etiqueta"] = "";
	$atributos ["estilo"] = "centrar";
	$atributos ["tipo"] = 'error';
	$atributos ["mensaje"] = $this->lenguaje->getCadena ( $esteCampo );
	
	echo $this->miFormulario->cuadroMensaje ( $atributos );
	unset ( $atributos );
	
	$valorCodificado = "pagina=" . $miPaginaActual;
	$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
	$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
	$valorCodificado = $cripto->codificar ( $valorCodificado );
	// -------------Fin Control Boton----------------------
	// ------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division ( "fin" );
	
	
	echo $this->miFormulario->agrupacion ( 'fin' );
	unset ( $atributos );
	// -------------Control cuadroTexto con campos ocultos-----------------------
	// Para pasar variables entre formularios o enviar datos para validar sesiones
	$atributos ["id"] = "formSaraData"; // No cambiar este nombre
	$atributos ["tipo"] = "hidden";
	$atributos ["obligatorio"] = false;
	$atributos ["etiqueta"] = "";
	$atributos ["valor"] = $valorCodificado;
	echo $this->miFormulario->campoCuadroTexto ( $atributos );
	unset ( $atributos );
	

}


$atributos ['marco'] = true;
$atributos ['tipoEtiqueta'] = 'fin';
echo $this->miFormulario->formulario ( $atributos );
unset($atributos);


?>