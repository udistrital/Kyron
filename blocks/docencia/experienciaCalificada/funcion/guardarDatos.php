<?php

// var_dump ( $_REQUEST );
// exit ();
if (!isset($GLOBALS ["autorizado"])) {
    include ("index.php");
    exit();
} else {

    $miSesion = Sesion::singleton();

    $conexion = "estructura";
    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

    $arregloDatos = array(
        $_REQUEST ['identificacionFinalCrear'],
        $_REQUEST ['experiencia'],
        $_REQUEST ['numeResolucion'],
        $_REQUEST ['emiResolucion'],
        $_REQUEST ['fechaResolucion'],
        $_REQUEST ['numeActa'],
        $_REQUEST ['fechaActa'],
        $_REQUEST ['puntaje'],
        $_REQUEST ['detalleDocencia']
    ); {

        //Verificar máximo dos puntos por año
        $docente = $_REQUEST ['docente'];

        if ($docente < 1) {
            $this->funcion->redireccionar('noInserto', $_REQUEST ['docente']);
            $puedeInsertar = 0;
        }

    /*    switch ($_REQUEST['experiencia']) {

            case '1':
                if ($_REQUEST['puntaje'] >= 0.1 && $_REQUEST['puntaje'] <= 11) {
                    $puntaje_real = $_REQUEST['puntaje'];
                } else {
                    $this->funcion->redireccionar('noInserto', $_REQUEST ['docente']);
                    $puedeInsertar = 0;
                }
                break;

            case '2':
                if ($_REQUEST['puntaje'] >= 0.1 && $_REQUEST['puntaje'] <= 9) {
                    $puntaje_real = $_REQUEST['puntaje'];
                } else {
                    $this->funcion->redireccionar('noInserto', $_REQUEST ['docente']);
                    $puedeInsertar = 0;
                }
                break;

            case '3':
                if ($_REQUEST['puntaje'] >= 0.1 && $_REQUEST['puntaje'] <= 6) {
                    $puntaje_real = $_REQUEST['puntaje'];
                } else {
                    $this->funcion->redireccionar('noInserto', $_REQUEST ['docente']);
                    $puedeInsertar = 0;
                }
                break;

            case '4':
                if ($_REQUEST['puntaje'] >= 0.1 && $_REQUEST['puntaje'] <= 9) {
                    $puntaje_real = $_REQUEST['puntaje'];
                } else {
                    $this->funcion->redireccionar('noInserto', $_REQUEST ['docente']);
                    $puedeInsertar = 0;
                }
                break;

            case '5':
                if ($_REQUEST['puntaje'] >= 0.1 && $_REQUEST['puntaje'] <= 6) {
                    $puntaje_real = $_REQUEST['puntaje'];
                } else {
                    $this->funcion->redireccionar('noInserto', $_REQUEST ['docente']);
                    $puedeInsertar = 0;
                }
                break;

            case '6':
                if ($_REQUEST['puntaje'] >= 0.1 && $_REQUEST['puntaje'] <= 6) {
                    $puntaje_real = $_REQUEST['puntaje'];
                } else {
                    $this->funcion->redireccionar('noInserto', $_REQUEST ['docente']);
                    $puedeInsertar = 0;
                }
                break;

            case '7':
                if ($_REQUEST['puntaje'] >= 0.1 && $_REQUEST['puntaje'] <= 6) {
                    $puntaje_real = $_REQUEST['puntaje'];
                } else {
                    $this->funcion->redireccionar('noInserto', $_REQUEST ['docente']);
                    $puedeInsertar = 0;
                }
                break;

            case '8':
                if ($_REQUEST['puntaje'] >= 0.1 && $_REQUEST['puntaje'] <= 6) {
                    $puntaje_real = $_REQUEST['puntaje'];
                } else {
                    $this->funcion->redireccionar('noInserto', $_REQUEST ['docente']);
                    $puedeInsertar = 0;
                }
                break;

            case '9':
                if ($_REQUEST['puntaje'] >= 0.1 && $_REQUEST['puntaje'] <= 2) {
                    $puntaje_real = $_REQUEST['puntaje'];
                } else {
                    $this->funcion->redireccionar('noInserto', $_REQUEST ['docente']);
                    $puedeInsertar = 0;
                }
                break;

            case '10':
                if ($_REQUEST['puntaje'] >= 0.1 && $_REQUEST['puntaje'] <= 2) {
                    $puntaje_real = $_REQUEST['puntaje'];
                } else {
                    $this->funcion->redireccionar('noInserto', $_REQUEST ['docente']);
                    $puedeInsertar = 0;
                }
                break;

            case '11':
                if ($_REQUEST['puntaje'] >= 0.1 && $_REQUEST['puntaje'] <= 4) {
                    $puntaje_real = $_REQUEST['puntaje'];
                } else {
                    $this->funcion->redireccionar('noInserto', $_REQUEST ['docente']);
                    $puedeInsertar = 0;
                }
                break;
        }*/

        $puedeInsertar = 1;
        //para insertar
        if ($puedeInsertar == 1) {
            $cadena_sql = $this->sql->cadena_sql("insertarExperiencia", $arregloDatos);
            $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "insertar");

            $arregloLogEvento = array(
                'registro_experienciacalif',
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
                $this->funcion->redireccionar('inserto', $_REQUEST ['docente']);
            } else {
                $this->funcion->redireccionar('noInserto', $_REQUEST ['docente']);
            }
        }
    }
}
?>