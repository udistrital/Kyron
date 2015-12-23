<?php
/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */

// URL base
$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );

$urlDirectorio=$url;

$urlDirectorio =$urlDirectorio."/plugin/scripts/javascript/dataTable/Spanish.json";

$url .= "/index.php?";



// Variables
$cadenaACodificar16 = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar16 .= "&procesarAjax=true";
$cadenaACodificar16 .= "&action=index.php";
$cadenaACodificar16 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar16 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar16 .= $cadenaACodificar16 . "&funcion=consultarDependencia";
$cadenaACodificar16 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena16 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar16, $enlace );

// URL definitiva
$urlFinal16 = $url . $cadena16;
// echo $urlFinal;




// Variables
$cadenaACodificar2 = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar2 .= "&procesarAjax=true";
$cadenaACodificar2 .= "&action=index.php";
$cadenaACodificar2 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar2 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar2 .= "&funcion=SeleccionTipoBien";
$cadenaACodificar2 .="&tiempo=".$_REQUEST['tiempo'];


// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena2= $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar2, $enlace );

// URL definitiva
$urlFinal2 = $url . $cadena2;


// Variables
$cadenaACodificar4 = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar4 .= "&procesarAjax=true";
$cadenaACodificar4 .= "&action=index.php";
$cadenaACodificar4 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar4 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar4 .= $cadenaACodificar4 . "&funcion=consultarUbicacion";
$cadenaACodificar4 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena4 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar4, $enlace );

// URL definitiva
$urlFinal4 = $url . $cadena4;



?>
<script type='text/javascript'>




function marcar(obj) {
    elem=obj.elements;
    for (i=0;i<elem.length;i++)
        if (elem[i].type=="checkbox")
            elem[i].checked=true;
} 

function desmarcar(obj) {
    elem=obj.elements;
    for (i=0;i<elem.length;i++)
        if (elem[i].type=="checkbox")
            elem[i].checked=false;
} 



function verificarElementos(obj) {
	elem=obj.elements;
	desicion= 0;
    for (i=0;i<elem.length;i++)
    { 
 		if (elem[i].type=="checkbox"){
        	if (elem[i].checked==true){
        		$('#<?php echo $this->campoSeguro('botonAprobar')?>').removeAttr('disabled');
        		$('#<?php echo $this->campoSeguro('botonGuadar')?>').attr('disabled','disabled');
             	}else if(elem[i].checked==false){
				desicion= 1;
 				}

			if(desicion==1 ){
				$('#<?php echo $this->campoSeguro('botonGuadar')?>').removeAttr('disabled');
        		$('#<?php echo $this->campoSeguro('botonAprobar')?>').attr('disabled','disabled');
				}
    	}            
	} 
}




function consultarEspacio(elem, request, response){
	  $.ajax({
	    url: "<?php echo $urlFinal4?>",
	    dataType: "json",
	    data: { valorD:$("#<?php echo $this->campoSeguro('dependencia')?>").val(),
    		valorS:$("#<?php echo $this->campoSeguro('sede')?>").val(),},
	    success: function(data){ 



	        if(data[0]!=" "){

	            $("#<?php echo $this->campoSeguro('ubicacion')?>").html('');
	            $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('ubicacion')?>");
	            $.each(data , function(indice,valor){

	            	$("<option value='"+data[ indice ].ESF_ID_ESPACIO+"'>"+data[ indice ].ESF_NOMBRE_ESPACIO+"</option>").appendTo("#<?php echo $this->campoSeguro('ubicacion')?>");
	            	
	            });
	            
	            $("#<?php echo $this->campoSeguro('ubicacion')?>").removeAttr('disabled');
	            
	            $('#<?php echo $this->campoSeguro('ubicacion')?>').width(500);
	            $("#<?php echo $this->campoSeguro('ubicacion')?>").select2();
	            
	          
	            
		        }
	    			

	    }
		                    
	   });
	};





