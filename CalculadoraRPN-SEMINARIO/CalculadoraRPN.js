"use strict";
class CalculadoraRPN {

    constructor() {
        this.pantalla = "";
        this.pila = new Array();
        this.valorActual=1;
        this.shiftClicked=false;
        this.altPressed=false;

         document.addEventListener('keydown', (event) => {
            const key = event.key;
            if(this.altPressed){
                if (key === 'c') 
                    this.limpiarPila();
            } else {
                if (key === '0' || key === '1' || key === '2' || key === '3' || key === '4' || key === '5' || key === '6' || key === '7' || key === '8' || key === '9') {
                    this.dígitos(key);
                } else if (key === 's') {
                    this.seno();
                } else if (key === 'o') {
                    this.coseno();
                } else if (key === 't') {
                    this.tangente();
                } else if (key === 'Shift') {
                    this.shift();
                } else if (key === '.') {
                    this.punto();
                } else if (key === '+') {
                    this.suma();
                } else if (key === '-') {
                    this.resta();
                } else if (key === '*') {
                    this.multiplicación();
                } else if (key === '/') {
                    this.división();
                } else if (key === 'm') {
                    this.mPressed = true;
                } else if (key === 'c') {
                    this.borrar();
                } else if (key === 'Backspace') {
                    this.borrarDigito();
                } else if (key === 'Enter') {
                    this.apilar();
                } else if (key === 'ArrowDown') {
                    this.cambioSigno();
                } else if (key === 'Delete') {
                    this.desapilar();
                } else if(key === 'Alt'){
                    this.altPressed=true;
                }
        }
        })

        document.addEventListener('keyup', (event) => {
            const key = event.key;
            if (key === 'Alt')
                this.altPressed = false;
        })
    } 

    apilar(){
        var number=new Number(this.pantalla);
        if(!isNaN(this.pantalla) && this.pantalla!=""){
            this.pila.push(number);
            this.pantalla="";
            this.show();
            this.showPila();
        }
    }

    desapilar(){
        this.pila.pop();
        this.showPila();
    }

   
    showPila(){
        var stringPila="";
        var pos=this.pila.length
        for (var i in this.pila) {
            stringPila += "[" + pos + "]" +"\t\t" +this.pila[i]+"\n";
            pos--;
        }       
        document.getElementsByTagName("textarea")[0].value = stringPila
    }

    show() {
        document.getElementsByTagName("input")[0].value = this.pantalla
    }

    dígitos(arg) {
        this.pantalla+=arg;
        this.show();
    }

    punto() {
        this.pantalla += ".";
        this.show();
    }

    suma(){
        if(this.pila.length >= 2){
            this.pila.push(this.pila.pop()+this.pila.pop());
            this.showPila();
        }
    }
    

    resta(){
        if(this.pila.length >= 2){
            this.pila.push(this.pila.pop()-this.pila.pop());
            this.showPila();
        }
    }

    multiplicación() {
        if(this.pila.length >= 2){
            this.pila.push(this.pila.pop()*this.pila.pop());
            this.showPila();
        }
    }

    división() {
        if(this.pila.length >= 2){
            this.pila.push(this.pila.pop()/this.pila.pop());
            this.showPila();
        }
    }


    
    borrar() {
        this.pantalla = "";
        this.show();
    }

    borrarDigito() {
        this.pantalla = this.pantalla.substring(0, this.pantalla.length - 1);
        this.show();
    }

    cambioSigno() {
        if(this.pantalla!=""){
            this.pantalla = -Number(this.pantalla);
            this.show();
        }
    }

    limpiarPila(){
        this.pila = new Array();
        this.showPila();
    }

    shift(){
        this.shiftClicked=!this.shiftClicked;
        if(this.shiftClicked){
            document.getElementsByName("shift")[0].style.backgroundColor='#A5CFED';
        } else{
            document.getElementsByName("shift")[0].style.backgroundColor='#EFEFEF';
        }
        this.changeLayout();
    }

    changeLayout(){
        if(this.shiftClicked){
            document.getElementsByName("seno")[0].value="sin-1";
            document.getElementsByName("coseno")[0].value="cos-1";
            document.getElementsByName("tangente")[0].value="tan-1";
        } else if(!this.shiftClicked){
            document.getElementsByName("seno")[0].value="sin";
            document.getElementsByName("coseno")[0].value="cos";
            document.getElementsByName("tangente")[0].value="tan";
        }
    }

    seno() {
        if(this.pila.length>=1){
            var numero=this.pila.pop();
            if(!this.shiftClicked){
                var resul=Math.sin(numero)
                this.pila.push(resul);
            } else{
                var resul=Math.asin(numero)
                this.pila.push(resul);
            }
        }
        this.showPila();
    }

    coseno() {
        if(this.pila.length>=1){
            var numero=this.pila.pop();
            if(!this.shiftClicked){
                var resul=Math.cos(numero)
                this.pila.push(resul);
            } else{
                var resul=Math.acos(numero)
                this.pila.push(resul);
            }
        }
        this.showPila();
    }

    tangente() {
        if(this.pila.length>=1){
            var numero=this.pila.pop();
            if(!this.shiftClicked){
                var resul=Math.tan(numero)
                this.pila.push(resul);
            } else{
                var resul=Math.atan(numero)
                this.pila.push(resul);
            }
        }
        this.showPila();
    }

    raiz(){
        if(this.pila.length>=1){
            var numero=this.pila.pop();
            var resul=Math.sqrt(numero)
            this.pila.push(resul);
        }
        this.showPila();
    }

}

var calc = new CalculadoraRPN();

