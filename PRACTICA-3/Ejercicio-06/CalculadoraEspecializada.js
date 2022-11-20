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
        document.getElementById("pila").value = stringPila
    }

    show() {
        document.getElementById("resultado").value = this.pantalla
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
            document.getElementById("shift").style.backgroundColor='#A5CFED';
        } else{
            document.getElementById("shift").style.backgroundColor='#EFEFEF';
        }
        this.changeLayout();
    }

    changeLayout(){
        if(this.shiftClicked){
            document.getElementById("seno").value="sin-1";
            document.getElementById("coseno").value="cos-1";
            document.getElementById("tangente").value="tan-1";
        } else if(!this.shiftClicked){
            document.getElementById("seno").value="sin";
            document.getElementById("coseno").value="cos";
            document.getElementById("tangente").value="tan";
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

}
class CalculadoraEspecializadaRPN extends CalculadoraRPN{

    constructor() {
        super();
        this.baseActual=10;

         document.addEventListener('keydown', (event) => {
            const key = event.key;
            if (key === 'b') {
                this.toBase(2);
            }else if(key==='q'){
                this.toBase(8);
            }else if(key==='d'){
                this.toBase(10);
            }else if(key==='h'){
                this.toBase(16);
            }
            
        })
    } 

    //REDEFINIDOS
    suma(){
        var base=this.baseActual;
        if(this.pila.length >= 2){
            this.toBase10();
            this.pila.push(this.pila.pop()+this.pila.pop());
            this.toBase(base);
            this.showPila();
        }
       
    }

    resta(){
        var base=this.baseActual;
        if(this.pila.length >= 2){
            this.toBase10();
            this.pila.push(this.pila.pop()-this.pila.pop());
            this.toBase(base);
            this.showPila();
        }
    }

    multiplicación() {
        var base=this.baseActual;
        if(this.pila.length >= 2){
            this.toBase10();
            this.pila.push(this.pila.pop()*this.pila.pop());
            this.toBase(base);
            this.showPila();
        }
    }

    división() {
        var base=this.baseActual;
        if(this.pila.length >= 2){
            this.toBase10();
            this.pila.push(this.pila.pop()/this.pila.pop());
            this.toBase(base);
            this.showPila();
        }
    }

    seno() {
        var base=this.baseActual;
        if(this.pila.length>=1){
            this.toBase10();
            var numero=this.pila.pop();
            if(!this.shiftClicked){
                var resul=Math.sin(numero)
                this.pila.push(resul);
            } else{
                var resul=Math.asin(numero)
                this.pila.push(resul);
            }
            this.toBase(base);
        }
        this.showPila();
    }



    coseno() {
        var base=this.baseActual;
        if(this.pila.length>=1){
            this.toBase10();
            var numero=this.pila.pop();
            if(!this.shiftClicked){
                var resul=Math.cos(numero)
                this.pila.push(resul);
            } else{
                var resul=Math.acos(numero)
                this.pila.push(resul);
            }
            this.toBase(base);
        }
        this.showPila();
    }

    tangente() {
        var base=this.baseActual;
        if(this.pila.length>=1){
            this.toBase10();
            var numero=this.pila.pop();
            if(!this.shiftClicked){
                var resul=Math.tan(numero)
                this.pila.push(resul);
            } else{
                var resul=Math.atan(numero)
                this.pila.push(resul);
            }
            this.toBase(base);
        }
        this.showPila();
    }

    //NUEVOS METODOS

    toBase(x){
        if(x==2){
            this.toBase2();
        } else if(x==8){
            this.toBase8();
        } else if(x==10){
            this.toBase10();
        } else if(x==16){
            this.toBase16();
        }
    }

    toBase10(){
        if(this.pila.length>=1){        
            if(this.pila.length>=1){
                for(var i in this.pila){
                    let num=this.pila[i]
                    var res=parseInt(num, this.baseActual)
                    if(isNaN(res)){
                        res=num;
                    }
                    this.pila[i]=res;
                }
                this.showPila();
                this.changeBaseTo(10);
            }   
        } else {
            this.changeBaseTo(10);
        }
    
    }

    toBase2(){
        if(this.pila.length>=1){ 
            this.toBase10();
            if (this.baseActual===10){
                let num=0;
                for(var i in this.pila){
                    num=0+this.pila[i];
                    num=num.toString(2);
                    var res=parseInt(num);
                    if(isNaN(res)){
                        res=num;
                    }
                    this.pila[i]=res;
                }
                this.showPila();  
                this.changeBaseTo(2);
            }
        } else {
            this.changeBaseTo(2);
        }
    }   

    toBase8(){
        if(this.pila.length>=1){ 
            this.toBase10();
            if (this.baseActual===10){
                let num=0;
                for(var i in this.pila){
                    num=0+this.pila[i];
                    num=num.toString(8);
                    var res=parseInt(num);
                    if(isNaN(res)){
                        res=num;
                    }
                    this.pila[i]=res;
                }
                this.showPila();  
                this.changeBaseTo(8);
            }
        } else {
            this.changeBaseTo(8);
        }
    }   

    toBase16(){
        if(this.pila.length>=1){ 
            this.toBase10();
            if (this.baseActual===10){
                let num=0;
                for(var i in this.pila){
                    num=0+this.pila[i];
                    num=num.toString(16);
                    var res=parseInt(num);
                    if(isNaN(res)){
                        res=num;
                    }
                    this.pila[i]=res;
                }
                //this.pila.push(num);
                this.showPila();  
                this.changeBaseTo(16);
            }
        } else {
            this.changeBaseTo(16);
        }
    }   

    changeBaseTo(base){
        this.baseActual=base;
        document.getElementById("Base"+base).style.backgroundColor='#53AAFC';
        if(base==2){
            document.getElementById("Base10").style.backgroundColor='#A9D0F5';
            document.getElementById("Base8").style.backgroundColor='#A9D0F5';
            document.getElementById("Base16").style.backgroundColor='#A9D0F5';
        } else if(base==10){
            document.getElementById("Base2").style.backgroundColor='#A9D0F5';
            document.getElementById("Base8").style.backgroundColor='#A9D0F5';
            document.getElementById("Base16").style.backgroundColor='#A9D0F5';
        } else if(base==8){
            document.getElementById("Base2").style.backgroundColor='#A9D0F5';
            document.getElementById("Base10").style.backgroundColor='#A9D0F5';
            document.getElementById("Base16").style.backgroundColor='#A9D0F5';
        } else if(base==16){
            document.getElementById("Base2").style.backgroundColor='#A9D0F5';
            document.getElementById("Base10").style.backgroundColor='#A9D0F5';
            document.getElementById("Base8").style.backgroundColor='#A9D0F5';

        }
    }

}

var calc = new CalculadoraEspecializadaRPN();

