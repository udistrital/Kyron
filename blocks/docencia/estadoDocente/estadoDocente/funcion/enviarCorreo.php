<?
function enviar_correo($configuracion)
{

        $destinatario=$configuracion["correo"];
        $encabezado="Nuevo Usuario ".$configuracion["titulo"];

        $mensaje="Administrador:\n";
        $mensaje.=$_REQUEST['nombre']." ".$_REQUEST['apellido']."\n";
        $mensaje.="Correo Electronico:".$_REQUEST['correo']."\n";
        $mensaje.="Telefono:".$_REQUEST['telefono']."\n\n";
        $mensaje.="Ha solicitado acceso a ".$configuracion["titulo"]."\n\n";
        $mensaje.="Por favor visite la seccion de administracion para gestionar esta peticion.\n";
        $mensaje.="_____________________________________________________________________\n";
        $mensaje.="Por compatibilidad con los servidores de correo, en este mensaje se han omitido a\n";
        $mensaje.="proposito las tildes.";

        $correo= mail($destinatario, $encabezado,$mensaje) ;


        $destinatario=$_REQUEST['correo'];
        $encabezado="Solicitud de Confirmacion ".$configuracion["titulo"];


        $mensaje="Hemos recibido una solicitud para acceder al portal web\n";
        $mensaje.=$configuracion["titulo"];
        $mensaje.="en donde se referencia esta direccion de correo electronico.\n\n";
        $mensaje.="Si efectivamente desea inscribirse a nuestra comunidad por favor seleccione el siguiente enlace:\n";
        $mensaje="En caso contrario por favor omita el contenido del presente mensaje.";
        $mensaje.="_____________________________________________________________________\n";
        $mensaje.="Por compatibilidad con los servidores de correo en este mensaje se han omitido a\n";
        $mensaje.="proposito las tildes.";
        $mensaje.="_____________________________________________________________________\n";
        $mensaje.="Si tiene inquietudes por favor envie un correo a: ".$configuracion["correo"]."\n";

        $correo= mail($destinatario, $encabezado,$mensaje) ;


}

?>