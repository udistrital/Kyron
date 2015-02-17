<?
/***************************************************************************
 *   PHP Application Framework Version 10                                  *
 *   Copyright (c) 2003 - 2009                                             *
 *   Teleinformatics Technology Group de Colombia                          *
 *   ttg@ttg.com.co                                                        *
 *                                                                         *
****************************************************************************/

if(!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

if(isset($certificado)&&$certificado=="BloqueEjemploAjax") {

    include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
    $cripto=new encriptar();


    $tab=1;
    //Rescatar los valores temporales

    if(isset($configuracion["id_sesion"])) {

        $valorCodificado="action=registro_participante";
        $valorCodificado.="&opcion=confirmarEditar";
        $valorCodificado.="&registro=".$_REQUEST["registro"];

        $valorCodificado=$cripto->codificar($valorCodificado, $configuracion);

        $this->cadena_sql=$this->sql->cadena_sql($configuracion,"rescatarTemp");
        $this->registro=$this->funcion->ejecutarSQL($configuracion,$this->cadena_sql, "busqueda",$configuracion["db_principal"]);

        $totalRegistros=$this->funcion->totalRegistros($configuracion,$configuracion["db_principal"]);

        if($totalRegistros>0) {

            for($i=0;$i<$totalRegistros;$i++) {

                $variable[$this->registro[$i]["campo"]]=$this->registro[$i]["valor"];

            }
        //                        echo 'case "'.$this->registro[$i]["campo"].'":<br>';
        //                        echo " \$variable[\"".$this->registro[$i]["campo"]."\"]=\$this->registro[\$i][\"campo\"];<br>break;<br>";

        }


        //------------------Division General-------------------------
        $atributos["id"]="";

        //Formulario para nuevos registros de usuario
        $atributos["tipoFormulario"]="multipart/form-data";
        $atributos["metodo"]="POST";
        $atributos["nombreFormulario"]=$certificado;
        echo $this->miFormulario->marcoFormulario("inicio",$atributos);



        //-----------------Inicio de Conjunto de Controles----------------------------------------

        $atributos["leyenda"]=$this->lenguaje["marcoDatosGenerales"];
        echo $this->miFormulario->marcoAGrupacion("inicio",$atributos);

                //-------------Control cuadroTexto-----------------------

        $esteCampo="nombre";
        $atributos["tamanno"]="";
        $atributos["estilo"]="";
        $atributos["etiqueta"]=$this->lenguaje[$esteCampo];
        $atributos["texto"]=$variable[$esteCampo];
        echo $this->miFormulario->campoTexto($configuracion,$atributos);

        //-------------Control cuadroTexto-----------------------

        $esteCampo="apellido";
        $atributos["tamanno"]="";
        $atributos["estilo"]="";
        $atributos["etiqueta"]=$this->lenguaje[$esteCampo];
        $atributos["texto"]=$variable[$esteCampo];
        echo $this->miFormulario->campoTexto($configuracion,$atributos);

        //-------------Control cuadroTexto-----------------------

        $esteCampo="identificacion";
        $atributos["tamanno"]="";
        $atributos["estilo"]="";
        $atributos["etiqueta"]=$this->lenguaje[$esteCampo];
        $atributos["texto"]=$variable[$esteCampo];
        echo $this->miFormulario->campoTexto($configuracion,$atributos);

        //-------------Control cuadroTexto-----------------------

        $esteCampo="telefono";
        $atributos["tamanno"]="";
        $atributos["estilo"]="";
        $atributos["etiqueta"]=$this->lenguaje[$esteCampo];
        $atributos["texto"]=$variable[$esteCampo];
        echo $this->miFormulario->campoTexto($configuracion,$atributos);


        //Fin de Conjunto de Controles
        echo $this->miFormulario->marcoAGrupacion("fin",$atributos);

        //------------------Division para los botones-------------------------
        $atributos["id"]="botones";
        $atributos["estilo"]="marcoBotones";
        echo $this->miFormulario->division("inicio",$atributos);

        //-------------Control Boton-----------------------
        $atributos["verificar"]="";
        $atributos["verificarFormulario"]="1";
        $atributos["tipo"]="boton";
        $atributos["id"]="botonAceptar";
        $atributos["estilo"]="";
        $atributos["tabIndex"]=$tab++;
        $atributos["valor"]=$this->lenguaje["botonAceptar"];
        echo $this->miFormulario->campoBoton($configuracion,$atributos);
        //-------------Fin Control Boton----------------------

        //-------------Control Boton-----------------------
        $atributos["verificar"]="";
        $atributos["tipo"]="boton";
        $atributos["id"]="botonCancelar";
        $atributos["tabIndex"]=$tab++;
        $atributos["valor"]=$this->lenguaje["botonCancelar"];
        echo $this->miFormulario->campoBoton($configuracion,$atributos);
        //-------------Fin Control Boton----------------------

        //------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin",$atributos);



        //-------------Control cuadroTexto con campos ocultos-----------------------
        $atributos["id"]="formulario";
        $atributos["tipo"]="hidden";
        $atributos["etiqueta"]="";
        $atributos["valor"]=$valorCodificado;
        echo $this->miFormulario->campoCuadroTexto($configuracion,$atributos);


        //-------------------Fin Division-------------------------------
        echo $this->miFormulario->marcoFormulario("fin",$atributos);

    }else {
    //Mensaje de error
        echo "OOPSSSS!!!. Imposible procesar el formulario";
    }

}
?>