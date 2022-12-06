"use strict";
class LectorArchivos {

    leerArchivoTexto(files) 
  { 
      //Solamente toma un archivo
      var archivo = files[0];
      var stringDatos="<h2>Datos</h2>";
      stringDatos+="<p>Nombre del archivo: "+archivo.name+"</p>";
      stringDatos+= "<p>Tamaño del archivo: " + archivo.size + " bytes</p>"; 
      stringDatos+= "<p>Tipo del archivo: " + archivo.type+"</p>";
      stringDatos+="<p>Fecha de la última modificación: " + archivo.lastModifiedDate+"</p>";
      //Solamente admite archivos de tipo texto

      var areaVisualizacion = $("pre").get(0)

      var tipoTexto = /text.*/;
      if (archivo.type.match(tipoTexto)) {
        var lector = new FileReader();
        lector.onload = function (evento) {
            $("h3").remove();
            $("pre").before("<h3>Contenido del archivo de texto:<h3>");
            areaVisualizacion.innerText = lector.result;
        }      
          lector.readAsText(archivo);
    } else {
        $("h3").remove();
        $("pre").before("<h3>Contenido del archivo de texto:<h3>");
        areaVisualizacion.innerText = "Error : ¡¡¡ Archivo no válido !!!";
    }    
    $('h2').each(function(index){
      if(index==1){
          $( this ).remove();
      }
    });

    $('section').each(function(index){
      if(index==1){
          $( this ).html(stringDatos);
      }
    });
    
  }
}
var lector= new LectorArchivos();
