<?php

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}
date_default_timezone_set('America/Bogota');
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

$this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");

include_once ($this->ruta . "/script/html2pdf/html2pdf.class.php");

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$arreglo = $_REQUEST['identificacion'];

$subtotal_salarial;
$subtotal_bono;
$total_puntos;

//1
$cadena_sql_1 = $this->sql->cadena_sql("datosDocente", $arreglo);
$datosDocente = $esteRecursoDB->ejecutarAcceso($cadena_sql_1, "busqueda");
//2
$cadena_sql_2 = $this->sql->cadena_sql("codigo_docente", $arreglo);
$codigo_interno = $esteRecursoDB->ejecutarAcceso($cadena_sql_2, "busqueda");

$consultas = array(
    "datosTitulos",
    "datosExcInvestigacion",
    "datosExcDireccion",
    "datosExcCalificada",
    "datosExcProfesional",
    "datosExcAcademica",
    "datosProAcademica",
    "datosComCorta",
    "datosCartas",
    "datosPrVideos",
    "datosLibInvestigacion",
    "datosLibTexto",
    "datosLibEnsayo",
    "datosPremios",
    "datosPatentes",
    "datosTraduccionLibro",
    "datosObArtSalOriginal",
    "datosObArtSalComple",
    "datosProTecnicaIn",
    "datosProTecnicaAd",
    "datosProSoftware",
    "datosProVideosCine",
    "datosPonencias",
    "datosPubUniver",
    "datosEstudioPosD",
    "datosReseña",
    "datosTraducciones",
    "datosObArtSalOrigBon",
    "datosObArtSalCompBon",
    "datosInterpretacion",
    "datosDireccionTrab"
);

$contenido_consultas = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
$puntaje = 0;
$acumulado = 0;
$a = array();

foreach ($consultas as $key => $values) {
    $puntaje = 0;
    $cadena_sql = $this->sql->cadena_sql($consultas[$key], $arreglo);
    $datos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

    if (is_array($datos)) {
        foreach ($datos as $nodo => $fila) {
            $contenido_consultas[$key].= '<tr>';
            foreach ($fila as $columna => $valor) {
                if (is_numeric($columna)) {
                    $contenido_consultas[$key].= "<td>" . wordwrap($valor, 30, "<br>", TRUE) . "</td> ";
                }
            }
            $acumulado = $datos[$nodo]['puntaje'] + $acumulado;
            $puntaje = $datos[$nodo]['puntaje'] + $puntaje;
            $contenido_consultas[$key].= '</tr>';
        }
        $a[$key] = $puntaje;
    } else {
        $contenido_consultas[$key].= '';
        $acumulado = 0 + $acumulado;
        $puntaje = 0 + $puntaje;

        $a[$key] = $puntaje;
    }
}

$bonificacion = round($a[21] + $a[22] + $a[23] + $a[24] + $a[25] + $a[26] + $a[27] + $a[28] + $a[29], 3);
$salarial = round($acumulado, 3) - $bonificacion;
$acumulado = round($acumulado, 3);

$fecha = date('d/m/Y');


ob_start();

$ContenidoPdf = "
<style type=\"text/css\">
    table { 
        color:#333; /* Lighten up font color */
        font-family:Helvetica, Arial, sans-serif; /* Nicer font */
        border-collapse:collapse; 
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
        font-size:8px
    }

    td {
        background: #FAFAFA; /* Lighter grey background */
        text-align: left;
        font-size:9px
    }
</style>
<page backtop='5mm' backbottom='10mm' backleft='10mm' backright='10mm' pagegroup='new'>

<page_footer>
        <p style='text-align: left; font-size:7px;'>Fecha Generación: " . $fecha . "</p><p style='text-align: right; font-size:10px;'>[[page_cu]]/[[page_nb]]</p>
