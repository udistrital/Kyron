<?

if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{


	//    foreach($_REQUEST as $clave=>$valor){
	//                    echo $clave."--->".$valor."<br>";
	//                }

	$this->error=false;


	if(isset($_REQUEST['nombre'])&&!(strlen($_REQUEST['nombre'])>2)){

		$atributos["mensajeErrorTitulo"]=$this->lenguaje["errorDatosTitulo"];
		$atributos["mensajeErrorCuerpo"]=$this->lenguaje["errorNombreCuerpo"];
		$this->mensaje_error($configuracion, $atributos);
		$this->error=true;

	}

}
?>