<?php if ($this->atributos['items']): ?>
<table id='tablaTitulos'>
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
				<td><center><?php echo $item[$campo['nombre_campo']]; ?></center></td>
			<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>