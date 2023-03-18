<!DOCTYPE HTML>

<html lang="es">
<head>
    <!-- Datos que describen el documento, CODIFICACION DE CARACTERES -->
    <meta charset="UTF-8" />
    <title>Calculadora Básica</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name ="author" content ="Lara Fernández Méndez" />
    <meta name ="description" content ="Una calculadora con funciones básicas" />
    <meta name ="keywords" content ="calculadora, calculos" />
    <!--Definición de la ventana gráfica-->
    <meta name ="viewport" content ="width=device-width, initial-scale=1.0" />
    <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="CalculadoraMilan.css" />
</head>

<body>
    <h1>Calculadora Básica</h1>
        <?php
        session_start();

            class Calculadora {

                private $pantalla;
                private $memoria;

                public function __construct(){
                    $this->pantalla = "";
                    $this->memoria = 0;
                }

                public function getPantalla(){
                    return $this->pantalla;   
               }

               public function setPantalla($arg){
                $this->pantalla=$arg;   
           }

                public function dígitos($arg) { 
                    $this->pantalla .= $arg;
                }

                public function borrarTodo() {
                    $this->pantalla = "";
                }

                public function borrarDigito() {
                    $this->pantalla = substr($this->pantalla, 0, -1);
                }

                public function division() {
                    $this->pantalla .= "/";
                }

                public function punto() {
                    $this->pantalla .= ".";
                }
            
                public function suma() {
                    $this->pantalla .= "+";
                }
            
                public function resta() {
                    $this->pantalla .= "-";
                }
            
                public function multiplicacion() {
                    $this->pantalla .= "*";
                }

                public function mrc() {
                    $this->pantalla = $this->memoria;
                }

                public function mMenos() {
                    if ($this->pantalla != "") {
                        $this->memoria = $this->memoria -  $this->calcular( $this->pantalla);
                    }
            
                }
            
                public function mMas() {
                    if ($this->pantalla != "") {
                        $this->memoria = $this->memoria +  $this->calcular( $this->pantalla);
                    }
                }

                public function porcentaje() {
                    $this->pantalla .= "/100";
                }
            
                public function igual() {
                    $this->pantalla = $this->calcular($this->pantalla);
                }

                public function raiz() {
                    $this->resultado= $this->calcular( $this->pantalla);
                    if ($this->resultado>=0)
                        $this->pantalla=sqrt( $this->calcular( $this->pantalla));
                    else    
                        $this->pantalla="ERROR";
                }
            
                public function cambioSigno() {
                    $this->resultado =  $this->calcular( $this->pantalla);
                    $this->resultado = - $this->resultado;
                    $this->pantalla= $this->calcular( $this->resultado);
                }
              
            

                protected function calcular($operacion) {
                    try {
                        return eval("return $operacion;");
                    } catch (Exception $e) {
                        $this->pantalla="ERROR";
                    }
                }

                public function limpiarPantalla(){
                    if($this->getPantalla()=="ERROR"){
                        $this->setPantalla("");
                      }
                }
            

            }


            if (!isset($_SESSION['calculadora']))
			  $_SESSION['calculadora']=new Calculadora();
			$calc = $_SESSION['calculadora'];

            if (count($_POST)>0)  {
                $calc->limpiarPantalla();
                if (isset($_POST['0']))
                    $calc->dígitos(0);
                elseif (isset($_POST['1']))
                    $calc->dígitos(1);
                elseif (isset($_POST['2']))
                    $calc->dígitos(2);
                elseif (isset($_POST['3']))
                    $calc->dígitos(3);                    
                elseif (isset($_POST['4']))
                    $calc->dígitos(4);
                elseif (isset($_POST['5']))
                    $calc->dígitos(5);
                elseif (isset($_POST['6']))
                    $calc->dígitos(6);
                elseif (isset($_POST['7']))
                    $calc->dígitos(7);
                elseif (isset($_POST['8']))
                    $calc->dígitos(8);
                elseif (isset($_POST['9']))
                    $calc->dígitos(9);
                elseif (isset($_POST['c']))
                    $calc->borrarTodo(); 
                elseif (isset($_POST['ce']))
                    $calc->borrarDigito(); 
                elseif (isset($_POST['cambioSigno']))
                    $calc->cambioSigno(); 
                elseif (isset($_POST['raiz']))
                    $calc->raiz(); 
                elseif (isset($_POST['porcentaje']))
                    $calc->porcentaje(); 
                elseif (isset($_POST['multiplicacion']))
                    $calc->multiplicacion(); 
                elseif (isset($_POST['division']))
                    $calc->division(); 
                elseif (isset($_POST['resta']))
                    $calc->resta(); 
                elseif (isset($_POST['mrc']))
                    $calc->mrc(); 
                elseif (isset($_POST['suma']))
                    $calc->suma(); 
                elseif (isset($_POST['mMenos']))
                    $calc->mMenos(); 
                elseif (isset($_POST['punto']))
                    $calc->punto(); 
                elseif (isset($_POST['igual']))
                    $calc->igual(); 
                elseif (isset($_POST['mMas']))
                    $calc->mMas(); 
            };

            $pantalla=$_SESSION['calculadora']->getPantalla();
            
        
    echo "  
    <form action='#' method='post' name='botones'>
        <label for='resultado'>nata by Milan</label>
        <input type='text' value='$pantalla' id='resultado' disabled readonly>
        <input type = 'submit' class='button' name = 'c' value = 'C'/>
        <input type = 'submit' class='button' name = 'ce' value = 'CE'/>
        <input type = 'submit' class='button' name = 'cambioSigno' value = '+/-'/>
        <input type = 'submit' class='button' name = 'raiz' value = '√'/>
        <input type = 'submit' class='button' name = 'porcentaje' value = '%'/>
        <input type = 'submit' class='button' name = '7' value = '7'/>
        <input type = 'submit' class='button' name = '8' value = '8'/>
        <input type = 'submit' class='button' name = '9' value = '9'/>
        <input type = 'submit' class='button' name = 'multiplicacion' value = 'x'/>
        <input type = 'submit' class='button' name = 'division' value = '/'/>
        <input type = 'submit' class='button' name = '4' value = '4'/>
        <input type = 'submit' class='button' name = '5' value = '5'/>
        <input type = 'submit' class='button' name = '6' value = '6'/>
        <input type = 'submit' class='button' name = 'resta' value = '-'/>
        <input type = 'submit' class='button' name = 'mrc' value = 'Mrc'/>
        <input type = 'submit' class='button' name = '1' value = '1'/>
        <input type = 'submit' class='button' name = '2' value = '2'/>
        <input type = 'submit' class='button' name = '3' value = '3'/>
        <input type = 'submit' class='button' name = 'suma' value = '+'/>
        <input type = 'submit' class='button' name = 'mMenos' value = 'M-'/>
        <input type = 'submit' class='button' name = '0' value = '0'/>
        <input type = 'submit' class='button' name = 'punto' value = '.'/>
        <input type = 'submit' class='button' name = 'igual' value = '='/>
        <input type = 'submit' class='button' name = 'mMas' value = 'M+'/>
    </form>
    ";
    
    ?>
</body>

</html>