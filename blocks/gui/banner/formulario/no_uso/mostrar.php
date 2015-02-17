<?
/***************************************************************************
 *   PHP Application Framework Version 10                                  *
 *   Copyright (c) 2003 - 2009                                             *
 *   Teleinformatics Technology Group de Colombia                          *
 *   ttg@ttg.com.co                                                        *
 *                                                                         *
****************************************************************************/

if(!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

if(isset($certificado)&&$certificado=="BloqueEjemploAjax") {

    include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
    $cripto=new encriptar();

      $indice=$configuracion["host"].$configuracion["site"]."/index.php?";
    $directorio=$configuracion["host"].$configuracion["site"].$configuracion["bloques"]."/registro_participante/imagen/";




    $tab=1;

    //Rescatar los valores

    if(isset($_REQUEST["registro"])) {

        $this->cadena_sql=$this->sql->cadena_sql($configuracion,"rescatarParticipante",$_REQUEST["registro"]);
        //echo $this->cadena_sql;
        $this->registro=$this->funcion->ejecutarSQL($configuracion,$this->cadena_sql, "busqueda",$configuracion["db_principal"]);

        if($this->funcion->totalRegistros($configuracion,$configuracion["db_principal"])>0) {
            ?><div id="imagenCentral">
    <table cellpadding="0" border="0" cellspacing="0">
        <tr>
            <td><img alt=" " src="<? echo $directorio?>contenido_0_0.png" style="width: 107px;  height: 59px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_0_1.png" style="width: 173px;  height: 59px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_0_2.png" style="width: 35px;  height: 59px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_0_3.png" style="width: 31px;  height: 59px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_0_4.png" style="width: 11px;  height: 59px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_0_5.png" style="width: 31px;  height: 59px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_0_6.png" style="width: 10px;  height: 59px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_0_7.png" style="width: 30px;  height: 59px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_0_8.png" style="width: 130px;  height: 59px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_0_9.png" style="width: 79px;  height: 59px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_0_10.png" style="width: 101px;  height: 59px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_0_11.png" style="width: 93px;  height: 59px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_0_12.png" style="width: 93px;  height: 59px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_0_13.png" style="width: 76px;  height: 59px; border-width: 0px;"></td>
        </tr>

        <tr>
            <td><img alt=" " src="<? echo $directorio?>contenido_1_0.png" style="width: 107px;  height: 77px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_1_1.png"  style="width: 173px; height: 77px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_1_2.png"  style="width: 35px; height: 77px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_1_3.png"  style="width: 31px; height: 77px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_1_4.png"  style="width: 11px; height: 77px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_1_5.png"  style="width: 31px; height: 77px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_1_6.png"  style="width: 10px; height: 77px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_1_7.png"  style="width: 30px; height: 77px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_1_8.png"  style="width: 130px; height: 77px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_1_9.png"  style="width: 79px; height: 77px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_1_10.png"  style="width: 101px; height: 77px; border-width: 0px;" usemap="#informacionConferencia" id="informacionConferencia"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_1_11.png"  style="width: 93px; height: 77px; border-width: 0px;"   usemap="#inscripcionConferencia" id="inscripcionConferencia"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_1_12.png"  style="width: 93px; height: 77px; border-width: 0px;"   usemap="#calendarioConferencia" id="calendarioConferencia"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_1_13.png" style="width: 76px;  height: 77px; border-width: 0px;"></td>
        </tr>

        <tr>
            <td><img alt=" " src="<? echo $directorio?>contenido_2_0.png" style="width: 107px;  height: 21px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_2_1.png"  style="width: 173px; height: 21px; border-width: 0px;"  usemap="#semana" id="semana"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_2_2.png"  style="width: 35px; height: 21px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_2_3.png"  style="width: 31px; height: 21px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_2_4.png"  style="width: 11px; height: 21px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_2_5.png"  style="width: 31px; height: 21px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_2_6.png"  style="width: 10px; height: 21px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_2_7.png"  style="width: 30px; height: 21px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_2_8.png"  style="width: 130px; height: 21px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_2_9.png"  style="width: 79px; height: 21px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_2_10.png"  style="width: 101px; height: 21px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_2_11.png"  style="width: 93px; height: 21px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_2_12.png"  style="width: 93px; height: 21px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_2_13.png" style="width: 76px;  height: 21px; border-width: 0px;"></td>
        </tr>

        <tr>
            <td><img alt=" " src="<? echo $directorio?>contenido_3_0.png" style="width: 107px;  height: 12px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_3_1.png"  style="width: 173px; height: 12px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_3_2.png"  style="width: 35px; height: 12px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_3_3.png"  style="width: 31px; height: 12px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_3_4.png"  style="width: 11px; height: 12px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_3_5.png"  style="width: 31px; height: 12px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_3_6.png"  style="width: 10px; height: 12px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_3_7.png"  style="width: 30px; height: 12px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_3_8.png"  style="width: 130px; height: 12px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_3_9.png"  style="width: 79px; height: 12px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_3_10.png"  style="width: 101px; height: 12px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_3_11.png"  style="width: 93px; height: 12px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_3_12.png"  style="width: 93px; height: 12px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_3_13.png" style="width: 76px;  height: 12px; border-width: 0px;"></td>
        </tr>

        <tr>
            <td><img alt=" " src="<? echo $directorio?>contenido_4_0.png" style="width: 107px;  height: 16px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_4_1.png"  style="width: 173px; height: 16px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_4_2.png"  style="width: 35px; height: 16px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_4_3.png"  style="width: 31px; height: 16px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_4_4.png"  style="width: 11px; height: 16px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_4_5.png"  style="width: 31px; height: 16px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_4_6.png"  style="width: 10px; height: 16px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_4_7.png"  style="width: 30px; height: 16px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_4_8.png"  style="width: 130px; height: 16px; border-width: 0px;"></td>
            <td colspan="4" rowspan="3">
                 <table class="tablaContenido" align="center">
                    <tr>
                        <td>
                            <div class="margen">
                                <p  class="bordeAncho">
                                    <span class="textoTitulo">&nbsp;Inscrito con &eacute;xito!!</span><hr class="hr_division"/>
                            </div>
                        </td>
                    </tr>
                </table>
                        <?



        //------------------Division General-------------------------
            $atributos["id"]="general";
            $atributos["estilo"]="general";
            echo $this->miFormulario->division("inicio",$atributos);

            //-------------------Division Titulo-------------------------------
            $atributos["id"]="titulo0";
            $atributos["estilo"]="marcoTitulo";
            echo $this->miFormulario->division("inicio",$atributos);

            //-----------------------Campo Mensaje-----------------------
            $atributos["mensaje"]=$this->lenguaje["marcoDatosGenerales"];
            $atributos["estilo"]="campoMostrar";
            $atributos["tamanno"]="grande";
            echo $this->miFormulario->campoMensaje($configuracion,$atributos);

            //-------------------Fin Division Titulo-------------------------------
            echo $this->miFormulario->division("fin",$atributos);

            //-----------------------Campo Mensaje-----------------------
            $esteCampo="id";
            $atributos["texto"]=$_REQUEST["registro"];
            $atributos["etiqueta"]="PIN de inscripci&oacute;n:";
            echo $this->miFormulario->campoTexto($configuracion,$atributos);

            
            //-----------------------Campo Mensaje-----------------------
            $esteCampo="nombre";
            $atributos["texto"]=$this->registro[0][$esteCampo];
            $atributos["etiqueta"]=$this->lenguaje[$esteCampo];
            echo $this->miFormulario->campoTexto($configuracion,$atributos);
            
            //-----------------------Campo Mensaje-----------------------
            $esteCampo="apellido";
            $atributos["texto"]=$this->registro[0][$esteCampo];
            $atributos["etiqueta"]=$this->lenguaje[$esteCampo];
            echo $this->miFormulario->campoTexto($configuracion,$atributos);

            //-----------------------Campo Mensaje-----------------------
            $esteCampo="identificacion";
            $atributos["texto"]=$this->registro[0][$esteCampo];
            $atributos["etiqueta"]=$this->lenguaje[$esteCampo];
            echo $this->miFormulario->campoTexto($configuracion,$atributos);

            //-----------------------Campo Mensaje-----------------------
            $esteCampo="codigo";
            $atributos["texto"]=$this->registro[0][$esteCampo];
            $atributos["etiqueta"]=$this->lenguaje[$esteCampo];
            echo $this->miFormulario->campoTexto($configuracion,$atributos);
             //-----------------------Campo Mensaje-----------------------
            $esteCampo="correo";
            $atributos["texto"]=$this->registro[0][$esteCampo];
            $atributos["etiqueta"]=$this->lenguaje[$esteCampo];
            echo $this->miFormulario->campoTexto($configuracion,$atributos);
            ?>
            </td>
            <td><img alt=" " src="<? echo $directorio?>contenido_4_13.png" style="width: 76px;  height: 16px; border-width: 0px;"></td>
        </tr>

        <tr>
            <td><img alt=" " src="<? echo $directorio?>contenido_5_0.png" style="width: 107px;  height: 32px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_5_1.png"  style="width: 173px; height: 32px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_5_2.png"  style="width: 35px; height: 32px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_5_3.png"  style="width: 31px; height: 32px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_5_4.png"  style="width: 11px; height: 32px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_5_5.png"  style="width: 31px; height: 32px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_5_6.png"  style="width: 10px; height: 32px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_5_7.png"  style="width: 30px; height: 32px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_5_8.png"  style="width: 130px; height: 32px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_5_13.png" style="width: 76px;  height: 32px; border-width: 0px;"></td>
        </tr>

        <tr>
            <td><img alt=" " src="<? echo $directorio?>contenido_6_0.png" style="width: 107px;  height: 282px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_6_1.png"  style="width: 173px; height: 282px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_6_2.png"  style="width: 35px; height: 282px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_6_3.png"  style="width: 31px; height: 282px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_6_4.png"  style="width: 11px; height: 282px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_6_5.png"  style="width: 31px; height: 282px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_6_6.png"  style="width: 10px; height: 282px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_6_7.png"  style="width: 30px; height: 282px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_6_8.png"  style="width: 130px; height: 282px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_6_13.png" style="width: 76px;  height: 282px; border-width: 0px;"></td>
        </tr>
        <tr>
            <td><img alt=" " src="<? echo $directorio?>contenido_7_0.png" style="width: 107px;  height: 3px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_7_1.png"  style="width: 173px; height: 3px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_7_2.png"  style="width: 35px; height: 3px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_7_3.png"  style="width: 31px; height: 3px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_7_4.png"  style="width: 11px; height: 3px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_7_5.png"  style="width: 31px; height: 3px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_7_6.png"  style="width: 10px; height: 3px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_7_7.png"  style="width: 30px; height: 3px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_7_8.png"  style="width: 130px; height: 3px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_7_9.png"  style="width: 79px; height: 3px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_7_10.png"  style="width: 101px; height: 3px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_7_11.png"  style="width: 93px; height: 3px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_7_12.png"  style="width: 93px; height: 3px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_7_13.png" style="width: 76px;  height: 3px; border-width: 0px;"></td>
        </tr>
        <tr>
            <td><img alt=" " src="<? echo $directorio?>contenido_8_0.png" style="width: 107px;  height: 214px; border-width: 0px;"></td>
            <td colspan="12" rowspan="3"  style="vertical-align: top;">
                <table class="tablaContenido2" align="center">
                    <tr>
                        <td>
                            <div class="margen2">
                                <p  class="bordeAncho">
                                    <span class="textoTitulo"> Certificaciones</span><hr class="hr_division"/>
                                <ul>
                                    <li>Los estudiantes, egresados y la comunidad en general que asistan a 3 &oacute; m&aacute;s de las conferencias programadas recibir&aacute;n certificado de participaci&oacute;n en el evento.</li>
                                    <li>La coordinaci&oacute;n de carrera de I.C.G., expedir&aacute; permiso acad&eacute;mico para las conferencias programadas.</li>
                                </ul>
                                </p>
                                <p  class="bordeAncho">
                                    <span class="textoTitulo"> Costos</span><hr class="hr_division"/>
                                <ul>
                                    <li>Las actividades programadas NO tienen costo.</li>
                                </ul>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="bloquecentralnoticia">
                    <!-- Inicio Evento  -->
                    <table class="tabla_simple">
                        <tr class="bloquecentralnoticia">
                            <td>
                                <p class="centrar">
                                <p  class="bordeAncho">
                                    <span class="textoTitulo"> Informaci&oacute;n de Contacto</span><hr class="hr_division"/>
                                </p>
                                <p class="centrar">
                                    GEOCIENCIAS, MEDIO AMBIENTE Y TERRITORIO EN EL A&Ntilde;O INTERNACIONAL DE LA BIODIVERSIDAD<br>
                                    XVI Semana Catastral</p>
                                <p class="centrar">
                                    Carrera 7 No 40 - 53 Piso 5<br>
                                    Tel&eacute;fono: 3 238400 Ext: 1516<br>

                                </p>
                                <p class="centrar">
                                    <a href="mailto:semanaicg@udistrital.edu.co">semanaicg@udistrital.edu.co
                                </p>
                            </td>
                        </tr>
                    </table>

                    <!-- Fin Evento  -->

                </div>
                <div class="piePagina">
                    <p>
                        <span class="texto_negrita">Organizaci&oacute;n Semana Catastral</span><br>
                        <span class="texto_pie">
                            Universidad Distrital Francisco Jos&eacute; de Caldas. Facultad de Ingenier&iacute;a - Proyecto Curricular de Ingenier&iacute;a Catastral y Geodesia. Bogot&aacute; - Colombia. 2010
                        </span>
                    </p>
                </div>

            </td>
            <td><img alt=" " src="<? echo $directorio?>contenido_8_13.png" style="width: 76px;  height: 214px; border-width: 0px;"></td>
        </tr>
        <tr>
            <td><img alt=" " src="<? echo $directorio?>contenido_8_0.png" style="width: 107px;  height: 214px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_8_13.png" style="width: 76px;  height: 214px; border-width: 0px;"></td>
        </tr>
        <tr>
            <td><img alt=" " src="<? echo $directorio?>contenido_8_0.png" style="width: 107px;  height: 214px; border-width: 0px;"></td>
            <td><img alt=" " src="<? echo $directorio?>contenido_8_13.png" style="width: 76px;  height: 214px; border-width: 0px;"></td>
        </tr>
    </table>




    <!-- Mapas de Imagenes-->
    <map name="imagen"><?
                include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
                $cripto=new encriptar();
                $variable="pagina=index";
                $variable.="&imagenPrincipal=".$idImagenSiguiente;
                $variable=$cripto->codificar_url($variable,$configuracion);
                ?><area shape="rect" coords="0,0,166,25" href="<? echo $indice.$variable ?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('imagen','<? echo $directorio ?>/imagen<? echo ($idImagenActual)?>/enlaceCambiarImagen.png')" />
    </map>
    <map name="rss">
        <area shape="rect" coords="0,0,37,24" title="Canal RSS. Las noticias de la XVI Semana ICG en tu escritorio"  href="<?
                echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]."/rss.xml";
                      ?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('rss','<? echo $directorio ?>enlacerss.png')"/>
    </map>
    <map name="informacionConferencia"><?
            include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
            $cripto=new encriptar();
            $variable="pagina=informacionConferencia";
            $variable=$cripto->codificar_url($variable,$configuracion);
            ?><area shape="rect" coords="0,0,101,77" href="<? echo $indice.$variable ?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('imagen','<? echo $directorio ?>/imagen<? echo ($idImagenActual)?>/enlaceCambiarImagen.png')" />
    </map>
    <map name="inscripcionConferencia"><?
            include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
            $cripto=new encriptar();
            $variable="pagina=inscripcionConferencia";
            $variable=$cripto->codificar_url($variable,$configuracion);
            ?><area shape="rect" coords="0,0,101,77" href="<? echo $indice.$variable ?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('imagen','<? echo $directorio ?>/imagen<? echo ($idImagenActual)?>/enlaceCambiarImagen.png')" />
    </map>
    <map name="calendarioConferencia"><?
            include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
            $cripto=new encriptar();
            $variable="pagina=calendarioConferencia";
            $variable=$cripto->codificar_url($variable,$configuracion);
            ?><area shape="rect" coords="0,0,101,77" href="<? echo $indice.$variable ?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('imagen','<? echo $directorio ?>/imagen<? echo ($idImagenActual)?>/enlaceCambiarImagen.png')" />
    </map>
         <map name="semana"><?
            include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
            $cripto=new encriptar();
            $variable="pagina=index";
            $variable=$cripto->codificar_url($variable,$configuracion);
            ?><area shape="rect" coords="0,0,101,77" href="<? echo $indice.$variable ?>" onmouseout="imagenOriginal()" onmouseover="cambiarImagen('imagen','<? echo $directorio ?>/imagen<? echo ($idImagenActual)?>/contenido_2_1.png')" />
    </map>
    <!--Fin Mapa de Imagenes-->
    <!--Division flotante para noticias-->
            <?
            if(isset($_REQUEST["noticia"])) {
                ?><div id="divNoticia">
        <div class="cuerpoNoticia"><?

                        switch($_REQUEST["noticia"]) {

                            case "exitoInscripcion":?>
            <p class="textoTitulo texto_negrita">
                                    <? echo $this->lenguaje["encabezadoExitoInscripcion"]?>
            </p>
            <p class="textoMediano">
                                    <? echo $this->lenguaje["cuerpoExitoInscripcion"]?>
            </p>
                                <?
                                break;

                            case "usuarioExiste":?>
            <p class="textoTitulo texto_negrita">
                El Usuario ya Existe!!!
            </p>
            <p class="textoMediano">
                Por favor contacte a nuestras oficinas para que puedan habilitar su cuenta.
            </p>
                                <?
                                break;

                            case "no_usuario":?>
            <p class="textoTitulo texto_negrita">
                Usuario o Clave no encontrado.
            </p>
            <p class="textoMediano">
                Por favor reingrese el nombre de usuario y clave o solicite una cuenta desde el enlace correspondiente.
            </p>
                                <?
                                break;

                            case "logout":?>
            <p class="textoTitulo texto_negrita">
                Su sesi&oacute;n ha terminado de manera segura.
            </p>
            <p class="textoMediano">
                Gracias por utilizar nuestros servicios. Lo esperamos de nuevo en nuestro portal.
            </p>
                                <?
                                break;

                            case "varios_perfiles":?>
            <p class="textoTitulo texto_negrita">
                                    <? echo $this->lenguaje["encabezadoVariosPerfiles"]?>
            </p>
            <p class="textoMediano">
                                    <? echo $this->lenguaje["cuerpoVariosPerfiles"]?>
            </p>
                                <?
                                break;

                        }
                        ?></div>
    </div><?
            }

            ?>
    <!--Division flotante para noticias-->
</div><?

            
           

        };

    }else {
    //Mensaje de error
        echo "OOPSSSS!!!. Imposible procesar el formulario";
    }

}
?>