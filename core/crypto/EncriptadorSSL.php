<?php


class EncriptadorSSL{
	
	
	var $llave;
	var $llavePrivada;
	var $llavePublica;
	
	
	function generarLlaves($bits=1024, $tipo=OPENSSL_KEYTYPE_RSA){
		
		$this->llave = openssl_pkey_new(array(
				'private_key_bits' => $bits,
				'private_key_type' => $tipo
		));
		
		
		
	}
	
	function guardarLlave($ruta,$fraseSeguridad){
		openssl_pkey_export($this->llave,$this->llavePrivada, $fraseSeguridad);
		return openssl_pkey_export_to_file($this->llave, $ruta.'/llave.pem', $fraseSeguridad);
	}
	
	
	function guardarLlavePublica($ruta){
		
		// get the public key $keyDetails['key'] from the private key;
		$keyDetails = openssl_pkey_get_details($this->llave);
		file_put_contents($ruta.'/llavePublica.pem', $keyDetails['key']);
		return true;
		
	}
	
	
	
	function getLlavePrivada($clave){
		
		return openssl_pkey_get_private($this->llave,$clave);
		
	}
	
	function getLlavePrivadaArchivo($archivo,$clave){
	
		return openssl_pkey_get_private($archivo,$clave);
	
	}
	
	
	function codificarSSL(){
		
		
	}
	
	
	function decodificarSSL($dato){
		
		
		$resultado=openssl_private_decrypt($dato,$respuesta,$this->llavePrivada);
		if($resultado){
		return $respuesta;
		}else{
			return $resultado;
		}
		
	}
	
	function decodificarSSLConLlave($dato,$llave){
	
	
		$resultado=openssl_private_decrypt($dato,$respuesta,$llave);
		if($resultado){
			
			return $respuesta;
		}else{
			return $resultado;
		}
	
	}
	
	
	
}