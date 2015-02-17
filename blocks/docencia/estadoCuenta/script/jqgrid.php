<?php

/**
 *  Para armar la grilla con jqGrid se deben tener dos arreglos:
 *  $nombresColumnas: Arreglo que contiene el nombre que se mostrará en el encabezado de las columnas.
 *  $modeloColumnas: Arreglo que contiene la descripción del modelo de cada columna. Debe coincidir en número de elementos
 *  al arreglo $nombreColumnas.
 *
 */

/**
 *  Para facilitar la modificación los arreglos se declaran en un script independiente llamado arreglosJqgrid
 */

$rutaEsteBloque=$this->miConfigurador->getVariableConfiguracion("raizDocumento");

if($esteBloque["grupo"]==""){
	$rutaEsteBloque.="/blocks/".$esteBloque["nombre"];
}else{
	$rutaEsteBloque.="/blocks/".$esteBloque["grupo"]."/".$esteBloque["nombre"];
}

if(!isset($_REQUEST["opcion"])|| (isset($_REQUEST["opcion"])&&$_REQUEST["opcion"]=="nuevo")){
	include_once($rutaEsteBloque."/script/scriptJqgrid/arreglosJqgrid.php");

	//Nombres de los elementos html en los que se mostrará la grilla (una tabla y una división).
	// En este bloque, estos elementos se declaran en el archivo tabElementos (carpeta formulario->tabs)
	$nombreTabla="#gridElementos";
	$nombreDivPaginador="#paginadorElementos";
	include_once ($rutaEsteBloque."/script/scriptJqgrid/variablesJqGrid.php");

	$funcionActualizarId="function actualizarId(){
			$('#idMarca').val($('#marca').find(':selected').text());
			$('#idIva').val($('#iva').find(':selected').text());
}";

	$datosAConfirmar="";

	$cadenaJqgrid="$('".$nombreTabla."').jqGrid('navGrid','".
			$nombreDivPaginador."',
			{edit:true,add:true,del:true, closeOnEscape:true, cloneToTop:true},
					editSettings,
					addSettings,
					delSettings);";

}elseif((isset($_REQUEST["opcion"])&&$_REQUEST["opcion"]=="confirmar")){

	include_once($rutaEsteBloque."/script/scriptJqgrid/arreglosConfirmarJqgrid.php");
	$nombreTabla="#gridConfirmarElementos";
	$nombreDivPaginador="#paginadorConfirmarElementos";

	$funcionActualizarId="";

	$cadenaJqgrid="$('".$nombreTabla."').jqGrid('navGrid','".
			$nombreDivPaginador."',
			{edit:false,add:false,del:false}
					);";
}

?>
<script type='text/javascript'>
	<?php 
	
	echo $funcionActualizarId; ?>
	
	$(function() {
		
		$("<?php echo $nombreTabla ?>").jqGrid({
			colNames:[<?php
			$cadena="";
			foreach($nombreColumnas as $valor){
				$cadena.="'".$valor."',";
			}
			echo substr($cadena,0,strlen($cadena)-1);
			?>],
		   	colModel:[<?php
		    $cadena="";
			foreach($modeloColumnas as $valor){
				$cadena.=$valor.",";
			}
			echo substr($cadena,0,strlen($cadena)-1);
		?>],
		   	rowNum:10,
		   	rowList:[10,20,30],
		   	pager: '<?php echo $nombreDivPaginador ?>',
		   	sortname: 'id',
		    viewrecords: true,
		    sortorder: "desc",
	        width: 750,
	        footerrow: true,
	        userDataOnFooter: true,
	        editurl: 'clientArray',
			caption: "Elementos de la Entrada"
		});
		//Si se quiere utilizar autocomplete con edición tipo formulario se debe cambiar el z-index asociado a autocomplete en
		//el css de jquery-ui 
		
		<?php echo $cadenaJqgrid; ?>
		
		//La siguiente línea se utiliza si se desea tener el paginador. En este caso no es necesario.
		//jQuery("<?php echo $nombreTabla ?>").jqGrid('inlineNav',"<?php echo $nombreDivPaginador ?>");
		
	});
	</script>
