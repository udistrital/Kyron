<?php

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlexcelenciaAcademica extends sql {

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

            case "actualizarExcelencia" :
                $cadena_sql = "UPDATE ";
                $cadena_sql .= "docencia.registro_excelenciaac ";
                $cadena_sql .= "SET ";
                $cadena_sql .= "excelencia_numres= '" . $variable [1] . "', ";
                $cadena_sql .= "excelencia_fecres = '" . $variable [2] . "', ";
                $cadena_sql .= "excelencia_numacta= '" . $variable [3] . "', ";
                $cadena_sql .= "excelencia_fecacta= '" . $variable [4] . "', ";
                $cadena_sql .= "excelencia_puntaje = '" . $variable [5] . "' ";
                $cadena_sql .= "WHERE ";
                $cadena_sql .= "excelencia_idserial ='" . $variable [6] . "' ";
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

            case "consultarExcelenciaModificar" :
                $cadena_sql = "SELECT excelencia_idserial, excelencia_iddocente, ";
                $cadena_sql .= " excelencia_numres, excelencia_fecres, ";
                $cadena_sql .= " excelencia_numacta, excelencia_fecacta, ";
                $cadena_sql .= " excelencia_puntaje ";
                $cadena_sql .= " FROM docencia.registro_excelenciaac ";
                $cadena_sql .= " WHERE excelencia_idserial='" . $variable . "'; ";
                break;

            case "consultarExcelencia" :
                $cadena_sql = "SELECT DISTINCT excelencia_iddocente, informacion_nombres, informacion_apellidos, excelencia_idserial, excelencia_numres, ";
                $cadena_sql .= " excelencia_fecres, excelencia_numacta, excelencia_fecacta, excelencia_puntaje ";
                $cadena_sql .= "FROM docencia.registro_excelenciaac ";
                $cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = excelencia_iddocente ";
                $cadena_sql .= " JOIN docencia.dependencia_docente ON informacion_numeroidentificacion = dependencia_iddocente ";

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

                $cadena_sql .= " ORDER BY excelencia_iddocente ASC";
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

            case "tipo_titulo" :
                $cadena_sql = "SELECT id_nivel, descripcion_nivel ";
                $cadena_sql .= "FROM docencia.nivel_formacion ";
                $cadena_sql .= "ORDER BY id_nivel";
                break;

            case "verificarPuntaje":
                $cadena_sql = " SELECT sum(excelencia_puntaje) ";
                $cadena_sql.= " FROM docencia.registro_excelenciaac ";
                $cadena_sql.= " WHERE excelencia_iddocente = '" . $variable['docente'] . "' ";
                $cadena_sql.= " and extract(year from excelencia_fecacta) = '" . $variable['annio'] . "' ";
                $cadena_sql.= " and excelencia_idserial not in ( ";
                $cadena_sql.= " SELECT excelencia_idserial ";
                $cadena_sql.= " FROM docencia.registro_excelenciaac ";
                $cadena_sql.= " WHERE excelencia_idserial='" . $variable['idserial'] . "' ";
                $cadena_sql.= ") ";
                break;

            case "verificarPuntajeGuardar":
                $cadena_sql = " SELECT sum(excelencia_puntaje) ";
                $cadena_sql.= " FROM docencia.registro_excelenciaac ";
                $cadena_sql.= " WHERE excelencia_iddocente = '" . $variable['docente'] . "' ";
                $cadena_sql.= " and extract(year from excelencia_fecacta) = '" . $variable['annio'] . "' ";
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
