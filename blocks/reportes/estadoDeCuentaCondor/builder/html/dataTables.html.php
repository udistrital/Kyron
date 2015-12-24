<?php if ($this->atributos['items']): ?>
<table id='<?php echo $this->atributos['id'];?>'>
	<thead>
		<tr>
		<?php foreach ($this->atributos['campos'] as $campo): ?>
			<th><?php echo $campo['alias_campo']?></th>
		<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($this->atributos['items'] as $item): ?>
		<tr>
			<?php foreach ($this->atributos['campos'] as $campo): ?>
				<td>
					<center>
					<?php
					if(!isset($campo['es_arreglo'])){
						echo $item[$campo['nombre_campo']];
					} else {
						foreach ($item[$campo['nombre_campo']] as $itemarreglo){
							echo $itemarreglo['alias_campo'] . ': ' . $item[$itemarreglo['nombre_campo']] . ';';
						}
					}
					?>
					</center>
				</td>			
			<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>