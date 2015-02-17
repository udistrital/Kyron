<?php
/**
 * @todo Cuando se carga este archivo aún no se tiene ningún ejemplar de las clases del bloque.
 * Esto impide que se puedan datos de las etiquetas desde el archivo locale. Se debe
 *
 */


$valor="#idElemento";
$cadenaFinal=$cadenaACodificar."&funcion=".$valor;
$enlace=$this->miConfigurador->getVariableConfiguracion("enlace");
$estaUrl=$url. $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaFinal,$enlace);
?>
<script type='text/javascript'>
function autoCompletarElemento(elem){
$(elem).autocomplete({
	source: function( request, response ) {
		$.ajax({
			url: "<?php echo $estaUrl?>",
			dataType: "json",
			data: {
				featureClass: "P",
				style: "full",
				maxRows: 12,
				name_startsWith: request.term
			},
			 success: function(data) {
				 response($.map(data, function( item,i ) {
				 return item;
				 }));
				 }
		});
	},
	
	minLength: 3,
	autofocus:true,

	open: function() {
		$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
	},
	close: function() {
		$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
	},

	select: function(event, ui) {
        event.preventDefault();
        $(elem).val(ui.item.label);
        $('#idElemento').val(ui.item.value);
	},

    focus: function(event, ui) {
        event.preventDefault();
        $(elem).val(ui.item.label);
        $('#idElemento').val(ui.item.value);
    }    
    
	
});
};
<?php 
$valor="#idIva";
$cadenaFinal=$cadenaACodificar."&funcion=".$valor;
$enlace=$this->miConfigurador->getVariableConfiguracion("enlace");
$estaUrl=$url. $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaFinal,$enlace);

?>

function rescatarIva(elem, request, response){
	$.ajax({
		url: "<?php echo $estaUrl?>",
		dataType: "json",
		data: {
			featureClass: "P",
			style: "full",
			maxRows: 12		
		},
		 success: function(data) {			 
			 return data;
		}
			 
	});
};


<?php

$valor="#marca";
$cadenaFinal=$cadenaACodificar."&funcion=".$valor;
$enlace=$this->miConfigurador->getVariableConfiguracion("enlace");
$estaUrl=$url. $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaFinal,$enlace);

?>

function poblarMarca(){

	var respuesta=$.ajax({
				url: "<?php echo $estaUrl?>",
				dataType: "html",
				data: {
					featureClass: "P",
					style: "full",
					maxRows: 12,
					idElemento:	$("#idElemento").val()	
				}	 
		})
	 .done(function(data) { 
		 $('<?php echo $valor?>').replaceWith(data);
		  
		 })
	 .fail(function() { alert("error"); });

}
</script>