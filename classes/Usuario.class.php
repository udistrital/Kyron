<?
if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

class Usuario {

    private $id;
    private $tipoDoc;
    private $nombre;
    private $nombres;
    private $apellidos;
    private $genero;
    private $fechaNacimiento;
    private $dependencia;
    private $estadoCivil;
    private $numDocumento;    
    /**
     * Arreglo que almacena los perfiles a los que pertenece un usuario
     * Tales perfiles están relacionados con el conjunto de servicios
     * a lso que tiene acceso el usuario.
     * @var int
     */
    private $tipo;
    
    private $servicios;

    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getTipoDoc() {
        return $this->tipoDoc;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getGenero() {
        return $this->genero;
    }

    function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    function getDependencia() {
        return $this->dependencia;
    }
    
    function getEstadoCivil() {
        return $this->estadoCivil;
    }

    function getNumDocumento() {
        return $this->numDocumento;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipoDoc($tipoDoc) {
        $this->fecha = $tipoDoc;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setGenero($genero) {
        $this->genero = $genero;
    }

    function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
    }
    
    function setDependencia($dependencia) {
        $this->dependencia = $dependencia;
    }

    function setEstadoCivil($estadoCivil) {
        $this->estadoCivil = $estadoCivil;
    }

    function setNumDocumento($numDocumento) {
        $this->numDocumento = $numDocumento;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }
}
?>