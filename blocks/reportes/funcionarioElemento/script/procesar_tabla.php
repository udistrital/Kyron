<?php

/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=Consulta";
$cadenaACodificar .= "&usuario=" . $_REQUEST ['usuario'];
$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];

if (isset ( $_REQUEST ['accesoCondor'] ) && $_REQUEST ['accesoCondor'] == 'true') {
	
	$_REQUEST ['funcionario'] = $_REQUEST ['usuario'];
	$cadenaACodificar .= "&accesoCondor='true'";
}

if (isset ( $_REQUEST ['funcionario'] ) && $_REQUEST ['funcionario'] != '') {
	$funcionario = $_REQUEST ['funcionario'];
} else {
	$funcionario = '';
}

if (isset ( $_REQUEST ['sede'] ) && $_REQUEST ['sede'] != '') {
	$sede = $_REQUEST ['sede'];
} else {
	$sede = '';
}

if (isset ( $_REQUEST ['dependencia'] ) && $_REQUEST ['dependencia'] != '') {
	$dependencia = $_REQUEST ['dependencia'];
} else {
	$dependencia = '';
}

if (isset ( $_REQUEST ['ubicacion'] ) && $_REQUEST ['ubicacion'] != '') {
	$ubicacion = $_REQUEST ['ubicacion'];
} else {
	$ubicacion = '';
}

$arreglo = array (
		'funcionario' => $funcionario,
		'sede' => $sede,
		'dependencia' => $dependencia,
		'ubicacion' => $ubicacion 
);

$arreglo = serialize ( $arreglo );

$cadenaACodificar .= "&arreglo=" . $arreglo;

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );

// URL definitiva
$urlFinal = $url . $cadena;

?>
<script type='text/javascript'>




$(function() {
         	$('#tablaTitulos').ready(function() {

             $('#tablaTitulos').dataTable( {
//              	 serverSide: true,
				language: {
                url: "<?php echo $urlDirectorio?>"
            			},
             	processing: true,
		"aLengthMenu": [[10,25, 50,100,300,500,1000,-1], [10,25, 50,100,300,500,1000,'Todos']],
//                   ordering: true,
                  searching: true,
//                deferRender: true,
      //             sScrollY: 500	,
        //          bScrollCollapse: true,
                  info:true,
//                   lengthChange:true,
   		    "pagingType": "full_numbers",
//                   stateSave: true,
         //          renderer: "bootstrap",
         //          retrieve: true,
                  ajax:{
                      url:"<?php echo $urlFinal?>",
                      dataSrc:"data"                                                                  
                  },
                  columns: [
                  { data :"tipobien" },
                  { data :"placa" },
                  { data :"descripcion" },
                  { data :"sede" },
                  { data :"dependencia" },
                  { data :"espaciofisico" },
                  { data :"estadoelemento" },
                  { data :"contratista" },
                  { data :"detalle" },
                  { data :"observaciones" },
                  { data :"verificacion" },
                            ]
             });
                  
         		});

});




</script>
