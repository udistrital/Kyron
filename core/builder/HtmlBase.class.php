<?php
include_once ("core/manager/Configurador.class.php");

/**
 * Contiene las definiciones de los diferentes controles HTML
 *
 * Listado de atributos que se requieren para definir el control:
 *
 * $atributos['anchoEtiqueta']: Entero. Define el ancho de la etqiueta en pixeles.
 */
class HtmlBase {
    
    var $conexion_id;
    
    var $cuadro_registro;
    
    var $cuadroCampos;
    
    var $cuadro_miniRegistro;
    
    var $cadenaHTML;
    
    var $configuracion;
    
    var $atributos;
    
    var $miConfigurador;
    
    const NOMBRE = 'nombre';
    
    const SELECCION = 'seleccion';
    
    const EVENTO = 'evento';
    
    const DESHABILITADO = 'deshabilitado';
    
    const ANCHO = 'ancho';
    
    const ALTO = 'alto';
    
    const OTRAOPCIONETIQUETA = 'otraOpcionEtiqueta';
    
    const MULTIPLE = 'multiple';
    
    const VALIDAR = 'validar';
    
    const BASEDATOS = 'baseDatos';
    
    /**
     * Nombres de los atributos que se pueden asignar a los controles,
     * se declaran como constantes para facilitar su cambio ya que se utilizan en varias funciones.
     */
    const ID = 'id';
    
    const TIPO = 'tipo';
    
    const MARCO = 'marco';
    
    const ESTILO = 'estilo';
    
    const ESTILOENLINEA = 'estiloEnLinea';
    
    const ESTILOETIQUETA = 'estiloEtiqueta';
    
    const ESTILOCONTENIDO = 'estiloContenido';
    
    const ESTILOMARCO = 'estiloMarco';
    
    const ESTILOBOTON = 'estiloBoton';
    
    const SINDIVISION = 'sinDivision';
    
    const HIDDEN = 'hidden';
    
    const SELECCIONADO = 'seleccionado';
    
    const MAXIMOTAMANNO = 'maximoTamanno';
    
    const ONCLICK = 'onClick';
    
    const TIPOSUBMIT = 'tipoSubmit';
    
    const TABINDEX = 'tabIndex';
    
    const VALOR = 'valor';
    
    const ETIQUETA = 'etiqueta';
    
    const ANCHOETIQUETA = 'anchoEtiqueta';
    
    const TITULO = 'titulo';
    
    const ESTILOAREA = 'estiloArea';
    
    const TEXTOENRIQUECIDO = 'textoEnriquecido';
    
    const VERIFICARFORMULARIO = 'verificarFormulario';
    
    const NOMBREFORMULARIO = 'nombreFormulario';
    
    const INICIO = 'inicio';
    
    const TIPOFORMULARIO = 'tipoFormulario';
    
    const METODO = 'metodo';
    
    const JQUERYUI = 'jqueryui';
    
    const LEYENDA = 'leyenda';
    
    const ENLACE = 'enlace';
    
    const ENLACECODIFICAR = 'enlaceCodificar';
    
    const COLUMNAS = 'columnas';
    
    const TAMANNO = 'tamanno';
    
    const MENSAJE = 'mensaje';
    
    const TEXTO = 'texto';
    
    const ANCHOCAJA = 'anchoCaja';
    
    /**
     * Atributos HTML
     * Se definen como constantes para evitar errores al duplicar
     */
    const HTMLNAME = 'name=';
    
    const HTMLTABINDEX = 'tabindex=';
    
    const HTMLVALUE = 'value=';
    
    const HTMLCLASS = 'class=';
    
    const HTMLLABEL = '<label for=';
    
    const HTMLENDLABEL = '</label>';
    
    function __construct() {
        
        $this->miConfigurador = Configurador::singleton ();
    
    }
    
    function setAtributos($misAtributos) {
        
        $this->atributos = $misAtributos;
    
    }
    
    public function setConfiguracion($configuracion) {
        
        $this->configuracion = $configuracion;
    
    }
    