function tipo_bien(elem, request, response){
	  $.ajax({
	    url: "<?php echo $urlFinal2?>",
	    dataType: "json",
	    data: { valor:$("#<?php echo $this->campoSeguro('nivel')?>").val()},
	    success: function(data){ 


	    			$("#<?php echo $this->campoSeguro('id_tipo_bien')?>").val(data[0]);
	    			$("#<?php echo $this->campoSeguro('tipo_bien')?>").val(data[1]);

	    			  switch($("#<?php echo $this->campoSeguro('id_tipo_bien')?>").val())
	    	            {
	    	                           
	    	                
	    	                case '2':


	    	                    $("#<?php echo $this->campoSeguro('devolutivo')?>").css('display','none');
	    	                    $("#<?php echo $this->campoSeguro('consumo_controlado')?>").css('display','block');   
	    	                 $("#<?php echo $this->campoSeguro('cantidad')?>").val('1');
	    	                 $('#<?php echo $this->campoSeguro('cantidad')?>').attr('disabled','');

	    	                 break;
	    	                
	    	                case '3':

	    	                    $("#<?php echo $this->campoSeguro('devolutivo')?>").css('display','block');
	    	                    $("#<?php echo $this->campoSeguro('consumo_controlado')?>").css('display','none');
	    	                    $("#<?php echo $this->campoSeguro('tipo_poliza')?>").select2();
	    	         
	    	                 $("#<?php echo $this->campoSeguro('cantidad')?>").val('1');
	    	                 $('#<?php echo $this->campoSeguro('cantidad')?>').attr('disabled','');
	    	                    
	    	                break;
	    	                                
	    	           
	    	                break;
	    	                

	    	                default:

	    	                    $("#<?php echo $this->campoSeguro('devolutivo')?>").css('display','none');
	    	                    $("#<?php echo $this->campoSeguro('consumo_controlado')?>").css('display','none');   
	    	                    
	    	                 
	    	                 $("#<?php echo $this->campoSeguro('cantidad')?>").val('');
	    	                 $('#<?php echo $this->campoSeguro('cantidad')?>').removeAttr('disabled');
	    	                 
	    	                break;
	    	                
	    	                }






	    			

	    }
		                    
	   });
	};




