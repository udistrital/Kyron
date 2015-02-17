<?php
$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$miSesion = Sesion::singleton ();

// Novedades
$enlaceRegistroNovedades ['enlace'] = "pagina=novedades";
$enlaceRegistroNovedades ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceRegistroNovedades ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceRegistroNovedades ['enlace'], $directorio );
$enlaceRegistroNovedades ['nombre'] = "Novedades";

// Registro Docente
$enlaceRegistroDocente ['enlace'] = "pagina=registroDocente";
$enlaceRegistroDocente ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceRegistroDocente ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceRegistroDocente ['enlace'], $directorio );
$enlaceRegistroDocente ['nombre'] = "Crear Docente";

// Estado Docente
$enlaceEstadoDocente ['enlace'] = "pagina=estadoDocente";
$enlaceEstadoDocente ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceEstadoDocente ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceEstadoDocente ['enlace'], $directorio );
$enlaceEstadoDocente ['nombre'] = "Cambiar Estado Docente";

// Ingresar Descarga Por Investigación
$enlaceDescargaInvestigacion ['enlace'] = "pagina=descargaPorInvestigacion";
$enlaceDescargaInvestigacion ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceDescargaInvestigacion ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceDescargaInvestigacion ['enlace'], $directorio );
$enlaceDescargaInvestigacion ['nombre'] = "Ingresar Descarga Por Investigación";

// Experiencia Profesional Docente
$enlaceexperienciaProfesional ['enlace'] = "pagina=experienciaProfesional";
$enlaceexperienciaProfesional ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceexperienciaProfesional ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceexperienciaProfesional ['enlace'], $directorio );
$enlaceexperienciaProfesional ['nombre'] = "Experiencia Profesional  ";

// Registro Premios Docente
$enlacepremiosDocente ['enlace'] = "pagina=premiosDocente";
$enlacepremiosDocente ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlacepremiosDocente ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlacepremiosDocente ['enlace'], $directorio );
$enlacepremiosDocente ['nombre'] = "Premios Docente  ";

// Tecnologia y Sotfware Docente
$enlacetecSofDocente ['enlace'] = "pagina=tecSofDocente";
$enlacetecSofDocente ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlacetecSofDocente ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlacetecSofDocente ['enlace'], $directorio );
$enlacetecSofDocente ['nombre'] = "Registrar Técnica y Software Docente  ";

// Obras Artistica Docente
$enlaceobrasartisticasDocente ['enlace'] = "pagina=obrasartisticasDocente";
$enlaceobrasartisticasDocente ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceobrasartisticasDocente ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceobrasartisticasDocente ['enlace'], $directorio );
$enlaceobrasartisticasDocente ['nombre'] = "Obras Artísticas Docente ";

// Premios Otorgados Docente
$enlaceponenciaDocente ['enlace'] = "pagina=ponenciaDocente";
$enlaceponenciaDocente ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceponenciaDocente ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceponenciaDocente ['enlace'], $directorio );
$enlaceponenciaDocente ['nombre'] = "Ponencias Docente";

// Publicaciones Impresas Univeristarias
$enlacepublImprUnivDocente ['enlace'] = "pagina=publImprUnivDocente";
$enlacepublImprUnivDocente ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlacepublImprUnivDocente ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlacepublImprUnivDocente ['enlace'], $directorio );
$enlacepublImprUnivDocente ['nombre'] = " Publicaciones Impresas Universitarias  Docente  ";

// Traducciones Docente
$enlacetraduccionesDocente ['enlace'] = "pagina=traduccionesDocente";
$enlacetraduccionesDocente ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlacetraduccionesDocente ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlacetraduccionesDocente ['enlace'], $directorio );
$enlacetraduccionesDocente ['nombre'] = " Traducción de Artículos del  Docente  ";

// Obras Artisticas Docente ll
$enlaceobrasartisticasLLDocente ['enlace'] = "pagina=obrasartisticasLLDocente";
$enlaceobrasartisticasLLDocente ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceobrasartisticasLLDocente ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceobrasartisticasLLDocente ['enlace'], $directorio );
$enlaceobrasartisticasLLDocente ['nombre'] = "Obras Artísticas Docente ";

// Ingresar Movilidad
$enlaceIngresarMovilidad ['enlace'] = "pagina=registrarMovilidadDocente";
$enlaceIngresarMovilidad ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceIngresarMovilidad ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceIngresarMovilidad ['enlace'], $directorio );
$enlaceIngresarMovilidad ['nombre'] = "Ingresar Movilidad";

