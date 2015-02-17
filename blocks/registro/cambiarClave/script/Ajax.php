<?php
/**
 * Importante: Si se desean los datos del bloque estos se encuentran en el arreglo $esteBloque
 *
 * Las funciones relacionadas con las peticiones AJAX tienen como punto de entrada el archivo procesarAjax.php en la carpeta funcion
 *
 */
$url=$this->miConfigurador->getVariableConfiguracion("host");
$url.=$this->miConfigurador->getVariableConfiguracion("site");
$url.="/index.php?";

$cadenaACodificar="pagina=".$this->miConfigurador->getVariableConfiguracion("pagina");

//Se debe tener una variable llamada procesarAjax
$cadenaACodificar.="&procesarAjax=true";
$cadenaACodificar.="&bloqueNombre=".$esteBloque["nombre"];
$cadenaACodificar.="&bloqueGrupo=".$esteBloque["grupo"];
$cadenaACodificar.="&action=index.php";

$campo=array("#entrada", "#elemento", "#sede", "#dependencia", "#funcionario");

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
	
	minLength: 1,
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
	},

    focus: function(event, ui) {
        event.preventDefault();
        $("<?php echo $valor ?>").val(ui.item.label);
    }    
    
	
});
});
</script>
<?php }?>