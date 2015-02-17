<?

if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

/**
 * Realizar una comprobación de la validez de los datos al lado del servidor.
 */	
        if(!isset($_REQUEST[sha1("usuario".$_REQUEST['tiempo'])]) || $_REQUEST[sha1("usuario".$_REQUEST['tiempo'])] == '')
                {
                    $resultado=false;
                }else if(!isset($_REQUEST[sha1("clave".$_REQUEST['tiempo'])]) || $_REQUEST[sha1("clave".$_REQUEST['tiempo'])] == '')
                {
                    $resultado=false;
                }else if((strlen($_REQUEST[sha1("usuario".$_REQUEST['tiempo'])])>255 || strlen($_REQUEST[sha1("usuario".$_REQUEST['tiempo'])])<3) || (strlen($_REQUEST[sha1("clave".$_REQUEST['tiempo'])])>255 || strlen($_REQUEST[sha1("clave".$_REQUEST['tiempo'])])<3))
                {
                    $resultado=false;
                }else{
                    $resultado=true;
                }
}
?>