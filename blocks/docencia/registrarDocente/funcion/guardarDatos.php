<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "docencia";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
        if($_REQUEST ['codigo'] == '' ||  $_REQUEST ['nombre'] == '' || $_REQUEST ['apellido'] == '' || $_REQUEST ['direccion'] == '' || $_REQUEST ['telefono'] == '')
            {
                $this->funcion->redireccionar ( 'informacionIncompleta', $_REQUEST ['identificacionDocente'] );
            }else
                {
                    /**
                     * GUARDAR INFORMACION DOCENTE
                     */
                    $arregloInformacionBasica = array (
			$_REQUEST ['tipoDocumento'],
			$_REQUEST ['identificacionDocente'],
			$_REQUEST ['nombre'],
			$_REQUEST ['apellido'],
			$_REQUEST ['sexo'],
			'TRUE',
			date('Y-m-d')
                    );
                    
                    $this->cadena_sql = $this->sql->cadena_sql ( "consultaDocenteInformacion", $arregloInformacionBasica );
                    $resultadoConsultaDocente = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );
                    
                    if(!is_array($resultadoConsultaDocente))
                        {
                        
                            $this->cadena_sql = $this->sql->cadena_sql ( "guardarDocenteInformacion", $arregloInformacionBasica ); 
                            $resultadoDocente = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
                    
                    $arregloLogEvento = array (
			'docente_informacion',
			$arregloInformacionBasica,
			$miSesion->getSesionUsuarioId (),
			$_SERVER ['REMOTE_ADDR'],
			$_SERVER ['HTTP_USER_AGENT'] 
                    );

                    $argumento = json_encode ( $arregloLogEvento );
                    $arregloFinalLogEvento = array (
                                    $miSesion->getSesionUsuarioId (),
                                    $argumento 
                    );

                    $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
                    $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
                    
                    /**
                     * GUARDAR INFORMACION VARIANTE
                     */
                    $arregloInformacionVariante = array (
			'45',
			$_REQUEST ['ciudad'],
			$_REQUEST ['codigo'],
			$_REQUEST ['fecha_nac'],
			$_REQUEST ['identificacionDocente']
                    );

                    $this->cadena_sql = $this->sql->cadena_sql ( "guardarDocenteInformacionInvariante", $arregloInformacionVariante ); 
                    $resultadoDocente = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
                    
                    $arregloLogEvento = array (
			'docente_infoinvariante',
			$arregloInformacionVariante,
			$miSesion->getSesionUsuarioId (),
			$_SERVER ['REMOTE_ADDR'],
			$_SERVER ['HTTP_USER_AGENT'] 
                    );

                    $argumento = json_encode ( $arregloLogEvento );
                    $arregloFinalLogEvento = array (
                                    $miSesion->getSesionUsuarioId (),
                                    $argumento 
                    );

                    $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
                    $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
                    
                    /**
                     * GUARDAR VINCULACION
                     */
                    
                    $esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

                    $rutaBloque=$this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );

                    $rutaBloqueUrl = $this->miConfigurador->getVariableConfiguracion ( "host" );
                    $rutaBloqueUrl .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
                    $rutaBloqueUrl .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];
                    
                    if ($_FILES ) {
                            // obtenemos los datos del archivo
                            $tamano = $_FILES["documentoResolucion"]['size'];
                            $tipo = $_FILES["documentoResolucion"]['type'];
                            $archivo1 = $_FILES["documentoResolucion"]['name'];
                            $prefijo = substr(md5(uniqid(rand())),0,6);

                            if ($archivo1 != "") {
                                    // guardamos el archivo a la carpeta files
                                    $destino1 =  $rutaBloque."/documentos/".$prefijo."_".$archivo1;
                                    if (copy($_FILES['documentoResolucion']['tmp_name'],$destino1)) {
                                            $status = "Archivo subido: <b>".$archivo1."</b>";
                                            $destino1 =  $rutaBloque."/documentos/".$prefijo."_".$archivo1;
                                            $destino1Url =  $rutaBloqueUrl."/documentos/".$prefijo."_".$archivo1;
                                            $destino1UrlSinNombre =  $rutaBloqueUrl."/documentos/";
                                            $destino1Nombre =  $prefijo."_".$archivo1;

            // 				echo $status;exit;
                                    } else {
                                            $status = "Error al subir el archivo";
                                    }
                            } else {
                                    $status = "Error al subir archivo";
                            }
                    }
                    
                    if ($_FILES ) {
                            // obtenemos los datos del archivo
                            $tamano = $_FILES["documentoPrueba"]['size'];
                            $tipo = $_FILES["documentoPrueba"]['type'];
                            $archivo2 = $_FILES["documentoPrueba"]['name'];
                            $prefijo = substr(md5(uniqid(rand())),0,6);

                            if ($archivo2 != "") {
                                    // guardamos el archivo a la carpeta files
                                    $destino2 =  $rutaBloque."/documentos/".$prefijo."_".$archivo2;
                                    if (copy($_FILES['documentoPrueba']['tmp_name'],$destino2)) {
                                            $status = "Archivo subido: <b>".$archivo2."</b>";
                                            $destino2 =  $rutaBloque."/documentos/".$prefijo."_".$archivo2;
                                            $destino2Url =  $rutaBloqueUrl."/documentos/".$prefijo."_".$archivo2;

            // 				echo $status;exit;
                                    } else {
                                            $status = "Error al subir el archivo";
                                    }
                            } else {
                                    $status = "Error al subir archivo";
                            }
                    }
                    
                    if ($_FILES ) {
                            // obtenemos los datos del archivo
                            $tamano = $_FILES["documentoFinal"]['size'];
                            $tipo = $_FILES["documentoFinal"]['type'];
                            $archivo3 = $_FILES["documentoFinal"]['name'];
                            $prefijo = substr(md5(uniqid(rand())),0,6);

                            if ($archivo3 != "") {
                                    // guardamos el archivo a la carpeta files
                                    $destino3 =  $rutaBloque."/documentos/".$prefijo."_".$archivo3;
                                    if (copy($_FILES['documentoFinal']['tmp_name'],$destino3)) {
                                            $status = "Archivo subido: <b>".$archivo3."</b>";
                                            $destino3 =  $rutaBloque."/documentos/".$prefijo."_".$archivo3;
                                            $destino3Url =  $rutaBloqueUrl."/documentos/".$prefijo."_".$archivo3;

            // 				echo $status;exit;
                                    } else {
                                            $status = "Error al subir el archivo";
                                    }
                            } else {
                                    $status = "Error al subir archivo";
                            }
                    }
                    
                    if ($_FILES ) {
                            // obtenemos los datos del archivo
                            $tamano = $_FILES["documentoConcepto"]['size'];
                            $tipo = $_FILES["documentoConcepto"]['type'];
                            $archivo4 = $_FILES["documentoConcepto"]['name'];
                            $prefijo = substr(md5(uniqid(rand())),0,6);

                            if ($archivo4 != "") {
                                    // guardamos el archivo a la carpeta files
                                    $destino4 =  $rutaBloque."/documentos/".$prefijo."_".$archivo4;
                                    if (copy($_FILES['documentoConcepto']['tmp_name'],$destino4)) {
                                            $status = "Archivo subido: <b>".$archivo4."</b>";
                                            $destino4 =  $rutaBloque."/documentos/".$prefijo."_".$archivo4;
                                            $destino4Url =  $rutaBloqueUrl."/documentos/".$prefijo."_".$archivo4;

            // 				echo $status;exit;
                                    } else {
                                            $status = "Error al subir el archivo";
                                    }
                            } else {
                                    $status = "Error al subir archivo";
                            }
                    }
                    
                    $arregloVinculacion = array (
			$_REQUEST ['identificacionDocente'],
			$_REQUEST ['resolucionNombramiento'],
			$_REQUEST ['fechaInicio'],
			$_REQUEST ['dedicacion'],
                        $destino1Url,
                        $destino2Url,
                        $destino3Url,
                        $destino4Url			
                    );
                    
                    $this->cadena_sql = $this->sql->cadena_sql ( "guardarVinculacionDocente", $arregloVinculacion ); 
                    $resultadoDocente = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
                    
                    $arregloLogEvento = array (
			'vinculacion_docente',
			$arregloInformacionVariante,
			$miSesion->getSesionUsuarioId (),
			$_SERVER ['REMOTE_ADDR'],
			$_SERVER ['HTTP_USER_AGENT'] 
                    );

                    $argumento = json_encode ( $arregloLogEvento );
                    $arregloFinalLogEvento = array (
                                    $miSesion->getSesionUsuarioId (),
                                    $argumento 
                    );

                    $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
                    $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
                    
                    /**
                     * GUARDAR DEPENDENCIA DOCENTE
                     */
                    $arregloInformacionDependencia = array (
			$_REQUEST ['identificacionDocente'],
			$_REQUEST ['facultadCrear'],
			$_REQUEST ['proyectoCurricular'],
                        'TRUE',
			date('Y-m-d')
                    );

                    $this->cadena_sql = $this->sql->cadena_sql ( "guardarDependenciaDocente", $arregloInformacionDependencia ); 
                    $resultadoDocente = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
                    
                    $arregloLogEvento = array (
			'dependencia_docente',
			$arregloInformacionDependencia,
			$miSesion->getSesionUsuarioId (),
			$_SERVER ['REMOTE_ADDR'],
			$_SERVER ['HTTP_USER_AGENT'] 
                    );

                    $argumento = json_encode ( $arregloLogEvento );
                    $arregloFinalLogEvento = array (
                                    $miSesion->getSesionUsuarioId (),
                                    $argumento 
                    );

                    $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
                    $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
                    
                    /**
                     * GUARDAR CATEGORIA DOCENTE
                     */
                    $arregloInformacionCategoria = array (
			$_REQUEST ['identificacionDocente'],
			$_REQUEST ['categoriaActual'],
                        'TRUE',
			date('Y-m-d')
                    );

                    $this->cadena_sql = $this->sql->cadena_sql ( "guardarCategoriaDocente", $arregloInformacionCategoria ); 
                    $resultadoDocente = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
                    
                    $arregloLogEvento = array (
			'categoria_docente',
			$arregloInformacionCategoria,
			$miSesion->getSesionUsuarioId (),
			$_SERVER ['REMOTE_ADDR'],
			$_SERVER ['HTTP_USER_AGENT'] 
                    );

                    $argumento = json_encode ( $arregloLogEvento );
                    $arregloFinalLogEvento = array (
                                    $miSesion->getSesionUsuarioId (),
                                    $argumento 
                    );

                    $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
                    $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
                    
                    
                    /**
                     * GUARDAR INFORMACION DETALLADA
                     */
                    $arregloInformacionDetallada = array (
			$_REQUEST ['identificacionDocente'],
			$_REQUEST ['correoInstitucional'],
			$_REQUEST ['correo'],
			$_REQUEST ['direccion'],
			$_REQUEST ['telefono'],
			$_REQUEST ['celular'],
			$_REQUEST ['celular'],
                        'TRUE',
			date('Y-m-d')
                    );

                    $this->cadena_sql = $this->sql->cadena_sql ( "guardarInformacionDetalladaDocente", $arregloInformacionDetallada ); 
                    $resultadoDocente = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
                    
                    $arregloLogEvento = array (
			'docente_infodetalle',
			$arregloInformacionDetallada,
			$miSesion->getSesionUsuarioId (),
			$_SERVER ['REMOTE_ADDR'],
			$_SERVER ['HTTP_USER_AGENT'] 
                    );

                    $argumento = json_encode ( $arregloLogEvento );
                    $arregloFinalLogEvento = array (
                                    $miSesion->getSesionUsuarioId (),
                                    $argumento 
                    );

                    $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
                    $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
                    
                    /**
                     * GUARDAR INFORMACION NOMBRAMIENTO
                     */
                    $arregloInformacionNombramiento = array (
			$_REQUEST ['identificacionDocente'],
			$_REQUEST ['numeActa'],
			$_REQUEST ['fechaActa'],
			$_REQUEST ['numeCaso']
                    );

                    $this->cadena_sql = $this->sql->cadena_sql ( "guardarNombramientoDocente", $arregloInformacionNombramiento ); 
                    $resultadoDocente = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
                    
                    $arregloLogEvento = array (
			'docente_nombramiento',
			$arregloInformacionNombramiento,
			$miSesion->getSesionUsuarioId (),
			$_SERVER ['REMOTE_ADDR'],
			$_SERVER ['HTTP_USER_AGENT'] 
                    );

                    $argumento = json_encode ( $arregloLogEvento );
                    $arregloFinalLogEvento = array (
                                    $miSesion->getSesionUsuarioId (),
                                    $argumento 
                    );

                    $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
                    $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
                    
                    /**
                     * GUARDAR INFORMACION ESTADO
                     */
                    $arregloInformacionEstado = array (
			$_REQUEST ['identificacionDocente'],
			"1",
			$destino1UrlSinNombre,
			$destino1Nombre,
                        'TRUE',
			date('Y-m-d')
                    );

                    $this->cadena_sql = $this->sql->cadena_sql ( "guardarDocenteEstado", $arregloInformacionEstado ); 
                    $resultadoDocente = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
                    
                    $arregloLogEvento = array (
			'docente_estado',
			$arregloInformacionEstado,
			$miSesion->getSesionUsuarioId (),
			$_SERVER ['REMOTE_ADDR'],
			$_SERVER ['HTTP_USER_AGENT'] 
                    );

                    $argumento = json_encode ( $arregloLogEvento );
                    $arregloFinalLogEvento = array (
                                    $miSesion->getSesionUsuarioId (),
                                    $argumento 
                    );

                    $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
                    $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
                    
                    $this->funcion->redireccionar ( 'inserto', $_REQUEST ['identificacionDocente'] );
                        
                        }else
                            {
                                $this->funcion->redireccionar ( 'yaExiste', $_REQUEST ['identificacionDocente'] );
                            }

                    
                    
                    
                }
		
		
	
}
?>