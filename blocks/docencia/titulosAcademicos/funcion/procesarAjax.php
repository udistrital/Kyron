<?php

/**
 * * Importante: Si se desean los datos del bloque estos se encuentran en el arreglo $esteBloque
 */
$directorioImagenes = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/images";

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


if (!$esteRecursoDB) {
	//Este se considera un error fatal
	exit;
}
switch($_REQUEST["funcion"]){

	case "#tipo_titulo":
            
            if($_REQUEST['docente'] != '' && $_REQUEST['tipoTitulo'] != '')
	    {
                $arreglo = array($_REQUEST['docente'],$_REQUEST['tipoTitulo']);

                $cadena_sql = $this->sql->cadena_sql("validarPregradoDocente", $arreglo);
                $registroPregrado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                
                if(is_array($registroPregrado))
                    {                    
                        switch ($_REQUEST['tipoTitulo'])
                        {
                            case '1':

                                $cadena_sql = $this->sql->cadena_sql("buscarTitulosDocente", $arreglo);
                                $registroTitulos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

                                if(is_array($registroTitulos))
                                    {
                                        switch (count($registroTitulos)) {
                                            case 1:
                                                $respuesta = "registrar_2Pre";
                                                break;
                                            default:
                                                $respuesta = "registrar_MasPre";
                                                break;
                                        }
                                    }else
                                        {
                                            $respuesta = "registrar_1Pre";
                                        }

                                break;
                            case '2':

                                $cadena_sql = $this->sql->cadena_sql("buscarTitulosDocente", $arreglo);
                                $registroTitulos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

                                if(is_array($registroTitulos))
                                    {
                                        switch (count($registroTitulos)) {
                                            case 1:
                                                $respuesta = "registrar_2Esp";
                                                break;
                                            default:
                                                $respuesta = "registrar_MasEsp";
                                                break;
                                        }
                                    }else
                                        {
                                            $respuesta = "registrar_1Esp";
                                        }

                                break;
                            case '3':

                                $cadena_sql = $this->sql->cadena_sql("buscarTitulosDocente", $arreglo);
                                $registroTitulos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

                                if(is_array($registroTitulos))
                                    {
                                        switch (count($registroTitulos)) {
                                            case 1:
                                                $respuesta = "registrar_2Mae";
                                                break;
                                            default:
                                                $respuesta = "registrar_MasMae";
                                                break;
                                        }
                                    }else
                                        {
                                            $respuesta = "registrar_1Mae";
                                        }


                                break;
                            case '4':

                                $cadena_sql = $this->sql->cadena_sql("buscarTitulosDocente", $arreglo);
                                $registroTitulos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

                                if(is_array($registroTitulos))
                                    {
                                        switch (count($registroTitulos)) {
                                            case 1:
                                                $respuesta = "registrar_2Doc";
                                                break;
                                            default:
                                                $respuesta = "registrar_MasDoc";
                                                break;
                                        }
                                    }else
                                        {
                                            $cadena_sql = $this->sql->cadena_sql("validarMaestriaDocente", $arreglo);
                                            $registroMaestrias = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

                                            if(is_array($registroMaestrias))
                                                {
                                                    $respuesta = "registrar_1Doc";
                                                }else
                                                    {
                                                        $respuesta = "registrar_1DocSinMae";
                                                    }

                                        }


                                break;

                        }


                    }else
                        {
                            $respuesta = "registrar_1Pre";
                        }
            }
            
        break;
        
        
	case "#tipo_tituloModificar":
            
        /*if($_REQUEST['tipoTitulo'] != $_REQUEST['tipoTituloActual'])    
        { */   
            if($_REQUEST['docente'] != '' && $_REQUEST['tipoTitulo'] != '')
	    {
                $arreglo = array($_REQUEST['docente'],$_REQUEST['tipoTitulo']);

                $cadena_sql = $this->sql->cadena_sql("validarPregradoDocente", $arreglo);
                $registroPregrado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                
                if(count($registroPregrado) == 1 && $_REQUEST['tipoTituloActual'] != 1)
                {
                    if(is_array($registroPregrado))
                    {                                            
                        switch ($_REQUEST['tipoTitulo'])
                        {
                            case '1':

                                $cadena_sql = $this->sql->cadena_sql("buscarTitulosDocente", $arreglo);
                                $registroTitulos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                                
                                if(is_array($registroTitulos))
                                    {
                                        switch (count($registroTitulos)) {
                                            case 1:
                                                $respuesta = "registrar_2Pre";
                                                break;
                                            default:
                                                $respuesta = "registrar_MasPre";
                                                break;
                                        }
                                    }else
                                        {
                                            $respuesta = "registrar_1Pre";
                                        }

                                break;
                            case '2':

                                $cadena_sql = $this->sql->cadena_sql("buscarTitulosDocente", $arreglo);
                                $registroTitulos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                                
                                if(is_array($registroTitulos))
                                    {
                                        switch (count($registroTitulos)) {
                                            case 1:
                                                $respuesta = "registrar_2Esp";
                                                break;
                                            default:
                                                $respuesta = "registrar_MasEsp";
                                                break;
                                        }
                                    }else
                                        {
                                            $respuesta = "registrar_1Esp";
                                        }

                                break;
                            case '3':

                                $cadena_sql = $this->sql->cadena_sql("buscarTitulosDocente", $arreglo);
                                $registroTitulos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

                                if(is_array($registroTitulos))
                                    {
                                        switch (count($registroTitulos)) {
                                            case 1:
                                                $respuesta = "registrar_2Mae";
                                                break;
                                            default:
                                                $respuesta = "registrar_MasMae";
                                                break;
                                        }
                                    }else
                                        {
                                            $respuesta = "registrar_1Mae";
                                        }


                                break;
                            case '4':

                                $cadena_sql = $this->sql->cadena_sql("buscarTitulosDocente", $arreglo);
                                $registroTitulos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

                                if(is_array($registroTitulos))
                                    {
                                        switch (count($registroTitulos)) {
                                            case 1:
                                                $respuesta = "registrar_2Doc";
                                                break;
                                            default:
                                                $respuesta = "registrar_MasDoc";
                                                break;
                                        }
                                    }else
                                        {
                                            $cadena_sql = $this->sql->cadena_sql("validarMaestriaDocente", $arreglo);
                                            $registroMaestrias = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

                                            if(is_array($registroMaestrias))
                                                {
                                                    $respuesta = "registrar_1Doc";
                                                }else
                                                    {
                                                        $respuesta = "registrar_1DocSinMae";
                                                    }

                                        }


                                break;

                        }


                    }else
                        {
                            $respuesta = "registrar_1Pre";
                        }
                    }else
                        {
                            $respuesta = "nomodifica_1Pre";
                        }
                
                
            }else
                {
                    $respuesta = '';
                }
        /*}else
                {
                    $respuesta = '';
                }*/
        break;
        
        case "#docenteid":
		
            $cadena_sql = $this->sql->cadena_sql("buscarNombreDocente", $_REQUEST["name_startsWith"]);
            $registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
            
            if($registro)
                {
                    //Para autocomplete
                    $respuesta = '[';

                    foreach ($registro as $fila) {
                            $respuesta.='{';
                            $respuesta.='"label":"' . $fila[1] . '",';
                            $respuesta.='"value":"' . $fila[0] . '"';
                            $respuesta.='},';
                    }

                    $respuesta = substr($respuesta, 0, strlen($respuesta) - 1);
                    $respuesta.=']';
                }else
                    {
                        $respuesta='[{"label":"No encontrado","value":"-1"}]';
                    }
		
        break;
        
        case "#docente":
		
            $cadena_sql = $this->sql->cadena_sql("buscarNombreDocente", $_REQUEST["name_startsWith"]);
            $registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
            
            if($registro)
                {
                    //Para autocomplete
                    $respuesta = '[';

                    foreach ($registro as $fila) {
                            $respuesta.='{';
                            $respuesta.='"label":"' . $fila[1] . '",';
                            $respuesta.='"value":"' . $fila[0] . '"';
                            $respuesta.='},';
                    }

                    $respuesta = substr($respuesta, 0, strlen($respuesta) - 1);
                    $respuesta.=']';
                }else
                    {
                        $respuesta='[{"label":"No encontrado","value":"-1"}]';
                    }
		
        break;
        
        case "#facultad":
		
            $cadena_sql = $this->sql->cadena_sql("buscarProyectos", $_REQUEST["facultad"]);
            $registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
            
	    $respuesta.= "<option value='' selected>Seleccione...</option>";

            if(!is_array($registro))
                {
                    $respuesta.= "<option value='' selected>--SIN REGISTROS--</option>";
                }else
                {
                        for($j=0;$j<count($registro);$j++)
                        {
                            $respuesta.=  "<option value='".$registro[$j][0]."'>".  htmlentities($registro[$j][1])."</option>";            
                        }
                }
		
        break;
        
}

echo $respuesta;
?>