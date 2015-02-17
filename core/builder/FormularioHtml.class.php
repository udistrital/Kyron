<?php
include_once ("WidgetHtml.class.php");
class FormularioHtml extends WidgetHtml {
	var $configuracion;
	public function setConfiguracion($configuracion) {
		$this->configuracion = $configuracion;
	}
	function recaptcha($atributos) {
		require_once ($this->configuracion ["raiz_documento"] . $this->configuracion ["clases"] . "/recaptcha/recaptchalib.php");
		$publickey = $this->configuracion ["captcha_llavePublica"];
		
		if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] != "") {
			$this->cadenaHTML = "<div class='" . $atributos ["estilo"] . "'>\n";
		} else {
			$this->cadenaHTML = "<div class='recaptcha'>\n";
		}
		$this->cadenaHTML .= recaptcha_get_html ( $publickey );
		$this->cadenaHTML .= "</div>\n";
		return $this->cadenaHTML;
	}
	function marcoFormulario($tipo, $atributos) {
		if ($tipo == "inicio") {
			
			if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] != "") {
				$this->cadenaHTML = "<div class='" . $atributos ["estilo"] . "'>\n";
			} else {
				$this->cadenaHTML = "<div class='formulario'>\n";
			}
			$this->cadenaHTML .= "<form ";
			
			if (isset ( $atributos ["id"] )) {
				$this->cadenaHTML .= "id='" . $atributos ["id"] . "' ";
			}
			
			if (isset ( $atributos ["tipoFormulario"] )) {
				$this->cadenaHTML .= "enctype='" . $atributos ["tipoFormulario"] . "' ";
			}
			
			if (isset ( $atributos ["metodo"] )) {
				$this->cadenaHTML .= "method='" . strtolower ( $atributos ["metodo"] ) . "' ";
			}
			
			if (isset ( $atributos ["action"] )) {
				$this->cadenaHTML .= "action='index.php' ";
			}
			
			$this->cadenaHTML .= "title='Formulario' ";
			$this->cadenaHTML .= "name='" . $atributos ["nombreFormulario"] . "'>\n";
		} else {
			$this->cadenaHTML = "</form>\n";
			$this->cadenaHTML .= "</div>\n";
		}
		
		return $this->cadenaHTML;
	}
	function marcoAgrupacion($tipo, $atributos = "") {
		$this->cadenaHTML = "";
		if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] == "jqueryui") {
			if ($tipo == "inicio") {
				$this->cadenaHTML = "<div>\n";
				$this->cadenaHTML .= "<fieldset class='ui-widget ui-widget-content' ";
				if (isset ( $atributos ["id"] )) {
					$this->cadenaHTML .= "id='" . $atributos ["id"] . "' ";
				}
				$this->cadenaHTML .= ">\n";
				if (isset ( $atributos ["leyenda"] )) {
					$this->cadenaHTML .= "<legend class='ui-state-default ui-corner-all'>\n" . $atributos ["leyenda"] . "</legend>\n";
				}
			} else {
				$this->cadenaHTML .= "</fieldset>\n";
				$this->cadenaHTML .= "</div>\n";
			}
		} else {
			
			if ($tipo == "inicio") {
				$this->cadenaHTML = "<div class='marcoControles'>\n";
				$this->cadenaHTML .= "<fieldset ";
				if (isset ( $atributos ["id"] )) {
					$this->cadenaHTML .= "id='" . $atributos ["id"] . "' ";
				}
				$this->cadenaHTML .= ">\n";
				if (isset ( $atributos ["leyenda"] )) {
					$this->cadenaHTML .= "<legend>\n" . $atributos ["leyenda"] . "</legend>\n";
				}
			} else {
				$this->cadenaHTML .= "</fieldset>\n";
				$this->cadenaHTML .= "</div>\n";
			}
		}
		return $this->cadenaHTML;
	}
	
	/**
	 * Formulario que no requieren su propia división
	 *
	 * @param unknown $tipo        	
	 * @param unknown $atributos        	
	 * @return Ambigous <string, unknown>
	 *        
	 */
	function formulario($tipo, $atributos = "") {
		if ($tipo == "inicio") {
			
			$this->cadenaHTML = "<form ";
			
			if (isset ( $atributos ["id"] )) {
				$this->cadenaHTML .= "id='" . $atributos ["id"] . "' ";
			}
			
			if (isset ( $atributos ["tipoFormulario"] )) {
				$this->cadenaHTML .= "enctype='" . $atributos ["tipoFormulario"] . "' ";
			}
			
			if (isset ( $atributos ["metodo"] )) {
				$this->cadenaHTML .= "method='" . strtolower ( $atributos ["metodo"] ) . "' ";
			}
			
			if (isset ( $atributos ["action"] )) {
				$this->cadenaHTML .= "action='index.php' ";
			}
			
			if (isset ( $atributos ["titulo"] )) {
				$this->cadenaHTML .= "title='" . $atributos ["titulo"] . "' ";
			}
			
			$this->cadenaHTML .= "name='" . $atributos ["nombreFormulario"] . "'>\n";
		} else {
			$this->cadenaHTML = "</form>\n";
		}
		
		return $this->cadenaHTML;
	}
	
	/**
	 * Agrupaciones que no deben tener una división propia
	 *
	 * @param unknown $tipo        	
	 * @param string $atributos        	
	 * @return Ambigous <string, unknown>
	 *        
	 */
	function agrupacion($tipo, $atributos = "") {
		$this->cadenaHTML = "";
		
		if ($tipo == "inicio") {
			$this->cadenaHTML .= "<fieldset ";
			if (isset ( $atributos ["id"] )) {
				$this->cadenaHTML .= "id='" . $atributos ["id"] . "' ";
			}
			$this->cadenaHTML .= ">\n";
			if (isset ( $atributos ["leyenda"] )) {
				$this->cadenaHTML .= "<legend>\n" . $atributos ["leyenda"] . "</legend>\n";
			}
		} else {
			$this->cadenaHTML .= "</fieldset>\n";
		}
		
		return $this->cadenaHTML;
	}
	function campoCuadroTexto($atributos) {
		$this->cadenaHTML = "";
		
		if (! isset ( $atributos ["sinDivision"] )) {
			if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] != "" && $atributos ["estilo"] != "jqueryui") {
				$this->cadenaHTML .= "<div class='" . $atributos ["estilo"] . "'>\n";
			} else {
				if (isset ( $atributos ["columnas"] ) && $atributos ["columnas"] != "" && is_numeric ( $atributos ["columnas"] )) {
					
					$this->cadenaHTML .= "<div class='campoCuadroTexto anchoColumna" . $atributos ["columnas"] . "'>\n";
				} else {
					$this->cadenaHTML .= "<div class='campoCuadroTexto'>\n";
				}
			}
		}
		if (isset ( $atributos ["etiqueta"] ) && $atributos ["etiqueta"] != "") {
			$this->cadenaHTML .= $this->etiqueta ( $atributos );
		}
		;
		if (isset ( $atributos ["dobleLinea"] )) {
			$this->cadenaHTML .= "<br>";
		}
		
		$this->cadenaHTML .= $this->cuadro_texto ( $this->configuracion, $atributos );
		if (! isset ( $atributos ["sinDivision"] )) {
			$this->cadenaHTML .= "</div>\n";
		}
		
		return $this->cadenaHTML;
	}
	function campoEspacio() {
		$this->cadenaHTML = "<div class='espacioBlanco'>\n</div>\n";
		return $this->cadenaHTML;
	}
	function campoFecha($atributos) {
		if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] != "") {
			$this->cadenaHTML = "<div class='" . $atributos ["estilo"] . "'>\n";
		} else {
			$this->cadenaHTML = "<div class='campoFecha'>\n";
		}
		$this->cadenaHTML .= $this->etiqueta ( $atributos );
		$this->cadenaHTML .= "<div style='display:table-cell;vertical-align:top;float:left;'><span style='white-space:pre;'> </span>";
		$this->cadenaHTML .= $this->cuadro_texto ( $this->configuracion, $atributos );
		$this->cadenaHTML .= "</div>";
		$this->cadenaHTML .= "<div style='display:table-cell;vertical-align:top;float:left;'>";
		$this->cadenaHTML .= "<span style='white-space:pre;'> </span><img src=\"" . $this->configuracion ["host"] . $this->configuracion ["site"] . $this->configuracion ["grafico"] . "/calendarito.jpg\" ";
		$this->cadenaHTML .= "id=\"imagen" . $atributos ["id"] . "\" style=\"cursor: pointer; border: 0px solid red;\" ";
		$this->cadenaHTML .= "title=\"Selector de Fecha\" alt=\"Selector de Fecha\" onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />";
		$this->cadenaHTML .= "</div>";
		$this->cadenaHTML .= "</div>\n";
		
		return $this->cadenaHTML;
	}
	
	/**
	 * Cuadro Mensaje: Funcion olvidada por el Ing Paulo.
	 * Se Incorpora nuevamente.
	 * Nickthor.
	 */
	function cuadroMensaje($atributos) {
		$this->cadenaHTML = "<div id='mensaje' class='" . $atributos ["tipo"] . " shadow " . $atributos ["estilo"] . "' >";
		$this->cadenaHTML .= "<span>" . $atributos ["mensaje"] . "</span>";
		$this->cadenaHTML .= "</div><br>";
		return $this->cadenaHTML;
	}
	function campoMensaje($atributos) {
		if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] == "jqueryui") {
			if (isset ( $atributos ["etiqueta"] ) && $atributos ["etiqueta"] != "simple") {
				$this->cadenaHTML = "<div class='ui-accordion ui-widget ui-helper-reset'>";
				$this->cadenaHTML .= '<h3 class="ui-accordion-header ui-state-default ui-accordion-icons ui-corner-all">';
				$this->cadenaHTML .= "<span class='ui-accordion-header-icon ui-icon ui-icon-document'></span>";
				$this->cadenaHTML .= $atributos ["mensaje"] . "</h3>";
				$this->cadenaHTML .= "</div>";
			} else {
				
				$this->cadenaHTML = "<div>";
				$this->cadenaHTML .= '<h3 class="ui-state-default">';
				$this->cadenaHTML .= $atributos ["mensaje"] . "</h3>";
				$this->cadenaHTML .= "</div>";
			}
			return $this->cadenaHTML;
                }else
                    {
                        if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] != "") {
                            $this->cadenaHTML = "<div id = '" . $atributos ["id"] . "' class='" . $atributos ["estilo"] . "' ";
                            } else {
                                    $this->cadenaHTML = "<div class='campoMensaje' ";
                            }

                            if (isset ( $atributos ["estiloEnLinea"] ) && $atributos ["estiloEnLinea"] != "") {
                                    $this->cadenaHTML .= "style='" . $atributos ["estiloEnLinea"] . "' ";
                            }

                            $this->cadenaHTML .= ">\n";

                            if (isset ( $atributos ["tamanno"] )) {
                                    switch ($atributos ["tamanno"]) {
                                            case "grande" :
                                                    $this->cadenaHTML .= "<span id = '" . $atributos ["id"] . "' class='textoGrande texto_negrita'>" . $atributos ["mensaje"] . "</span>";
                                                    break;

                                            case "enorme" :
                                                    $this->cadenaHTML .= "<span id = '" . $atributos ["id"] . "'  class='textoEnorme texto_negrita'>" . $atributos ["mensaje"] . "</span>";
                                                    break;

                                            case "pequenno" :
                                                    $this->cadenaHTML .= "<span id = '" . $atributos ["id"] . "'  class='textoPequenno'>" . $atributos ["mensaje"] . "</span>";
                                                    break;

                                            default :
                                                    $this->cadenaHTML .= "<span id = '" . $atributos ["id"] . "'  class='textoMediano'>" . $atributos ["mensaje"] . "</span>";
                                                    break;
                                    }
                            } else {
                                    $this->cadenaHTML .= $atributos ["mensaje"];
                            }

                            if (isset ( $atributos ["linea"] ) && $atributos ["linea"] == true) {
                                    $this->cadenaHTML .= "<hr class='hr_division'>";
                            }
                            $this->cadenaHTML .= "</div>\n";
                            
                            return $this->cadenaHTML;
                    }
		
		
		
	}
	function campoTextArea($atributos) {
		if ($atributos ["estilo"] == "jqueryui") {
			$this->cadenaHTML = "<div>\n";
			$this->cadenaHTML .= "<fieldset class='ui-widget ui-widget-content'>\n";
			$this->cadenaHTML .= "<legend class='ui-state-default ui-corner-all'>\n" . $atributos ["etiqueta"] . "</legend>\n";
			$this->cadenaHTML .= $this->area_texto ( $this->configuracion, $atributos );
			$this->cadenaHTML .= "\n</fieldset>\n";
			$this->cadenaHTML .= "</div>\n";
			return $this->cadenaHTML;
		} else {
			
			if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] != "") {
				$this->cadenaHTML = "<div class='" . $atributos ["estilo"] . "'>\n";
			} else {
				$this->cadenaHTML = "<div class='campoAreaTexto'>\n";
			}
			
			$this->cadenaHTML .= $this->etiqueta ( $atributos );
			$this->cadenaHTML .= "<div class='campoAreaContenido'>\n";
			$this->cadenaHTML .= $this->area_texto ( $this->configuracion, $atributos );
			$this->cadenaHTML .= "\n</div>\n";
			$this->cadenaHTML .= "</div>\n";
			return $this->cadenaHTML;
		}
	}
	function campoBoton($atributos) {
		$this->cadenaHTML = "";
		
		if (! isset ( $atributos ["sinDivision"] )) {
			
			if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] != "") {
				$this->cadenaHTML .= "<div class='" . $atributos ["estilo"] . "'>\n";
			} else {
				$this->cadenaHTML .= "<div class='campoBoton'>\n";
			}
		}
		
		$this->cadenaHTML .= $this->boton ( $this->configuracion, $atributos );
		if (! isset ( $atributos ["sinDivision"] )) {
			$this->cadenaHTML .= "</div>\n";
		}
		
		return $this->cadenaHTML;
	}
	function campoBotonRadial($atributos) {
		if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] != "") {
			$this->cadenaHTML = "<div class='" . $atributos ["estilo"] . "'>\n";
		} else {
			$this->cadenaHTML = "<div class='campoBotonRadial'>\n";
		}
		
		if (isset ( $atributos ["etiqueta"] ) && $atributos ["etiqueta"] != "") {
			$this->cadenaHTML .= $this->etiqueta ( $atributos );
		}
		
		$this->cadenaHTML .= $this->radioButton ( $this->configuracion, $atributos );
		$this->cadenaHTML .= "\n</div>\n";
		return $this->cadenaHTML;
	}
	function campoCuadroSeleccion($atributos) {
		$this->cadenaHTML = "";
		
		if (! isset ( $atributos ["sinDivision"] )) {
			
			if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] != "") {
				$this->cadenaHTML .= "<div class='" . $atributos ["estilo"] . "'>\n";
			} else {
				$this->cadenaHTML .= "<div class='campoCuadroSeleccion'>\n";
			}
		}
		$this->cadenaHTML .= $this->checkBox ( $this->configuracion, $atributos );
		if (! isset ( $atributos ["sinDivision"] )) {
			$this->cadenaHTML .= "\n</div>\n";
		}
		return $this->cadenaHTML;
	}
	function campoImagen($atributos) {
		if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] != "") {
			$this->cadenaHTML = "<div class='" . $atributos ["estilo"] . "'>\n";
		} else {
			$this->cadenaHTML = "<div class='campoImagen'>\n";
		}
		
		$this->cadenaHTML .= "<div class='marcoCentrado'>\n";
		$this->cadenaHTML .= "<img src='" . $atributos ["imagen"] . "' ";
		
		if (isset ( $atributos ["etiqueta"] ) && $atributos ["etiqueta"] != "") {
			$this->cadenaHTML .= "alt='" . $atributos ["etiqueta"] . "' ";
		}
		
		if (isset ( $atributos ["borde"] )) {
			$this->cadenaHTML .= "border='" . $atributos ["borde"] . "' ";
		} else {
			$this->cadenaHTML .= "border='0' ";
		}
		
		if (isset ( $atributos ["ancho"] )) {
			if ($atributos ["ancho"] != "") {
				$this->cadenaHTML .= "width='" . $atributos ["ancho"] . "' ";
			}
		} else {
			$this->cadenaHTML .= "width='200px' ";
		}
		
		if (isset ( $atributos ["alto"] )) {
			if ($atributos ["alto"] != "") {
				$this->cadenaHTML .= "height='" . $atributos ["alto"] . "' ";
			}
		} else {
			$this->cadenaHTML .= "height='200px' ";
		}
		$this->cadenaHTML .= " />";
		$this->cadenaHTML .= "</div>\n";
		$this->cadenaHTML .= "</div>\n";
		return $this->cadenaHTML;
	}
	function campoCuadroLista($atributos) {
		if (isset ( $atributos ["columnas"] ) && $atributos ["columnas"] != "" && is_numeric ( $atributos ["columnas"] )) {
			
			$this->cadenaHTML = "<div class='campoCuadroLista anchoColumna" . $atributos ["columnas"] . "'>\n";
		} else {
			$this->cadenaHTML = "<div class='campoCuadroLista'>\n";
		}
		
		$this->cadenaHTML .= $this->etiqueta ( $atributos );
		$this->cadenaHTML .= $this->cuadro_lista ( $atributos );
		$this->cadenaHTML .= "</div>\n";
		
		return $this->cadenaHTML;
	}
	function campoTexto($atributos) {
		if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] != "") {
			if ($atributos ["estilo"] == "jqueryui") {
				$this->cadenaHTML = "<div class='ui-widget ";
			} else {
				$this->cadenaHTML = "<div class='" . $atributos ["estilo"] . " ";
			}
		} else {
			$this->cadenaHTML = "<div class='campoTexto' ";
		}
		
		if (isset ( $atributos ["columnas"] ) && $atributos ["columnas"] != "" && is_numeric ( $atributos ["columnas"] )) {
			$this->cadenaHTML .= " anchoColumna" . $atributos ["columnas"] . "' ";
		} else {
			$this->cadenaHTML .= " anchoColumna1' ";
		}
		
		$this->cadenaHTML .= ">\n";
		if (isset ( $atributos ['etiqueta'] )) {
			$this->cadenaHTML .= "<div class='campoTextoEtiqueta'>\n";
			$this->cadenaHTML .= $atributos ["etiqueta"];
			$this->cadenaHTML .= "\n</div>\n";
			$this->cadenaHTML .= "<div class='campoTextoContenido'>\n";
		} else {
			$this->cadenaHTML .= "<div class='campoTextoContenidoSolo'>\n";
		}
		
		if ($atributos ["texto"] != "") {
			$this->cadenaHTML .= nl2br ( $atributos ["texto"] );
		} else {
			$this->cadenaHTML .= "--";
		}
		$this->cadenaHTML .= "\n</div>\n";
		$this->cadenaHTML .= "\n</div>\n";
		
		return $this->cadenaHTML;
	}
	function campoMensajeEtiqueta($atributos){
		if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] != "") {
			$this->cadenaHTML = "<div class='" . $atributos ["estilo"] . "'>\n";
		} else {
			$this->cadenaHTML = "<div class='campoMensajeEtiqueta'>\n";
		}
		
		if (isset ( $atributos ["estiloEtiqueta"] ) && $atributos ["estiloEtiqueta"] != "") {
			$this->cadenaHTML .= "<div class='" . $atributos ["estiloEtiqueta"] . "'>\n";
		} else {
			$this->cadenaHTML .= "<div class='campoEtiquetaMensaje'>\n";
		}
		$this->cadenaHTML .= $atributos ["etiqueta"];
		$this->cadenaHTML .= "\n</div>\n";
		
		if (isset ( $atributos ["estiloContenido"] ) && $atributos ["estiloContenido"] != "") {
			$this->cadenaHTML .= "<div class='" . $atributos ["estiloContenido"] . "'>\n";
		} else {
			$this->cadenaHTML .= "<div class='campoContenidoMensaje'>\n";
		}
		if ($atributos ["texto"] != "") {
			$this->cadenaHTML .= nl2br ( $atributos ["texto"] );
		} else {
			$this->cadenaHTML .= "--";
		}
		$this->cadenaHTML .= "\n</div>\n";
		$this->cadenaHTML .= "\n</div>\n";
		
		return $this->cadenaHTML;
	}
	function campoMapa($atributos) {
		$this->cadenaCampoMapa = "<div class='campoMapaEtiqueta'>\n";
		$this->cadenaCampoMapa .= $atributos ["etiqueta"];
		$this->cadenaCampoMapa .= "</div>\n";
		$this->cadenaCampoMapa .= "<div class='campoMapa'>\n";
		$this->cadenaCampoMapa .= $this->division ( "inicio", $atributos );
		$this->cadenaCampoMapa .= $this->division ( "fin", $atributos );
		$this->cadenaCampoMapa .= "\n</div>\n";
		
		return $this->cadenaCampoMapa;
	}
	function division($tipo, $atributos = "") {
		$this->cadenaHTML = "";
		if ($tipo == "inicio") {
			if (isset ( $atributos ["estilo"] )) {
				$this->cadenaHTML = "<div class='" . $atributos ["estilo"] . "' ";
			} else {
				$this->cadenaHTML = "<div ";
			}
			
			if (isset ( $atributos ["estiloEnLinea"] ) && $atributos ["estiloEnLinea"] != "") {
				$this->cadenaHTML .= "style='" . $atributos ["estiloEnLinea"] . "' ";
			}
			
			if (isset ( $atributos ["titulo"] )) {
				$this->cadenaHTML .= "title='" . $atributos ["titulo"] . "' ";
			}
			
			$this->cadenaHTML .= "id='" . $atributos ["id"] . "' ";
			// $this->cadenaHTML.="name='".$atributos["id"]."' ";
			$this->cadenaHTML .= ">\n";
		} else {
			
			$this->cadenaHTML .= "\n</div>\n";
		}
		
		return $this->cadenaHTML;
	}
	function enlace($atributos) {
		$this->cadenaHTML = "";
		$this->cadenaHTML .= "<a ";
		
		if (isset ( $atributos ["id"] )) {
			$this->cadenaHTML .= "id='" . $atributos ["id"] . "' ";
		}
		
		if (isset ( $atributos ["enlace"] ) && $atributos ["enlace"] != "") {
			$this->cadenaHTML .= "href='" . $atributos ["enlace"] . "' ";
		}
		
		if (isset ( $atributos ["tabIndex"] )) {
			$this->cadenaHTML .= "tabindex='" . $atributos ["tabIndex"] . "' ";
		}
		
		if (isset ( $atributos ["estilo"] ) && $atributos ["estilo"] != "") {
			
			if ($atributos ["estilo"] == 'jqueryui') {
				$this->cadenaHTML .= " class='botonEnlace ui-widget ui-widget-content ui-state-default ui-corner-all' ";
			} else {
				
				$this->cadenaHTML .= "class='" . $atributos ["estilo"] . "' ";
			}
		}
		$this->cadenaHTML .= ">\n";
		if (isset ( $atributos ["enlaceTexto"] )) {
			$this->cadenaHTML .= "<span>" . $atributos ["enlaceTexto"] . "</span>";
		}
		$this->cadenaHTML .= "</a>\n";
		
		return $this->cadenaHTML;
	}
	function listaNoOrdenada($atributos) {
		$this->cadenaHTML = "<ul>";
		
		foreach ( $atributos ["items"] as $clave => $valor ) {
			$this->cadenaHTML .= "<li>";
			
			// Podría implementarse llamando a $this->enlace
			if (isset ( $atributos ["pestañas"] ) && $atributos ["pestañas"] == "true") {
				$this->cadenaHTML .= "<a id='pes" . $clave . "' href='#" . $clave . "'><div id='tab" . $clave . "'>" . $valor . "</div></a>";
			}
			
			if (isset ( $atributos ["enlaces"] ) && $atributos ["enlaces"] == "true") {
				$enlace=explode('|',$valor);
				$this->cadenaHTML .= "<a href='". $enlace[1] . "'>" . $enlace[0] . "</a>";
			}
			$this->cadenaHTML .= "</li>";
		}
		
		$this->cadenaHTML .= "</ul>";
		
		return $this->cadenaHTML;
	}
} // Fin de la clase FormularioHtml
?>