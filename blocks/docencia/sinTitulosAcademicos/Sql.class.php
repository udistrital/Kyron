<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlSinTitulosAcademicos extends sql {


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
                                $cadena_sql .= "FROM pais ";
                                $cadena_sql .= "ORDER BY paisnombre";
			break;
                    
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
                    
                        case "buscarProyectos" :

                            $cadena_sql = "SELECT codigo_proyecto, nombre_proyecto ";
                            $cadena_sql .= "FROM docencia.proyectocurricular ";
                            $cadena_sql .= " WHERE id_facultad = '".$variable."' ";
                            $cadena_sql .= "ORDER BY nombre_proyecto";
                            break;
                        
                        case "insertarSinTitulo":

				$cadena_sql = "INSERT INTO docencia.sin_titulos_academicos( ";
                                $cadena_sql .= "id_docente, nume_acta, fech_acta, nume_caso, id_categoria, ";
                                $cadena_sql .= "puntaje, detalledocencia ) ";
                                $cadena_sql .= " VALUES ('".$variable[0]."',";
                                $cadena_sql .= " '".$variable[1]."',";
                                $cadena_sql .= " '".$variable[2]."',";
                                $cadena_sql .= " '".$variable[3]."',";
                                $cadena_sql .= " '".$variable[4]."',";
                                $cadena_sql .= " '".$variable[5]."',";
                                $cadena_sql .= " '".$variable[6]."')";
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

				$cadena_sql = "SELECT id_categoria, nombre, descripcion ";
                                $cadena_sql .= "FROM docencia.categoria_titulo ";
			break;
			
                        case "consultarSinTitulos":
                            
				$cadena_sql = "SELECT DISTINCT id_docente, nume_acta, fech_acta, nume_caso, puntaje, informacion_nombres, informacion_apellidos, id_sintitulo, detalledocencia ";
                                $cadena_sql .= "FROM docencia.dependencia_docente ";
                                $cadena_sql .= "JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
                                $cadena_sql .= "JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
                                $cadena_sql .= "JOIN docencia.sin_titulos_academicos ON id_docente = dependencia_iddocente ";
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
                        
                        case "consultarSinTituloDocente":
                            
				$cadena_sql = "SELECT DISTINCT id_sintitulo, id_docente, nume_acta, fech_acta, nume_caso, id_categoria, puntaje, detalledocencia ";
                                $cadena_sql .= "FROM docencia.sin_titulos_academicos ";
                                $cadena_sql .= "WHERE id_sintitulo= '".$variable."'";
			break;
                    
                        case "consultarDocente" :
				
				$cadena_sql = "SELECT informacion_numeroidentificacion, ";
				$cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
				$cadena_sql .= "FROM docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
				break;
                    
                        case "actualizarSinTitulo":
                            
				$cadena_sql = "UPDATE docencia.sin_titulos_academicos ";
                                $cadena_sql .= " SET nume_acta = '".$variable[1]."', fech_acta = '".$variable[2]."', nume_caso = '".$variable[3]."', id_categoria = '".$variable[4]."', puntaje = '".$variable[5]."', detalledocencia = '".$variable[7]."'  ";
                                $cadena_sql .= "WHERE id_sintitulo= '".$variable[0]."'";
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
