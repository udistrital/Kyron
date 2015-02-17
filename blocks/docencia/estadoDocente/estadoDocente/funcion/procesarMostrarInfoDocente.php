<?

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
 $resultado = $_REQUEST['datos']; 

	if ($resultado == false) {
		echo "Se presentó un error en el sistema, contacte al administrador";
		exit ();
	}
	
	
	if ($resultado == true) {

		$this->funcion->redireccionar ( "cambiarEstado",$resultado);
	} else {
		echo "OOOPS!!!!. DB Engine Access Error";
		exit ();
	}
}
?>