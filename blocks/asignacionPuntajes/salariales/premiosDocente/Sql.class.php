<?php

namespace asignacionPuntajes\salariales\premiosDocente;

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
				break;
				
			case "entidadInstitucion" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_universidad,";
				$cadenaSql .= "	nombre_universidad";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.universidad";
				break;
				
			case "tipoEntidadInstitucion" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " id_tipo_entidad,";
				$cadenaSql .= "	nombre_tipo_entidad";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.tipo_entidad";
				break;
				
			case "contexto" :
				$cadenaSql = "select";
				$cadenaSql .= " id_contexto,";
				$cadenaSql .= "	descripcion";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.contexto";
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
				
			case "ciudad" :
				$cadenaSql = "SELECT";
				$cadenaSql .= " ciudadid,";
				$cadenaSql .= "	ciudadnombre";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " docencia.ciudad";
				$cadenaSql .= " WHERE paiscodigo ='" . $variable ."'";
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
				$cadenaSql.=" LIKE '%" . $variable . "%' LIMIT 10;";
				break;
								
			case "consultar" :			
				$cadenaSql=" select ";
				$cadenaSql.=" pd.id_premio_docente, ";
				$cadenaSql.=" pd.documento_docente, ";
				$cadenaSql.=" dc.primer_nombre||' '||dc.segundo_nombre||' '||dc.primer_apellido||' '||dc.segundo_apellido nombre_docente,";
				$cadenaSql.=" un.nombre_universidad AS entidad,";
				$cadenaSql.=" te.nombre_tipo_entidad AS tipo_entidad,";
				$cadenaSql.=" ct.descripcion AS contexto,";
				$cadenaSql.=" pi.paisnombre AS pais,";
				$cadenaSql.=" cd.ciudadnombre AS ciudad,";
				$cadenaSql.=" pd.concepto_premio,";
				$cadenaSql.=" pd.fecha_premio,";
				$cadenaSql.=" pd.numero_condecorados, ";
				$cadenaSql.=" pd.anno_premio,";
				$cadenaSql.=" pd.numero_acta,";
				$cadenaSql.=" pd.fecha_acta,";
				$cadenaSql.=" pd.caso_acta,";
				$cadenaSql.=" pd.puntaje";
				$cadenaSql.=" from ";
				$cadenaSql.=" docencia.premio_docente pd ";
				$cadenaSql.=" left join docencia.docente dc on pd.documento_docente=dc.documento_docente ";
				$cadenaSql.=" left join docencia.docente_proyectocurricular dc_pc on pd.documento_docente=dc_pc.documento_docente ";
				$cadenaSql.=" left join docencia.proyectocurricular pc on dc_pc.id_proyectocurricular=pc.id_proyectocurricular ";
				$cadenaSql.=" left join docencia.facultad fc on pc.id_facultad=fc.id_facultad ";
				$cadenaSql.=" left join docencia.universidad un on pd.id_universidad=un.id_universidad ";
				$cadenaSql.=" left join docencia.tipo_entidad te on pd.id_tipo_entidad=te.id_tipo_entidad ";
				$cadenaSql.=" left join docencia.contexto ct on pd.id_contexto=ct.id_contexto ";
				$cadenaSql.=" left join docencia.pais pi on pd.paiscodigo=pi.paiscodigo ";
				$cadenaSql.=" left join docencia.ciudad cd on pd.ciudadid=cd.ciudadid ";
				$cadenaSql.=" where pd.estado=true";
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
				$cadenaSql = "INSERT INTO docencia.premio_docente( ";
				$cadenaSql .= "documento_docente, id_universidad, otra_entidad, id_tipo_entidad, ";
				$cadenaSql .= "id_contexto, paiscodigo, ciudadid, concepto_premio, fecha_premio, ";
				$cadenaSql .= "numero_condecorados, anno_premio, ";
				$cadenaSql .= "numero_acta, fecha_acta, caso_acta, puntaje) ";
				$cadenaSql .= " VALUES (" . $variable ['id_docenteRegistrar'] . ",";
				$cadenaSql .= " '" . $variable ['entidad'] . "',";
				$cadenaSql .= " '" . $variable ['otraEntidad'] . "',";
				$cadenaSql .= "'" . $variable ['tipoEntidad'] . "',";
				$cadenaSql .= " '" . $variable ['contexto'] . "',";
				$cadenaSql .= " '" . $variable ['pais'] . "',";
				$cadenaSql .= " " . $variable ['ciudad'] . ",";
				$cadenaSql .= " '" . $variable ['conceptoPremio'] . "',";
				$cadenaSql .= " '" . $variable ['fechaPremio'] . "',";
				$cadenaSql .= " '" . $variable ['numeroCondecorados'] . "',";
				$cadenaSql .= " '" . $variable ['anno'] . "',";
				$cadenaSql .= "' " . $variable ['numeroActa'] . "',";
				$cadenaSql .= " '" . $variable ['fechaActa'] . "',";
				$cadenaSql .= "' " . $variable ['numeroCasoActa'] . "',";
				$cadenaSql .= " '" . $variable ['puntaje'] . "')";
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
				$cadenaSql.=" ce.puntaje ";
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
				$cadenaSql .= "puntaje = '" . $variable ['puntaje'] . "'";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "documento_docente ='" . $variable ['id_docenteRegistrar'] . "' ";
				$cadenaSql .= "and numero_issn ='" . $variable ['identificadorColeccion_old'] . "' ";
				break;
		}
		
		return $cadenaSql;
	}
}

?>