// Registro de Videos
$enlaceproduccionvideosDocente ['enlace'] = "pagina=produccionvideosDocente";
$enlaceproduccionvideosDocente ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceproduccionvideosDocente ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceproduccionvideosDocente ['enlace'], $directorio );
$enlaceproduccionvideosDocente ['nombre'] = "Producción en Videos del Docente  ";

// Gestion Titulos Academicos
$enlacetitulosAcademicos ['enlace'] = "pagina=titulosAcademicos";
$enlacetitulosAcademicos ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlacetitulosAcademicos ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlacetitulosAcademicos ['enlace'], $directorio );
$enlacetitulosAcademicos ['nombre'] = "Títulos Académicos";

// Asignar Docente sin Titulo
$enlacedocenteSinTitulo ['enlace'] = "pagina=sinTitulosAcademicos";
$enlacedocenteSinTitulo ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlacedocenteSinTitulo ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlacedocenteSinTitulo ['enlace'], $directorio );
$enlacedocenteSinTitulo ['nombre'] = "Docentes Sin Títulos Académicos";

// Experiencia Investigacion
$enlaceexperienciaInvestigacion ['enlace'] = "pagina=experienciaInvestigacion";
$enlaceexperienciaInvestigacion ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceexperienciaInvestigacion ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceexperienciaInvestigacion ['enlace'], $directorio );
$enlaceexperienciaInvestigacion ['nombre'] = "Experiencia en Investigación";

// Experiencia Docente
$enlaceexperienciaDocencia ['enlace'] = "pagina=experienciaDocencia";
$enlaceexperienciaDocencia ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceexperienciaDocencia ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceexperienciaDocencia ['enlace'], $directorio );
$enlaceexperienciaDocencia ['nombre'] = "Experiencia en Docencia";

// Comunicacion Corta
$enlacecomunicacionCorta ['enlace'] = "pagina=comunicacionCorta";
$enlacecomunicacionCorta ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlacecomunicacionCorta ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlacecomunicacionCorta ['enlace'], $directorio );
$enlacecomunicacionCorta ['nombre'] = "Comunicacion Corta";

// Cartas al editor
$enlacecartasEditor ['enlace'] = "pagina=cartasEditor";
$enlacecartasEditor ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlacecartasEditor ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlacecartasEditor ['enlace'], $directorio );
$enlacecartasEditor ['nombre'] = "Cartas al Editor";

// Cartas al editor
$enlaceregistroLibros ['enlace'] = "pagina=registroLibros";
$enlaceregistroLibros ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceregistroLibros ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceregistroLibros ['enlace'], $directorio );
$enlaceregistroLibros ['nombre'] = "Producción de Libros";

// Asignar Docente sin Titulo
$enlacedocenteConCarga ['enlace'] = "pagina=docentesconcarga";
$enlacedocenteConCarga ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlacedocenteConCarga ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlacedocenteConCarga ['enlace'], $directorio );
$enlacedocenteConCarga ['nombre'] = "Docentes Con Carga Académica";

// Registra publicaciones de docente
$enlaceindexacionRevistas ['enlace'] = "pagina=indexacionRevistas";
$enlaceindexacionRevistas ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceindexacionRevistas ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceindexacionRevistas ['enlace'], $directorio );
$enlaceindexacionRevistas ['nombre'] = "Revistas indexadas";

// Registra Patentes de docente
$enlaceregistrarPatentes ['enlace'] = "pagina=registrarPatentes";
$enlaceregistrarPatentes ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceregistrarPatentes ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceregistrarPatentes ['enlace'], $directorio );
$enlaceregistrarPatentes ['nombre'] = "Patentes";

// Registra traducciones docente
$enlaceregistrarTraducciones ['enlace'] = "pagina=registrarTraducciones";
$enlaceregistrarTraducciones ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceregistrarTraducciones ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceregistrarTraducciones ['enlace'], $directorio );
$enlaceregistrarTraducciones ['nombre'] = "Traducciones";

// Registra empresas base tecnologica
$enlaceregistrarEmpresas ['enlace'] = "pagina=registrarEmpresas";
$enlaceregistrarEmpresas ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceregistrarEmpresas ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceregistrarEmpresas ['enlace'], $directorio );
$enlaceregistrarEmpresas ['nombre'] = "Empresas de Base Tecnológica";

// Registra estudios doctorales de docentes
$enlaceestudiosDoctorales ['enlace'] = "pagina=estudiosDoctorales";
$enlaceestudiosDoctorales ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceestudiosDoctorales ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceestudiosDoctorales ['enlace'], $directorio );
$enlaceestudiosDoctorales ['nombre'] = "Estudios PostDoctorales";

