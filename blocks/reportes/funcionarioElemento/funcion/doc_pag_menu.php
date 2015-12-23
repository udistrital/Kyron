<?PHP
require_once ('dir_relativo.cfg');
require_once (dir_conect . 'valida_pag.php');
require_once ('../generales/gen_link.php');
require_once (dir_conect . 'fu_tipo_user.php');
require_once ("../clase/config.class.php");
include_once ("../clase/multiConexion.class.php");
require_once ("../clase/encriptar.class.php");

$esta_configuracion = new config ();
$configuracion = $esta_configuracion->variable ( "../" );
$cripto = new encriptar ();
fu_tipo_user ( 30 );
$conexion = new multiConexion ();
ob_start ();
$indiceAcademico = $configuracion ["host"] . $configuracion ["raiz_sga"] . "/index.php?";
$indiceAcademico1 = $configuracion ["raiz_sga"] . "/index.php?";

// Consejerias
$variable = "pagina=admin_consejeriasDocente";
$variable .= "&usuario=" . $_SESSION ['usuario_login'];
$variable .= "&opcion=verProyectos";
$variable .= "&tipoUser=30";
$variable .= "&modulo=Docente";
$variable .= "&aplicacion=Condor";
$variable = $cripto->codificar_url ( $variable, $configuracion );
$enlaceAcademicoConsejerias = $indiceAcademico1 . $variable;

// Dig NOTAS
$indiceDoc = $configuracion ["host"] . "/weboffice/index.php?";

$variable = "pagina=registro_notasDocente";
$variable .= "&usuario=" . $_SESSION ['usuario_login'];
$variable .= "&action=loginCondor";
$variable .= "&nivel=PREGRADO";
$variable .= "&tipoUser=30";
$variable .= "&modulo=docentes";
$variable .= "&tiempo=300";
$variable = $cripto->codificar_url ( $variable, $configuracion );
$enlaceNotasDocentesPregrado = $indiceDoc . $variable;

$indiceDoc = $configuracion ["host"] . "/weboffice/index.php?";

$variable = "pagina=registro_notasDocente";
$variable .= "&usuario=" . $_SESSION ['usuario_login'];
$variable .= "&action=loginCondor";
$variable .= "&nivel=POSGRADO";
$variable .= "&tipoUser=30";
$variable .= "&modulo=docentes";
$variable .= "&tiempo=300";
$variable = $cripto->codificar_url ( $variable, $configuracion );
$enlaceNotasDocentesPosgrado = $indiceDoc . $variable;

$indiceDoc = $configuracion ["host"] . "/weboffice/index.php?";

$variable = "pagina=registro_notasDocente";
$variable .= "&usuario=" . $_SESSION ['usuario_login'];
$variable .= "&opcion=notasPerAnterior";
$variable .= "&nivel=ANTERIOR";
$variable .= "&tipoUser=30";
$variable .= "&aplicacion=Condor";
$variable .= "&modulo=docentes";
$variable .= "&tiempo=300";
$variable = $cripto->codificar_url ( $variable, $configuracion );
$enlaceNotasDocentesAnterior = $indiceDoc . $variable;

/*
 * $variable="pagina=adminConsultasAdmisiones"; $variable.="&usuario=".$_SESSION['usuario_login']; $variable.="&opcion=consultaDatosAspirantes"; $variable.="&tipoUser=33"; $variable.="&aplicacion=Condor"; $variable=$cripto->codificar_url($variable,$configuracion); $enlaceConsultasAspirantes=$indice.$variable;
 */

$indicePlanDocActual = $configuracion ["host"] . "/weboffice/index.php?";

$variable = "pagina=registro_plan_trabajo";
$variable .= "&usuario=" . $_SESSION ['usuario_login'];
$variable .= "&action=loginCondor";
$variable .= "&nivel=A";
$variable .= "&tipoUser=30";
$variable .= "&modulo=planTrabajo";
$variable .= "&tiempo=300";
$variable = $cripto->codificar_url ( $variable, $configuracion );
$enlaceDocentesPlanTrabajoActual = $indicePlanDocActual . $variable;

$indicePlanDocProximo = $configuracion ["host"] . "/weboffice/index.php?";

