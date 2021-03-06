<?php
include_once ($this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/core/connection/Sql.class.php");

class BuilderSql extends Sql {
    
    var $cadenaSql;
    
    var $miConfigurador;
    
    private static $instance;
    
    function __construct() {
        
        $this->miConfigurador = Configurador::singleton ();
        return 0;
    
    }
    
    public static function singleton() {
        
        if (! isset ( self::$instance )) {
            $className = __CLASS__;
            self::$instance = new $className ();
        }
        return self::$instance;
    
    }
    
    function cadenaSql($indice, $parametro = "") {
        
        $this->clausula ( $indice, $parametro );
        if (isset ( $this->cadena_sql [$indice] )) {
            return $this->cadena_sql [$indice];
        }
        return false;
    
    }
    
    private function clausula($indice, $parametro) {
        
        $prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
        
        switch ($indice) {
            
            case "usuario" :
                $cadena = "SELECT usuario, estilo FROM " . $prefijo . "estilo WHERE usuario='" . $this->id_usuario . "'";
                break;
            
            case "pagina" :
                $cadena = "SELECT  " . $prefijo . "bloque_pagina.*," . $prefijo . "bloque.nombre, " . $prefijo . "pagina.parametro FROM " . $prefijo . "pagina, " . $prefijo . "bloque_pagina, " . $prefijo . "bloque WHERE " . $prefijo . "pagina.nombre='" . $parametro . "' AND " . $prefijo . "bloque_pagina.id_bloque=" . $prefijo . "bloque.id_bloque AND " . $prefijo . "bloque_pagina.id_pagina=" . $prefijo . "pagina.id_pagina";
                break;
            
            case "bloquesPagina" :
                $cadena = "SELECT  " . $prefijo . "bloque_pagina.*," . $prefijo . "bloque.nombre ," . $prefijo . "pagina.parametro, " . $prefijo . "bloque.grupo FROM " . $prefijo . "pagina, " . $prefijo . "bloque_pagina, " . $prefijo . "bloque WHERE " . $prefijo . "pagina.nombre='" . $parametro . "' AND " . $prefijo . "bloque_pagina.id_bloque=" . $prefijo . "bloque.id_bloque AND " . $prefijo . "bloque_pagina.id_pagina=" . $prefijo . "pagina.id_pagina ORDER BY " . $prefijo . "bloque_pagina.seccion," . $prefijo . "bloque_pagina.posicion ";
                break;
            
            default :
        }
        if (isset ( $cadena )) {
            $this->cadena_sql [$indice] = $cadena;
        }
    
    }

}

?>