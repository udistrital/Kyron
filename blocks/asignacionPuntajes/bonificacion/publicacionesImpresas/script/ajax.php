<?php
/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */

// URL base
$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$url .= "/index.php?";
// Variables
$cadenaACodificarDocente = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificarDocente .= "&procesarAjax=true";
$cadenaACodificarDocente .= "&action=index.php";
$cadenaACodificarDocente .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarDocente .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarDocente .= "&funcion=consultarDocente";
$cadenaACodificarDocente .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificarDocente, $enlace );

// URL definitiva
$urlFinalDocente = $url . $cadena;
?>

$( "#<?php echo $this->campoSeguro('docente')?>" ).keyup(function() {
	$('#<?php echo $this->campoSeguro('docente') ?>').val($('#<?php echo $this->campoSeguro('docente') ?>').val().toUpperCase());
});

$( "#<?php echo $this->campoSeguro('docente')?>" ).change(function() {
	if($('#<?php echo $this->campoSeguro('docente') ?>').val()==''){
		$("#<?php echo $this->campoSeguro('id_docente') ?>").val('');
	}
});

$("#<?php echo $this->campoSeguro('docente') ?>").autocomplete({
	minChars: 3,
	serviceUrl: '<?php echo $urlFinalDocente; ?>',
	onSelect: function (suggestion) {
    	$("#<?php echo $this->campoSeguro('id_docente') ?>").val(suggestion.data);
	}
});


//////////////////Función que se ejecuta al seleccionar alguna opcón del contexto de la revista////////////////////

$("#<?php echo $this->campoSeguro('contextoRevista')?>").change(function() {

	if($("#<?php echo $this->campoSeguro('contextoRevista')?>").val() == ''){

		$("<option value=''>Seleccione .....</option>").appendTo("#<?php echo $this->campoSeguro('pais')?>");
		
		$("#<?php echo $this->campoSeguro('pais_div')?>").css('display','none'); 
		$("#<?php echo $this->campoSeguro('categoria_div')?>").css('display','none');
		 		
	}else{

		$("#<?php echo $this->campoSeguro('pais')?>").html("");
		$("<option value=''>Seleccione .....</option>").appendTo("#<?php echo $this->campoSeguro('pais')?>");
		consultarPais();

		$("#<?php echo $this->campoSeguro('categoria')?>").html("");
		$("<option value=''>Seleccione .....</option>").appendTo("#<?php echo $this->campoSeguro('categoria')?>");
		consultarCategoria();
		
		$("#<?php echo $this->campoSeguro('pais_div')?>").css('display','block'); 
		$("#<?php echo $this->campoSeguro('categoria_div')?>").css('display','block'); 
		
		$("#<?php echo $this->campoSeguro('pais')?>").select2();
		$("#<?php echo $this->campoSeguro('categoria')?>").select2();

		if($("#<?php echo $this->campoSeguro('contextoRevista')?>").val() == 0){
			$("#<?php echo $this->campoSeguro('pais')?>").val(1);
			var label = document.querySelector('label[for="categoria"]');
			label.textContent = 'Categorías';
		}else if($("#<?php echo $this->campoSeguro('contextoRevista')?>").val() == 1){
			var label = document.querySelector('label[for="categoria"]');
			label.textContent = 'Tipo de Indexación';
		}
		
	}
	
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


///////////////Función que se encarga de hacer dinámico el campo país////////////////  


<?php

$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$url .= "/index.php?";

// Variables
$cadenaACodificarPais = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificarPais .= "&procesarAjax=true";
$cadenaACodificarPais .= "&action=index.php";
$cadenaACodificarPais .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarPais .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarPais .= "&funcion=consultarPais";
$cadenaACodificarPais .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificarPais, $enlace );

// URL definitiva
$urlFinalPais = $url . $cadena;

?>

function consultarPais(elem, request, response){
	$.ajax({
		url: "<?php echo $urlFinalPais?>",
		dataType: "json",
		data: { valor:$("#<?php echo $this->campoSeguro('contextoRevista')?>").val()},
		success: function(data){
			if(data[0]!=" "){
				$("#<?php echo $this->campoSeguro('pais')?>").html('');
				$("<option value=''>Seleccione .....</option>").appendTo("#<?php echo $this->campoSeguro('pais')?>");
				$.each(data , function(indice,valor){
					$("<option value='"+data[ indice ].paiscodigo+"'>"+data[ indice ].paisnombre+"</option>").appendTo("#<?php echo $this->campoSeguro('pais')?>");
				});
			}
		}
	});
};


//////////////*******Función que permite enviar los caracteres a medida que se van ingresando e ir recibiendo una respuesta para ir mostrando posibles docentes*******/////////////// 
//////////////////////ver en procecarajax.php la función consultarDocente y en sql.class.php ver la sentencia docente.////////////////////////////////////////////////////////////////
//////////////////////Para que esta función se ejecute correctamente debe agregar//
<?php
// Variables
$cadenaACodificarDocenteReg = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificarDocenteReg .= "&procesarAjax=true";
$cadenaACodificarDocenteReg .= "&action=index.php";
$cadenaACodificarDocenteReg .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarDocenteReg .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarDocenteReg .= "&funcion=consultarDocenteReg";
$cadenaACodificarDocenteReg .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificarDocenteReg, $enlace );

