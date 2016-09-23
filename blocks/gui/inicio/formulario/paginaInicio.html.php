		<header>
			<div id="tabzilla">
				<a href="http://www.udistrital.edu.co">Udistrital</a>
			</div>
		</header>
		<div style="opacity: 1;" class="fade-in-forward" id="stage">
			<div class="sign-in">
				<div id="marco-principal" class="card">
					<header>
						<h1 id="fxa-signin-header">
							<span class="service">
								<div class="button-row">
									<?php
										$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
										$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
										$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
										//Enlace 1 si el menú es cargado en su opción logout
										$valorCodificado = "action=inicio";//Es el nombre del directorio del bloque
										$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
										$valorCodificado .= "&bloque=inicio";
										$valorCodificado .= "&bloqueGrupo=gui";
										$valorCodificado .= "&opcion=login";
										$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
									?>
									<button id="submit-btn" class="disabled" onclick="window.location.href='<?php echo $directorio.'='.$valorCodificado?>'">
										Ingresar
									</button>
								</div>
							</span>
						</h1>
					</header>
					<h1 class="tlt">KYRON - Sistema de Gestión de Información Docente</h1>
					<img style="width:100%" src="<?php echo $this -> miConfigurador->getVariableConfiguracion("rutaUrlBloque").'css/banner_kyron.png'?>" alt="Kyron">
				</div>
			</div>
		</div>
		<!--[if !(IE) | (gte IE 10)]><!-->
		<noscript>
			Cóndor necesita Javascript.
		</noscript>
		<!--<![endif]-->