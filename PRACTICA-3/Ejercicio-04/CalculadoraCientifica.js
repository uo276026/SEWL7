
"use strict";
class Calculadora {

    constructor() {
        this.pantalla = "";
        this.memoria = new Number('0');
        this.limpiarPantalla = false;
        this.mPressed = false;


        document.addEventListener('keydown', (event) => {
            const key = event.key;
            if (this.mPressed) {
                if (key === '+')
                    this.mMas();
                else if (key === '-')
                    this.mMenos();
                else if (key === 'Enter')
                    this.mrc();
            } else {
                if (key === '0' || key === '1' || key === '2' || key === '3' || key === '4' || key === '5' || key === '6' || key === '7' || key === '8' || key === '9') {
                    this.dígitos(key);
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
                    this.igual();
                } else if (key === '%') {
                    this.porcentaje();
                } else if (key === 'v') {
                    this.raíz();
                } else if (key === 'ArrowDown') {
                    this.cambioSigno();
                }
            }

        }
        )

        document.addEventListener('keyup', (event) => {
            const key = event.key;
            if (key === 'm')
                this.mPressed = false;
        }
        )
    }

    show() {
        document.getElementById("resultado").value = this.pantalla
    }

    dígitos(arg) {
        if (this.pantalla != "0") {
            this.limpiaPantalla();
            this.pantalla += Number(arg).toString();
            this.show()
        } else {
            this.limpiaPantalla();
            this.pantalla = Number(arg).toString();
            this.show()
        }
    }

    punto() {
        this.limpiaPantalla();
        this.pantalla += ".";
        this.show();
    }

    suma() {
        this.limpiaPantalla();
        this.pantalla += "+";
        this.show();
    }

    resta() {
        this.limpiaPantalla();
        this.pantalla += "-";
        this.show();
    }

    multiplicación() {
        this.limpiaPantalla();
        this.pantalla += "*";
        this.show();
    }

    división() {
        this.limpiaPantalla();
        this.pantalla += "/";
        this.show();
    }

    mrc() {
        this.limpiaPantalla();
        this.pantalla = this.memoria;
        this.show();
    }

    mMenos() {
        this.limpiaPantalla();
        if (this.pantalla != "") {
            try {
                var resultado = eval(this.pantalla);
                this.memoria = new Number(this.memoria - resultado);
            } catch (err) {
                this.pantalla = "ERROR";
                this.limpiarPantalla = true;
            }
        }

    }

    mMas() {
        this.limpiaPantalla();
        if (this.pantalla != "") {
            try {
                var resultado = eval(this.pantalla);
                this.memoria = new Number(resultado + this.memoria);
            } catch (err) {
                this.pantalla = "ERROR";
                this.limpiarPantalla = true;
            }
        }
    }

    borrar() {
        this.limpiaPantalla();
        this.pantalla = "";
        this.show();
    }

    borrarDigito() {
        this.limpiaPantalla();
        this.pantalla = this.pantalla.substring(0, this.pantalla.length - 1);
        this.show();
    }

    igual() {
        this.limpiaPantalla();
        if (this.pantalla != "") {
            try {
                var resultado = Number(eval(this.pantalla));
                this.pantalla = Number(resultado);
                this.show();
                if (isNaN(this.pantalla)) {
                    this.limpiarPantalla = true;
                }
            } catch (err) {
                this.pantalla = "ERROR";
                this.show();
                this.limpiarPantalla = true;
            }
        }
    }

    porcentaje() {
        this.limpiaPantalla();
        this.pantalla += "/100";
        this.show();
    }
    raíz() {
        this.limpiaPantalla();
        this.igual();
        if (this.pantalla < 0) {
            this.pantalla = "ERROR";
            this.show();
            this.limpiarPantalla = true;
        } else if (this.pantalla != "") {
            try {
                var resultado = Math.sqrt(eval(this.pantalla));
                this.pantalla=resultado;
                this.show();
            } catch (err) {
                this.pantalla = "ERROR";
                this.show();
                this.limpiarPantalla = true;
            }
        }

    }

    cambioSigno() {
        this.limpiaPantalla();
        if (this.pantalla != "") {
            this.igual();
        }

        if (!this.limpiarPantalla) {
            this.pantalla = -Number(this.pantalla);
            this.show();
        }
    }

    limpiaPantalla() {
        if (this.limpiarPantalla || this.pantalla=="Infinity") {
            this.pantalla = "";
            this.limpiarPantalla = false;
            this.show();
        }
    }

}