</page_footer> 

        <table>
            <thead>
                <tr>
                    <th style=\"width:10px;word-warp:break-word\" colspan='1' rowspan='2'>
                        <img src='" . $rutaBloque . "/images/ud.jpg'>
                    </th>
                    <th style=\"width:650px;font-size:13px;\" colspan=\"5\">
                        <br>UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS
                        <br> NIT 899999230-7<br><br>
                        Oficina de Docencia<br><br>
                        ESTADO DE CUENTA INDIVIDUAL
                        <br><br>
                    </th>
                </tr>
                <tr>
                    <th colspan='5' style='font-size:10px;'></th>
                </tr>
            </thead>      
            <tr>
                <th colspan='6' style='font-size:10px;'>INFORMACIÓN GENERAL DEL DOCENTE</th>
            </tr>
            <tr>
                <td >Nombre Docente</td>
                <td  colspan='1'>" . $datosDocente[0]['informacion_nombres'] . " " . $datosDocente[0]['informacion_apellidos'] . "</td>
                <td >Documento</td>
                <td  colspan='1'>" . $datosDocente[0]['dependencia_iddocente'] . "</td>
                <td >Código</td>
                <td  colspan='1'>" . $codigo_interno[0][0] . "</td>
            </tr>
            <tr> 
                <td  >Proyecto</td>
                <td  colspan='3'>" . $datosDocente[0]['nombre_proyecto'] . "</td>
                <td  >Facultad</td>
                <td  colspan='1'>" . $datosDocente[0]['nombre_facultad'] . "</td>
            </tr>
            <tr> 
                <td  >Fecha de Vinculación</td>
                <td  colspan='5'>" . $datosDocente[0]['vinculacion_fechaingreso'] . "</td>
            </tr>
            <tr> 
                <td>Estado</td>
                <td  colspan='5'>" . $datosDocente[0]['estado'] . "</td>
            </tr>
        </table> 
    <br>

     <table align='left'>
                <tr>
                    <th style=\"width:685px;text-align:right;\">TOTAL PUNTOS SALARIALES</th>
                    <td style=\"width:44px;\">" . $salarial . "</td>
                 </tr>
                   <tr>
                    <th style=\"width:685px;text-align:right;\">TOTAL PUNTOS BONIFICACIÓN</th>
                    <td style=\"width:44px;\">" . $bonificacion . "</td>
                 </tr>
                   <tr>
                    <th style=\"width:685px;text-align:right;\">GRAN TOTAL</th>
                    <td style=\"width:44px;\">" . $acumulado . "</td>
                 </tr>
                </table>
        <br>   
    <table >
                <tr>
                    <th align=center style=\"width:735px;text-align:left;\">INFORMACIÓN PERTINENTE A PUNTOS SALARIALES</th>
                 </tr>
                </table>
        <br>    
        <table align='left' >
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;word-warp:break-word\" colspan=\"10\" >TÍTULOS ACADÉMICOS</th>
            </tr>
            <tr>
                <th>TIPO<BR>TÍTULO</th>
                <th>TÍTULO</th>
                <th style=\"width:50px;\">UNIVERSIDAD</th>
                <th>FECHA<br>GRADO</th>
                <th>FECHA<br>RECONOC.</th>
                <th>ACTA</th>
                <th>CERT.<br>CONVALIDA</th>
                <th>FECHA</th>
                <th>ENTIDAD</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
           
                " . $contenido_consultas[0] . "
             <tr>
                <th style=\"text-align:right;\" colspan=\"9\" >Subtotal</th>
                <td>" . $a[0] . "</td>
            </tr>
        </table>
    
    <BR>
            
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;word-warp:break-word\" colspan=\"4\" >EXPERIENCIA CALIFICADA EN INVESTIGACIÓN</th>
            </tr>
            <tr>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th>TIEMPO VALORADO</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
          
                " . $contenido_consultas[1] . "
       <tr>
                 <th style=\"text-align:right;\" colspan=\"3\" >Subtotal</th>
                <td>" . $a[1] . "</td>
            </tr>
        </table>
    
    <BR>
    
        <table>
            <tr>
               <th style=\"width:735px;font-size:10px;text-align:left;word-warp:break-word\" colspan=\"4\" >EXPERIENCIA CALIFICADA EN DIRECCIÓN ACADÉMICA</th>
            </tr>
            <tr>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th>TIEMPO VALORADO</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
                
                " . $contenido_consultas[2] . "  
            <tr>         
               <th style=\"text-align:right;\" colspan=\"3\" >Subtotal</th>
            <td>" . $a[2] . "</td>
            </tr>
        </table>
    
    <BR>
    
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;word-warp:break-word\" colspan=\"4\" >EXPERIENCIA CALIFICADA POR AÑO VENCIDO</th>
            </tr>
            <tr>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th>TIEMPO VALORADO</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
             
                " . $contenido_consultas[3] . "
     <tr>    <th style=\"text-align:right;\" colspan=\"3\" >Subtotal</th>
                <td>" . $a[3] . "</td>
            </tr>
        </table>
    
    <BR>
    
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"4\" >EXPERIENCIA PROFESIONAL</th>
            </tr>
            <tr>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th>TIEMPO VALORADO</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
              
                " . $contenido_consultas[4] . "
    <tr>  
                 <th style=\"text-align:right;\" colspan=\"3\" >Subtotal</th>
          <td>" . $a[4] . "</td>
            </tr>
        </table>
    <BR>
    
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"4\">EXCELENCIA ACADÉMICA</th>
            </tr>
            <tr>
                <th>AÑO</th>
                <th>RESOLUCIÓN</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
               
                " . $contenido_consultas[5] . "
           <tr> 
                 <th style=\"text-align:right;\" colspan=\"3\" >Subtotal</th>
                 <td>" . $a[5] . "</td>
            </tr>
        </table>
    
    <BR>
    
        <table>
            <tr>
              <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"8\">PRODUCCIÓN ACADÉMICA</th>
            </tr>
            <tr>
                <th>TIPO</th>
                <th>NOMBRE ARTÍCULO</th>
                <th>AÑO</th>
                <th>ISSN</th>
                <th>VOLUMEN</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
             
                " . $contenido_consultas[6] . "
          <tr>  
                 <th style=\"text-align:right;\" colspan=\"7\" >Subtotal</th>
               <td>" . $a[6] . "</td>
            </tr>
        </table>
    
    <BR>
    
        <table>
            <tr>
               <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"8\">COMUNICACIÓN CORTA</th>
            </tr>
            <tr>
                <th>NOMBRE REVISTA</th>
                <th>ISSN</th>
                <th>AUTOR</th>
                <th>CC</th>
                <th>AÑO</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
                
                " . $contenido_consultas[7] . "
   <tr>
                 <th style=\"text-align:right;\" colspan=\"7\" >Subtotal</th>
               <td>" . $a[7] . "</td>
            </tr>
        </table>
    
    <BR>
    
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"8\">CARTAS AL EDITOR</th>
            </tr>
            <tr>
                <th>NOMBRE REVISTA</th>
                <th>ISSN</th>
                <th>AUTOR</th>
                <th>CC</th>
                <th>AÑO</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
            " . $contenido_consultas[8] . "
            
            <tr> 
                 <th style=\"text-align:right;\" colspan=\"7\" >Subtotal</th>
             <td>" . $a[8] . "</td>
            </tr>
        </table>
    
    <BR>
   
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"7\">PRODUCCIÓN DE VIDEOS</th>
            </tr>
            <tr>
                <th>CONTEXTO</th>
                <th>AUTOR</th>
                <th>NOMBRE</th>
                <th>AÑO</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
                 
                " . $contenido_consultas[9] . "
            <tr>
             <th style=\"text-align:right;\" colspan=\"6\" >Subtotal</th>
            <td>" . $a[9] . "</td>
            </tr>
        </table>
    
    <BR>
    
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"9\">LIBROS DE INVESTIGACIÓN</th>
            </tr>
            <tr>
                <th>TÍTULO DEL LIBRO</th>
                <th>ISBN</th>
                <th>No. TOTAL AUTORES</th>
                <th>No. TOTAL AUTORES UD</th>
                <th>AÑO</th>
                <th>EDITORIAL</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
                
                " . $contenido_consultas[10] . "
           
            <tr> 
                 <th style=\"text-align:right;\" colspan=\"8\" >Subtotal</th>
               <td>" . $a[10] . "</td>
            </tr>
        </table>
    
    <BR>
    
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"9\">LIBROS DE TEXTO</th>
            </tr>
            <tr>
                <th>TÍTULO DEL LIBRO</th>
                <th>ISBN</th>
                <th>No. TOTAL AUTORES</th>
                <th>No. TOTAL AUTORES UD</th>
                <th>AÑO</th>
                <th>EDITORIAL</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
           
                " . $contenido_consultas[11] . "
        
            <tr> 
                 <th style=\"text-align:right;\" colspan=\"8\" >Subtotal</th>
               <td>" . $a[11] . "</td>
            </tr>
        </table>
    
    <BR> 
    
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"9\">LIBROS DE ENSAYO</th>
            </tr>
            <tr>
                <th>TÍTULO DEL LIBRO</th>
                <th>ISBN</th>
                <th>No. TOTAL AUTORES</th>
                <th>No. TOTAL AUTORES UD</th>
                <th>AÑO</th>
                <th>EDITORIAL</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
          
                " . $contenido_consultas[12] . "

            <tr> 
                 <th style=\"text-align:right;\" colspan=\"8\" >Subtotal</th>
               <td>" . $a[12] . "</td>
            </tr>
        </table>
    
    <BR> 
    
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"9\">PREMIOS</th>
            </tr>
            <tr>
                <th>CONTEXTO</th>
                <th>ENTIDAD</th>
                <th>CONCEPTO PREMIO</th>
                <th>CIUDAD</th>
                <th>FECHA</th>
                <th>No. PERSONAS</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
     
                " . $contenido_consultas[13] . "
   
            <tr> 
                 <th style=\"text-align:right;\" colspan=\"8\" >Subtotal</th>
               <td>" . $a[13] . "</td>
            </tr>
        </table>
    
    <BR>

        <table>
            <tr>
               <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"8\">PATENTES</th>
            </tr>
            <tr>
                <th>AUTOR PROPIEDAD</th>
                <th>ENTIDAD</th>
                <th>AÑO</th>
                <th>CONCEPTO</th>
                <th>No. REGISTRO</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th>PUNTOS</th>
            </tr>
               
                " . $contenido_consultas[14] . "
                      <tr>
                <th colspan=\"7\" style=\"text-align:right;\">Subtotal</th>
                <td>" . $a[14] . "</td>
            </tr>
        </table>
    
    <BR>
    
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"6\">TRADUCCIÓN DE LIBROS</th>
            </tr>
            <tr>
                <th>TÍTULO LIBRO ORIGINAL</th>
                <th>AUTOR TRADUCCIÓN</th>
                <th>ISBN</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th>PUNTOS</th>
            </tr>
              
                " . $contenido_consultas[15] . "
                     <tr>  
                <th colspan=\"5\" style=\"font-size:10px;text-align:right;\">Subtotal</th>
                <td>" . $a[15] . "</td>
            </tr>
        </table>
    
    <BR> 
    
        <table>
            <tr>
               <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"10\">OBRAS ARTÍSTICAS SALARIALES</th>
            </tr>
            <tr>
                <td colspan='8' style='font-size:11px;text-align: left'>CREACIÓN ORIGINAL</td>   
            </tr>
            <tr>
                <th>CONTEXTO</th>
                <th>TÍTULO OBRA</th>
                <th>AUTOR</th>
                <th>TIPO CERTIFICACIÓN</th>
                <th>FECHA</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
         
                " . $contenido_consultas[16] . "
          
            <tr> 
                <th colspan='7' style='font-size:10px;text-align:right'>Subtotal</th>
               <td>" . $a[16] . "</td>
            </tr>
            <tr>
                <td style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"8\">CREACIÓN COMPLEMENTARIA</td>   
            </tr>
            <tr>
                <th>CONTEXTO</th>
                <th>TÍTULO OBRA</th>
                <th>AUTOR</th>
                <th>TIPO CERTIFICACIÓN</th>
                <th>FECHA</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
     
                " . $contenido_consultas[17] . "

            <tr> 
                <th colspan='7' style='font-size:10px;text-align:right'>Subtotal</th>
             <td>" . $a[17] . "</td>
            </tr>
        </table>
     <BR>

    
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"7\">PRODUCCIÓN TÉCNICA</th>
            </tr>
            <tr>
                <td style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"7\">INNOVACIÓN TECNÓLOGICA</td>   
            </tr>
            <tr>
                <th>No. AUTORES</th>
                <th>NOMBRES</th>
                <th>CERTIFICADO</th>
                <th>FECHA PRODUCCIÓN</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
            
                " . $contenido_consultas[18] . "
                     <tr>  
              <th colspan=\"6\" style='font-size:10px;text-align:right'>Subtotal</th>
                <td>" . $a[18] . "</td>
            </tr>
            <tr>
              <td style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"7\">ADAPTACIÓN TECNOLÓGICA</td>   
            </tr>
            <tr>
                <th>No. AUTORES</th>
                <th>NOMBRES</th>
                <th>CERTIFICADO</th>
                <th>FECHA PRODUCCIÓN</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
            
                " . $contenido_consultas[19] . "
    <tr>  
                <th colspan=\"6\" style='font-size:10px;text-align:right'>Subtotal</th>
               <td>" . $a[19] . "</td>
            </tr>
        </table>
    
    <BR> 
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"7\">PRODUCCIÓN DE SOFTWARE</th>
            </tr>
            <tr>
                <th>No. AUTORES</th>
                <th>NOMBRES</th>
                <th>CERTIFICADO</th>
                <th>FECHA PRODUCCIÓN</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
       
                " . $contenido_consultas[20] . "
     
            <tr> 
                <th colspan=\"6\" style='font-size:10px;text-align:right'>Subtotal</th>
               <td>" . $a[20] . "</td>
            </tr>
        </table>
    
    <BR>
    
    <table align='left'>
                <tr>
                    <th align=center style=\"width:735px;text-align:left;\">INFORMACIÓN PERTINENTE A PUNTOS POR BONIFICACIÓN</th>
                 </tr>
                </table>
    <BR>
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"8\">PRODUCCIÓN DE VIDEOS, CINEMATÓGRAFOS, CIENTÍFICO</th>
            </tr>
            <tr>
                <th>TÍTULO</th>
                <th>MODALIDAD</th>
                <th>No. AUTORES</th>
                <th>FECHA</th>
                <th>REGISTRO</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
      
                " . $contenido_consultas[21] . "
                     <tr>  
                <th colspan=\"7\" style=\"text-align:left;\">Subtotal</th>
               <td>" . $a[21] . "</td>
            </tr>
        </table>
    <BR>
        <table>
            <tr>
               <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"9\">PONENCIAS</th>
            </tr>
            <tr>
                <th>CONTEXTO</th>
                <th>TITULO</th>
                <th>AUTOR</th>
                <th>FECHA</th>
                <th>EVENTO</th>
                <th>CERTIFICADO</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
     
                " . $contenido_consultas[22] . "
              <tr>  
                <th colspan=\"8\" style=\"text-align:right;\">Subtotal</th>
               <td>" . $a[22] . "</td>
            </tr>
        </table>
    
    <BR> 
        <table>
            <tr>
               <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"12\">PUBLICACIONES IMPRESAS UNIVERSITARIAS</th>
            </tr>
            <tr>
                <th>TITULO</th>
                <th>ISSN</th>
                <th>AUTOR</th>
                <th>FECHA</th>
                <th>NOMBRE REVISTA</th>
                <th>VOLUMEN</th>
                <th>No.</th>
                <th>CATEGORÍA</th>
                <th>AÑO</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th>PUNTOS</th>
            </tr>

                " . $contenido_consultas[23] . "
            <tr>  
                <th colspan=\"11\" style=\"text-align:right;\">Subtotal</th>
                <td>" . $a[23] . "</td>
            </tr>
        </table>
    
    <BR> <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"8\">ESTUDIOS POSDOCTORALES</th>
            </tr>
            <tr>
                <th>AUTOR</th>
                <th>ENTIDAD</th>
                <th>FECHA</th>
                <th>TITULO</th>
                <th>DURACIÓN</th>
                <th>ACTA<BR>CIARP-UD</th>
                <th>FECHA</th>
                <th>PUNTOS</th>
            </tr>
                " . $contenido_consultas[24] . "
                    
            <tr>  
                <th colspan='7' style='font-size:10px;text-align:right'>Subtotal</th>
               <td>" . $a[24] . "</td>
            </tr>
        </table>
    
    <BR> <table>
            <tr>
               <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"6\">RESEÑA CRÍTICA</th>
            </tr>
            <tr>
                <th>TITULO</th>
                <th>FECHA</th>
                <th>AUTOR</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
       
                " . $contenido_consultas[25] . "
 
            <tr> 
                <th colspan='5' style='font-size:10px;text-align:right'>Subtotal</th>
               <td>" . $a[25] . "</td>
            </tr>
        </table>
    
    <BR> <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"6\">TRADUCCIONES</th>
            </tr>
            <tr>
                <th>TITULO</th>
                <th>FECHA</th>
                <th>AUTOR</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
   
                " . $contenido_consultas[26] . "

            <tr> 
                <th colspan='5' style='font-size:10px;text-align:right'>Subtotal</th>
              <td>" . $a[26] . "</td>
            </tr>
        </table>
    
    <BR><table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"6\">OBRAS ARTÍSTICAS BONIFICACIÓN</th>
            </tr>
            <tr>
                <td style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"6\">CREACIÓN ORIGINAL</td>   
            </tr>
            <tr>
                <th>TÍTULO OBRA</th>
                <th>FECHA</th>
                <th>AUTOR</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
 
                " . $contenido_consultas[27] . "
 <tr>  
                <th colspan='5' style='font-size:10px;text-align:right'>Subtotal</th>
                <td>" . $a[27] . "</td>
            </tr>
            <tr>
              <td style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"6\">CREACIÓN COMPLEMENTARIA</td>   
            </tr>
            <tr>
                <th>TÍTULO OBRA</th>
                <th>FECHA</th>
                <th>AUTOR</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>

                " . $contenido_consultas[28] . "
 <tr>  
                <th colspan='5' style='font-size:10px;text-align:right'>Subtotal</th>
               <td>" . $a[28] . "</td>
            </tr>
        </table>
    
    <BR>
        <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"7\">INTERPRETACIONES</th>
            </tr>
            <tr>
                <th>TITULO</th>
                <th>AUTOR</th>
                <th>LUGAR</th>
                <th>FECHA</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>
   
                " . $contenido_consultas[29] . "
 <tr>  
                <th colspan='6' style='font-size:10px;text-align:right'>Subtotal</th>
             <td>" . $a[29] . "</td>
            </tr>
        </table>
    
    <BR> <table>
            <tr>
                <th style=\"width:735px;font-size:10px;text-align:left;\" colspan=\"8\">DIRECCIÓN DE TRABAJOS DE GRADO</th>
            </tr>
            <tr>
                <th>TIPO</th>
                <th>TITULO TRABAJO</th>
                <th>No. ESTUDIANTES</th>
                <th>NOMBRE DIRECTOR</th>
                <th>AÑO</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th style=\"width:35\">PUNTOS</th>
            </tr>

                " . $contenido_consultas[30] . "
 <tr>       
                <th colspan='7' style='font-size:10px;text-align:right'>Subtotal</th>
               <td>" . $a[30] . "</td>
            </tr>
        </table>
    <BR>
     <table align='left'>
                <tr>
                    <th style=\"width:685px;text-align:right;\">TOTAL PUNTOS SALARIALES</th>
                    <td style=\"width:44px;\">" . $salarial . "</td>
                 </tr>
                   <tr>
                    <th style=\"width:685px;text-align:right;\">TOTAL PUNTOS BONIFICACIÓN</th>
                    <td style=\"width:44px;\">" . $bonificacion . "</td>
                 </tr>
                   <tr>
                    <th style=\"width:685px;text-align:right;\">GRAN TOTAL</th>
                    <td style=\"width:44px;\">" . $acumulado . "</td>
                 </tr>
                </table>
        <br>   
       <table>
            <tr>
                <td style=\"width:735px;text-align:right;\">
                    <br><br><br><br><br><br>
                </td>
            </tr>
            <tr>
                <th style=\"width:735px;text-align:center;\">
                    Jefe(a) Oficina de Docencia
                </th>
            </tr>
        </table>        

</page>
              

";

$html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', 3);
$html2pdf->pdf->SetDisplayMode('fullpage');
$html2pdf->WriteHTML($ContenidoPdf);
clearstatcache();
$html2pdf->Output('EstadoCuenta_"' . $arreglo . '".pdf', 'D');
