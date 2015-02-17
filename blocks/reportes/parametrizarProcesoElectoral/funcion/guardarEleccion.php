<?

if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
    
    $rutaCandidatos = $this->miConfigurador->getVariableConfiguracion("raizDocumento"). "/blocks";
    $rutaCandidatos.= $this->miConfigurador->getVariableConfiguracion("rutaCandidatos");
        
        $proceso = $_REQUEST['proceso'];    
        $idEleccion = $_REQUEST['idEleccion'];    
        $nombreEleccion = $_REQUEST['nombreEleccion'.$idEleccion];
        $tipoEstamento = $_REQUEST['tipoestamento'.$idEleccion];
        $descripcion = $_REQUEST['descripcion'.$idEleccion];
        $fechaInicio = $_REQUEST['fechaInicio'.$idEleccion];
        $fechaFin = $_REQUEST['fechaFin'.$idEleccion];
        $tipoVotacion = $_REQUEST['tipovotacion'.$idEleccion];
        if(isset($_REQUEST['segundaClave'.$idEleccion]))
        {
            $segundaClave = $_REQUEST['segundaClave'.$idEleccion];
        }else
            {
                $segundaClave = 2;
            }
        
       
        if(isset($_REQUEST['restricciones'.$idEleccion]) && is_array($_REQUEST['restricciones'.$idEleccion]))
            {
                $restricciones = "{";
                for ($i=0;$i<count($_REQUEST['restricciones'.$idEleccion]);$i++)    
                {
                    if(($i + 1) == count($_REQUEST['restricciones'.$idEleccion]))
                        {
                            $restricciones .= $_REQUEST['restricciones'.$idEleccion][$i];
                        }else
                            {
                                $restricciones .= $_REQUEST['restricciones'.$idEleccion][$i].",";
                            }
                }
                $restricciones .= "}";
            }else
                {
                    $restricciones = '';
                }
            
         $candidatos = 0;   
         if(isset($_REQUEST['identificacion'.$idEleccion]) && is_array($_REQUEST['identificacion'.$idEleccion]))
            {
                for ($j=1;$j<count($_REQUEST['identificacion'.$idEleccion]);$j++)    
                {   
                    if($_REQUEST['identificacion'.$idEleccion][$j] != '')
                    {
                        $candidatos++;
                        $estension = explode(".", $_FILES['foto']['name'][$j]);
                        $nombre = $estension[0];
                        $ext = $estension[1];

                        $nombreArchivo = $_REQUEST['identificacion'.$idEleccion][$j].".".$ext;

                        copy($_FILES['foto']['tmp_name'][$j],$rutaCandidatos.$nombreArchivo);

                        $candidatosGuardar[$j] = array($_REQUEST['identificacion'.$idEleccion][$j], $_REQUEST['nombres'.$idEleccion][$j], $_REQUEST['apellidos'.$idEleccion][$j], $_REQUEST['nombreLista'.$idEleccion][$j], $nombreArchivo);      
                    }                    
                }
            }   
            
            if($candidatos != 0)
                {
                    if(isset($_REQUEST['nombreLista'.$idEleccion]) && is_array($_REQUEST['nombreLista'.$idEleccion]))
                    {            
                        for($i=0;$i<count($_REQUEST['nombreLista'.$idEleccion]);$i++)
                        {                    
                            $recorreLista[$i] = trim($_REQUEST['nombreLista'.$idEleccion][$i]);
                        }
                        $arregloLista = array_unique($recorreLista);
                        $arregloListaFinal = array_values($arregloLista);
                    } 
                }else
                    {
                        $arregloListaFinal = '';
                    }
            
             
            
        if($segundaClave == 'on')
            {
                $segundaClave = 1;
            }else
                {
                    $segundaClave = 2;
                }    
            
        $arregloEleccion = array($proceso, $nombreEleccion, $tipoEstamento, $descripcion, $fechaInicio, $fechaFin, $restricciones, $tipoVotacion, 1, count($candidatos), $segundaClave, $idEleccion);    
 
	$conexion="estructura";
	$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        
        $this->cadena_sql = $this->sql->cadena_sql("insertarEleccion", $arregloEleccion);
	$resultadoEleccion = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
        
        $idGuardado=$esteRecursoDB->ultimo_insertado();

        if($resultadoEleccion)
            {
                if($arregloListaFinal != '')
                    {
                        for($l = 1 ;$l<count($arregloListaFinal); $l++)
                        {
                            $arregloListasInsert = array($arregloListaFinal[$l], $idGuardado, $l);

                            $this->cadena_sql = $this->sql->cadena_sql("insertarLista", $arregloListasInsert);
                            $resultadoLista = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
                        }

                        $this->cadena_sql = $this->sql->cadena_sql("idLista", $idGuardado);
                        $resultadoIdLista = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");

                        for($c=1;$c <= count($candidatosGuardar); $c++) 
                        {
                            for($lis = 0 ;$lis<count($resultadoIdLista); $lis++) 
                            {
                                if($resultadoIdLista[$lis]['nombre'] == $candidatosGuardar[$c][3])
                                    {
                                        $candidatosGuardar[$c][3] = $resultadoIdLista[$lis]['idlista'];
                                    }
                            }
                            $arregloCandidato = array($candidatosGuardar[$c][0],$candidatosGuardar[$c][1],$candidatosGuardar[$c][2], $c, $candidatosGuardar[$c][3], $candidatosGuardar[$c][4]);

                            $this->cadena_sql = $this->sql->cadena_sql("insertarCandidato", $arregloCandidato);
                            $resultadoCandidato = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
                        }
                        $this->funcion->redireccionar('inserto',$proceso);
                    }else
                        {
                            $this->funcion->redireccionar('insertoSinCandidatos',$proceso);
                        } 
            }else
                {
                    $this->funcion->redireccionar('ErrorInsertando',$proceso);
                }
		
	
}
?>