$variable = "pagina=registro_plan_trabajo";
$variable .= "&usuario=" . $_SESSION ['usuario_login'];
$variable .= "&action=loginCondor";
$variable .= "&nivel=X";
$variable .= "&tipoUser=30";
$variable .= "&modulo=planTrabajo";
$variable .= "&tiempo=300";
$variable = $cripto->codificar_url ( $variable, $configuracion );
$enlaceDocentesPlanTrabajoProximo = $indicePlanDocProximo . $variable;

/*
 * $indice=$configuracion["host"].$configuracion["raiz_sga"]."/index.php?"; $indice1=$configuracion["raiz_sga"]."/index.php?"; //$indice="http://oasdes.udistrital.edu.co/weboffice/webofficepro/index.php?"; //$indice="http://10.20.0.39/webofficepro/index.php?"; $variable="pagina=login"; $variable.="&usuario=".$_SESSION['usuario_login']; $variable.="&action=loginCondor"; $variable.="&tipoUser=84"; $variable.="&modulo=AdminBlogdev"; $variable.="&tiempo=".$_SESSION['usuario_login']; $variable=$cripto->codificar_url($variable,$configuracion); $enlaceWeboffice=$indice.$variable;
 */

// Menú para ingresar a la página de docencia.
$indiceDoc = $configuracion ["host"] . "/docencia/index.php?";
$variable = "pagina=login";
$variable .= "&usuario=" . $_SESSION ['usuario_login'];
$variable .= "&action=loginCondor";
$variable .= "&tipoUser=30";
$variable .= "&modulo=Docencia";
$variable .= "&tiempo=" . $_SESSION ['usuario_login'];
$variable = $cripto->codificar_url ( $variable, $configuracion );
$enlaceDocencia = $indiceDoc . $variable;

// Biblioteca
$variable = "pagina=admin_biblioteca";
$variable .= "&usuario=" . $_SESSION ['usuario_login'];
$variable .= "&opcion=adminBiblioteca";
$variable .= "&tipoUser=30";
$variable .= "&modulo=Docente";
$variable .= "&aplicacion=Condor";
$variable = $cripto->codificar_url ( $variable, $configuracion );
$enlaceAdminBiblioteca = $indiceAcademico . $variable;

/* enlce consulta docuemntos */
$variable = "pagina=adminDocumentosVinculacion";
$variable .= "&usuario=" . $_SESSION ['usuario_login'];
$variable .= "&action=loginCondor";
$variable .= "&opcion=inicio";
$variable .= "&tipoUser=30";
$variable .= "&nivel=A";
$variable .= "&modulo=Docente";
$variable .= "&aplicacion=Condor";
$variable .= "&tiempo=300";
$variable = $cripto->codificar_url ( $variable, $configuracion );
$enlaceDocumentoVinculacion = $indiceAcademico . $variable;

// Enlace para evaluación Docente
include_once ("crypto/Encriptador.class.php");
$miCodificador = Encriptador::singleton ();
$usuario = $_SESSION ['usuario_login'];
$identificacion = $_SESSION ['usuario_login'];
$tipo = 30;
$indiceSaraAcademica = $configuracion ["host"] . "/saraacademica/index.php?";
$tokenCondor = "condorSara2013!";
$tokenCondor = $miCodificador->codificar ( $tokenCondor );
$opcion = "temasys=";
$variable = "indexEvaluacion&pagina=docentes";
$variable .= "&usuario=" . $usuario;
$variable .= "&tipo=" . $tipo;
$variable .= "&token=" . $tokenCondor;
$variable .= "&opcionPagina=indexEvaluacion";
// $variable=$cripto->codificar_url($variable,$configuracion);
$variable = $miCodificador->codificar ( $variable );
$enlaceEvaldocentes = $indiceSaraAcademica . $opcion . $variable;

// Enlace para ver observaciones y resultados de evaluación docente
include_once ("crypto/Encriptador.class.php");
$miCodificador = Encriptador::singleton ();
$usuario = $_SESSION ['usuario_login'];
$identificacion = $_SESSION ['usuario_login'];
$tipo = 30;
$indiceSaraAcademica = $configuracion ["host"] . "/saraacademica/index.php?";
$tokenCondor = "condorSara2013!";
$tokenCondor = $miCodificador->codificar ( $tokenCondor );
$opcion = "temasys=";
$variable = "indexEvaluacion&pagina=docentes";
$variable .= "&usuario=" . $usuario;
$variable .= "&tipo=" . $tipo;
$variable .= "&token=" . $tokenCondor;
$variable .= "&opcionPagina=resultadosEvaluacion";
// $variable=$cripto->codificar_url($variable,$configuracion);
$variable = $miCodificador->codificar ( $variable );
$enlaceResultadosEvaldocentes = $indiceSaraAcademica . $opcion . $variable;

