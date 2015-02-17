<?
if(!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
}else {
//Revisar si el identificador existe.
//Pasar de la tabla borrador a la tabla definitiva...
//Si han cancelado entonces borrar borrador y redireccionar al indice...
/*$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";*/
    
$ruta = "http://10.20.0.38:8080/birt/frameset?__report=Docencia/cuentas.rptdesign&__format=pdf&cedula=".$_REQUEST['cedula'];
//$ruta = "http://10.20.0.38:8080/birt/frameset?__report=Docencia/cuentas.rptdesign&cedula=".$_REQUEST['identificacion'];

$len=filesize($ruta);
    
header("Content-type: application/pdf");
header("Content-Length: $len");
//header("Content-Disposition: inline; filename=reporte.pdf");

//header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=reporte.pdf");

readfile($ruta);

    

}


?>