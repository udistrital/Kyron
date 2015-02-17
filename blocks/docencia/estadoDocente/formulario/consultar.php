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

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

{
	$tab = 1;
	
	include_once ("core/crypto/Encriptador.class.php");
	$cripto = Encriptador::singleton ();
	$valorCodificado = "&solicitud=nuevo";
	$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
	$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
	$valorCodificado = $cripto->codificar ( $valorCodificado );
	
	// ---------------Inicio Formulario (<form>)--------------------------------
	$atributos ["id"] = $nombreFormulario;
	$atributos ["tipoFormulario"] = "multipart/form-data";
	$atributos ["metodo"] = "POST";
	$atributos ["nombreFormulario"] = $nombreFormulario;
	$verificarFormulario = "1";
	echo $this->miFormulario->formulario ( "inicio", $atributos );
	
	// ------------------Division para los botones-------------------------
	$atributos ["id"] = "botones";
	$atributos ["estilo"] = "marcoBotones";
	echo $this->miFormulario->division ( "inicio", $atributos );
	
	// -------------Control Boton-----------------------
	$esteCampo = "botonvolver";
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
	
	echo $this->miFormulario->formulario ( "fin" );
}
$resultadoTitulos = unserialize ( $_REQUEST ['datos'] );

if ($resultadoTitulos) {
	// -----------------Inicio de Conjunto de Controles----------------------------------------
	$esteCampo = "marcoDatosResultadoParametrizar";
	$atributos ["estilo"] = "jqueryui";
	$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
	// echo $this->miFormulario->marcoAgrupacion("inicio", $atributos);
	unset ( $atributos );
	
	echo "<table id='tablaTitulos'>";
	
	echo "<thead>
                <tr>
					<th>Identificación</th>
                    <th>Nombres y Apellidos</th>
                    <th>Estado</th>
                    <th>Estado Complementario</th>                    
            		<th>Documento Soporte</th>        
					<th>Fecha Inicio Estado</th>
                    <th>Fecha Terminación Estado</th>
        			<th>Cambiar Estado</th>       		
                    <th>Modificar Estado</th>
					<th>Histórico Estado</th>
                </tr>
            </thead>
            <tbody>";
	
	for($i = 0; $i < count ( $resultadoTitulos ); $i ++) {

		$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) .  $this->miConfigurador->getVariableConfiguracion ( "site" ). "/blocks/docencia/" . $esteBloque ['nombre']."/funcion/forzarDescarga.php";
		
		
		
		
		$variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
		$variable .= "&solicitud=ModificarEstado";
		$variable .= "&usuario=" . $miSesion->getSesionUsuarioId ();
		$variable .= "&identificacion=" . $resultadoTitulos [$i] [0];
		$variable .= "&idEstado=" . $resultadoTitulos [$i] [9];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $directorio );
		
		$variable2 = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
		$variable2 .= "&solicitud=CambiarEstado";
		$variable2 .= "&usuario=" . $miSesion->getSesionUsuarioId ();
		$variable2 .= "&identificacion=" . $resultadoTitulos [$i] [0];
		$variable2 .= "&idEstado=" . $resultadoTitulos [$i] [9];
		$variable2 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable2, $directorio );
		
		$variable3 = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
		$variable3 .= "&solicitud=historicoEstadoDocente";
		$variable3 .= "&usuario=" . $miSesion->getSesionUsuarioId ();
		$variable3 .= "&identificacion=" . $resultadoTitulos [$i] [0];
		$variable3 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable3, $directorio );
		
		if ($resultadoTitulos [$i] [5] == '0001-01-01') {
			
			$resultadoTitulos [$i] [5] = 'No Aplica';
			$resultadoTitulos [$i] [6] = 'No Aplica';
		}
		
		$mostrarHtml = "<tr>
                    <td><center>" . $resultadoTitulos [$i] [0] . "</center></td>
                    <td><center>" . $resultadoTitulos [$i] [7] . " " . $resultadoTitulos [$i] [8] . "</center></td>
                    <td><center>" . $resultadoTitulos [$i] [1] . "</center></td>
                    <td><center>" . $resultadoTitulos [$i] [2] . "</center></td>";
		
		if ($resultadoTitulos [$i] [4] == 'No Aplica') {
			$mostrarHtml .= "<td><center>" . $resultadoTitulos [$i] [4] . "</center></td>";
		} else {
			
			$mostrarHtml .= " 
                    <td><center><A HREF=\"" .$resultadoTitulos [$i] [3]. "\" target=\"_blank\">" . $resultadoTitulos [$i] [4] . "</A></center></td>
                    		";
		}
		
		$mostrarHtml .= "
                    <td><center>" . $resultadoTitulos [$i] [5] . "</center></td>
                    <td><center>" . $resultadoTitulos [$i] [6] . "</center></td>
 					<td><center>
                        <a href='" . $variable2 . "'>
                            <img src='" . $rutaBloque . "/css/images/cambiar.png' width='15px'>
                        </a>
                   </center></td>
                   
                    <td><center>
                        <a href='" . $variable . "'>
                            <img src='" . $rutaBloque . "/css/images/edit.png' width='15px'>
                        </a>
                   </center></td>
     				<td><center>
                        <a href='" . $variable3 . "'>
                            <img src='" . $rutaBloque . "/css/images/historico.png' width='19px'>
                        </a>
                   </center></td>                            		
    		
                </tr>";
		
		echo $mostrarHtml;
		unset ( $mostrarHtml );
		unset ( $variable );
	}
	
	echo "</tbody>";
	
	echo "</table>";
	

	
	
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
	echo $this->miFormulario->formulario ( "inicio", $atributos );
	
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
	;
	echo $this->miFormulario->cuadroMensaje ( $atributos );
	unset ( $atributos );
	
	$valorCodificado = "pagina=" . $miPaginaActual;
	$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
	$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
	$valorCodificado = $cripto->codificar ( $valorCodificado );
	// -------------Fin Control Boton----------------------
	
	// ------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division ( "fin" );
	// ------------------Division para los botones-------------------------
	$atributos ["id"] = "botones";
	$atributos ["estilo"] = "marcoBotones";
	echo $this->miFormulario->division ( "inicio", $atributos );
	
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
}

?>