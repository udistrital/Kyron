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

$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( "pagina" );

$nombreFormulario = $esteBloque ["nombre"];

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

$cadena = $this->sql->cadena_sql ( "Consultar Historico Docente", $_REQUEST['identificacion']	 );
$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );
$datos=serialize($resultado); 

$cadena = $this->sql->cadena_sql ( "consultarDocente", $_REQUEST ['identificacion'] );
$docente = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );




{
	$tab = 1;
	
	include_once ("core/crypto/Encriptador.class.php");
	$cripto = Encriptador::singleton ();
	$valorCodificado = "&solicitud=historico";
	$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
	$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
	$valorCodificado .= "&action=" .$esteBloque ["nombre"];
	$valorCodificado .= "&identificacion=" . $_REQUEST ['identificacion'] ;
	$valorCodificado .= "&datos=" .$datos;
	$valorCodificado = $cripto->codificar ( $valorCodificado );
	
	// ---------------Inicio Formulario (<form>)--------------------------------
	$atributos ["id"] = $nombreFormulario;
	$atributos ["tipoFormulario"] = "multipart/form-data";
	$atributos ["metodo"] = "POST";
	$atributos ["nombreFormulario"] = $nombreFormulario;
	$verificarFormulario = "1";
	echo $this->miFormulario->formulario ( "inicio", $atributos );
	
	

	
	
	$esteCampo = "marcoDatosBasicos";
	$atributos ["estilo"] = "jqueryui";
	$atributos ["leyenda"] = "Docente : " . $docente [0] [1] . "<br>Identificación: " . $docente [0] [0];
	echo $this->miFormulario->marcoAGrupacion ( "inicio", $atributos );
	
	
	
	
	// ------------------Division para los botones-------------------------
	$atributos ["id"] = "botones";
	$atributos ["estilo"] = "marcoBotones";
	echo $this->miFormulario->division ( "inicio", $atributos );
	
	// -------------Control Boton-----------------------
	$esteCampo = "volver";
	$atributos ["id"] = $esteCampo;
	$atributos ["tabIndex"] = $tab ++;
	$atributos ["tipo"] = "boton";
	$atributos ["columnas"] = 2;
	$atributos ["estilo"] = "";
	$atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
	$atributos ["tipoSubmit"] = "jquery"; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
	$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
	$atributos ["nombreFormulario"] = $nombreFormulario;
	echo $this->miFormulario->campoBoton ( $atributos );
	unset ( $atributos );
	
	
	echo $this->miFormulario->division ( "fin" );
	// ------------------Control Lista Desplegable------------------------------
	$esteCampo = "tiporeporte";
	$atributos ["id"] = $esteCampo;
	$atributos ["tabIndex"] = $tab ++;
	$atributos ["seleccion"] = 1;
	$atributos ["evento"] = 2;
	$atributos ["columnas"] = 2;
	$atributos ["limitar"] = false;
	$atributos ["tamanno"] = 1;
	$atributos ["ancho"] = "200px";
	$atributos ["estilo"] = "jqueryui";
	$atributos ["etiquetaObligatorio"] = false;
	$atributos ["validar"] = "required";
	$atributos ["anchoEtiqueta"] = 330;
	$atributos ["obligatorio"] = true;
	$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
	// -----De donde rescatar los datos ---------
	$atributos ["cadena_sql"] = array (
			array (
					'1',
					'PDF'
			),
			array (
					'2',
					'EXCEL'
			)
	);
	$atributos ["baseDatos"] = "estructura";
	echo $this->miFormulario->campoCuadroLista ( $atributos );
	unset ( $atributos );
	
	
	
	// ------------------Division para los botones-------------------------
	$atributos ["id"] = "botones";
	$atributos ["estilo"] = "marcoBotones";
	echo $this->miFormulario->division ( "inicio", $atributos );
	
	// -------------Control Boton-----------------------
	$esteCampo = "reporte";
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



// var_dump($resultado);exit;
if ($resultado) {
	// -----------------Inicio de Conjunto de Controles----------------------------------------
	$esteCampo = "marcoDatosResultadoParametrizar";
	$atributos ["estilo"] = "jqueryui";
	$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
	// echo $this->miFormulario->marcoAgrupacion("inicio", $atributos);
	unset ( $atributos );
	
	echo "<table id='tablaTitulos'>";
	
	echo "<thead>
                <tr>
                    <th>Estado</th>
                    <th>Estado Complementario</th>                    
            		<th>Documento Soporte</th>        
					<th>Fecha Inicio Estado</th>
                    <th>Fecha Terminación Estado</th>
        			<th>Fecha de Registro</th>       		
                </tr>
            </thead>
            <tbody>";
	
	for($i = 0; $i < count ( $resultado ); $i ++) {
		
		$variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
		$variable .= "&solicitud=ModificarEstado";
		$variable .= "&usuario=" . $miSesion->getSesionUsuarioId ();
		$variable .= "&identificacion=" . $resultado [$i] [0];
		$variable .= "&idEstado=" . $resultado [$i] [9];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $directorio );
		
		$variable2 = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
		$variable2 .= "&solicitud=CambiarEstado";
		$variable2 .= "&usuario=" . $miSesion->getSesionUsuarioId ();
		$variable2 .= "&identificacion=" . $resultado [$i] [0];
		$variable2 .= "&idEstado=" . $resultado [$i] [9];
		$variable2 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable2, $directorio );
		
		$variable3 = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
		$variable3 .= "&solicitud=historicoEstadoDocente";
		$variable3 .= "&usuario=" . $miSesion->getSesionUsuarioId ();
		$variable3 .= "&identificacion=" . $resultado [$i] [0];
		$variable3 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable3, $directorio );
		
		$mostrarHtml = "<tr>
                    <td><center>" . $resultado [$i] [1] . "</center></td>
                    <td><center>" . $resultado [$i] [2] . "</center></td>
                    <td><center><A HREF=\"" . $resultado [$i] [3] . "\" target=\"_blank\">" . $resultado [$i] [4] . "</A></center></td>
                    <td><center>" . $resultado [$i] [5] . "</center></td>
                    <td><center>" . $resultado [$i] [6] . "</center></td>
                    <td><center>" . $resultado [$i] [10] . "</center></td>
 				                        		
    		
                </tr>";
		echo $mostrarHtml;
		unset ( $mostrarHtml );
		unset ( $variable );
	}
	
	echo "</tbody>";
	
	echo "</table>";
	
	
	
	
	echo $this->miFormulario->marcoAGrupacion ( "fin" );
	
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