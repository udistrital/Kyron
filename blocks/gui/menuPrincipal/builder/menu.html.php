<?php 
/*
 *  Sintaxis recomendada para las plantillas PHP
 */ 
?>

<div class="demo-container">
		<div class="black">
			<ul id="mega-menu-1" class="mega-menu">
	<?php foreach ( $this->atributos['enlaces']  as $nombrePagina => $columnas ): ?>	
		<?php
			//Si el tipo es menú, se llama el título del menú y el enlace del menú.
			$tituloMenu = array_keys($columnas['columna']['menu'])[0];
			$enlaceMenu = $columnas['columna']['menu'][$tituloMenu];
			//Cuando se tienen estos datos, se elimina este primer término.
			unset($columnas['columna']);
			//Si solo tenía un registro de la clase menú, no se seguirá dibujando, de lo contrario entra a dibujar los menús y submenús.
			if (count($columnas)>0): ?>	
				<?php $numColumnas = count($columnas); $tit=0; ?>	
				<li><a href="#"><?php echo $tituloMenu ?></a>
				<ul>
				<?php foreach ( $columnas as $col=>$item): ?>
					<?php foreach ( $item as $clase=>$paginas): ?>	
						<?php foreach ( $paginas as $nombrePagina=>$enlace): ?>
							<?php if ($clase=='submenu'):?>
								<?php if ($tit==0):?>
										<li><a href="#"><?php echo $nombrePagina ?></a>
											<ul>
											<?php $tit++;?>
								<?php elseif ($tit>0):?>
										</ul>
									</li>
									<li><a href="#"><?php echo $nombrePagina ?></a>
									<ul>
								<?php endif; ?>
				      		<?php else:?>
				      			<li><a href="<?php echo $enlace ?>"><?php echo $nombrePagina ?></a></li>
				      		<?php endif; ?>			      							
						<?php endforeach; ?> 
							
					<?php endforeach; ?> 	
						<?php if ($tit>0):?>
								<?php $tit=0;?>
									</ul>
									</li>
							<?php endif; ?>
				<?php endforeach; ?> 
				</ul>
		
		<?php else: ?>
			<li><a href='<?php echo $enlaceMenu ?>'><?php echo $tituloMenu ?></a></li>
		<?php endif; ?>
	<?php endforeach; ?>
				</li>
			</ul>	
	</div>
</div>


