<?php
$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
$this->idioma ['noDefinido'] = 'No definido';
$this->idioma[$esteBloque ['nombre']] = "";

///************ SECCIÓN DE NOMBRES DE TABS *****************//
$this->idioma["tabConsultar"] = "Estado de Cuenta Individual";
$this->idioma["tabIngresar"] = "Ingresar Estado de Cuenta Individual";
//////////////////////////////////////////////////////////////

//************ MENSAJES *********
$this->idioma["mensajeActualizar"] =  "Actualización Exitosa </br> Han sido actualizados los datos de Estado de Cuenta Individual <br>";
$this->idioma["mensajeRegistro"] =  "Registro Exitoso.<br> Se ha realizado la migración masiva.<br>" ;
$this->idioma["mensajeError"] =  "Error al tratar de realizar la migración masiva.";
$this->idioma["mensajeNoRegistros"] =  "No Se Encontraron  </br> Registros de Estado de Cuenta Individual Para los Criterios Ingresados";
$this->idioma["mensajeNoActualizo"] =  "Error al tratar de actualizar </br>el registro de Estado de Cuenta Individual Para el Docente </br>";
/////////////////////////////////

//* SECCIÓN ELEMENTOS QUE SU NOMBRE POSIBLEMENTE VARIA DENTRO DEL FORMULARIO *//
$this->idioma["nombre"] = "Nombre de la Estado de Cuenta Individual";
$this->idioma["contexto"] = "Contexto de la Estado de Cuenta Individual";
$this->idioma["identificadorColeccion"] = "ISSN";
$this->idioma["categoria0"] = "Categorías";
$this->idioma["categoria1"] = "Tipo de Indexación";
$this->idioma["numero"] = "Número de Estado de Cuenta Individual";
$this->idioma["marcoConsultaGeneral"] = "Consulta Cartas al Editor Registradas";
$this->idioma["marcoModificarRegistro"] = "Modificar Información de Cartas al Editor";

$this->idioma["nombreTitulo"] = "Nombre de Estado de Cuenta Individual Públicada.";
$this->idioma["contextoTitulo"] = "Contexto de la Estado de Cuenta Individual.";
$this->idioma["identificadorColeccionTitulo"] = "International Standard Serial Number, Número Internacional Normalizado de Publicaciones Seriado.";
$this->idioma["numeroTitulo"] = "Número de Publicación en Estado de Cuenta Individual.";
$this->idioma["paginasTitulo"] = "Páginas de la Publicación en Estado de Cuenta Individual.";
$this->idioma["annoTitulo"] = "Año de Publicación de la Estado de Cuenta Individual.";
$this->idioma["volumenTitulo"] = "Volumen de la Estado de Cuenta Individual.";
$this->idioma["tituloArticuloTitulo"] = "Título del Artículo Indexado";
$this->idioma["numeroAutoresTitulo"] = "Número de Autores del Artículo.";
$this->idioma["docenteRegistrarTitulo"] = "Identificación o Nombre del Docente.";
$this->idioma["docenteTitulo"] = "Identificación o Nombre del Docente.";
$this->idioma["numeroAutoresUniversidadTitulo"] = "Número de Autores en la Publicacón Pertenecientes a la Universidad Distrital.";
$this->idioma["fechaPublicacionTitulo"] = "Fecha de Publicación del Artículo.";
$this->idioma["numeroActaTitulo"] = "Ingrese el Número de Acta CIARP-UD.";
$this->idioma["fechaActaTitulo"] = "Seleccione la Fecha de Acta CIARP-UD.";
$this->idioma["numeroCasoActaTitulo"] = "Ingrese el Número de Caso de Acta.";
$this->idioma["puntajeTitulo"] = "Ingrese Puntaje.";
///////////////////////////////////////////////////////////////////

//***************** SECCIÓN BOTONES ******************//
$this->idioma["botonRegresar"] = "Regresar";
$this->idioma["botonConsultar"] = "Consultar";
$this->idioma["botonCargar"] = "Cargar Masivamente";
$this->idioma["botonGuardar"] = "Guardar";
$this->idioma["continuar"] = "Continuar";
$this->idioma["botonAceptar"] = "Aceptar";
$this->idioma["botonRegistrar"] = "Registrar";
$this->idioma["botonCancelar"] = "Cancelar";
$this->idioma["noDefinido"] = "No definido";
///////////////////////////////////////////////////////


// *** SECCIÓN DE ETIQUETAS QUE POSIBLEMENTE NO VARIAN *** //
$this->idioma["facultad"] = "Facultad";
$this->idioma["proyectoCurricular"] = "Proyecto Curricular";
$this->idioma["docente"] = "Identificación o nombre del docente:";
$this->idioma["docenteRegistrar"] = "Identificación o Nombre del Docente";
$this->idioma["pais"] = "País";
$this->idioma["anno"] = "Año";
$this->idioma["volumen"] = "Volumen";
$this->idioma["paginas"] = "Páginas";
$this->idioma["tituloArticulo"] = "Título del Artículo";
$this->idioma["numeroAutores"] = "Número de Autores";
$this->idioma["numeroAutoresUniversidad"] = "Número de Autores UD";
$this->idioma["fechaPublicacion"] = "Fecha de Publicación";
$this->idioma["numeroActa"] = "Número de Acta CIARP-UD";
$this->idioma["fechaActa"] = "Fecha de Acta CIARP-UD";
$this->idioma["numeroCasoActa"] = "Número de Caso de Acta";
$this->idioma["puntaje"] = "Puntaje	";
$this->idioma["normatividad"] = "Normatividad:";
$this->idioma["normatividadTitulo"] = "Ingrese la normatividad.";
////////////////////////////////////////////////////////////////

$this->idioma["normatividad"] = "Normatividad";
$this->idioma["normatividadTitulo"] = "Normatividad";

$this->idioma['cartasEditor'] = '';
$this->idioma['cartasEditorRegistrar'] = '';
$this->idioma['cartasEditorModificar'] = '';

$this->idioma['tituloFieldset'] = 'Descarga o sube el formato de carga masiva';
$this->idioma['botonDescargar'] = 'Descargar Formato carga Masiva';
$this->idioma['inputDocumento'] = 'Sube el formato diligenciado';
$this->idioma['inputDocumentoTitulo'] = 'Formato con algunos registros';


?>
