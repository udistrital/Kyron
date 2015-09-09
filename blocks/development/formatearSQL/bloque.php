<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<form name="cadenaSql" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    
    <textarea name="sql" rows="12" cols="100"></textarea>
    <br>
    <input type="submit" value="Formatear" name="opcion" />
    <input type="submit" value="Desformatear" name="opcion" />
    <input type="reset" value="Borrar" name="Borrar" />
</form >
<?

if(!isset($_REQUEST['sql'])){echo 'Inserte cadena';exit;};

if($_REQUEST['opcion']=='Formatear'){
	$cadena= nl2br($_REQUEST['sql']);
	
	$linea=explode('<br />',$cadena);
	
	foreach ($linea as $key => $value) {
		echo '$cadenaSql';
		if($key!=0)
		{echo '.';}
		echo '=" '.$value.'";<br>';
	}
} else {
	$cadena= nl2br($_REQUEST['sql']);
	
	$linea=explode('<br />',$cadena);
	
	foreach ($linea as $key => $value) {
		$caracteres = array('$cadenaSql.="', "\n", "\r");
		$value = str_replace($caracteres,'',$value);
		echo '=" '.$value.'";<br>';
	}
}

?>
