<?php

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
$ruta = $this->miConfigurador->getVariableConfiguracion ( 'raizDocumento' );
include ($ruta . '/classes/html2pdf/html2pdf.class.php');

// echo "EXCEL";exit;

$conexion = "docencia2";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "Consultar Historico Docente", $_REQUEST ['datos'] );
$respuesta = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
// echo count($respuesta);exit;
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/";

$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" ); // Because esteBloque is an array OK
global $ruta;
$ruta = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/" . $esteBloque ["grupo"] . "/" . $esteBloque ["nombre"];
require ($ruta . '/librerias/PHPExcel.php');

global $url;
$rutaDocumentos = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/" . $esteBloque ["grupo"] . "/" . $esteBloque ["nombre"] . "/documentos";
$url = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "documentos";
global $url2;
$url2 = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "imagen/";

/**
 * **************************************************************************
 */

$objPHPExcel = new PHPExcel ();

/**
 * Titulo
 */
$objPHPExcel->getActiveSheet ()->mergeCells ( 'A1:F1' );
$objPHPExcel->getActiveSheet ()->getStyle ( 'A1:F1' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getFont ()->setName ( 'Arial' );
$objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getFont ()->setSize ( 15 );
$objPHPExcel->setActiveSheetIndex ( 0 )->getRowDimension ( '1' )->setRowHeight ( 40 );
$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'A1', 'Universidad Distrital "Francisco Jose de Caldas"' );

/**
 * Encabezado
 */
$objPHPExcel->getActiveSheet ()->mergeCells ( 'B3:E3' );
$objPHPExcel->getActiveSheet ()->getStyle ( 'B3:E3' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$objPHPExcel->getActiveSheet ()->getStyle ( 'B3' )->getFont ()->setName ( 'Arial' );
$objPHPExcel->getActiveSheet ()->getStyle ( 'B3' )->getFont ()->setSize ( 11 );
$objPHPExcel->setActiveSheetIndex ( 0 )->getRowDimension ( '3' )->setRowHeight ( 20 );
$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'B3', 'Historico Estado Docente' );
$objPHPExcel->getActiveSheet ()->mergeCells ( 'B4:E4' );
$objPHPExcel->getActiveSheet ()->getStyle ( 'B4:E4' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'B4', $respuesta [0] [1] );

/**
 * Crear nuevo objeto de imagen
 */
/**
 * Orientacion, tamaño y escala
 */
$objPageSetup = new PHPExcel_Worksheet_PageSetup ();
$objPageSetup->setPaperSize ( PHPExcel_Worksheet_PageSetup::PAPERSIZE_A2_PAPER );
$objPageSetup->setOrientation ( PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE );
$objPHPExcel->getActiveSheet ()->setBreak ( 'A40', PHPExcel_Worksheet::BREAK_ROW );
$objPHPExcel->getActiveSheet ()->setBreak ( 'O1', PHPExcel_Worksheet::BREAK_COLUMN );
$objPageSetup->setFitToWidth ( 1 );
$objPHPExcel->getActiveSheet ()->setPageSetup ( $objPageSetup );

/**
 * Background
 */
// $objPHPExcel->getActiveSheet()
// ->getStyle('A6:F6')->getFill()->applyFromArray(
// array(
// 'type' => PHPExcel_Style_Fill::FILL_SOLID,
// 'startcolor' => array('argb' => '#FF0000'),
// )
// );

/**
 * Color Font
 */
// $objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE );
$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'A' )->setAutoSize ( true );
$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'B' )->setAutoSize ( true );
$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'C' )->setAutoSize ( true );
$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'D' )->setAutoSize ( true );
$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'E' )->setAutoSize ( true );
$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'F' )->setAutoSize ( true );
$objPHPExcel->getActiveSheet ()->getStyle ( 'A6:F6' )->getFont ()->setSize ( 8 );
$objPHPExcel->setActiveSheetIndex ( 0 )->getRowDimension ( '1' )->setRowHeight ( 40 );
// $objPHPExcel->getActiveSheet()->getColumnDimension('A:F')->setAutoSize(true);

/**
 * Datos del jefe de dependencia
 */
$objPHPExcel->getDefaultStyle ()->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$objPHPExcel->getActiveSheet ()->getStyle ( 'A6:F6' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'A6', 'Estado Docente' )->setCellValue ( 'B6', 'Estado Complementario' )->setCellValue ( 'C6', 'Nombre archivo Soporte' )->setCellValue ( 'D6', 'Fecha Inicio de Estado' )->setCellValue ( 'E6', 'Fecha Terminación de Estado' )->setCellValue ( 'F6', 'Fecha Registro Estado' );

$objPHPExcel->getActiveSheet ()->setTitle ( 'Docente' . $respuesta [0] [1] );

$objPHPExcel->getDefaultStyle ()->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$rowID = 7;
// var_dump($respuesta);EXIT;
$column = array (
		'A',
		'B',
		'C',
		'D',
		'E',
		'F' 
);

