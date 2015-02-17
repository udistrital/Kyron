<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$miSesion = Sesion::singleton ();

$nombreFormulario = $esteBloque ["nombre"];

include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton ();
$valorCodificado = "&action=" . $esteBloque ['nombre'];
$valorCodificado .= "&opcion=actualizarDatos";
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado = $cripto->codificar ( $valorCodificado );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";

$tab = 1;

$esteCampo = "CuadroModificarRegistros";
$atributos ["id"] = $esteCampo;
$atributos ["estilo"] = "jqueryui";
$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
echo $this->miFormulario->marcoAgrupacion ( "inicio", $atributos );
unset ( $atributos );

// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = $nombreFormulario;
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario ( "inicio", $atributos );

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

$id_tec_soft = $_REQUEST ['idTecnSotf'];

$cadena_sql = $this->sql->cadena_sql ( "consultartecsoftModificar", $id_tec_soft );
$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
// var_dump ( $resultado );

$cadena_sql = $this->sql->cadena_sql ( "consultarEvaluadorestecsoftModificar", $id_tec_soft );

$resultadoEvaluadores = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

// var_dump ( $resultadoEvaluadores );

switch ($resultado [0] ['nume_evaluadores']) {
	
	case '2' :
		$mostrar1 = "display:block";
		$mostrar2 = "display:block";
		$mostrar3 = "display:none";
		
		$identEva1 = $resultadoEvaluadores [0] [0];
		$evaluador1 = $resultadoEvaluadores [0] [1];
		$UnivEva1 = $resultadoEvaluadores [0] [2];
		$puntaje1 = $resultadoEvaluadores [0] [3];
		
		
		$identEva2 = $resultadoEvaluadores [1] [0];
		$evaluador2 = $resultadoEvaluadores [1] [1];
		$UnivEva2 = $resultadoEvaluadores [1] [2];
		$puntaje2 = $resultadoEvaluadores [1] [3];
		
                $identEva3 = '';
		$evaluador3 = '';
		$universidad3 = -1;
		$puntaje3 = '';
		
		break;
	case '3' :
		$mostrar1 = "display:block";
		$mostrar2 = "display:block";
		$mostrar3 = "display:block";
		
		$identEva1 = $resultadoEvaluadores [0] [0];
		$evaluador1 = $resultadoEvaluadores [0] [1];
		$UnivEva1 = $resultadoEvaluadores [0] [2];
		$puntaje1 = $resultadoEvaluadores [0] [3];
		
		$identEva2 = $resultadoEvaluadores [1] [0];
		$evaluador2 = $resultadoEvaluadores [1] [1];
		$UnivEva2 = $resultadoEvaluadores [1] [2];
		$puntaje2 = $resultadoEvaluadores [1] [3];
		
		$identEva3 = $resultadoEvaluadores [2] [0];
		$evaluador3 = $resultadoEvaluadores [2] [1];
		$UnivEva3 = $resultadoEvaluadores [2] [2];
		$puntaje3 = $resultadoEvaluadores [2] [3];
		
		break;
}

