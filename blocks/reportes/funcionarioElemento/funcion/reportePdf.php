<?
$ruta = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" );

$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/plugin/html2pfd/";

include ($ruta . "/plugin/html2pdf/html2pdf.class.php");

if (! isset ( $GLOBALS ["autorizado"]funcionarioElemento/index.php");
	exit ();
}
class RegistradorOrden {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miFuncion;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql, $funcion) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
		$this->miFuncion = $funcion;
	}
	function documento() {
		

		$placas = unserialize ( $_REQUEST ['placas'] );


		
		$contenidoPagina = "
<style type=\"text/css\">
    table { 
        color:#333; /* Lighten up font color */
        font-family:Helvetica, Arial, sans-serif; /* Nicer font */
		
        border-collapse:collapse; border-spacing: 3px; 
    }

    td, th { 
        border: 1px solid #CCC; 
        height: 13px;
    } /* Make cells a bit taller */

	col{
	width=50%;
	
	}			
				
    th {
        background: #F3F3F3; /* Light grey background */
        font-weight: bold; /* Make sure they're bold */
        text-align: center;
        font-size:10px
    }

    td {
        background: #FAFAFA; /* Lighter grey background */
        text-align: left;
        font-size:10px
    }
</style>				
				
				
<page backtop='10mm' backbottom='7mm' backleft='10mm' backright='10mm'>
	
        		
		    <table style='width:100%;'>";
		$contador = 1;
		$salidacontador = 1;
		$salida=count($placas);
		
		$directorio = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' );
		foreach($placas as $p) {
			if ($contador == 1) {
				
				$contenidoPagina .= "<tr>";
			}
			
			$contenidoPagina .= "<td style='width:33.31%;text-align=center;'>
								<barcode type='CODABAR' value='".$p."' style='width:30mm; height:6mm; font-size: 4mm'></barcode>".'   '."<img src='" . $directorio . "/css/images/escudo2.jpeg'  width='40' height='40'></td><br>";
			
			
			
			if ($contador == 3) {
			
				$contenidoPagina .= "</tr>";
				$contador=0;
				
			}
			$contador++;
			
			if ($salida == $salidacontador) {
					
				$contenidoPagina .= "</tr>";
				
			
			}
			
			$salidacontador++;
			
			
		}
		
		$contenidoPagina .= "</table>";
		
		$contenidoPagina .= "</page>";
		
// 		echo $contenidoPagina;exit;
		return $contenidoPagina;
	}
}

$miRegistrador = new RegistradorOrden ( $this->lenguaje, $this->sql, $this->funcion );

$textos = $miRegistrador->documento ();

ob_start ();
$html2pdf = new \HTML2PDF ( 'P', 'LETTER', 'es', true, 'UTF-8' );
$html2pdf->pdf->SetDisplayMode ( 'fullpage' );
$html2pdf->WriteHTML ( $textos );

$html2pdf->Output ( 'Placas' . '_' . date ( "Y-m-d" ) . '.pdf', 'D' );

?>





