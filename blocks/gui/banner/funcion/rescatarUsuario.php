<?

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
} else {
//Revisar si el identificador existe.
//Pasar de la tabla borrador a la tabla definitiva...
//Si han cancelado entonces borrar borrador y redireccionar al indice...

    $conexion = "estructura";
    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

    $cadena_sql = $this->sql->cadena_sql("datosUsuario", $usuario);
    $datosUsuario = $esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");    
}
?>