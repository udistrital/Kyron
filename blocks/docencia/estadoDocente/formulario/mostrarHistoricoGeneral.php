<?
echo "historico General";

// var_dump($_REQUEST['datos']);exit;

/***************************************************************************
 *   PHP Application Framework Version 10                                  *
 *   Copyright (c) 2003 - 2009                                             *
 *   Teleinformatics Technology Group de Colombia                          *
 *   ttg@ttg.com.co                                                        *
 *                                                                         *
****************************************************************************/


$registro=json_decode($_REQUEST['datos']); 

// var_dump($registro);exit;


foreach ( $registro  as $clave => $valor){
//  var_dump($valor->id_docente);exit;
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "Consultar Historico Docente", $valor->id_docente );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

	$respuesta[$clave]= $resultado;


}

// var_dump($respuesta);exit;


// var_dump($resultado);exit;


// exit;

$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

$nombreFormulario = $esteBloque ["nombre"];

include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton ();
// $valorCodificado ="pagina=registrarDocente";
$valorCodificado = "action=" . $esteBloque ["nombre"];
$valorCodificado .= "&solicitud=procesarCertificadoGeneral";
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&datos=" . $_REQUEST ["datos"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado = $cripto->codificar ( $valorCodificado );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";

//

$tab = 1;



// ------------------Division General-------------------------
$atributos ["id"] = "";

// Formulario para nuevos registros de usuario
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["estilo"] = "formularioConJqgrid";
$atributos ["nombreFormulario"] = $esteBloque ["nombre"];
echo $this->miFormulario->marcoFormulario ( "inicio", $atributos );

// -----------------Inicio de Conjunto de Controles----------------------------------------
$esteCampo = "marcoDatosBasicos";
$atributos ["estilo"] = "jqueryui";
$atributos ["leyenda"] = "Docentes";
echo $this->miFormulario->marcoAGrupacion ( "inicio", $atributos );
unset ( $atributos );

{ // ---------------Inicio Formulario (<form>)--------------------------------
	$atributos ["id"] = "historico";
	$atributos ["estilo"] = "campoAreaContenido";
	$atributos ["estiloEnLinea"] = "display:none";
	$verificarFormulario = "1";
	echo $this->miFormulario->division ( "inicio", $atributos );
	{
		$esteCampo = "nombreDoc";
		$atributos ["id"] = $esteCampo;
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
		$atributos ["estilo"] = "jqueryui";
		$atributos ["columnas"] = "1";
		// ****************************** Invento *****************************************
		$atributos ["texto"] = $resultado [0] ['nombre'];
		echo $this->miFormulario->campoTexto ( $atributos );
		unset ( $atributos );
	}
	echo $this->miFormulario->division ( "fin" );
}



$tab = 1;

if ($respuesta) {
	?>
<br>
<div align="center">
	<h1>Historico Docentes</h1>
</div>
<div id='demo'>
	<div id='example_wrapper' class='dataTables_wrapper' role='grid'>
		<table aria-describedby='example_info' class='display dataTable'
			id='example' border='0' cellpadding='0' cellspacing='0'>
			<!--Columnas-->
			<thead>
				<tr role='row'>
					<th aria-label='Documento' aria-sort='ascending'
						style='width: 128px;' colspan='1' rowspan='1'
						aria-controls='example' tabindex='0' role='columnheader'
					    class='sorting_asc'>Nombre Docente</th>
					<th aria-label='Documento' aria-sort='ascending'
						style='width: 128px;' colspan='1' rowspan='1'
						aria-controls='example' tabindex='0' role='columnheader'
						class='sorting_asc'>Estado Docente</th>
					<th aria-label='nombres' aria-sort='ascending'
						style='width: 128px;' colspan='1' rowspan='1'
						aria-controls='example' tabindex='0' role='columnheader'
						class='sorting_asc'>Estado Complementario</th>
					<th aria-label='Descripciont' aria-sort='ascending'
						style='width: 128px;' colspan='1' rowspan='1'
						aria-controls='example' tabindex='0' role='columnheader'
						class='sorting_asc'>Nombre Archivo Soporte</th>
					<th aria-label='Descripciont' aria-sort='ascending'
						style='width: 128px;' colspan='1' rowspan='1'
						aria-controls='example' tabindex='0' role='columnheader'
						class='sorting_asc'>Fecha Inicio de Estado</th>
					<th aria-label='Descripciont' aria-sort='ascending'
						style='width: 128px;' colspan='1' rowspan='1'
						aria-controls='example' tabindex='0' role='columnheader'
						class='sorting_asc'>Fecha Terminación de Estado</th>
					<th aria-label='Descripciont' aria-sort='ascending'
						style='width: 128px;' colspan='1' rowspan='1'
						aria-controls='example' tabindex='0' role='columnheader'
						class='sorting_asc'>Fecha Registro Estado</th>
				</tr>
			</thead>


			<tbody aria-relevant='all' aria-live='polite' role='alert'>
			<?php
			
			
	
// 		var_dump($respuesta);exit;	
			
	foreach ( $respuesta as $doc) {
        foreach ( $doc as $key => $row ) {
		?>
				<tr class='gradeA odd' align=center>
					<td class='  sorting_1'>
					 <?php echo $row[1]; ?>
					
					</td>
					</a>
					<td><?php echo $row[2]; ?></td>
					<td><?php echo $row[3];?></td>
					<td><?php echo $row[4]; ?></td>
					<td><?php echo $row[5]; ?></td>
					<td><?php echo $row[6]; ?></td>
					<td><?php echo $row[7]; ?></td>
				</tr>
				<?php
				}
	}
	?>
			</tbody>
		</table>
		<!--div id='example_info' class='dataTables_info'>Showing 1 to 10 of 57 entries</div><div id='example_paginate' class='dataTables_paginate paging_two_button'><a aria-controls='example' id='example_previous' class='paginate_disabled_previous' tabindex='0' role='button'>Previous</a><a aria-controls='example' id='example_next' class='paginate_enabled_next' tabindex='0' role='button'>Next</a></div-->
	</div>
</div>
<?php
}

{ // ------------------Division para los botones-------------------------
	$atributos ["id"] = "botones";
	$atributos ["estilo"] = "marcoBotones";
	echo $this->miFormulario->division ( "inicio", $atributos );
	
	$esteCampo = "botonPDF";
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
	
	$esteCampo = "botonExcel";
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
	
	echo $this->miFormulario->division ( "fin" );
	
	$atributos ["id"] = "botones1";
	$atributos ["estilo"] = "marcoBotones";
	echo $this->miFormulario->division ( "inicio", $atributos );
	
	$esteCampo = "botonVolver";
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
	
	// -------------Control cuadroTexto con campos ocultos-----------------------
	// Para pasar variables entre formularios o enviar datos para validar sesiones
	$atributos ["id"] = "formSaraData"; // No cambiar este nombre
	$atributos ["tipo"] = "hidden";
	$atributos ["obligatorio"] = false;
	$atributos ["etiqueta"] = "";
	$atributos ["valor"] = $valorCodificado;
	echo $this->miFormulario->campoCuadroTexto ( $atributos );
	unset ( $atributos );
	
	
	echo $this->miFormulario->division ( "fin" );
	
	// -------------Fin Control Boton---------------------
}
$atributos ["verificarFormulario"] = $verificarFormulario;
echo $this->miFormulario->formulario ( "fin", $atributos );

?>