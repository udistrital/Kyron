<?php
$token=strrev(($this->miConfigurador->getVariableConfiguracion("enlace")));
$this->idioma[$token."usuario"]="Usuario:";
$this->idioma[$token."clave"]="Clave:";
$this->idioma["enlaceRecordarClave"]="¿Olvidó su clave?";
$this->idioma["loginButton"]="Ingresar";
$this->idioma["botonAceptar"]="Aceptar";
$this->idioma["botonCancelar"]="Cancelar";
$this->idioma[$token."checkbox"]="Recordarme";
$this->idioma["noDefinido"]="No definido";
$this->idioma["encabezadoBarra"]="GENERADOR DE CERTIFICACIONES UNIVERSIDAD DISTRITAL Francisco José de Caldas";

?>