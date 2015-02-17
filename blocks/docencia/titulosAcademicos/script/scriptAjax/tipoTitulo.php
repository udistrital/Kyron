<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$valor = "#tipo_titulo";
$cadenaFinal = $cadenaACodificar . "&funcion=" . $valor;
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$estaUrl = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaFinal, $enlace);
?>
<script type='text/javascript'>

    function validarTitulos(){
            $.ajax({
		url: "<?php echo $estaUrl?>",
		dataType: "html",
		data: {
                        docente: $("#identificacionFinalCrear").val(),
                        tipoTitulo: $("#tipo_titulo").val()
		},
                success: function(respuesta) {
                        
                        switch(respuesta)
                        {
                            //Validaciones Pregrado
                            // Registrar el primer pregrado
                            case 'registrar_1Pre':
                                alert("Se debe registrar al menos un pregrado para registrar otros títulos");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[178]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("1");
                                $("#tipo_titulo").select2("val", "1");
                                
                                break;
                                
                            //Registrar el segundo pregrado    
                            case 'registrar_2Pre':
                                alert("Este será el segundo pregrado del docente seleccionado");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[178]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("1");
                                $("#tipo_titulo").select2("val", "1");
                                
                                break;
                                
                            //Registrar mas de 2 pregrados    
                            case 'registrar_MasPre':
                                alert("El docente ya tiene registrado 2 o más pregrados, por lo tanto no se puede dar puntaje a un nuevo pregrado");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all ");
                                $("#puntaje").attr("disabled", true);
                                $("#puntaje").attr("size", "50");
                                $("#puntaje").val("No se puede dar puntaje a más de 2 pregrados");
                                $("#tipo_titulo").val("1");
                                $("#tipo_titulo").select2("val", "1");
                                
                                break;
                                
                                
                            //Validaciones Especializacion
                            // Registrar el primer especializacion
                            case 'registrar_1Esp':
                                alert("El docente no tiene registrado especializaciones");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[20]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("2");
                                $("#tipo_titulo").select2("val", "2");
                                
                                break;
                                
                            //Registrar el segundo especializacion    
                            case 'registrar_2Esp':
                                alert("Este será la segunda especialización del docente seleccionado");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[10]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("2");
                                $("#tipo_titulo").select2("val", "2");
                                
                                break;
                                
                            //Registrar mas de 2 especializacion    
                            case 'registrar_MasEsp':
                                alert("El docente ya tiene registrado 2 o más especializaciones, por lo tanto no se puede dar puntaje a una nueva especialización");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all ");
                                $("#puntaje").attr("disabled", true);
                                $("#puntaje").attr("size", "50");
                                $("#puntaje").val("No se puede dar puntaje a más de 2 especializaciones");
                                
                                break;
                                
                            //Validaciones Maestria
                            // Registrar el primer Maestria
                            case 'registrar_1Mae':
                                alert("El docente no tiene registrado maestrías");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[40]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("3");
                                $("#tipo_titulo").select2("val", "3");
                                
                                break;
                                
                            //Registrar el segundo Maestria    
                            case 'registrar_2Mae':
                                alert("Este será la segunda maestría del docente seleccionado");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[20]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("3");
                                $("#tipo_titulo").select2("val", "3");
                                
                                break;
                                
                            //Registrar mas de 2 Maestria    
                            case 'registrar_MasMae':
                                alert("El docente ya tiene registrado 2 o más maestrías, por lo tanto no se puede dar puntaje a una nueva maestría");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all ");
                                $("#puntaje").attr("disabled", true);
                                $("#puntaje").attr("size", "50");
                                $("#puntaje").val("No se puede dar puntaje a más de 2 maestrias");
                                
                                break;    
                                
                                
                            //Validaciones Doctorado
                            // Registrar el primer Doctorado
                            case 'registrar_1Doc':
                                alert("El docente no tiene registrado doctorados");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[80]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("4");
                                $("#tipo_titulo").select2("val", "4");
                                
                                break;
                                
                            // Registrar el primer Doctorado
                            case 'registrar_1DocSinMae':
                                alert("El docente no tiene registrado doctorados ni maestrías");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[120]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("4");
                                $("#tipo_titulo").select2("val", "4");
                                break;
                                
                            //Registrar el segundo Doctorado    
                            case 'registrar_2Doc':
                                alert("Este será el segundo doctorado del docente seleccionado");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[40]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("4");
                                $("#tipo_titulo").select2("val", "4");
                                
                                break;
                                
                            //Registrar mas de 2 Doctorado    
                            case 'registrar_MasDoc':
                                alert("El docente ya tiene registrado 2 o más doctorados, por lo tanto no se puede dar puntaje a un nuevo doctorado");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all ");
                                $("#puntaje").attr("disabled", true);
                                $("#puntaje").attr("size", "50");
                                $("#puntaje").val("No se puede dar puntaje a más de 2 doctorados");
                                
                                break;    
                                
                            
                        }
                }
			 
            });
            }
  <?php          
       