class CalculadoraCientifica extends Calculadora {
    constructor() {
        super();
        this.parentesisAbiertos = 0;
        this.shiftClicked=false;
        this.hypClicked=false;
        this.deg = true;  
        this.altPressed=false; 
        
        document.addEventListener('keydown', (event) => {
            const key = event.key;
            if (this.mPressed) {
                if (key === 'Delete'){
                    this.mc();
                }
                else if (event.code === 'Space'){
                    this.ms();
                }
            }else if(this.altPressed){
                if (key === 'ArrowUp'){
                    this.elevaryPotenciaY();
                }
            } else {
                if (key === 'a') {
                    this.cambiarMedidaAngulo();
                } else if (key === 'h') {
                    this.hyp();
                } else if (key === 'f') {
                    this.fe();
                } else if (key === 'ArrowUp') {
                    this.elevar2y3();
                } else if (key === 'Alt') {
                    this.altPressed = true;
                } else if (key === 's') {
                    this.seno();
                } else if (key === 'o') {
                    this.coseno();
                } else if (key === 't') {
                    this.tangente();
                } else if (key === 'b') {
                    this.base10ex();
                } else if (key === 'l') {
                    this.logaritmo();
                } else if (key === 'e') {
                    this.expdms();
                } else if (key === 'd') {
                    this.moddeg();
                } else if (key === 'Shift') {
                    this.shift();
                } else if (key === 'Delete') {
                    this.ce();
                } else if (key === 'p') {
                    this.pi();
                } else if (key === 'x') {
                    this.exponente();
                } else if (key === '(') {
                    this.abrirParentesis();
                } else if (key === ')') {
                    this.cerrarParentesis();
                }
            }

        }
        )
        document.addEventListener('keyup', (event) => {
            const key = event.key;
            if (key === 'Alt')
                this.altPressed = false;
        })
    }

    //METODOS REDEFINIDOS
    igual() {
        this.limpiaPantalla();
        if (this.pantalla != "") {
            try {
                for (let i = 0; i < this.parentesisAbiertos; i++) {
                    this.pantalla += ")";
                }
                var resultado = eval(this.pantalla);
                this.pantalla = new Number(resultado);
                this.show();
                if (isNaN(this.pantalla)) {
                    this.limpiarPantalla = true;
                }
            } catch (err) {
                this.pantalla = "ERROR";
                this.show();
                this.limpiarPantalla = true;
            }
        }
        this.parentesisAbiertos = 0;
    }

    borrar() {
        this.limpiaPantalla();
        this.pantalla = "";
        this.parentesisAbiertos = 0;
        this.show();
    }

    borrarDigito() {
        this.limpiaPantalla();
        var borrado = this.pantalla.substring(this.pantalla.length - 1, this.pantalla.length);
        if (borrado === "(") {
            this.parentesisAbiertos--;
        } else if (borrado === ")") {
            this.parentesisAbiertos++;
        }
        this.pantalla = this.pantalla.substring(0, this.pantalla.length - 1);
        this.show();
    }

    raíz() {
        this.limpiaPantalla();
        if(!this.shiftClicked){
            this.igual();
            if (this.pantalla < 0) {
                this.pantalla = "ERROR";
                this.show();
                this.limpiarPantalla = true;
            } else if (this.pantalla != "") {
                try {
                    this.pantalla = Math.sqrt(eval(this.pantalla));
                    this.show();
                } catch (err) {
                    this.pantalla = "ERROR";
                    this.show();
                    this.limpiarPantalla = true;
                }
            }
        } else{
            this.pantalla += "1/";
            this.show();
        }

    }



    //NUEVOS METODOS
    //Borra memoria
    mc() {
        this.memoria = new Number('0');
    }

    //Muestra en pantalla valor de memoria
    mr() {
        this.mrc();
    }

    //memoria = this.pantalla
    ms() {
        this.limpiaPantalla();
        var resultado = '0';
        if (this.pantalla != "") {
            resultado = this.calcular(this.pantalla);
        }
        this.memoria = new Number(resultado);
    }

    calcular(op) {
        if (op != "") {
            try {
                var resultado = Number(eval(op));
                if (isNaN(resultado)) {
                    this.limpiarPantalla = true;
                }
                return resultado;
            } catch (err) {
                return "ERROR";
                this.limpiarPantalla = true;
            }
        }
        return "";
    }

    elevar2y3() {
        this.limpiaPantalla();
        if(!this.shiftClicked){
            this.pantalla += "**2";
           
        } else{
            this.pantalla += "**3";
        }
        this.show();
        
    }

    elevaryPotenciaY() {
        this.limpiaPantalla();
        if(!this.shiftClicked){
            this.pantalla += "**";
        } else{
            this.pantalla += "**(1/";
            this.parentesisAbiertos++;
        }
        this.show();
    }

