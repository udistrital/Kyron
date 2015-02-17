<?php
$this->idioma[sha1('usuario'.$_REQUEST['tiempo'])]="Identificación";
$this->idioma[sha1('clave'.$_REQUEST['tiempo'])]="Clave";
$this->idioma[sha1('usuario'.$_REQUEST['tiempo']).'Titulo']='Número de documento o código en caso de estudiantes.';
$this->idioma[sha1('clave'.$_REQUEST['tiempo']).'Titulo']="Clave de Acceso";
$this->idioma["botonAceptar"]="Ingresar";
$this->idioma["botonCancelar"]="Cancelar";
$this->idioma["noDefinido"]="No definido";
$this->idioma["botonIngresar"]="Ingresar";

$this->idioma["mensajePie"]="Universidad Distrital Francisco José de Caldas
		Todos los derechos reservados.
		Carrera 8 N. 40-78 Piso 1 / PBX 3238400 - 3239300
<a class='enlace' href='mailto:computo@udistrital.edu.co'>computo@udistrital.edu.co</a>";

?>