<!DOCTYPE HTML>

<html lang="es">
<head>
    <!-- Datos que describen el documento, CODIFICACION DE CARACTERES -->
    <meta charset="UTF-8" />
    <title>Calculadora RPN</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name ="author" content ="Lara Fernández Méndez" />
    <meta name ="description" content ="Una calculadora RPN" />
    <meta name ="keywords" content ="calculadora, calculos, RPN, notación postfija, notación polaca inversa" />
    <!--Definición de la ventana gráfica-->
    <meta name ="viewport" content ="width=device-width, initial-scale=1.0" />
    <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="CalculadoraRPN.css" />
</head>

<body>
    <h1>Calculadora RPN</h1>
    <?php
        session_start();

            class CalculadoraRPN {
                private $pantalla;
                private $pila;
                private $valorActual;
                private $shiftClicked;
                private $altPressed;
        

                public function __construct(){
                    $this->pantalla = "";
                    $this->pila = array();
                    $this->valorActual=1;
                    $this->shiftClicked=false;
                    $this->altPressed=false;
                }

                public function getPantalla(){
                    return $this->pantalla;   
               }

               public function apilar(){
                    $number=$this->pantalla;
                    if(!is_nan(floatval($this->pantalla)) && $this->pantalla!=""){
                        array_push($this->pila, $number);
                        $this->pantalla="";
                    }
                }

                public function desapilar(){
                    array_pop($this->pila);
                }
            
               
                public function getPila(){
                    $stringPila="";
                    $pos=count($this->pila);
                    foreach($this->pila as $valor){
                        $stringPila .= "[" . $pos . "]" ."\t\t" .$valor."\n";
                        $pos--;
                    }       
                    return $stringPila;
                }

                public function dígitos($arg) {
                    $this->pantalla.=$arg;
                }

                public function punto() {
                    $this->pantalla .= ".";
                }
            
                public function suma(){
                    if(count($this->pila) >= 2){
                        array_push($this->pila, array_pop($this->pila)+array_pop($this->pila));
                        
                    }
                } 
            
                public function resta(){
                    if(count($this->pila) >= 2){
                        array_push($this->pila, array_pop($this->pila)-array_pop($this->pila));
                        
                    }
                }

                public function multiplicacion() {
                    if(count($this->pila) >= 2){
                        array_push($this->pila, array_pop($this->pila)*array_pop($this->pila));
                    }
                }
            
                public function division() {
                    if(count($this->pila) >= 2){
                        array_push($this->pila, array_pop($this->pila)/array_pop($this->pila));
                    }
                }

                public function borrarTodo() {
                    $this->pantalla = "";
                }
            
                public function borrarDigito() {
                    $this->pantalla = substr($this->pantalla, 0, -1);
                }

                public function cambioSigno() {
                    if($this->pantalla!=""){
                        $this->resultado =  $this->calcular( $this->pantalla);
                        $this->resultado = - $this->resultado;
                        $this->pantalla= $this->calcular( $this->resultado);
                    }
                }

                public function limpiarPila(){
                    $this->pila = Array();
                }

                public function shift(){
                    $this->shiftClicked=!$this->shiftClicked;
                }

                public function isShiftClicked(){
                    return $this->shiftClicked;
                }

                public function seno() {
                    if(count($this->pila)>=1){
                        $numero=array_pop($this->pila);
                        if(!$this->shiftClicked){
                            $resul=sin($numero);
                        } else{
                            $resul=asin($numero);
                        }
                        array_push($this->pila,$resul);
                    }
                }

                public function coseno() {
                    if(count($this->pila)>=1){
                        $numero=array_pop($this->pila);
                        if(!$this->shiftClicked){
                            $resul=cos($numero);
                        } else{
                            $resul=acos($numero);
                        }
                        array_push($this->pila,$resul);
                    }
                }

                public function tangente() {
                    if(count($this->pila)>=1){
                        $numero=array_pop($this->pila);
                        if(!$this->shiftClicked){
                            $resul=tan($numero);
                        } else{
                            $resul=atan($numero);
                        }
                        array_push($this->pila,$resul);
                    }
                }

                public function raiz(){
                    if(count($this->pila)>=1){
                        $numero=array_pop($this->pila);
                        $resul=sqrt($numero);
                        array_push($this->pila,$resul);
                    }
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

            if (!isset($_SESSION['calculadoraRPN']))
			  $_SESSION['calculadoraRPN']=new CalculadoraRPN();
			$calcRPN = $_SESSION['calculadoraRPN'];


            

              if (count($_POST)>0)  {   
                $calcRPN->limpiarPantalla();
                if (isset($_POST['0']))
                    $calcRPN->dígitos(0);
                elseif (isset($_POST['1']))
                    $calcRPN->dígitos(1);
                elseif (isset($_POST['2']))
                    $calcRPN->dígitos(2);
                elseif (isset($_POST['3']))
                    $calcRPN->dígitos(3);                    
                elseif (isset($_POST['4']))
                    $calcRPN->dígitos(4);
                elseif (isset($_POST['5']))
                    $calcRPN->dígitos(5);
                elseif (isset($_POST['6']))
                    $calcRPN->dígitos(6);
                elseif (isset($_POST['7']))
                    $calcRPN->dígitos(7);
                elseif (isset($_POST['8']))
                    $calcRPN->dígitos(8);
                elseif (isset($_POST['9']))
                    $calcRPN->dígitos(9);
                elseif (isset($_POST['c']))
                    $calcRPN->borrarTodo(); 
                elseif (isset($_POST['ce']))
                    $calcRPN->borrarDigito(); 
                elseif (isset($_POST['cambioSigno']))
                    $calcRPN->cambioSigno(); 
                elseif (isset($_POST['raiz']))
                    $calcRPN->raiz(); 
                elseif (isset($_POST['multiplicacion']))
                    $calcRPN->multiplicacion(); 
                elseif (isset($_POST['division']))
                    $calcRPN->division(); 
                elseif (isset($_POST['resta']))
                    $calcRPN->resta(); 
                elseif (isset($_POST['suma']))
                    $calcRPN->suma(); 
                elseif (isset($_POST['punto']))
                    $calcRPN->punto(); 
                elseif (isset($_POST['seno']))
                    $calcRPN->seno(); 
                elseif (isset($_POST['coseno']))
                    $calcRPN->coseno(); 
                elseif (isset($_POST['tangente']))
                    $calcRPN->tangente(); 
                elseif (isset($_POST['shift']))
                    $calcRPN->shift(); 
                elseif (isset($_POST['enter']))
                    $calcRPN->apilar(); 
                elseif (isset($_POST['vaciar']))
                    $calcRPN->limpiarPila(); 
                elseif (isset($_POST['eliminarUlt']))
                    $calcRPN->desapilar(); 
            };

            if($calcRPN->isShiftClicked()){
                $seno = "sin-1";
                $coseno = "cos-1";
                $tangente = "tan-1";
            } else{
                $seno = "sin";
                $coseno = "cos";
                $tangente = "tan";
            }
            

            $pantalla=$_SESSION['calculadoraRPN']->getPantalla();
            
            $pila=$_SESSION['calculadoraRPN']->getPila();

    echo "
    <form action='#' method='post' name='botones'>
        <label for='pila'> RPN </label>
        <textarea rows='7' name='pila' id='pila' disabled readonly>$pila </textarea>
        <label for='resultado'> Número:</label>
        <input type='text' value='$pantalla' id='resultado' disabled readonly/>
        <div>
            <input type = 'submit' class='button' name = 'seno' value = '$seno'/>
            <input type = 'submit' class='button' name = 'coseno' value = '$coseno'/>
            <input type = 'submit' class='button' name = 'tangente' value = '$tangente'/>
            <input type = 'submit' class='button' name = 'shift' value = '↑'/>
        </div>

        <input type = 'submit' class='button' name = '7' value = '7'/>
        <input type = 'submit' class='button' name = '8' value = '8'/>
        <input type = 'submit' class='button' name = '9' value = '9'/>
        <input type = 'submit' class='button' name = 'punto' value = '.'/>
        <input type = 'submit' class='button' name = 'cambioSigno' value = '+/-'/>
        <input type = 'submit' class='button' name = '4' value = '4'/>
        <input type = 'submit' class='button' name = '5' value = '5'/>
        <input type = 'submit' class='button' name = '6' value = '6'/>
        <input type = 'submit' class='button' name = 'multiplicacion' value = 'x'/>
        <input type = 'submit' class='button' name = 'division' value = '/'/>
        <input type = 'submit' class='button' name = '1' value = '1'/>
        <input type = 'submit' class='button' name = '2' value = '2'/>
        <input type = 'submit' class='button' name = '3' value = '3'/>

        <input type = 'submit' class='button' name = 'suma' value = '+'/>
        <input type = 'submit' class='button' name = 'resta' value = '-'/>
        <input type = 'submit' class='button' name = '0' value = '0'/>
        <input type = 'submit' class='button' name = 'enter' value = 'ENTER'/>
        <input type = 'submit' class='button' name = 'c' value = 'C'/>
        <input type = 'submit' class='button' name = 'ce' value = 'CE'/>
        <input type = 'submit' class='button' name = 'vaciar' value = 'Vaciar'/>     
        <input type = 'submit' class='button' name = 'eliminarUlt' value = 'Eliminar últ.'/>     
        <input type = 'submit' class='button' name = 'raiz' value = '√'/>
    </form>
    ";
    ?>
</body>

</html>