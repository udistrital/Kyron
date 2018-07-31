<?php

namespace cargaMasiva\funcion;

if (! isset ( $GLOBALS ["autorizado"] )) {
    include ("index.php");
    exit ();
}
class redireccion {
    public static function redireccionar($opcion, $timeout = "") {
        $miConfigurador = \Configurador::singleton ();
        $miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
        
        switch ($opcion) {
            
            case "inserto" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=confirma";
                //$variable .= "&usuario=" . $_REQUEST ['usuario'];
                //$variable .= "&perfiles=" . $_REQUEST['perfiles'];
                break;
                
            case "noInserto" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=error";
                //$variable .= "&usuario=" . $_REQUEST ['usuario'];
                //$variable .= "&perfiles=" . $_REQUEST['perfiles'];
                break;
                
            case "elimino" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=elimina";
                //$variable .= "&usuario=" . $_REQUEST ['usuario'];
                //$variable .= "&perfiles=" . $_REQUEST['perfiles'];
                break;
                
            case "noElimino" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noelimina";
                //$variable .= "&usuario=" . $_REQUEST ['usuario'];
                //$variable .= "&perfiles=" . $_REQUEST['perfiles'];
                break;
                
            case "crear" :
                $variable = "pagina=crearNoticia";
                //$variable .= "&usuario=" . $_REQUEST ['usuario'];
                //$variable .= "&perfiles=" . $_REQUEST['perfiles'];
                break;
                
            case "continuar" :
                $variable = "pagina=" . $miPaginaActual;
                //$variable .= "&usuario=" . $_REQUEST ['usuario'];
                //$variable .= "&perfiles=" . $_REQUEST['perfiles'];
                break;
                
            case "devolver" :
                $variable = "pagina=" . $miPaginaActual;
                //$variable .= "&usuario=" . $_REQUEST ['usuario'];
                //$variable .= "&perfiles=" . $_REQUEST['perfiles'];
                break;
        }
        
        foreach ( $_REQUEST as $clave => $valor ) {
            unset ( $_REQUEST [$clave] );
        }
        
        $url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
        $enlace = $miConfigurador->configuracion ['enlace'];
        $variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
        $_REQUEST [$enlace] = $enlace . '=' . $variable;
        $redireccion = $url . $_REQUEST [$enlace];
        
        if ($timeout == ''){
            echo "<script>location.replace('" . $redireccion . "')</script>";
        } else {
            echo "<br><h5>Redireccionando...</h5><br>";
            echo "<script>setTimeout(function(){location.replace('" . $redireccion . "')}, " . $timeout . ")</script>";
        }
        
    }
}

?>