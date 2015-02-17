<?php
if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

$this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");

include_once ($this->ruta . "/script/html2pdf");

ob_start();
?>

<style type="text/css">
    table { 
        color:#333; /* Lighten up font color */
        font-family:Helvetica, Arial, sans-serif; /* Nicer font */

        border-collapse:collapse; border-spacing: 3px; 
    }

    table.page_header {width: 100%; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
    table.page_footer {width: 100%; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}

    td, th { 
        border: 1px solid #CCC; 
        height: 13px;
    } /* Make cells a bit taller */

    th {
        background: #F3F3F3; /* Light grey background */
        font-weight: bold; /* Make sure they're bold */
        text-align: center;
        font-size:10px
    }

    td {
        background: #FAFAFA; /* Lighter grey background */
        text-align: left;
        font-size:10px
    }
</style>
<form method="post" action='index.php' name='<? echo $this->formulario; ?>' >
    <h1>Liquidación Cuota Parte para la Entidad <? echo $datos_basicos['entidad_nombre'] ?> </h1>

    <center>
        <table class='bordered'  width ="68%">
            <thead>
                <tr>
                    <th  class='encabezado_registro' width="15%" colspan="1" rowspan="2">
                        <img alt="Imagen" width="70%" src="<? echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/Images/escudo1.png" />
                    </th>
                    <th  colspan="1" style="font-size:14px;" class='subtitulo_th centrar'>
                        <br>UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS
                        <br> NIT 899999230-7<br><br>
                        Detalle Cuenta de Cobro 
                        <br><? echo $consecu_cc ?><br><br>
                    </th>
                </tr>
                <tr>
                    <th colspan="1" style="font-size:12px;" class='subtitulo_th2'>
                        <?
                        $dias = array("Domingo, ", "Lunes, ", "Martes, ", "Miercoles, ", "Jueves, ", "Viernes, ", "Sábado, ");
                        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                        echo "Bogotá D.C, " . $fecha_cc = $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
                        ?>

                    </th>
                </tr>
            </thead>      

            <tr>
                <td class='texto_elegante estilo_td' >Entidad Concurrente:</td>
                <td class='texto_elegante estilo_td ' colspan='1'><? echo'&nbsp;&nbsp;' . $datos_basicos['entidad_nombre'] ?></td>
            </tr>
            <tr> 
                <td class='texto_elegante estilo_td' >NIT:</td>
                <td class='texto_elegante estilo_td' colspan='1'><? echo '&nbsp;&nbsp;' . $datos_basicos['entidad'] ?></td>
            </tr>
            <tr> 
                <td class='texto_elegante estilo_td' >Fecha Corte Cuenta:</td>
                <td class='texto_elegante estilo_td' colspan="2"><? echo '&nbsp;&nbsp' . $fecha_cobro ?></td>
            </tr>
        </table> </center>
    <br>
    <center>
        <table class='bordered'  width ="60%">
            <tr>
                <td class='texto_elegante estilo_td' >Nombre Pensionado:</td>
                <td class='texto_elegante estilo_td ' colspan='1'><? echo'&nbsp;&nbsp;' . $datos_basicos['nombre_emp'] ?></td>
                <td class='texto_elegante estilo_td' >Documento Pensionado:</td>
                <td class='texto_elegante estilo_td ' colspan='1'><? echo'&nbsp;&nbsp;' . $datos_basicos['cedula'] ?></td>
            </tr>
            <tr>
                <td class='texto_elegante estilo_td' >Nombre Sustituto:</td>
                <td class='texto_elegante estilo_td ' colspan='1'><? echo'&nbsp;&nbsp;' ?></td>
                <td class='texto_elegante estilo_td' >Documento Sustituto:</td>
                <td class='texto_elegante estilo_td ' colspan='1'><? echo'&nbsp;&nbsp;' ?></td>
            </tr>
        </table>
    </center>
    <br>
    <center>
        <table class='bordered'  width ="68%" >
            <tr>
                <th colspan="8" class="subtitulo_th" style="font-size:12px;">DETALLE DE LA LIQUIDACIÓN</th>
            </tr>
            <tr>
                <th class='subtitulo_th centrar'>CICLO</th>
                <th class='subtitulo_th centrar'>MESADA</th>
                <th class='subtitulo_th centrar'>VALOR CUOTA</th>
                <!--th class='subtitulo_th centrar'>AJUSTE PENSION</th-->
                <th class='subtitulo_th centrar'>MESADA AD.</th>
                <th class='subtitulo_th centrar'>INCREMENTO SALUD</th>
                <th class='subtitulo_th centrar'>INTERÉS L_68/1923</th>
                <th class='subtitulo_th centrar'>INTERÉS L_1066/2006</th>
                <th class='subtitulo_th centrar'>TOTAL MES</th>
            </tr>
            <tbody id="itemContainer">
                <?
                if (is_array($liquidacion)) {
                foreach ($liquidacion as $key => $value) {

                echo "<tr>";
                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>" . date('Y-m', strtotime(str_replace('/', '-', $liquidacion[$key]['fecha']))) . "</td>";
                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($liquidacion[$key]['mesada']) . "</td>";
                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($liquidacion[$key]['cuota_parte']) . "</td>";
                //echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;' >" . $liquidacion[$key]['ajuste_pension'] . "</td>";
                echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'>" . number_format($liquidacion[$key]['mesada_adc']) . "</td>";
                echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'>" . number_format($liquidacion[$key]['incremento']) . "</td>";
                echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'>$ " . number_format($liquidacion[$key]['interes_a2006']) . "</td>";
                echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'>$ " . number_format($liquidacion[$key]['interes_d2006']) . "</td > ";
                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($liquidacion[$key]['total']) . "</td>";
                echo "</tr>";
                }
                } else {
                echo "<tr>";
                echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                //echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                echo "</tr>";
                }
                ?>
        </table>
        <center><div class="holder" style="-moz-user-select: none;"></div></center>
    </center>
    <br>
    <center>
        <table class='bordered'  width ="68%" >
            <tr>
                <th colspan="9" class="subtitulo_th" style="font-size:12px;">PARCIALES LIQUIDACIÓN</th>
            </tr>
            <tr>
                <th class='encabezado_registro' width="12%" rowspan="2">TOTAL</th>
                <!--th class='subtitulo_th centrar'>AJUSTE PENSION</th-->
                <th class='subtitulo_th centrar'>VALOR CUOTA</th>
                <th class='subtitulo_th centrar'>MESADA AD.</th>
                <th class='subtitulo_th centrar'>INCREMENTO SALUD</th>
                <th class='subtitulo_th centrar'>INTERES LEY 68/1923</th>
                <th class='subtitulo_th centrar'>INTERES LEY 1066/2006</th>
                <th class='subtitulo_th centrar'>ACUMULADO INTERES</th>
            </tr>
            <?
            if (is_array($totales_liquidacion)) {

            foreach ($totales_liquidacion as $key => $values) {

            echo "<tr>";
            //echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_ajustepen']) . "</td>";
            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_cuotap']) . "</td>";
            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_mesada_ad']) . "</td>";
            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_incremento']) . "</td>";
            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_interes_a2006']) . "</td>";
            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_interes_d2006']) . "</td>";
            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_interes']) . "</td>";
            echo "</tr>";
            $total[$key] = $totales_liquidacion[$key]['liq_total'];
            }
            } else {
            echo "<tr>";
            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
            echo "</tr>";
            }
            ?>
            <tr>
                <th class='subtitulo_th2' colspan="1">TOTAL&nbsp;&nbsp;</th>
                <td class='texto_elegante estilo_td3' colspan="8" style='text-align:center'><? echo " $ " . number_format($total[0]) ?></td>
            </tr>
        </table>
    </center>

    <br><br>
    <center>
        <table class='bordered'  width ="20%" >
            <tr>
                <th colspan="3" class="subtitulo_th" style="font-size:12px;">AJUSTES ANUALES PENSIÓN APLICADOS (Ley 4a/76, Ley 71/88 y Ley 100 de 1993)</th>
            </tr>
            <tr>
                <th class='subtitulo_th centrar'>VIGENCIA</th>
                <th class = 'subtitulo_th centrar'>PORCENTAJE (IPC)</th>
                <th class = 'subtitulo_th centrar'>SUMAFIJA</th>
            </tr>
            <tbody id="itemContainer2">
                <?
                foreach ($detalle_indice as $key => $values) {
                echo "<tr>";
                echo " <td class='texto_elegante estilo_td' style='text-align:center;'>" . $detalle_indice[$key]['vigencia'] . "</td> ";
                echo " <td class='texto_elegante estilo_td' style='text-align:center;'>" . $detalle_indice[$key]['ipc'] . "</td> ";
                echo " <td class='texto_elegante estilo_td' style='text-align:center;'>" . $detalle_indice[$key]['suma_fija'] . "</td> ";
                echo "</tr>";
                }
                ?>
        </table>
        <center><div class="holder2" style="-moz-user-select: none;"></div></center>
    </center>
    <br><br>
    <center>
        <table class = 'bordered' width = "60%">
            <tr>
                <td class = 'estilo_td' align = justify style = "font-size:12px" colspan = "9">
                    <br><br><br><br>
                </td>
            </tr>
            <tr>
                <td class = 'estilo_td' align = center style = "font-size:12px" colspan = "9">
                    <? echo $jefeRecursos[0][0] ?>
                    <br>Jefe(a) División de Recursos Humanos
                </td>
            </tr>
        </table>
        <p style="font-size:9px">Diseño forma: JUAN D. CALDERON MARTIN.
            <br><br><br><br><br>
        <p>______________________________________________________________________________
        <p style="font-size:12px">UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS
        <p style="font-size:12px">Carrera 7 40-53 PBX: 323 93 00, Ext. 1618 - 1603.
    </center>

    <br><br><br>
    <div>
        <div class="null"></div>
        <input id="generarBoton" type="submit" class="navbtn" value="Generar PDF">
        <input type='hidden' name='no_pagina' value="liquidadorCP">
        <input type='hidden' name='opcion' value='pdf_detalle'>
        <input type="hidden" name='datos_basicos' value='<?php echo serialize($datos_basicos) ?>'>
        <input type="hidden" name='totales_liquidacion' value='<?php echo serialize($totales_liquidacion) ?>'>
        <input type="hidden" name='detalle_indice' value='<?php echo serialize($detalle_indice) ?>'>
        <input type="hidden" name='liquidacion' value='<?php echo serialize($liquidacion) ?>'>
        <input type="hidden" name='consecutivo' value='<?php echo $consecu_cc ?>'>
        <input type="hidden" name='fecha_cobro' value='<?php echo $fecha_cobro ?>'>
        <input type="hidden" name='jRecursos' value='<?php echo $jefeRecursos[0][0] ?>'>
    </div>
</form>
