<?php

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
$ruta = $this->miConfigurador->getVariableConfiguracion ( 'raizDocumento' );
include ($ruta . '/classes/html2pdf/html2pdf.class.php');

$respuesta=unserialize($_REQUEST['datos']);
// var_dump($respuesta);exit;
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "";

function paginas($contenidoDatos, $nombre, $directorio) {
	$contenidoPagina = "<page backtop='1mm' backbottom='1mm' backleft='1mm' backright='1mm'>";
	$contenidoPagina .= "<page_header>
			
        <table align='center' style='width: 100%;'>
            <tr>
                <td align='center' >
                    <img src='" . $directorio . "css/images/escudo.jpg'>
                </td>
                <td align='center' >
                    <font size='12px'><b>UNIVERSIDAD DISTRITAL</b></font>
                    <br>
                    <font size='12px'><b>FRANCISCO JOSÉ DE CALDAS</b></font>
                    <br>
                    <font size='9px'><b>DOCUMENTO HISTÓRICO ESTADO DOCENTE</b></font>
                    <br>
                    <font size='9px'><b>" . date ( "Y-m-d" ) . "</b></font>				
                </td>
                <td align='center' >
                    <img src='" . $directorio . "css/images/sabio.jpg' width='60'>
                </td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table align='center' width = '100%'>
            <tr>
                <td align='center'>
                    <img src='" . $directorio . "css/images/escudo.jpg'>
                </td>
            </tr>
            <tr>
                <td align='center'>
                    Universidad Distrital Francisco José de Caldas
                    <br>
                    Todos los derechos reservados.
                    <br>
                    Carrera 8 N. 40-78 Piso 1 / PBX 3238400 - 3239300
                    <br>
                           
                </td>
            </tr>
        </table>
    </page_footer>";
	
	$contenidoPagina .= "
     <table>
            <tr>
                <td>
<br><br><br><br>
                <p><h5>&nbsp; &nbsp; &nbsp; Este Documento muestra el histórico  estado del siguiente docente :  “".$nombre."“ </h5></p>
                
                 
                </td>
            </tr>
        </table>
    <style>
td{
  font-size: 13px;
}
</style>
                		
                		";
	
	$contenidoPagina .= "<table width=\"30%\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" class='bordered' align=\"center \">
		
		
		
		
	<!--Columnas-->
					<thead>
				<tr role='row'>
					<th aria-label='Documento' aria-sort='ascending'
						style='width: 100px;' colspan='1' rowspan='1'
						aria-controls='example' tabindex='0' role='columnheader'
						class='sorting_asc'>Estado Docente</th>
					<th aria-label='nombres' aria-sort='ascending'
						style='width: 230px;' colspan='1' rowspan='1'
						aria-controls='example' tabindex='0' role='columnheader'
						class='sorting_asc'>Estado Complementario</th>
					<th aria-label='Descripciont' aria-sort='ascending'
						style='width: 200px;' colspan='1' rowspan='1'
						aria-controls='example' tabindex='0' role='columnheader'
						class='sorting_asc'>Nombre Archivo Soporte</th>
					<th aria-label='Descripciont' aria-sort='ascending'
						style='width: 180px;' colspan='1' rowspan='1'
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
 

";
	
	$contenidoPagina .= $contenidoDatos;
	
	$contenidoPagina .= "   	  </table>";
	
	$contenidoPagina .= "</page> ";
	
	return $contenidoPagina;
}
function armarContenido($NoRegistros, $respuesta, $directorio) {
	$pagina = '';
	$contenido = '';
	$i = 0;
	$Modulo = $NoRegistros;
	foreach ( $respuesta as $res ) {
		$contenido .= "<tr class='gradeA odd' align=center> ";
		$contenido .= "<td>" . $res [1] . " </td>";
		$contenido .= "<td>" . $res [2] . " </td>";
		$contenido .= "<td>" . $res [4] . " </td>";
		$contenido .= "<td>" . $res [5] . " </td>";
		$contenido .= "<td>" . $res [6] . " </td>";
		$contenido .= "<td>" . $res [10] . " </td>";
		$contenido .= "</tr>";
		
		if ($i == 24) {
			$paginaPDF = paginas ( $contenido, $respuesta [0] [7]." ".$respuesta [0] [8], $directorio );
			$pagina .= $paginaPDF;
			$contenido = '';
			
			$Modulo = $Modulo - 24;
			$i = 0;
		}
		
		if ($Modulo > 0 && $Modulo < 24 && $i == ($Modulo - 1)) {
			$paginaPDF = paginas ( $contenido, $respuesta [0] [7]." ".$respuesta [0] [8], $directorio );
			$pagina .= $paginaPDF;
			$contenido = '';
		}
		$i ++;
	}
	return $pagina;
}



$pagina=armarContenido(count($respuesta), $respuesta,$directorio);

$html2pdf = new HTML2PDF ( 'L', 'LETTER', 'es' );

// $html2pdf->pdf->SetDisplayMode('fullpage');
$res = $html2pdf->WriteHTML ( $pagina );
clearstatcache();
$html2pdf->Output ( 'Historial  Estado del Docente.pdf', 'D' );

// $html2pdf->Output ( 'certificado.pdf' );
?>