$valor = "#tipo_tituloModificar";
$cadenaFinal = $cadenaACodificar . "&funcion=" . $valor;
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$estaUrl = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaFinal, $enlace);
?>
            
function validarTitulosModificar(){
            $.ajax({
		url: "<?php echo $estaUrl?>",
		dataType: "html",
		data: {
                        docente: $("#id_docente").val(),
                        tipoTitulo: $("#tipo_titulo").val(),
                        tipoTituloActual: $("#tipo_tituloActual").val()
		},
                success: function(respuesta) {
                        
                        switch(respuesta)
                        {
                            //Validaciones Pregrado
                            // Registrar el primer pregrado
                            case 'nomodifica_1Pre':         
                                alert("No puede cambiar el tipo de titulo ya que es el único pregrado registrado");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[178]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("1");
                                $("#tipo_titulo").select2("val", "1");
                                
                                break;
                                
                            case 'registrar_1Pre':         
                                alert("Se debe registrar al menos un pregrado para registrar otros títulos");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[178]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("1");
                                $("#tipo_titulo").select2("val", "1");
                                
                                break;
                                
                            //Registrar el segundo pregrado    
                            case 'registrar_2Pre':
                                alert("Este será el segundo pregrado del docente seleccionado");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[178]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("1");
                                $("#tipo_titulo").select2("val", "1");
                                
                                break;
                                
                            //Registrar mas de 2 pregrados    
                            case 'registrar_MasPre':
                                alert("El docente ya tiene registrado 2 o más pregrados, por lo tanto no se puede dar puntaje a un nuevo pregrado");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all ");
                                $("#puntaje").attr("disabled", true);
                                $("#puntaje").attr("size", "50");
                                $("#puntaje").val("No se puede dar puntaje a más de 2 pregrados");
                                $("#tipo_titulo").val("1");
                                $("#tipo_titulo").select2("val", "1");
                                
                                break;
                                
                                
                            //Validaciones Especializacion
                            // Registrar el primer especializacion
                            case 'registrar_1Esp':
                                alert("El docente no tiene registrado especializaciones");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[20]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("2");
                                $("#tipo_titulo").select2("val", "2");
                                
                                break;
                                
                            //Registrar el segundo especializacion    
                            case 'registrar_2Esp':
                                alert("Este será la segunda especialización del docente seleccionado");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[10]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("2");
                                $("#tipo_titulo").select2("val", "2");
                                
                                break;
                                
                            //Registrar mas de 2 especializacion    
                            case 'registrar_MasEsp':
                                alert("El docente ya tiene registrado 2 o más especializaciones, por lo tanto no se puede dar puntaje a una nueva especialización");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all ");
                                $("#puntaje").attr("disabled", true);
                                $("#puntaje").attr("size", "50");
                                $("#puntaje").val("No se puede dar puntaje a más de 2 especializaciones");
                                
                                break;
                                
                            //Validaciones Maestria
                            // Registrar el primer Maestria
                            case 'registrar_1Mae':
                                alert("El docente no tiene registrado maestrías");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[40]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("3");
                                $("#tipo_titulo").select2("val", "3");
                                
                                break;
                                
                            //Registrar el segundo Maestria    
                            case 'registrar_2Mae':
                                alert("Este será la segunda maestría del docente seleccionado");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[20]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("3");
                                $("#tipo_titulo").select2("val", "3");
                                
                                break;
                                
                            //Registrar mas de 2 Maestria    
                            case 'registrar_MasMae':
                                alert("El docente ya tiene registrado 2 o más maestrías, por lo tanto no se puede dar puntaje a una nueva maestría");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all ");
                                $("#puntaje").attr("disabled", true);
                                $("#puntaje").attr("size", "50");
                                $("#puntaje").val("No se puede dar puntaje a más de 2 maestrias");
                                
                                break;    
                                
                                
                            //Validaciones Doctorado
                            // Registrar el primer Doctorado
                            case 'registrar_1Doc':
                                alert("El docente no tiene registrado doctorados");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[80]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("4");
                                $("#tipo_titulo").select2("val", "4");
                                
                                break;
                                
                            // Registrar el primer Doctorado
                            case 'registrar_1DocSinMae':
                                alert("El docente no tiene registrado doctorados ni maestrías");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[120]]");
                                $("#puntaje").attr("size", "5");
                                $("#tipo_titulo").val("4");
                                $("#tipo_titulo").select2("val", "4");
                                break;
                                
                            //Registrar el segundo Doctorado    
                            case 'registrar_2Doc':
                                alert("Este será el segundo doctorado del docente seleccionado");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[40]]");
                                $("#puntaje").attr("size", "5");
                                $("#puntaje").attr("disabled", false);
                                $("#tipo_titulo").val("4");
                                $("#tipo_titulo").select2("val", "4");
                                
                                break;
                                
                            //Registrar mas de 2 Doctorado    
                            case 'registrar_MasDoc':
                                alert("El docente ya tiene registrado 2 o más doctorados, por lo tanto no se puede dar puntaje a un nuevo doctorado");
                                $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all ");
                                $("#puntaje").attr("disabled", true);
                                $("#puntaje").attr("size", "50");
                                $("#puntaje").val("No se puede dar puntaje a más de 2 doctorados");
                                
                                break;    
                                
                        }
                }
			 
            });
            }
    
