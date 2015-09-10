<?php
use core\general\ValidadorCampos;
class InspectorHTML {
    
    private static $instance;
    
    // Constructor
    function __construct() {
    
    }
    
    public static function singleton() {
        
        if (! isset ( self::$instance )) {
            $className = __CLASS__;
            self::$instance = new $className ();
        }
        return self::$instance;
    
    }
    
    function limpiarPHPHTML($arreglo, $excluir = "") {
        
        if ($excluir != "") {
            $variables = explode ( "|", $excluir );
        } else {
            $variables [0] = "";
        }
        
        foreach ( $arreglo as $clave => $valor ) {
            if (! in_array ( $clave, $variables )) {
                
                $arreglo [$clave] = strip_tags ( $valor );
            }
        }
        
        return $arreglo;
    
    }
    
    function limpiarSQL($arreglo, $excluir = "") {
        
        if ($excluir != "") {
            $variables = explode ( "|", $excluir );
        } else {
            $variables [0] = "";
        }
        
        foreach ( $arreglo as $clave => $valor ) {
            if (! in_array ( $clave, $variables )) {
                
                $arreglo [$clave] = addcslashes ( $valor, '%_' );
            }
        }
        
        return $arreglo;
    
    }
    
    /*
     * Permite que los valores de $_REQUEST se validen del lado del servidor con el módulo
     * ValidadorCampos de los componentes generales del CORE de SARA
     */
    function validacionCampos($variables, $validadorCampos){
    	
    	include ('core/general/ValidadorCampos.class.php');
    	
    	$miValidador = new ValidadorCampos();
    	var_dump($miValidador->evaluarTipo('10/02/2013',"fecha"));
    }

}