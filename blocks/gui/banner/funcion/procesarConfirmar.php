<?
if(!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
}else {
//Revisar si el identificador existe.
//Pasar de la tabla borrador a la tabla definitiva...
//Si han cancelado entonces borrar borrador y redireccionar al indice...

    $configuracion['id_sesion']=$_REQUEST['id_sesion'];

    $cadena_sql=$this->sql->cadena_sql($configuracion, "rescatarTemp",$_REQUEST['id_sesion']);


    $this->registro=$this->ejecutarSQL($configuracion, $cadena_sql,"busqueda", $configuracion["db_principal"]);

    $totalRegistros=$this->funcion->totalRegistros($configuracion,$configuracion["db_principal"]);

    if($totalRegistros>0) {

        for($i=0;$i<$totalRegistros;$i++) {

            $variable[$this->registro[$i]["campo"]]=$this->registro[$i]["valor"];

        }
    //                        echo 'case "'.$this->registro[$i]["campo"].'":<br>';
    //                        echo " \$variable[\"".$this->registro[$i]["campo"]."\"]=\$this->registro[\$i][\"campo\"];<br>break;<br>";

    }

    //Inicio de la Transaccion
    $cadena_sql=$this->sql->cadena_sql($configuracion, "iniciarTransaccion");
    $resultado=$this->ejecutarSQL($configuracion, $cadena_sql,"accion", $configuracion["db_principal"]);

    $cadena_sql=$this->sql->cadena_sql($configuracion, "insertarRegistro",$variable);
    $resultado=$this->ejecutarSQL($configuracion, $cadena_sql,"accion", $configuracion["db_principal"]);

    

    if($resultado==true) {

    //Finalizar la transaccion
        //Rescatar el ultimo ID de personal registrado o actualizado
        $idRegistrado=$this->ultimoInsertado($configuracion,$configuracion["db_principal"]);

        $cadena_sql=$this->sql->cadena_sql($configuracion, "finalizarTransaccion");
        $resultado=$this->ejecutarSQL($configuracion, $cadena_sql,"accion", $configuracion["db_principal"]);

        //Si el registro no se esta realizando dede la consola de administracion
        $configuracion["idRegistrado"]=$idRegistrado;

        $this->redireccionar($configuracion, "exitoRegistro");

    }else {

        $cadena_sql=$this->sql->cadena_sql($configuracion, "cancelarTransaccion");
        $resultado=$this->ejecutarSQL($configuracion, $cadena_sql,"accion", $configuracion["db_principal"]);
        $this->funcion->redireccionar($configuracion, "falloRegistro");
    }








}


?>