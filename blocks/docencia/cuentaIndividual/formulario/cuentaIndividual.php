<?php
if (!isset($GLOBALS ['autorizado'])) {
    include ('../index.php');
    exit();
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion('esteBloque');

$rutaBloque = $this->miConfigurador->getVariableConfiguracion('host');
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion('site') . '/blocks/';
$rutaBloque .= $esteBloque ['grupo'] . '/' . $esteBloque ['nombre'];

$this->ruta = $this->miConfigurador->getVariableConfiguracion('rutaBloque');

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$arreglo = $_REQUEST["identificacionFinalConsulta"];

$subtotal_salarial;
$subtotal_bono;
$total_puntos;

//1
$cadena_sql_1 = $this->sql->cadena_sql("datosDocente", $arreglo);
$datosDocente = $esteRecursoDB->ejecutarAcceso($cadena_sql_1, "busqueda");
//2
$cadena_sql_2 = $this->sql->cadena_sql("codigo_docente", $arreglo);
$codigo_interno = $esteRecursoDB->ejecutarAcceso($cadena_sql_2, "busqueda");


if (is_array($datosDocente)) {

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

    $contenido_consultas = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
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
                        $contenido_consultas[$key].= "<td>" . $valor . "</td> ";
                    }
                }
                $acumulado = $datos[$nodo]['puntaje'] + $acumulado;
                $puntaje = $datos[$nodo]['puntaje'] + $puntaje;
                $contenido_consultas[$key].= '</tr>';
            }
            $a[$key] = $puntaje;
        } else {
            $contenido_consultas[$key].= '<tr>';
            $contenido_consultas[$key].= '</tr>';
            $acumulado = 0 + $acumulado;
            $puntaje = 0 + $puntaje;

            $a[$key] = $puntaje;
        }
    }

    $bonificacion = round($a[21] + $a[22] + $a[23] + $a[24] + $a[25] + $a[26] + $a[27] + $a[28] + $a[29], 3);
    $salarial = round($acumulado, 3) - $bonificacion;
    $acumulado = round($acumulado, 3);
    ob_start();
    ?>

    <style type='text/css'>
        table { 
            color:#333; /* Lighten up font color */
            font-family:Helvetica, Arial, sans-serif; /* Nicer font */
            table-layout : fixed;
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
    <br><br><br><br><br>
    <center>
        <table   width ='60%'>
            <thead>
                <tr>
                    <th width='15%' colspan='1' rowspan='2'>
                        <img width='50%' <?php echo "src='" . $rutaBloque . "/images/ud.jpg'" ?>>
                    </th>
                    <th  colspan='5' style='font-size:12px;'>
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
                <td  colspan='1'><?php echo $datosDocente[0]['informacion_nombres'] . " " . $datosDocente[0]['informacion_apellidos'] ?></td>
                <td >Documento</td>
                <td  colspan='1'><?php echo $datosDocente[0]['dependencia_iddocente'] ?></td>
                <td >Código</td>
                <td  colspan='1'><?php echo $codigo_interno[0][0] ?></td>
            </tr>
            <tr> 
                <td  >Proyecto</td>
                <td  colspan='3'><?php echo $datosDocente[0]['nombre_proyecto'] ?></td>
                <td  >Facultad</td>
                <td  colspan='1'><?php echo $datosDocente[0]['nombre_facultad'] ?></td>
            </tr>
            <tr> 
                <td  >Fecha de Vinculación</td>
                <td  colspan='5'><?php echo $datosDocente[0]["vinculacion_fechaingreso"] ?></td>
            </tr>
            <tr> 
                <td  >Estado Docente</td>
                <td  colspan='5'><?php echo $datosDocente[0]["estado"] ?></td>
            </tr>
        </table> </center>
    <br>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='10' style='font-size:10px;'>INFORMACIÓN PERTINENTE A PUNTOS SALARIALES</th>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='10' style='font-size:11px;text-align: left'>TÍTULOS ACADÉMICOS</th>
            </tr>
            <tr>
                <th>TIPO TÍTULO</th>
                <th>TÍTULO OBTENIDO</th>
                <th>UNIVERSIDAD</th>
                <th>FECHA GRADO</th>
                <th>FECHA RECONOCIMIENTO</th>
                <th>ACTA</th>
                <th>CERTIFICADO CONVALIDACIÓN</th>
                <th>FECHA CONVALIDACIÓN</th>
                <th>ENTIDAD CONVALIDACIÓN</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>
    <?php echo $contenido_consultas[0] ?>
            </tr>
            <tr> 
                <th colspan='9' style='font-size:10px;text-align:right'>Subtotal</th>
                <td><?php echo $a[0] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='4' style='font-size:11px;text-align: left'>EXPERIENCIA CALIFICADA EN INVESTIGACIÓN</th>
            </tr>
            <tr>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th>TIEMPO VALORADO</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>
    <?php echo $contenido_consultas[1] ?>
            </tr>
            <tr> 
                <th colspan='3f' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[1] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='4' style='font-size:11px;text-align: left'>EXPERIENCIA CALIFICADA EN DIRECCIÓN ACADÉMICA</th>
            </tr>
            <tr>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th>TIEMPO VALORADO</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[2] ?>
            </tr>
            <tr> 
                <th colspan='3f' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[2] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='4' style='font-size:11px;text-align: left'>EXPERIENCIA CALIFICADA POR AÑO VENCIDO</th>
            </tr>
            <tr>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th>TIEMPO VALORADO</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[3] ?>
            </tr>
            <tr> 
                <th colspan='3f' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[3] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='4' style='font-size:11px;text-align: left'>EXPERIENCIA PROFESIONAL</th>
            </tr>
            <tr>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th>TIEMPO VALORADO</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[4] ?>
            </tr>
            <tr> 
                <th colspan='3' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[4] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='4' style='font-size:11px;text-align: left'>EXCELENCIA ACADÉMICA</th>
            </tr>
            <tr>
                <th>AÑO</th>
                <th>RESOLUCIÓN</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[5] ?>
            </tr>
            <tr> 
                <th colspan='3' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[5] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='8' style='font-size:11px;text-align: left'>PRODUCCIÓN ACADÉMICA</th>
            </tr>
            <tr>
                <th>TIPO</th>
                <th>NOMBRE ARTÍCULO</th>
                <th>AÑO</th>
                <th>ISSN</th>
                <th>VOLUMEN</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[6] ?>
            </tr>
            <tr> 
                <th colspan='7' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[6] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='8' style='font-size:11px;text-align: left'>COMUNICACIÓN CORTA</th>
            </tr>
            <tr>
                <th>NOMBRE REVISTA</th>
                <th>ISSN</th>
                <th>AUTOR</th>
                <th>CC</th>
                <th>AÑO</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[7] ?>
            </tr>
            <tr> 
                <th colspan='7' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[7] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='8' style='font-size:11px;text-align: left'>CARTAS AL EDITOR</th>
            </tr>
            <tr>
                <th>NOMBRE REVISTA</th>
                <th>ISSN</th>
                <th>AUTOR</th>
                <th>CC</th>
                <th>AÑO</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[8] ?>
            </tr>
            <tr> 
                <th colspan='7' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[8] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='7' style='font-size:11px;text-align: left'>PRODUCCIÓN DE VIDEOS</th>
            </tr>
            <tr>
                <th>CONTEXTO</th>
                <th>AUTOR</th>
                <th>NOMBRE</th>
                <th>AÑO</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[9] ?>
            </tr>
            <tr> 
                <th colspan='6' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[9] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='9' style='font-size:11px;text-align: left'>LIBROS DE INVESTIGACIÓN</th>
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
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[10] ?>
            </tr>
            <tr> 
                <th colspan='8' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[10] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='9' style='font-size:11px;text-align: left'>LIBROS DE TEXTO</th>
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
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[11] ?>
            </tr>
            <tr> 
                <th colspan='8' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[11] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='9' style='font-size:11px;text-align: left'>LIBROS DE ENSAYO</th>
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
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[12] ?>
            </tr>
            <tr> 
                <th colspan='8' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[12] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='9' style='font-size:11px;text-align: left'>PREMIOS</th>
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
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[13] ?>
            </tr>
            <tr> 
                <th colspan='8' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[13] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='8' style='font-size:11px;text-align: left'>PATENTES</th>
            </tr>
            <tr>
                <th>AUTOR PROPIEDAD</th>
                <th>ENTIDAD</th>
                <th>AÑO</th>
                <th>CONCEPTO</th>
                <th>No. REGISTRO</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[14] ?>
            </tr>
            <tr> 
                <th colspan='7' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[14] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='6' style='font-size:11px;text-align: left'>TRADUCCIÓN DE LIBROS</th>
            </tr>
            <tr>
                <th>TÍTULO LIBRO ORIGINAL</th>
                <th>AUTOR TRADUCCIÓN</th>
                <th>ISBN</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[15] ?>
            </tr>
            <tr> 
                <th colspan='5' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[15] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='8' style='font-size:11px;text-align: left'>OBRAS ARTÍSTICAS SALARIALES</th>
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
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[16] ?>
            </tr>
            <tr> 
                <th colspan='7' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[16] ?></td>
            </tr>
            <tr>
                <td colspan='8' style='font-size:11px;text-align: left'>CREACIÓN COMPLEMENTARIA</td>   
            </tr>
            <tr>
                <th>CONTEXTO</th>
                <th>TÍTULO OBRA</th>
                <th>AUTOR</th>
                <th>TIPO CERTIFICACIÓN</th>
                <th>FECHA</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[17] ?>
            </tr>
            <tr> 
                <th colspan='7' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[17] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='7' style='font-size:11px;text-align: left'>PRODUCCIÓN TÉCNICA</th>
            </tr>
            <tr>
                <td colspan='7' style='font-size:11px;text-align: left'>INNOVACIÓN TECNÓLOGICA</td>   
            </tr>
            <tr>
                <th>No. AUTORES</th>
                <th>NOMBRES</th>
                <th>CERTIFICADO</th>
                <th>FECHA PRODUCCIÓN</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[18] ?>
            </tr>
            <tr> 
                <th colspan='6' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[18] ?></td>
            </tr>
            <tr>
                <td colspan='7' style='font-size:11px;text-align: left'>ADAPTACIÓN TECNOLÓGICA</td>   
            </tr>
            <tr>
                <th>No. AUTORES</th>
                <th>NOMBRES</th>
                <th>CERTIFICADO</th>
                <th>FECHA PRODUCCIÓN</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[19] ?>
            </tr>
            <tr> 
                <th colspan='6' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[19] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='7' style='font-size:11px;text-align: left'>PRODUCCIÓN DE SOFTWARE</th>
            </tr>
            <tr>
                <th>No. AUTORES</th>
                <th>NOMBRES</th>
                <th>CERTIFICADO</th>
                <th>FECHA PRODUCCIÓN</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>     
    <?php echo $contenido_consultas[20] ?>
            </tr>
            <tr> 
                <th colspan='6' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[20] ?></td>
            </tr>
        </table>
    </center>
    <BR><BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='8' style='font-size:10px;'>INFORMACIÓN PERTINENTE A PUNTOS POR BONIFICACIÓN</th>
            </tr>
        </table>
    </center>
    <BR>

    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='9' style='font-size:11px;text-align: left'>PONENCIAS</th>
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
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>
    <?php echo $contenido_consultas[21] ?>
            </tr>
            <tr> 
                <th colspan='8' style='font-size:10px;text-align:right'>Subtotal</th> 
                <td width='50px'><?php echo $a[21] ?></td>

            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='12' style='font-size:11px;text-align: left'>PUBLICACIONES IMPRESAS UNIVERSITARIAS</th>
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
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>
    <?php echo $contenido_consultas[22] ?>
            </tr>
            <tr> 
                <th colspan='11' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[22] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='8' style='font-size:11px;text-align: left'>ESTUDIOS POSDOCTORALES</th>
            </tr>
            <tr>
                <th>AUTOR</th>
                <th>ENTIDAD</th>
                <th>FECHA</th>
                <th>TITULO</th>
                <th>DURACIÓN</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>
    <?php echo $contenido_consultas[23] ?>
            </tr>
            <tr> 
                <th colspan='7' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[23] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='6' style='font-size:11px;text-align: left'>RESEÑA CRÍTICA</th>
            </tr>
            <tr>
                <th>TITULO</th>
                <th>FECHA</th>
                <th>AUTOR</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>
    <?php echo $contenido_consultas[24] ?>
            </tr>
            <tr> 
                <th colspan='5' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[24] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='6' style='font-size:11px;text-align: left'>TRADUCCIONES</th>
            </tr>
            <tr>
                <th>TITULO</th>
                <th>FECHA</th>
                <th>AUTOR</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>
    <?php echo $contenido_consultas[25] ?>
            </tr>
            <tr> 
                <th colspan='5' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[25] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='6' style='font-size:11px;text-align: left'>OBRAS ARTÍSTICAS BONIFICACIÓN</th>
            </tr>
            <tr>
                <td colspan='6' style='font-size:11px;text-align: left'>CREACIÓN ORIGINAL</td>   
            </tr>
            <tr>
                <th>TÍTULO OBRA</th>
                <th>FECHA</th>
                <th>AUTOR</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>
    <?php echo $contenido_consultas[26] ?>
            </tr>
            <tr> 
                <th colspan='5' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[26] ?></td>
            </tr>
            <tr>
                <td colspan='6' style='font-size:11px;text-align: left'>CREACIÓN COMPLEMENTARIA</td>   
            </tr>
            <tr>
                <th>TÍTULO OBRA</th>
                <th>FECHA</th>
                <th>AUTOR</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>
    <?php echo $contenido_consultas[27] ?>
            </tr>
            <tr> 
                <th colspan='5' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[27] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='7' style='font-size:11px;text-align: left'>INTERPRETACIONES</th>
            </tr>
            <tr>
                <th>TITULO</th>
                <th>AUTOR</th>
                <th>LUGAR</th>
                <th>FECHA</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>
    <?php echo $contenido_consultas[28] ?>
            </tr>
            <tr> 
                <th colspan='6' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[28] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr>
                <th colspan='8' style='font-size:11px;text-align: left'>DIRECCIÓN DE TRABAJOS DE GRADO</th>
            </tr>
            <tr>
                <th>TIPO</th>
                <th>TITULO TRABAJO</th>
                <th>No. ESTUDIANTES</th>
                <th>NOMBRE DIRECTOR</th>
                <th>AÑO</th>
                <th>ACTA CIARP-UD</th>
                <th>FECHA</th>
                <th width='50px'>PUNTOS</th>
            </tr>
            <tr>
    <?php echo $contenido_consultas[29] ?>
            </tr>
            <tr> 
                <th colspan='7' style='font-size:10px;text-align:right'>Subtotal</th>
                <td width='50px'><?php echo $a[29] ?></td>
            </tr>
        </table>
    </center>
    <BR>
    <center>
        <table   width ='60%' >
            <tr> 
                <th colspan='8' style='font-size:10px;text-align:right'>TOTAL PUNTOS SALARIALES</th>
                <td width='50px'><?php echo $salarial ?></td>
            </tr>
            <tr> 
                <th colspan='8' style='font-size:10px;text-align:right'>TOTAL PUNTOS BONIFICACIÓN</th>
                <td width='50px'><?php echo $bonificacion ?></td>
            </tr>
            <tr> 
                <th colspan='8' style='font-size:10px;text-align:right'>GRAN TOTAL</th>
                <td width='50px'><?php echo $acumulado ?></td>
            </tr>
        </table>
    </center>

    <br><br>
    <center>
        <table width = '60%'>
            <tr>
                <td style = 'font-size:12px' colspan = '9'>
                    <br><br>
                </td>
            </tr>
            <tr>
                <th style = 'font-size:12px' colspan = '9'>
                    Jefe(a) Oficina de Docencia
                </th>
            </tr>
        </table>
        <p style='font-size:9px'>Fecha Generación:

    </center>

    <br><br><br>
    <?php
    $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
    $nombreFormulario = $esteBloque["nombre"];

    $valorCodificado = "action=" . $esteBloque["nombre"];
    $valorCodificado.= "&opcion=imprimir";
    $valorCodificado.="&bloque=" . $esteBloque["id_bloque"];
    $valorCodificado.="&bloqueGrupo=" . $esteBloque["grupo"];
    $valorCodificado.="&identificacion=" . $_REQUEST["identificacionFinalConsulta"];
    $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);
    $directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");

    $tab = 1;

