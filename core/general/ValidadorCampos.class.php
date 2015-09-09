<?php

namespace core\general;

//require_once ("core/general/Agregador.class.php");
require_once ("Rangos.class.php");
require_once ("Tipos.class.php");
//require_once ("Agregador.class.php");

class ValidadorCampos extends \Agregador{
    function __construct(){
        
        $this->aggregate('Rangos');
        $this->aggregate('Tipos');        
        
    }
}

// Fin de la clase FormularioHtml
?>
