<?php

require_once ("core/general/Agregador.class.php");
require_once ("core/builder/controleshtml/BotonHtml.class.php");
require_once ("core/builder/controleshtml/CheckBoxHtml.class.php");
require_once ("core/builder/controleshtml/Div.class.php");
require_once ("core/builder/controleshtml/Fieldset.class.php");
require_once ("core/builder/controleshtml/Form.class.php");
require_once ("core/builder/controleshtml/Img.class.php");
require_once ("core/builder/controleshtml/Input.class.php");
require_once ("core/builder/controleshtml/Link.class.php");
require_once ("core/builder/controleshtml/ListHtml.class.php");
require_once ("core/builder/controleshtml/RadioButtonHtml.class.php");
require_once ("core/builder/controleshtml/RecaptchaHtml.class.php");
require_once ("core/builder/controleshtml/Select.class.php");
require_once ("core/builder/controleshtml/TextArea.class.php");

class FormularioHtml extends Agregador{
    
    
    function __construct(){
        
        $this->aggregate('BotonHtml');
        $this->aggregate('CheckBoxHtml');
        $this->aggregate('Div');
        $this->aggregate('Fieldset');
        $this->aggregate('Form');
        $this->aggregate('Img');
        $this->aggregate('Input');
        $this->aggregate('Link');
        $this->aggregate('ListHtml');
        $this->aggregate('RadioButtonHtml');
        $this->aggregate('RecaptchaHtml');
        $this->aggregate('Select');
        $this->aggregate('TextArea');
        
        
    }
    
    

}

// Fin de la clase FormularioHtml
?>
