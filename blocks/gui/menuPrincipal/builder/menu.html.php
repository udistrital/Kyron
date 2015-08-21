<?php 
/*
 *  Sintaxis recomendada para las plantillas PHP
 */ 
?>
<br /><br /><br /><br /><br /><br /><br /><br /><br />		
<nav class="navbar navbar-inverse" role="navigation">
<ul class="nav navbar-nav">	 
	<?php foreach ( $this->atributos['enlaces']  as $nombrePagina => $enlace ): ?>
		<?php if (is_array($enlace)): ?>				
			<?php if (!isset($enlace['columnas']) ):?>
				<li class="dropdown"><a class="dropdown-toggle"
				data-toggle="dropdown" href="#">
		     	<?php echo $nombrePagina ?><b class="caret"></b></a>				
				<ul class="dropdown-menu">
		      	<?php foreach ( $enlace  as $nombrePagina => $enlace ) : ?>
		      		<?php if ($nombrePagina=='title'):?>
		      			<li><a class="titulo" href='#'><?php echo $enlace ?></a></li>
		      		<?php else:?>
		      		 	<li><a href='<?php echo $enlace ?>'><?php echo $nombrePagina ?></a></li>
		      		<?php endif; ?>		
					
				<?php endforeach; ?>
		      </ul></li>
		    <?php elseif (isset($enlace['columnas']) ):?>
		    	<?php $columns = count($enlace['columnas']);?>
		    	<li class="dropdown"><a href="#" class="dropdown-toggle"
				data-toggle="dropdown">
		    	<?php echo $nombrePagina ?><span class="caret"></span></a>	
		    	<ul class="dropdown-menu multi-column columns-<?php echo $columns;?>">
				<div class="row">
		    	<?php foreach ( $enlace['columnas']  as $nombrePagina => $enlace ):?>		
		    		<div class="col-sm-<?php echo (12/$columns); ?>">
					<ul class="multi-column-dropdown">
		    		<?php foreach ( $enlace as $items => $links):?>	
		    					<?php if ($items=='title'):?>
		      						<li><a class="titulo" href='#'><?php echo $links ?></a></li>
		      					<?php else:?>
		      		 				<li><a href='<?php echo $enlace ?>'><?php echo $items ?></a></li>
		      					<?php endif; ?>							
								
					<?php endforeach; ?>
					</ul>
					</div>
				<?php endforeach; ?>
				</div>
				</ul></li>
		    <?php endif; ?>		    
		<?php else: ?>
			<li class='linkMenu'><a href='<?php echo $enlace ?>'><?php echo $nombrePagina ?></a></li>
		<?php endif; ?>
	<?php endforeach; ?>
  </ul>
</nav>
<br />