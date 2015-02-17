<?php
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$nombreFormulario = "consultarCatalogo";

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");

$conexion = "certificado";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

if (!$esteRecursoDB) {
	//Este se considera un error fatal
	exit;
}

$cadena_sql = $this->sql->cadena_sql("buscarTablas", "");
$resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

if (!$resultado) {
	//Este se considera un error fatal
	echo "No hay datos";
	exit;
}else {

	echo "<table border = '1'> \n";
	//Mostramos los nombres de las tablas
	echo "<tr>";
	
	foreach ($resultado as $key => $value){
 		echo "<td>hola</td> \n";
	}
	
	echo "</tr> \n";
	
	foreach ($resultado as $key => $value){		
 		echo "<tr> \n";
 		echo "<td>".$value['documento']."</td> \n";
 		echo "<td>".$value['nombres']."</td> \n";
 		echo "<td>".$value['apellidos']."</td> \n";
 		echo "<td>".$value['dependencia']."</td> \n";
 		echo "<td>".$value['objeto']."</td> \n";
 		echo "<td>".$value['fecha_ingreso']."</td> \n";
 		echo "<td>".$value['fecha_retiro']."</td> \n";
 		echo "</tr> \n";
	}
	
	echo "</table>";

}

?>
