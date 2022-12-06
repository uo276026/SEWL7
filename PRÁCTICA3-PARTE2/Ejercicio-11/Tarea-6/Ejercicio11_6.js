"use strict";

class MapaDinamico {

  constructor(){
    this.mapa;
    this.marcador;
    this.origen;
    this.destino;
  }

  initMap(){
    navigator.geolocation.getCurrentPosition(this.getPosicion.bind(this));
      var centro = {lat: 43.53573, lng: -5.66152};
      var mapaElement = $("main").get(0);
      var mapaGeoposicionado = new google.maps.Map(mapaElement,{
        zoom: 8,
        center:centro,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    this.mapa=mapaGeoposicionado;
    var mapaDinamico = this;
    var infoWindow = new google.maps.InfoWindow;
    if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Localización actual');
            infoWindow.open(mapaGeoposicionado);
            mapaGeoposicionado.setCenter(pos);
           });
        }

  }

  getPosicion(posicion){
    this.mensaje = "";
    this.longitud         = posicion.coords.longitude; 
    this.latitud          = posicion.coords.latitude;  
    this.precision        = posicion.coords.accuracy;      
  }

  

  buscar(){
    var lugar=""
    $('input').each(function(index){
      if(index==0){
        lugar = $( this ).val();
      }
    });
    var url ="http://api.openweathermap.org/data/2.5/weather?q="+lugar+",ES&units=metric&lang=es&APPID=4340638947e6e249e8459a6b2ab5b8d9";
    this.cargarDatos(url);  
  }

  calcularDistancia(){
    this.origen=null;
    this.destino=null;
    var origen = "";

    var destino ="";

    $('input').each(function(index){
      if(index==1){
        origen = $( this ).val();
      } 
      if(index==2){
        destino=$( this ).val();
      }
    });

    if(origen=="" || destino==""){

      $('p').each(function(index){
        if(index==3){
            $( this ).remove();
        }
    });

    $('button').each(function(index){
      if(index==1){
          $( this ).after("<p>ERROR: Hay un valor que se encuentra vacío</p>")
      }
    });

    } else{
      this.cargarDatos2(origen, destino)
    }
  }

  calcularDistanciaEntreDosCoordenadas(origen, destino){
    // Convertir todas las coordenadas a radianes
    var lat1 = this.gradosARadianes(origen.lat);
    var lon1 = this.gradosARadianes(origen.lng);
    var lat2 = this.gradosARadianes(destino.lat);
    var lon2 = this.gradosARadianes(destino.lng);
    // Aplicar fórmula
    const RADIO_TIERRA_EN_KILOMETROS = 6371;
    var diferenciaEntreLongitudes = (lon2 - lon1);
    var diferenciaEntreLatitudes = (lat2 - lat1);
    var a = Math.pow(Math.sin(diferenciaEntreLatitudes / 2.0), 2) + Math.cos(lat1) * Math.cos(lat2) * Math.pow(Math.sin(diferenciaEntreLongitudes / 2.0), 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return RADIO_TIERRA_EN_KILOMETROS * c;
  };

  gradosARadianes(grados) {
    return grados * Math.PI / 180;
  };

  cargarDatos2(nombreOrigen, nombreDestino){
    var mapaDinamico = this;
    $.ajax({
        dataType: "json",
        url: "http://api.openweathermap.org/data/2.5/weather?q="+nombreOrigen+",ES&units=metric&lang=es&APPID=4340638947e6e249e8459a6b2ab5b8d9",
        method: 'GET',
        success: function(datos){
                mapaDinamico.origen = {lat:  datos.coord.lat, lng: datos.coord.lon};
        },
        error:function(){
          $('p').each(function(index){
            if(index==3){
                $( this ).remove();
            }
          });
            $('button').each(function(index){
              if(index==1){
                  $( this ).after("<p>¡Tenemos problemas! No puedo obtener JSON para la ciudad origen</p>")
              }
            });
        }
    });
    $.ajax({
      dataType: "json",
      url: "http://api.openweathermap.org/data/2.5/weather?q="+nombreDestino+",ES&units=metric&lang=es&APPID=4340638947e6e249e8459a6b2ab5b8d9",
      method: 'GET',
      success: function(datos){
              if(mapaDinamico.origen!=null){
                mapaDinamico.destino = {lat:  datos.coord.lat, lng: datos.coord.lon};
                var distancia = mapaDinamico.calcularDistanciaEntreDosCoordenadas(mapaDinamico.origen,mapaDinamico.destino);
                $('p').each(function(index){
                  if(index==3){
                      $( this ).text("Desde "+nombreOrigen+" hasta "+nombreDestino+" hay "+distancia+ " km");
                  }
              });
              }
            },
      error:function(){ 
        $('p').each(function(index){
          if(index==3){
              $( this ).remove();
          }
      });
          $('button').each(function(index){
            if(index==1){
                $( this ).after("<p>¡Tenemos problemas! No puedo obtener JSON para la ciudad destino</p>")
            }
          });
      }
  });
  }

  cargarDatos(url){
    var mapaDinamico = this;
    $.ajax({
        dataType: "json",
        url: url,
        method: 'GET',
        success: function(datos){
                var longitud = datos.coord.lon;
                var latitud = datos.coord.lat;
                mapaDinamico.createMark(latitud,longitud);
            },
        error:function(){
          $('p').each(function(index){
            if(index==3){
                $( this ).remove();
            }
        });
            $('button').each(function(index){
              if(index==1){
                  $( this ).after("<p>¡Tenemos problemas! No puedo obtener JSON de la página web para la ciudad indicada en buscar</p>")
              }
            });
            
        }
    });
}

createMark(latitud, longitud){
  var lugar = {lat: latitud, lng: longitud};
  this.mapa.setCenter(lugar);
  if(this.marcador!=null)
    this.marcador.setMap(null);
  this.marcador = new google.maps.Marker({position:lugar,map:this.mapa});
  this.marcador.addListener("click", () => {
    this.mapa.setZoom(10);
    this.mapa.setCenter(this.marcador.getPosition());
  });
}

}

var mapaDinamicoGoogle = new MapaDinamico();
