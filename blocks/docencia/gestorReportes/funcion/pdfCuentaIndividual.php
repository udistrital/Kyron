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


$ContenidoPdf = "
<style type=\"text/css\">
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
<page backtop='60mm' backbottom='20mm' backleft='30mm' backright='3mm' pagegroup='new'>
<page_header>
    <table align='right'>
        <thead>
            <tr>
                <th style=\"width:10px;\" colspan=\"1\">
                    <img alt=\"Imagen\" src=" . $this->ruta . "/images/ud.png" . "/nomina/cuotas_partes/Images/escudo1.png\" />
                </th>
                <th style=\"width:420px;font-size:13px;\" colspan=\"1\">
                    <br>UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS
                    <br> NIT 899999230-7<br>
                    <br> DIVISIÓN DE RECURSOS HUMANOS<br><br>
                </th>
                <th style=\"width:130px;font-size:10px;\" colspan=\"1\">
                    <br>CUENTA DE COBRO
                    <br>No." . $consecutivo . "<br>
                    <br>" . $fecha_cc . "<br><br>
                </th>
            </tr>
        </thead>               <tr>
                        <td>Entidad Concurrente:</td>
                        <td colspan='2'>" . '&nbsp;&nbsp;' . $datos_basicos['entidad_nombre'] . "</td>
                    </tr>
                    <tr> 
                        <td>NIT:</td>
                        <td   colspan='2'>" . '&nbsp;&nbsp;' . $datos_basicos['entidad'] . "</td>
                    </tr>
                    <tr> 
                        <td>Fecha Vencimiento Cuenta:</td>
                        <td   colspan=\"2\">&nbsp;&nbsp; 30 días calendario a partir de la fecha de recibido</td>
                    </tr>
    </table>  
    <br>
     <table align='right'>
                    <tr>
                        <td>Nombre Pensionado:</td>
                        <td style=\"width:309px;\">" . '&nbsp;&nbsp;' . $datos_basicos['nombre_emp'] . "</td>
                        <td>Documento Pensionado:</td>
                        <td style=\"width:150px;\">" . '&nbsp;&nbsp;' . $datos_basicos['cedula'] . "</td>
                    </tr>
                    <tr>
                        <td>Nombre Sustituto:</td>
                        <td style=\"width:309px;\"></td>
                        <td>Documento Sustituto:</td>
                        <td style=\"width:150px;\" ></td>
                    </tr>
                </table>
</page_header>

<page_footer>
    <table align='center' width='100%'>
        <tr>
            <td align='center' style=\"width: 750px;\">
                Universidad Distrital Francisco José de Caldas
                <br>
                Todos los derechos reservados.
                <br>
                Carrera 8 N. 40-78 Piso 1 / PBX 3238400 - 3239300, Ext. 1618 - 1603
                <br>

            </td>
        </tr>
    </table>
     <p style=\"font-size:7px\">Diseño forma: JUAN D. CALDERON MARTIN</p>
        <p style='text-align: right; font-size:10px;'>[[page_cu]]/[[page_nb]]</p>
</page_footer> 


