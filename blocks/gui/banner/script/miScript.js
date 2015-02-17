
 $(function() {
 	
 	$("#ActualizarDatos").validationEngine({
		promptPosition : "centerRight",
		scroll : false
	});
 	
}); 



function hora(){
    
    var hora=fecha.getHours();
    var minutos=fecha.getMinutes();
    var segundos=fecha.getSeconds();
    if(hora<10){ hora='0'+hora;}
    if(minutos<10){minutos='0'+minutos; }
    if(segundos<10){ segundos='0'+segundos; }     
    var fech = "<b>Fecha: " + fecha.getFullYear() + "/" + (fecha.getMonth() + 1) + "/" + fecha.getDate() + " <br> Hora: " + hora +":"+minutos+":"+segundos + "</b>";
    document.getElementById('clockDiv').innerHTML=fech;
    fecha.setSeconds(fecha.getSeconds()+1);
    setTimeout("hora()",1000);
}