//---------------Inicio Formulario (<form>)--------------------------------
    $atributos["id"] = $nombreFormulario;
    $atributos["tipoFormulario"] = "multipart/form-data";
    $atributos["metodo"] = "POST";
    $atributos["nombreFormulario"] = $nombreFormulario;
    $verificarFormulario = "1";
    echo $this->miFormulario->formulario("inicio", $atributos);

//------------------Division para los botones-------------------------
    $atributos["id"] = "botones";
    $atributos["estilo"] = "marcoBotones";
    echo $this->miFormulario->division("inicio", $atributos);

//-------------Control Boton-----------------------
    $esteCampo = "botonImprimir";
    $atributos["id"] = "imprimir";
    $atributos["tabIndex"] = $tab++;
    $atributos["tipo"] = "boton";
    $atributos["estilo"] = "";
    $atributos["verificar"] = ""; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
    $atributos["tipoSubmit"] = ""; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
    $atributos["valor"] = $this->lenguaje->getCadena($esteCampo);
    $atributos["nombreFormulario"] = $nombreFormulario;
    echo $this->miFormulario->campoBoton($atributos);
    unset($atributos);

    $esteCampo = "botonCancelar";
    $atributos["id"] = $esteCampo;
    $atributos["tabIndex"] = $tab++;
    $atributos["tipo"] = "boton";
    $atributos["estilo"] = "";
    $atributos["verificar"] = ""; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
    $atributos["tipoSubmit"] = ""; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
    $atributos["valor"] = $this->lenguaje->getCadena($esteCampo);
    $atributos["nombreFormulario"] = $nombreFormulario;
    echo $this->miFormulario->campoBoton($atributos);
    unset($atributos);

