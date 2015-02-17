<?php

class sesionSql {

	private $prefijoTablas;

	var $cadena_sql;

	function __construct() {

	
	}

	function setPrefijoTablas($valor) {

		$this->prefijoTablas = $valor;
	
	}

	function getCadenaSql($indice, $parametro = "") {

		$this->clausula ( $indice, $parametro );
		if (isset ( $this->cadena_sql [$indice] )) {
			return $this->cadena_sql [$indice];
		}
		return false;
	
	}

	private function clausula($indice, $parametro) {

		switch ($indice) {
			
			case "seleccionarPagina" :
				$this->cadena_sql [$indice] = "SELECT ";
				$this->cadena_sql [$indice] .= "nivel ";
				$this->cadena_sql [$indice] .= "FROM ";
				$this->cadena_sql [$indice] .= $this->prefijoTablas . "pagina ";
				$this->cadena_sql [$indice] .= "WHERE ";
				$this->cadena_sql [$indice] .= "nombre='" . $parametro . "' ";
				$this->cadena_sql [$indice] .= "LIMIT 1";
				break;
			
			case "actualizarSesion" :
				
				$this->cadena_sql [$indice] = "UPDATE ";
				$this->cadena_sql [$indice] .= $this->prefijoTablas . "valor_sesion ";
				$this->cadena_sql [$indice] .= "SET ";
				$this->cadena_sql [$indice] .= "expiracion=" . $parametro ["expiracion"] . " ";
				$this->cadena_sql [$indice] .= "WHERE ";
				$this->cadena_sql [$indice] .= "sesionid='" . $parametro ["sesionId"] . "' ";
				break;
			
			case "borrarVariableSesion" :
				$this->cadena_sql [$indice] = "DELETE ";
				$this->cadena_sql [$indice] .= "FROM ";
				$this->cadena_sql [$indice] .= $this->prefijoTablas . "valor_sesion ";
				$this->cadena_sql [$indice] .= "WHERE ";
				$this->cadena_sql [$indice] .= "sesionid='" . $parametro ["sesionId"] . " ";
				$this->cadena_sql [$indice] .= "AND variable='" . $parametro ["dato"] . "'";
				break;
			
			case "borrarSesionesExpiradas" :
				$this->cadena_sql [$indice] = "DELETE ";
				$this->cadena_sql [$indice] .= "FROM ";
				$this->cadena_sql [$indice] .= $this->prefijoTablas . "valor_sesion ";
				$this->cadena_sql [$indice] .= "WHERE ";
				$this->cadena_sql [$indice] .= "expiracion<" . time ();
				break;
			
			case "borrarSesion" :
				$this->cadena_sql [$indice] = "DELETE ";
				$this->cadena_sql [$indice] .= "FROM ";
				$this->cadena_sql [$indice] .= $this->prefijoTablas . "valor_sesion ";
				$this->cadena_sql [$indice] .= "WHERE ";
				$this->cadena_sql [$indice] .= "sesionid='" . $parametro . "' ";
				break;
			
			case "buscarValorSesion" :
				$this->cadena_sql [$indice] = "SELECT ";
				$this->cadena_sql [$indice] .= "valor, ";
				$this->cadena_sql [$indice] .= "sesionid, ";
				$this->cadena_sql [$indice] .= "variable, ";
				$this->cadena_sql [$indice] .= "expiracion ";
				$this->cadena_sql [$indice] .= "FROM ";
				$this->cadena_sql [$indice] .= $this->prefijoTablas . "valor_sesion ";
				$this->cadena_sql [$indice] .= "WHERE ";
				$this->cadena_sql [$indice] .= "sesionid ='" . $parametro ["sesionId"] . "' ";
				$this->cadena_sql [$indice] .= "AND ";
				$this->cadena_sql [$indice] .= "variable='" . $parametro ["variable"] . "' ";
				break;
			
			case "actualizarValorSesion" :
				$this->cadena_sql [$indice] = "UPDATE ";
				$this->cadena_sql [$indice] .= $this->prefijoTablas . "valor_sesion ";
				$this->cadena_sql [$indice] .= "SET ";
				$this->cadena_sql [$indice] .= "valor='" . $parametro ["valor"] . "', ";
				$this->cadena_sql [$indice] .= "expiracion='" . $parametro ["expiracion"] . "' ";
				$this->cadena_sql [$indice] .= "WHERE ";
				$this->cadena_sql [$indice] .= "sesionid='" . $parametro ["sesionId"] . "' ";
				$this->cadena_sql [$indice] .= "AND variable='" . $parametro ["variable"] . "'";
				break;
			
			case "insertarValorSesion" :
				$this->cadena_sql [$indice] = "INSERT INTO ";
				$this->cadena_sql [$indice] .= $this->prefijoTablas . "valor_sesion ";
				$this->cadena_sql [$indice] .= "( ";
				$this->cadena_sql [$indice] .= " sesionid, ";
				$this->cadena_sql [$indice] .= " variable, ";
				$this->cadena_sql [$indice] .= " valor,";
				$this->cadena_sql [$indice] .= " expiracion";
				$this->cadena_sql [$indice] .= ") ";
				$this->cadena_sql [$indice] .= "VALUES ";
				$this->cadena_sql [$indice] .= "(";
				$this->cadena_sql [$indice] .= "'" . $parametro ["sesionId"] . "', ";
				$this->cadena_sql [$indice] .= "'" . $parametro ["variable"] . "', ";
				$this->cadena_sql [$indice] .= "'" . $parametro ["valor"] . "', ";
				$this->cadena_sql [$indice] .= "'" . $parametro ["expiracion"] . "' ";
				$this->cadena_sql [$indice] .= ")";
				break;
			
			case "verificarNivelUsuario" :
				$this->cadena_sql [$indice] = "SELECT ";
				$this->cadena_sql [$indice] .= "tipo ";
				$this->cadena_sql [$indice] .= "FROM ";
				$this->cadena_sql [$indice] .= $this->prefijoTablas . "usuario ";
				$this->cadena_sql [$indice] .= "WHERE ";
				$this->cadena_sql [$indice] .= "id_usuario='" . $parametro . "' ";
				break;
			
			case "verificarUsuarioCenso" :
				$this->cadena_sql [$indice] = 'SELECT ';
				$this->cadena_sql [$indice] .= 'identificacion as id_usuario, ';
				$this->cadena_sql [$indice] .= 'ideleccion, ';
				$this->cadena_sql [$indice] .= 'clave, ';
				$this->cadena_sql [$indice] .= 'nombre, ';
				$this->cadena_sql [$indice] .= 'idtipo ';
				$this->cadena_sql [$indice] .= 'FROM ';
				$this->cadena_sql [$indice] .= $this->prefijoTablas. 'censo ';
				$this->cadena_sql [$indice] .= "WHERE ";
				$this->cadena_sql [$indice] .= "identificacion = '" . trim ( $parametro) . "' ";
				
				break;
		}
	
	}

}

?>