// Enlace para ver la lista de clase y enviar correo electónico a estudiantes.
include_once ("crypto/Encriptador.class.php");
$miCodificador = Encriptador::singleton ();
$usuario = $_SESSION ['usuario_login'];
$identificacion = $_SESSION ['usuario_login'];
$tipo = 30;
$indiceSaraAcademica = $configuracion ["host"] . "/saraacademica/index.php?";
$tokenCondor = "condorSara2013!";
$tokenCondor = $miCodificador->codificar ( $tokenCondor );
$opcion = "temasys=";
$variable = "indexEvaluacion&pagina=docentes";
$variable .= "&usuario=" . $usuario;
$variable .= "&tipo=" . $tipo;
$variable .= "&token=" . $tokenCondor;
$variable .= "&opcionPagina=listaClase";
// $variable=$cripto->codificar_url($variable,$configuracion);
$variable = $miCodificador->codificar ( $variable );
$enlaceListaClase = $indiceSaraAcademica . $opcion . $variable;

// Enlace para el cambio de contraseña
$usuario = $_SESSION ['usuario_login'];
$identificacion = $_SESSION ['usuario_login'];
$indiceSaraLaverna = $configuracion ["host_adm_pwd"] . "/lamasu/index.php?";
$tokenCondor = "condorSara2013!";
$tipo = 30;
$tokenCondor = $miCodificador->codificar ( $tokenCondor );
$opcion = "temasys=";
$variable .= "gestionPassword&pagina=docentes";
$variable .= "&usuario=" . $usuario;
$variable .= "&tipo=" . $tipo;
$variable .= "&token=" . $tokenCondor;
$variable .= "&opcionPagina=cambioPassword";
// $variable=$cripto->codificar_url($variable,$configuracion);
$variable = $miCodificador->codificar ( $variable );
$enlaceCambioPassword = $indiceSaraLaverna . $opcion . $variable;

// enlace administrados Evaluación Docente
include_once ("crypto/Encriptador.class.php");
$miCodificador = Encriptador::singleton ();
$usuario = $_SESSION ['usuario_login'];
$identificacion = $_SESSION ['usuario_login'];
$tipo = 30;
$indiceKyron = $configuracion ["host"] . "/kyronFinal/index.php?";
$tokenCondor = "condorKyron2015!";
$tokenCondor = $miCodificador->codificar ( $tokenCondor );
$opcion = "kyronConexion=";
$variable .= "|pagina=docencia";
$variable .= "|usuario=" . $usuario;
$variable .= "|tipo=" . $tipo;
$variable .= "|token=" . $tokenCondor;
$variable .= "|opcionPagina=indexEstadoCuenta";
// $variable=$cripto->codificar_url($variable,$configuracion);
$variable = $miCodificador->codificar ( $variable );
$enlaceEstadoCuenta = $indiceKyron . $opcion . $variable;

// Enlace consulta de certificado de ingresos y retenciones
include_once ("crypto/Encriptador.class.php");
$miCodificador = Encriptador::singleton ();
$usuario = $_SESSION ['usuario_login'];
$identificacion = $_SESSION ['usuario_login'];
$indiceSaraLaverna = $configuracion ["host_adm_pwd"] . "/saraadministrativa/index.php?";
$tokenCondor = "s4r44dm1n1str4t1v4C0nd0r2014!";
$tipo = 30;
$tokenCondor = $miCodificador->codificar ( $tokenCondor );
$opcion = "temasys=";
$variable .= "gestionPassword&pagina=certificaciones";
$variable .= "&usuario=" . $usuario;
$variable .= "&tipo=" . $tipo;
$variable .= "&token=" . $tokenCondor;
$variable .= "&opcionPagina=gestionAdministrativos";
// $variable=$cripto->codificar_url($variable,$configuracion);
$variable = $miCodificador->codificar ( $variable );
$enlaceCertificadosIngRet = $indiceSaraLaverna . $opcion . $variable;

