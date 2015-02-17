<?php
if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}
/**
 * Este script está incluido en el método html de la clase Frontera.class.php.
 * 
 *  La ruta absoluta del bloque está definida en $this->ruta
 */
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$nombreFormulario = $esteBloque["nombre"];

$valorCodificado = "action=" . $esteBloque["nombre"];
$valorCodificado.="&bloque=" . $esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=" . $esteBloque["grupo"];
$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);
$directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");

$tab = 1;
?>

    <style>
        .noticia_index {
            border: 0 solid gray;
            color: DarkSlateGray;
            font-family: Helvetica;
            font-size: 10pt;
            font-weight: normal;
            width: 100%;
        }
        .Estilo6 {
            font-family: Helvetica;
            font-size: 12px;
        }
        .input {
            border-collapse: collapse;
        }
        .menu {
            color: DarkSlateGray;
            font-family: Arial;
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
        }
    </style>

    <BODY onLoad="inicio();">

    <center>
        <table class='centrar'  width="1024px" height="640px" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td width="200px" height="300px">
                    <div style=' border:0px solid; width:250px; height:225px; cursor:pointer;' onclick="location.href='http://www.udistrital.edu.co'">
                        <img src="<?= $directorio ?>formulario/sabio.png" align="bottom" border="0" />
                    </div>
                </td>
                <td colspan="3" valign="top" align='left' >

                    <div name="menu_ayuda" style="position: relative; width: 130px; top: 20px; left: 10px; cursor: pointer; color: DarkSlateGray;" id="menu_ayuda" class="menu" onmouseout="salirMenu(this.id);" onmouseover="llamarMenu(this.id);">	
                        Ayuda
                    </div>
                    <div name="menu_otros" style="position: relative; width: 130px; top: 1px; left: 160px; cursor: pointer; color: DarkSlateGray;" id="menu_otros" class="menu" onmouseout="salirMenu(this.id);" onmouseover="llamarMenu(this.id);">	
                        Otros Accesos
                    </div>	
                    <div name="menu_info" style="position: relative; width: 130px; top: -18px; left: 350px; cursor: pointer; color: DarkSlateGray;" id="menu_info" class="menu" onmouseout="salirMenu(this.id);" onmouseover="llamarMenu(this.id);">	
                        Informaci&oacute;n
                    </div>																				
                    <div id='mensaje' class='mensaje'>
                        <br><br>
                        <center>Importante!!! Para que este sitio funcione correctamente es necesario activar el contenido JavaScript en su explorador.</center>

                    </div> 
                    <div name="condor" style="position: relative; width: 200px; top: 60px; left: 380px; cursor: pointer; color: DarkSlateGray;" id="condor" >	
                        <img src="<?= $directorio ?>formulario/condor.png" width='250' height='120' border="0" align='center' />
                    </div>
                </td> 
            </tr>
            <tr>
                <td width="200px" height="125px">&nbsp;
                </td>		
                <td width="320px">&nbsp; </td>		
                <td width="480px" rowspan="2" valign="top">
                    
                    <form id="login" name="login" method="post" enctype="multipart/form-data">
                        <table width="100%" height="100%"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#7A8180" style="border-collapse: collapse">
                            <tr> <td align="left">
                                    <span class="Estilo6"><b>INGRESE SUS DATOS DE USUARIO</b></span>
                                </td>
                            </tr>
                            <tr>    
                                <td width="100%" >

                                    <table width="100%" border=0 align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
                                        <tr>
                                            <td colspan="4" height="25px" align="left">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="60px"><span class="Estilo6">Usuario:&nbsp;</span></td>
                                            <td colspan="3"><input name="usuario" id="usuario" type="text" value="1022350133" class="input validate[required, custom[integer]] datepicker " size="30" onKeypress="if(event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"></td>
                                        </tr>
                                        <tr>
                                            <td align="left"><span class="Estilo6">Clave:&nbsp;</span></td>
                                            <td colspan="3">
                                                <input name="clave" type="password" class="input" id="clave" value="sistemasoas" name="clave" size="30">

                                            </td>
                                        </tr>

                                        <tr> 
                                            <td align="center">&nbsp;</td> 
                                            <td align="left" colspan="2" height="40px">
                                                <input name="submit" type="submit" value=" Entrar " class="Estilo6  validate[required] datepicker " onClick="enviarDatos();" style="height:22; width:90; cursor:pointer" >
                                            </td>
                                        </tr>
                                        <div class="campoCuadroTexto">
                                            <input id="formSaraData" type="hidden" value="<?= $valorCodificado ?>" name="formSaraData">
                                        </div>

                                    </table>

                                </td>
                            </tr>
                            <tr> <td align="left" height="150px">
                                    &nbsp;
                                </td>
                            </tr>
                        </table>
                    </form>

                </td>
                <td width="">
                </td>		  		
            </tr>
            <tr align="center">
                <td colspan="2" valign="top" >
                    <table  width="100%" border='0' height="100%">
                        <tr>
                            <td width="5px"> 
                            </td>	
                            <td width="300px" valign="top">

                                <table width="100%"  border="0" cellpadding="0" cellspacing="0" align="center">
                                    <tr>
                                        <td valign="top"> 
                                            <!--///NOTICONDOR/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                                            <div id='noticias' name='noticias'>

                                                <br>
                                                <div class='noticia_index'>                    
                                                    Por favor registre la fecha de grado de secundaria a través del menú Datos Personales.
                                                    <br><br>                         
                                                </div>
                                                <div class='noticia_index'>

                                                    <b>Fechas Calendario Académico 2013-2 para Estudiantes.</b>
                                                    <a  href="calendario_estudiantes_2013-2.pdf" >Descargar...</a>.
                                                </div>

                                            </div>

                                            </div>
                                        </td>
                                    </tr>
                                </table>

                            </td>
                            <td align="right">
                                <br><br><br><br>
                                </table-->
                            </td>
                        </tr>
                    </table>
                </td>	
                <td colspan="2" >

                </td>
            </tr>	
        </table>
    </center>
</body>
<script LANGUAGE="JavaScript">
        function inicio()
        { document.getElementById('mensaje').style.display = 'none';
            document.forms['login'].elements['s8CYStjA9dtjDiS2VnStAVIYuVoNmWhIi-Wpm8v7Cgo'].focus();
        }								
</script>
