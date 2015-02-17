<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlTitulosAcademicos extends sql {


	var $miConfigurador;


	function __construct(){
		$this->miConfigurador=Configurador::singleton();
	}


	function cadena_sql($tipo,$variable="") {
			
		/**
		 * 1. Revisar las variables para evitar SQL Injection
		 *
		 */

		$prefijo=$this->miConfigurador->getVariableConfiguracion("prefijo");
		$idSesion=$this->miConfigurador->getVariableConfiguracion("id_sesion");
			
		switch($tipo) {

			case "buscarNombreDocente" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "informacion_numeroidentificacion, ";
				$cadena_sql .= "informacion_numeroidentificacion || ' - ' || UPPER(informacion_nombres)|| ' ' ||UPPER(informacion_apellidos) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.docente_informacion ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "informacion_estadoregistro = TRUE  ";
                                
                                if($variable != '')
                                    {
                                        if(is_numeric($variable))
                                        {
                                            $cadena_sql .= " AND  informacion_numeroidentificacion like '%".$variable."%'  ";
                                        }else
                                            {
                                                $cadena_sql .= " AND  ((UPPER(informacion_nombres) like '%".strtoupper($variable)."%') OR (UPPER(informacion_apellidos) like '%".strtoupper($variable)."%'))  ";
                                            }
                                    }
                                
				
				break;

			case "buscarTitulosDocente" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= " id_titulo, id_docente, id_nivelformacion, cons_titu ";
				$cadena_sql .= " FROM ";
				$cadena_sql .= " docencia.titulos_academicos ";
				$cadena_sql .= " WHERE id_docente = '".$variable[0]."'";
				$cadena_sql .= " AND id_nivelformacion = '".$variable[1]."'";

				break;

                        case "buscarProyectos" :

                            $cadena_sql = "SELECT codigo_proyecto, nombre_proyecto ";
                            $cadena_sql .= "FROM docencia.proyectocurricular ";
                            $cadena_sql .= " WHERE id_facultad = '".$variable."' ";
                            $cadena_sql .= "ORDER BY nombre_proyecto";
                            break;
			    
                            
			case "validarMaestriaDocente" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= " id_titulo, id_docente, id_nivelformacion ";
				$cadena_sql .= " FROM ";
				$cadena_sql .= " docencia.titulos_academicos ";
				$cadena_sql .= " WHERE id_docente = '".$variable[0]."'";
				$cadena_sql .= " AND id_nivelformacion = '3'";

				break;
					
			case "validarPregradoDocente" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= " id_titulo, id_docente, id_nivelformacion ";
				$cadena_sql .= " FROM ";
				$cadena_sql .= " docencia.titulos_academicos ";
				$cadena_sql .= " WHERE id_docente = '".$variable[0]."'";
				$cadena_sql .= " AND id_nivelformacion = '1'";

				break;

			case "tipo_titulo":

				$cadena_sql = "SELECT id_nivel, descripcion_nivel ";
				$cadena_sql .= "FROM docencia.nivel_formacion ";
				$cadena_sql .= "ORDER BY id_nivel";
				break;

			case "universidad":

				$cadena_sql = "SELECT id_universidad, nombre_universidad ";
				$cadena_sql .= "FROM docencia.universidades ";
				$cadena_sql .= "ORDER BY nombre_universidad";
				break;

			case "pais":

				$cadena_sql = "SELECT paiscodigo, paisnombre ";
				$cadena_sql .= "FROM docencia.pais_kyron ";
				$cadena_sql .= "ORDER BY paisnombre";
				break;

                        case "insertarTitulo":

				if($variable[9]=='')
				{
					$fech = 'NULL';
				}else
				{
					$fech = "'".$variable[9]."'";
				}

				$cadena_sql = "INSERT INTO docencia.titulos_academicos( ";
				$cadena_sql .= "id_docente, id_nivelformacion, titulo, universidad,  ";
				$cadena_sql .= " anio_fin, modalidad , pais, resolucion_convalida, fecha_convalida, entidad_convalida, ";
				$cadena_sql .= "nume_acta, fech_acta, nume_caso, puntaje, detalledocencia, cons_titu) ";
				$cadena_sql .= " VALUES ('".$variable[0]."',";
				$cadena_sql .= " '".$variable[1]."',";
				$cadena_sql .= " '".$variable[2]."',";
				$cadena_sql .= " '".$variable[3]."',";
				$cadena_sql .= " '".$variable[4]."',";
				$cadena_sql .= " '".$variable[5]."',";
				$cadena_sql .= " '".$variable[6]."',";
				$cadena_sql .= " '".$variable[7]."',";
				$cadena_sql .= " '".$variable[8]."',";
				$cadena_sql .= " ".$fech.",";
				$cadena_sql .= " '".$variable[10]."',";
				$cadena_sql .= " '".$variable[11]."',";
				$cadena_sql .= " '".$variable[12]."',";
				$cadena_sql .= " '".$variable[13]."',";
				$cadena_sql .= " '".$variable[14]."',";
				$cadena_sql .= " '".$variable[15]."')";
				break;

			case "actualizarTitulo":

				if($variable[8]=='')
				{
					$fech = 'NULL';
				}else
				{
					$fech = "'".$variable[8]."'";
				}

				$cadena_sql = "UPDATE docencia.titulos_academicos SET ";
				$cadena_sql .= " id_nivelformacion = '".$variable[1]."', titulo = '".$variable[2]."', universidad = '".$variable[3]."',  ";
				$cadena_sql .= " anio_fin = '".$variable[4]."', modalidad = '".$variable[5]."', pais = '".$variable[6]."',  ";
				$cadena_sql .= " resolucion_convalida = '".$variable[7]."', fecha_convalida = ".$fech.", entidad_convalida = '".$variable[9]."', ";
				$cadena_sql .= "nume_acta = '".$variable[10]."', fech_acta = '".$variable[11]."', nume_caso = '".$variable[12]."', puntaje = '".$variable[13]."', detalledocencia = '".$variable[14]."' ";
				$cadena_sql .= " WHERE id_titulo = '".$variable[16]."'";


				break;

			case "facultad":

				$cadena_sql = "SELECT codigo_facultad, nombre_facultad ";
				$cadena_sql .= "FROM docencia.facultades ";
				$cadena_sql .= "ORDER BY nombre_facultad";
				break;
					
			case "proyectos":

				$cadena_sql = "SELECT codigo_proyecto, nombre_proyecto ";
				$cadena_sql .= "FROM docencia.proyectocurricular ";
				$cadena_sql .= "ORDER BY nombre_proyecto";
				break;

			case "categoria":

				$cadena_sql = "SELECT item_parametro, item_nombre ";
				$cadena_sql .= "FROM docencia.item_parametro ";
				$cadena_sql .= "WHERE item_idparametro = 1";
				break;
					
			case "consultarTitulos":

				$cadena_sql = "SELECT DISTINCT id_docente, descripcion_nivel, titulo, universidad, ";
				$cadena_sql .= " anio_fin, modalidad, fecha_convalida, entidad_convalida, nume_acta, ";
				$cadena_sql .= " fech_acta, nume_caso, puntaje, pais, resolucion_convalida, informacion_nombres, informacion_apellidos, id_titulo, detalledocencia ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= "LEFT JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
				$cadena_sql .= "LEFT JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "LEFT JOIN docencia.titulos_academicos ON id_docente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.nivel_formacion ON id_nivel = id_nivelformacion  ";
				$cadena_sql .= "WHERE 1=1";
				if($variable[0] != '')
				{
					$cadena_sql .= " AND dependencia_iddocente = '".$variable[0]."'";
				}
				if($variable[1] != '')
				{
					$cadena_sql .= " AND dependencia_facultad = '".$variable[1]."'";
				}
				if($variable[2] != '')
				{
					$cadena_sql .= " AND dependencia_proyectocurricular = '".$variable[2]."'";
				}
				if($variable[3] != '')
				{
					$cadena_sql .= " AND categoria_estado = '".$variable[3]."'";
				}


				break;

			case "consultarDocente" :

				$cadena_sql = "SELECT informacion_numeroidentificacion, ";
				$cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
				$cadena_sql .= "FROM docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
				break;

			case "consultarTituloDocente":

				$cadena_sql = "SELECT DISTINCT id_titulo, id_docente, id_nivelformacion, titulo, universidad, ";
				$cadena_sql .= " anio_fin, modalidad, pais, resolucion_convalida, fecha_convalida, entidad_convalida, nume_acta, ";
				$cadena_sql .= " fech_acta, nume_caso, puntaje, cons_titu, detalledocencia ";
				$cadena_sql .= "FROM docencia.titulos_academicos ";
				$cadena_sql .= "WHERE id_titulo='".$variable."'";

				break;
				/**
				 * Clausulas genéricas. se espera que estén en todos los formularios
				 * que utilicen esta plantilla
				 */

			case "iniciarTransaccion":
				$cadena_sql="START TRANSACTION";
				break;

			case "finalizarTransaccion":
				$cadena_sql="COMMIT";
				break;

			case "cancelarTransaccion":
				$cadena_sql="ROLLBACK";
				break;


			case "eliminarTemp":

				$cadena_sql="DELETE ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."tempFormulario ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_sesion = '".$variable."' ";
				break;

			case "insertarTemp":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo."tempFormulario ";
				$cadena_sql.="( ";
				$cadena_sql.="id_sesion, ";
				$cadena_sql.="formulario, ";
				$cadena_sql.="campo, ";
				$cadena_sql.="valor, ";
				$cadena_sql.="fecha ";
				$cadena_sql.=") ";
				$cadena_sql.="VALUES ";

				foreach($_REQUEST as $clave => $valor) {
					$cadena_sql.="( ";
					$cadena_sql.="'".$idSesion."', ";
					$cadena_sql.="'".$variable['formulario']."', ";
					$cadena_sql.="'".$clave."', ";
					$cadena_sql.="'".$valor."', ";
					$cadena_sql.="'".$variable['fecha']."' ";
					$cadena_sql.="),";
				}

				$cadena_sql=substr($cadena_sql,0,(strlen($cadena_sql)-1));
				break;

			case "rescatarTemp":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_sesion, ";
				$cadena_sql.="formulario, ";
				$cadena_sql.="campo, ";
				$cadena_sql.="valor, ";
				$cadena_sql.="fecha ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."tempFormulario ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_sesion='".$idSesion."'";
				break;

			case "registrarEvento" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= $prefijo . "logger( ";
				$cadena_sql .= "id_usuario, ";
				$cadena_sql .= "evento, ";
				$cadena_sql .= "fecha) ";
				$cadena_sql .= "VALUES( ";
				$cadena_sql .= $variable[0].", ";
				$cadena_sql .= "'" . $variable[1] . "', ";
				$cadena_sql .= "'" . time () . "') ";
				break;

		}
		return $cadena_sql;

	}
}
?>
