<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

//El tiempo que se utiliza para agregar al nombre del campo se declara en ready.php


/**
 * Este script está incluido en el método html de la clase Frontera.class.php.
 *
 * La ruta absoluta del bloque está definida en $this->ruta
 */
$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

$nombreFormulario = sha1($esteBloque ['nombre'].$_REQUEST['tiempo']);

$valorCodificado = "action=" . $esteBloque ["nombre"];
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado .= "&tiempo=" . $_REQUEST ['tiempo'];
$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
$directorioImagenes = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" )."/imagenes";

$tab = 1;

// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = $nombreFormulario;
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario ( "inicio", $atributos );

?>
<table cellpadding="0" border="0" cellspacing="0" align='center'>
  <tr>
    <td><img alt=" " src="<?php echo $directorioImagenes;?>/kyron_0_0.png" style="width: 768px;  height: 214px; border-width: 0px;"></td>
    <td><img alt=" " src="<?php echo $directorioImagenes;?>/kyron_0_1.png" style="width: 399px;  height: 214px; border-width: 0px;"></td>
    <td><img alt=" " src="<?php echo $directorioImagenes;?>/kyron_0_2.png" style="width: 113px;  height: 214px; border-width: 0px;"></td>
</tr>

  <tr>
    <td><img alt=" " src="<?php echo $directorioImagenes;?>/kyron_1_0.png" style="width: 768px;  height: 140px; border-width: 0px;"></td>
    <td style="background-image: url(<?php echo $directorioImagenes;?>/kyron_1_1.png);width: 399px; height: 100px; border-width: 0px;">
        
        <?php        

        
        $esteCampo = sha1('usuario'.$_REQUEST['tiempo']);
        $atributos ["id"] = $esteCampo;
        $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
        $atributos ["tabIndex"] = $tab ++;
        $atributos ["obligatorio"] = true;
        $atributos ["tamanno"] = "30";
        $atributos ["place"] = "Digite su usuario";
        $atributos ["tipo"] = "";
        $atributos ["estilo"] = "jqueryui";
        $atributos ["validar"] = "required";

        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset ( $atributos );

        // -------------Control cuadroTexto-----------------------
        $esteCampo = sha1('clave'.$_REQUEST['tiempo']);
        $atributos ["id"] = $esteCampo;
        $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
        $atributos ["tabIndex"] = $tab ++;
        $atributos ["obligatorio"] = true;
        $atributos ["tamanno"] = "30";
        $atributos ["place"] = "Digite su clave";
        $atributos ["tipo"] = "password";
        $atributos ["estilo"] = "jqueryui";
        $atributos ["validar"] = "required";

        // $atributos["valor"]="sistemasoas";

        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset ( $atributos );



        // ------------------Division para los botones-------------------------
        $atributos ["id"] = "botones";
        $atributos ["estilo"] = "marcoBotones";
        echo $this->miFormulario->division ( "inicio", $atributos );

        // -------------Control Boton-----------------------
        $esteCampo = "botonAceptar";
        $atributos ["id"] = $esteCampo;
        $atributos ["tabIndex"] = $tab ++;
        $atributos ["tipo"] = "boton";
        $atributos ["estilo"] = "";
        $atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
        $atributos ["tipoSubmit"] = "jquery"; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
        $atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ["nombreFormulario"] = $nombreFormulario;
        echo $this->miFormulario->campoBoton ( $atributos );
        unset ( $atributos );
        // -------------Fin Control Boton----------------------

        // ------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division ( "fin" );

        // -------------Control cuadroTexto con campos ocultos-----------------------
        // Para pasar variables entre formularios o enviar datos para validar sesiones
        $atributos ["id"] = "formSaraData"; // No cambiar este nombre
        $atributos ["tipo"] = "hidden";
        $atributos ["obligatorio"] = false;
        $atributos ["etiqueta"] = "";
        $atributos ["valor"] = $valorCodificado;
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset ( $atributos );
        
        ?>
    </td>
    <td><img alt=" " src="<?php echo $directorioImagenes;?>/kyron_1_2.png" style="width: 113px;  height: 140px; border-width: 0px;"></td>
</tr>

  <tr>
    <td><img alt=" " src="<?php echo $directorioImagenes;?>/kyron_2_0.png" style="width: 768px;  height: 118px; border-width: 0px;"></td>
    <td><a href="#"><img alt=" " src="<?php echo $directorioImagenes;?>/kyron_2_1.png"  style="width: 399px; height: 118px; border-width: 0px;"></a></td>
    <td><img alt=" " src="<?php echo $directorioImagenes;?>/kyron_2_2.png" style="width: 113px;  height: 118px; border-width: 0px;"></td>
