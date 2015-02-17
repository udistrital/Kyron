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

function limpiar(elem, request, response){
  
	 $("#numeroIdentificacion").autocomplete = "off";
	 $("#seleccionnumerocedula").autocomplete = "off";
	 $("#seleccioncategoria").autocomplete = "off";
	 $("#selecciondocente1").autocomplete = "off";
	 $("#seleccionfacultad").autocomplete = "off";
	 $("#selecciondocente2").autocomplete = "off";
	 $("#seleccionProyectoCurricular").autocomplete = "off";
	 $("#selecciondocente3").autocomplete = "off";
	 $("#seleccioncategoriaT").autocomplete = "off";
	 $("#seleccionfacultadT").autocomplete = "off";
	 $("#seleccionProyectoCurricularT").autocomplete = "off";
	 $("#selecciondocente4").autocomplete = "off";
	 $("#docentesTodos").autocomplete = "off";


			
		};

function filtrar(elem, request, response){

 if  ($("#seleccion").val() == 17){

	 $("#numeroCedula").css('display','block');
	 $("#categoria").css('display','none');
	 $("#facultad").css('display','none');
	 $("#proyectoCurricular").css('display','none');
   	 $("#todosparametros").css('display','none');
   	 
	 }else if  ($("#seleccion").val() == 18){

		 $("#numeroCedula").css('display','none');
		 $("#categoria").css('display','block');
		 $("#facultad").css('display','none');
		 $("#proyectoCurricular").css('display','none');
	   	 $("#todosparametros").css('display','none');
		 
	 }else if  ($("#seleccion").val() == 19){

		 $("#numeroCedula").css('display','none');
		 $("#categoria").css('display','none');
		 $("#facultad").css('display','block');
		 $("#proyectoCurricular").css('display','none');
	   	 $("#todosparametros").css('display','none');
		 
	 }else if  ($("#seleccion").val() == 20){

		 $("#numeroCedula").css('display','none');
		 $("#categoria").css('display','none');
		 $("#facultad").css('display','none');
		 $("#proyectoCurricular").css('display','block');
	   	 $("#todosparametros").css('display','none');

   	}else if  ($("#seleccion").val() == 21){

   	 $("#numeroCedula").css('display','none');
	 $("#categoria").css('display','none');
	 $("#facultad").css('display','none');
	 $("#proyectoCurricular").css('display','none');
   	 $("#todosparametros").css('display','block');
   		
	 }



		
	};


	function consultarNunCedula(elem, request, response){

		      <?php
								$valor = "NumCedula";
								$cadenaFinal = $cadenaACodificar . "&funcion=" . $valor;
								$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
								$estaUrl = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaFinal, $enlace );
								?>
					$.ajax(	{
						url: "<?php echo $estaUrl?>",
						dataType: "json",
						data: {
							numIdentificacion:	$("#numeroIdentificacion").val(),
						},
						success: function(data) { 


							
							 	  
							 if(data !== null )
							 {
								 $("#seleccionnumerocedula").html("");	
							 $.each(data , function(indice,valor){
								  
								
									$("#seleccionnumerocedula").append("<option value='"+valor.informacion_numeroidentificacion+"'>"+valor.nombre+"</option>");


					      });
							 $('#seleccionnumerocedula').removeAttr('disabled');			
							 }else
							 {
								 $("#seleccionnumerocedula").html("<option value='1'>Ingrese Número de Cedula</option>");
								 $('#seleccionnumerocedula').attr('disabled','');	
							 }
							 
					}
						
							 
					});

		};




		function consultarCategoria(elem, request, response){


			  <?php
					$valor = "Categoria";
					$cadenaFinal = $cadenaACodificar . "&funcion=" . $valor;
					$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
					$estaUrl = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaFinal, $enlace );
					?>
							$.ajax(	{
								url: "<?php echo $estaUrl?>",
								dataType: "json",
								data: {
									
									Categoria:	$("#seleccioncategoria").val(),
									
								},
								success: function(data) { 

                           
									
									 	  
									 if(data !== null )
									 {
									 $("#selecciondocente1").html("");	
									 $.each(data , function(indice,valor){
										  
										
											$("#selecciondocente1").append("<option value='"+valor.categoria_iddocente+"'>"+valor.nombre+"</option>");


							      });
									 $('#selecciondocente1').removeAttr('disabled');			
									 }else
									 {
										 $("#selecciondocente1").html("<option value='1'>Seleccione Categoria</option>");
										 $('#selecciondocente1').attr('disabled','');	
									 }
									 
							}
								
									 
							});

			

		};


		function resetFormulario(elem, request, response){
	


			 $("#seleccionnumerocedula").html("");	
			$("<option value='1'>Ingrese Número de Cedula</option>").appendTo("#seleccionnumerocedula");
		    $('#seleccionnumerocedula').attr('disabled','');

		    $("#selecciondocente1").html("");		
			$("<option value='1'>Seleccione Categoria</option>").appendTo("#selecciondocente1");
		    $('#selecciondocente1').attr('disabled','');
		    
		    $("#selecciondocente2").html("");
		    $("<option value='1'>Seleccione Facultad</option>").appendTo("#selecciondocente2");
		    $('#selecciondocente2').attr('disabled','');
		    
		    $("#selecciondocente3").html("");
		    $("<option value='1'>Seleccione Facultad</option>").appendTo("#selecciondocente3");
		    $('#selecciondocente3').attr('disabled','');

		    $("#selecciondocente4").html("");
		    $("<option value='1'>Seleccione Parametros</option>").appendTo("#selecciondocente4");
		    $('#selecciondocente4').attr('disabled','');


			

			
		};
		

		

		function consultarfacultad(elem, request, response){


			  <?php
					$valor = "Facultad";
					$cadenaFinal = $cadenaACodificar . "&funcion=" . $valor;
					$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
					$estaUrl = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaFinal, $enlace );
					?>
							$.ajax(	{
								url: "<?php echo $estaUrl?>",
								dataType: "json",
								data: {
									
									Facultad:	$("#seleccionfacultad").val(),
									
								},
								success: function(data) { 

                           
									
									 	  
									 if(data !== null )
									 {
									 $("#selecciondocente2").html("");	
									 $.each(data , function(indice,valor){
										  
										
											$("#selecciondocente2").append("<option value='"+valor.dependencia_iddocente+"'>"+valor.nombre+"</option>");


							      });
									 $('#selecciondocente2').removeAttr('disabled');			
									 }else
									 {
										 $("#selecciondocente2").html("<option value='1'>Seleccione Facultad</option>");
										 $('#selecciondocente2').attr('disabled','');	
									 }
									 
							}
								
									 
							});

			

		};



		function consultarProyectoCurricular(elem, request, response){


			  <?php
					$valor = "Proyecto Curricular";
					$cadenaFinal = $cadenaACodificar . "&funcion=" . $valor;
					$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
					$estaUrl = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaFinal, $enlace );
					?>
							$.ajax(	{
								url: "<?php echo $estaUrl?>",
								dataType: "json",
								data: {
									
									PrCurricular:	$("#seleccionProyectoCurricular").val(),
									
								},
								success: function(data) { 

                         
									
									 	  
									 if(data !== null )
									 {
									 $("#selecciondocente3").html("");	
									 $.each(data , function(indice,valor){
										  
										
											$("#selecciondocente3").append("<option value='"+valor.dependencia_iddocente+"'>"+valor.nombre+"</option>");


							      });
									 $('#selecciondocente3').removeAttr('disabled');			
									 }else
									 {
										 $("#selecciondocente3").html("<option value='1'>Seleccione Facultad</option>");
										 $('#selecciondocente3').attr('disabled','');	
									 }
									 
							}
								
									 
							});

			

		};


      function seleccionar($OPTION){

    			  <?php
									$valor = "Filtrar Varios";
									$cadenaFinal = $cadenaACodificar . "&funcion=" . $valor;
									$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
									$estaUrl = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaFinal, $enlace );
									?>
						



    	  
			switch ($OPTION){

			case  'CategoriaT|FacultadT|ProyectoT':
			     	$.ajax(	{
					url: "<?php echo $estaUrl?>",
					dataType: "json",
					data: {
						
						CategoriaT:	$("#seleccioncategoriaT").val(),
						FacultadT:$("#seleccionfacultadT").val(),
						ProyectoT:$("#seleccionProyectoCurricularT").val(),
					},
					success: function(data) {
						 
						 if(data !== null ){
						 	$("#selecciondocente4").html("");	
						 	     $.each(data , function(indice,valor){
							    	$("#selecciondocente4").append("<option value='"+valor.id_docente+"'>"+valor.nombre+"</option>");
							      });
						    $('#selecciondocente4').removeAttr('disabled');			
						 }else{
							alert('El Filtro No ha generado Ningun Resultado: Intente Combinando Otros Parametros')


							 
							 $("#selecciondocente4").html("<option value='1'>Seleccione Parametros</option>");
							 $('#selecciondocente4').attr('disabled','');	
						 }
					}		 
				  });

		    break;
					
			case  'CategoriaT|FacultadT':

				$.ajax(	{
					url: "<?php echo $estaUrl?>",
					dataType: "json",
					data: {
						
						CategoriaT:	$("#seleccioncategoriaT").val(),
						FacultadT:$("#seleccionfacultadT").val(),
						
					},
					success: function(data) {
						
						 if(data !== null ){
						 	$("#selecciondocente4").html("");	
						 	     $.each(data , function(indice,valor){
							    	$("#selecciondocente4").append("<option value='"+valor.id_docente+"'>"+valor.nombre+"</option>");
							      });
						    $('#selecciondocente4').removeAttr('disabled');			
						 }else{

							 
							alert('El Filtro No ha generado Ningun Resultado: Intente Combinando Otros Parametros')


							 
							 $("#selecciondocente4").html("<option value='1'>Seleccione Parametros</option>");
							 $('#selecciondocente4').attr('disabled','');	
						 }
					}		 
				  });

				break;
				
			case  'CategoriaT|ProyectoT':

				$.ajax(	{
					url: "<?php echo $estaUrl?>",
					dataType: "json",
					data: {
						
						CategoriaT:	$("#seleccioncategoriaT").val(),
						ProyectoT:$("#seleccionProyectoCurricularT").val(),
						
					},
					success: function(data) {
						
						 if(data !== null ){
						 	$("#selecciondocente4").html("");	
						 	     $.each(data , function(indice,valor){
							    	$("#selecciondocente4").append("<option value='"+valor.id_docente+"'>"+valor.nombre+"</option>");
							      });
						    $('#selecciondocente4').removeAttr('disabled');			
						 }else{

							 
							alert('El Filtro No ha generado Ningun Resultado: Intente Combinando Otros Parametros')


							 
							 $("#selecciondocente4").html("<option value='1'>Seleccione Parametros</option>");
							 $('#selecciondocente4').attr('disabled','');	
						 }
					}		 
				  });


				
				
				break;


			case  'FacultadT|ProyectoT':

				$.ajax(	{
					url: "<?php echo $estaUrl?>",
					dataType: "json",
					data: {
						
						FacultadT:$("#seleccionfacultadT").val(),
						ProyectoT:$("#seleccionProyectoCurricularT").val(),
						
					},
					success: function(data) {
						
						 if(data !== null ){
						 	$("#selecciondocente4").html("");	
						 	     $.each(data , function(indice,valor){
							    	$("#selecciondocente4").append("<option value='"+valor.id_docente+"'>"+valor.nombre+"</option>");
							      });
						    $('#selecciondocente4').removeAttr('disabled');			
						 }else{

							 
							alert('El Filtro No ha generado Ningun Resultado: Intente Combinando Otros Parametros')


							 
							 $("#selecciondocente4").html("<option value='1'>Seleccione Parametros</option>");
							 $('#selecciondocente4').attr('disabled','');	
						 }
					}		 
				  });

				break;
				

			case  'CategoriaT':

     		alert("Debe seleccione más de un parametro");

				break;


						
			case  'FacultadT':

	     		alert("Debe seleccione más de un parametro");
				
				
				break;

				
            case  'ProyectoT':

         		alert("Debe seleccione más de un parametro");
				
				break;





			}







    	  

	

		};


		
		function filtrarGeneral(elem, request, response){



	       if ($("#seleccioncategoriaT").val()!=0){
     
         		           if($("#seleccionfacultadT").val()!=0){

         		                     	 if($("#seleccionProyectoCurricularT").val()!=0){


          			                                   $.tipo = 'CategoriaT|FacultadT|ProyectoT';
                                                       seleccionar ($.tipo);
 
             			                 }else{

             			                                $.tipo = 'CategoriaT|FacultadT';
                                                         seleccionar ($.tipo);


                 		                  	 }


         	            	}else if($("#seleccionProyectoCurricularT").val()!=0){

             			       $.tipo = 'CategoriaT|ProyectoT';
                                seleccionar ($.tipo);

                			}else {

                                $.tipo = 'CategoriaT';
                                seleccionar ($.tipo);

                    		}
                  		

		    }else if($("#seleccionfacultadT").val()!=0){

		    		     if($("#seleccioncategoriaT").val()!=0){
			
        			           						  if($("#seleccionProyectoCurricularT").val()!=0){


         			         								$.tipo = 'CategoriaT|FacultadT|ProyectoT';
                        									seleccionar ($.tipo);

            			 								 }else{

            			   										 $.tipo = 'CategoriaT|FacultadT';
                          											 seleccionar ($.tipo);


                			 								}


        		}else if($("#seleccionProyectoCurricularT").val()!=0){


            			   $.tipo = 'FacultadT|ProyectoT';
                           seleccionar ($.tipo);

               			



            		}else {

                       $.tipo = 'FacultadT';
                       seleccionar ($.tipo);

                		}


		    	



			
			}else if($("#seleccionProyectoCurricularT").val()!=0){



				   if($("#seleccioncategoriaT").val()!=0){

			                  	if($("#seleccionfacultadT").val()!=0){


			         						$.tipo = 'CategoriaT|FacultadT|ProyectoT';
              								seleccionar ($.tipo);

  			  			 		}else{

  										    $.tipo = 'CategoriaT|ProyectoT';
                 							seleccionar ($.tipo);

	
    	  						 }


					}else if($("#seleccionProyectoCurricularT").val()!=0){


  			    			$.tipo = 'FacultadT|ProyectoT';
                 			seleccionar ($.tipo);

  					}else {

         			    $.tipo = 'ProyectoT';
          			    seleccionar ($.tipo);

    				 		}
			
				
			}else {


				 $("#selecciondocente4").html("<option value='1'>Seleccione Parametros</option>");
				 $('#selecciondocente4').attr('disabled','');	




				}




			

		};


		
		
		


</script>