"use strict";
class Meteo {
    constructor(ciudad){
        this.apikey = "4340638947e6e249e8459a6b2ab5b8d9";
        this.ciudad = ciudad;
        this.codigoPais = "ES";
        this.unidades = "&units=metric";
        this.idioma = "&lang=es";
        this.url = "http://api.openweathermap.org/data/2.5/weather?q=" + this.ciudad + "," + this.codigoPais + this.unidades + this.idioma + "&APPID=" + this.apikey;
        this.correcto = "Â¡Todo correcto! JSON recibido de <a href='http://openweathermap.org'>OpenWeatherMap</a>"

    }
    cargarDatos(){
        $.ajax({
            dataType: "json",
            url: this.url,
            method: 'GET',
            success: function(datos){
                    var stringDatos = "<li>Ciudad: " + datos.name + "</li>";
                        stringDatos += "<li>Paí­s: " + datos.sys.country + "</li>";
                        stringDatos += "<li>Latitud: " + datos.coord.lat + " grados</li>";
                        stringDatos += "<li>Longitud: " + datos.coord.lon + " grados</li>";
                        stringDatos += "<li>Temperatura: " + datos.main.temp + " grados Celsius</li>";
                        stringDatos += "<li>Temperatura máxima: " + datos.main.temp_max + " grados Celsius</li>";
                        stringDatos += "<li>Temperatura mínima: " + datos.main.temp_min + " grados Celsius</li>";
                        stringDatos += "<li>Presión: " + datos.main.pressure + " milibares</li>";
                        stringDatos += "<li>Humedad: " + datos.main.humidity + " %</li>";
                        stringDatos += "<li>Amanece a las: " + new Date(datos.sys.sunrise *1000).toLocaleTimeString() + "</li>";
                        stringDatos += "<li>Oscurece a las: " + new Date(datos.sys.sunset *1000).toLocaleTimeString() + "</li>";
                        stringDatos += "<li>Dirección del viento: " + datos.wind.deg + " grados</li>";
                        stringDatos += "<li>Velocidad del viento: " + datos.wind.speed + " metros/segundo</li>";
                        stringDatos += "<li>Hora de la medida: " + new Date(datos.dt *1000).toLocaleTimeString() + "</li>";
                        stringDatos += "<li>Fecha de la medida: " + new Date(datos.dt *1000).toLocaleDateString() + "</li>";
                        stringDatos += "<li>Descripción: " + datos.weather[0].description + "</li>";
                        stringDatos += "<li>Visibilidad: " + datos.visibility + " metros</li>";
                        stringDatos += "<li>Nubosidad: " + datos.clouds.all + " %</li>";
                        stringDatos += '<img alt="TiempoIMG" src="http://openweathermap.org/img/w/' + datos.weather[0].icon + '.png">'

                    $('p').remove();
                    $('section').each(function(index){
                        if(index==1){
                            $( this ).append("<ul></ul>");
                        }
                    });
                    $("ul").html(stringDatos);
                },
            error:function(){
                $('p').remove();
                $('section').each(function(index){
                    if(index==1){
                        $( this ).append("<p>¡Tenemos problemas! No puedo obtener JSON de la página web</p>");
                    }
                });
            }
        });
    }
    crearElemento(tipoElemento, texto, insertarAntesDe){
        var elemento = document.createElement(tipoElemento); 
        elemento.innerHTML = texto;
        $(insertarAntesDe).before(elemento);
    }
    verJSON(){
        $('ul').remove();
        this.cargarDatos();
    }
}
