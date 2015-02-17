<?php

//Las etiquetas de la selección se colocarán en estos campos:
$campo=array("#proveedor", "#dependenciaSupervisora", "#iva");

/**
 * Los id se colocarán en campos cuyos nombres son iguales a los del arreglo pero inician con id.
 * Ejemplo: proveedor debe tener un campo oculto asociado llamado idProveedor
 */

foreach($campo as $valor){

	$cadenaFinal=$cadenaACodificar."&funcion=".$valor;
	$enlace=$this->miConfigurador->getVariableConfiguracion("enlace");
	$laurl= $url. $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaFinal,$enlace);

	?>
<script type='text/javascript'>
$(function() {
$( "<?php echo $valor ?>" ).autocomplete({
	source: function( request, response ) {
		$.ajax({
			url: "<?php echo $laurl?>",
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
        $("<?php echo $valor ?>").val(ui.item.label);
        $("<?php echo substr_replace($valor,"id".strtoupper(substr($valor,1,1)).substr($valor,2),1);?>").val(ui.item.value);
	},

    focus: function(event, ui) {
        event.preventDefault();
        $("<?php echo $valor ?>").val(ui.item.label);
        $("<?php echo substr_replace($valor,"id".strtoupper(substr($valor,1,1)).substr($valor,2),1);?>").val(ui.item.value);
    }    
    
	
});
});
</script>
<?php }?>