    seno() {
        this.limpiaPantalla();
        var resul = this.calcular(this.pantalla);
        resul = this.comprobarGrados(resul);
        if(!this.shiftClicked&& !this.hypClicked){
            this.pantalla = this.calcular("Math.sin(" + resul + ")");
        }else if(this.shiftClicked && !this.hypClicked){
            this.pantalla = this.calcular("Math.asin(" + resul + ")");
        } else if(!this.shiftClicked && this.hypClicked){
            this.pantalla = this.calcular("Math.sinh(" + resul + ")");
        }else{
            this.pantalla = this.calcular("Math.asinh(" + resul + ")");
        }
        this.show();

    }

    coseno() {
        this.limpiaPantalla();
        var resul = this.calcular(this.pantalla);
        resul = this.comprobarGrados(resul);
        if(!this.shiftClicked&& !this.hypClicked){
            this.pantalla = this.calcular("Math.cos(" + resul + ")");
        }else if(this.shiftClicked && !this.hypClicked){
            this.pantalla = this.calcular("Math.acos(" + resul + ")");
        } else if(!this.shiftClicked && this.hypClicked){
            this.pantalla = this.calcular("Math.cosh(" + resul + ")");
        }else{
            this.pantalla = this.calcular("Math.acosh(" + resul + ")");
        }
        this.show();
    }


    tangente() {
        this.limpiaPantalla();
        var resul = this.calcular(this.pantalla);
        resul = this.comprobarGrados(resul);
        if(!this.shiftClicked&& !this.hypClicked){
            this.pantalla = this.calcular("Math.tan(" + resul + ")");
        }else if(this.shiftClicked && !this.hypClicked){
            this.pantalla = this.calcular("Math.atan(" + resul + ")");
        } else if(!this.shiftClicked && this.hypClicked){
            this.pantalla = this.calcular("Math.tanh(" + resul + ")");
        }else{
            this.pantalla = this.calcular("Math.atanh(" + resul + ")");
        }
        this.show();
    }

    abrirParentesis() {
        if (this.pantalla != "0") {
            this.limpiaPantalla();
            this.pantalla += "(";
            this.show()
        } else {
            this.limpiaPantalla();
            this.pantalla = "(";
            this.show()
        }
        this.parentesisAbiertos++;
    }

    cerrarParentesis() {
        this.limpiaPantalla();
        this.pantalla += ")"
        this.show();
        this.parentesisAbiertos--;
    }

    base10ex() {
        this.limpiaPantalla();
        if(!this.shiftClicked){
            this.pantalla += "10**"
           
        } else{
            this.pantalla += "Math.E**";
        }
        this.show();
    }

    logaritmo() {
        this.limpiaPantalla();
        if(!this.shiftClicked){
            this.pantalla += "Math.log10(";
        } else{
            this.pantalla += "Math.log(";
        }
        this.parentesisAbiertos++;
        this.show();
    }

    expdms() {
        this.limpiaPantalla();
        if(!this.shiftClicked){
            this.pantalla += "Math.exp(";
            this.parentesisAbiertos++;
        } else{
            var d = Math.trunc(this.pantalla);
            var m = Math.trunc((this.pantalla - d) * 60);
            var s = (this.pantalla - d - m/60) * 3600;
            s=s.toString();
            s = s.replaceAll(".","");
            if(isNaN(d) || isNaN(m) || isNaN(s)){
                this.limpiarPantalla=true;
                this.pantalla = "ERROR"
            } else{
                this.pantalla = d+"."+m+s
            }
            if(isNaN(this.pantalla)){
                this.limpiarPantalla=true;
            }
        }
        
        this.show();
    }

    moddeg() {
        this.limpiaPantalla();
        if(!this.shiftClicked){
            this.pantalla += "%";
        } else{
            var d = Math.trunc(this.pantalla);
            var m = Math.trunc((this.pantalla - d) / 60);
            var s = (this.pantalla - d - m/60) / 3600;
            s=s.toString();
            s = s.replaceAll(".","");
            if(isNaN(d) || isNaN(m) || isNaN(s)){
                this.limpiarPantalla=true;
                this.pantalla = "ERROR"
            } else{
                this.pantalla = d+"."+m+s
            }
            if(isNaN(this.pantalla)){
                this.limpiarPantalla=true;
            }
        }
        
        this.show();
    }



    fe(){
        this.limpiaPantalla();
        var array=this.pantalla.split(".");
        var entero=array[0]
        var decimal=array[1]
        var exp = entero.length-1;
        var factor=10**exp;
        var resultado=this.pantalla/factor
        this.pantalla=resultado+"e+"+exp;
        this.show();

    }

