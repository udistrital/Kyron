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
$valorCodificado .= "&action=" . $esteBloque ['nombre'];
$valorCodificado .= "&opcion=guardarDatos";
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado = $cripto->codificar ( $valorCodificado );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagen/";

$tab = 1;
// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = $nombreFormulario;
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario ( "inicio", $atributos );

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

?>
    <?php
				
				$esteCampo = "identificacionFinalCrear";
				$atributos ["id"] = $esteCampo;				
				$atributos ["tipo"] = "hidden";
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = "docente";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["obligatorio"] = true;
				$atributos ["tamanno"] = 55;
				$atributos ["columnas"] = 1;
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ["tipo"] = "";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["anchoEtiqueta"] = 350;
				$atributos ["validar"] = "minSize[3], maxSize[2000]";
				$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				// ------------------Control Lista Desplegable------------------------------
				$esteCampo = "tipo";
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab ++;
				$atributos ["seleccion"] = - 1;
				$atributos ["evento"] = 2;
				$atributos ["columnas"] = "1";
				$atributos ["limitar"] = false;
				$atributos ["tamanno"] = 1;
				$atributos ["ancho"] = "250px";
				$atributos ["estilo"] = "jqueryui";
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ["validar"] = "required";
				$atributos ["anchoEtiqueta"] = 350;
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
				$atributos ["anchoEtiqueta"] = 350;
				$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30],custom[onlyNumberSp]";
				$atributos ["categoria"] = "";
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
					$atributos ["seleccion"] = 1;
					$atributos ["evento"] = 2;
					$atributos ["columnas"] = "1";
					$atributos ["limitar"] = false;
					$atributos ["tamanno"] = 1;
					$atributos ["ancho"] = "130px";
					$atributos ["estilo"] = "jqueryui";
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ["validar"] = "required";
					$atributos ["anchoEtiqueta"] = 350;
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
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
                                        //------------------Control Lista Desplegable------------------------------
                                        $esteCampo = "univEva1";
                                        $atributos["id"] = $esteCampo;
                                        $atributos["tabIndex"] = $tab++;
                                        $atributos["seleccion"] = -1;
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
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
                                        //------------------Control Lista Desplegable------------------------------
                                        $esteCampo = "univEva2";
                                        $atributos["id"] = $esteCampo;
                                        $atributos["tabIndex"] = $tab++;
                                        $atributos["seleccion"] = -1;
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
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
                                        //------------------Control Lista Desplegable------------------------------
                                        $esteCampo = "univEva3";
                                        $atributos["id"] = $esteCampo;
                                        $atributos["tabIndex"] = $tab++;
                                        $atributos["seleccion"] = -1;
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
				$atributos ["anchoEtiqueta"] = 350;
				$atributos ["validar"] = "required";
				$atributos ["categoria"] = "fecha";
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
				$atributos ["anchoEtiqueta"] = 350;
				$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30]";
				$atributos ["categoria"] = "";
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
				$atributos ["anchoEtiqueta"] = 350;
				$atributos ["validar"] = "required";
				$atributos ["categoria"] = "fecha";
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
				$atributos ["anchoEtiqueta"] = 350;
				$atributos ["validar"] = "required, minSize[1],min[1],maxSize[30],custom[onlyNumberSp]";
				$atributos ["categoria"] = "";
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
				$atributos ["anchoEtiqueta"] = 350;
				$atributos ["validar"] = "required, minSize[1],min[0.1],custom[number]";
				$atributos ["deshabilitado"] = false;
				$atributos ["categoria"] = "";
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
                                $atributos["anchoEtiqueta"] = 350;
                                $atributos["validar"]="required";
                                $atributos["categoria"]="";
                                echo $this->miFormulario->campoTextArea($atributos);
                                unset($atributos);
                                
				// ------------------Fin Division para los botones-------------------------
				// echo $this->miFormulario->division("fin");
				
				// ------------------Division para los botones-------------------------
				$atributos ["id"] = "botones";
				$atributos ["estilo"] = "marcoBotones";
				echo $this->miFormulario->division ( "inicio", $atributos );
				
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
				
				?>
