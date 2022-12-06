"use strict";
class MapaKML {
  
  constructor(){
    this.contenidoKML;
    this.map;
  }

    leerArchivo(files) { 
      var archivo = files[0];
      var extension=archivo.name.substring(archivo.name.length-4)
      var objeto=this;
      if (extension==".kml") {

        $('p').each(function(index){
          if(index==1){
              $( this ).remove();
          }
        });

        var lector = new FileReader();
        lector.onload = function (evento) {
          var informacion= $.parseXML(lector.result);
          var placemarks=$('Placemark',informacion);
          for(var i=0;i<placemarks.length;i++){
            var coordinates=$('coordinates',placemarks[i]);
            coordinates=coordinates.text().split(",");
            var latitud= parseInt(coordinates[1]);
            var longitud = parseInt(coordinates[0]);
            var lugar = {lat: latitud, lng: longitud};
            objeto.map.setCenter(lugar);
            var marcador = new google.maps.Marker({position:lugar,map:objeto.map});
          }
        }      
        lector.readAsText(archivo);
      } else{
        $('p').each(function(index){
          if(index==0){
            $( this ).after("<p>ERROR: No es un archivo .kml</p>")
          }
          if(index==1){
              $( this ).remove();
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
