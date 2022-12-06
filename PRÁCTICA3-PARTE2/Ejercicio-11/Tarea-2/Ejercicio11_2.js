"use strict";
class Geolocalización {
    constructor (){
        navigator.geolocation.getCurrentPosition(this.getPosicion.bind(this));
        this.verErrores(this);
    }
    getPosicion(posicion){
        this.mensaje = "";
        this.longitud         = posicion.coords.longitude; 
        this.latitud          = posicion.coords.latitude;  
        this.precision        = posicion.coords.accuracy;      
    }
    
    verTodo(){
        $('ul').remove();
        var datos=''; 
        datos+="<h2>Datos</h2>";
        if(this.mensaje!=""){
            datos+='<p>'+ this.mensaje + '</p>'; 
        } 
        datos+='<ul><li>Longitud: '+this.longitud +' grados</li>'; 
        datos+='<li>Latitud: '+this.latitud +' grados</li>';
        datos+='<li>Precisión de la latitud y longitud: '+ this.precision +' metros</li></ul>';
        $('h2').each(function(index){
            if(index==1){
                $( this ).remove();
            }
        });
        $('section').each(function(index){
            if(index==1){
                $( this ).append("<ul></ul>");
                $( this ).html(datos);
            }
        });
    }

    verErrores(error){
        switch(error.code) {
        case error.PERMISSION_DENIED:
            this.mensaje = "El usuario no ha permitido la petición de geolocalización"
            break;
        case error.POSITION_UNAVAILABLE:
            this.mensaje = "Información de geolocalización no disponible"
            break;
        case error.TIMEOUT:
            this.mensaje = "La peticiÃ³n de geolocalización ha caducado"
            break;
        case error.UNKNOWN_ERROR:
            this.mensaje = "Se ha producido un error desconocido"
            break;
        }
    }
}
var miPosicion = new Geolocalización();