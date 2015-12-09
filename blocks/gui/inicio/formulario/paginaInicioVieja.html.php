<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

// El tiempo que se utiliza para agregar al nombre del campo se declara en ready.php

/**
 * Este script está incluido en el método html de la clase Frontera.class.php.
 *
 * La ruta absoluta del bloque está definida en $this->ruta
 */
$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

$tab = 1;

$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
$directorioImagenes = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/imagenes";

?>
<header>
	<div id="fondo_base"></div>
	<div id="fondo_menu"></div>
	<!--
                        <ul id="menu">
                            <li>
                                <a href="#">Administrativa</a>
                                <ul>
                                    <li><a href="#">Docencia</a></li>
                                    <li><a href="#">Recursos Humanos</a></li>                                         
                                </ul>
                            </li>                            
			</ul>
                        -->
	<div id="logo_kyron">
		<div id="logo_k">
			<img src="<?php echo $directorioImagenes?>/kyron.png" />
		</div>
	</div>
</header>
<section>
	<article id="fondo_login">
		<h1 id="fxa-signin-header">
		<span class="service">
			<div class="button-row">
					<?php
					$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
					$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
					$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
					// Enlace 1 si el menú es cargado en su opción logout
					$valorCodificado = "action=inicio"; // Es el nombre del directorio del bloque
					$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
					$valorCodificado .= "&bloque=inicio";
					$valorCodificado .= "&bloqueGrupo=gui";
					$valorCodificado .= "&opcion=login";
					$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
					?>
					<button id="submit-btn" class="disabled"
					onclick="window.location.href='<?php echo $directorio.'='.$valorCodificado?>'">
					Ingresar</button>

			</div>
		</span>
		</h1>
	</article>
	<section id="logo_universidad">
		<article id="contenedor_logo_u">
			<div id="logo_u">
				<img src="<?php echo $directorioImagenes?>/UD_logo.png" />
			</div>
		</article>
		<article id="datos">
			<p>Universidad Distrital Francisco José de Caldas</p>
		</article>
	</section>
</section>
<section>
	<div id="fondo_texto">
		<div id="texto">
			<h1>SISTEMA DE INFORMACIÓN</h1>
			<h3>DE GESTIÓN DOCENTE</h3>
		</div>
	</div>
</section>
<footer>
	<div id="datos_contacto_pie">
		<p>Todos los derechos reservados.</p>
		<p>Carrera 8 N. 40-78 Piso 1 / PBX 3238400 - 3239300</p>
		<a href="">computo@udistrital.edu.co</a>
	</div>
</footer>