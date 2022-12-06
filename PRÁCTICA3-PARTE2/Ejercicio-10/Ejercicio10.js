"use strict";
class TarifaLuz {
    constructor(category){
        this.idRegion= $('option:selected').val();
        this.category=category;
        this.year= $('input').val();
        this.url = "https://apidatos.ree.es/es/datos/mercados/"+this.category+"?start_date="+this.year+"-01-01T00:00&end_date="+this.year+"-12-31T23:59&time_trunc=month&geo_ids="+this.idRegion;
    }

    cargarDatos(){
        $.ajax({
            dataType: "json",
            url: this.url,
            type: 'GET',  
            success: function(datos){
                var stringDatos = "";
                stringDatos+="<h2>Datos</h2>";
                for(var i=0; i < datos.included.length; i++){
                    stringDatos+="<h3>"+datos.included[i].attributes.title+"</h3>";
                    for(var j=0; j < datos.included[i].attributes.values.length; j++){
                        stringDatos+="<ul><li> Precio:"+datos.included[i].attributes.values[j].value+"</li>";
                        stringDatos+="<li> Porcentaje:"+datos.included[i].attributes.values[j].percentage+"</li>";
                        stringDatos+="<li> Fecha:"+datos.included[i].attributes.values[j].datetime.substring(0,10)+"</li></ul>";
                    }
                    $("h2 span:last-child").remove();
                    $('p').each(function(index){
                        if(index==2){
                            $( this ).remove();
                        }
                    });
                    
                    $('section').each(function(index){
                        if(index==1){
                            $( this ).html(stringDatos);
                        }
                    });
                    }
                },
            error:function(){
                $('p').each(function(index){
                    if(index==2){
                        $( this ).remove();
                    }
                });
                $('section').each(function(index){
                    if(index==1){
                        $(this).html("<h2>Datos</h2><p>Ha ocurrido un problema.  Puede que no haya datos para los filtros seleccionados</p>")
                    }
                });
            }
        });
    }
    

}
