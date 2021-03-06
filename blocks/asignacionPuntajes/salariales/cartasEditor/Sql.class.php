<?php

namespace asignacionPuntajes\salariales\cartasEditor;

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
				
			case "docente" :
				$cadenaSql=" SELECT";
				$cadenaSql.=" documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido AS value, ";
				$cadenaSql.=" documento_docente AS data ";
				$cadenaSql.=" FROM ";
				$cadenaSql.=" docencia.docente WHERE documento_docente||' - '||primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido ";
				$cadenaSql.=" LIKE '%" . $variable . "%' AND estado = true LIMIT 10;";
				break;
								
			case "consultar" :			
				$cadenaSql=" select ";
				$cadenaSql.=" ce.id_cartas_editor, ";
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
				$cadenaSql .= " '" . $variable ['pais'] . "',";
				$cadenaSql .= " '" . $variable ['categoria'] . "',";
				$cadenaSql .= " '" . $variable ['identificadorColeccion'] . "',";
				$cadenaSql .= " '" . $variable ['anno'] . "',";
				$cadenaSql .= " '" . $variable ['volumen'] . "',";
				$cadenaSql .= " '" . $variable ['numero'] . "',";
				$cadenaSql .= " '" . $variable ['paginas'] . "',";
				$cadenaSql .= " '" . $variable ['tituloArticulo'] . "',";
				$cadenaSql .= " '" . $variable ['numeroAutores'] . "',";
				$cadenaSql .= " " . $variable ['numeroAutoresUniversidad'] . ",";
				$cadenaSql .= " '" . $variable ['fechaPublicacion'] . "' ,";
				$cadenaSql .= " '" . $variable ['numeroActa'] . "',";
				$cadenaSql .= " '" . $variable ['fechaActa'] . "',";
				$cadenaSql .= " '" . $variable ['numeroCasoActa'] . "',";
				$cadenaSql .= " '" . $variable ['puntaje'] . "',";
				$cadenaSql .= " '" . $variable ['normatividad'] . "')";
				break;
				
			case "publicacionActualizar" :
				$cadenaSql=" SELECT ce.documento_docente,";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente,";
				$cadenaSql.=" ce.id_cartas_editor, ";
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
				$cadenaSql.=" WHERE ce.estado=true";
				$cadenaSql.=" and ce.id_cartas_editor ='" . $variable['id_cartas_editor']. "'";
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
				$cadenaSql .= "numero_autores_ud = " . $variable ['numeroAutoresUniversidad'] . ", ";
				$cadenaSql .= "fecha_publicacion = '" . $variable ['fechaPublicacion'] . "', ";
				$cadenaSql .= "numero_acta = '" . $variable ['numeroActa'] . "', ";
				$cadenaSql .= "fecha_acta = '" . $variable ['fechaActa'] . "', ";
				$cadenaSql .= "numero_caso = '" . $variable ['numeroCasoActa'] . "', ";
				$cadenaSql .= "puntaje = '" . $variable ['puntaje'] . "', ";
				$cadenaSql .= "normatividad = '" . $variable ['normatividad'] . "'";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "id_cartas_editor ='" . $variable ['id_cartas_editor'] . "' ";
				break;
		}
		
		return $cadenaSql;
	}
}

?>