// URL definitiva
$urlFinalDocenteReg = $url . $cadena;
?>

$(function () {
    $( "#<?php echo $this->campoSeguro('docenteRegistrar')?>" ).keyup(function() {
		$('#<?php echo $this->campoSeguro('docenteRegistrar') ?>').val($('#<?php echo $this->campoSeguro('docenteRegistrar') ?>').val().toUpperCase());
    });
    $("#<?php echo $this->campoSeguro('docenteRegistrar') ?>").autocomplete({
    	minChars: 3,
    	serviceUrl: '<?php echo $urlFinalDocente; ?>',
    	onSelect: function (suggestion) {        		
    	        $("#<?php echo $this->campoSeguro('id_docenteRegistrar') ?>").val(suggestion.data);
    	    }
    });

});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


///////////////Función que se encarga de hacer dinámico el campo categoría////////////////  
<?php

$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$url .= "/index.php?";

// Variables
$cadenaACodificarCategoria = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificarCategoria .= "&procesarAjax=true";
$cadenaACodificarCategoria .= "&action=index.php";
$cadenaACodificarCategoria .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarCategoria .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarCategoria .= "&funcion=consultarCategoria";
$cadenaACodificarCategoria .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificarCategoria, $enlace );
// URL definitiva
$urlFinalCategoria = $url . $cadena;
?>

function consultarCategoria(elem, request, response){
	$.ajax({
		url: "<?php echo $urlFinalCategoria?>",
		dataType: "json",
		data: { valor:$("#<?php echo $this->campoSeguro('contextoRevista')?>").val()},
		success: function(data){
			if(data[0]!=" "){
				$("#<?php echo $this->campoSeguro('categoria')?>").html("");
				$("<option value=''>Seleccione .....</option>").appendTo("#<?php echo $this->campoSeguro('categoria')?>");
				$.each(data , function(indice,valor){
					$("<option value='"+data[ indice ].id_tipo_indexacion+"'>"+data[ indice ].descripcion+"</option>").appendTo("#<?php echo $this->campoSeguro('categoria')?>");
				});
			}
		}
	});
};
///////////////////////////////////////////////////////////////////////////////////// 
    	 


if($("#<?php echo $this->campoSeguro('contextoRevista')?>").val() == 0 || $("#<?php echo $this->campoSeguro('contextoRevista')?>").val() == 1){
	$('#<?php echo $this->campoSeguro('contextoRevista')?>').width(400);
	$('#<?php echo $this->campoSeguro('pais')?>').width(470);
	$('#<?php echo $this->campoSeguro('categoria')?>').width(470);
	$("#<?php echo $this->campoSeguro('pais')?>").select2();
	$("#<?php echo $this->campoSeguro('categoria')?>").select2();
}
