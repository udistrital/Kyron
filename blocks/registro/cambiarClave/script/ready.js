// Asociar el widget de validación al formulario
$("#cambiarClave").validationEngine({
    promptPosition : "centerRight", 
    scroll: false
});



$(function() {
    $( document ).tooltip();
});

//Asociar el widget tabs a la división cuyo id es tabs
$(function() {
    $( "#tabs" ).tabs();
});
        
$(function() {
    $("button").button().click(function(event) {
        event.preventDefault();
    });
});
