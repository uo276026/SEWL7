"use strict";
class MapaDinamico {

    initMap(){
        var gijon = {lat: 43.53573, lng: -5.66152};
        var mapaElement = $("main").get(0);
        var mapaGijon = new google.maps.Map(mapaElement,{zoom: 8,center:gijon});
        var marcador = new google.maps.Marker({position:gijon,map:mapaGijon});
    }
}

var mapaDinamicoGoogle = new MapaDinamico();
