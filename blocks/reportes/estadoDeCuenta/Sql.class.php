<?php

namespace reportes\estadoDeCuenta;

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
			
			/**
			 * Clausulas genéricas.
			 * se espera que estén en todos los formularios
			 * que utilicen esta plantilla
			 */
			case "iniciarTransaccion" :
				$cadenaSql = "START TRANSACTION";
				break;
			
			case "finalizarTransaccion" :
				$cadenaSql = "COMMIT";
				break;
			
			case "cancelarTransaccion" :
				$cadenaSql = "ROLLBACK";
				break;
			
			case "eliminarTemp" :
				
				$cadenaSql = "DELETE ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= $prefijo . "tempFormulario ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "id_sesion = '" . $variable . "' ";
				break;
			
			case "insertarTemp" :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= $prefijo . "tempFormulario ";
				$cadenaSql .= "( ";
				$cadenaSql .= "id_sesion, ";
				$cadenaSql .= "formulario, ";
				$cadenaSql .= "campo, ";
				$cadenaSql .= "valor, ";
				$cadenaSql .= "fecha ";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				
				foreach ( $_REQUEST as $clave => $valor ) {
					$cadenaSql .= "( ";
					$cadenaSql .= "'" . $idSesion . "', ";
					$cadenaSql .= "'" . $variable ['formulario'] . "', ";
					$cadenaSql .= "'" . $clave . "', ";
					$cadenaSql .= "'" . $valor . "', ";
					$cadenaSql .= "'" . $variable ['fecha'] . "' ";
					$cadenaSql .= "),";
				}
				
				$cadenaSql = substr ( $cadenaSql, 0, (strlen ( $cadenaSql ) - 1) );
				break;
			
			case "rescatarTemp" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "id_sesion, ";
				$cadenaSql .= "formulario, ";
				$cadenaSql .= "campo, ";
				$cadenaSql .= "valor, ";
				$cadenaSql .= "fecha ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= $prefijo . "tempFormulario ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "id_sesion='" . $idSesion . "'";
				break;
			
			/* Consultas del desarrollo */
			case "facultad" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_facultad,";
				$cadenaSql .= "	nombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.facultad";
				break;
				
			case "proyectoCurricular" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_proyectocurricular,";
				$cadenaSql .= "	nombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.proyectocurricular";
				$cadenaSql .= " WHERE estado=true";
				break;
				
			case "contexto" :
				$cadenaSql = "select";
				$cadenaSql .= " id_contexto,";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.contexto";
				$cadenaSql .= " WHERE id_contexto != -1";
				break;
				
			case "pais" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " paiscodigo,";
				$cadenaSql .= "	paisnombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.pais";
				if($variable == 1){
					$cadenaSql .= " WHERE paiscodigo = 'COL'";
				}elseif ($variable == 2){
					$cadenaSql .= " WHERE paiscodigo != 'COL'";
				}
				$cadenaSql .= "order by paisnombre";
				break;
				
			case "categoria_revista" :
				$cadenaSql = "select";
				$cadenaSql .= " id_tipo_indexacion,";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_indexacion";
				$cadenaSql .= " WHERE";
				$cadenaSql .= " id_contexto =" . $variable;
				break;
				
			case "datos_docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido AS nombre_docente,";
				$cadenaSql.=" pc.nombre AS proyecto_curricular,";
				$cadenaSql.=" fc.nombre AS facultad,";
				$cadenaSql.=" dc.documento_docente AS documento_docente";
				$cadenaSql.=" FROM";
				$cadenaSql.=" docencia.docente AS dc";
				$cadenaSql.=" LEFT JOIN docencia.docente_proyectocurricular AS dc_pc ON dc_pc.documento_docente = dc.documento_docente";
				$cadenaSql.=" LEFT JOIN docencia.proyectocurricular AS pc ON pc.id_proyectocurricular = dc_pc.id_proyectocurricular";
				$cadenaSql.=" LEFT JOIN docencia.facultad AS fc ON fc.id_facultad = pc.id_facultad";
				$cadenaSql.=" WHERE dc.documento_docente='". $variable."'";
				$cadenaSql.=" ;";
				break;
				
			case "titulos_docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" ta.titulo AS titulo,";
				$cadenaSql.=" ta.fecha_acta AS fecha_acta,";
				$cadenaSql.=" ta.numero_acta AS numero_acta,";
				$cadenaSql.=" ta.puntaje AS puntaje,";
				$cadenaSql.=" tta.tipo AS tipo_titulo_academico";
				$cadenaSql.=" FROM docencia.titulo_academico AS ta";
				$cadenaSql.=" LEFT JOIN docencia.tipo_titulo_academico AS tta ON tta.id_tipo_titulo_academico = ta.id_tipo_titulo_academico";
				$cadenaSql.=" WHERE ta.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY ta.id_tipo_titulo_academico ASC";				
				$cadenaSql.=" ;";
				break;
				
			case "experiencia_calificada" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" tec.descripcion AS tipo_experiencia_calificada,";
				$cadenaSql.=" ec.fecha_acta AS fecha_acta,";
				$cadenaSql.=" ec.numero_acta AS numero_acta,";
				$cadenaSql.=" ec.puntaje AS puntaje,";
				$cadenaSql.=" ter.descripcion AS tipo_emisor_resolucion";
				$cadenaSql.=" FROM docencia.experiencia_calificada AS ec";
				$cadenaSql.=" LEFT JOIN docencia.tipo_experiencia_calificada AS tec ON tec.id_tipo_experiencia_calificada = ec.id_tipo_experiencia_calificada";
				$cadenaSql.=" LEFT JOIN docencia.tipo_emisor_resolucion AS ter ON ter.id_tipo_emisor_resolucion = ec.id_tipo_emisor_resolucion";
				$cadenaSql.=" WHERE ec.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY ec.id_tipo_emisor_resolucion ASC";
				$cadenaSql.=" ;";
				break;
			
			case "direccion_de_trabajos" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" ttg.nombre_tipo_trabajogrado AS tipo_trabajogrado,";
				$cadenaSql.=" dtg.fecha_acta AS fecha_acta,";
				$cadenaSql.=" dtg.numero_acta AS numero_acta,";
				$cadenaSql.=" dtg.puntaje AS puntaje,";
				$cadenaSql.=" dtg.titulo_trabajogrado AS titulo_trabajogrado,";
				$cadenaSql.=" ctg.nombre_categoria_trabajogrado AS nombre_categoria_trabajogrado";
				$cadenaSql.=" FROM docencia.direccion_trabajogrado AS dtg";
				$cadenaSql.=" LEFT JOIN docencia.tipo_trabajogrado AS ttg ON ttg.id_tipo_trabajogrado = dtg.id_tipo_trabajogrado";
				$cadenaSql.=" LEFT JOIN docencia.categoria_trabajogrado AS ctg ON ctg.id_categoria_trabajogrado = dtg.id_categoria_trabajogrado";
				$cadenaSql.=" WHERE dtg.documento_docente='". $variable."'";
				$cadenaSql.=" ORDER BY ttg.nombre_tipo_trabajogrado ASC";
				$cadenaSql.=" ;";
				break;
				
			case "experiencia_actividades_administrativas" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" u.nombre_universidad AS nombre_universidad,";
				$cadenaSql.=" eda.fecha_acta AS fecha_acta,";
				$cadenaSql.=" eda.numero_acta AS numero_acta,";
				$cadenaSql.=" eda.puntaje AS puntaje,";
				$cadenaSql.=" te.nombre_tipo_entidad AS nombre_tipo_entidad";
				$cadenaSql.=" FROM docencia.experiencia_direccion_academica AS eda";
				$cadenaSql.=" LEFT JOIN docencia.tipo_entidad AS te ON te.id_tipo_entidad = eda.id_tipo_entidad";
				$cadenaSql.=" LEFT JOIN docencia.universidad AS u ON u.id_universidad = eda.id_universidad";
				$cadenaSql.=" ORDER BY te.nombre_tipo_entidad ASC";
				$cadenaSql.=" ;";
				break;
				
			case "novedades" :
				
				break;
				
			case "consultar" :			
				$cadenaSql=" select ";
				$cadenaSql.=" ce.documento_docente, ";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente,";
				$cadenaSql.=" ce.nombre_revista, ce.titulo_articulo, pi.paisnombre, ti.descripcion as tipo_indexacion,";
				$cadenaSql.=" ce.numero_issn, ce.anno_publicacion,";
				$cadenaSql.=" ce.volumen_revista, ce.numero_revista,";
				$cadenaSql.=" ce.paginas_revista,";
				$cadenaSql.=" ce.fecha_publicacion ";
				$cadenaSql.=" from ";
				$cadenaSql.=" docencia.cartas_editor ce ";
				$cadenaSql.=" left join docencia.docente dc on ce.documento_docente=dc.documento_docente ";
				$cadenaSql.=" left join docencia.docente_proyectocurricular dc_pc on ce.documento_docente=dc_pc.documento_docente ";
				$cadenaSql.=" left join docencia.proyectocurricular pc on dc_pc.id_proyectocurricular=pc.id_proyectocurricular ";
				$cadenaSql.=" left join docencia.facultad fc on pc.id_facultad=fc.id_facultad ";
				$cadenaSql.=" left join docencia.pais pi on ce.paiscodigo=pi.paiscodigo ";
				$cadenaSql.=" left join docencia.tipo_indexacion ti ON ti.id_tipo_indexacion = ce.id_tipo_indexacion";
				$cadenaSql.=" where ce.estado=true";
				$cadenaSql.=" and dc.estado=true";
				$cadenaSql.=" and pc.estado=true";
				$cadenaSql.=" and dc_pc.estado=true";
				if ($variable ['documento_docente'] != '') {
					$cadenaSql .= " AND dc.documento_docente = '" . $variable ['documento_docente'] . "'";
				}
				if ($variable ['id_facultad'] != '') {
					$cadenaSql .= " AND fc.id_facultad = '" . $variable ['id_facultad'] . "'";
				}
				if ($variable ['id_proyectocurricular'] != '') {
					$cadenaSql .= " AND pc.id_proyectocurricular = '" . $variable ['id_proyectocurricular'] . "'";
				}
				break;
				
			case "registrar" :
				$cadenaSql = "INSERT INTO docencia.cartas_editor( ";
				$cadenaSql .= "documento_docente, nombre_revista, id_contexto, paiscodigo, ";
				$cadenaSql .= "id_tipo_indexacion, ";
				$cadenaSql .= "numero_issn, anno_publicacion, volumen_revista, numero_revista, paginas_revista, ";
				$cadenaSql .= "titulo_articulo, numero_autores, numero_autores_ud, fecha_publicacion, ";
				$cadenaSql .= "numero_acta, fecha_acta, numero_caso, puntaje, normatividad) ";
				$cadenaSql .= " VALUES (" . $variable ['id_docenteRegistrar'] . ",";
				$cadenaSql .= " '" . $variable ['nombre'] . "',";
				$cadenaSql .= " '" . $variable ['contexto'] . "',";
				$cadenaSql .= "'" . $variable ['pais'] . "',";
				$cadenaSql .= " '" . $variable ['categoria'] . "',";
				$cadenaSql .= " '" . $variable ['identificadorColeccion'] . "',";
				$cadenaSql .= " '" . $variable ['anno'] . "',";
				$cadenaSql .= " '" . $variable ['volumen'] . "',";
				$cadenaSql .= " '" . $variable ['numero'] . "',";
				$cadenaSql .= " '" . $variable ['paginas'] . "',";
				$cadenaSql .= " '" . $variable ['tituloArticulo'] . "',";
				$cadenaSql .= " '" . $variable ['numeroAutores'] . "',";
				$cadenaSql .= " '" . $variable ['numeroAutoresUniversidad'] . "',";
				$cadenaSql .= "' " . $variable ['fechaPublicacion'] . "' ,";
				$cadenaSql .= "' " . $variable ['numeroActa'] . "',";
				$cadenaSql .= " '" . $variable ['fechaActa'] . "',";
				$cadenaSql .= "' " . $variable ['numeroCasoActa'] . "',";
				$cadenaSql .= "' " . $variable ['puntaje'] . "',";
				$cadenaSql .= " '" . $variable ['normatividad'] . "')";
				break;
				
			case "publicacionActualizar" :
				$cadenaSql=" SELECT ce.documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente,";
				$cadenaSql.=" ce.nombre_revista, ";
				$cadenaSql.=" ce.id_contexto, ";
				$cadenaSql.=" ce.paiscodigo, ";
				$cadenaSql.=" ce.id_tipo_indexacion, ";
				$cadenaSql.=" ce.numero_issn, ";
				$cadenaSql.=" ce.anno_publicacion, ";
				$cadenaSql.=" ce.volumen_revista, ";
				$cadenaSql.=" ce.numero_revista, ";
				$cadenaSql.=" ce.paginas_revista, ";
				$cadenaSql.=" ce.titulo_articulo, ";
				$cadenaSql.=" ce.numero_autores, ";
				$cadenaSql.=" ce.numero_autores_ud, ";
				$cadenaSql.=" ce.fecha_publicacion, ";
				$cadenaSql.=" ce.numero_acta, ";
				$cadenaSql.=" ce.fecha_acta, ";
				$cadenaSql.=" ce.numero_caso, ";
				$cadenaSql.=" ce.puntaje, ";
				$cadenaSql.=" ce.normatividad ";
				$cadenaSql.=" FROM docencia.cartas_editor ce ";
				$cadenaSql.=" left join docencia.docente dc on ce.documento_docente=dc.documento_docente ";
				$cadenaSql.=" WHERE ce.documento_docente ='" . $variable['documento_docente']. "'";
				$cadenaSql.=" and ce.estado=true";
				$cadenaSql.=" and ce.numero_issn ='" . $variable['identificadorColeccion']. "'";
				break;
				
			case "actualizar" :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "docencia.cartas_editor ";
				$cadenaSql .= "SET ";
				$cadenaSql .= "nombre_revista = '" . $variable ['nombre'] . "', ";
				$cadenaSql .= "id_contexto = '" . $variable ['contexto'] . "', ";
				$cadenaSql .= "paiscodigo = '" . $variable ['pais'] . "', ";
				$cadenaSql .= "id_tipo_indexacion = '" . $variable ['categoria'] . "', ";
				$cadenaSql .= "numero_issn = '" . $variable ['identificadorColeccion'] . "', ";
				$cadenaSql .= "anno_publicacion = '" . $variable ['anno'] . "', ";
				$cadenaSql .= "volumen_revista = '" . $variable ['volumen'] . "', ";
				$cadenaSql .= "numero_revista = '" . $variable ['numero'] . "', ";
				$cadenaSql .= "paginas_revista = '" . $variable ['paginas'] . "', ";
				$cadenaSql .= "titulo_articulo = '" . $variable ['tituloArticulo'] . "', ";
				$cadenaSql .= "numero_autores = '" . $variable ['numeroAutores'] . "', ";
				$cadenaSql .= "numero_autores_ud = '" . $variable ['numeroAutoresUniversidad'] . "', ";
				$cadenaSql .= "fecha_publicacion = '" . $variable ['fechaPublicacion'] . "', ";
				$cadenaSql .= "numero_acta = '" . $variable ['numeroActa'] . "', ";
				$cadenaSql .= "fecha_acta = '" . $variable ['fechaActa'] . "', ";
				$cadenaSql .= "numero_caso = '" . $variable ['numeroCasoActa'] . "', ";
				$cadenaSql .= "puntaje = '" . $variable ['puntaje'] . "', ";
				$cadenaSql .= "normatividad = '" . $variable ['normatividad'] . "'";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "documento_docente ='" . $variable ['id_docenteRegistrar'] . "' ";
				$cadenaSql .= "and numero_issn ='" . $variable ['identificadorColeccion_old'] . "' ";
				break;
		}
		
		return $cadenaSql;
	}
}

?>
