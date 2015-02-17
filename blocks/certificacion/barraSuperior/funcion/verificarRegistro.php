<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
	//Verificar si el nombre de usuario ya existe
	$cadena_sql=$this->sql->cadena_sql("buscarUsuario",$_REQUEST["nombre"]);

	$registro=$this->miRecursoDB-> ejecutarAcceso($cadena_sql, "busqueda");
	return $registro;



}
?>