$j = 1;
foreach ( $respuesta as $key ) {
	
	foreach ( $column as $col ) {
		
		$pos [$j] = $col . $rowID;
		$j ++;
	}
	
	$rowID ++;
}

$h = 1;

foreach ( $respuesta as $key ) {
	
	for($k = 2; $k <= 7; $k ++) {
		$resp [$h] = $key [$k];
		$h ++;
	}
}

if (count ( $resp ) == count ( $pos )) {
	for($i = 1; $i <= (count ( $resp )); $i ++) {
		
		$objPHPExcel->getDefaultStyle ()->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->setCellValue ( $pos [$i], trim ( $resp [$i] ) );
		
		//echo $pos [$i] . $resp [$i] . "<br>";
	}
} else {
	
	//echo "sos";
}


$objPHPExcel->getActiveSheet ()->getHeaderFooter ()->setOddHeader ( '&G&L' );
header ( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
header ( 'Content-Disposition: attachment;filename="Historial Estado Docente.xls"' );
header ( 'Cache-Control: max-age=0' );
$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );

$objWriter->save ( 'php://output' );
// echo "<script language='javascript'>window.open('".$url."/prueba.xls','_blank','');</script>";
// exit();

// Renombrar Hoja
// $objPHPExcel->getActiveSheet()->setTitle('Historial Estado Docente');

// // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
// $objPHPExcel->setActiveSheetIndex(0);

// // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.

// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter->save('php://output');

// function paginas($contenidoDatos, $nombre, $directorio) {
// $contenidoPagina = "<page backtop='1mm' backbottom='1mm' backleft='1mm' backright='1mm'>";
// $contenidoPagina .= "<page_header>
// <table align='center' style='width: 100%;'>
// <tr>
// <td align='center' >
// <img src='" . $directorio . "css/images/escudo.jpg'>
// </td>
// <td align='center' >
// <font size='12px'><b>UNIVERSIDAD DISTRITAL</b></font>
// <br>
// <font size='12px'><b>FRANCISCO JOSÉ DE CALDAS</b></font>
// <br>
// <font size='9px'><b>DOCUMENTO HISTORICO</b></font>
// <br>
// <font size='9px'><b>" . date ( "Y-m-d" ) . "</b></font>
// </td>
// <td align='center' >
// <img src='" . $directorio . "css/images/sabio.jpg' width='60'>
// </td>
// </tr>
// </table>
// </page_header>
// <page_footer>
// <table align='center' width = '100%'>
// <tr>
// <td align='center'>
// <img src='" . $directorio . "css/images/escudo.jpg'>
// </td>
// </tr>
// <tr>
// <td align='center'>
// Universidad Distrital Francisco José de Caldas
// <br>
// Todos los derechos reservados.
// <br>
// Carrera 8 N. 40-78 Piso 1 / PBX 3238400 - 3239300
// <br>

// </td>
// </tr>
// </table>
// </page_footer>";

// $contenidoPagina .= "
// <table>
// <tr>
// <td>
// <br><br><br><br>
// <p><h5>Este Documento muestra el historico estado del siguiente docente : “" . $nombre . "“ </h5></p>

// </td>
// </tr>
// </table>
// ";

// $contenidoPagina .= "<table width=\"30%\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" class='bordered' align=\"center \">

// <!--Columnas-->
// <thead>
// <tr role='row'>
// <th aria-label='Documento' aria-sort='ascending'
// style='width: 100px;' colspan='1' rowspan='1'
// aria-controls='example' tabindex='0' role='columnheader'
// class='sorting_asc'>Estado Docente</th>
// <th aria-label='nombres' aria-sort='ascending'
// style='width: 230px;' colspan='1' rowspan='1'
// aria-controls='example' tabindex='0' role='columnheader'
// class='sorting_asc'>Estado Complementario</th>
// <th aria-label='Descripciont' aria-sort='ascending'
// style='width: 200px;' colspan='1' rowspan='1'
// aria-controls='example' tabindex='0' role='columnheader'
// class='sorting_asc'>Nombre Archivo Soporte</th>
// <th aria-label='Descripciont' aria-sort='ascending'
// style='width: 180px;' colspan='1' rowspan='1'
// aria-controls='example' tabindex='0' role='columnheader'
// class='sorting_asc'>Fecha Inicio de Estado</th>
// <th aria-label='Descripciont' aria-sort='ascending'
// style='width: 128px;' colspan='1' rowspan='1'
// aria-controls='example' tabindex='0' role='columnheader'
// class='sorting_asc'>Fecha Terminación de Estado</th>
// <th aria-label='Descripciont' aria-sort='ascending'
// style='width: 128px;' colspan='1' rowspan='1'
// aria-controls='example' tabindex='0' role='columnheader'
// class='sorting_asc'>Fecha Registro Estado</th>
// </tr>
// </thead>

