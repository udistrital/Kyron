<?php 

$url=$this->miConfigurador->getVariableConfiguracion("host");
$url.=$this->miConfigurador->getVariableConfiguracion("site");
$url.="/index.php?";

$ruta=$this->miConfigurador->getVariableConfiguracion("raizDocumento");
$ruta.="/blocks/".$esteBloque["grupo"]."/".$esteBloque["nombre"]."/";


$cadenaACodificar="pagina=".$this->miConfigurador->getVariableConfiguracion("pagina");

//Se debe tener una variable llamada procesarAjax
$cadenaACodificar.="&procesarAjax=true";
$cadenaACodificar.="&bloqueNombre=".$esteBloque["nombre"];
$cadenaACodificar.="&bloqueGrupo=".$esteBloque["grupo"];
$cadenaACodificar.="&action=index.php";


include_once($ruta."/locale/es_es/Mensaje.php");

// Arreglo que contiene el nombre que se mostrará en el encabezado de las columnas.
$nombreColumnas=array(
		$this->idioma["elemento"],
		$this->idioma["idElemento"],
		$this->idioma["cantidad"],
		$this->idioma["precio"],
		$this->idioma["descuento"],
		$this->idioma["iva"],
		$this->idioma["idIva"],
		$this->idioma["codigoBarras"],
		$this->idioma["descripcionElemento"],
		$this->idioma["marcaElemento"],
		$this->idioma["idMarca"],
		$this->idioma["serialElemento"]
);

//URL que se utilizará para rescatar los datos de la columna idIva a través de ajax
$valor="#idIva";
$cadenaFinal=$cadenaACodificar."&funcion=".$valor;
$enlace=$this->miConfigurador->getVariableConfiguracion("enlace");
$estaUrl=$url. $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaFinal,$enlace);

//Arreglo que contiene la descripción del modelo de cada columna. Debe coincidir en número de elementos
//al arreglo $nombreColumnas.

$modeloColumnas=array(
		//Columna 1:
		/**
		 * Para activar validación: registrar las opciones en editoptions atributo class
		 * Para activar autocompletado: invocar una función que ejecute el ajax. Esto se realiza
		 * en la función anónima del atributo dataInit en editoptions.
		 * 
		 * Por convención de Sara, las funciones autoCompletarElemento() y poblarMarca se crean en Ajax.php pues requieren ajax. 
		 *		 
		 */
		"{ name:'elemento', 
		index:'elemento', 
		width:80, 
		align:'right', 
		editable:true, 
		editoptions: { 
			class:'validate[required] text-input', 
			dataInit:function (elem) {
				autoCompletarElemento(elem)
				},
			dataEvents: [
                       {
                          type: 'change',
                          fn: function(elem) {
                            poblarMarca();	
							actualizarId();	
							   }
						}
                       ]
			}
		}",
		
		//Campo Oculto
		
		"{ name:'idElemento',
		index:'idElemento',
		editable:true,
		hidden:true
		}",		
		
		//Columna 2:
		"{ name:'cantidad', 
		index:'cantidad', 
		width:40, 
		align:'center', 
		editable:true, 
		formatter:'number', 
		formatoptions:{
			decimalPlaces: 0
			},
		editoptions: { 
			class:'validate[required, min[1],max[999], custom[integer]] text-input'
			}		
		}",
		
		//Columna 3:
		"{ name:'precio', 
		index:'precio', 
		width:80, 
		align:'right', 
		editable:true, 
		formatter:'currency',
		formatoptions:{
			decimalSeparator:',', 
			thousandsSeparator: '.', 
			decimalPlaces: 2, 
			prefix: '$'
			},
		editoptions: { 
			class:'validate[required, custom[number]] text-input'
			}	 
		}",
		
		//Columna 4
		"{ name:'descuento', 
		index:'descuento', 
		width:80, 
		align:'right', 
		editable:true, 
		formatter:'currency', 
		formatoptions:{
			decimalSeparator:',', 
			thousandsSeparator: '.', 
			decimalPlaces: 2, 
			prefix: '$'
			},
		editoptions: { 
			class:'validate[custom[number]] text-input'
			}	
		}",
		
		//Columna 5
		//Esta columna es un cuadro de lista que rescata los datos a partir de ajax desde la url especificada en $estaUrl
		"{ name:'iva', 
		index:'iva', 
		width:40, 
		align:'right', 
		editable:true, 
		edittype:'select', 
		editoptions: { 
			dataUrl:'".$estaUrl."',
			dataEvents: [
                     {
                       type: 'change',
                       fn: function(elem) {
							   actualizarId();		
			  			   }
					}
              ] 
			}
		}",
		
		//Campo Oculto
		
		"{ name:'idIva',
		index:'idElemento',
		editable:true,
		hidden:true
		}",
		
		
		
		//Columna 6		
		"{ name:'codigoBarras', 
		index:'codigoBarras', 
		width:60, 
		align:'center', 
		editable:true,
		editoptions: { 
			class:'validate[custom[number]] text-input'
		}	
		}",
		
		//Columna 7		
		"{ name:'descripcionElemento', 
		index:'descripcionElemento', 
		width:100, align:'right', 
		editable:true, 
		edittype:'textarea', 
		editoptions: {rows:'2',cols:'20'}}",
		
		//Columna 8
		//TODO revisar
		"{ 
		name:'marca', 
		index:'marca', 
		width:80, 
		align:'right', 
		editable:true,
		edittype:'select',
		editoptions:{
				value:{1:'N/A',2:'A'},
				dataEvents: [
                     {
                       type: 'change',
                       fn: function(elem) {
							   actualizarId();		
			  			   }
					}
              ] 
				} 		
		}",
		
		//Campo Oculto
		
		"{ name:'idMarca',
		index:'idElemento',
		editable:true,
		hidden:true
		}",
		
		//Columna 9
		"{ name:'serialElemento', 
		index:'serialElemento', 
		width:80, 
		align:'right', 
		editable:true
		}"		
	
);


?>