?>
    <?php
				$atributos ["id"] = "CuadroModificarRegistros";
				$atributos ["estilo"] = "";
				// $atributos["estiloEnLinea"]="display:none";
				echo $this->miFormulario->division ( "inicio", $atributos );
				
				$esteCampo = "identificacionDocente";
				$atributos ["tipo"] = "hidden";
                                $atributos ["valor"] =$resultado [0] ['id_docente']; 
                                echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				{ // ------------------Control Lista Desplegable------------------------------
					$esteCampo = "tipo";
					$atributos ["id"] = $esteCampo;
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["seleccion"] = $resultado [0] ['tipo_produccion'];
					$atributos ["evento"] = 2;
					$atributos ["columnas"] = "1";
					$atributos ["limitar"] = false;
					$atributos ["tamanno"] = 1;
					$atributos ["ancho"] = "250px";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["validar"] = "required";
					$atributos ["anchoEtiqueta"] = 320;
					$atributos ["obligatorio"] = true;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					// -----De donde rescatar los datos ---------
					$atributos ["cadena_sql"] = $this->sql->cadena_sql ( "tipo_produccion" );
					$atributos ["baseDatos"] = "estructura";
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "numeCertificado";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 32;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 320;
					$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30],custom[onlyNumberSp]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] =$resultado [0] ['nume_certificado']; 
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					{
						
						$esteCampo = "grupoEvaludadores";
						$atributos ["id"] = $esteCampo;
						$atributos ["estilo"] = "jqueryui";
						$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
						echo $this->miFormulario->marcoAgrupacion ( "inicio", $atributos );
						unset ( $atributos );
						
						// ------------------Control Lista Desplegable------------------------------
						$esteCampo = "numEvaluadores";
						$atributos ["id"] = $esteCampo;
						$atributos ["tabIndex"] = $tab ++;
						$atributos ["seleccion"] =$resultado [0] ['nume_evaluadores']; ;
						$atributos ["evento"] = 2;
						$atributos ["columnas"] = "1";
						$atributos ["limitar"] = false;
						$atributos ["tamanno"] = 1;
						$atributos ["ancho"] = "130px";
						$atributos ["estilo"] = "jqueryui";
						$atributos ["etiquetaObligatorio"] = true;
						$atributos ["validar"] = "required";
						$atributos ["anchoEtiqueta"] = 300;
						$atributos ["obligatorio"] = true;
						$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
						// -----De donde rescatar los datos ---------
						$atributos ["cadena_sql"] = array (
								array (
										'2',
										'2' 
								),
								array (
										'3',
										'3' 
								) 
						);
						$atributos ["baseDatos"] = "estructura";
						echo $this->miFormulario->campoCuadroLista ( $atributos );
						unset ( $atributos );
						
                                                $atributos ["id"] = "divEv1";
                                                $atributos ["estiloEnLinea"] = "display:block";
                                                echo $this->miFormulario->division ( "inicio", $atributos );

                                                $esteCampo = "infoEv1";
                                                $atributos ["id"] = $esteCampo;
                                                $atributos ["estilo"] = "jqueryui";
                                                $atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
                                                echo $this->miFormulario->marcoAgrupacion ( "inicio", $atributos );
                                                unset ( $atributos );

                                                $esteCampo = "idEvaluador1";
                                                $atributos ["id"] = $esteCampo;
                                                $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                                                $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
                                                $atributos ["tabIndex"] = $tab ++;
                                                $atributos ["obligatorio"] = false;
                                                $atributos ["tamanno"] = 10;
                                                $atributos ["columnas"] = 1;
                                                $atributos ["etiquetaObligatorio"] = true;
                                                $atributos ["tipo"] = "";
                                                $atributos ["estilo"] = "jqueryui";
                                                $atributos ["anchoEtiqueta"] = 350;
                                                $atributos ["validar"] = "required, minSize[4], maxSize[12],custom[number]";
                                                $atributos ["categoria"] = "";
                                                $atributos ["valor"] =$identEva1;
                                                echo $this->miFormulario->campoCuadroTexto ( $atributos );
                                                unset ( $atributos );

                                                $esteCampo = "nomEvaluador1";
                                                $atributos ["id"] = $esteCampo;
                                                $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                                                $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
                                                $atributos ["tabIndex"] = $tab ++;
                                                $atributos ["obligatorio"] = false;
                                                $atributos ["tamanno"] = 30;
                                                $atributos ["columnas"] = 1;
                                                $atributos ["etiquetaObligatorio"] = true;
                                                $atributos ["tipo"] = "";
                                                $atributos ["estilo"] = "jqueryui";
                                                $atributos ["anchoEtiqueta"] = 350;
                                                $atributos ["validar"] = "required, minSize[6], maxSize[2000]";
                                                $atributos ["categoria"] = "";
                                                $atributos ["valor"] =$evaluador1;
                                                echo $this->miFormulario->campoCuadroTexto ( $atributos );
                                                unset ( $atributos );

                                                //------------------Control Lista Desplegable------------------------------
                                                $esteCampo = "univEva1";
                                                $atributos["id"] = $esteCampo;
                                                $atributos["tabIndex"] = $tab++;
                                                $atributos["seleccion"] = $UnivEva1;
                                                $atributos["evento"] = 2;
                                                $atributos["columnas"] = "1";
                                                $atributos["limitar"] = false;
                                                $atributos["tamanno"] = 1;
                                                $atributos["ancho"] = "250px";
                                                $atributos["estilo"] = "jqueryui";
                                                $atributos["etiquetaObligatorio"] = true;
                                                $atributos["validar"] = "required";
                                                $atributos["anchoEtiqueta"] = 350;
                                                $atributos["obligatorio"] = true;
                                                $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
                                                //-----De donde rescatar los datos ---------
                                                $atributos["cadena_sql"] = $this->sql->cadena_sql("universidad");
                                                $atributos["baseDatos"] = "estructura";
                                                echo $this->miFormulario->campoCuadroLista($atributos);
                                                unset($atributos);

                                                $esteCampo = "puntEvaluador1";
                                                $atributos ["id"] = $esteCampo;
                                                $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                                                $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
                                                $atributos ["tabIndex"] = $tab ++;
                                                $atributos ["obligatorio"] = false;
                                                $atributos ["tamanno"] = 10;
                                                $atributos ["columnas"] = 1;
                                                $atributos ["etiquetaObligatorio"] = true;
                                                $atributos ["tipo"] = "";
                                                $atributos ["estilo"] = "jqueryui";
                                                $atributos ["anchoEtiqueta"] = 350;
                                                $atributos ["validar"] = "required, minSize[1],min[0.1],max[100],custom[number]";
                                                $atributos ["categoria"] = "";
                                                $atributos ["valor"] =$puntaje1;
                                                echo $this->miFormulario->campoCuadroTexto ( $atributos );
                                                unset ( $atributos );

                                                echo $this->miFormulario->marcoAgrupacion ( "fin" );

                                                echo $this->miFormulario->division ( "fin" );

                                                $atributos ["id"] = "divEv2";
                                                $atributos ["estiloEnLinea"] = "display:block";
                                                echo $this->miFormulario->division ( "inicio", $atributos );

                                                $esteCampo = "infoEv2";
                                                $atributos ["id"] = $esteCampo;
                                                $atributos ["estilo"] = "jqueryui";
                                                $atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
                                                echo $this->miFormulario->marcoAgrupacion ( "inicio", $atributos );
                                                unset ( $atributos );

                                                $esteCampo = "idEvaluador2";
                                                $atributos ["id"] = $esteCampo;
                                                $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                                                $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
                                                $atributos ["tabIndex"] = $tab ++;
                                                $atributos ["obligatorio"] = false;
                                                $atributos ["tamanno"] = 10;
                                                $atributos ["columnas"] = 1;
                                                $atributos ["etiquetaObligatorio"] = true;
                                                $atributos ["tipo"] = "";
                                                $atributos ["estilo"] = "jqueryui";
                                                $atributos ["anchoEtiqueta"] = 350;
                                                $atributos ["validar"] = "required, minSize[4], maxSize[12],custom[number]";
                                                $atributos ["categoria"] = "";
                                                $atributos ["valor"] =$identEva2;
                                                echo $this->miFormulario->campoCuadroTexto ( $atributos );
                                                unset ( $atributos );

                                                $esteCampo = "nomEvaluador2";
                                                $atributos ["id"] = $esteCampo;
                                                $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                                                $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
                                                $atributos ["tabIndex"] = $tab ++;
                                                $atributos ["obligatorio"] = false;
                                                $atributos ["tamanno"] = 30;
                                                $atributos ["columnas"] = 1;
                                                $atributos ["etiquetaObligatorio"] = true;
                                                $atributos ["tipo"] = "";
                                                $atributos ["estilo"] = "jqueryui";
                                                $atributos ["anchoEtiqueta"] = 350;
                                                $atributos ["validar"] = "required, minSize[6], maxSize[2000]";
                                                $atributos ["categoria"] = "";
                                                $atributos ["valor"] =$evaluador2;
                                                echo $this->miFormulario->campoCuadroTexto ( $atributos );
                                                unset ( $atributos );

                                                //------------------Control Lista Desplegable------------------------------
                                                $esteCampo = "univEva2";
                                                $atributos["id"] = $esteCampo;
                                                $atributos["tabIndex"] = $tab++;
                                                $atributos["seleccion"] = $UnivEva2;
                                                $atributos["evento"] = 2;
                                                $atributos["columnas"] = "1";
                                                $atributos["limitar"] = false;
                                                $atributos["tamanno"] = 1;
                                                $atributos["ancho"] = "250px";
                                                $atributos["estilo"] = "jqueryui";
                                                $atributos["etiquetaObligatorio"] = true;
                                                $atributos["validar"] = "required";
                                                $atributos["anchoEtiqueta"] = 350;
                                                $atributos["obligatorio"] = true;
                                                $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
                                                //-----De donde rescatar los datos ---------
                                                $atributos["cadena_sql"] = $this->sql->cadena_sql("universidad");
                                                $atributos["baseDatos"] = "estructura";
                                                echo $this->miFormulario->campoCuadroLista($atributos);
                                                unset($atributos);

                                                $esteCampo = "puntEvaluador2";
                                                $atributos ["id"] = $esteCampo;
                                                $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                                                $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
                                                $atributos ["tabIndex"] = $tab ++;
                                                $atributos ["obligatorio"] = false;
                                                $atributos ["tamanno"] = 10;
                                                $atributos ["columnas"] = 1;
                                                $atributos ["etiquetaObligatorio"] = true;
                                                $atributos ["tipo"] = "";
                                                $atributos ["estilo"] = "jqueryui";
                                                $atributos ["anchoEtiqueta"] = 350;
                                                $atributos ["validar"] = "required, minSize[1],min[0.1],max[100],custom[number]";
                                                $atributos ["categoria"] = "";
                                                $atributos ["valor"] =$puntaje2;
                                                echo $this->miFormulario->campoCuadroTexto ( $atributos );
                                                unset ( $atributos );

                                                echo $this->miFormulario->marcoAgrupacion ( "fin" );

                                                echo $this->miFormulario->division ( "fin" );

                                                $atributos ["id"] = "divEv3";
                                                $atributos ["estiloEnLinea"] = "display:none";
                                                echo $this->miFormulario->division ( "inicio", $atributos );

                                                $esteCampo = "infoEv3";
                                                $atributos ["id"] = $esteCampo;
                                                $atributos ["estilo"] = "jqueryui";
                                                $atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
                                                echo $this->miFormulario->marcoAgrupacion ( "inicio", $atributos );
                                                unset ( $atributos );

                                                $esteCampo = "idEvaluador3";
                                                $atributos ["id"] = $esteCampo;
                                                $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                                                $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
                                                $atributos ["tabIndex"] = $tab ++;
                                                $atributos ["obligatorio"] = false;
                                                $atributos ["tamanno"] = 10;
                                                $atributos ["columnas"] = 1;
                                                $atributos ["etiquetaObligatorio"] = true;
                                                $atributos ["tipo"] = "";
                                                $atributos ["estilo"] = "jqueryui";
                                                $atributos ["anchoEtiqueta"] = 350;
                                                $atributos ["validar"] = "required, minSize[4], maxSize[12],custom[number]";
                                                $atributos ["categoria"] = "";
                                                $atributos ["valor"] =$identEva3;
                                                echo $this->miFormulario->campoCuadroTexto ( $atributos );
                                                unset ( $atributos );

                                                $esteCampo = "nomEvaluador3";
                                                $atributos ["id"] = $esteCampo;
                                                $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                                                $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
                                                $atributos ["tabIndex"] = $tab ++;
                                                $atributos ["obligatorio"] = false;
                                                $atributos ["tamanno"] = 30;
                                                $atributos ["columnas"] = 1;
                                                $atributos ["etiquetaObligatorio"] = true;
                                                $atributos ["tipo"] = "";
                                                $atributos ["estilo"] = "jqueryui";
                                                $atributos ["anchoEtiqueta"] = 350;
                                                $atributos ["validar"] = "required, minSize[6], maxSize[2000]";
                                                $atributos ["categoria"] = "";
                                                $atributos ["valor"] =$evaluador3;
                                                echo $this->miFormulario->campoCuadroTexto ( $atributos );
                                                unset ( $atributos );

                                                //------------------Control Lista Desplegable------------------------------
                                                $esteCampo = "univEva3";
                                                $atributos["id"] = $esteCampo;
                                                $atributos["tabIndex"] = $tab++;
                                                $atributos["seleccion"] = $UnivEva3;
                                                $atributos["evento"] = 2;
                                                $atributos["columnas"] = "1";
                                                $atributos["limitar"] = false;
                                                $atributos["tamanno"] = 1;
                                                $atributos["ancho"] = "250px";
                                                $atributos["estilo"] = "jqueryui";
                                                $atributos["etiquetaObligatorio"] = true;
                                                $atributos["validar"] = "required";
                                                $atributos["anchoEtiqueta"] = 350;
                                                $atributos["obligatorio"] = true;
                                                $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
                                                //-----De donde rescatar los datos ---------
                                                $atributos["cadena_sql"] = $this->sql->cadena_sql("universidad");
                                                $atributos["baseDatos"] = "estructura";
                                                echo $this->miFormulario->campoCuadroLista($atributos);
                                                unset($atributos);


                                                $esteCampo = "puntEvaluador3";
                                                $atributos ["id"] = $esteCampo;
                                                $atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
                                                $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
                                                $atributos ["tabIndex"] = $tab ++;
                                                $atributos ["obligatorio"] = false;
                                                $atributos ["tamanno"] = 10;
                                                $atributos ["columnas"] = 1;
                                                $atributos ["etiquetaObligatorio"] = true;
                                                $atributos ["tipo"] = "";
                                                $atributos ["estilo"] = "jqueryui";
                                                $atributos ["anchoEtiqueta"] = 350;
                                                $atributos ["validar"] = "required, minSize[1],min[0.1],max[100],custom[number]";
                                                $atributos ["categoria"] = "";
                                                $atributos ["valor"] =$puntaje3;
                                                echo $this->miFormulario->campoCuadroTexto ( $atributos );
                                                unset ( $atributos );
                                                echo $this->miFormulario->marcoAgrupacion ( "fin" );

                                                echo $this->miFormulario->division ( "fin" );

                                                echo $this->miFormulario->marcoAgrupacion ( "fin" );
                                                unset ( $atributos );
					}
					$esteCampo = "fechaPr";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = "8";
					$atributos ["ancho"] = 350;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["deshabilitado"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 320;
					$atributos ["validar"] = "required";
					$atributos ["categoria"] = "fecha";
					$atributos ["valor"] =$resultado [0] ['fech_produccion'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "numeActa";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 32;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 320;
					$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] =$resultado [0] ['nume_acta'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "fechaActa";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = "8";
					$atributos ["ancho"] = 350;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["deshabilitado"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 320;
					$atributos ["validar"] = "required";
					$atributos ["categoria"] = "fecha";
					$atributos ["valor"] =$resultado [0] ['fech_acta']; ;;
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "numeCaso";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 32;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 320;
					$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30],custom[onlyNumberSp]";
					$atributos ["categoria"] = "";
					$atributos ["valor"] =$resultado [0] ['nume_caso']; ;;
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = "puntaje";
					$atributos ["id"] = $esteCampo;
					$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
					$atributos ["tabIndex"] = $tab ++;
					$atributos ["obligatorio"] = true;
					$atributos ["tamanno"] = 32;
					$atributos ["columnas"] = 1;
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["tipo"] = "";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["anchoEtiqueta"] = 320;
					$atributos ["validar"] = "required, minSize[1],min[0.1],custom[number]";
					$atributos ["deshabilitado"] = false;
					$atributos ["categoria"] = "";
					$atributos ["valor"] =$resultado [0] ['puntaje'];
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
                                        
                                        $esteCampo="detalleDocencia";
                                        $atributos["id"]=$esteCampo;
                                        $atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
                                        $atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
                                        $atributos["tabIndex"]=$tab++;
                                        $atributos["obligatorio"]=true;
                                        $atributos["etiquetaObligatorio"] = false;
                                        $atributos["tipo"]="";
                                        $atributos["columnas"] = 100;
                                        $atributos["filas"] = 5;
                                        $atributos["estilo"]="jqueryui";
                                        $atributos["anchoEtiqueta"] = 300;
                                        $atributos["validar"]="required";
                                        $atributos["categoria"]="";
                                        $atributos ["valor"] = $resultado [0] ['detalledocencia'];
                                        echo $this->miFormulario->campoTextArea($atributos);
                                        unset($atributos);

				}
				
				// ------------------Fin Division para los botones-------------------------
				// echo $this->miFormulario->division("fin");
				
				// ------------------Division para los botones-------------------------
				$atributos ["id"] = "botones";
				$atributos ["estilo"] = "marcoBotones";
				echo $this->miFormulario->division ( "inicio", $atributos );
				
				$esteCampo = "botonCancelar";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["tipo"] = "boton";
				$atributos ["estilo"] = "";
				$atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
				$atributos ["tipoSubmit"] = "jquery"; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
				$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["nombreFormulario"] = $nombreFormulario;
				echo $this->miFormulario->campoBoton ( $atributos );
				unset ( $atributos );
				// -------------Control Boton-----------------------
				$esteCampo = "botonAceptar";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["tipo"] = "boton";
				$atributos ["estilo"] = "";
				$atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
				$atributos ["tipoSubmit"] = "jquery"; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
				$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ["nombreFormulario"] = $nombreFormulario;
				echo $this->miFormulario->campoBoton ( $atributos );
				unset ( $atributos );
				// -------------Fin Control Boton----------------------
				
				// ------------------Fin Division para los botones-------------------------
				echo $this->miFormulario->division ( "fin" );
				
				// -------------Control cuadroTexto con campos ocultos-----------------------
				// Para pasar variables entre formularios o enviar datos para validar sesiones
				$atributos ["id"] = "formSaraData"; // No cambiar este nombre
				$atributos ["tipo"] = "hidden";
				$atributos ["obligatorio"] = false;
				$atributos ["etiqueta"] = "";
				$atributos ["valor"] = $valorCodificado;
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				// Fin del Formulario
				echo $this->miFormulario->formulario ( "fin" );
				
				echo $this->miFormulario->marcoAgrupacion ( "fin" );
				
				?>
