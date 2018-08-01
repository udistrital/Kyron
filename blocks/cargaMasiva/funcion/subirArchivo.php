<?php

namespace cargaMasiva\funcion;

use cargaMasiva\funcion\redireccionar;

include_once ('redireccionar.php');

include_once ('core/general/ValidadorCampos.class.php');
use core\general\ValidadorCampos as ValidadorCampos;

require_once ('core/log/logger.class.php');

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class RegistrarIndexacionRevista {
	
	var $miConfigurador;
	var $lenguaje;
	var $miFuncion;
	var $miSql;
	var $miValidador;
	
	function __construct($lenguaje, $sql, $funcion) {
		
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
		$this->miFuncion = $funcion;
		$this->miValidador = new ValidadorCampos();
	}
	function procesarFormulario() {
	    $esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
	    
	    // REMOVE NEXT in PRODUCTION
	    error_reporting(E_ALL);
	    ini_set('display_errors', TRUE);
	    ini_set('display_startup_errors', TRUE);
	    
	    define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
	    date_default_timezone_set('Europe/London');
	    
	    
	    echo "Iniciando...<br>\n";
	    
	    /** Include PHPExcel_IOFactory */
	    $rutaSara = $this->miConfigurador->getVariableConfiguracion ( 'raizDocumento' );
	    require_once $rutaSara . '/plugin/PHPExcel-1.8.1/Classes/PHPExcel/IOFactory.php';
	    
	    $fieldDocumento = 0;
	    $newFiles = [];
	    foreach($_FILES as $key => $file) {
	        $newFiles[] = $file;
	    }
	    $_FILES = $newFiles;
	    
	    if (! (isset($_FILES[$fieldDocumento]) && isset($_FILES[$fieldDocumento]['tmp_name']) && $_FILES[$fieldDocumento]['tmp_name'] != '') ){
	        $this->escribirError('No hay un archivo correcto!');
	        exit();
	    }
	    
	    $objPHPExcel = \PHPExcel_IOFactory::load($_FILES[$fieldDocumento]['tmp_name']);
	    
	    $sheet = $objPHPExcel->getSheetByName('Categoría');
	    if (!is_null($sheet)) {
	        $this->procesarCategoria($sheet);
	    }
	    
	    $sheet = $objPHPExcel->getSheetByName('Revista Nacional');
	    if (!is_null($sheet)) {
	        $this->procesarRevistaIndexada($sheet);
	    }
	    
	    $sheet = $objPHPExcel->getSheetByName('Capítulo de Libros');
	    if (!is_null($sheet)) {
	        $this->procesarCapituloDeLibros($sheet);
	    }
	    
	    $sheet = $objPHPExcel->getSheetByName('Cartas al Editor');
	    if (!is_null($sheet)) {
	        $this->procesarCartaAlEditor($sheet);
	    }
	    
	    $sheet = $objPHPExcel->getSheetByName('Experiencia Calificada');
	    if (!is_null($sheet)) {
	        $this->procesarExperienciaCalificada($sheet);
	    }
	    
	    $sheet = $objPHPExcel->getSheetByName('Libros');
	    if (!is_null($sheet)) {
	        $this->procesarLibros($sheet);
	    }
	    
	    $sheet = $objPHPExcel->getSheetByName('Técnica y Software');
	    if (!is_null($sheet)) {
	        $this->procesarTecnicaYSoftware($sheet);
	    }
	    
	}
	
	function procesarCategoria($sheet) {
	    echo "Procesando página Categoría...<br>\n";
	    $indicesColumnas = array('A','B','C','D','E','F','G','H','I');
	    $cabeceras = [];
	    foreach ($indicesColumnas as $clave => $valor) {
	        $cabeceras[] = $sheet->getCell($valor . '1')->getCalculatedValue();
	    }
	    
	    $cabecerasDeseadas = [
	        'Cedula',
	        'Categoría',
	        'Motivo',
	        'Nombre producción',
	        'Nombre Título',
	        'Número de Acta',
	        'Fecha de Acta',
	        'Número de Caso',
	        'Puntaje'
	    ];
	    //var_dump($cabeceras, $cabecerasDeseadas, $cabeceras == $cabecerasDeseadas);
	    
	    if ($cabeceras != $cabecerasDeseadas) {
	        $this->escribirError('Las titulos de las cabeceras del documento no corresponden, ¿ha subido el documento correcto?');
	        exit();
	    }
	    //var_dump($cabeceras);
	    
	    $filasExtraidas = [];
	    
	    $indiceFila = 2;
	    while (true) { // mientras las filas tengan datos
	        if ($indiceFila >= 1000){
	            echo "Son máximo 1000 registros<br>\n";
	            break;
	        }
	        
	        $datos = [];
	        foreach ($indicesColumnas as $clave => $valor) {
	            $datos[] = $sheet->getCell($valor . $indiceFila)->getCalculatedValue();
	        }
	        //var_dump($datos);
	        
	        $columnasVacias = 0;
	        foreach ($datos as $columna) {
	            if($columna == '' || $columna == null){
	                $columnasVacias++;
	            }
	        }
	        //var_dump('$columnasVacias', $columnasVacias);
	        if ($columnasVacias == count($datos)){ // todas están vacias
	            //echo "No hay más registros...<br>\n";
	            break;
	        }
	        
	        //Conversión de datos
	        $datos[6] = \PHPExcel_Shared_Date::ExcelToPHPObject($datos[6])->format('Y/m/d');
	        
	        //echo "Validando datos<br>\n";
	        $fila = [];
	        $fila['indice_fila'] = $indiceFila;
	        $fila['documento_docente'] = $this->validar($datos[0], 'A' . $indiceFila ,'Entero', true); // NO usado
	        $fila['categoria_docente'] = $this->validar($datos[1], 'B' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['motivo_categoria_docente'] = $this->validar($datos[2], 'C' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['nombre_produccion'] = $this->validar($datos[3], 'D' . $indiceFila, 'LetrasNumerosEspacioYPuntuacion', true);
	        $fila['nombre_titulo'] = $this->validar($datos[4], 'E' . $indiceFila, 'LetrasNumerosEspacioYPuntuacion', true);
	        $fila['numero_acta'] = $this->validar($datos[5], 'F' . $indiceFila, 'Entero', true);
	        $fila['fecha_acta'] = $this->validar($datos[6], 'G' . $indiceFila, 'FechaYmd', true);
	        $fila['numero_caso'] = $this->validar($datos[7], 'H' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['puntaje'] = $this->validar($datos[8], 'I' . $indiceFila, 'Doble', true);
	        
	        $filasExtraidas[] = $fila;
	        //var_dump($indiceFila, $fila);
	        $indiceFila++;
	    }
	    
	    $this->grabarFilasEnDB($filasExtraidas, 'buscarCategoria', 'insertarCategoria');
	    exit();
	}
	
	function procesarRevistaIndexada($sheet) {
	    echo "Procesando página Revista Indexada Nacional...<br>\n";
	    $indicesColumnas = array('A','B','C','D','E','F','G','H','I','J','K',
	        'L','M','N','O','P');
	    $cabeceras = [];
	    foreach ($indicesColumnas as $clave => $valor) {
	        $cabeceras[] = $sheet->getCell($valor . '1')->getCalculatedValue();
	    }
	    
	    $cabecerasDeseadas = [
	        'Cedula',
	        'Nombre de Revista',
	        'Categoría',
	        'ISSN',
	        'Año',
	        'Volumen',
	        'Número de Revista',
	        'Páginas',
	        'Título del Artículo',
	        'Número de Autores',
	        'Número de Autores UD',
	        'Número de Acta',
	        'Fecha de Acta',
	        'Número de Caso',
	        'Puntaje',
	        'Normatividad'
	    ];
	    //var_dump($cabeceras, $cabecerasDeseadas, $cabeceras == $cabecerasDeseadas);
	    
	    if ($cabeceras != $cabecerasDeseadas) {
	        $this->escribirError('Las titulos de las cabeceras del documento no corresponden, ¿ha subido el documento correcto?');
	        exit();
	    }
	    //var_dump($cabeceras);
	    
	    $filasExtraidas = [];
	    
	    $indiceFila = 2;
	    while (true) { // mientras las filas tengan datos
	        if ($indiceFila >= 1000){
	            echo "Son máximo 1000 registros<br>\n";
	            break;
	        }
	        
	        $datos = [];
	        foreach ($indicesColumnas as $clave => $valor) {
	            $datos[] = $sheet->getCell($valor . $indiceFila)->getCalculatedValue();
	        }
	        //var_dump($datos);
	        
	        $columnasVacias = 0;
	        foreach ($datos as $columna) {
	            if($columna == '' || $columna == null){
	                $columnasVacias++;
	            }
	        }
	        //var_dump('$columnasVacias', $columnasVacias);
	        if ($columnasVacias == count($datos)){ // todas están vacias
	            //echo "No hay más registros...<br>\n";
	            break;
	        }
	        
	        //Conversión de datos
	        $datos[12] = \PHPExcel_Shared_Date::ExcelToPHPObject($datos[12])->format('Y/m/d');
	        
	        //echo "Validando datos<br>\n";
	        $fila = [];
	        $fila['indice_fila'] = $indiceFila;
	        $fila['documento_docente'] = $this->validar($datos[0], 'A' . $indiceFila ,'Entero', true); // NO usado
	        $fila['nombre_revista'] = $this->validar($datos[1], 'B' . $indiceFila, 'LetrasNumerosEspacioYPuntuacion', true);
	        $fila['tipo_indexacion'] = $this->validar($datos[2], 'C' . $indiceFila, 'LetrasNumerosEspacioYPuntuacion', true);
	        $fila['numero_issn'] = $this->validar($datos[3], 'D' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['anno_publicacion'] = $this->validar($datos[4], 'E' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['volumen_revista'] = $this->validar($datos[5], 'F' . $indiceFila, 'Entero', true);
	        $fila['numero_revista'] = $this->validar($datos[6], 'G' . $indiceFila, 'Entero', true);
	        $fila['paginas_revista'] = $this->validar($datos[7], 'H' . $indiceFila, 'Entero', true);
	        $fila['titulo_articulo'] = $this->validar($datos[8], 'I' . $indiceFila, 'LetrasNumerosEspacioYPuntuacion', true);
	        $fila['numero_autores'] = $this->validar($datos[9], 'J' . $indiceFila, 'Entero', true);
	        $fila['numero_autores_ud'] = $this->validar($datos[10], 'K' . $indiceFila, 'Entero', true);
	        $fila['numero_acta'] = $this->validar($datos[11], 'L' . $indiceFila, 'Entero', true);
	        $fila['fecha_acta'] = $this->validar($datos[12], 'M' . $indiceFila, 'FechaYmd', true);
	        $fila['numero_caso'] = $this->validar($datos[13], 'N' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['puntaje'] = $this->validar($datos[14], 'O' . $indiceFila, 'Doble', true);
	        $fila['normatividad'] = $this->validar($datos[15], 'P' . $indiceFila, 'LetrasNumerosEspacioYPuntuacion', true);
	        
	        $filasExtraidas[] = $fila;
	        //var_dump($indiceFila, $fila);
	        $indiceFila++;
	    }
	    
	    $this->grabarFilasEnDB($filasExtraidas, 'buscarRevista', 'insertarRevista');
	    exit();
	}
	
	function procesarCapituloDeLibros($sheet) {
	    //// OJO NO ESTA TERMINADO
	    echo "Procesando página Capítulo de Libros...<br>\n";
	    $indicesColumnas = array('A','B','C','D','E','F','G','H','I','J','K',
	        'L','M','N','O','P','Q');
	    $cabeceras = [];
	    foreach ($indicesColumnas as $clave => $valor) {
	        $cabeceras[] = $sheet->getCell($valor . '1')->getCalculatedValue();
	    }
	    
	    $cabecerasDeseadas = [
	        'Cedula',
	        'Título del capítulo',
	        'Título del libro',
	        'Tipo de Libro',
	        'ISBN',
	        'Editorial',
	        'Año de publicación',
	        'Volumen',
	        'Número de Autores del Cap',
	        'Número de Autores del Cap UD',
	        'Número de Autores del Libro',
	        'Número de Autores del Libro UD',
	        'Número de Acta',
	        'Fecha de Acta',
	        'Número de Caso',
	        'Puntaje',
	        'Normatividad'
	    ];
	    //var_dump($cabeceras, $cabecerasDeseadas, $cabeceras == $cabecerasDeseadas);
	    
	    if ($cabeceras != $cabecerasDeseadas) {
	        $this->escribirError('Las titulos de las cabeceras del documento no corresponden, ¿ha subido el documento correcto?');
	        exit();
	    }
	    //var_dump($cabeceras);
	    
	    $filasExtraidas = [];
	    
	    $indiceFila = 2;
	    while (true) { // mientras las filas tengan datos
	        if ($indiceFila >= 1000){
	            echo "Son máximo 1000 registros<br>\n";
	            break;
	        }
	        
	        $datos = [];
	        foreach ($indicesColumnas as $clave => $valor) {
	            $datos[] = $sheet->getCell($valor . $indiceFila)->getCalculatedValue();
	        }
	        //var_dump($datos);
	        
	        $columnasVacias = 0;
	        foreach ($datos as $columna) {
	            if($columna == '' || $columna == null){
	                $columnasVacias++;
	            }
	        }
	        //var_dump('$columnasVacias', $columnasVacias);
	        if ($columnasVacias == count($datos)){ // todas están vacias
	            //echo "No hay más registros...<br>\n";
	            break;
	        }
	        
	        //Conversión de datos
	        $datos[13] = \PHPExcel_Shared_Date::ExcelToPHPObject($datos[13])->format('Y/m/d');
	        
	        //echo "Validando datos<br>\n";
	        $fila = [];
	        $fila['indice_fila'] = $indiceFila;
	        $fila['documento_docente'] = $this->validar($datos[0], 'A' . $indiceFila ,'Entero', true); // NO usado
	        $fila['titulo_capitulo'] = $this->validar($datos[1], 'B' . $indiceFila, 'LetrasNumerosEspacioYPuntuacion', true);
	        $fila['titulo_libro'] = $this->validar($datos[2], 'C' . $indiceFila, 'LetrasNumerosEspacioYPuntuacion', true);
	        $fila['tipo_libro'] = $this->validar($datos[3], 'D' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['codigo_isbn'] = $this->validar($datos[4], 'E' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['editorial'] = $this->validar($datos[5], 'F' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['anno_publicacion'] = $this->validar($datos[6], 'G' . $indiceFila, 'Entero', true);
	        $fila['volumen'] = $this->validar($datos[7], 'H' . $indiceFila, 'Entero', true);
	        $fila['numero_autores_capitulo'] = $this->validar($datos[8], 'I' . $indiceFila, 'Entero', true);
	        $fila['numero_autores_capitulo_ud'] = $this->validar($datos[9], 'J' . $indiceFila, 'Entero', true);
	        $fila['numero_autores_libro'] = $this->validar($datos[10], 'K' . $indiceFila, 'Entero', true);
	        $fila['numero_autores_libro_ud'] = $this->validar($datos[11], 'L' . $indiceFila, 'Entero', true);
	        $fila['numero_acta'] = $this->validar($datos[12], 'M' . $indiceFila, 'Entero', true);
	        $fila['fecha_acta'] = $this->validar($datos[13], 'N' . $indiceFila, 'FechaYmd', true);
	        $fila['numero_caso'] = $this->validar($datos[14], 'O' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['puntaje'] = $this->validar($datos[15], 'P' . $indiceFila, 'Doble', true);
	        $fila['normatividad'] = $this->validar($datos[16], 'Q' . $indiceFila, 'LetrasNumerosEspacioYPuntuacion', true);
	        
	        $filasExtraidas[] = $fila;
	        //var_dump($indiceFila, $fila);
	        $indiceFila++;
	    }
	    
	    $this->grabarFilasEnDB($filasExtraidas, 'buscarCapituloDeLibro', 'insertarCapituloDeLibro');
	    exit();
	}
	
	function procesarCartaAlEditor($sheet) {
	    //// OJO NO ESTA TERMINADO
	    echo "Procesando página Cartas al Editor...<br>\n";
	    $indicesColumnas = array('A','B','C','D','E','F','G','H','I','J','K',
	        'L','M','N','O','P','Q','R','S');
	    $cabeceras = [];
	    foreach ($indicesColumnas as $clave => $valor) {
	        $cabeceras[] = $sheet->getCell($valor . '1')->getCalculatedValue();
	    }
	    
	    $cabecerasDeseadas = [
	        'Cedula',
	        'Nombre de la Revista',
	        'Contexto de la Revista',
	        'País',
	        'Categorías',
	        'ISSN',
	        'Año',
	        'Volumen',
	        'Número de Revista',
	        'Páginas',
	        'Título del Artículo',
	        'Número de Autores',
	        'Número de Autores UD',
	        'Fecha de Publicación',
	        'Número de Acta',
	        'Fecha de Acta',
	        'Número de Caso',
	        'Puntaje',
	        'Normatividad'
	    ];
	    //var_dump($cabeceras, $cabecerasDeseadas, $cabeceras == $cabecerasDeseadas);
	    
	    if ($cabeceras != $cabecerasDeseadas) {
	        $this->escribirError('Las titulos de las cabeceras del documento no corresponden, ¿ha subido el documento correcto?');
	        exit();
	    }
	    //var_dump($cabeceras);
	    
	    $filasExtraidas = [];
	    
	    $indiceFila = 2;
	    while (true) { // mientras las filas tengan datos
	        if ($indiceFila >= 1000){
	            echo "Son máximo 1000 registros<br>\n";
	            break;
	        }
	        
	        $datos = [];
	        foreach ($indicesColumnas as $clave => $valor) {
	            $datos[] = $sheet->getCell($valor . $indiceFila)->getCalculatedValue();
	        }
	        //var_dump($datos);
	        
	        $columnasVacias = 0;
	        foreach ($datos as $columna) {
	            if($columna == '' || $columna == null){
	                $columnasVacias++;
	            }
	        }
	        //var_dump('$columnasVacias', $columnasVacias);
	        if ($columnasVacias == count($datos)){ // todas están vacias
	            //echo "No hay más registros...<br>\n";
	            break;
	        }
	        
	        //Conversión de datos
	        $datos[13] = \PHPExcel_Shared_Date::ExcelToPHPObject($datos[13])->format('Y/m/d');
	        $datos[15] = \PHPExcel_Shared_Date::ExcelToPHPObject($datos[15])->format('Y/m/d');
	        
	        //echo "Validando datos<br>\n";
	        $fila = [];
	        $fila['indice_fila'] = $indiceFila;
	        $fila['documento_docente'] = $this->validar($datos[0], 'A' . $indiceFila ,'Entero', true); // NO usado
	        $fila['nombre_revista'] = $this->validar($datos[1], 'B' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['contexto'] = $this->validar($datos[2], 'C' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['paisnombre'] = $this->validar($datos[3], 'D' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['tipo_indexacion'] = $this->validar($datos[4], 'E' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['numero_issn'] = $this->validar($datos[5], 'F' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['anno_publicacion'] = $this->validar($datos[6], 'G' . $indiceFila, 'Entero', true);
	        $fila['volumen_revista'] = $this->validar($datos[7], 'H' . $indiceFila, 'Entero', true);
	        $fila['numero_revista'] = $this->validar($datos[8], 'I' . $indiceFila, 'Entero', true);
	        $fila['paginas_revista'] = $this->validar($datos[9], 'J' . $indiceFila, 'Entero', true);
	        $fila['titulo_articulo'] = $this->validar($datos[10], 'K' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['numero_autores'] = $this->validar($datos[11], 'L' . $indiceFila, 'Entero', true);
	        $fila['numero_autores_ud'] = $this->validar($datos[12], 'M' . $indiceFila, 'Entero', true);
	        $fila['fecha_publicacion'] = $this->validar($datos[13], 'N' . $indiceFila, 'FechaYmd', true);
	        $fila['numero_acta'] = $this->validar($datos[14], 'O' . $indiceFila, 'Entero', true);
	        $fila['fecha_acta'] = $this->validar($datos[15], 'P' . $indiceFila, 'FechaYmd', true);
	        $fila['numero_caso'] = $this->validar($datos[16], 'Q' . $indiceFila, 'LetrasNumerosYEspacios', true);
	        $fila['puntaje'] = $this->validar($datos[17], 'R' . $indiceFila, 'Doble', true);
	        $fila['normatividad'] = $this->validar($datos[18], 'S' . $indiceFila, 'LetrasNumerosEspacioYPuntuacion', true);
	        
	        $filasExtraidas[] = $fila;
	        //var_dump($indiceFila, $fila);
	        $indiceFila++;
	    }
	    
	    $this->grabarFilasEnDB($filasExtraidas, 'buscarCartaAlEditor', 'insertarCartaAlEditor');
	    exit();
	}
	
	function procesarExperienciaCalificada() {
	    
	}
	
	function procesarLibros() {
	    
	}
	
	function procesarTecnicaYSoftware() {
	    
	}
	
	function grabarFilasEnDB($filasExtraidas, $SQLBuscar, $SQLInsertar) {
	    //var_dump('$filasExtraidas', $filasExtraidas);
	    // grabar datos
	    $conexion = 'docencia';
	    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	    
	    $resultadoTotal = true;
	    
	    foreach ($filasExtraidas as $fila) {
	        //var_dump($fila);
	        $cadenaSql = $this->miSql->getCadenaSql ( $SQLBuscar, $fila );
	        //echo 'SQL Search: ' . $cadenaSql . "<br>\n"; die;
	        $resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'busqueda' );
	        //var_dump($resultado);die;
	        if ($resultado == false || $resultado == 'error') {
	            $this->escribirError('Error al leer los registros de filas. ¿No tiene permisos sobre la base de datos?');
	            exit();
	        }
	        
	        if (is_array($resultado) && count($resultado) > 0) {
	            // el registro ya existe
	            echo 'Ya existe el registro de la fila: ' . $fila['indice_fila'] . "<br>\n";
	            continue; // si ya existe salta al siguiente
	        }
	        
	        //Inicia para el log
	        //////// OJO VOLVERLO A ACTIVAR
	        //$this->logger = new \logger (); //Se agrega mas arriba
	        //$registro['opcion'] = 'REGISTRA_PIN_DE_PAGO_ESTUDIANTE';
	        //$registro['beneficiario'] = $fila['documento_identificacion'];
	        //$registro['$cadenaSql_base64'] =  base64_encode($cadenaSql); // es OPCIONAL
	        //$this->logger->log_usuario($registro);
	        //Termina para el log
	        
	        $cadenaSql = $this->miSql->getCadenaSql ( $SQLInsertar, $fila );
	        //echo 'SQL Insert: ' . $cadenaSql . "<br>\n";
	        $resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
	        //var_dump($resultado);die;
	        $resultadoTotal = ($resultado == false)?false:true;
	        
	        if ($resultado) {
	            // todo salio bien
	            echo 'Se insertó exitosamente el registro de la fila: ' . $fila['indice_fila'] . "<br>\n";
	        } else {
	            echo 'No insertó el registro de la fila: ' . $fila['indice_fila'] . ". Algo falló, intente de nuevo.<br>\n";
	            exit ();
	        }
	    }
	    //var_dump($resultadoTotal);die;
	    if ($resultadoTotal) {
	        redireccion::redireccionar ( 'inserto', 5000 );
	        exit ();
	    } else {
	        redireccion::redireccionar ( 'noInserto' );
	        exit ();
	    }
	}

    function escribirError($mensaje){
	    //$data = ['error' => $message];
	    //header('Content-Type: text/html; charset=utf-8');
	    //echo json_encode($data);
	    echo "<br>\n" . $mensaje . "<br>\n";
	    
	    $url = $this->miConfigurador->configuracion ["host"] . $this->miConfigurador->configuracion ["site"] . "/index.php?";
	    $enlace = $this->miConfigurador->configuracion ['enlace'];
	    
	    $esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
	    
	    $valorCodificado = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' ); // Frontera mostrar formulario
	    //$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
	    //$valorCodificado .= "&bloqueGrupo=" . $esteBloque ['nombre'];
	    //$valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
	    //$valorCodificado .= "&perfiles=" . $_REQUEST['perfiles'];
	    //$valorCodificado .= "&opcion=continuar";
	    // Paso 2: codificar la cadena resultante
	    $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
	    
	    $redireccion = $url . $enlace . '=' . $valorCodificado;
	    //echo '<form><div align="center"><input type="button" value="VOLVER ATRÁS" name="Back2" onclick="history.back()" /></div></form>';
	    echo '<div align="center"><input type="submit" value="Volver Atrás" name="Back2" onclick="window.location=\'' . $redireccion . '\'" /></div>';
	    
	}
	
	function validar ($valor, $celda, $tipo, $required = false){
	    if ($required == true && ($valor == '' || $valor == null)){
	        $this->escribirError('La celda "' . $celda . '", con valor "' . $valor . '" NO puede estar vacia y debe tener el tipo  "' . $tipo . '".');
	        exit();
	    }
	    
	    if ($valor == '' || $valor == null){
	        return $valor;
	    }
	    
	    //$valido = $miValidador -> validarTipo($_REQUEST['observacion'], 'onlyLetterNumberSpPunt');
	    //$valido = $valido && $miValidador -> validarTipo($_REQUEST['verificado'], 'boleano');
	    if ($tipo == 'string') {
	        // http://php.net/manual/es/function.pg-escape-string.php
	        $escaped = htmlspecialchars($valor);
	        $escaped = trim($escaped);
	        $escaped = str_replace("'", "", $escaped);
	        $escaped = pg_escape_string($escaped);
	        return $escaped;
	    }
	    
	    $valido = $this->miValidador -> validarTipo((string)$valor, $tipo);
	    if (! $valido){
	        $this->escribirError('La celda "' . $celda . '", con valor "' . $valor . '" no tiene el tipo de dato "' . $tipo . '".');
	        exit();
	    } else {
	        return $valor;
	    }
	}
	
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}

$miRegistrador = new RegistrarIndexacionRevista ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();

?>
