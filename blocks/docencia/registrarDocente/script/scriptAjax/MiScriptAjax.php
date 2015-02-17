<script type='text/javascript'>
function modificar(elem, request, response){
	
<?php
$valor = "facultad";
$cadenaFinal = $cadenaACodificar . "&funcion=" . $valor;
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$estaUrl = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaFinal, $enlace );
?>
	$.ajax(	{
		url: "<?php echo $estaUrl?>",
		dataType: "json",
		data: {
			facultad:	$("#facultad").val(),
		},
		success: function(data) { 
		
			                
				$('#proyectoCurricular').html('');
				
				
      $.each(data , function(indice,valor){
    

				$("<option value='"+data[ indice ].codigo_proyecto+"'>"+data[ indice ].nombre_proyecto+"</option>").appendTo("#proyectoCurricular");
      });
       
                $('#proyectoCurricular').removeAttr('disabled');
				

	}
		
			 
	});





	
};
</script>