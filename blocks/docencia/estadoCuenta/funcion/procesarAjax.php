<?php

/**
 * * Importante: Si se desean los datos del bloque estos se encuentran en el arreglo $esteBloque
 */

$conexion = "gearbox";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
if (!$esteRecursoDB) {
	//Este se considera un error fatal
	exit;
}

switch($_REQUEST["funcion"]){

	case "#proveedor":
		$cadena_sql = $this->sql->cadena_sql("buscarProveedor", $_REQUEST["name_startsWith"]);
		break;

	case "#dependenciaSupervisora":
		$cadena_sql = $this->sql->cadena_sql("buscarDependenciaSupervisora", $_REQUEST["name_startsWith"]);
		break;

	case "#idSedes":
		$cadena_sql = $this->sql->cadena_sql("buscarSedes", $_REQUEST["name_startsWith"]);
		break;

	case "#idElemento":
		$cadena_sql = $this->sql->cadena_sql("buscarTipoSuministro", $_REQUEST["name_startsWith"]);
		break;

	case "#idIva":
		$cadena_sql = $this->sql->cadena_sql("buscarIva");
		break;

	case "#marca":
		$cadena_sql = $this->sql->cadena_sql("buscarMarca",$_REQUEST["idElemento"]);
		break;

}

//echo $cadena_sql;
$registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

if ($registro) {

	if(($_REQUEST["funcion"]!="#idIva") && ($_REQUEST["funcion"]!="#marca")){

		//Para autocomplete
		$respuesta = '[';

		foreach ($registro as $fila) {
			$respuesta.='{';
			$respuesta.='"label":"' . $fila[1] . '",';
			$respuesta.='"value":"' . $fila[0] . '"';
			$respuesta.='},';
		}

		$respuesta = substr($respuesta, 0, strlen($respuesta) - 1);
		$respuesta.=']';
	}else{
		//Para jqgrid

		if($_REQUEST["funcion"]=="#idIva"){
			$respuesta ='<select>';
			foreach ($registro as $fila) {
				$respuesta.="<option value='".$fila[0]."'>". $fila[1]."</option>";
			}
			
		}else{
			
			$respuesta="<select id='marca' class='FormElement ui-widget-content ui-corner-all' role='select' name='marca' size='1' onchange='actualizarId()'>";
			$respuesta.="<option role='option' value='-1'>Seleccionar...</option>";
			foreach ($registro as $fila) {
				$respuesta.="<option role='option' value='".$fila[0]."'>". $fila[1]."</option>";
			}
		}
		
		$respuesta.='</select>';
	}


} else {
	
	if(($_REQUEST["funcion"]!="#idIva") && ($_REQUEST["funcion"]!="#marca")){
		$respuesta='[{"label":"No encontrado","value":"-1"}]';
	}else{

		if($_REQUEST["funcion"]=="#idIva"){
			$respuesta ='<select>';
		}else{
			$respuesta="<select id='marca' 
					class='FormElement 
					ui-widget-content 
					ui-corner-all' 
					role='select' 
					name='marca' 
					size='1'					
					>";
		}
		$respuesta.="<option value='0'>N/A</option>";
		$respuesta.='</select>';
	}
}

echo $respuesta;
?>