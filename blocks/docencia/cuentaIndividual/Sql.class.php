<?php

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlcuentaIndividual extends sql {

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

//*********************************************ESTADO DE CUENTA DOCENTE**********************************************************

            case "datosDocente":
                $cadena_sql = "SELECT ";
                $cadena_sql.=" dependencia_iddocente,informacion_nombres, informacion_apellidos, vinculacion_numeroresolucion, ";
                $cadena_sql.=" vinculacion_fechaingreso,nombre_proyecto,nombre_facultad, ";
                $cadena_sql.=" CASE WHEN informacion_estadoregistro='t' ";
                $cadena_sql.=" THEN 'ACTIVO' ";
                $cadena_sql.=" ELSE 'INACTIVO' END as estado  ";
                $cadena_sql.=" FROM docencia.dependencia_docente ";
                $cadena_sql.=" JOIN docencia.vinculacion_docente ON dependencia_iddocente=vinculacion_iddocente ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.facultades ON codigo_facultad=dependencia_facultad  ";
                $cadena_sql.=" JOIN docencia.proyectocurricular ON codigo_proyecto=dependencia_proyectocurricular   ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion =dependencia_iddocente  ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND dependencia_iddocente='" . $variable . "'";
                break;

            case "datosTitulos":
                $cadena_sql = " SELECT DISTINCT ";
                $cadena_sql.=" descripcion_nivel,titulo, nombre_universidad,anio_fin, fech_acta, nume_acta,resolucion_convalida,fecha_convalida,entidad_convalida,puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente  ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.titulos_academicos ON id_docente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.nivel_formacion ON id_nivel = id_nivelformacion ";
                $cadena_sql.=" JOIN docencia.universidades ON id_universidad = universidad ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND dependencia_iddocente='" . $variable . "'";
                break;

            case "codigo_docente":
                $cadena_sql = " SELECT infoinvariante_codigointerno, infoinvariante_iddocente  ";
                $cadena_sql.=" FROM docencia.docente_infoinvariante ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND infoinvariante_iddocente='" . $variable . "'";
                break;

            case "datosCategorias":

//OJO ESTA HAY QUE CAMBIARLA!!!
                $cadena_sql = " SELECT DISTINCT ";
                $cadena_sql.=" nume_acta, fech_acta,fech_acta,";
                $cadena_sql.=" age(fecha_fin, fecha_inicio) tiempo,";
                $cadena_sql.=" puntaje";
                $cadena_sql.=" FROM docencia.dependencia_docente";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.experiencia_investigacion ON id_docente = dependencia_iddocente";
                $cadena_sql.=" JOIN docencia.universidades ON id_universidad = entidad ";
                $cadena_sql.=" JOIN docencia.tipo_experiencia_investigacion TE ON id_tipo = tipo_experiencia";
                $cadena_sql.=" WHERE 1=1";
                $cadena_sql.=" AND dependencia_iddocente='" . $variable . "'";
                break;

            case "datosExcInvestigacion":
                $cadena_sql = " SELECT DISTINCT ";
                $cadena_sql.=" nume_acta, fech_acta,";
                $cadena_sql.=" age(fecha_fin, fecha_inicio) tiempo,";
                $cadena_sql.=" puntaje";
                $cadena_sql.=" FROM docencia.dependencia_docente";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.experiencia_investigacion ON id_docente = dependencia_iddocente";
                $cadena_sql.=" JOIN docencia.universidades ON id_universidad = entidad ";
                $cadena_sql.=" JOIN docencia.tipo_experiencia_investigacion TE ON id_tipo = tipo_experiencia";
                $cadena_sql.=" WHERE 1=1";
                $cadena_sql.=" AND dependencia_iddocente='" . $variable . "'";
                break;

            case "datosExcDireccion":
                $cadena_sql = " SELECT nume_acta,fecha_acta, age(fecha_fin,fecha_inicio) as tiempo,puntaje ";
                $cadena_sql.=" FROM docencia.experiencia_direccion_acade ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND id_docente='" . $variable . "'";
                break;

            case "datosExcCalificada":
                $cadena_sql = " SELECT DISTINCT  ";
                $cadena_sql.=" experiencia_numacta, experiencia_fecacta, 0 as tiempo, experiencia_puntaje as puntaje";
                $cadena_sql.=" FROM docencia.registro_experienciacalif ";
                $cadena_sql.=" JOIN docencia.tipo_experienciacalif ON exp_idtipo=experiencia_tipoexp ";
                $cadena_sql.=" JOIN docencia.tipo_emisoresresolucion ON emires_idtipo=experiencia_emires ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = experiencia_iddocente ";
                $cadena_sql.=" JOIN docencia.dependencia_docente ON informacion_numeroidentificacion = dependencia_iddocente ";
                $cadena_sql.=" WHERE 1 = 1";
                $cadena_sql.=" AND experiencia_iddocente='" . $variable . "'";
                break;

            case "datosExcProfesional":
                $cadena_sql = "  SELECT DISTINCT nume_acta, fech_acta, ";
                $cadena_sql.=" age(fecha_fin,fecha_inicio) as tiempo ,puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente  ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.experiencia_profesional ON id_docente = dependencia_iddocente  ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND id_docente='" . $variable . "'";
                break;

            case "datosExcAcademica":
                $cadena_sql = "  SELECT DISTINCT extract(year from excelencia_fecacta) as anio,excelencia_numres, ";
                $cadena_sql.=" excelencia_fecres, excelencia_puntaje as puntaje ";
                $cadena_sql.=" FROM docencia.registro_excelenciaac ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = excelencia_iddocente ";
                $cadena_sql.=" JOIN docencia.dependencia_docente ON informacion_numeroidentificacion = dependencia_iddocente ";
                $cadena_sql.=" WHERE 1 = 1 ";
                $cadena_sql.=" AND excelencia_iddocente='" . $variable . "'";
                break;

            case "datosProAcademica":
                $cadena_sql = " SELECT  item_nombre,titulo_articulo, paisnombre,  anno_publicacion,   ";
                $cadena_sql.=" numero_issn, volumen_revista,acta_numero, fecha_acto ";
                $cadena_sql.=" FROM docencia.dependencia_docente   ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.indexacion_revistas ON id_revista_docente = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.parametros_indexacion ON item_id = revista_indexacion   ";
                $cadena_sql.=" JOIN docencia.universidades ON id_universidad = revista_institucion   ";
                $cadena_sql.=" JOIN docencia.pais_kyron ON paiscodigo = pais_publicacion   ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" ORDER BY item_nombre ASC ";
                $cadena_sql.=" AND dependencia_iddocente='" . $variable . "' ";

                break;

            case "datosComCorta":
                $cadena_sql = " SELECT revista_nombre, numero_issn, ";
                $cadena_sql.=" informacion_nombres||' '||informacion_apellidos as autor, id_revista_docente, anno_publicacion, ";
                $cadena_sql.=" acta_numero, fecha_acto, cast (puntaje as numeric) as puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.comunicacion_corta ON id_revista_docente = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.parametros_indexacion ON item_id = revista_indexacion ";
                $cadena_sql.=" JOIN docencia.universidades ON id_universidad = revista_institucion ";
                $cadena_sql.=" JOIN docencia.pais_kyron ON paiscodigo = pais_publicacion ";
                $cadena_sql.=" WHERE 1 = 1 ";
                $cadena_sql.=" AND id_revista_docente='" . $variable . "'";
                break;

            case "datosCartas":
                $cadena_sql = " SELECT nombre, issn,informacion_nombres||' '|| informacion_apellidos as autor,  ";
                $cadena_sql.=" id_docente,annio_publ, nume_acta, fech_acta, ";
                $cadena_sql.=" puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente   ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.cartas_editor ON id_docente = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.parametros_indexacion ON item_id = indexacion   ";
                $cadena_sql.=" JOIN docencia.universidades ON id_universidad = institucion   ";
                $cadena_sql.=" JOIN docencia.pais_kyron ON paiscodigo = pais    ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND id_docente='" . $variable . "'";
                break;

            case "datosPrVideos":
                $cadena_sql = "SELECT DISTINCT descripcion_contexto,informacion_nombres||' '||informacion_apellidos as autor,titulo_video, ";
                $cadena_sql.=" extract(year from fech_video) as anio, nume_acta, fech_acta, puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente  ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.prvideos_docente ON id_docente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.contexto_obra ON id_contexto= contexto   ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND id_docente='" . $variable . "'";
                $cadena_sql.=" ORDER BY descripcion_contexto ASC ";
                break;

            case "datosLibInvestigacion":
                $cadena_sql = " SELECT DISTINCT  titulo,codigo_numeracion,nume_autores, nume_autores_ud,annio,  nombre_editorial,  ";
                $cadena_sql.=" nume_acta, fech_acta, puntaje  ";
                $cadena_sql.=" FROM docencia.dependencia_docente  ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.registro_libros as rl ON id_docente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.tipo_libro as tl ON tl.id_tipo_libro = rl.id_tipo_libro  ";
                $cadena_sql.=" JOIN docencia.editoriales ON editorial=id_editorial ";
                $cadena_sql.=" WHERE rl.id_tipo_libro=1 ";
                $cadena_sql.=" AND dependencia_iddocente='" . $variable . "'";
                break;

            case "datosLibTexto":
                $cadena_sql = " SELECT DISTINCT  titulo,codigo_numeracion,nume_autores, nume_autores_ud,annio,  nombre_editorial,  ";
                $cadena_sql.=" nume_acta, fech_acta, puntaje  ";
                $cadena_sql.=" FROM docencia.dependencia_docente  ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.registro_libros as rl ON id_docente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.tipo_libro as tl ON tl.id_tipo_libro = rl.id_tipo_libro  ";
                $cadena_sql.=" JOIN docencia.editoriales ON editorial=id_editorial ";
                $cadena_sql.=" WHERE rl.id_tipo_libro=3 ";
                $cadena_sql.=" AND dependencia_iddocente='" . $variable . "'";
                break;

            case "datosLibEnsayo":
                $cadena_sql = " SELECT DISTINCT  titulo,codigo_numeracion,nume_autores, nume_autores_ud,annio,  nombre_editorial,  ";
                $cadena_sql.=" nume_acta, fech_acta, puntaje  ";
                $cadena_sql.=" FROM docencia.dependencia_docente  ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.registro_libros as rl ON id_docente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.tipo_libro as tl ON tl.id_tipo_libro = rl.id_tipo_libro  ";
                $cadena_sql.=" JOIN docencia.editoriales ON editorial=id_editorial ";
                $cadena_sql.=" WHERE rl.id_tipo_libro=2 ";
                $cadena_sql.=" AND dependencia_iddocente='" . $variable . "'";
                break;

            case "datosPremios":
                $cadena_sql = " SELECT DISTINCT  ";
                $cadena_sql.=" CASE WHEN contexto_entidad='1' THEN 'Nacional'  ";
                $cadena_sql.=" WHEN contexto_entidad='2' THEN 'Internacional' ";
                $cadena_sql.=" END as contexto, ";
                $cadena_sql.=" CASE WHEN nombre_universidad=NULL THEN otra_entidad ";
                $cadena_sql.=" ELSE nombre_universidad END as entidad, ";
                $cadena_sql.=" concepto_premio, ";
                $cadena_sql.=" ciudadnombre, fecha, num_otorg_personas,   ";
                $cadena_sql.=" nume_acta, fech_acta, puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente  ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.premios_docente ON id_docente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.ciudad_kyron ON ciudadid = ciudad ";
                $cadena_sql.=" JOIN docencia.universidades ON id_universidad = entidad ";
                $cadena_sql.=" WHERE id_docente='" . $variable . "'";
                break;

            case "datosPatentes":
                $cadena_sql = " SELECT DISTINCT  ";
                $cadena_sql.=" informacion_nombres||' '|| informacion_apellidos as nombres , nombre_universidad, year_patente, concepto_patente,  ";
                $cadena_sql.=" numregistro_patente, acta_patente, fecha_patente, puntaje_patente as puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente  ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.registrar_patentes ON docente_patente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.tipo_patente ON id_patentes = tipo_patente  ";
                $cadena_sql.=" JOIN docencia.universidades ON id_universidad = entidad_patente  ";
                $cadena_sql.=" JOIN docencia.pais_kyron ON paiscodigo = pais_patente   ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND docente_patente='" . $variable . "'";
                break;

            case "datosTraduccionLibro":
                $cadena_sql = "  SELECT DISTINCT  ";
                $cadena_sql.=" nom_libro, informacion_nombres||' '|| informacion_apellidos as nombres, aniol,  ";
                $cadena_sql.=" nume_acta, fech_acta, puntaje  ";
                $cadena_sql.=" FROM docencia.dependencia_docente    ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente    ";
                $cadena_sql.=" JOIN docencia.traduccion_docente ON id_docente = dependencia_iddocente    ";
                $cadena_sql.=" JOIN docencia.tipo_traduccion ON  id_tipo_traduccion= tipo_traduccion     ";
                $cadena_sql.=" WHERE 1=1  ";
                $cadena_sql.=" AND id_tipo_traduccion=1  ";
                $cadena_sql.=" AND id_docente='" . $variable . "'";
                break;

            case "datosObArtSalOriginal":
                $cadena_sql = " SELECT DISTINCT  ";
                $cadena_sql.=" descripcion_contexto,titulo_obra, informacion_nombres||' '|| informacion_apellidos as nombres, ";
                $cadena_sql.=" certifica, anio_obra,    ";
                $cadena_sql.=" nume_acta, fech_acta, puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente   ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.obras_docente ON id_docente = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.contexto_obra ON id_contexto= contexto_obra   ";
                $cadena_sql.=" JOIN docencia.tipo_obra_artistica  ON id_tipo_obra = tipo_obra   ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND id_tipo_obra=1 ";
                $cadena_sql.=" AND id_docente='" . $variable . "' ";
                break;

            case "datosObArtSalComple":
                $cadena_sql = " SELECT DISTINCT  ";
                $cadena_sql.=" descripcion_contexto,titulo_obra, informacion_nombres||' '|| informacion_apellidos as nombres, ";
                $cadena_sql.=" certifica, anio_obra,    ";
                $cadena_sql.=" nume_acta, fech_acta, puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente   ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.obras_docente ON id_docente = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.contexto_obra ON id_contexto= contexto_obra   ";
                $cadena_sql.=" JOIN docencia.tipo_obra_artistica  ON id_tipo_obra = tipo_obra   ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND id_tipo_obra=2 ";
                $cadena_sql.=" AND id_docente='" . $variable . "' ";
                break;

            case "datosProTecnicaIn":
                $cadena_sql = " SELECT DISTINCT 1 AS n_autor, ";
                $cadena_sql.=" informacion_nombres||' '|| informacion_apellidos as nombres, ";
                $cadena_sql.=" nume_certificado, fech_produccion, nume_acta, fech_acta, puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.tecn_sotf_docente ON id_docente = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.tipo_produc_teg_soft ON id_tipo_producc = tipo_produccion ";
                $cadena_sql.=" WHERE 1 = 1 ";
                $cadena_sql.=" AND tipo_produccion = '1' ";
                $cadena_sql.=" AND id_docente='" . $variable . "' ";
                break;

            case "datosProTecnicaAd":
                $cadena_sql = " SELECT DISTINCT 1 AS n_autor, ";
                $cadena_sql.=" informacion_nombres||' '|| informacion_apellidos as nombres, ";
                $cadena_sql.=" nume_certificado, fech_produccion, nume_acta, fech_acta, puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.tecn_sotf_docente ON id_docente = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.tipo_produc_teg_soft ON id_tipo_producc = tipo_produccion ";
                $cadena_sql.=" WHERE 1 = 1 ";
                $cadena_sql.=" AND tipo_produccion = '2' ";
                $cadena_sql.=" AND id_docente='" . $variable . "' ";
                break;

            case "datosProSoftware":
                $cadena_sql = " SELECT DISTINCT 1 AS n_autor, ";
                $cadena_sql.=" informacion_nombres||' '|| informacion_apellidos as nombres,  ";
                $cadena_sql.=" nume_certificado, fech_produccion, nume_acta, fech_acta, puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.tecn_sotf_docente ON id_docente = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.tipo_produc_teg_soft ON id_tipo_producc = tipo_produccion ";
                $cadena_sql.=" WHERE 1 = 1 ";
                $cadena_sql.=" AND tipo_produccion = '3' ";
                $cadena_sql.=" AND id_docente='" . $variable . "' ";
                break;

            case "datosProVideosCine":
                $cadena_sql = "SELECT DISTINCT descripcion_contexto,informacion_nombres||' '||informacion_apellidos as autor,titulo_video, ";
                $cadena_sql.=" extract(year from fech_video) as anio, nume_acta, fech_acta, fech_acta, puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente  ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.prvideos_docente ON id_docente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.contexto_obra ON id_contexto= contexto   ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND id_docente='" . $variable . "'";
                $cadena_sql.=" ORDER BY descripcion_contexto ASC ";
                break;

            case "datosPonencias":
                $cadena_sql = " SELECT DISTINCT  ";
                $cadena_sql.=" descripcion_contexto, nombre_ponencia, informacion_nombres||' '||informacion_apellidos as autor,   ";
                $cadena_sql.=" fecha,evento_ponencia, nume_certificado, nume_acta, fech_acta, puntaje  ";
                $cadena_sql.=" FROM docencia.dependencia_docente    ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente    ";
                $cadena_sql.=" JOIN docencia.ponencia_docente ON id_docente = dependencia_iddocente    ";
                $cadena_sql.=" JOIN docencia.contexto_ponencia ON id_contexto= contexto_ponencia     ";
                $cadena_sql.=" JOIN docencia.pais_kyron ON paiscodigo = pais_ponencia    ";
                $cadena_sql.=" JOIN docencia.ciudad_kyron ON ciudadid = ciudad   ";
                $cadena_sql.=" WHERE  id_docente='" . $variable . "' ";
                $cadena_sql.=" ORDER BY descripcion_contexto ASC ";
                break;

            case "datosPubUniver":
                //El usuario solicitó solo revistas. El cod_numeración=2 son libros :O
                $cadena_sql = " SELECT DISTINCT ";
                $cadena_sql.=" titulo_publicacion,desc_codigo_numeracion,  informacion_nombres||' '||informacion_apellidos  as autor, ";
                $cadena_sql.=" fecha_publicacion,    ";
                $cadena_sql.=" revistapublicacion,volumen, num_revista, categoria_revista,anio_revist, ";
                $cadena_sql.=" nume_acta, fech_acta, puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente   ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.publ_impr_univ_docente ON id_docente = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.codigo_numeracion ON   id_codigo = codigo_numeracion   ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND codigo_numeracion ='1'  ";
                $cadena_sql.=" AND dependencia_iddocente='" . $variable . "'";
                break;

            case "datosEstudioPosD":
                $cadena_sql = " SELECT DISTINCT  ";
                $cadena_sql.=" autor_doctorestudios,  ";
                $cadena_sql.=" institucion_doctorestudios, fecha_doctorestudios, titulo_doctorestudios,  ";
                $cadena_sql.=" duracion_doctorestudios, actanumber_doctorestudios, fechcta_doctorestudios, ";
                $cadena_sql.=" puntaje_doctorestudios as puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente  ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.estudiosdoctorales ON docente_doctorestudios = dependencia_iddocente  ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND dependencia_iddocente='" . $variable . "'";
                break;

            case "datosReseña":
                $cadena_sql = "  SELECT DISTINCT titulo_resena,  ";
                $cadena_sql.=" fecha_resena, autor_resena, numacta_resena, fechacta_resena,  ";
                $cadena_sql.=" puntaje_resena as puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente  ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.registrar_resena ON id_docente = dependencia_iddocente  ";
                $cadena_sql.=" JOIN docencia.parametros_indexacion ON item_id = categoria_resena  ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND dependencia_iddocente='" . $variable . "'";
                break;

            case "datosTraducciones":
                $cadena_sql = " SELECT DISTINCT ";
                $cadena_sql.=" titulo_traduccion, fecha,  ";
                $cadena_sql.=" informacion_nombres||' '|| informacion_apellidos as nombres, ";
                $cadena_sql.=" nume_acta, fech_acta, puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente     ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.traduccion_docente ON id_docente = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.tipo_traduccion ON  id_tipo_traduccion= tipo_traduccion  ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND id_tipo_traduccion=2 ";
                $cadena_sql.=" AND dependencia_iddocente='" . $variable . "'";
                break;

            case "datosObArtSalOrigBon":
                $cadena_sql = " SELECT DISTINCT    ";
                $cadena_sql.=" titulo_obra, fecha_obra, informacion_nombres||' '|| informacion_apellidos as nombres,      ";
                $cadena_sql.=" nume_acta, fech_acta, puntaje   ";
                $cadena_sql.=" FROM docencia.dependencia_docente     ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente     ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.obras_docente_bonificacion ON id_docente = dependencia_iddocente     ";
                $cadena_sql.=" JOIN docencia.tipo_obra_artistica  ON id_tipo_obra = tipo_obra     ";
                $cadena_sql.=" WHERE 1=1   ";
                $cadena_sql.=" AND id_tipo_obra=1   ";
                $cadena_sql.=" AND id_docente='" . $variable . "' ";
                break;

            case "datosObArtSalCompBon":
                $cadena_sql = " SELECT DISTINCT    ";
                $cadena_sql.=" titulo_obra, fecha_obra, informacion_nombres||' '|| informacion_apellidos as nombres,      ";
                $cadena_sql.=" nume_acta, fech_acta, puntaje   ";
                $cadena_sql.=" FROM docencia.dependencia_docente     ";
                $cadena_sql.=" JOIN docencia.categoria_docente ON categoria_iddocente = dependencia_iddocente     ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
                $cadena_sql.=" JOIN docencia.obras_docente_bonificacion ON id_docente = dependencia_iddocente     ";
                $cadena_sql.=" JOIN docencia.tipo_obra_artistica  ON id_tipo_obra = tipo_obra     ";
                $cadena_sql.=" WHERE 1=1   ";
                $cadena_sql.=" AND id_tipo_obra=2   ";
                $cadena_sql.=" AND id_docente='" . $variable . "' ";
                break;

            case "datosInterpretacion":
                $cadena_sql = " SELECT DISTINCT  ";
                $cadena_sql.=" titulo_interpretacion,autor_interpretacion,   ";
                $cadena_sql.=" nombre_universidad,  ";
                $cadena_sql.=" fecha_intepretacion, numacta_interpretacion, fechacta_interpretacion, puntaje_interpretacion as puntaje  ";
                $cadena_sql.=" FROM docencia.dependencia_docente   ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente   ";
                $cadena_sql.=" JOIN  docencia.registrar_interpretaciones ON id_docente = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.universidades ON id_universidad = entidad_interpretacion   ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND dependencia_iddocente='" . $variable . "' ";
                break;

            case "datosDireccionTrab":
                $cadena_sql = " SELECT DISTINCT ";
                $cadena_sql.=" nombre_tipodireccion, titulo_direccion,num_autores, ";
                $cadena_sql.=" informacion_nombres||' '|| informacion_apellidos as director, ";
                $cadena_sql.=" anio_direccion,  ";
                $cadena_sql.=" numacta_direccion, fechacta_direccion, ";
                $cadena_sql.=" CASE WHEN puntaje_direccion ='NULL' THEN 'No Aplica' ";
                $cadena_sql.=" WHEN puntaje_direccion !='NULL' THEN puntaje_direccion END  AS puntaje ";
                $cadena_sql.=" FROM docencia.dependencia_docente   ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.direccion_trabajos ON docente_direccion = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.direccion_tipo ON id_tipodireccion = tipo_direccion   ";
                $cadena_sql.=" JOIN docencia.direccion_categoria  ON id_categoriadireccion = categoria_direccion   ";
                $cadena_sql.=" JOIN docencia.autors_direccion ON autors_direccion.id_direccion=docencia.direccion_trabajos.id_direccion ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND dependencia_iddocente='" . $variable . "' ";
                $cadena_sql.=" ORDER BY titulo_direccion ";
                break;

            case "autores_datosDireccionTrab":
                $cadena_sql = " SELECT DISTINCT ";
                $cadena_sql.=" titulo_direccion, string_agg(nom_autor,',') ";
                $cadena_sql.=" FROM docencia.dependencia_docente   ";
                $cadena_sql.=" JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.direccion_trabajos ON docente_direccion = dependencia_iddocente   ";
                $cadena_sql.=" JOIN docencia.direccion_tipo ON id_tipodireccion = tipo_direccion   ";
                $cadena_sql.=" JOIN docencia.direccion_categoria  ON id_categoriadireccion = categoria_direccion   ";
                $cadena_sql.=" JOIN docencia.autors_direccion ON autors_direccion.id_direccion=docencia.direccion_trabajos.id_direccion ";
                $cadena_sql.=" WHERE 1=1 ";
                $cadena_sql.=" AND docente_direccion='" . $variable . "' ";
                $cadena_sql.=" GROUP BY docencia.direccion_trabajos.id_direccion ";
                $cadena_sql.=" ORDER BY titulo_direccion ";
                break;


            //*********************************************Otras consultas **********************************************************

            case "buscarNombreDocente" :
                $cadena_sql = "SELECT ";
                $cadena_sql .= "informacion_numeroidentificacion, ";
                $cadena_sql .= "informacion_numeroidentificacion || ' - ' || UPPER(informacion_nombres)|| ' ' ||UPPER(informacion_apellidos) ";
                $cadena_sql .= "FROM ";
                $cadena_sql .= "docencia.docente_informacion ";
                $cadena_sql .= "WHERE ";
                $cadena_sql .= "informacion_estadoregistro = TRUE ";
                break;

            case "consultarDocente" :
                $cadena_sql = "SELECT informacion_numeroidentificacion, ";
                $cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
                $cadena_sql .= "FROM docencia.docente_informacion ";
                $cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
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
                $cadena_sql.= " WHERE excelencia_idserial = '" . $variable['idserial'] . "' ";
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
