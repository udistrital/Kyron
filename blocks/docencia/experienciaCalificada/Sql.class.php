<?php

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlexperienciaCalificada extends sql {

    var $miConfigurador;

    function __construct() {
        $this->miConfigurador = Configurador::singleton();
    }

    function cadena_sql($tipo, $variable = "", $variable1 = "", $variable2 = "") {

        /**
         * 1.
         * Revisar las variables para evitar SQL Injection
         */
        $prefijo = $this->miConfigurador->getVariableConfiguracion("prefijo");
        $idSesion = $this->miConfigurador->getVariableConfiguracion("id_sesion");

        switch ($tipo) {

            case "actualizarExperiencia" :
                $cadena_sql = "UPDATE ";
                $cadena_sql .= "docencia.registro_experienciacalif ";
                $cadena_sql .= "SET ";
                $cadena_sql .= "experiencia_tipoexp= '" . $variable [1] . "', ";
                $cadena_sql .= "experiencia_numres= '" . $variable [2] . "', ";
                $cadena_sql .= "experiencia_emires= '" . $variable [3] . "', ";
                $cadena_sql .= "experiencia_fecres = '" . $variable [4] . "', ";
                $cadena_sql .= "experiencia_numacta= '" . $variable [5] . "', ";
                $cadena_sql .= "experiencia_fecacta= '" . $variable [6] . "', ";
                $cadena_sql .= "experiencia_puntaje = '" . $variable [7] . "', ";
                $cadena_sql .= "detalledocencia = '" . $variable [9] . "' ";
                $cadena_sql .= "WHERE ";
                $cadena_sql .= "experiencia_idserial ='" . $variable [8] . "' ";
                break;

            case "buscarProyectos" :

                $cadena_sql = "SELECT codigo_proyecto, nombre_proyecto ";
                $cadena_sql .= "FROM docencia.proyectocurricular ";
                $cadena_sql .= " WHERE id_facultad = '".$variable."' ";
                $cadena_sql .= "ORDER BY nombre_proyecto";
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

            case "consultarDocente" :
                $cadena_sql = "SELECT informacion_numeroidentificacion, ";
                $cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
                $cadena_sql .= "FROM docencia.docente_informacion ";
                $cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
                break;

            case "consultarExperienciaModificar" :
                $cadena_sql = "SELECT  experiencia_idserial,  experiencia_iddocente, ";
                $cadena_sql .= " experiencia_tipoexp, experiencia_numres, ";
                $cadena_sql .= " experiencia_emires, experiencia_fecres, ";
                $cadena_sql .= " experiencia_numacta, experiencia_fecacta, ";
                $cadena_sql .= " experiencia_puntaje, detalledocencia ";
                $cadena_sql .= " FROM docencia.registro_experienciacalif ";
                $cadena_sql .= " WHERE experiencia_idserial='" . $variable . "'; ";
                break;

            case "consultarExperiencia" :
                $cadena_sql = "SELECT DISTINCT experiencia_iddocente, informacion_nombres, informacion_apellidos, exp_tipo ";
                $cadena_sql .= " experiencia_tipoexp, experiencia_numres, emires_emisor,experiencia_fecres, experiencia_numacta, experiencia_fecacta, experiencia_puntaje, experiencia_idserial ";
                $cadena_sql .= " FROM docencia.registro_experienciacalif ";
                $cadena_sql .= " LEFT JOIN docencia.tipo_experienciacalif ON exp_idtipo=experiencia_tipoexp ";
                $cadena_sql .= " LEFT JOIN docencia.tipo_emisoresresolucion ON emires_idtipo=experiencia_emires ";
                $cadena_sql .= " LEFT JOIN docencia.docente_informacion ON informacion_numeroidentificacion = experiencia_iddocente ";
                $cadena_sql .= " LEFT JOIN docencia.dependencia_docente ON informacion_numeroidentificacion = dependencia_iddocente ";
                $cadena_sql .= "WHERE 1 = 1";
                if ($variable [0] != '') {
                    $cadena_sql .= " AND dependencia_iddocente = '" . $variable [0] . "'";
                }
                if ($variable [1] != '') {
                    $cadena_sql .= " AND dependencia_facultad = '" . $variable [1] . "'";
                }
                if ($variable [2] != '') {
                    $cadena_sql .= " AND dependencia_proyectocurricular = '" . $variable [2] . "'";
                }
                $cadena_sql .= " ORDER BY experiencia_iddocente ";
                break;

            case "insertarExperiencia" :
                $cadena_sql = "INSERT INTO docencia.registro_experienciacalif( ";
                $cadena_sql.= " experiencia_iddocente, ";
                $cadena_sql.= " experiencia_tipoexp, ";
                $cadena_sql.= " experiencia_numres, ";
                $cadena_sql.= " experiencia_emires, ";
                $cadena_sql.= " experiencia_fecres, ";
                $cadena_sql.= " experiencia_numacta, ";
                $cadena_sql.= " experiencia_fecacta, ";
                $cadena_sql.= " experiencia_puntaje, ";
                $cadena_sql.= " detalledocencia) ";
                $cadena_sql.= " VALUES (" . $variable [0] . ", ";
                $cadena_sql.= " '" . $variable [1] . "', ";
                $cadena_sql.= " '" . $variable [2] . "', ";
                $cadena_sql.= " '" . $variable [3] . "', ";
                $cadena_sql.= " '" . $variable [4] . "', ";
                $cadena_sql.= " '" . $variable [5] . "', ";
                $cadena_sql.= " '" . $variable [6] . "', ";
                $cadena_sql.= " '" . $variable [7] . "', ";
                $cadena_sql.= " '" . $variable [8] . "') ";
                $cadena_sql.= " RETURNING experiencia_idserial ";
                break;

            case "facultad" :
                $cadena_sql = "SELECT codigo_facultad, nombre_facultad ";
                $cadena_sql .= "FROM docencia.facultades ";
                $cadena_sql .= "ORDER BY nombre_facultad";
                break;

            case "proyectos" :
                $cadena_sql = "SELECT codigo_proyecto, nombre_proyecto ";
                $cadena_sql .= "FROM docencia.proyectocurricular ";
                $cadena_sql .= "ORDER BY nombre_proyecto";
                break;

            case "registrarEvento" :
                $cadena_sql = "INSERT INTO ";
                $cadena_sql .= $prefijo . "logger( ";
                $cadena_sql .= "id_usuario, ";
                $cadena_sql .= "evento, ";
                $cadena_sql .= "fecha) ";
                $cadena_sql .= "VALUES( ";
                $cadena_sql .= $variable [0] . ", ";
                $cadena_sql .= "'" . $variable [1] . "', ";
                $cadena_sql .= "'" . time() . "' ) ";
                break;

            case "resolucionEmision":
                $cadena_sql = "SELECT emires_idtipo, emires_emisor ";
                $cadena_sql .= "FROM docencia.tipo_emisoresResolucion ";
                $cadena_sql .= "ORDER BY emires_idtipo";
                break;

            case "tipo_titulo" :
                $cadena_sql = "SELECT id_nivel, descripcion_nivel ";
                $cadena_sql .= "FROM docencia.nivel_formacion ";
                $cadena_sql .= "ORDER BY id_nivel";
                break;


            case "tipoExperiencia" :
                $cadena_sql = "SELECT exp_idtipo,exp_tipo,exp_puntaje ";
                $cadena_sql .= "FROM docencia.tipo_experienciacalif ";
                $cadena_sql .= "ORDER BY exp_idtipo";
                break;


            /**
             * Clausulas genéricas.
             * se espera que estén en todos los formularios
             * que utilicen esta plantilla
             */
            case "iniciarTransaccion" :
                $cadena_sql = "START TRANSACTION";
                break;

            case "finalizarTransaccion" :
                $cadena_sql = "COMMIT";
                break;

            case "cancelarTransaccion" :
                $cadena_sql = "ROLLBACK";
                break;

            case "eliminarTemp" :

                $cadena_sql = "DELETE ";
                $cadena_sql .= "FROM ";
                $cadena_sql .= $prefijo . "tempFormulario ";
                $cadena_sql .= "WHERE ";
                $cadena_sql .= "id_sesion = '" . $variable . "' ";
                break;

            case "insertarTemp" :
                $cadena_sql = "INSERT INTO ";
                $cadena_sql .= $prefijo . "tempFormulario ";
                $cadena_sql .= "( ";
                $cadena_sql .= "id_sesion, ";
                $cadena_sql .= "formulario, ";
                $cadena_sql .= "campo, ";
                $cadena_sql .= "valor, ";
                $cadena_sql .= "fecha ";
                $cadena_sql .= ") ";
                $cadena_sql .= "VALUES ";

                foreach ($_REQUEST as $clave => $valor) {
                    $cadena_sql .= "( ";
                    $cadena_sql .= "'" . $idSesion . "', ";
                    $cadena_sql .= "'" . $variable ['formulario'] . "', ";
                    $cadena_sql .= "'" . $clave . "', ";
                    $cadena_sql .= "'" . $valor . "', ";
                    $cadena_sql .= "'" . $variable ['fecha'] . "' ";
                    $cadena_sql .= "), ";
                }

                $cadena_sql = substr($cadena_sql, 0, (strlen($cadena_sql) - 1));
                break;

            case "rescatarTemp" :
                $cadena_sql = "SELECT ";
                $cadena_sql .= "id_sesion, ";
                $cadena_sql .= "formulario, ";
                $cadena_sql .= "campo, ";
                $cadena_sql .= "valor, ";
                $cadena_sql .= "fecha ";
                $cadena_sql .= "FROM ";
                $cadena_sql .= $prefijo . "tempFormulario ";
                $cadena_sql .= "WHERE ";
                $cadena_sql .= "id_sesion = '" . $idSesion . "'";
                break;
        }
        return $cadena_sql;
    }

}

?>
