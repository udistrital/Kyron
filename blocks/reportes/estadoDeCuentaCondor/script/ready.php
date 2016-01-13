

<?php
$esteBloque = $this->miConfigurador->getVariableConfiguracion ( 'esteBloque' );

$enlace = "action=index.php";
$enlace .= "&bloqueNombre=" . $esteBloque ["nombre"];
$enlace .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$enlace .= "&procesarAjax=true";
$enlace .= "&funcion=guardarObservacion";
$enlace .= "&docente=" . $_REQUEST['docente'];
$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
?>

function guardarObservacion(name){	
	var llaves_primarias_valor = name;
	var id_tipo_observacion = $("[name="+name+"]:checkbox").val();
	var observacion = $("textarea[name="+name+"]").val();
	var verificado = $("[name="+name+"]:checkbox").is(":checked");
	var data = {
	  	"llaves_primarias_valor":llaves_primarias_valor,
	  	"id_tipo_observacion":id_tipo_observacion,
	  	"observacion":observacion,
	  	"verificado":verificado
	};
	$.ajax({
	  type: "POST",
	  url: "<?php echo $enlace;?>",
	  data: data,
	  success: registroGuardado
	});
	function registroGuardado(data){
		if(data.errorType){
			alert(data.errorMessage);
		}
	}
}

$(".checkbox-verificacion").change(function(e){
	var name = $(this).attr("name");
	guardarObservacion(name);
});

$(".text-observacion").focus(function(e){
	$(this).addClass("selected");
	$(this).removeClass("noselected");
});

$(".text-observacion").blur(function(e){
	$(this).addClass("noselected");
	$(this).removeClass("selected");
	var name = $(this).attr("name");
	guardarObservacion(name);
});

$(".text-observacion").keypress(function(e) {
    if(e.which == 13) {
    	$(':focus').blur();
    }
});

//Se utiliza para cargar elementos del builder
$.each(_arregloCreacionElementos,function(){
	this();
});
