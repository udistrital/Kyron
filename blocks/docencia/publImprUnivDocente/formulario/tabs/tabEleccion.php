<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$rutaCandidatos = $this->miConfigurador->getVariableConfiguracion("host");
$rutaCandidatos.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks";
$rutaCandidatos.= $this->miConfigurador->getVariableConfiguracion("rutaCandidatos");

$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");

$directorioEnlace = $this->miConfigurador->getVariableConfiguracion("host");
$directorioEnlace.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorioEnlace.=$this->miConfigurador->getVariableConfiguracion("enlace");

include_once("core/crypto/Encriptador.class.php");
$cripto=Encriptador::singleton();
$valorCodificado="action=".$esteBloque["nombre"];
$valorCodificado.="&opcion=guardarEleccion"; 
$valorCodificado.="&bloque=".$esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
$valorCodificado=$cripto->codificar($valorCodificado);
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

$miSesion = Sesion::singleton();
$nombreFormulario="Eleccion".$idEleccion;

$arrayEleccion = array($proceso, $idEleccion);

$this->cadena_sql = $this->sql->cadena_sql("consultaEleccion", $arrayEleccion);
$resultadoEleccion = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");

if($resultadoEleccion)
    {
        $tab=1;
        //---------------Inicio Formulario (<form>)--------------------------------
        $atributos["id"]=$nombreFormulario;
        $atributos["tipoFormulario"]="multipart/form-data";
        $atributos["metodo"]="POST";
        $atributos["nombreFormulario"]=$nombreFormulario;
        $atributos["titulo"]=$nombreFormulario;
        echo $this->miFormulario->formulario("inicio",$atributos); 
        unset($atributos);
       
    //-------------Control cuadroTexto-----------------------
	$esteCampo="nombreEleccion".$idEleccion;
	$atributos["id"]=$esteCampo;
        $atributos["obligatorio"]=true;
        $atributos["estilo"]="textoTitulo textoJustificar";
        $atributos["columnas"]=1;
	$atributos["texto"]="Nombre de la elección: ".$resultadoEleccion[0]['nombre'];
	echo $this->miFormulario->campoTexto($atributos);
	unset($atributos);
        
        //------------------Control Lista Desplegable------------------------------
        $esteCampo = "tipoestamento".$idEleccion;
        $atributos["id"] = $esteCampo;
        $atributos["tabIndex"] = $tab++;        
        $atributos["evento"] = 2;
        //$atributos["seleccion"] = 0;
        $atributos["columnas"] = "1";
        $atributos["limitar"] = false;
        $atributos["tamanno"] = 1;
        $atributos["ancho"] = "250px";
        $atributos["estilo"] = "jqueryui";
        $atributos["etiquetaObligatorio"] = true;
        $atributos["validar"] = "required";
        $atributos["anchoEtiqueta"] = 250;
        $atributos["obligatorio"] = true;
        $atributos["etiqueta"] = "Tipo de estamento: ";
        
        if($resultadoEleccion)
            {
                $atributos["deshabilitado"] = true;
                $atributos["seleccion"] = $resultadoEleccion[0]['tipoestamento'];
            }
        
        //-----De donde rescatar los datos ---------
        $atributos["cadena_sql"] = $this->sql->cadena_sql("tipoestamento");
        $atributos["baseDatos"] = "estructura";
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);
        
        //-------------Control cuadroTexto-----------------------
	$esteCampo="descripcion".$idEleccion;
	$atributos["id"]=$esteCampo;
        $atributos["obligatorio"]=true;
        $atributos["estilo"]="textoTitulo textoJustificar";
        $atributos["columnas"]=1;
	$atributos["texto"]="Descripción de la elección: ".$resultadoEleccion[0]['descripcion'];
	echo $this->miFormulario->campoTexto($atributos);
	unset($atributos);
        
        $this->cadena_sql = $this->sql->cadena_sql("consultaFechaProceso", $arrayEleccion);
        $resultadoFechas = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");
        
        ?>
        <input type="hidden" name="fechainiProceso<?php echo $idEleccion?>" id="fechainiProceso<?php echo $idEleccion?>" value="<?php echo $resultadoFechas[0]['fechainicio']?>">
        <input type="hidden" name="fechafinProceso<?php echo $idEleccion?>" id="fechafinProceso<?php echo $idEleccion?>" value="<?php echo $resultadoFechas[0]['fechafin']?>">
        <?php
   
        
    //-------------Control cuadroTexto-----------------------
	$esteCampo="fechaInicio".$idEleccion;
	$atributos["id"]=$esteCampo;
        $atributos["obligatorio"]=true;
        $atributos["estilo"]="textoTitulo textoJustificar";
        $atributos["columnas"]=1;
	$atributos["texto"]="Fecha de inicio de la elección: ".$resultadoEleccion[0]['fechainicio'];
	echo $this->miFormulario->campoTexto($atributos);
	unset($atributos); 
        
        //-------------Control cuadroTexto-----------------------
	$esteCampo="fechaFin".$idEleccion;
	$atributos["id"]=$esteCampo;
        $atributos["obligatorio"]=true;
        $atributos["estilo"]="textoTitulo textoJustificar";
        $atributos["columnas"]=1;
	$atributos["texto"]="Fecha de finalización de la elección: ".$resultadoEleccion[0]['fechafin'];
	echo $this->miFormulario->campoTexto($atributos);
	unset($atributos);  
              
        //------------------Control Lista Desplegable------------------------------
        $esteCampo = "restricciones".$idEleccion;
        $atributos["id"] = $esteCampo;
        $atributos["obligatorio"]=true;
        $atributos["estilo"]="textoTitulo textoJustificar";
        $atributos["columnas"]=1;
        $atributos["texto"] = "Restricciones: ".$resultadoEleccion[0]['restricciones'];
        echo $this->miFormulario->campoTexto($atributos);
        unset($atributos);
        
        //------------------Control Lista Desplegable------------------------------
        $esteCampo = "segundaClave".$idEleccion;
        $atributos["id"] = $esteCampo;
        $atributos["obligatorio"]=true;
        $atributos["estilo"]="textoTitulo textoJustificar";
        $atributos["columnas"]=1;
        
                if($resultadoEleccion[0]['utilizarsegundaclave'] == 1)
                    {
                        $atributos["texto"] = "Segunda Clave: Si";                        
                    }else
                        {
                            $atributos["texto"] = "Segunda Clave: No";      
                        }
        echo $this->miFormulario->campoTexto($atributos);
        unset($atributos);
        
        //------------------Control Lista Desplegable------------------------------
        $esteCampo = "tipovotacion".$idEleccion;
        $atributos["id"] = $esteCampo;
        $atributos["tabIndex"] = $tab++;
        $atributos["seleccion"] = 0;
        $atributos["evento"] = 2;
        $atributos["columnas"] = "1";
        $atributos["limitar"] = false;
        $atributos["tamanno"] = 1;
        $atributos["ancho"] = "250px";
        $atributos["estilo"] = "jqueryui";
        $atributos["etiquetaObligatorio"] = true;
        $atributos["validar"] = "required";
        $atributos["anchoEtiqueta"] = 250;
        $atributos["obligatorio"] = true;
        $atributos["etiqueta"] = "Tipo de Votación";
        if($resultadoEleccion)
            {
                $atributos["deshabilitado"] = true;
                $atributos["seleccion"] = $resultadoEleccion[0]['tipovotacion'];
            }
        //-----De donde rescatar los datos ---------
        $atributos["cadena_sql"] = $this->sql->cadena_sql("tipovotacion");
        $atributos["baseDatos"] = "estructura";
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);
    }else
        {
            $tab=1;
            //---------------Inicio Formulario (<form>)--------------------------------
            $atributos["id"]=$nombreFormulario;
            $atributos["tipoFormulario"]="multipart/form-data";
            $atributos["metodo"]="POST";
            $atributos["nombreFormulario"]=$nombreFormulario;
            $atributos["titulo"]=$nombreFormulario;
            echo $this->miFormulario->formulario("inicio",$atributos); 
            unset($atributos);

        //-------------Control cuadroTexto-----------------------
            $esteCampo="nombreEleccion".$idEleccion;
            $atributos["id"]=$esteCampo;
            $atributos["etiqueta"]="Digite el nombre de la elección: ";
            $atributos["titulo"]="Digite el nombre de la elección ";
            $atributos["tabIndex"]=$tab++;
            $atributos["obligatorio"]=true;
            $atributos["tamanno"]=40;
            $atributos["columnas"] = 1;
            $atributos["etiquetaObligatorio"] = false;
            $atributos["tipo"]="";
            $atributos["estilo"]="jqueryui";
            $atributos["anchoEtiqueta"] = 250;
            $atributos["validar"]="required, minSize[5]";
            $atributos["categoria"]="";
            $atributos["evento"]=" OnkeyUp=\"cambiarTitulo('".$idEleccion."');\" ";
            if($resultadoEleccion)
                {
                    $atributos["deshabilitado"] = true;
                    $atributos["valor"] = $resultadoEleccion[0]['nombre'];
                }
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            //------------------Control Lista Desplegable------------------------------
            $esteCampo = "tipoestamento".$idEleccion;
            $atributos["id"] = $esteCampo;
            $atributos["tabIndex"] = $tab++;        
            $atributos["evento"] = 2;
            //$atributos["seleccion"] = 0;
            $atributos["columnas"] = "1";
            $atributos["limitar"] = false;
            $atributos["tamanno"] = 1;
            $atributos["ancho"] = "250px";
            $atributos["estilo"] = "jqueryui";
            $atributos["etiquetaObligatorio"] = true;
            $atributos["validar"] = "required";
            $atributos["anchoEtiqueta"] = 250;
            $atributos["obligatorio"] = true;
            $atributos["etiqueta"] = "Tipo de estamento: ";

            if($resultadoEleccion)
                {
                    $atributos["deshabilitado"] = true;
                    $atributos["seleccion"] = $resultadoEleccion[0]['tipoestamento'];
                }

            //-----De donde rescatar los datos ---------
            $atributos["cadena_sql"] = $this->sql->cadena_sql("tipoestamento");
            $atributos["baseDatos"] = "estructura";
            echo $this->miFormulario->campoCuadroLista($atributos);
            unset($atributos);

            //-------------Control cuadroTexto-----------------------
            $esteCampo="descripcion".$idEleccion;
            $atributos["id"]=$esteCampo;
            $atributos["etiqueta"]="Digite la descripción de la elección: ";
            $atributos["titulo"]="Digite la descripción de la elección ";
            $atributos["tabIndex"]=$tab++;
            $atributos["obligatorio"]=true;
            $atributos["tamanno"]=40;
            $atributos["etiquetaObligatorio"] = true;
            $atributos["tipo"]="";
            $atributos["estilo"]="jqueryui";
            $atributos["anchoEtiqueta"] = 250;
            $atributos["validar"]="required, minSize[5]";
            $atributos["categoria"]="";
            if($resultadoEleccion)
                {
                    $atributos["deshabilitado"] = true;
                    $atributos["valor"] = $resultadoEleccion[0]['descripcion'];
                }
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            $this->cadena_sql = $this->sql->cadena_sql("consultaFechaProceso", $arrayEleccion);
            $resultadoFechas = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");

            ?>
            <input type="hidden" name="fechainiProceso<?php echo $idEleccion?>" id="fechainiProceso<?php echo $idEleccion?>" value="<?php echo $resultadoFechas[0]['fechainicio']?>">
            <input type="hidden" name="fechafinProceso<?php echo $idEleccion?>" id="fechafinProceso<?php echo $idEleccion?>" value="<?php echo $resultadoFechas[0]['fechafin']?>">
            <?php


        //-------------Control cuadroTexto-----------------------
            $esteCampo="fechaInicio".$idEleccion;
            $atributos["id"]=$esteCampo;
            $atributos["etiqueta"]="Fecha de inicio de la elección: ";
            $atributos["titulo"]="Fecha de inicio de la elección ";
            $atributos["tabIndex"]=$tab++;
            $atributos["obligatorio"]=true;
            $atributos["tamanno"]=25;
            $atributos["etiquetaObligatorio"] = true;
            $atributos["deshabilitado"] = true;
            $atributos["tipo"]="";
            $atributos["estilo"]="jqueryui";
            $atributos["anchoEtiqueta"] = 250;
            $atributos["validar"] = "required";
            $atributos["categoria"]="fecha";
            if($resultadoEleccion)
                {
                    $atributos["deshabilitado"] = true;
                    $atributos["valor"] = $resultadoEleccion[0]['fechainicio'];
                }
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos); 

            //-------------Control cuadroTexto-----------------------
            $esteCampo="fechaFin".$idEleccion;
            $atributos["id"]=$esteCampo;
            $atributos["etiqueta"]="Fecha de finalización de la elección: ";
            $atributos["titulo"]="Fecha de finalización de la elección ";
            $atributos["tabIndex"]=$tab++;
            $atributos["obligatorio"]=true;
            $atributos["tamanno"]=25;
            $atributos["etiquetaObligatorio"] = true;
            $atributos["deshabilitado"] = true;
            $atributos["tipo"]="";
            $atributos["estilo"]="jqueryui";
            $atributos["anchoEtiqueta"] = 250;
            $atributos["validar"]="required";
            $atributos["categoria"]="fecha";
            if($resultadoEleccion)
                {
                    $atributos["deshabilitado"] = true;
                    $atributos["valor"] = $resultadoEleccion[0]['fechafin'];
                }
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);  

            //------------------Control Lista Desplegable------------------------------
            $esteCampo = "restricciones".$idEleccion;
            $atributos["id"] = $esteCampo;
            $atributos["nombre"] = "restricciones".$idEleccion."[]";
            $atributos["tabIndex"] = $tab++;
            $atributos["seleccion"] = 0;
            $atributos["evento"] = 2;
            $atributos["columnas"] = "1";
            $atributos["limitar"] = false;
            $atributos["tamanno"] = 1;
            $atributos["ancho"] = 550;
            $atributos["estilo"] = "jqueryui";
            $atributos["etiquetaObligatorio"] = true;
            $atributos["anchoEtiqueta"] = 250;
            $atributos["validar"] = "required,minListOptions[1]";
            $atributos["multiple"] = true;
            $atributos["obligatorio"] = true;
            $atributos["etiqueta"] = "Restricciones";

            if($resultadoEleccion)
                {
                    $atributos["deshabilitado"] = true;
                    $atributos["seleccion"] = $resultadoEleccion[0]['restricciones'];
                }
            //-----De donde rescatar los datos ---------
            $atributos["cadena_sql"] = $this->sql->cadena_sql("datosRestricciones");
            $atributos["baseDatos"] = "estructura";
            echo $this->miFormulario->campoCuadroLista($atributos);
            unset($atributos);

            //------------------Control Lista Desplegable------------------------------
            $esteCampo = "segundaClave".$idEleccion;
            $atributos["id"] = $esteCampo;
            $atributos["nombre"] = $esteCampo;
            $atributos["tabIndex"] = $tab++;
            $atributos["etiquetaObligatorio"] = true;
            $atributos["anchoEtiqueta"] = 250;
            $atributos["validar"] = "required";
            $atributos["obligatorio"] = true;
            $atributos["etiqueta"] = "Uso segunda clave:";
            if($resultadoEleccion)
                {
                    $atributos["deshabilitado"] = true;
                    $atributos["seleccionado"] = true;
                    if($resultadoEleccion[0]['utilizarsegundaclave'] == 1)
                        {
                            $atributos["valor"] = "on";                        
                        }else
                            {
                                $atributos["valor"] = "off";   
                            }

                }
            echo $this->miFormulario->campoCuadroSeleccion($atributos);
            unset($atributos);

            //------------------Control Lista Desplegable------------------------------
            $esteCampo = "tipovotacion".$idEleccion;
            $atributos["id"] = $esteCampo;
            $atributos["tabIndex"] = $tab++;
            $atributos["seleccion"] = 0;
            $atributos["evento"] = 2;
            $atributos["columnas"] = "1";
            $atributos["limitar"] = false;
            $atributos["tamanno"] = 1;
            $atributos["ancho"] = "250px";
            $atributos["estilo"] = "jqueryui";
            $atributos["etiquetaObligatorio"] = true;
            $atributos["validar"] = "required";
            $atributos["anchoEtiqueta"] = 250;
            $atributos["obligatorio"] = true;
            $atributos["etiqueta"] = "Tipo de Votación";
            if($resultadoEleccion)
                {
                    $atributos["deshabilitado"] = true;
                    $atributos["seleccion"] = $resultadoEleccion[0]['tipovotacion'];
                }
            //-----De donde rescatar los datos ---------
            $atributos["cadena_sql"] = $this->sql->cadena_sql("tipovotacion");
            $atributos["baseDatos"] = "estructura";
            echo $this->miFormulario->campoCuadroLista($atributos);
            unset($atributos);
        }
        
        
        
        //------------------Division para los botones-------------------------
        $atributos["id"]="gestionar";
        $atributos["estilo"]="marcoBotones";
        echo $this->miFormulario->division("inicio",$atributos);

 
        //-----------------Inicio de Conjunto de Controles----------------------------------------
        $esteCampo = "marcoDatosCandidatos";
        $atributos["estilo"] = "jqueryui";
        $atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
        echo $this->miFormulario->marcoAgrupacion("inicio", $atributos);
        unset($atributos);
        
        if($resultadoEleccion)
            {
                $arrayCandidatos = array($proceso, $resultadoEleccion[0]['ideleccion']);

                $this->cadena_sql = $this->sql->cadena_sql("consultaCandidatos", $arrayCandidatos);
                $resultadoCandidatos = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");
            
            }
        
        
        ?>
