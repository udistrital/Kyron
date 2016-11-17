function confirmarEliminar(url){
	console.log(url);
	window.url = url;
	var r = confirm("¿Está seguro de eliminar el registro?");
	if (r == true) {
	    window.location = url;
	} else {
		
	}
}
