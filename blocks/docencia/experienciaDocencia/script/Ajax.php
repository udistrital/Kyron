<?php
/**
 * Este archivo se utiliza para registrar las funciones javascript que sirven para peticiones AJAX. 
 * Se implementa antes de procesar cualquier bloque al momento de armar la página.
 * 
 * Importante: Si se desean los datos del bloque estos se encuentran en el arreglo $esteBloque
 *
 * El archivo procesarAjax.php (carpeta funcion) tiene la tarea de procesar la peticiones ajax conforme a la variable
 * funcion que se registra en la URL.
 *
 */
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url.=$this->miConfigurador->getVariableConfiguracion("site");
$url.="/index.php?";

$ruta = $this->miConfigurador->getVariableConfiguracion("raizDocumento");
$ruta.="/blocks/" . $esteBloque["grupo"] . "/" . $esteBloque["nombre"] . "/";
$directorioImagenes = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/images";

$urlImagenes = $this->miConfigurador->getVariableConfiguracion("host");
$urlImagenes.=$this->miConfigurador->getVariableConfiguracion("site");
$urlImagenes.="/blocks/" . $esteBloque["grupo"] . "/" . $esteBloque["nombre"] . "/images";;


//Incluir el archivo de idioma
/**
 * @todo Rescatar el valor del idioma desde la sesión. En la actualidad de forma predeterminada se utiliza es_es
 */
include_once($ruta . "/locale/es_es/Mensaje.php");


$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");

//Se debe tener una variable llamada procesarAjax
$cadenaACodificar.="&procesarAjax=true";
$cadenaACodificar.="&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar.="&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar.="&action=index.php";

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