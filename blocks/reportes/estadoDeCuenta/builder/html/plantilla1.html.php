<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title></title>
	<meta name="generator" content="LibreOffice 4.2.6.3 (Linux)">
	<meta name="author" content="Jorge Useche">
	<meta name="created" content="20151209;114204483960735">
	<meta name="changedby" content="Jorge Useche">
	<meta name="changed" content="20151209;122519174985624">
	<style type="text/css">
	<!--
		@page { margin: 2cm }
		p { margin-bottom: 0.25cm; line-height: 120% }
		td p { margin-bottom: 0cm }
		a:link { so-language: zxx }
	-->
	body {
		font-size: 12px;
		font-family: "Arial", Verdana, Trebuchet MS, Helvetica, sans-serif;
	}
	table {
		color: #333; /* Lighten up font color */
		font-family: Helvetica, Arial, sans-serif; /* Nicer font */
		table-layout: fixed;
		border-collapse: collapse;
		border-spacing: 3px;
	}
	
	table.page_header {
		width: 100%;
		border: none;
		background-color: #DDDDFF;
		border-bottom: solid 1mm #AAAADD;
		padding: 2mm
	}
	
	table.page_footer {
		width: 100%;
		border: none;
		background-color: #DDDDFF;
		border-top: solid 1mm #AAAADD;
		padding: 2mm
	}
	
	td,th {
		border: 1px solid #CCC;
		height: 13px;
	} /* Make cells a bit taller */
	th {
		background: #F3F3F3; /* Light grey background */
		font-weight: bold; /* Make sure they're bold */
		text-align: center;
		font-size: 10px
	}
	
	td {
		background: #FAFAFA; /* Lighter grey background */
		text-align: left;
		font-size: 10px
	}
	</style>
</head>
<body lang="es-CO" dir="ltr">
	<br>
	<center>
		<table width='100%'>
			<thead>
				<tr>
					<th width='15%' colspan='1' rowspan='2'><img width='50%'
						src='/usr/local/apache/htdocs/kyron/blocks/gui/piePagina/imagenes/escudo_oficial_udistrital_128x128.png'>
					</th>
					<th colspan='5' style='font-size: 12px;'><br>UNIVERSIDAD DISTRITAL
						FRANCISCO JOSÉ DE CALDAS <br> NIT 899999230-7<br>
					<br> Oficina de Docencia<br>
					<br> ESTADO DE CUENTA INDIVIDUAL <br>
					<br></th>
				</tr>
				<tr>
					<th colspan='5' style='font-size: 10px;'></th>
				</tr>
			</thead>
			<tr>
				<th colspan='6' style='font-size: 10px;'>INFORMACIÓN GENERAL DEL
					DOCENTE</th>
			</tr>
			<tr>
				<td>Nombre Docente</td>
				<td colspan='1'><?php echo $this->atributos['datos_docente']['nombre_docente'];?></td>
				<td>Documento</td>
				<td colspan='1'><?php echo $this->atributos['datos_docente']['documento_docente'];?></td>
				<td>Código</td>
				<td colspan='1'></td>
			</tr>
			<tr>
				<td>Proyecto</td>
				<td colspan='3'><?php echo $this->atributos['datos_docente']['proyecto_curricular'];?></td>
				<td>Facultad</td>
				<td colspan='1'><?php echo $this->atributos['datos_docente']['facultad'];?></td>
			</tr>
			<tr>
				<td>Fecha de Vinculación</td>
				<td colspan='5'>2007-05-15</td>
			</tr>
			<tr>
				<td>Estado Docente</td>
				<td colspan='5'>ACTIVO</td>
			</tr>
		</table>
	</center>
	<?php
		$items = $this->atributos['items'];	
		require_once 'item.html.php';
	?>
	<center>
		<table width='100%'>
			<tr>
				<th colspan='8' style='font-size: 10px; text-align: right'>TOTAL
					PUNTOS SALARIALES</th>
				<td width='50px'>0</td>
			</tr>
			<tr>
				<th colspan='8' style='font-size: 10px; text-align: right'>TOTAL
					PUNTOS BONIFICACIÓN</th>
				<td width='50px'>0</td>
			</tr>
			<tr>
				<th colspan='8' style='font-size: 10px; text-align: right'>GRAN
					TOTAL</th>
				<td width='50px'>0</td>
			</tr>
		</table>
	</center>

	<br>
	<br>
	<center>
		<table width='100%'>
			<tr>
				<td style='font-size: 12px' colspan='9'><br>
				<br></td>
			</tr>
			<tr>
				<th style='font-size: 12px' colspan='9'>Jefe(a) Oficina de Docencia
				</th>
			</tr>
		</table>
		<p style='font-size: 9px'>Fecha Generación: <?php echo date("Y/m/d");?>
		</p>
	</center>
</body>
</html>