<div id="scroll">
    <table id="tablaCandidatos<?php echo $idEleccion?>" width="100%">
	<!-- Cabecera de la tabla -->
	<thead>
            <?php
                
                if($resultadoEleccion)
                {                    
                ?>
		<tr>
                    <th>Lista</th>
                    <th>Posición</th>
                    <th>Identificación</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Foto</th>
		</tr>
                <?php
                }else
                    {
                        ?>
                        <tr>
                            <th>Lista</th>
                            <th>Posición</th>
                            <th>Identificación</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Foto</th>
                            <th>Borrar</th>
                        </tr>
                        <?php
                    }
                ?>
	</thead>
 
	<!-- Cuerpo de la tabla con los campos -->
	<tbody> 
            
                <?php
                
                if($resultadoEleccion)
                {
                    if($resultadoCandidatos)
                    {
                        for($can = 0; $can < count($resultadoCandidatos); $can++)
                        {
                            ?>
                                
                            <tr>
                                <td>
                                    <?php echo $resultadoCandidatos[$can][0]?>
                                </td>
                                <td>
                                    <?php echo $resultadoCandidatos[$can][1]?>
                                </td>
                                <td>
                                    <?php echo $resultadoCandidatos[$can][2]?>
                                </td>
                                <td>
                                    <?php echo $resultadoCandidatos[$can][3]?>
                                </td>
                                <td>
                                    <?php echo $resultadoCandidatos[$can][4]?>
                                </td>
                                <td>
                                    <img src='<?php echo $rutaCandidatos.$resultadoCandidatos[$can][5]?>' width="150px"></img>
                                </td>
                            </tr>        
            
                            <?
                        }
                    }
                }
                ?>
               	<!-- fila base para clonar y agregar al final -->
		<tr class="fila-base">
                        <td>
                            <?php                             
                            //-------------Control cuadroTexto-----------------------
                            $esteCampo="nombreLista".$idEleccion."[]";
                            $atributos["id"]=$esteCampo;
                            $atributos["tabIndex"]=$tab++;
                            $atributos["obligatorio"]=true;
                            $atributos["tamanno"]=10;
                            $atributos["columnas"] = 1;
                            $atributos["etiquetaObligatorio"] = false;
                            $atributos["tipo"]="";
                            $atributos["estilo"]="jqueryui";
                            $atributos["anchoEtiqueta"] = 250;
                            $atributos["validar"]="required, minSize[3]";
                            $atributos["categoria"]="";
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                            
                            ?>
                            <!--<input type="text" class="identificacion" name='identificacion<?php echo $idEleccion;?>[]' id='identificacion<?php echo $idEleccion;?>[]'/>-->
                        </td>
			<td>
                            <?php                             
                            //-------------Control cuadroTexto-----------------------
                            $esteCampo="posicionLista".$idEleccion."[]";
                            $atributos["id"]=$esteCampo;
                            $atributos["tabIndex"]=$tab++;
                            $atributos["obligatorio"]=true;
                            $atributos["tamanno"]=2;
                            $atributos["columnas"] = 1;
                            $atributos["etiquetaObligatorio"] = false;
                            $atributos["tipo"]="";
                            $atributos["estilo"]="jqueryui";
                            $atributos["anchoEtiqueta"] = 250;
                            $atributos["validar"]="required, custom[integer]";
                            $atributos["categoria"]="";
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                            
                            ?>
                            <!--<input type="text" class="nombres" name='nombres<?php echo $idEleccion;?>[]' id='nombres<?php echo $idEleccion;?>[]' />-->
                        </td>
			<td>
                            <?php                             
                            //-------------Control cuadroTexto-----------------------
                            $esteCampo="identificacion".$idEleccion."[]";
                            $atributos["id"]=$esteCampo;
                            $atributos["tabIndex"]=$tab++;
                            $atributos["obligatorio"]=true;
                            $atributos["tamanno"]=15;
                            $atributos["columnas"] = 1;
                            $atributos["etiquetaObligatorio"] = false;
                            $atributos["tipo"]="";
                            $atributos["estilo"]="jqueryui";
                            $atributos["anchoEtiqueta"] = 250;
                            $atributos["validar"]="required, minSize[5], custom[integer]";
                            $atributos["categoria"]="";
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                            
                            ?>
                            <!--<input type="text" class="identificacion" name='identificacion<?php echo $idEleccion;?>[]' id='identificacion<?php echo $idEleccion;?>[]'/>-->
                        </td>
			<td>
                            <?php                             
                            //-------------Control cuadroTexto-----------------------
                            $esteCampo="nombres".$idEleccion."[]";
                            $atributos["id"]=$esteCampo;
                            $atributos["tabIndex"]=$tab++;
                            $atributos["obligatorio"]=true;
                            $atributos["tamanno"]=15;
                            $atributos["columnas"] = 1;
                            $atributos["etiquetaObligatorio"] = false;
                            $atributos["tipo"]="";
                            $atributos["estilo"]="jqueryui";
                            $atributos["anchoEtiqueta"] = 250;
                            $atributos["validar"]="required, minSize[5]";
                            $atributos["categoria"]="";
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                            
                            ?>
                            <!--<input type="text" class="nombres" name='nombres<?php echo $idEleccion;?>[]' id='nombres<?php echo $idEleccion;?>[]' />-->
                        </td>
			<td>
                            <?php                             
                            //-------------Control cuadroTexto-----------------------
                            $esteCampo="apellidos".$idEleccion."[]";
                            $atributos["id"]=$esteCampo;
                            $atributos["tabIndex"]=$tab++;
                            $atributos["obligatorio"]=true;
                            $atributos["tamanno"]=15;
                            $atributos["columnas"] = 1;
                            $atributos["etiquetaObligatorio"] = false;
                            $atributos["tipo"]="";
                            $atributos["estilo"]="jqueryui";
                            $atributos["anchoEtiqueta"] = 250;
                            $atributos["validar"]="required, minSize[5]";
                            $atributos["categoria"]="";
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                            
                            ?>
                            <!--<input type="text" class="apellidos" name='apellidos<?php echo $idEleccion;?>[]' id='apellidos<?php echo $idEleccion;?>[]' />-->
                        </td>			
			<td>
                            <input type='file' name='foto[]' id='foto[]' class="validate[required]">
                        </td>			
			<td class="eliminar"><img src='<?php echo $rutaBloque."/images/cancel.png"?>'></td>
		</tr>
		<!-- fin de código: fila base -->
	</tbody>
