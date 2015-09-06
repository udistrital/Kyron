<?
include_once ("../../core/crypto/Encriptador.class.php");

$miCodificador = Encriptador::singleton ();
echo $miCodificador->codificar ( "sistemas@oas" ) . "<br>";
echo $miCodificador->decodificar ( "5_dfsZmN2mOyEKYq4mrdujB8X110ZpW9JNXm-PiOXOY" ) . "<br>";
echo $miCodificador->decodificar ( "f0IwtDm7fwaW0fsXvj-YqWCyU1wLmxK5-NvTNWo0Rg4" ) . "<br>";
echo 'f0IwtDm7fwaW0fsXvj-YqWCyU1wLmxK5-NvTNWo0Rg4';

/*
 * $parametro=array("AwLSWHOR61DhZcTqkA==", "CwKk33OR61C9BaWCkKKdcbc=", "DwLlY3OR61B/gbFc", "EwLQVHOR61DfS8OI/96/gEL0l9XuWw==", "FwJ14HOR61DhdetkyM8whQ==", "GwKxk3OR61C90avH6Fq2nbol5g==", "HwI+DXOR61DMHj+OOwOsk7YAZg=="); foreach ($parametro as $valor){ echo $miCodificador->decodificar($valor)."<br>"; }
 */

?>
