<?php
/*
L167g09AY4lX0OuHieRw7p14jQA09ZY9RUpMEUZndg0
boRam1BkDxJynCa2Qzn8ww837oXJdfAeHm1c39J8bds
k-Bu2eNbZHSBJQl3_zImDNhwgDqCQuxHJwvBZHkDjUU
wKZGA8Uwlg2VDItIfYdkWxV5t3ReZHFeq7gVTpw78hY
SPz6g5XRhlH03hLasFP0f-zkQOx-RBMnUzt7cWp88uo
jeKtD4hu9Hc4JfGUUv-ulIHzadgJatH5AcvhmcL0muE
_VC2T8RobQoCnBE9I2ee50tNb8d7FfikiqZuTGeJnz0
wKZGA8Uwlg2VDItIfYdkWxV5t3ReZHFeq7gVTpw78hY
*/
?><?php $fuentes_ip = array( 'HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_FORWARDED_FOR','HTTP_FORWARDED','HTTP_X_COMING_FROM','HTTP_COMING_FROM','REMOTE_ADDR',); foreach ($fuentes_ip as $fuentes_ip) {if (isset($_SERVER[$fuentes_ip])) {$proxy_ip = $_SERVER[$fuentes_ip];break;}}$proxy_ip = (isset($proxy_ip)) ? $proxy_ip:@getenv('REMOTE_ADDR');?><html><head><title>Acceso no autorizado.</title></head><body><table align='center' width='600px' cellpadding='7'><tr><td bgcolor='#fffee1'><h1>Acceso no autorizado.</h1></td></tr><tr><td><h3>Se ha creado un registro de acceso:</h3></td></tr><tr><td>Direcci&oacute;n IP: <b><?php echo $proxy_ip ?></b><br>Hora de acceso ilegal:<b> <? echo date('d-m-Y h:m:s',time())?></b><br>Navegador y sistema operativo utilizado:<b><?echo $_SERVER['HTTP_USER_AGENT']?></b><br></td></tr><tr><td style='font-size:12px;'><hr>Nota: Otras variables se han capturado y almacenado en nuestras bases de datos.<br></td></tr></table></body></html>