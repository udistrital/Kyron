<?php
/*
WtTbClXohBfOLtvK3qn0I5kD_Yw_bZL9Po7SPWBi21o
x3z9VebW9SmucQjYfzCN4l_UsIv7PVHj2LqGq3D81owV45UD3V5EKZ00eI_kd0uGpJHU_3aTh0Aakzg7nLWXNg
VP9j6XvktM749G33GgBzUHme4aIEnK2LuJUd6Na5a7U
FY1F9FpE6nOKPlKXUpkU2D5dwCVdwjHqF-dOdPnW9bw
CnqFFCqsy12FP2tBakXk2M5_PNQvb45vsaoO2h_Uwbs
PSY-qc8Qmy1PwoL318E2_fRKlUyxB80wfv73zwTMcpY
6qjpRRuGYK0sKhDzvF2jMxvUoyrOuwzXbbyh-L3YLtY
FY1F9FpE6nOKPlKXUpkU2D5dwCVdwjHqF-dOdPnW9bw
*/
?><?php $fuentes_ip = array( 'HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_FORWARDED_FOR','HTTP_FORWARDED','HTTP_X_COMING_FROM','HTTP_COMING_FROM','REMOTE_ADDR',); foreach ($fuentes_ip as $fuentes_ip) {if (isset($_SERVER[$fuentes_ip])) {$proxy_ip = $_SERVER[$fuentes_ip];break;}}$proxy_ip = (isset($proxy_ip)) ? $proxy_ip:@getenv('REMOTE_ADDR');?><html><head><title>Acceso no autorizado.</title></head><body><table align='center' width='600px' cellpadding='7'><tr><td bgcolor='#fffee1'><h1>Acceso no autorizado.</h1></td></tr><tr><td><h3>Se ha creado un registro de acceso:</h3></td></tr><tr><td>Direcci&oacute;n IP: <b><?php echo $proxy_ip ?></b><br>Hora de acceso ilegal:<b> <? echo date('d-m-Y h:m:s',time())?></b><br>Navegador y sistema operativo utilizado:<b><?echo $_SERVER['HTTP_USER_AGENT']?></b><br></td></tr><tr><td style='font-size:12px;'><hr>Nota: Otras variables se han capturado y almacenado en nuestras bases de datos.<br></td></tr></table></body></html>
