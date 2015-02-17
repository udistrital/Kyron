<?php

if (!isset($GLOBALS ["autorizado"])) {
    include ("index.php");
    exit();
} else {

    $miSesion = Sesion::singleton();

    $conexion = "estructura";
    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

    $arregloDatos = array(
        $_REQUEST ['docente'],
        $_REQUEST ['numeResolucion'],
        $_REQUEST ['fechaResolucion'],
        $_REQUEST ['numeActa'],
        $_REQUEST ['fechaActa'],
        $_REQUEST ['puntaje'],
        $_REQUEST ['excelencia_idserial']
    );

    $docente = $_REQUEST ['identificacion'];


    if ($docente < 1) {
        $this->funcion->redireccionar('noInserto', $_REQUEST ['identificacion']);
    }


    $annio_excelencia = date("Y", strtotime($_REQUEST['fechaActa']));
    $parametros = array(
        'docente' => $_REQUEST ['identificacion'],
        'annio' => $annio_excelencia,
        'idserial' => $_REQUEST ['excelencia_idserial']
    );

    $cadena_sql = $this->sql->cadena_sql("verificarPuntaje", $parametros);
    $resultadoBusqueda = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

    if ($resultadoBusqueda[0][0] !== NULL) {
      $puntaje = floatval($resultadoBusqueda[0][0]);
      
        if ($puntaje >= 2) {
            $this->funcion->redireccionar('maxExcelencia', $docente);
            $puedeInsertar = 0;
        } elseif ($puntaje > 0) {
            $total_puntaje = $puntaje + floatval($_REQUEST['puntaje']);
            if ($total_puntaje > 2) {
                $this->funcion->redireccionar('maxExcelencia', $docente);
                $puedeInsertar = 0;
            } else {
                $puedeInsertar = 1;
            }
        }
    } else {
        $puedeInsertar = 1;
    }


    if ($puedeInsertar == 1) {

        $cadena_sql = $this->sql->cadena_sql("actualizarExcelencia", $arregloDatos);
        $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");

        $arregloLogEvento = array(
            'registro_excelenciaac',
            $arregloDatos,
            $miSesion->getSesionUsuarioId(),
            $_SERVER ['REMOTE_ADDR'],
            $_SERVER ['HTTP_USER_AGENT']
        );

        $argumento = json_encode($arregloLogEvento);
        $arregloFinalLogEvento = array(
            $miSesion->getSesionUsuarioId(),
            $argumento
        );

        $cadena_sql = $this->sql->cadena_sql("registrarEvento", $arregloFinalLogEvento);
        $registroAcceso = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");

        if ($resultado) {
            $this->funcion->redireccionar('Actualizo', $_REQUEST ['docente']);
        } else {
            $this->funcion->redireccionar('noActualizo', $_REQUEST ['docente']);
        }
    }
}
?>