    function etiqueta($misAtributos) {
        
        $this->setAtributos ( $misAtributos );
        
        $this->mi_etiqueta = "";
        
        if (! isset ( $this->atributos [self::SINDIVISION] )) {
            if (isset ( $this->atributos [self::ANCHOETIQUETA] )) {
                
                $this->mi_etiqueta .= "<div style='float:left; width:" . $this->atributos [self::ANCHOETIQUETA] . "px' ";
            } else {
                $this->mi_etiqueta .= "<div style='float:left; width:150px' ";
            }
            
            $this->mi_etiqueta .= ">";
        }
        
        $this->mi_etiqueta .= '<label ';
        
        if (isset ( $this->atributos ["estiloEtiqueta"] )) {
            $this->mi_etiqueta .= self::HTMLCLASS . "'" . $this->atributos ["estiloEtiqueta"] . "' ";
        }
        
        $this->mi_etiqueta .= "for='" . $this->atributos [self::ID] . "' >";
        $this->mi_etiqueta .= $this->atributos [self::ETIQUETA] . self::HTMLENDLABEL;
        
        if (isset ( $this->atributos ["etiquetaObligatorio"] ) && $this->atributos ["etiquetaObligatorio"]) {
            $this->mi_etiqueta .= "<span class='texto_rojo texto_pie'>* </span>";
        } else {
            if (! isset ( $this->atributos [self::SINDIVISION] ) && (isset ( $this->atributos [self::ESTILO] ) && $this->atributos [self::ESTILO] != "jqueryui")) {
                $this->mi_etiqueta .= "<span style='white-space:pre;'> </span>";
            }
        }
        
        if (! isset ( $this->atributos [self::SINDIVISION] )) {
            $this->mi_etiqueta .= "</div>\n";
        }
        
        return $this->mi_etiqueta;
    
    }
    
    function campoSeguro($campo = '') {
        
        if (isset ( $_REQUEST ['tiempo'] )) {
            $this->atributos ['tiempo'] = $_REQUEST ['tiempo'];
        }else{
        	$this->atributos ['tiempo'] = '';
        }
        
        if (isset ( $this->atributos ['campoSeguro'] ) && $this->atributos ['campoSeguro'] && $this->atributos [self::ID] != 'formSaraData') {
            $this->atributos [self::ID] = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $this->atributos [self::ID] . $this->atributos ['tiempo'] );
            $this->atributos [self::NOMBRE] = $this->atributos [self::ID];
            if ($campo == 'form') {
                $_REQUEST ['formSecureId'] = $this->atributos [self::ID];
            }
        }
    
    }
    
    function definirEstilo($estilo = '') {
        
        if (! isset ( $this->atributos [self::ESTILO] )) {
            $this->atributos [self::ESTILO] = $estilo;            
        } else {
            
            $this->atributos [self::ESTILO] = str_replace ( 'jqueryui', 'ui-widget ui-widget-content ui-corner-all', $this->atributos [self::ESTILO] );
            $this->atributos [self::ESTILO] = str_replace ( 'jquery', 'ui-widget ui-widget-content ui-corner-all', $this->atributos [self::ESTILO] );
        }
        
        if(isset($this->atributos[self::ESTILOMARCO])){
            $this->atributos [self::ESTILOMARCO]=str_replace ("jqueryui" ,"ui-widget ui-widget-content ui-corner-all", $this->atributos [self::ESTILOMARCO] );
        }
    
    }
    
    /**
     * Crear la cadena para los atributos de id, name, title, tabindex,
     * 
     * @return string
     */
    function definirAtributosGenerales() {
        
        $cadena = '';
        
        if (isset ( $this->atributos [self::TITULO] ) && $this->atributos [self::TITULO] != "") {
            $cadena .= "title='" . $this->atributos [self::TITULO] . "' ";
        }
        
        if (! isset ( $this->atributos [self::ID] ) || $this->atributos [self::ID] == '') {
            $this->atributos [self::ID] = 'controlSara';
        
        }
        $cadena .= "id='" . $this->atributos [self::ID] . "' ";
        
        if (! isset ( $this->atributos [self::NOMBRE] )) {
            $this->atributos [self::NOMBRE] = $this->atributos [self::ID];
        }
        
        $cadena .= self::HTMLNAME . "'" . $this->atributos [self::NOMBRE] . "' ";
        
        if (! isset ( $this->atributos [self::TABINDEX] )) {
            $this->atributos [self::TABINDEX] = 0;
        }
        $cadena .= self::HTMLTABINDEX . "'" . $this->atributos [self::TABINDEX] . "' ";
        
        if (isset ( $this->atributos [self::ESTILOENLINEA] ) && $this->atributos [self::ESTILOENLINEA] != "") {
            $cadena .= "style='" . $this->atributos [self::ESTILOENLINEA] . "' ";
        }
        
        return $cadena;
    
    }
    
}
?>
