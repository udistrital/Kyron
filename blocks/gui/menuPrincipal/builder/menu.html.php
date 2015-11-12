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
			$tituloMenu = array_keys($columnas['columna']['menu_enlace_interno'])[0];
			$enlaceMenu = $columnas['columna']['menu_enlace_interno'][$tituloMenu];
			unset($columnas['columna']);
			if (count($columnas)>0): ?>	
				<?php $numColumnas = count($columnas); $tit=0; ?>	
				<li><a href="#"><?php echo $tituloMenu ?></a>
				<ul>
				<?php foreach ( $columnas as $col=>$item): ?>
					<?php foreach ( $item as $titulo=>$paginas): ?>	
						<?php foreach ( $paginas as $nombrePagina=>$enlace): ?>	
							<?php if ($titulo=='submenu_enlace_interno'):?>
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