</tr>

  <tr>
    <td><img alt=" " src="<?php echo $directorioImagenes;?>/kyron_3_0.png" style="width: 768px;  height: 215px; border-width: 0px;"></td>
    <td style="background-image: url(<?php echo $directorioImagenes;?>/kyron_3_1.png);width: 399px; height: 215px; border-width: 0px;">
        <?php
        
        $atributos["id"]="divpie";
        $atributos["estilo"]="";
        echo $this->miFormulario->division("inicio",$atributos);
        //------------------Division-------------------------
        $atributos["id"]="sabio";
        $atributos["estilo"]="";
        echo $this->miFormulario->division("inicio",$atributos);
        unset($atributos);
        //------------Fin de la División -----------------------
        echo $this->miFormulario->division("fin");

        //------------------Division-------------------------
        $atributos["id"]="escudo";
        $atributos["estilo"]="centrar";
        echo $this->miFormulario->division("inicio",$atributos);
        unset($atributos);
        
        ?>
        <img src="<?php echo $directorio;?>/css/images/escudo-blanco.png" width="100px" >    
        <?php
        
        //------------Fin de la División -----------------------
        echo $this->miFormulario->division("fin");

        //------------------Division-------------------------
        $atributos["id"]="pie";
        $atributos["estilo"]="";
        echo $this->miFormulario->division("inicio",$atributos);
        unset($atributos);

        //-----------------Texto-----------------------------
        $esteCampo='mensajePie';
        $atributos["estilo"]="";
        $atributos['texto']=$this->lenguaje->getCadena($esteCampo);
        echo $this->miFormulario->campoTexto($atributos);
        unset($atributos);


        //------------Fin de la División -----------------------
        echo $this->miFormulario->division("fin");

        echo $this->miFormulario->division ( "fin" );

        echo $this->miFormulario->division ( "fin" );
        
        ?>
    </td>
    <td><img alt=" " src="<?php echo $directorioImagenes;?>/kyron_3_2.png" style="width: 113px;  height: 215px; border-width: 0px;"></td>
</tr>

  <tr>
    <td><img alt=" " src="<?php echo $directorioImagenes;?>/kyron_4_0.png" style="width: 768px;  height: 273px; border-width: 0px;"></td>
    <td><img alt=" " src="<?php echo $directorioImagenes;?>/kyron_4_1.png" style="width: 399px;  height: 273px; border-width: 0px;"></td>
    <td><img alt=" " src="<?php echo $directorioImagenes;?>/kyron_4_2.png" style="width: 113px;  height: 273px; border-width: 0px;"></td>
</tr>

</table>    
<?php

// Fin del Formulario
echo $this->miFormulario->formulario ( "fin" );


 // Si existe algun tipo de error en el login aparece el siguiente mensaje

if (isset ( $_REQUEST ['error'] ) && $_REQUEST ['error'] == 'usuarioNoValido') {
	// ------------------Division para los botones-------------------------
	$atributos ["id"] = "error";
	$atributos ["estilo"] = "marcoBotones";
	echo $this->miFormulario->division ( "inicio", $atributos );
	
	// -------------Control texto-----------------------
	$esteCampo = "mensajeUsuarioError";
	$atributos ["tamanno"] = "";
	$atributos ["estilo"] = "errorLogin";
	$atributos ["etiqueta"] = "";
	$atributos ["mensaje"] = "Nombre de usuario o contraseña incorrectos";
	$atributos ["columnas"] = ""; // El control ocupa 47% del tamaño del formulario
	echo $this->miFormulario->campoMensaje ( $atributos );
	unset ( $atributos );
	
	// ------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division ( "fin" );
} else if (isset ( $_REQUEST ['error'] ) && $_REQUEST ['error'] == 'claveNoValida') {
	// ------------------Division para los botones-------------------------
	$atributos ["id"] = "error";
	$atributos ["estilo"] = "marcoBotones";
	echo $this->miFormulario->division ( "inicio", $atributos );
	
	// -------------Control texto-----------------------
	$esteCampo = "mensajeClaveError";
	$atributos ["tamanno"] = "";
	$atributos ["estilo"] = "errorLogin";
	$atributos ["etiqueta"] = "";
	$atributos ["mensaje"] = "Nombre de usuario o contraseña incorrectos";
	$atributos ["columnas"] = ""; // El control ocupa 47% del tamaño del formulario
	echo $this->miFormulario->campoMensaje ( $atributos );
	unset ( $atributos );
	
	// ------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division ( "fin" );
}
 
?>
 