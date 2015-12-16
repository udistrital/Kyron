<?php foreach($items as $item):?>
<?php if(count($item['resultados'])!=0):?>
<br />
<center>
	<table width='100%'>
		<tr>
			<th colspan='4' style='font-size: 11px; text-align: left'>
				<?php echo $item['tituloTipo'].': '.$item['titulo'];?>			
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
			<td>
				<?php echo $item['titulo1'] .' '. $resultado[$item['llavevalor1']];?>
				<br/>
				<?php echo $resultado[$item['llavevalor2']];?>
			</td>
			<td>
				<?php echo $resultado['fecha_acta'];?>
			</td>
			<td>
				<?php echo $resultado['numero_acta'];?>
			</td>
			<td>
				<?php echo $resultado['puntaje']; $puntajeTotal+=$resultado['puntaje'];?>
			</td>
		</tr>
		<?php endforeach;?>
		<tr>
			<th colspan='3f' style='font-size: 10px; text-align: right'>Subtotal</th>
			<td width='50px'><?php echo $puntajeTotal;?></td>
			<?php
				if($item['tipo']=='1'){//Salarial
					$puntosSalariales+=$puntajeTotal;
				} elseif($item['tipo']=='2'){//Bonficación				
					$puntosBonificacion+=$puntajeTotal;
				}	
			?>
		</tr>
	</table>
</center>
<br />
<?php endif;?>
<?php endforeach;?>