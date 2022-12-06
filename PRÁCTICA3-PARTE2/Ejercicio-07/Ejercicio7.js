$(document).ready(function(){
    $('button[name="ocultar"]').click(function(){
      $('p').hide();
    });
    $('button[name="mostrar"]').click(function(){
      $('p').show();
    });
    $('button[name="MasInfo"]').click(function(){
        $('p').text("El lenguaje Ruby fue creado por Yukihiro 'Matz' Matsumoto, quien empezó a trabajar en Ruby el 24 de febrero de 1993, y" +
        "lo presentó al público en el año 1995. Diferencias en rendimiento entre la actual implementación de Ruby (1.8.6) y otros lenguajes de programación"+
        "más arraigados han llevado al desarrollo de varias máquinas virtuales para Ruby. Entre esas se encuentra JRuby, un intento de llevar Ruby a la plataforma Java, y Rubinius, un intérprete modelado basado en las máquinas virtuales de Smalltalk.");
    });
    $('button[name="MenosInfo"]').click(function(){
        $('p').text("Ruby es un lenguaje de programación interpretado, reflexivo y orientado a objetos, creado por el programador japonés Yukihiro Matsumoto.");
    });
    $('button[name="añadirOpinion"]').click(function(){
        $('button[name="añadirOpinion"]').after("<p>"+"'"+$('input[name="opinion"]').val()+"'"+"</p>");
    });

    $('button[name="ocultarVersiones"]').click(function(){
      $("table tr td").each(function() {
        var celda = $.trim($(this).text());
        if (celda.length == 0) {
            $(this).parent().hide();
        }
      });
    });

    $('button[name="mostrarVersiones"]').click(function() {
      $("table tr").each(function() {
          $(this).show();
      });
    });
    
    $('button[name="verInfoHTML"]').click(function() {
      $('p').text("");
      $("*", document.body).each(function() {
        var etiquetaPadre = $(this).parent().get(0).tagName;
        $('p').prepend(document.createTextNode( "Etiqueta padre : <"  + etiquetaPadre + "> elemento : <" + $(this).get(0).tagName +"> valor: "+$(this).get(0).text));
        
      });
      $('button[name="verInfoHTML"]').hide();
    });

  


    $('button[name="sumarFilas"]').click(function(){
      var total=0;
      $("table tr td").each(function() {
        if(!isNaN(parseInt($(this).text()))){
          total += parseInt($(this).text());
        }
      });
      $('p').text("SUMA: "+total);
    });
    

  });