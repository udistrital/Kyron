<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

$nombreFormulario = $esteBloque ["nombre"];

include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton ();
//$valorCodificado ="pagina=registrarDocente";
$valorCodificado = "action=".$esteBloque ["nombre"];
$valorCodificado .= "&solicitud=procesarNuevo";
$valorCodificado .= "&bloque=".$esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=".$esteBloque ["grupo"];
$valorCodificado = $cripto->codificar ( $valorCodificado );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";

$miSesion = Sesion::singleton();

echo $miSesion->getSesionUsuarioId();


$tab = 1;

// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = $nombreFormulario;
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario ( "inicio", $atributos );

?>
<div id="wizard" class="swMain">
    <ul>
        <li><a href="#step-1">
                <span class="stepNumber">1</span>
                <span class="stepDesc">
                    Datos Basicos<br />
                    <small>Información Basico del docente</small>
                </span>
            </a>
        </li>
        <li><a href="#step-2">
                <span class="stepNumber">2</span>
                <span class="stepDesc">
                    Informaci&oacute;n Nombramiento<br />
                    <small>Detalles.....</small>
                </span>
            </a></li>
        <li><a href="#step-3">
                <span class="stepNumber">3</span>
                <span class="stepDesc">
                    Informacion Adicional<br />
                    <small>Detalles...</small>
                </span>
            </a></li>
    </ul>
    <div id="step-1">	
        <h2 class="StepTitle">Paso 1: Datos Basicos</h2>
        <?php 
        
        // //-------------Control cuadroTexto-----------------------
        $esteCampo = "numIdentificacion";
        $atributos ["id"] = $esteCampo;
        $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
        $atributos ["tabIndex"] = $tab ++;
        $atributos ["obligatorio"] = true;
        $atributos ["tamanno"] = "";
        $atributos ["tipo"] = "";
        $atributos ["estilo"] = "jqueryui";
        $atributos ["columnas"] = "1";
        $atributos ["validar"] = "required";
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset ( $atributos );

        // -------------Control cuadroTexto-----------------------
        $esteCampo = "tipoIdentificacion";
        $atributos ["id"] = $esteCampo;
        $atributos ["tabIndex"] = $tab ++;
        $atributos ["seleccion"] = 0; // 9
        $atributos ["evento"] = 2;
        $atributos ["limitar"] = false;
        $atributos ["tamanno"] = 1;
        $atributos ["estilo"] = "jqueryui";
        $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
        // -----De donde rescatar los datos -------ependencia in /usr/lo--
        $atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscartipoidentificacion" );
        $atributos ["baseDatos"] = "docencia";

        echo $this->miFormulario->campoCuadroLista ( $atributos );
        unset ( $atributos );



        // -------------Control cuadroTexto-----------------------
        $esteCampo = "nombres";
        $atributos ["id"] = $esteCampo;
        $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
        $atributos ["tabIndex"] = $tab ++;
        $atributos ["obligatorio"] = true;
        $atributos ["tamanno"] = "10";
        $atributos ["tipo"] = "";
        $atributos ["estilo"] = "jqueryui";
        $atributos ["columnas"] = "1";
        $atributos ["validar"] = "required";
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset ( $atributos );

        // //-------------Control cuadroTexto-----------------------
        $esteCampo = "apellidos";
        $atributos ["id"] = $esteCampo;
        $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
        $atributos ["tabIndex"] = $tab ++;
        $atributos ["obligatorio"] = true;
        $atributos ["tamanno"] = "10";
        $atributos ["tipo"] = "";
        $atributos ["estilo"] = "jqueryui";
        $atributos ["columnas"] = "1";
        $atributos ["validar"] = "required";
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset ( $atributos );

        // //-------------Control cuadroTexto-----------------------
        $esteCampo = "genero";
        $atributos ["id"] = $esteCampo;
        $atributos ["tabIndex"] = $tab ++;
        $atributos ["seleccion"] = 0; // 9
        $atributos ["evento"] = 2;
        $atributos ["limitar"] = false;
        $atributos ["tamanno"] = 1;
        $atributos ["estilo"] = "jqueryui";
        $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
        // -----De donde rescatar los datos -------ependencia in /usr/lo--
        $atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscargenero" );
        $atributos ["baseDatos"] = "docencia";
        echo $this->miFormulario->campoCuadroLista ( $atributos );
        unset ( $atributos );

        // //-------------Control cuadroTexto-----------------------
        $esteCampo = "fechaNacimiento";
        $atributos["id"]=$esteCampo;
        $atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
        $atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
        $atributos["tabIndex"]=$tab++;
        $atributos["obligatorio"]=false;
        $atributos["tamanno"]="10";
        $atributos["tipo"]="";
        $atributos["estilo"]="jqueryui";
        $atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
        $atributos["validar"]="minSize[3]";
        $atributos["categoria"]="fecha";
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // //-------------Control cuadroTexto-----------------------
        $esteCampo = "paisNacimiento";
        $atributos ["id"] = $esteCampo;
        $atributos ["tabIndex"] = $tab ++;
        $atributos ["seleccion"] = 0; // 9
        $atributos ["evento"] = 2;
        $atributos ["limitar"] = false;
        $atributos ["tamanno"] = 1;
        $atributos ["estilo"] = "jqueryui";
        $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
        // -----De donde rescatar los datos -------ependencia in /usr/lo--
        $atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarpais" );
        $atributos ["baseDatos"] = "docencia";
        echo $this->miFormulario->campoCuadroLista ( $atributos );
        unset ( $atributos );

        // //-------------Control cuadroTexto-----------------------
        $esteCampo = "ciudadNacimiento";
        $atributos ["id"] = $esteCampo;
        $atributos ["tabIndex"] = $tab ++;
        $atributos ["seleccion"] = 0; // 9
        $atributos ["evento"] = 2;
        $atributos ["limitar"] = false;
        $atributos ["tamanno"] = 1;
        $atributos ["estilo"] = "jqueryui";
        $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
        // -----De donde rescatar los datos -------ependencia in /usr/lo--
        $atributos ["cadena_sql"] = $this->sql->cadena_sql ( "buscarciudad" );
        $atributos ["baseDatos"] = "docencia";
        echo $this->miFormulario->campoCuadroLista ( $atributos );
        unset ( $atributos );
        
        ?>          			
    </div>
    <div id="step-2">
        <h2 class="StepTitle">Step 2: Profile Details</h2>	
        <table cellspacing="3" cellpadding="3" align="center">
            <tr>
                <td align="center" colspan="3">&nbsp;</td>
            </tr>        
            <tr>
                <td align="right">First Name :</td>
                <td align="left">
                    <input type="text" id="firstname" name="firstname" value="" class="txtBox">
                </td>
                <td align="left"><span id="msg_firstname"></span>&nbsp;</td>
            </tr>
            <tr>
                <td align="right">Last Name :</td>
                <td align="left">
                    <input type="text" id="lastname" name="lastname" value="" class="txtBox">
                </td>
                <td align="left"><span id="msg_lastname"></span>&nbsp;</td>
            </tr> 
            <tr>
                <td align="right">Gender :</td>
                <td align="left">
                    <select id="gender" name="gender" class="txtBox">
                        <option value="">-select-</option>
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>                 
                    </select>
                </td>
                <td align="left"><span id="msg_gender"></span>&nbsp;</td>
            </tr>                                   			
        </table>        
    </div>                      
    <div id="step-3">
        <h2 class="StepTitle">Step 3: Contact Details</h2>	
        <table cellspacing="3" cellpadding="3" align="center">
            <tr>
                <td align="center" colspan="3">&nbsp;</td>
            </tr>        
            <tr>
                <td align="right">Email :</td>
                <td align="left">
                    <input type="text" id="email" name="email" value="" class="txtBox">
                </td>
                <td align="left"><span id="msg_email"></span>&nbsp;</td>
            </tr>
            <tr>
                <td align="right">Phone :</td>
                <td align="left">
                    <input type="text" id="phone" name="phone" value="" class="txtBox">
                </td>
                <td align="left"><span id="msg_phone"></span>&nbsp;</td>
            </tr>          			
            <tr>
                <td align="right">Address :</td>
                <td align="left">
                    <textarea name="address" id="address" class="txtBox" rows="3"></textarea>
                </td>
                <td align="left"><span id="msg_address"></span>&nbsp;</td>
            </tr>                                   			
        </table>               				          
    </div>    
</div>