// Registra resena critica
$enlaceresenaCritica ['enlace'] = "pagina=resenaCritica";
$enlaceresenaCritica ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceresenaCritica ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceresenaCritica ['enlace'], $directorio );
$enlaceresenaCritica ['nombre'] = "Reseña Crítica";

// Registra interpretaciones musicales
$enlaceregistrarInterpretaciones ['enlace'] = "pagina=registrarInterpretaciones";
$enlaceregistrarInterpretaciones ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceregistrarInterpretaciones ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceregistrarInterpretaciones ['enlace'], $directorio );
$enlaceregistrarInterpretaciones ['nombre'] = "Registrar Interpretaciones";

// Registrar direccion de trabajos de grado
$enlacedireccionTrabajos ['enlace'] = "pagina=direccionTrabajos";
$enlacedireccionTrabajos ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlacedireccionTrabajos ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlacedireccionTrabajos ['enlace'], $directorio );
$enlacedireccionTrabajos ['nombre'] = "Dirección de Trabajos de Grado";

// Movilidad Docente
$enlaceregistrarMovilidadDocente ['enlace'] = "pagina=registrarMovilidadDocente";
$enlaceregistrarMovilidadDocente ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceregistrarMovilidadDocente ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceregistrarMovilidadDocente ['enlace'], $directorio );
$enlaceregistrarMovilidadDocente ['nombre'] = "Movilidad Docente  ";

// Actividad Academica
$enlaceactividadacademicaDocente ['enlace'] = "pagina=actividadacademicaDocente";
$enlaceactividadacademicaDocente ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceactividadacademicaDocente ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceactividadacademicaDocente ['enlace'], $directorio );
$enlaceactividadacademicaDocente ['nombre'] = "Actividad Académica del Docente";

// Investigacion Diciplinaria
$enlaceinvesdiciplinariasDocente ['enlace'] = "pagina=invesdiciplinariasDocente";
$enlaceinvesdiciplinariasDocente ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceinvesdiciplinariasDocente ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceinvesdiciplinariasDocente ['enlace'], $directorio );
$enlaceinvesdiciplinariasDocente ['nombre'] = "Investigación Disciplinaria del Docente";


// Registrar descarga por investigacion
$enlacedescargaInvestigacion ['enlace'] = "pagina=descargaInvestigacion";
$enlacedescargaInvestigacion ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlacedescargaInvestigacion ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlacedescargaInvestigacion ['enlace'], $directorio );
$enlacedescargaInvestigacion ['nombre'] = "Descarga por investigación";

// Ingresar Extension
$enlaceingresarExtension ['enlace'] = "pagina=ingresarExtension";
$enlaceingresarExtension ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceingresarExtension ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceingresarExtension ['enlace'], $directorio );
$enlaceingresarExtension ['nombre'] = "Ingresar Extensión";

// Avances Financieros
$enlaceavancesFinancieros ['enlace'] = "pagina=avancesFinancieros";
$enlaceavancesFinancieros ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceavancesFinancieros ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceavancesFinancieros ['enlace'], $directorio );
$enlaceavancesFinancieros ['nombre'] = "Ingresar Avances Financieros";

// Ingresar Convenios
$enlaceIngresarConvenios ['enlace'] = "pagina=ingresarConvenios";
$enlaceIngresarConvenios ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceIngresarConvenios ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceIngresarConvenios ['enlace'], $directorio );
$enlaceIngresarConvenios ['nombre'] = "Ingresar Convenios";

// Experiencia Calificada
$enlaceExperienciaCalificada ['enlace'] = "pagina=experienciaCalificada";
$enlaceExperienciaCalificada ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceExperienciaCalificada ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceExperienciaCalificada ['enlace'], $directorio );
$enlaceExperienciaCalificada ['nombre'] = "Experiencia Calificada";

// Excelencia Académica
$enlaceExcelenciaAcademica ['enlace'] = "pagina=excelenciaAcademica";
$enlaceExcelenciaAcademica ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceExcelenciaAcademica ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceExcelenciaAcademica ['enlace'], $directorio );
$enlaceExcelenciaAcademica ['nombre'] = "Excelencia Académica";

// Experiencia Dirección Academica
$enlaceexperienciaDireccion ['enlace'] = "pagina=experienciaDireccion";
$enlaceexperienciaDireccion ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlaceexperienciaDireccion ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceexperienciaDireccion ['enlace'], $directorio );
$enlaceexperienciaDireccion ['nombre'] = "Experiencia Dirección Académica";

