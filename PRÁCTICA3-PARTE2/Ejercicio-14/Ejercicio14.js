"use strict";
class Program {
    constructor(){
        this.colores=["white", "green", "blue", "red", "yellow", "pink", "orange", "black"];
        this.colorActual=1;
        this.x=-40;
        this.y=10;
        this.colorFondo=this.colores[0];
        this.isDrawing=false;
    }

    click(){
        
        var canvas = $("canvas")[0]
        var canvas1 = canvas.getContext("2d");

        //Hacer click en el canvas
        var mouse_position = function(e){
            var x = e.offsetX/3
            var y = e.offsetY/3
            this.isDrawing=true;
            canvas1.beginPath();
                canvas1.strokeStyle = "black";
                canvas1.moveTo(x, y);
        }
        
        //Mover el ratón por el canvas  
        var mouse_monitor = function(e) {
            var rect = canvas.getBoundingClientRect()
            var x = e.offsetX/3
            var y = e.offsetY/3
            if(this.isDrawing){ 
                canvas1.lineTo(x, y);
                canvas1.stroke();
            }
          }
          
          //Soltar click
          var mouse_up = function(e){
            this.isDrawing=false;
          }

          $(canvas).on('mousedown', mouse_position );
          $(canvas).on('mousemove', mouse_monitor);
          $(canvas).on('mouseup', mouse_up);
    }


  
    

    cambiarColor(){
        this.colorActual+=1;
        if(this.colorActual>7){
            this.colorActual=0;
        }
        var colorActual=this.colores[this.colorActual].toUpperCase();
        $('p').each(function(index){
            if(index==0){
                $( this ).text("Color actual: "+ colorActual);
            }
          });
    }

    rellenarFondo(){
        var canvas = $("canvas")[0]
        var canvas1 = canvas.getContext("2d");
        canvas1.fillStyle = this.colores[this.colorActual];
        canvas1.fillRect(0, 0, canvas.width, canvas.height);
        this.x=-40;
        this.y=10;
        this.colorFondo=this.colores[this.colorActual];
        this.cambiarColor();
    }

    borrarTodo(){
        var canvas = $("canvas")[0]
        var context = canvas.getContext("2d");
        context.fillStyle = "white";
        context.fillRect(0, 0, canvas.width, canvas.height);
        this.x=-40;
        this.y=10;
        this.colorFondo="white";
    }


    dibujar(forma){
        var canvas = $("canvas")[0]
		var canvas1 = canvas.getContext('2d');
        var xanterior=this.x;
        var yanterior=this.y;
		this.x+=50;
        if(this.x>canvas.width){
            this.x=10;
            this.y+=50;
        }
        if(this.y>canvas.height){
            this.x=xanterior;
            this.y=yanterior
        } else{
		    //fillRect(float x, float y, float ancho, float alto)
            canvas1.fillStyle = this.colores[this.colorActual];
            if(forma=="cuadrado") {
                canvas1.fillRect(this.x, this.y, 30, 30);
            } else if(forma=="triangulo"){
                canvas1.beginPath();
                canvas1.strokeStyle = this.colores[this.colorActual];
                canvas1.moveTo(this.x+15, this.y);
                canvas1.lineTo(this.x, this.y+30);
                canvas1.lineTo(this.x+30, this.y+30);
                canvas1.fill();
                canvas1.closePath();
                canvas1.stroke();
            } else if(forma=="circulo"){
                canvas1.beginPath();
                canvas1.strokeStyle = this.colores[this.colorActual];
                canvas1.arc(this.x+15, this.y+15, 15, 0, Math.PI * 2, true);
                canvas1.stroke();
            } else if(forma=="corazón"){
                var img = new Image();
                img.onload = () => canvas1.drawImage(img, this.x-5, this.y-5);
                img.src = "images/heart.png"; 
            } else if(forma=="estrella"){
                var img = new Image();
                img.onload = () => canvas1.drawImage(img, this.x-5, this.y-5);
                img.src = "images/star.png"; 
            }
        }
    }

    cargarImagen(files) {
        var fileReader = new FileReader();
        fileReader.onload = function (event) {
            var img = new Image();
            img.onload = function () { 
                var canvas = $("canvas")[0]
                var canvas1 = canvas.getContext("2d");
                canvas.width = img.width;
                canvas.height = img.height;
                canvas1.drawImage(img, 0, 0);
            }
            img.src = event.target.result;
        }
        fileReader.readAsDataURL(files[0]);
        this.x=-40;
        this.y=10;
    }
}

function allowDrop(ev) {
    ev.preventDefault();
  }

function drag(ev, forma) {
    ev.dataTransfer.setData("text", forma);
}

  function drop(ev) {
    ev.preventDefault();
    var forma = ev.dataTransfer.getData("text");
    program.dibujar(forma);
  }

var program = new Program();