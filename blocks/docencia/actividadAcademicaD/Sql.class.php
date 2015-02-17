<?php

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlactividadAcademicaD extends sql {

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

            case "buscarNombreDocenteCondor" :
                $cadena_sql = " SELECT doc_nro_iden, (doc_nro_iden || ' ' || doc_nombre || ' ' || doc_apellido) as Nombres ";
                $cadena_sql.= " FROM mntac.acdocente ";
                //$cadena_sql.= " WHERE mntac.acdocente.doc_estado_registro='A' ";
                break;

            case "consultarDocenteCondor" :
                $cadena_sql = " SELECT doc_nro_iden, (doc_nombre || ' ' || doc_apellido) as Nombres ";
                $cadena_sql .= " FROM mntac.acdocente ";
                $cadena_sql .= " WHERE doc_nro_iden='" . $variable . "' ";
                //$cadena_sql .= "AND doc_estado_registro='A' ";
                break;

            case "buscarNombreDocente" :
                $cadena_sql = "SELECT ";
                $cadena_sql .= "informacion_numeroidentificacion, ";
                $cadena_sql .= "informacion_numeroidentificacion || ' - ' || UPPER(informacion_nombres)|| ' ' ||UPPER(informacion_apellidos) ";
                $cadena_sql .= "FROM ";
                $cadena_sql .= "docencia.docente_informacion ";
                $cadena_sql .= "WHERE ";
                $cadena_sql .= "informacion_estadoregistro = TRUE  ";
                break;

            case "consultarDocente" :
                $cadena_sql = "SELECT informacion_numeroidentificacion, ";
                $cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
                $cadena_sql .= "FROM docencia.docente_informacion ";
                $cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
                break;

            case "consultarActividad":
                $cadena_sql = " SELECT ";
                $cadena_sql .= " hor_id_curso,
                    asi_nombre, 
                    CASE hor_dia_nro
                            WHEN 1 THEN 'Lunes'
                            WHEN 2 THEN 'Martes'
                            WHEN 3 THEN 'Miercoles'
                            WHEN 4 THEN 'Jueves'
                            WHEN 5 THEN 'Viernes'
                            ELSE ''
                            END dia_nombre,
                            hor_hora, ";
                $cadena_sql .= " cur_asi_cod, ";
                $cadena_sql .= " car_doc_nro,"
                        . "doc_apellido,"
                        . "doc_nombre, "
                        . "car_estado, "
                        . "tvi_nombre, ";
                $cadena_sql .= " cur_ape_ano, cur_ape_per,cur_cra_cod,cur_dep_cod,dep_nombre, "
                        . "cur_nro_cupo, cur_estado,cur_grupo, cra_cod, cra_nombre  ";
                $cadena_sql .= " FROM  accargas,  achorarios,  accursos,  gedep,  actipvin, acdocente,  acasi, accra ";
                $cadena_sql .= " WHERE car_hor_id=hor_id ";
                $cadena_sql .= " and cur_id=hor_id_curso ";
                $cadena_sql .= " and dep_cod=cur_dep_cod ";
                $cadena_sql .= " and tvi_cod=car_tip_vin ";
                $cadena_sql .= " and car_doc_nro=doc_nro_iden ";
                $cadena_sql .= " and cur_asi_cod=asi_cod ";
                $cadena_sql .= " and cur_cra_cod=cra_cod ";

                if ($variable [0] != '') {
                    $cadena_sql .= " AND car_doc_nro = '" . $variable [0] . "'";
                }
                if ($variable [1] != '') {
                    $cadena_sql .= " AND cur_dep_cod = '" . $variable [1] . "'";
                }
                if ($variable [2] != '') {
                    $cadena_sql .= " AND cur_cra_cod = '" . $variable [2] . "'";
                }
                $cadena_sql .= " and ROWNUM<100 ";
               // $cadena_sql .= " ORDER BY cur_ape_per DESC ";
                break;

            case "insertarExcelencia" :
                $cadena_sql = "INSERT INTO docencia.registro_excelenciaac( ";
                $cadena_sql.= " excelencia_iddocente, ";
                $cadena_sql.= " excelencia_numres, excelencia_fecres, ";
                $cadena_sql.= " excelencia_numacta, excelencia_fecacta, ";
                $cadena_sql.= " excelencia_puntaje) ";
                $cadena_sql.= " VALUES (" . $variable [0] . ", ";
                $cadena_sql.= " '" . $variable [1] . "', ";
                $cadena_sql.= " '" . $variable [2] . "', ";
                $cadena_sql.= " '" . $variable [3] . "', ";
                $cadena_sql.= " '" . $variable [4] . "', ";
                $cadena_sql.= " '" . $variable [5] . "') ";
                $cadena_sql.= " RETURNING excelencia_idserial ";
                break;

            case "facultad" :
                $cadena_sql = " SELECT DEP_COD, DEP_NOMBRE from  gedep ";
                $cadena_sql.= " WHERE dep_nombre like 'FACULTAD%' ";
                $cadena_sql.= " ORDER BY DEP_NOMBRE ASC ";
                break;

            case "proyectos" :
                $cadena_sql = "SELECT cra_cod, cra_nombre ";
                $cadena_sql.= " FROM accra ";
                $cadena_sql.= " ORDER BY cra_nombre ASC";
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

            case "tipo_titulo" :
                $cadena_sql = "SELECT id_nivel, descripcion_nivel ";
                $cadena_sql .= "FROM docencia.nivel_formacion ";
                $cadena_sql .= "ORDER BY id_nivel";
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