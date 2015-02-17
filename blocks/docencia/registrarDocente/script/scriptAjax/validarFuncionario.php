<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->miConfigurador = Configurador::singleton ();
$miSesion = Sesion::singleton ();
	
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

$wsPersonas = $this->miConfigurador->getVariableConfiguracion("wsPersonas");

?>
<script type='text/javascript'>

    function validarFuncionario(){
        
        var wsUrl = "<?php echo $wsPersonas?>";
        
        var tipoDocumento = $("#tipoDocumento").val();
        var identificacionDocente = $("#identificacionDocente").val();
        //var codigoInterno = $("#codigoInterno").val();
        var codigoInterno = '';

        var soapRequest ="<soapenv:Envelope xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema'"; 
            soapRequest += " xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/' xmlns:con='"+ wsUrl +"'> ";
            soapRequest += " <soapenv:Header/> ";
            soapRequest += " <soapenv:Body> ";
            soapRequest += " <con:consultarPersona soapenv:encodingStyle='http://schemas.xmlsoap.org/soap/encoding/'> ";
            soapRequest += " <tipo_identificacion xsi:type='xsd:string'>" + tipoDocumento + "</tipo_identificacion> ";
            soapRequest += " <nume_identificacion xsi:type='xsd:string'>" + identificacionDocente + "</nume_identificacion> ";
            soapRequest += " <codi_interno xsi:type='xsd:string'></codi_interno> ";
            soapRequest += " </con:consultarPersona> ";
            soapRequest += " </soapenv:Body> ";
            soapRequest += " </soapenv:Envelope>"; 
        
         $.ajax({
                type: "post",
                url: wsUrl,
                contentType: "text/xml",
                dataType: "xml",
                data: soapRequest,
                success: function( response ){
                            // Get a jQuery-ized version of the response.
                            var xml = $( response );
                            
                            var error = xml.find( "error" ).text();
                            var convError = parseInt(error);

                            var codigo = $( "#codigo" );
                            var nombre = $( "#nombre" );
                            var apellido = $( "#apellido" );
                            var fecha_nac = $( "#fecha_nac" );
                            var direccion = $( "#direccion" );
                            var telefono = $( "#telefono" );
                            var celular = $( "#celular" );
                            var correo = $( "#correo" );
                            var ciudad = $( "#ciudad" );
                            var sexo = $( "#sexo" );
                            var estado_civil = $( "#estado_civil" );

                            if(convError <= 0)
                            {
                                codigo.val(xml.find( "codigo_interno" ).text());
                                nombre.val(xml.find( "primer_nombre" ).text() + " " + xml.find( "segundo_nombre" ).text());
                                apellido.val(xml.find( "primer_apellido" ).text() + " " + xml.find( "segundo_apellido" ).text());
                                fecha_nac.val(xml.find( "fecha_nacimiento" ).text());
                                direccion.val(xml.find( "direccion" ).text());
                                telefono.val(xml.find( "telefono" ).text());
                                celular.val(xml.find( "celular" ).text());
                                correo.val(xml.find( "correo" ).text());
                                ciudad.val(xml.find( "ciudad" ).text());
                                sexo.val(xml.find( "sexo" ).text());
                                estado_civil.val(xml.find( "estado_civil" ).text());

                                $("#infoFuncionario").css("display","block");
                                $("#errorWs").css("display","none");
                            }else
                                {
                                    $("#infoFuncionario").css("display","none");
                                    var errorCampo = $( "#errorCampo" );
                                    $("#errorWs").css("display","block");
                                    $("#errorCampo").css("display","block");
                                    errorCampo.text(xml.find( "descripcionError" ).text());
                                    
                                    codigo.val('');
                                    nombre.val('');
                                    fecha_nac.val('');
                                    direccion.val('');
                                    telefono.val('');
                                    celular.val('');
                                    correo.val('');
                                    ciudad.val('');
                                    sexo.val('');
                                    estado_civil.val('');
                                    
                                }

                            
                            
                        }
            });

        return false;
        }

  
</script>