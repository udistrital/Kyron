<?php
include_once("core/manager/Configurador.class.php");
$this->miConfigurador=Configurador::singleton();

require_once($this->miConfigurador->getVariableConfiguracion("raizDocumento")."/classes/jqgrid/jqGrid.php"); 
require_once($this->miConfigurador->getVariableConfiguracion("raizDocumento")."/classes/jqgrid/jqGridPdo.php"); 
require_once($this->miConfigurador->getVariableConfiguracion("raizDocumento")."/classes/jqgrid/tcpdf/config/lang/spa.php"); 

$miSesion = Sesion::singleton ();
	
$conexion = "docencia";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ($conexion );

$cadena_sql = $this->sql->cadena_sql ( "consultar", $arreglo );

$servidor = $esteRecursoDB->getServidor();
$puerto = $esteRecursoDB->getPuerto();
$db = $esteRecursoDB->getDB();
$user = $esteRecursoDB->getUsuario();
$pass = $esteRecursoDB->getClave();

$DNS = "pgsql:host=".$servidor.";port=".$puerto.";dbname=".$db.";user=".$user.";password=".$pass."";
	
$conn = new PDO($DNS,$user,$pass); 
// Create the jqGrid instance 
$grid = new jqGridRender($conn); 

// Write the SQL Query 
$grid->SelectCommand = $consultaGrilla ; 

// Set output format to json 
$grid->dataType = 'json'; 
// Let the grid create the model 
$grid->setColModel(); 
// Set the url from where we obtain the data
$grid->setUrl("resultadoConsulta.php"); 

// Set some grid options 
$grid->setGridOptions(array( 
    "rowNum"=>10, 
    "rowList"=>array(10,20,30), 
    "sortname"=>"OrderID", 
    "caption"=>"PDF export with custom header" 
)); 
// Change some property of the field(s) 
$grid->setColProperty("OrderDate", array( 
    "formatter"=>"date", 
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y"), 
    "search"=>false 
    ) 
); 
$grid->setColProperty("ShipName", array("width"=>"450")); 
$grid->setColProperty("Freight", array("label"=>"Test", "align"=>"right")); 
// Enable navigator 
$grid->navigator = true; 
// Enable pdf export on navigator 
$grid->setNavOptions('navigator', array("pdf"=>true, "add"=>false,"edit"=>false,"del"=>false,"view"=>false, "excel"=>false));

$oper = jqGridUtils::GetParam("oper"); 
// prevent some executions when not excel export 
if($oper == "pdf") { 
    $grid->setPdfOptions(array( 
        // enable header information 
        "header"=>true, 
        // set bigger top margin 
        "margin_top"=>27, 
        // set logo image 
        "header_logo"=>"logo.gif", 
        // set logo image width 
        "header_logo_width"=>30, 
        //header title 
        "header_title"=>"jqGrid pdf table", 
        // and a header string to print 
        "header_string"=>"by Trirand Inc - www.trirand.net" 
        )); 
} 
// Enjoy 
$grid->renderGrid('#grid','#pager',true, null, null, true,true); 
$conn = null; 


?> 