// var_dump($_SESSION);exit;

/**
 * ****
 */
// Enlace a Invetarios Docente en el sistema Arka
include_once ("crypto/Encriptador.class.php");
$miCodificador = Encriptador::singleton ();
$usuario = $_SESSION ['usuario_login'];
$identificacion = $_SESSION ['usuario_login'];
$tipo = 30;
$indiceArkaInventarios = $configuracion ["host_inventario"] . "/arka/index.php?";
$tokenCondor = "0xel0t1l";
$opcion = "data=";
$variable = "actionBloque=funcionarioElemento";
$variable .= "&pagina=inventarioFuncionario";
$variable .= "&bloqueGrupo=inventarios/gestionElementos";
$variable .= "&bloque=funcionarioElemento";
$variable .= "&opcion=Consultar";
$variable .= "&identificacion=" . $identificacion;
$variable .= "&usuario=" . $identificacion;
$variable .= "&accesoCondor=true";

$variable = $miCodificador->codificar_arka ( $variable, $tokenCondor );
$enlaceInventarioDocente = $indiceArkaInventarios . $opcion . $variable;

?>
<html>
<head>
<script language="JavaScript" src="../script/clicder.js"></script>
<script language="JavaScript" src="../script/SlideMenu.js"></script>
<script language="JavaScript" src="../script/ventana.js"></script>
<script language="JavaScript" src="../script/BorraLink.js"></script>

</head>

<body class='menu'>

<? require_once('../usuarios/usuarios.php'); ?>