// ";

// $contenidoPagina .= $contenidoDatos;

// $contenidoPagina .= " </table>";

// $contenidoPagina .= "</page> ";

// return $contenidoPagina;
// }
// function armarContenido($NoRegistros, $respuesta, $directorio) {
// $pagina = '';
// $contenido = '';
// $i = 0;
// $Modulo = $NoRegistros;
// foreach ( $respuesta as $res ) {
// $contenido .= "<tr class='gradeA odd' align=center> ";
// $contenido .= "<td>" . $res [2] . " </td>";
// $contenido .= "<td>" . $res [3] . " </td>";
// $contenido .= "<td>" . $res [4] . " </td>";
// $contenido .= "<td>" . $res [5] . " </td>";
// $contenido .= "<td>" . $res [6] . " </td>";
// $contenido .= "<td>" . $res [7] . " </td>";
// $contenido .= "</tr>";

// if ($i == 24) {
// $paginaPDF = paginas ( $contenido, $respuesta [0] [1], $directorio );
// $pagina .= $paginaPDF;
// $contenido = '';

// $Modulo = $Modulo - 24;
// $i = 0;
// }

// if ($Modulo > 0 && $Modulo < 24 && $i == ($Modulo - 1)) {
// $paginaPDF = paginas ( $contenido, $respuesta [0] [1], $directorio );
// $pagina .= $paginaPDF;
// $contenido = '';
// }
// $i ++;
// }
// return $pagina;
// }

// // $contenidoPagina = "
// // <html>
// // <header>
// // <tr>

// // <th>".$respuesta [0] [1]."</th>
// // </tr>
// // </header>

// // <table width=\"30%\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" class='bordered' align=\"center \">

// // <thead>
// // <tr role='row'>
// // <th aria-label='Documento' aria-sort='ascending'
// // style='width: 100px;' colspan='1' rowspan='1'
// // aria-controls='example' tabindex='0' role='columnheader'
// // class='sorting_asc'>Estado Docente</th>
// // <th aria-label='nombres' aria-sort='ascending'
// // style='width: 230px;' colspan='1' rowspan='1'
// // aria-controls='example' tabindex='0' role='columnheader'
// // class='sorting_asc'>Estado Complementario</th>
// // <th aria-label='Descripciont' aria-sort='ascending'
// // style='width: 200px;' colspan='1' rowspan='1'
// // aria-controls='example' tabindex='0' role='columnheader'
// // class='sorting_asc'>Nombre Archivo Soporte</th>
// // <th aria-label='Descripciont' aria-sort='ascending'
// // style='width: 180px;' colspan='1' rowspan='1'
// // aria-controls='example' tabindex='0' role='columnheader'
// // class='sorting_asc'>Fecha Inicio de Estado</th>
// // <th aria-label='Descripciont' aria-sort='ascending'
// // style='width: 128px;' colspan='1' rowspan='1'
// // aria-controls='example' tabindex='0' role='columnheader'
// // class='sorting_asc'>Fecha Terminación de Estado</th>
// // <th aria-label='Descripciont' aria-sort='ascending'
// // style='width: 128px;' colspan='1' rowspan='1'
// // aria-controls='example' tabindex='0' role='columnheader'
// // class='sorting_asc'>Fecha Registro Estado</th>
// // </tr>
// // </thead>

// // ";
// // foreach ( $respuesta as $res ) {
// // $contenidoPagina .= "<tr class='gradeA odd' align=center> ";
// // $contenidoPagina .= "<td>" . $res [2] . " </td>";
// // $contenidoPagina .= "<td>" . $res [3] . " </td>";
// // $contenidoPagina .= "<td>" . $res [4] . " </td>";
// // $contenidoPagina .= "<td>" . $res [5] . " </td>";
// // $contenidoPagina .= "<td>" . $res [6] . " </td>";
// // $contenidoPagina .= "<td>" . $res [7] . " </td>";
// // $contenidoPagina .= "</tr>";
// // }
// // $contenidoPagina .= " </table>";

// // header ( "Content-type: application/octet-stream" );
// // // indicamos al navegador que se está devolviendo un archivo
// // header ( "Content-Disposition: attachment; filename=Historico.xls" );
// // // con esto evitamos que el navegador lo grabe en su caché
// // header ( "Pragma: no-cache" );
// // header ( "Expires: 0" );
// // // damos salida a la tabla
// // echo $contenidoPagina;

// $pagina=armarContenido(count($respuesta), $respuesta,$directorio);

// $html2pdf = new HTML2PDF ( 'L', 'LETTER', 'es' );
// // $html2pdf->pdf->SetDisplayMode('fullpage');
// $res = $html2pdf->WriteHTML ( $pagina );
// // $html2pdf->Output ( 'certificado.pdf', 'D' );
// $html2pdf->Output ( 'certificado.pdf' );
?>