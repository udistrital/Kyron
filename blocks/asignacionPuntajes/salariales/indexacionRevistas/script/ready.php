<?php
// Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
// if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>

// Asociar el widget tabs a la división cuyo id es tabs
$(function() {
$("#tabs").tabs();
}); 