<script src="../script/jquery.min.js"></script>
	<link href="../estilo/menu.css" rel="stylesheet" type="text/css">

	<ul class="menu">

		<li class="item1"><a href="#">Datos Personales</a>
			<ul class="submenus">
				<li class="subitem1"><a target="principal"
					href="doc_actualiza_dat.php">Actualizar Datos </a></li>
			</ul></li>

		<li class="item2"><a href="#">Plan de trabajo</a>
			<ul class="submenus">
				<li class="subitem1"><a target="principal"
					href="<?echo $enlaceDocentesPlanTrabajoActual?>">Registrar Periodo
						Actual!</a></li>
				<li class="subitem1"><a target="principal"
					href="<?echo $enlaceDocentesPlanTrabajoProximo?>">Registrar Periodo
						Pr&oacute;ximo!</a></li>
				<li class="subitem1"><a href="#" class="postmenu">Reglamentaci&oacute;n</a>
					<ul class="submenus">
						<li class="subitem1"><a target="principal" href="est_doc.pdf">Estatuto
								Del Profesor</a></li>
						<li class="subitem1"><a target="principal"
							href="doc_circular003_pt.php">Circular 003</a></li>
						<li class="subitem1"><a target="principal"
							href="doc_circular008_pt.php">Circular 008</a></li>
					</ul>
			
			</ul></li>
		</li>

		<li class=""><a href="#">Asignaci&oacute;n Acad.</a>
			<ul class="submenus">
				<li class="subitem1"><a target="principal" href="doc_fre_carga.php">Asignaturas
				</a></li>
			</ul></li>

		<li class=""><a href="#">Consejerias </a>
			<ul class="submenus">
				<li class="subitem1"><a target="principal"
					href="<? echo $enlaceAcademicoConsejerias ?>">Consejerias </a></li>
			</ul></li>

		<li class="item5"><a href="#">Auto Evaluaci&oacute;n </a>
			<ul class="submenus">
				<li class="subitem1"><a target="principal"
					href="<?PHP echo $enlaceEvaldocentes?>">Auto Evaluaci&oacute;n</a></li>
				<li class="subitem1"><a target="principal"
					href="doc_obsevaciones.php">Observaciones de Est.</a></li>
				<li class="subitem1"><a target="principal"
					href="<?PHP echo $enlaceResultadosEvaldocentes?>">Obeservaciones
						Ev.</a></li>
			</ul></li>

		<li class="item5"><a href="#">Captura de Notas</a>
			<ul class="submenus">
				<li class="subitem1"><a target="principal" href="doc_curso.php">Lista
						de clase</a></li>
				<li class="subitem1"><a target="principal"
					href="<?echo $enlaceListaClase?>">Envío de correos</a></li>
				<li class="subitem1"><a target="principal"
					href="<?echo $enlaceNotasDocentesPregrado?>">Captura notas Pregrado</a></li>
				<li class="subitem1"><a target="principal"
					href="<?echo $enlaceNotasDocentesPosgrado?>">Captura notas Posgrado</a></li>
				<li class="subitem1"><a target="principal"
					href="doc_carga_curvac.php">Vacacionales</a></li>
				<li class="subitem1"><a target="principal"
					href="<?echo $enlaceNotasDocentesAnterior?>">Notas per. Anterior</a></li>
			</ul></li>

		<li class="item5"><a href="#">Servicios</a>
			<ul class="submenus">
				<!--<li class="subitem1"><a target="principal" href="<?PHP //echo $enlaceDocencia ?>">Estado de cuenta</a></li>-->
				<li class="subitem1"><a target="principal"
					href="<?PHP echo $enlaceEstadoCuenta ?>">Estado de cuenta Docencia</a></li>
				<li class="subitem1"><a target="principal" href="<?echo $CalAcad?>">Calendario
						Acad&eacute;mico</a></li>
				<li class="subitem1"><a target="principal"
					href="doc_contacta_doc.php">Contactar docentes</a></li>
				<li class="subitem1"><a target="principal"
					href="http://sgral.udistrital.edu.co/sgral/index.php?option=com_content&task=view&id=279&Itemid=116">Derechos
						Pecuniarios</a></li>
				<li class="subitem1"><a target="principal"
					href="../generales/estaturo_est.pdf">Estatuto estudiantil</a></li>
				<li class="subitem1"><a target="principal"
					href="../generales/gen_est_abhl.php">Estudiantes Activos</a></li>
				<li class="subitem1"><a target="principal"
					href="../generales/gen_fac_trabgrado.php">Trabajos de grado</a></li>

			</ul></li>

		<li class="item5"><a href="#">Vinculaci&oacute;n Docente</a>
			<ul class="submenus">
				<li class="subitem1"><a target="principal"
					href="<?PHP echo $enlaceDocumentoVinculacion ?>">Documentos </a></li>
			</ul></li>

		<li class="item5"><a href="#">Cert. Ingresos y Ret.</a>
			<ul class="submenus">
				<li class="subitem1"><a target="principal"
					href="<?echo $enlaceCertificadosIngRet?>">Certificados</a></li>
			</ul></li>

		<li class="item5"><a href="#">Biblioteca</a>
			<ul class="submenus">
				<li class="subitem1"><a target="principal"
					href="<?echo $enlaceAdminBiblioteca?>">Base de datos</a></li>
			</ul></li>
		<li class="item2"><a href="#">Manuales</a>
			<ul class="submenus">
				<li class="subitem1"><a target="principal"
					href="<?php echo $configuracion['host_soporte'].'/soporte/archivos/manual_vinculacion_docente_docente.pdf';?>">Manual
						Vinculaci&oacute;n Docente</a></li>
			</ul></li>

		<li class="item3"><a href="#">Inventario</a>
			<ul class="submenus">
				<li class="subitem1"><a target="principal"
					href="<?php echo $enlaceInventarioDocente ;?>">Inventario Docente</a></li>
			</ul></li>


		<li class="item5"><a href="#">Clave</a>
			<ul class="submenus">
				<li class="subitem1"><a target="principal"
					href="<?echo $enlaceCambioPassword?>">Cambiar mi clave</a></li>
			</ul></li>
		<li class=""><a target="_top" href="../conexion/salir.php"><font
				color="red">Cerrar Sesi&oacute;n </font></a></li>
	</ul>


	<!--initiate accordion-->
	<script type="text/javascript">
$(function() {

var menu_ul = $('.menu .submenus'),
menu_a  = $('.menu a');
var clase;
var link;
menu_ul.hide();

menu_a.click(function(e) {
link=$(this).attr('href');
if(link=='#')
{
clase=$(this).attr('class');
menu_a.removeClass('active');
$(this).addClass('active');
if($(this).next().css('display') == 'none'){ 
$(this).next().slideDown('fast');    
}
else
{
$(this).next().slideUp('fast');
}

}
});

});
</script>

	<!--initiate accordion-->
	<script type="text/javascript">

//makeMenu('top','Datos Personales')
	//makeMenu('sub','Actualizar','doc_actualiza_dat.php','principal')