function consultarDependencia(elem, request, response){
	  $.ajax({
	    url: "<?php echo $urlFinal16?>",
	    dataType: "json",
	    data: { valor:$("#<?php echo $this->campoSeguro('sede')?>").val()},
	    success: function(data){ 


	    	 if(data[0]!=" "){

		            $("#<?php echo $this->campoSeguro('dependencia')?>").html('');
		            $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependencia')?>");
		            $.each(data , function(indice,valor){

		            	$("<option value='"+data[ indice ].ESF_CODIGO_DEP+"'>"+data[ indice ].ESF_DEP_ENCARGADA+"</option>").appendTo("#<?php echo $this->campoSeguro('dependencia')?>");
		            	
		            });
		            
		            $("#<?php echo $this->campoSeguro('dependencia')?>").removeAttr('disabled');
		            
		            $('#<?php echo $this->campoSeguro('dependencia')?>').width(260);
		            $("#<?php echo $this->campoSeguro('dependencia')?>").select2();
		            
		          
		            
			        }
	    
	    			

	    }
		                    
	   });
	};

	  $(function () {



		   $("#<?php echo $this->campoSeguro('dependencia')?>").change(function(){
	        	if($("#<?php echo $this->campoSeguro('dependencia')?>").val()!=''){
	        		consultarEspacio();
	    		}else{
	    			$("#<?php echo $this->campoSeguro('ubicacion')?>").attr('disabled','');
	    			}

	    	      });


		  
		    $("#<?php echo $this->campoSeguro('nivel')?>").change(function() {
		    	
				if($("#<?php echo $this->campoSeguro('nivel')?>").val()!=''){

					tipo_bien();	

				}else{}

		    });
			  

	        $("#<?php echo $this->campoSeguro('sede')?>").change(function(){
	        	if($("#<?php echo $this->campoSeguro('sede')?>").val()!=''){
	            	consultarDependencia();
	    		}else{
	    			$("#<?php echo $this->campoSeguro('dependencia')?>").attr('disabled','');
	    			}

	    	      });
	        

	        $( "#<?php echo $this->campoSeguro('cantidad')?>" ).keyup(function() {
	            
	            $("#<?php echo $this->campoSeguro('valor')?>").val('');
	            $("#<?php echo $this->campoSeguro('subtotal_sin_iva')?>").val('');
	            $("#<?php echo $this->campoSeguro('total_iva')?>").val('');
	            $("#<?php echo $this->campoSeguro('total_iva_con')?>").val('');
	            
	          });  
		
	        $( "#<?php echo $this->campoSeguro('valor')?>" ).keyup(function() {
	        	$("#<?php echo $this->campoSeguro('subtotal_sin_iva')?>").val('');
	            $("#<?php echo $this->campoSeguro('total_iva')?>").val('');
	            $("#<?php echo $this->campoSeguro('total_iva_con')?>").val('');
	            
	            cantidad=Number($("#<?php echo $this->campoSeguro('cantidad')?>").val());
	            valor=Number($("#<?php echo $this->campoSeguro('valor')?>").val());
	            
	            precio = cantidad * valor;
	      
	      
	            if (precio==0){
	            
	            
	            $("#<?php echo $this->campoSeguro('subtotal_sin_iva')?>").val('');
	            
	            }else{
	            
	            $("#<?php echo $this->campoSeguro('subtotal_sin_iva')?>").val(precio);
	            
	            }

	          }); 
	          
	          $( "#<?php echo $this->campoSeguro('iva')?>" ).change(function() {
	        
	        
	        
			     switch($("#<?php echo $this->campoSeguro('iva')?>").val())
	            {
	                           
	                case '1':
	                 
	                 cantidad=Number($("#<?php echo $this->campoSeguro('cantidad')?>").val());
	            	 valor=Number($("#<?php echo $this->campoSeguro('valor')?>").val());
	       			 precio=cantidad * valor;
	       			 total=precio;
	       			 
	                 $("#<?php echo $this->campoSeguro('total_iva')?>").val('0');
	                 
	                 $("#<?php echo $this->campoSeguro('total_iva_con')?>").val(total);
	                                    
	                break;
	                
	                case '2':
	                 
	                 cantidad=Number($("#<?php echo $this->campoSeguro('cantidad')?>").val());
	            	 valor=Number($("#<?php echo $this->campoSeguro('valor')?>").val());
	       			 precio=cantidad * valor;
	       			 total=precio;
	       			 
	                 $("#<?php echo $this->campoSeguro('total_iva')?>").val('0');
	                 
	                 $("#<?php echo $this->campoSeguro('total_iva_con')?>").val(total);
	                                    
	                break;
	                
	                case '3':
	                
	                 cantidad=Number($("#<?php echo $this->campoSeguro('cantidad')?>").val());
	            	 valor=Number($("#<?php echo $this->campoSeguro('valor')?>").val());
	       			 iva = (cantidad * valor)* 0.05;
	       			 precio=cantidad * valor;
	       			 total=precio+iva;
	       			 
	                 $("#<?php echo $this->campoSeguro('total_iva')?>").val(iva);
	                 
	                 $("#<?php echo $this->campoSeguro('total_iva_con')?>").val(total);
	                    
	                break;
	                                
	                case '4':
	                
	                 cantidad=Number($("#<?php echo $this->campoSeguro('cantidad')?>").val());
	            	 valor=Number($("#<?php echo $this->campoSeguro('valor')?>").val());
	       			 iva = (cantidad * valor)* 0.04;
	       			 precio = cantidad*valor;
	       			 total=precio+iva;
	       			 
	                 $("#<?php echo $this->campoSeguro('total_iva')?>").val(iva);
	                 $("#<?php echo $this->campoSeguro('total_iva_con')?>").val(total);
	                                     
	                break;
	                

	                 case '5':
	                
	                 cantidad=Number($("#<?php echo $this->campoSeguro('cantidad')?>").val());
	            	 valor=Number($("#<?php echo $this->campoSeguro('valor')?>").val());
	       			 iva = (cantidad * valor)* 0.1;
	       			 precio = cantidad*valor;
	       			 total=precio+iva;
	       			 
	                 $("#<?php echo $this->campoSeguro('total_iva')?>").val(iva);
	                 $("#<?php echo $this->campoSeguro('total_iva_con')?>").val(total);
	                                     
	                break;
	                
	                 case '6':
	                
	                 cantidad=Number($("#<?php echo $this->campoSeguro('cantidad')?>").val());
	            	 valor=Number($("#<?php echo $this->campoSeguro('valor')?>").val());
	       			 iva = (cantidad * valor)* 0.16;
	       			 precio = cantidad*valor;
	       			 total=precio+iva;
	       			 
	                 $("#<?php echo $this->campoSeguro('total_iva')?>").val(iva);
	                 $("#<?php echo $this->campoSeguro('total_iva_con')?>").val(total);
	                                     
	                break;
	                
	                
	                default:
	                $("#<?php echo $this->campoSeguro('total_iva')?>").val('');
	                $("#<?php echo $this->campoSeguro('total_iva_con')?>").val('');
	                   
	                break;
	                
	                }
	            
	          });  
	          
	          $("#<?php echo $this->campoSeguro('iva')?>").select2();  
	          
	          
	         $( "#<?php echo $this->campoSeguro('tipo_bien')?>" ).change(function() {
	        
	        
	        
	          switch($("#<?php echo $this->campoSeguro('tipo_bien')?>").val())
	            {
	                           
	                
	                case '2':
	                
	                 $("#<?php echo $this->campoSeguro('cantidad')?>").val('1');
	                 $('#<?php echo $this->campoSeguro('cantidad')?>').attr('disabled','');

	                 break;
	                
	                case '3':
	                
	                 $("#<?php echo $this->campoSeguro('cantidad')?>").val('1');
	                 $('#<?php echo $this->campoSeguro('cantidad')?>').attr('disabled','');
	                    
	                break;
	                                
	           
	                break;
	                

	                default:
	                 
	                 $("#<?php echo $this->campoSeguro('cantidad')?>").val('');
	                 $('#<?php echo $this->campoSeguro('cantidad')?>').removeAttr('disabled');
	                 
	                break;
	                
	                }
	            
	          });  
	         $('#<?php echo $this->campoSeguro('selecc_registros')?>').width(160);
	         $("#<?php echo $this->campoSeguro('selecc_registros') ?>").select2();



	         
	         
	         
	         
	     	$("#<?php echo $this->campoSeguro('selecc_registros')?>").change(function(){

	     		
	     		if($("#<?php echo $this->campoSeguro('selecc_registros')?>").val()==1){
	     			marcar(this.form);
	     			verificarElementos(this.form);
	     			

	     		}else{

	     			desmarcar(this.form);	 

	     			verificarElementos(this.form);
	     			    			
	     			}

	     	      });




			
	    });
	


</script>
