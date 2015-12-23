<?PHP

require_once('dir_relativo.cfg');
require_once(dir_conect.'valida_pag.php');
require_once(dir_conect.'fu_tipo_user.php');
require_once('../generales/gen_link.php');
require_once("../clase/config.class.php");
require_once("../clase/encriptar.class.php");

	$esta_configuracion=new config();
	$configuracion=$esta_configuracion->variable("../"); 

	$cripto=new encriptar();
	
	fu_tipo_user(24);
	ob_start();

	$indice="http://oasdes.udistrital.edu.co/weboffice/webofficepro/index.php?";
	$variable="pagina=login";
	$variable.="&usuario=".$_SESSION['usuario_login'];
	$variable.="&action=loginCondor";
	$variable.="&tipoUser=24";
	$variable.="&modulo=funcionarioCapacitacion";
	$variable.="&tiempo=".$_SESSION['usuario_login'];

	$variable=$cripto->codificar_url($variable,$configuracion);
	$enlaceWeboffice=$indice.$variable;
	
	$indiceCIR=$configuracion["host"]."/weboffice/index.php?";
	$variable="pagina=adminIngresosRetenciones";
	$variable.="&usuario=".$_SESSION['usuario_login'];
	$variable.="&action=loginCondor";
	$variable.="&nivel=POSGRADO";
	$variable.="&tipoUser=24";
	$variable.="&modulo=certificadoIngRet";
	$variable.="&tiempo=300";
	
	$variable=$cripto->codificar_url($variable,$configuracion);
	$enlaceCertIngRet=$indiceCIR.$variable;
	
	$indiceAcademico=$configuracion["host"].$configuracion["raiz_sga"]."/index.php?";
	//Gestión de Certificados
	$variable="pagina=adminDesprendiblesPagos";
	$variable.="&usuario=".$_SESSION['usuario_login'];
	$variable.="&action=loginCondor";
	$variable.="&tipoUser=24";
	$variable.="&nivel=A";
	$variable.="&modulo=desprendiblesPagos";
	$variable.="&aplicacion=Condor";
	$variable.="&tiempo=300";
	$variable=$cripto->codificar_url($variable,$configuracion);
	$enlacePagos=$indiceAcademico.$variable;

        //Enlace para cambio de contraseña
        include_once("crypto/Encriptador.class.php");
        $miCodificador=Encriptador::singleton();
        $usuario = $_SESSION['usuario_login'];
        $identificacion = $_SESSION['usuario_login'];
        $indiceSaraLaverna = $configuracion["host_adm_pwd"]."/lamasu/index.php?";
        $tokenCondor = "condorSara2013!";
        $tipo=24;
        $tokenCondor = $miCodificador->codificar($tokenCondor);
        $opcion="temasys=";
        $variable.="gestionPassword&pagina=funcionario";                                                        
        $variable.="&usuario=".$usuario;
        $variable.="&tipo=".$tipo;
        $variable.="&token=".$tokenCondor;
        $variable.="&opcionPagina=cambioPassword";
        //$variable=$cripto->codificar_url($variable,$configuracion);
        $variable=$miCodificador->codificar($variable);
        $enlaceCambioPassword=$indiceSaraLaverna.$opcion.$variable;  
        
        //Enlace consulta de certificado de ingresos y retenciones
        include_once("crypto/Encriptador.class.php");
        $miCodificador=Encriptador::singleton();
        $usuario = $_SESSION['usuario_login'];
        $identificacion = $_SESSION['usuario_login'];
        $indiceSaraLaverna = $configuracion["host_adm_pwd"]."/saraadministrativa/index.php?";
        $tokenCondor = "s4r44dm1n1str4t1v4C0nd0r2014!";
        $tipo=24;
        $tokenCondor = $miCodificador->codificar($tokenCondor);
        $opcion="temasys=";
        $variable.="gestionPassword&pagina=certificaciones";                                                        
        $variable.="&usuario=".$usuario;
        $variable.="&tipo=".$tipo;
        $variable.="&token=".$tokenCondor;
        $variable.="&opcionPagina=gestionAdministrativos";
        //$variable=$cripto->codificar_url($variable,$configuracion);
        $variable=$miCodificador->codificar($variable);
        $enlaceCertificadosIngRet=$indiceSaraLaverna.$opcion.$variable;
        
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

<li class="item1">
<a href="#">Datos Personales</a>
<ul class="submenus">
<li class="subitem1"><a target="principal" href="fun_verifica_dat.php">Verificar</a></li>
<li class="subitem1"><a target="principal" href="fun_beneficiarios.php">Beneficiarios</a></li>
<li class="subitem1"><a target="principal" href="fun_seguridad_social.php">Seguridad Social</a></li>
</ul>
</li>

<li class="item5">
<a href="#">Formaci&oacute;n</a>
<ul class="submenus">
<li class="subitem1"><a target="principal" href="fun_formacion.php">B&aacute;sica y Superior</a></li>
<li class="subitem1"><a target="principal" href="fun_cursos.php">Cursos</a></li>
</ul>
</li>

<li class="item5">
<a href="#">Cargos</a>
<ul class="submenus">
<li class="subitem1"><a target="principal" href="fun_cargo.php">Actual</a></li>
<li class="subitem1"><a target="principal" href="fun_hiscar.php">Hist&oacute;rico</a></li>
</ul>
</li>

<li class="item5">
<a href="#">Despren. de Pago</a>
<ul class="submenus">
<li class="subitem1"><a target="principal" href="fun_frm_desp.php">Consultas</a></li>
<li class="subitem1"><a target="principal" href="fun_banco.php">Cuenta Bancaria</a></li>
<li class="subitem1"><a target="principal" href="<?echo $enlacePagos?>">Cesantias</a></li>
</ul>
</li>

<li class="item5">
<a href="#">Cert. Ingresos y Ret.</a>
<ul class="submenus">
<li class="subitem1"><a target="principal" href="<?echo $enlaceCertificadosIngRet?>">Certificados</a></li>
</ul>
</li>

<li class="item5">
<a href="#">Novedades</a>
<ul class="submenus">
<li class="subitem1"><a target="principal" href="fun_novedades.php">Activas</a></li>
<li class="subitem1"><a target="principal" href="fun_hnovedades.php">Hist&oacute;rico</a></li>
</ul>
</li>

<li class="item5">
<a href="#">Formatos Solicitud</a>
<ul class="submenus">
<li class="subitem1"><a target="principal" href="fun_formato_regreso_vaca.php">Reingreso Vacaciones</a></li>
<li class="subitem1"><a target="principal" href="fun_formato_solicitud_tramite.php">Solicitud y Tr&aacute;mite</a></li>
</ul>
</li>

<li class="item5"><a href="#">Inventario</a>
<ul class="submenus">
<li class="subitem1"><a target="principal" href="<?php echo $enlaceInventarioDocente ;?>">Inventario Docente</a></li>
</ul></li>


<li class="item5">
<a href="#">Clave</a>
<ul class="submenus">
<li class="subitem1"><a target="principal" href="<?echo $enlaceCambioPassword?>">Cambiar mi clave</a></li>
</ul>
</li>

<li class=""><a target="_top" href="../conexion/salir.php"><font color="red">Cerrar Sesi&oacute;n </font></a>
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
onload=SlideMenuInit;
</script>
</body>
</html>
