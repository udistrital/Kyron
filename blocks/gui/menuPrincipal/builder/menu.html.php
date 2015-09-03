<?php 
/*
 *  Sintaxis recomendada para las plantillas PHP
 */ 
?>

<div class="demo-container">
		<div class="black">
			<ul id="mega-menu-1" class="mega-menu">
	<?php foreach ( $this->atributos['enlaces']  as $nombrePagina => $columnas ): ?>	
		<?php if (is_array($columnas)): ?>	
				<?php $numColumnas = count($columnas); $tit=0;?>	
				<li><a href="#"><?php echo $nombrePagina ?></a>
					<ul>
				<?php foreach ( $columnas as $col=>$item): ?>
					<?php foreach ( $item as $titulo=>$paginas): ?>	
						<?php foreach ( $paginas as $nombrePagina=>$enlace): ?>	
							<?php if ($titulo=='tittle'):?>
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
			<li><a href='<?php echo $columnas ?>'><?php echo $nombrePagina ?></a></li>
		<?php endif; ?>
	<?php endforeach; ?>
				</li>
			</ul>	
	</div>
</div>


