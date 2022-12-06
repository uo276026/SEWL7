"use strict";
class MapaKML {
  
  constructor(){
    this.contenidoKML;
    this.map;
  }

    leerArchivo(files) { 
      var archivo = files[0];
      var extension=archivo.name.substring(archivo.name.length-8)
      var objeto=this;
      if (extension.toUpperCase()==".GEOJSON") {
        $('p').each(function(index){
          if(index==1){
              $( this ).remove();
          }
        });
        var lector = new FileReader();
        lector.onload = function (evento) {
          var informacion = $.parseJSON(lector.result);
            for(var i=0; i<informacion.features.length;i++){
              var latitud= parseInt(informacion.features[i].geometry.coordinates[1]);
              var longitud= parseInt(informacion.features[i].geometry.coordinates[0]);
              var lugar = {lat: latitud, lng: longitud};
              objeto.map.setCenter(lugar);
              var marcador = new google.maps.Marker({position:lugar,map:objeto.map});
            }
        }      
        lector.readAsText(archivo);
      } else{
        $('p').each(function(index){
          if(index==1){
              $( this ).remove();
          }
          if(index==0){
              $( this ).after("<p>ERROR: No es un archivo .GeoJSON</p>")
          }
        });
      } 
  }

  initMap(){
    var gijon = {lat: 43.53573, lng: -5.66152};
    var mapaElement = $("main").get(0);
    var map = new google.maps.Map(mapaElement,{zoom: 8,center:gijon});
    this.map=map;
  }


}
var mapakml= new MapaKML();
