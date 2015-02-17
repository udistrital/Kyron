<?
/***************************************************************************
 *   PHP Application Framework Version 10                                  *
 *   Copyright (c) 2003 - 2009                                             *
 *   Teleinformatics Technology Group de Colombia                          *
 *   ttg@ttg.com.co                                                        *
 *                                                                         *
****************************************************************************/

if(!isset($GLOBALS["autorizado"])){
	include("../index.php");
	exit;
}

if(isset($certificado)&&$certificado=="BloqueEjemploAjax"){

    include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
    include_once($configuracion["raiz_documento"].$configuracion["clases"]."/grillaBusqueda.class.php");
    include_once($configuracion["raiz_documento"].$configuracion["clases"]."/navegacion.class.php");
    $cripto=new encriptar();
    $grilla=new grillaBusqueda();

    

    $tab=1;

    //Rescatar los valores temporales

    if(isset($_REQUEST["opcion"])){

                $this->cadena_sql=$this->sql->cadena_sql($configuracion,"totalConductores");
                $this->registro=$this->funcion->ejecutarSQL($configuracion,$this->cadena_sql, "busqueda",$configuracion["db_principal"]);
                if($this->funcion->totalRegistros($configuracion,$configuracion["db_principal"])>0){

                        $atributosNavegacion["totalRegistros"]=$this->registro[0][0];

                        if($atributosNavegacion["totalRegistros"]!=0){

                                unset($this->registro);

                                if(!isset($_REQUEST["hoja"]))
                                {
                                    $atributosNavegacion["hojaActual"]=1;
                                }else{
                                    $atributosNavegacion["hojaActual"]=$_REQUEST["hoja"];
                                }

                                $this->cadena_sql=$this->sql->cadena_sql($configuracion,"rescatarConductores",$atributosNavegacion);
                                //echo $this->cadena_sql;

                                $this->registro=$this->funcion->ejecutarSQL($configuracion,$this->cadena_sql, "busqueda",$configuracion["db_principal"]);
                                $navegador=new navegacion();

                                if($this->funcion->totalRegistros($configuracion,$configuracion["db_principal"])>0){
                                    $atributos["titulo"][1]=$this->lenguaje['nombre'];
                                    $atributos["titulo"][2]=$this->lenguaje['apellido'];
                                    $atributos["titulo"][3]=$this->lenguaje['identificacion'];
                                    $atributos["titulo"][4]=$this->lenguaje['telefono'];
                                    $atributos["titulo"]["borrar"]=$this->lenguaje['borrar'];
                                    $atributos["titulo"]["ver"]=$this->lenguaje['ver'];

                                    $variable="pagina=conductorAdministrador";
                                    $variable.="&opcion=mostrar";
                                    $atributos["opcion"]["informacion"]=$variable;
                                    $atributos["opcion"]["borrar"]="conductor";
                                    $atributos["opcion"]["totalColumnas"]=count($this->registro[0])/2;

                                    $atributosNavegacion["enlace"]="pagina=".$_REQUEST["pagina"];
                                    $atributosNavegacion["enlace"].="&opcion=".$_REQUEST["opcion"];


                                    $navegador->menu_navegacion($configuracion, $atributosNavegacion);

                                    $grilla->grillaResultado($configuracion,$this->registro,$atributos);


                                }else{

                                    $atributos["titulo"]=$this->lenguaje['tituloSinRegistro'];
                                    $atributos["cuerpo"]=$this->lenguaje['cuerpoSinRegistro'];

                                    $grilla->grillaVacia($configuracion, $atributos);
                                }
                        }else{

                            $atributos["titulo"]=$this->lenguaje['tituloSinRegistro'];
                            $atributos["cuerpo"]=$this->lenguaje['cuerpoSinRegistro'];
                            $grilla->grillaVacia($configuracion, $atributos);
                        }

                }else{

                    echo "OOPSSSS!!!. Imposible mostrar los datos";
                }
                
                
    }else{
        //Mensaje de error
        echo "OOPSSSS!!!. Imposible procesar el formulario";
    }

}
?>