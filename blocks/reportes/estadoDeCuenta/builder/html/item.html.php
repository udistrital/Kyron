<?php foreach($items as $item):?>
<?php if(count($item['resultados'])!=0):?>
<br />
<center>
	<table width='100%'>
		<tr>
			<th colspan='4' style='font-size: 11px; text-align: left'>
				<?php echo $item['tipo'].': '.$item['titulo'];?>			
			</th>
		</tr>
		<tr>
			<th>DESCRIPCIÓN</th>
			<th>FECHA</th>
			<th>SESIÓN</th>
			<th width='50px'>PUNTOS</th>
		</tr>
		<?php $index = 1; $puntajeTotal = 0;?>
		<?php foreach ($item['resultados'] as $resultado):?>
		<tr>
			<th>
				<?php echo $item['titulo1'] .' '. $resultado[$item['llavevalor1']];?>
				<br/>
				<?php echo $resultado[$item['llavevalor2']];?>
			</th>
			<th>
				<?php echo $resultado['fecha_acta'];?>
			</th>
			<th>
				<?php echo $resultado['numero_acta'];?>
			</th>
			<th>
				<?php echo $resultado['puntaje']; $puntajeTotal+=$resultado['puntaje'];?>
			</th>
		
		
		</tr>
		<?php endforeach;?>
		<tr>
			<th colspan='3f' style='font-size: 10px; text-align: right'>Subtotal</th>
			<td width='50px'><?php echo $puntajeTotal;?></td>
		</tr>
	</table>
</center>
<br />
<?php endif;?>
<?php endforeach;?>