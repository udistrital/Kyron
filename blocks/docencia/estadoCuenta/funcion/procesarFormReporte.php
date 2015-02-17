<?
if(!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
}else {
//Revisar si el identificador existe.
//Pasar de la tabla borrador a la tabla definitiva...
//Si han cancelado entonces borrar borrador y redireccionar al indice...
/*$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";
    ?>
<div>
    <table>
        <tr>
            <td>
                <a href="http://localhost:8080/birt/frameset?__report=Docencia/cuentas.rptdesign&__format=pdf&cedula=<? echo $_REQUEST['nombreDocente']?>"> 
                    <img src="<?echo $directorio?>pdf.png">
                </a>
            </td>
            <td>
                <a href="http://localhost:8080/birt/frameset?__report=Docencia/cuentas.rptdesign&__format=xls&cedula=<? echo $_REQUEST['nombreDocente']?>"> 
                    <img src="<?echo $directorio?>excel.png">
                </a>
            </td>
        </tr>
    </table>
</div>    
    <?php*/
            $this->redireccionar("exitoReporte");

    








}


?>