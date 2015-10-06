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


//////////////////Función que se ejecuta al seleccionar alguna opción del contexto de la Entidad////////////////////

$("#<?php echo $this->campoSeguro('contexto')?>").change(function() {

	if($("#<?php echo $this->campoSeguro('contexto')?>").val() == ''){

		$("<option value=''>Seleccione .....</option>").appendTo("#<?php echo $this->campoSeguro('pais')?>");
		$("#<?php echo $this->campoSeguro('ciudad')?>").select2('val','-1');
		
		$("#<?php echo $this->campoSeguro('pais_div')?>").css('display','none'); 
		$("#<?php echo $this->campoSeguro('ciudad_div')?>").css('display','none'); 
		 		
	}else{
		
		$("#<?php echo $this->campoSeguro('ciudad')?>").select2('val','-1');

		$("#<?php echo $this->campoSeguro('pais')?>").html("");
		$("<option value=''>Seleccione .....</option>").appendTo("#<?php echo $this->campoSeguro('pais')?>");
		consultarPais();
		
		$("#<?php echo $this->campoSeguro('pais_div')?>").css('display','block'); 
		
		$("#<?php echo $this->campoSeguro('pais')?>").select2();
	}
	
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////Función que se ejecuta al seleccionar alguna opción del contexto de la Entidad////////////////////

$("#<?php echo $this->campoSeguro('pais')?>").change(function() {

	if($("#<?php echo $this->campoSeguro('contexto')?>").val() == ''){

		$("<option value=''>Seleccione .....</option>").appendTo("#<?php echo $this->campoSeguro('ciudad')?>");
		
		$("#<?php echo $this->campoSeguro('ciudad_div')?>").css('display','none');
		 		
	}else{

		$("#<?php echo $this->campoSeguro('ciudad')?>").html("");
		$("<option value=''>Seleccione .....</option>").appendTo("#<?php echo $this->campoSeguro('ciudad')?>");
		consultarCiudad();
		
		$("#<?php echo $this->campoSeguro('ciudad_div')?>").css('display','block'); 
		
		$("#<?php echo $this->campoSeguro('ciudad')?>").select2();
		
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
		data: { valor:$("#<?php echo $this->campoSeguro('contexto')?>").val()},
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
$cadenaACodificarCiudad = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificarCiudad .= "&procesarAjax=true";
$cadenaACodificarCiudad .= "&action=index.php";
$cadenaACodificarCiudad .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarCiudad .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarCiudad .= "&funcion=consultarCiudad";
$cadenaACodificarCiudad .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificarCiudad, $enlace );
// URL definitiva
$urlFinalCiudad = $url . $cadena;
?>

function consultarCiudad(elem, request, response){
	$.ajax({
		url: "<?php echo $urlFinalCiudad?>",
		dataType: "json",
		data: { valor:$("#<?php echo $this->campoSeguro('pais')?>").val()},
		success: function(data){
			if(data[0]!=" "){
				$("#<?php echo $this->campoSeguro('ciudad')?>").html("");
				$("<option value=''>Seleccione .....</option>").appendTo("#<?php echo $this->campoSeguro('ciudad')?>");
				$.each(data , function(indice,valor){
					$("<option value='"+data[ indice ].ciudadid+"'>"+data[ indice ].ciudadnombre+"</option>").appendTo("#<?php echo $this->campoSeguro('ciudad')?>");
				});
			}
		}
	});
};
///////////////////////////////////////////////////////////////////////////////////// 
    	 


if($("#<?php echo $this->campoSeguro('contexto')?>").val() == 0 || $("#<?php echo $this->campoSeguro('contexto')?>").val() == 1){
	$('#<?php echo $this->campoSeguro('contexto')?>').width(400);
	$('#<?php echo $this->campoSeguro('pais')?>').width(470);
	$('#<?php echo $this->campoSeguro('ciudad')?>').width(470);
	$("#<?php echo $this->campoSeguro('pais')?>").select2();
	$("#<?php echo $this->campoSeguro('ciudad')?>").select2();
}