//Menu 1	
//makeMenu('top','Plan de Trabajo')
	//makeMenu('sub','Registrar Periodo Actual!','<?echo $enlaceDocentesPlanTrabajoActual?>','principal')
	//makeMenu('sub','Registrar Periodo Pr&oacute;ximo!','<?echo $enlaceDocentesPlanTrabajoProximo?>','principal')
	//makeMenu('sub','Gestionar','doc_adm_pt.php','principal')
	//makeMenu('sub','Reglamentaci&oacute;n','','')
	//makeMenu('sub2','Estatuto Del Profesor','est_doc.pdf','principal')
	//makeMenu('sub2','Circular 003','doc_circular003_pt.php','principal')
	//makeMenu('sub2','Circular 008','doc_circular008_pt.php','principal')

//Menu 2
//makeMenu('top','Asignaci&oacute;n Acad.')
	//makeMenu('sub','Asignaturas','doc_fre_carga.php','principal')
	
//Menu 3
//makeMenu('top','Consejerias')
	// makeMenu('sub','Consejerias','<? echo $enlaceAcademicoConsejerias ?>','principal')

//Menu 4    
//makeMenu('top','Auto Evaluaci&oacute;n')
  //makeMenu('sub','Auto Evaluaci&oacute;n','../err/valida_evadoc.php','principal')
  //makeMenu('sub','Auto Evaluaci�n','../ev06/evaluacion.php','principal')
  //makeMenu('sub','Obs. Eva. Actual','doc_fre_observaciones.php','principal')
  //makeMenu('sub','Observaciones de Est.','doc_obsevaciones.php','principal')
  //makeMenu('sub','Resultados','../informes/resultados_uni_prom_20113.pdf','principal')

//Menu 5
//makeMenu('top','Captura de Notas')
  //makeMenu('sub','Lista de clase','doc_curso.php','principal')
  //makeMenu('sub','Captura notas Pregrado','<?echo $enlaceNotasDocentesPregrado?>','principal')
  //makeMenu('sub','Captura notas Posgrado','<?echo $enlaceNotasDocentesPosgrado?>','principal')
  //makeMenu('sub','Posgrado','doc_curso_posgrado.php','principal')
  //makeMenu('sub','Vacacionales','doc_carga_curvac.php','principal')
 // makeMenu('sub','Posgrados Per.Ant.','doc_carga_pos.php','principal')
 // makeMenu('sub','<center><b>REPORTES</b></center>','','')
  //makeMenu('sub','Per&iacute;odo Anterior','','')
  //makeMenu('sub','Notas per. Anterior','<?echo $enlaceNotasDocentesAnterior?>','principal')

//Menu 6
//makeMenu('top','Servicios')
 // makeMenu('sub','Estado de cuenta','<?PHP echo $enlaceDocencia ?>','principal')  
  //makeMenu('sub','Accesos a C&oacute;ndor','../generales/gen_uso_condor.php','principal')
  //makeMenu('sub','Calendario Acad&eacute;mico','<?echo $CalAcad?>','principal')
 // makeMenu('sub','Contactar Docentes','doc_contacta_doc.php','principal')
  //makeMenu('sub','Derechos Pecuniarios','http://sgral.udistrital.edu.co/sgral/index.php?option=com_content&task=view&id=279&Itemid=116','principal')
  //makeMenu('sub','Estatuto Estudiantil','../generales/estaturo_est.pdf','principal')
  //makeMenu('sub','Estudiantes Activos','../generales/gen_est_abhl.php','principal')
  //makeMenu('sub','Trabajos de Grado','../generales/gen_fac_trabgrado.php','principal')

//Menu 7
//makeMenu('top','Vinculaci&oacute;n Docente')         
       //makeMenu('sub','Documentos','<?PHP echo $enlaceDocumentoVinculacion ?>','principal')
  
//Menu 8
//makeMenu('top','Biblioteca')
  //makeMenu('sub','Bases de Datos','<?echo $enlaceAdminBiblioteca?>','principal')

//Menu 9
//makeMenu('top','Clave')
//makeMenu('sub','Cambiar mi Clave','../generales/cambiar_mi_clave.php','principal')

//Menu 10
//makeMenu('salir','Cerrar Sesi&oacute;n','../conexion/salir.php','_top','end')

//Ejecucin del men
onload=SlideMenuInit;
</script>

</body>
</html>
