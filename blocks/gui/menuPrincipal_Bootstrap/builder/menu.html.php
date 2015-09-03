<?php 
/*
 *  Sintaxis recomendada para las plantillas PHP
 */ 
?>
<nav class="navbar navbar-inverse" role="navigation">
	<ul class="nav navbar-nav">	 
	<?php foreach ( $this->atributos['enlaces']  as $nombrePagina => $columnas ): ?>	
		<?php if (is_array($columnas)): ?>	
			<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">	
			<?php echo $nombrePagina ?><span class="caret"></span></a>
				<?php $numColumnas = count($columnas);?>
				<ul class="dropdown-menu multi-column columns-<?php echo $numColumnas;?>">
					<div class="row">		
				<?php foreach ( $columnas as $col=>$item): ?>
					<div class="col-sm-<?php echo (12/$numColumnas);?>">
						<ul class="multi-column-dropdown">								
					<?php foreach ( $item as $titulo=>$paginas): ?>		
						<?php foreach ( $paginas as $nombrePagina=>$enlace): ?>								
							<?php if ($titulo=='tittle'):?>
				      			<li><a class="titulo" href='#'><?php echo $nombrePagina ?></a></li>
				      		<?php else:?>
				      		 	<li><a href='<?php echo $enlace ?>'><?php echo $nombrePagina ?></a></li>
				      		<?php endif; ?>			      							
						<?php endforeach; ?> 											
				<?php endforeach; ?> 	
						</ul>
					</div>					
			<?php endforeach; ?> 
					</div>
				</ul>	
			</li>
		<?php else: ?>
			<?php if ($nombrePagina=='Cerrar Sesión'):?>
				<?php $cerrar = 1; $linkCerrar = $columnas; $nombrePaginaCerrar = $nombrePagina; ?>
			<?php else: ?>
				<li class='linkMenu'><a href='<?php echo $columnas ?>'><?php echo $nombrePagina ?></a></li>
			<?php endif; ?>			
		<?php endif; ?>
	<?php endforeach; ?>	
	</ul>  		
	<?php if (isset($cerrar) && $cerrar == 1):?>
		<div class="container-fluid">    
      		<ul class="nav navbar-nav navbar-right">
        		<li><a href=<?php echo $linkCerrar ?>'><span class="glyphicon glyphicon-log-in"></span><?php echo $nombrePaginaCerrar ?></a></li>
      		</ul>
  		</div>	
  	<?php endif; ?>
</nav>

