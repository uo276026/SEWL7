"use strict";

class MapaDinamico {

  initMap(){
    navigator.geolocation.getCurrentPosition(this.getPosicion.bind(this));
      var centro = {lat: 43.53573, lng: -5.66152};
      var mapaElement = $("main").get(0);
      var mapaGeoposicionado = new google.maps.Map(mapaElement,{
        zoom: 8,
        center:centro,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var mapaDinamico = this;
    var infoWindow = new google.maps.InfoWindow;
    if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Localización encontrada');
            infoWindow.open(mapaGeoposicionado);
            mapaGeoposicionado.setCenter(pos);
          }, function() {
            mapaDinamico.handleLocationError(true, infoWindow, mapaGeoposicionado.getCenter());
          });
        } else {
          mapaDinamico.handleLocationError(false, infoWindow, mapaGeoposicionado.getCenter());
        }
  }

  getPosicion(posicion){
    this.mensaje = "";
    this.longitud         = posicion.coords.longitude; 
    this.latitud          = posicion.coords.latitude;  
    this.precision        = posicion.coords.accuracy;      
  }

  handleLocationError(browserHasGeolocation, infoWindow, pos) {
    //alert('Error: Ha fallado la geolocalización, puede que no haya aceptado los permisos');
    $('p').remove();
    $('h2').after("<p>Error: Ha fallado la geolocalización, puede que no haya aceptado los permisos</p>")       
  }

}

var mapaDinamicoGoogle = new MapaDinamico();
