<?php 


$ruta=$this->miConfigurador->getVariableConfiguracion("raizDocumento");
$ruta.="/blocks/".$esteBloque["grupo"]."/".$esteBloque["nombre"]."/";

include($ruta."/locale/es_es/Mensaje.php");

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

//Arreglo que contiene la descripción del modelo de cada columna. Debe coincidir en número de elementos
//al arreglo $nombreColumnas.

$modeloColumnas=array(
		//Columna 1:
		"{ name:'elemento', 
		index:'elemento'
		}",
		
		//Campo Oculto
		
		"{ name:'idElemento',
		index:'idElemento',
		hidden:true
		}",		
		
		//Columna 2:
		"{ name:'cantidad', 
		index:'cantidad', 
		width:40, 
		align:'center', 
		formatter:'number', 
		formatoptions:{
			decimalPlaces: 0
			}				
		}",
		
		//Columna 3:
		"{ name:'precio', 
		index:'precio', 
		width:80, 
		align:'right', 
		formatter:'currency',
		formatoptions:{
			decimalSeparator:',', 
			thousandsSeparator: '.', 
			decimalPlaces: 2, 
			prefix: '$'
			}			 
		}",
		
		//Columna 4
		"{ name:'descuento', 
		index:'descuento', 
		width:80, 
		align:'right', 
		formatter:'currency', 
		formatoptions:{
			decimalSeparator:',', 
			thousandsSeparator: '.', 
			decimalPlaces: 2, 
			prefix: '$'
			}
		}",
		
		//Columna 5
		//Esta columna es un cuadro de lista que rescata los datos a partir de ajax desde la url especificada en $estaUrl
		"{ name:'iva', 
		index:'iva', 
		width:40, 
		align:'right'		
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
		align:'center'
		}",
		
		//Columna 7		
		"{ name:'descripcionElemento', 
		index:'descripcionElemento', 
		width:100, align:'right'
		}",
		
		//Columna 8
		"{ 
		name:'marca', 
		index:'marca', 
		width:80, 
		align:'right'		 		
		}",
		
		//Campo Oculto
		
		"{ name:'idMarca',
		index:'idElemento',
		hidden:true
		}",
		
		//Columna 9
		"{ name:'serialElemento', 
		index:'serialElemento', 
		width:80, 
		align:'right'
		}"		
	
);


?>