
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

var calc = new Calculadora();

