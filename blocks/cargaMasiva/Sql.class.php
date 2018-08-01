<?php

namespace cargaMasiva;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class Sql extends \Sql {
	var $miConfigurador;
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
	}
	function getCadenaSql($tipo, $variable = "") {
		
		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		
		switch ($tipo) {
			
			case "buscarCategoria":
			    $cadenaSql="SELECT * FROM docencia.categoria_docente ";
			    $cadenaSql.=" WHERE ";
			    $cadenaSql.=" documento_docente='".$variable['documento_docente']."' ";
			    $cadenaSql.=" AND tipo_categoria_docente = ( ";
			    $cadenaSql.=" SELECT ";
			    $cadenaSql.=" id_categoria_actual_docente ";
			    $cadenaSql.=" FROM ";
			    $cadenaSql.=" docencia.categoria_actual_docente ";
			    $cadenaSql.=" WHERE ";
			    $cadenaSql.=" categoria_actual='".$variable['categoria_docente']."' ";
			    $cadenaSql.=" ) ";
			    $cadenaSql.=" AND motivo_categoria_docente = ( ";
			    $cadenaSql.=" SELECT ";
			    $cadenaSql.=" id ";
			    $cadenaSql.=" FROM ";
			    $cadenaSql.=" docencia.motivo_categoria_docente ";
			    $cadenaSql.=" WHERE nombre='".$variable['motivo_categoria_docente']."' ";
			    $cadenaSql.=" ) ";
			    $cadenaSql.=" AND nombre_produccion='".$variable['nombre_produccion']."' ";
			    $cadenaSql.=" AND nombre_titulo='".$variable['nombre_titulo']."' ";
			    $cadenaSql.=" AND numero_acta='".$variable['numero_acta']."' ";
			    $cadenaSql.=" AND fecha_acta='".$variable['fecha_acta']."' ";
			    $cadenaSql.=" AND numero_caso='".$variable['numero_caso']."' ";
			    $cadenaSql.=" AND puntaje='".$variable['puntaje']."' ";
			    $cadenaSql.=" ; ";
			    break;
			    
			case "insertarCategoria":
			    $cadenaSql="INSERT INTO docencia.categoria_docente ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" documento_docente, ";
			    $cadenaSql.=" tipo_categoria_docente, ";
			    $cadenaSql.=" motivo_categoria_docente, ";
			    $cadenaSql.=" nombre_produccion, ";
			    $cadenaSql.=" nombre_titulo, ";
			    $cadenaSql.=" numero_acta, ";
			    $cadenaSql.=" fecha_acta, ";
			    $cadenaSql.=" numero_caso, ";
			    $cadenaSql.=" puntaje, ";
			    $cadenaSql.=" estado ";
			    $cadenaSql.=" ) ";
			    $cadenaSql.=" VALUES ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" '".$variable['documento_docente']."', ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" SELECT ";
			    $cadenaSql.=" id_categoria_actual_docente ";
			    $cadenaSql.=" FROM ";
			    $cadenaSql.=" docencia.categoria_actual_docente ";
			    $cadenaSql.=" WHERE ";
			    $cadenaSql.=" categoria_actual='".$variable['categoria_docente']."' ";
			    $cadenaSql.=" ), ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" SELECT ";
			    $cadenaSql.=" id ";
			    $cadenaSql.=" FROM ";
			    $cadenaSql.=" docencia.motivo_categoria_docente ";
			    $cadenaSql.=" WHERE nombre='".$variable['motivo_categoria_docente']."' ";
			    $cadenaSql.=" ), ";
			    $cadenaSql.=" '".$variable['nombre_produccion']."', ";
			    $cadenaSql.=" '".$variable['nombre_titulo']."', ";
			    $cadenaSql.=" '".$variable['numero_acta']."', ";
			    $cadenaSql.=" '".$variable['fecha_acta']."', ";
			    $cadenaSql.=" '".$variable['numero_caso']."', ";
			    $cadenaSql.=" '".$variable['puntaje']."', ";
			    $cadenaSql.=" 'true' ";
			    $cadenaSql.=" ); ";
			    break;
			    
			case "buscarRevista":
			    $cadenaSql="SELECT * FROM docencia.revista_indexada ";
			    $cadenaSql.=" WHERE ";
			    $cadenaSql.=" id_contexto='1' ";
			    $cadenaSql.=" AND paiscodigo='COL' ";
			    $cadenaSql.=" AND documento_docente='".$variable['documento_docente']."' ";
			    $cadenaSql.=" AND nombre_revista='".$variable['nombre_revista']."' ";
			    $cadenaSql.=" AND id_tipo_indexacion=( ";
			    $cadenaSql.=" SELECT ";
			    $cadenaSql.=" id_tipo_indexacion ";
			    $cadenaSql.=" FROM ";
			    $cadenaSql.=" docencia.tipo_indexacion ";
			    $cadenaSql.=" WHERE descripcion='".$variable['tipo_indexacion']."' ";
			    $cadenaSql.=" ) ";
			    $cadenaSql.=" AND numero_issn='".$variable['numero_issn']."' ";
			    $cadenaSql.=" AND anno_publicacion='".$variable['anno_publicacion']."' ";
			    $cadenaSql.=" AND volumen_revista='".$variable['volumen_revista']."' ";
			    $cadenaSql.=" AND numero_revista='".$variable['numero_revista']."' ";
			    $cadenaSql.=" AND paginas_revista='".$variable['paginas_revista']."' ";
			    $cadenaSql.=" AND titulo_articulo='".$variable['titulo_articulo']."' ";
			    $cadenaSql.=" AND numero_autores='".$variable['numero_autores']."' ";
			    $cadenaSql.=" AND numero_autores_ud='".$variable['numero_autores_ud']."' ";
			    $cadenaSql.=" AND numero_acta='".$variable['numero_acta']."' ";
			    $cadenaSql.=" AND fecha_acta='".$variable['fecha_acta']."' ";
			    $cadenaSql.=" AND numero_caso='".$variable['numero_caso']."' ";
			    $cadenaSql.=" AND puntaje='".$variable['puntaje']."' ";
			    $cadenaSql.=" AND normatividad='".$variable['normatividad']."' ";
			    $cadenaSql.=" ; ";
			    break;
			    
			case "insertarRevista":
			    $cadenaSql="INSERT INTO docencia.revista_indexada ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" id_contexto, ";
			    $cadenaSql.=" paiscodigo, ";
			    $cadenaSql.=" documento_docente, ";
			    $cadenaSql.=" nombre_revista, ";
			    $cadenaSql.=" id_tipo_indexacion, ";
			    $cadenaSql.=" numero_issn, ";
			    $cadenaSql.=" anno_publicacion, ";
			    $cadenaSql.=" volumen_revista, ";
			    $cadenaSql.=" numero_revista, ";
			    $cadenaSql.=" paginas_revista, ";
			    $cadenaSql.=" titulo_articulo, ";
			    $cadenaSql.=" numero_autores, ";
			    $cadenaSql.=" numero_autores_ud, ";
			    $cadenaSql.=" numero_acta, ";
			    $cadenaSql.=" fecha_acta, ";
			    $cadenaSql.=" numero_caso, ";
			    $cadenaSql.=" puntaje, ";
			    $cadenaSql.=" normatividad, ";
			    $cadenaSql.=" estado ";
			    $cadenaSql.=" ) ";
			    $cadenaSql.=" VALUES ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" '1', ";
			    $cadenaSql.=" 'COL', ";
			    $cadenaSql.=" '".$variable['documento_docente']."', ";
			    $cadenaSql.=" '".$variable['nombre_revista']."', ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" SELECT ";
			    $cadenaSql.=" id_tipo_indexacion ";
			    $cadenaSql.=" FROM ";
			    $cadenaSql.=" docencia.tipo_indexacion ";
			    $cadenaSql.=" WHERE descripcion='".$variable['tipo_indexacion']."' ";
			    $cadenaSql.=" ), ";
			    $cadenaSql.=" '".$variable['numero_issn']."', ";
			    $cadenaSql.=" '".$variable['anno_publicacion']."', ";
			    $cadenaSql.=" '".$variable['volumen_revista']."', ";
			    $cadenaSql.=" '".$variable['numero_revista']."', ";
			    $cadenaSql.=" '".$variable['paginas_revista']."', ";
			    $cadenaSql.=" '".$variable['titulo_articulo']."', ";
			    $cadenaSql.=" '".$variable['numero_autores']."', ";
			    $cadenaSql.=" '".$variable['numero_autores_ud']."', ";
			    $cadenaSql.=" '".$variable['numero_acta']."', ";
			    $cadenaSql.=" '".$variable['fecha_acta']."', ";
			    $cadenaSql.=" '".$variable['numero_caso']."', ";
			    $cadenaSql.=" '".$variable['puntaje']."', ";
			    $cadenaSql.=" '".$variable['normatividad']."', ";
			    $cadenaSql.=" 'true' ";
			    $cadenaSql.=" ); ";
			    break;
			    
			case "buscarCapituloDeLibro":
			    $cadenaSql="SELECT * FROM docencia.capitulo_libro ";
			    $cadenaSql.=" WHERE ";
			    $cadenaSql.=" documento_docente='".$variable['documento_docente']."' ";
			    $cadenaSql.=" AND titulo_capitulo='".$variable['titulo_capitulo']."' ";
			    $cadenaSql.=" AND titulo_libro='".$variable['titulo_libro']."' ";
			    $cadenaSql.=" AND id_tipo_libro=( ";
			    $cadenaSql.=" SELECT id_tipo_libro ";
			    $cadenaSql.=" FROM docencia.tipo_libro ";
			    $cadenaSql.=" WHERE tipo_libro='".$variable['tipo_libro']."' ";
			    $cadenaSql.=" ) ";
			    $cadenaSql.=" AND codigo_isbn='".$variable['codigo_isbn']."' ";
			    $cadenaSql.=" AND id_editorial=( ";
			    $cadenaSql.=" SELECT id_editorial ";
			    $cadenaSql.=" FROM docencia.editorial ";
			    $cadenaSql.=" WHERE nombre_editorial='".$variable['editorial']."' ";
			    $cadenaSql.=" ) ";
			    $cadenaSql.=" AND anno_publicacion='".$variable['anno_publicacion']."' ";
			    $cadenaSql.=" AND volumen='".$variable['volumen']."' ";
			    $cadenaSql.=" AND numero_autores_capitulo='".$variable['numero_autores_capitulo']."' ";
			    $cadenaSql.=" AND numero_autores_capitulo_ud='".$variable['numero_autores_capitulo_ud']."' ";
			    $cadenaSql.=" AND numero_autores_libro='".$variable['numero_autores_libro']."' ";
			    $cadenaSql.=" AND numero_autores_libro_ud='".$variable['numero_autores_libro_ud']."' ";
			    $cadenaSql.=" AND numero_acta='".$variable['numero_acta']."' ";
			    $cadenaSql.=" AND fecha_acta='".$variable['fecha_acta']."' ";
			    $cadenaSql.=" AND numero_caso='".$variable['numero_caso']."' ";
			    $cadenaSql.=" AND puntaje='".$variable['puntaje']."' ";
			    $cadenaSql.=" AND normatividad='".$variable['normatividad']."' ";
			    $cadenaSql.=" AND estado='true' ";
			    $cadenaSql.=" ; ";
			    break;
			    
			case "insertarCapituloDeLibro":
			    $cadenaSql="INSERT INTO docencia.capitulo_libro ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" documento_docente, ";
			    $cadenaSql.=" titulo_capitulo, ";
			    $cadenaSql.=" titulo_libro, ";
			    $cadenaSql.=" id_tipo_libro, ";
			    $cadenaSql.=" codigo_isbn, ";
			    $cadenaSql.=" id_editorial, ";
			    $cadenaSql.=" anno_publicacion, ";
			    $cadenaSql.=" volumen, ";
			    $cadenaSql.=" numero_autores_capitulo, ";
			    $cadenaSql.=" numero_autores_capitulo_ud, ";
			    $cadenaSql.=" numero_autores_libro, ";
			    $cadenaSql.=" numero_autores_libro_ud, ";
			    $cadenaSql.=" numero_acta, ";
			    $cadenaSql.=" fecha_acta, ";
			    $cadenaSql.=" numero_caso, ";
			    $cadenaSql.=" puntaje, ";
			    $cadenaSql.=" normatividad, ";
			    $cadenaSql.=" estado ";
			    $cadenaSql.=" ) ";
			    $cadenaSql.=" VALUES ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" '".$variable['documento_docente']."', ";
			    $cadenaSql.=" '".$variable['titulo_capitulo']."', ";
			    $cadenaSql.=" '".$variable['titulo_libro']."', ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" SELECT id_tipo_libro ";
			    $cadenaSql.=" FROM docencia.tipo_libro ";
			    $cadenaSql.=" WHERE tipo_libro='".$variable['tipo_libro']."' ";
			    $cadenaSql.=" ), ";
			    $cadenaSql.=" '".$variable['codigo_isbn']."', ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" SELECT id_editorial ";
			    $cadenaSql.=" FROM docencia.editorial ";
			    $cadenaSql.=" WHERE nombre_editorial='".$variable['editorial']."' ";
			    $cadenaSql.=" ), ";
			    $cadenaSql.=" '".$variable['anno_publicacion']."', ";
			    $cadenaSql.=" '".$variable['volumen']."', ";
			    $cadenaSql.=" '".$variable['numero_autores_capitulo']."', ";
			    $cadenaSql.=" '".$variable['numero_autores_capitulo_ud']."', ";
			    $cadenaSql.=" '".$variable['numero_autores_libro']."', ";
			    $cadenaSql.=" '".$variable['numero_autores_libro_ud']."', ";
			    $cadenaSql.=" '".$variable['numero_acta']."', ";
			    $cadenaSql.=" '".$variable['fecha_acta']."', ";
			    $cadenaSql.=" '".$variable['numero_caso']."', ";
			    $cadenaSql.=" '".$variable['puntaje']."', ";
			    $cadenaSql.=" '".$variable['normatividad']."', ";
			    $cadenaSql.=" 'true' ";
			    $cadenaSql.=" ); ";
			    break;
			    
			case "buscarCartaAlEditor":
			    $cadenaSql="SELECT * FROM docencia.cartas_editor ";
			    $cadenaSql.=" WHERE ";
			    $cadenaSql.=" documento_docente='".$variable['documento_docente']."' ";
			    $cadenaSql.=" AND nombre_revista='".$variable['nombre_revista']."' ";
			    $cadenaSql.=" AND id_contexto=( ";
			    $cadenaSql.=" SELECT id_contexto ";
			    $cadenaSql.=" FROM docencia.contexto ";
			    $cadenaSql.=" WHERE descripcion='".$variable['contexto']."' ";
			    $cadenaSql.=" ) ";
			    $cadenaSql.=" AND paiscodigo=( ";
			    $cadenaSql.=" SELECT paiscodigo ";
			    $cadenaSql.=" FROM docencia.pais ";
			    $cadenaSql.=" WHERE paisnombre='".$variable['paisnombre']."' ";
			    $cadenaSql.=" ) ";
			    $cadenaSql.=" AND id_tipo_indexacion=( ";
			    $cadenaSql.=" SELECT ";
			    $cadenaSql.=" id_tipo_indexacion ";
			    $cadenaSql.=" FROM ";
			    $cadenaSql.=" docencia.tipo_indexacion ";
			    $cadenaSql.=" WHERE descripcion='".$variable['tipo_indexacion']."' ";
			    $cadenaSql.=" ) ";
			    $cadenaSql.=" AND numero_issn='".$variable['numero_issn']."' ";
			    $cadenaSql.=" AND anno_publicacion='".$variable['anno_publicacion']."' ";
			    $cadenaSql.=" AND volumen_revista='".$variable['volumen_revista']."' ";
			    $cadenaSql.=" AND numero_revista='".$variable['numero_revista']."' ";
			    $cadenaSql.=" AND paginas_revista='".$variable['paginas_revista']."' ";
			    $cadenaSql.=" AND titulo_articulo='".$variable['titulo_articulo']."' ";
			    $cadenaSql.=" AND numero_autores='".$variable['numero_autores']."' ";
			    $cadenaSql.=" AND numero_autores_ud='".$variable['numero_autores_ud']."' ";
			    $cadenaSql.=" AND fecha_publicacion='".$variable['fecha_publicacion']."' ";
			    $cadenaSql.=" AND numero_acta='".$variable['numero_acta']."' ";
			    $cadenaSql.=" AND fecha_acta='".$variable['fecha_acta']."' ";
			    $cadenaSql.=" AND numero_caso='".$variable['numero_caso']."' ";
			    $cadenaSql.=" AND puntaje='".$variable['puntaje']."' ";
			    $cadenaSql.=" AND normatividad='".$variable['normatividad']."' ";
			    $cadenaSql.=" AND estado='true' ";
			    $cadenaSql.=" ; ";
			    break;
			    
			case "insertarCartaAlEditor":
			    $cadenaSql="INSERT INTO docencia.cartas_editor ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" documento_docente, ";
			    $cadenaSql.=" nombre_revista, ";
			    $cadenaSql.=" id_contexto, ";
			    $cadenaSql.=" paiscodigo, ";
			    $cadenaSql.=" id_tipo_indexacion, ";
			    $cadenaSql.=" numero_issn, ";
			    $cadenaSql.=" anno_publicacion, ";
			    $cadenaSql.=" volumen_revista, ";
			    $cadenaSql.=" numero_revista, ";
			    $cadenaSql.=" paginas_revista, ";
			    $cadenaSql.=" titulo_articulo, ";
			    $cadenaSql.=" numero_autores, ";
			    $cadenaSql.=" numero_autores_ud, ";
			    $cadenaSql.=" fecha_publicacion, ";
			    $cadenaSql.=" numero_acta, ";
			    $cadenaSql.=" fecha_acta, ";
			    $cadenaSql.=" numero_caso, ";
			    $cadenaSql.=" puntaje, ";
			    $cadenaSql.=" normatividad, ";
			    $cadenaSql.=" estado ";
			    $cadenaSql.=" ) ";
			    $cadenaSql.=" VALUES ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" '".$variable['documento_docente']."', ";
			    $cadenaSql.=" '".$variable['nombre_revista']."', ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" SELECT id_contexto ";
			    $cadenaSql.=" FROM docencia.contexto ";
			    $cadenaSql.=" WHERE descripcion='".$variable['contexto']."' ";
			    $cadenaSql.=" ), ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" SELECT paiscodigo ";
			    $cadenaSql.=" FROM docencia.pais ";
			    $cadenaSql.=" WHERE paisnombre='".$variable['paisnombre']."' ";
			    $cadenaSql.=" ), ";
			    $cadenaSql.=" ( ";
			    $cadenaSql.=" SELECT ";
			    $cadenaSql.=" id_tipo_indexacion ";
			    $cadenaSql.=" FROM ";
			    $cadenaSql.=" docencia.tipo_indexacion ";
			    $cadenaSql.=" WHERE descripcion='".$variable['tipo_indexacion']."' ";
			    $cadenaSql.=" ), ";
			    $cadenaSql.=" '".$variable['numero_issn']."', ";
			    $cadenaSql.=" '".$variable['anno_publicacion']."', ";
			    $cadenaSql.=" '".$variable['volumen_revista']."', ";
			    $cadenaSql.=" '".$variable['numero_revista']."', ";
			    $cadenaSql.=" '".$variable['paginas_revista']."', ";
			    $cadenaSql.=" '".$variable['titulo_articulo']."', ";
			    $cadenaSql.=" '".$variable['numero_autores']."', ";
			    $cadenaSql.=" '".$variable['numero_autores_ud']."', ";
			    $cadenaSql.=" '".$variable['fecha_publicacion']."', ";
			    $cadenaSql.=" '".$variable['numero_acta']."', ";
			    $cadenaSql.=" '".$variable['fecha_acta']."', ";
			    $cadenaSql.=" '".$variable['numero_caso']."', ";
			    $cadenaSql.=" '".$variable['puntaje']."', ";
			    $cadenaSql.=" '".$variable['normatividad']."', ";
			    $cadenaSql.=" 'true' ";
			    $cadenaSql.=" ); ";
		}
		
		return $cadenaSql;
	}
}

?>
