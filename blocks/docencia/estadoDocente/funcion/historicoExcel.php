<?php
// var_dump($_REQUEST);exit;
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
$ruta = $this->miConfigurador->getVariableConfiguracion ( 'raizDocumento' );
include ($ruta . '/classes/html2pdf/html2pdf.class.php');

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
$cadena = $this->sql->cadena_sql ( "Consultar Historico Docente Excel", $_REQUEST ['identificacion'] );
$respuesta = $esteRecursoDB->ejecutarAcceso ( $cadena, "busqueda" );

// var_dump($respuesta);exit;

// echo count($respuesta);exit;
// var_dump($respuesta);exit;
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
$objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getFont ()->setSize ( 16 );
$objPHPExcel->setActiveSheetIndex ( 0 )->getRowDimension ( '1' )->setRowHeight ( 40 );
$objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getFont ()->setBold(true);
$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'A1', 'Universidad Distrital Francisco José de Caldas' );

/**
 * Encabezado
 */
$objPHPExcel->getActiveSheet ()->mergeCells ( 'B3:E3' );
$objPHPExcel->getActiveSheet ()->getStyle ( 'B3:E3' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$objPHPExcel->getActiveSheet ()->getStyle ( 'B3' )->getFont ()->setName ( 'Arial' );
$objPHPExcel->getActiveSheet ()->getStyle ( 'B3' )->getFont ()->setSize ( 13 );
$objPHPExcel->getActiveSheet ()->getStyle ( 'B3' )->getFont ()->setBold(true);
$objPHPExcel->setActiveSheetIndex ( 0 )->getRowDimension ( '3' )->setRowHeight ( 20 );
$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'B3', 'Histórico Estado Docente' );
$objPHPExcel->getActiveSheet ()->mergeCells ( 'B4:E4' );
$objPHPExcel->getActiveSheet ()->getStyle ( 'B4:E4' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'B4', "Identificación: " . $_REQUEST ['identificacion'] . "      Nombre Docente: " . $respuesta [0] [1] );

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
$objPHPExcel->getActiveSheet ()->getStyle ( 'A6:F6' )->getFont ()->setSize ( 11	 );
$objPHPExcel->getActiveSheet ()->getStyle ( 'A6:F6' )->getFont ()->setBold(true);

$objPHPExcel->setActiveSheetIndex ( 0 )->getRowDimension ( '1' )->setRowHeight ( 40 );
// $objPHPExcel->getActiveSheet()->getColumnDimension('A:F')->setAutoSize(true);

/**
 * Datos del jefe de dependencia
 */
$objPHPExcel->getDefaultStyle ()->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$objPHPExcel->getActiveSheet ()->getStyle ( 'A6:F6' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'A6', 'Estado Docente' )->setCellValue ( 'B6', 'Estado Complementario' )->setCellValue ( 'C6', 'Nombre archivo Soporte' )->setCellValue ( 'D6', 'Fecha Inicio de Estado' )->setCellValue ( 'E6', 'Fecha Terminación de Estado' )->setCellValue ( 'F6', 'Fecha Registro Estado' );

$objPHPExcel->getActiveSheet ()->setTitle ( $respuesta [0] [0] );

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
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A7:F100' )->getFont ()->setSize ( 8 );
		$objPHPExcel->getActiveSheet ()->setCellValue ( $pos [$i], trim ( $resp [$i] ) );
		
		// echo $pos [$i] . $resp [$i] . "<br>";
	}
} else {
	
	// echo "sos";
}

$objPHPExcel->getActiveSheet ()->getHeaderFooter ()->setOddHeader ( '&G&L' );
header ( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
header ( 'Content-Disposition: attachment;filename="Historial Estado del Docente.xlsx"' );
header ( 'Cache-Control: max-age=0' );
$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );

$objWriter->save ( 'php://output' );

?>