<table align='right'>
                    <tr>
                        <th>Item</th>
                        <th>Descripción</th>
                        <th>DESDE</th>
                        <th>HASTA</th>
                        <th>Valor</th>
                    </tr>
                    <tr>
                        <td style=\"text-align:center;\">1</td>
                        <td >Cuotas Partes Pensionales (mesadas ordinarias y adicionales)</td>
                        <td style=\"text-align:center;\">" . '&nbsp;&nbsp;' . $totales_liquidacion[0]['liq_fdesde'] . "</td>
                        <td style=\"text-align:center;\">" . '&nbsp;&nbsp;' . $totales_liquidacion[0]['liq_fhasta'] . "</td>
                        <td>" . '&nbsp;$&nbsp;' . number_format($totales_liquidacion[0]['liq_cuotap'] + $totales_liquidacion[0]['liq_mesada_ad']) . "</td>
                    </tr>
                    <tr>
                        <td style=\"text-align:center;\">2</td>
                        <td>Incremento en Cotización Salud</td>
                        <td style=\"text-align:center;\">" . '&nbsp;&nbsp;' . $totales_liquidacion[0]['liq_fdesde'] . "</td>
                        <td style=\"text-align:center;\">" . '&nbsp;&nbsp;' . $totales_liquidacion[0]['liq_fhasta'] . "</td>
                        <td>" . '&nbsp;$&nbsp;' . number_format($totales_liquidacion[0]['liq_incremento']) . "</td>
                    </tr>
                    <tr>
                        <td style=\"text-align:center;\">3</td>
                        <td>Valor Intereses Ley 68/1923</td>
                        <td style=\"text-align:center;\">" . '&nbsp;&nbsp;' . $totales_liquidacion[0]['liq_fdesde'] . "</td>
                        <td style=\"text-align:center;\">" . '&nbsp;&nbsp;' . $totales_liquidacion[0]['liq_fhasta'] . "</td>
                        <td>" . '&nbsp;$&nbsp;' . number_format($totales_liquidacion[0]['liq_interes_a2006']) . "</td>
                    </tr>
                     <tr>
                        <td style=\"text-align:center;\">4</td>
                        <td>Valor Intereses Ley 1066/2006</td>
                        <td style=\"text-align:center;\">" . '&nbsp;&nbsp;' . $totales_liquidacion[0]['liq_fdesde'] . "</td>
                        <td style=\"text-align:center;\">" . '&nbsp;&nbsp;' . $totales_liquidacion[0]['liq_fhasta'] . "</td>
                        <td>" . '&nbsp;$&nbsp;' . number_format($totales_liquidacion[0]['liq_interes_d2006']) . "</td>
                    </tr>
          
             <tr>
                        <th   style=\"text-align:right;\" colspan=\"4\">TOTAL&nbsp;&nbsp;</th>
                        <td >" . '&nbsp;$&nbsp;' . number_format($totales_liquidacion[0]['liq_total']) . "</td>
            </tr>
            <tr>
            <td style=\"width:675px;text-align:center;\" colspan=\"45\">SON&nbsp;" . $enletras . "</td>
            </tr>
            </table><br>             
            <table align='right'>
                    <tr>
                        <td   align:justify style=\"font-size:12px;width:300px;\" colspan=\"2\">
                            El (La) Jefe de la División de Recursos Humanos y la (el) Tesorero (a) de 
                            la UNIVERSIDAD DISTRITAL FRANCISCO JOSE DE CALDAS, certifican que  la persona 
                            por quien se realiza este cobro se encuentra incluida en nomina  de pensionados y se le ha pagado las mesadas cobradas.
                            La supervivencia fue verificada de conformidad con el articulo 21 del Decreto 19 de 2012.</td>
                    </tr>
                    <tr>
                        <td   align=justify style=\"font-size:12px;width:300px;text-align:justify;\" colspan=\"2\">
                            La suma adeudada debe ser consignada (en efectivo, cheque de gerencia o transferencia electronica) en la Cuenta 
                            de Ahorros No 251–80660–0 del Banco de Occcidente, a nombre del FONDO DE PENSIONES UNIVERSIDAD DISTRITAL y remitir 
                            copia de la misma a la carrera 7 Nº 40-53, piso 6, Division de Recursos Humanos y al correo electronico rechumanos@udistrital.edu.co.
                            <br><br>
                            En caso de haber pagado parcial o totalmente esta cuenta, favor descontar el valor de dicho abono (s) del presente 
                            cobro y remitir el (los) comprobante (s) del (los) pago (s) realizado (s).</td>
                    </tr>
                    <tr>
                        <td   align=justify style=\"font-size:12px;\" >
                            <br><br><br><br>
                        </td>
                        <td   align=justify style=\"font-size:12px;\">
                            <br><br><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td   align=center style=\"width:332px;text-align:center;\">
        " . $jefeTesoreria . "
                            <br>Tesorero(a)
                        </td>
                        <td   align=center style=\"width:332px;text-align:center;\">
        " . $jefeRecursos . "
                            <br>Jefe(a) División de Recursos Humanos
                        </td>
                    </tr>
                </table>

</page>
              

";



$PDF = new HTML2PDF('P', 'Letter', 'es', true, 'UTF-8', 3);
$PDF->pdf->SetDisplayMode('fullpage');
$PDF->writeHTML($ContenidoPdf);
clearstatcache();
$PDF->Output("CuentadeCobro_" . $datos_basicos['cedula'] . "_" . $datos_basicos['entidad_nombre'] . ".pdf", "D");

