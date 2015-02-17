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
        $_REQUEST ['experiencia'],
        $_REQUEST ['numeResolucion'],
        $_REQUEST ['emiResolucion'],
        $_REQUEST ['fechaResolucion'],
        $_REQUEST ['numeActa'],
        $_REQUEST ['fechaActa'],
        $_REQUEST ['puntaje'],
        $_REQUEST ['experiencia_idserial'],
        $_REQUEST ['detalleDocencia']
    );

    $docente = $_REQUEST ['identificacion'];


    if ($docente < 1) {
        $this->funcion->redireccionar('noInserto', $_REQUEST ['identificacion']);
    }

    $puedeInsertar = 1;


    if ($puedeInsertar == 1) {

        $cadena_sql = $this->sql->cadena_sql("actualizarExperiencia", $arregloDatos);
        $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");


        $arregloLogEvento = array(
            'actualizar_experienciacalif',
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