//-------------Fin Control Boton----------------------
//-------------Control cuadroTexto con campos ocultos-----------------------
//Para pasar variables entre formularios o enviar datos para validar sesiones
    $atributos["id"] = "formSaraData"; //No cambiar este nombre
    $atributos["tipo"] = "hidden";
    $atributos["obligatorio"] = false;
    $atributos["etiqueta"] = "";
    $atributos["valor"] = $valorCodificado;
    echo $this->miFormulario->campoCuadroTexto($atributos);
    unset($atributos);

//Fin del Formulario
    echo $this->miFormulario->formulario("fin");
} else {


    $nombreFormulario = $esteBloque ["nombre"];

    $tab = 1;

    include_once ("core/crypto/Encriptador.class.php");
    $cripto = Encriptador::singleton();
    $valorCodificado = "&opcion=nuevo";
    $valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
    $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
    $valorCodificado = $cripto->codificar($valorCodificado);

    // ---------------Inicio Formulario (<form>)--------------------------------
    $atributos ["id"] = $nombreFormulario;
    $atributos ["tipoFormulario"] = "multipart/form-data";
    $atributos ["metodo"] = "POST";
    $atributos ["nombreFormulario"] = $nombreFormulario;
    $verificarFormulario = "1";
    echo $this->miFormulario->formulario("inicio", $atributos);

    // ------------------Division para los botones-------------------------
    $atributos ["id"] = "botones";
    $atributos ["estilo"] = "marcoBotones";
    echo $this->miFormulario->division("inicio", $atributos);

    // -------------Control Boton-----------------------
    $esteCampo = "botonVolver";
    $atributos ["id"] = $esteCampo;
    $atributos ["tabIndex"] = $tab ++;
    $atributos ["tipo"] = "boton";
    $atributos ["estilo"] = "";
    $atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
    $atributos ["tipoSubmit"] = "jquery"; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
    $atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
    $atributos ["nombreFormulario"] = $nombreFormulario;
    echo $this->miFormulario->campoBoton($atributos);
    unset($atributos);

    $nombreFormulario = $esteBloque ["nombre"];
    include_once ("core/crypto/Encriptador.class.php");
    $cripto = Encriptador::singleton();
    $directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque") . "/imagen/";

    $miPaginaActual = $this->miConfigurador->getVariableConfiguracion("pagina");

    $tab = 1;
    // ---------------Inicio Formulario (<form>)--------------------------------
    $atributos ["id"] = $nombreFormulario;
    $atributos ["tipoFormulario"] = "multipart/form-data";
    $atributos ["metodo"] = "POST";
    $atributos ["nombreFormulario"] = $nombreFormulario;
    $verificarFormulario = "1";
    echo $this->miFormulario->formulario("inicio", $atributos);

    $atributos ["id"] = "divNoEncontroEgresado";
    $atributos ["estilo"] = "marcoBotones";
    // $atributos["estiloEnLinea"]="display:none";
    echo $this->miFormulario->division("inicio", $atributos);

    // -------------Control Boton-----------------------
    $esteCampo = "noEncontroProcesos";
    $atributos ["id"] = $esteCampo; // Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
    $atributos ["etiqueta"] = "";
    $atributos ["estilo"] = "centrar";
    $atributos ["tipo"] = 'error';
    $atributos ["mensaje"] = $this->lenguaje->getCadena($esteCampo);

    echo $this->miFormulario->cuadroMensaje($atributos);
    unset($atributos);

    $valorCodificado = "pagina=" . $miPaginaActual;
    $valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
    $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
    $valorCodificado = $cripto->codificar($valorCodificado);
    // -------------Fin Control Boton----------------------
    // ------------------Fin Division para los botones-------------------------
    echo $this->miFormulario->division("fin");
    // ------------------Division para los botones-------------------------
    $atributos ["id"] = "botones";
    $atributos ["estilo"] = "marcoBotones";
    echo $this->miFormulario->division("inicio", $atributos);


    // -------------Fin Control Boton----------------------
    // ------------------Fin Division para los botones-------------------------
    echo $this->miFormulario->division("fin");

    // -------------Control cuadroTexto con campos ocultos-----------------------
    // Para pasar variables entre formularios o enviar datos para validar sesiones
    $atributos ["id"] = "formSaraData"; // No cambiar este nombre
    $atributos ["tipo"] = "hidden";
    $atributos ["obligatorio"] = false;
    $atributos ["etiqueta"] = "";
    $atributos ["valor"] = $valorCodificado;
    echo $this->miFormulario->campoCuadroTexto($atributos);
    unset($atributos);

    // Fin del Formulario
    echo $this->miFormulario->formulario("fin");
}