    ce() {
        var regex=/(\d+)/g;
        var string=this.pantalla.match(regex);
        var a=string.toString();
        var digitos=a.split(",");
        var digito=digitos[digitos.length-1]
        var b=this.pantalla.lastIndexOf(digito);
        var c=this.pantalla.substring(0, b);
        this.pantalla=c;
        this.show();
        
    }

    pi() {
        this.limpiaPantalla();
        this.pantalla += "Math.PI"
        this.show();
    }

    exponente() {
        this.limpiaPantalla();
        this.pantalla += "Math.exp("
        this.show();
        this.parentesisAbiertos++;
    }

    comprobarGrados(resul) {
        if (this.deg == true) {
            return this.DegreestoRadians(resul);
        } else if (this.rad == true) {
            return resul;
        } else {
            return this.GradToRadians(resul);
        }
    }

    cambiarMedidaAngulo() {
        if (this.deg == true) {
            this.pantalla = this.DegreestoRadians(this.pantalla);
            this.show(this.pantalla)
            document.getElementById("medidas").value = "RAD";
            this.deg = false;
            this.rad = true;
            this.grad = false;
        } else if (this.rad == true) {
            this.pantalla = this.RadianstoGrad(this.pantalla);
            this.show(this.pantalla);
            document.getElementById("medidas").value = "GRAD";
            this.deg = false;
            this.rad = false;
            this.grad = true;
        } else {
            this.pantalla = this.GradToDegrees(this.pantalla);
            this.show(this.pantalla);
            document.getElementById("medidas").value = "DEG";
            this.deg = true;
            this.rad = false;
            this.grad = false;
        }
    }

    DegreestoRadians(angle) {
        return angle * (Math.PI / 180);
    }

    RadianstoGrad(angle) {
        return angle * (200 / Math.PI)
    }

    GradToDegrees(angle) {
        return angle * 180 / 200;
    }

    GradToRadians(angle) {
        return angle * Math.PI / 200;
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

    hyp(){
        this.hypClicked=!this.hypClicked;
        if(this.hypClicked){
            document.getElementById("hyp").style.backgroundColor='#A5CFED';
        } else{
            document.getElementById("hyp").style.backgroundColor='#E3E2E2';
        }
        this.changeLayout();
    }

    changeLayout(){
        if(this.shiftClicked && !this.hypClicked){
            document.getElementById("potencia").value="x^3";
            document.getElementById("potencia/raiz").value="y√x";
            document.getElementById("seno").value="sin-1";
            document.getElementById("coseno").value="cos-1";
            document.getElementById("tangente").value="tan-1";
            document.getElementById("raiz/x").value="1/x";
            document.getElementById("10xex").value="e^x";
            document.getElementById("log/ln").value="ln";
            document.getElementById("exp/dms").value="dms";
            document.getElementById("mod/deg").value="deg";
        } else if(!this.shiftClicked && !this.hypClicked){
            document.getElementById("potencia").value="x^2";
            document.getElementById("potencia/raiz").value="x^y";
            document.getElementById("seno").value="sin";
            document.getElementById("coseno").value="cos";
            document.getElementById("tangente").value="tan";
            document.getElementById("raiz/x").value="√";
            document.getElementById("10xex").value="10^x";
            document.getElementById("log/ln").value="log";
            document.getElementById("exp/dms").value="Exp";
            document.getElementById("mod/deg").value="Mod";
        } else if(!this.shiftClicked && this.hypClicked){
            document.getElementById("potencia").value="x^2";
            document.getElementById("potencia/raiz").value="x^y";
            document.getElementById("seno").value="sinh";
            document.getElementById("coseno").value="cosh";
            document.getElementById("tangente").value="tanh";
            document.getElementById("raiz/x").value="√";
            document.getElementById("10xex").value="10^x";
            document.getElementById("log/ln").value="log";
            document.getElementById("exp/dms").value="Exp";
            document.getElementById("mod/deg").value="Mod";
        } else{
            document.getElementById("potencia").value="x^3";
            document.getElementById("potencia/raiz").value="y√x";
            document.getElementById("seno").value="sinh-1";
            document.getElementById("coseno").value="cosh-1";
            document.getElementById("tangente").value="tanh-1";
            document.getElementById("raiz/x").value="1/x";
            document.getElementById("10xex").value="e^x";
            document.getElementById("log/ln").value="ln";
            document.getElementById("exp/dms").value="dms";
            document.getElementById("mod/deg").value="deg";
        }
    }
    

}

var calc = new CalculadoraCientifica();