// Capitulo Libros
$enlacecapitulosLibros ['enlace'] = "pagina=capituloLibros";
$enlacecapitulosLibros ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId ();

$enlacecapitulosLibros ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlacecapitulosLibros ['enlace'], $directorio );
$enlacecapitulosLibros ['nombre'] = "Capítulos de Libros";

//Gestión de Reportes
$enlaceReportes['enlace'] = "pagina=gestorReportes";
$enlaceReportes['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceReportes['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceReportes['enlace'], $directorio);
$enlaceReportes['nombre'] = "Gestor de Reportes";

//consultar actividad docente
$enlaceActividad['enlace'] = "pagina=actividadAcademicaD";
$enlaceActividad ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceActividad ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceActividad['enlace'], $directorio);
$enlaceActividad ['nombre'] = "Consultar Actividad Académica Docente";

//consultar actividad docente
$enlaceCuenta['enlace'] = "pagina=cuentaIndividual";
$enlaceCuenta['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceCuenta['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceCuenta['enlace'], $directorio);
$enlaceCuenta['nombre'] = "Estado de Cuenta Individual Docente";
?>
<div class="wrap">

	<div class="demo-container">
		<div class="black">
			<ul id="mega-menu-1" class="mega-menu">
				<li><a href="#">Inicio</a></li>
				<li><a href="#">Hoja de Vida</a>
                                    <ul>
                                        <li><a href="<?php echo $enlaceRegistroDocente['urlCodificada']?>"><?php echo $enlaceRegistroDocente['nombre']?></a></li>
                                        <!--<li><a href="<?php echo $enlaceEstadoDocente['urlCodificada']?>"><?php echo $enlaceEstadoDocente ['nombre']?></a></li>-->
                                        <li><a href="<?php echo $enlacetitulosAcademicos['urlCodificada']?>"><?php echo $enlacetitulosAcademicos ['nombre']?></a></li>
                                        <li><a href="<?php echo $enlacedocenteSinTitulo['urlCodificada']?>"><?php echo $enlacedocenteSinTitulo['nombre']?></a></li>						
                                        <!--<li><a href="<?php echo $enlaceIngresarConvenios['urlCodificada']?>"><?php echo $enlaceIngresarConvenios['nombre']?></a></li>-->
                                        <!--<li><a href="<?php echo $enlacedescargaInvestigacion['urlCodificada']?>"><?php echo $enlacedescargaInvestigacion['nombre']?></a></li>-->
                                        <!--<li><a href="<?php echo $enlaceavancesFinancieros['urlCodificada']?>"><?php echo $enlaceavancesFinancieros['nombre']?></a></li>-->
                                        <!--<li><a href="<?php echo $enlaceIngresarMovilidad['urlCodificada']?>"><?php echo $enlaceIngresarMovilidad['nombre']?></a></li>-->
                                        <!--<li><a href="<?php echo $enlaceingresarExtension['urlCodificada']?>"><?php echo $enlaceingresarExtension['nombre']?></a></li>-->
                                        <li><a href="<?php echo $enlaceActividad['urlCodificada'] ?>"><?php echo $enlaceActividad['nombre'] ?></a></li>
                                        <!--<li><a href="<?php echo $enlaceinvesdiciplinariasDocente['urlCodificada']?>"><?php echo $enlaceinvesdiciplinariasDocente['nombre']?></a></li>-->
                                    </ul>
                                </li>

				<li><a href="#">Asignaci&oacute;n de Puntajes</a>
                                    <ul>
                                        <li><a href="#">Salariales</a>
                                            <ul>
                                                <li><a href="<?php echo $enlacecapitulosLibros['urlCodificada']?>"><?php echo $enlacecapitulosLibros['nombre']?></a></li>
                                                <li><a href="<?php echo $enlacecartasEditor['urlCodificada']?>"><?php echo $enlacecartasEditor['nombre']?></a></li>
                                                <li><a href="<?php echo $enlacedireccionTrabajos['urlCodificada']?>"><?php echo $enlacedireccionTrabajos['nombre']?></a></li>
                                                <li><a href="<?php echo $enlaceexperienciaDireccion['urlCodificada']?>"><?php echo $enlaceexperienciaDireccion['nombre']?></a></li>																
                                                <li><a href="<?php echo $enlaceexperienciaInvestigacion['urlCodificada']?>"><?php echo $enlaceexperienciaInvestigacion['nombre']?></a></li>
                                                <li><a href="<?php echo $enlaceexperienciaDocencia['urlCodificada']?>"><?php echo $enlaceexperienciaDocencia['nombre']?></a></li>        
                                                <li><a href="<?php echo $enlaceexperienciaProfesional['urlCodificada']?>"><?php echo $enlaceexperienciaProfesional['nombre']?></a></li>
                                                <li><a href="<?php echo $enlaceExperienciaCalificada['urlCodificada'] ?>"><?php echo $enlaceExperienciaCalificada['nombre'] ?></a></li>
                                                <li><a href="<?php echo $enlaceExcelenciaAcademica['urlCodificada'] ?>"><?php echo $enlaceExcelenciaAcademica['nombre'] ?></a></li>
                                                <li><a href="<?php echo $enlaceindexacionRevistas['urlCodificada']?>"><?php echo $enlaceindexacionRevistas['nombre']?></a></li>                                                   
	                      						<li><a href="<?php echo $enlacecomunicacionCorta['urlCodificada']?>"><?php echo $enlacecomunicacionCorta['nombre']?></a></li>
                                                <li><a href="<?php echo $enlaceobrasartisticasDocente['urlCodificada']?>"><?php echo $enlaceobrasartisticasDocente['nombre']?></a></li>	
                                                <li><a href="<?php echo $enlaceregistrarPatentes['urlCodificada']?>"><?php echo $enlaceregistrarPatentes['nombre']?></a></li>                                                
                                                <li><a href="<?php echo $enlacepremiosDocente['urlCodificada']?>"><?php echo $enlacepremiosDocente['nombre']?></a></li>
                                                <li><a href="<?php echo $enlaceproduccionvideosDocente['urlCodificada']?>"><?php echo $enlaceproduccionvideosDocente['nombre']?></a></li>								
                                                <li><a href="<?php echo $enlaceregistroLibros['urlCodificada']?>"><?php echo $enlaceregistroLibros['nombre']?></a></li>
                                                <li><a href="<?php echo $enlaceregistrarTraducciones['urlCodificada']?>"><?php echo $enlaceregistrarTraducciones['nombre']?></a></li>
                                                <li><a href="<?php echo $enlacetecSofDocente['urlCodificada']?>"><?php echo $enlacetecSofDocente['nombre']?></a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Bonificaci&oacute;n</a>
                                            <ul>
                                                <li><a href="<?php echo $enlacepublImprUnivDocente['urlCodificada']?>"><?php echo $enlacepublImprUnivDocente ['nombre']?></a></li>
                                                <li><a href="<?php echo $enlaceestudiosDoctorales['urlCodificada']?>"><?php echo $enlaceestudiosDoctorales['nombre']?></a></li>
                                                <li><a href="<?php echo $enlaceresenaCritica['urlCodificada']?>"><?php echo $enlaceresenaCritica ['nombre']?></a></li>
                                                <!--<li><a href="<?php echo $enlaceregistrarEmpresas['urlCodificada']?>"><?php echo $enlaceregistrarEmpresas['nombre']?></a></li>-->
                                                <!--<li><a href="<?php echo $enlaceregistrarInterpretaciones['urlCodificada']?>"><?php echo $enlaceregistrarInterpretaciones['nombre']?></a></li>      -->
                                                <li><a href="<?php echo $enlacetraduccionesDocente['urlCodificada']?>"><?php echo $enlacetraduccionesDocente['nombre']?></a></li>  
                                                <li><a href="<?php echo $enlaceponenciaDocente['urlCodificada']?>"><?php echo $enlaceponenciaDocente ['nombre']?></a></li>								    
                                           </ul>
                                        </li>
                                        <li><a href="#">Novedades</a>
                                            <ul>
                                                <li><a href="<?php echo $enlaceRegistroNovedades['urlCodificada']?>"><?php echo $enlaceRegistroNovedades['nombre']?></a></li>
                                            </ul>
                                        </li>
                                    </ul>
			</li>
                        
                    <li><a  href="">Reportes Docencia</a>
                    <ul>
                        <li><a href="#">Consultar Reportes Docencia</a>
                            <ul>
                                <li><a href="<?php echo $enlaceReportes['urlCodificada'] ?>"><?php echo $enlaceReportes['nombre'] ?></a></li>
                            </ul>
                            <ul>
                                <li><a href="<?php echo $enlaceCuenta['urlCodificada'] ?>"><?php echo $enlaceCuenta['nombre'] ?></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>



        <?php  $pagina = $this->miConfigurador->getVariableConfiguracion("site") ?>
      <li><a href="<?php  echo $pagina ?>">Cerrar Sesi&oacute;n</a></li>
			</ul>
		</div>
	</div>

</div>