</table>
</div>
<?php

if(!$resultadoEleccion)
{
?>
<!-- Botón para agregar filas -->
<input type="button" id="agregar<?php echo $idEleccion?>" value="Agregar Candidato" onclick="agregarfila('<?php echo $idEleccion?>')" />
<?php
}
?>        
        <?php
        //Fin de Conjunto de Controles
        echo $this->miFormulario->marcoAGrupacion("fin");
        
        //------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");
        
        
        //------------------Division para los botones-------------------------
        $atributos["id"]="botones";
        $atributos["estilo"]="marcoBotones";
        echo $this->miFormulario->division("inicio",$atributos);
        
        if(!$resultadoEleccion)
            {
                //-------------Control Boton-----------------------
                $esteCampo="guardar";
                $atributos["id"]=$esteCampo;
                $atributos["tabIndex"]=$tab++;
                $atributos["tipo"]="boton";
                $atributos["estilo"]="jqueryui";
                $atributos["verificar"]="true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
                $atributos["tipoSubmit"]="jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                $atributos["valor"]="Guardar Elección";
                $atributos["nombreFormulario"]=$nombreFormulario;
                echo $this->miFormulario->campoBoton($atributos);
                unset($atributos);
            }
        //-------------Fin Control Boton----------------------

        //------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");
               
        //-------------Control cuadroTexto con campos ocultos-----------------------
	//Para pasar variables entre formularios o enviar datos para validar sesiones
	$atributos["id"]="formSaraData"; //No cambiar este nombre
	$atributos["tipo"]="hidden";
	$atributos["obligatorio"]=false;
	$atributos["etiqueta"]="";
	$atributos["valor"]=$valorCodificado;
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);
        
        //-------------Control cuadroTexto con campos ocultos-----------------------
	//Para pasar variables entre formularios o enviar datos para validar sesiones
	$atributos["id"]="idEleccion"; //No cambiar este nombre
	$atributos["tipo"]="hidden";
	$atributos["obligatorio"]=false;
	$atributos["etiqueta"]="";
	$atributos["valor"]=$idEleccion;
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);
   	
        //Fin del Formulario
        echo $this->miFormulario->formulario("fin");


?>