</script>
<?php

$campo = array("#docenteid","#docente");
?>
<script type='text/javascript'>
<?php
foreach ($campo as $valor) {

    $cadenaFinal = $cadenaACodificar . "&funcion=" . $valor;
    $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
    $laurl = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaFinal, $enlace);
    ?>

        $(function() {
            $("<?php echo $valor ?>").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "<?php echo $laurl ?>",
                        dataType: "json",
                        data: {
                            featureClass: "P",
                            style: "full",
                            maxRows: 12,
                            name_startsWith: request.term
                        },
                        success: function(data) {
                            response($.map(data, function(item, i) {
                                return item;
                            }));
                        }
                    });
                },
                minLength: 3,
                autofocus: true,
                open: function() {
                    $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                },
                close: function() {
                    $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                },
                select: function(event, ui) {
                    event.preventDefault();
                    <?php
                    if($valor == "#docenteid")
                    {
                        ?>
                            $("#identificacionFinalConsulta").val(ui.item.value);
                            $("<?php echo $valor  ?>").val(ui.item.label);
                        <?php
                    }else if($valor == "#docente")
                        {
                        ?>
                            $("#identificacionFinalCrear").val(ui.item.value);
                            $("<?php echo $valor  ?>").val(ui.item.label);
                        <?php
                        }
                    ?>
                    
                     
                },
                focus: function(event, ui) {
                    event.preventDefault();
                    $("<?php echo $valor ?>").val(ui.item.label);
                }


            });
        });

    <?php
}

    $valor = "#facultad";

    $cadenaFinal = $cadenaACodificar . "&funcion=" . $valor;
    $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
    $laurl = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaFinal, $enlace);
    ?>

        $(function() {
                
                $("<?php echo $valor ?>").change(function () {
                        $("<?php echo $valor ?> option:selected").each(function () {
                         facul=$(this).val();
                         $.post("<?php echo $laurl ?>", { facultad: facul }, function(data){
                         $("#proyecto").html(data);
                         });            
                     });
                })
        });

    <?php
?>
</script>