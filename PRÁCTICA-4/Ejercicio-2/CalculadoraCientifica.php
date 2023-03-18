<!DOCTYPE HTML>

<html lang="es">
<head>
    <!-- Datos que describen el documento, CODIFICACION DE CARACTERES -->
    <meta charset="UTF-8" />
    <title>Calculadora Científica</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name ="author" content ="Lara Fernández Méndez" />
    <meta name ="description" content ="Una calculadora con funciones científicas" />
    <meta name ="keywords" content ="calculadora, ciencias, matematicas, calculo" />
    <!--Definición de la ventana gráfica-->
    <meta name ="viewport" content ="width=device-width, initial-scale=1.0" />
    <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="CalculadoraCientifica.css" />
</head>

<body>
    <h1>Calculadora Científica</h1>
    <?php
    session_start();

            class CalculadoraMilan {

                protected $pantalla;
                protected $memoria;

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
                        $this->resul=eval("return $operacion;");
                        return $this->resul;
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

            class CalculadoraCientifica extends CalculadoraMilan {

                private $parentesisAbiertos;
                private $shiftClicked;
                private $hypClicked;
                private $deg;
                private $anguloActual;

                public function __construct (){
                    parent::__construct();
                    $this->parentesisAbiertos = 0;
                    $this->shiftClicked=false;
                    $this->hypClicked=false;
                    $this->anguloActual = "DEG";  
                }


                //NUEVOS METODOS
                public function mc() {
                    $this->memoria = 0;
                }  

                public function mr() {
                    $this->mrc();
                }
                
                public function ms() {
                    $this->resultado = '0';
                    if ($this->pantalla != "") {
                        $this->resultado = $this->calcular($this->pantalla);
                    }
                    $this->memoria = $this->resultado;
                }

                public function elevar2y3() {
                    if(! $this->shiftClicked){
                        $this->pantalla .= "**2";
                       
                    } else{
                        $this->pantalla .= "**3";
                    }  
                }

                public function elevaryPotenciaY() {
                    if(!$this->shiftClicked){
                        $this->pantalla .= "**";
                    } else{
                        $this->pantalla .= "**(1/";
                        //$this->parentesisAbiertos++;
                    }
                }

                public function raiz() {
                    $this->resultado= $this->calcular( $this->pantalla);
                    if($this->shiftClicked){
                        $this->pantalla="1/". $this->resultado;
                    } else{
                        if ($this->resultado>=0)
                            $this->pantalla=sqrt( $this->calcular( $this->pantalla));
                        else    
                            $this->pantalla="ERROR";
                    }
                  
                }

                public function seno() {
                    $this->resul = $this->calcular($this->pantalla);
                    $this->resul = $this->comprobarGrados($this->resul);
                    if(!$this->shiftClicked && !$this->hypClicked){
                        $this->pantalla = $this->calcular(sin($this->resul));
                    }else if($this->shiftClicked && !$this->hypClicked){
                        $this->pantalla = $this->calcular(asin($this->resul));
                    } else if(!$this->shiftClicked && $this->hypClicked){
                        $this->pantalla = $this->calcular(sinh($this->resul));
                    }else{
                        $this->pantalla = $this->calcular(asinh($this->resul));
                    }
                }

                public function coseno() {
                    $this->resul = $this->calcular($this->pantalla);
                    $this->resul = $this->comprobarGrados($this->resul);
                    if(!$this->shiftClicked&& !$this->hypClicked){
                        $this->pantalla = $this->calcular(cos($this->resul));
                    }else if($this->shiftClicked && !$this->hypClicked){
                        $this->pantalla = $this->calcular(acos($this->resul));
                    } else if(!$this->shiftClicked && $this->hypClicked){
                        $this->pantalla = $this->calcular(cosh($this->resul));
                    }else{
                        $this->pantalla = $this->calcular(acosh($this->resul));
                    }
                }

                public function tangente() {
                    $this->resul = $this->calcular($this->pantalla);
                    $this->resul = $this->comprobarGrados($this->resul);
                    if(!$this->shiftClicked&& !$this->hypClicked){
                        $this->pantalla = $this->calcular(tan($this->resul));
                    }else if($this->shiftClicked && !$this->hypClicked){
                        $this->pantalla = $this->calcular(atan($this->resul));
                    } else if(!$this->shiftClicked && $this->hypClicked){
                        $this->pantalla = $this->calcular(tanh($this->resul));
                    }else{
                        $this->pantalla = $this->calcular(atanh($this->resul));
                    }
                }

                public function comprobarGrados($resul) {
                    if ($this->anguloActual == "DEG") {
                        return $this->DegreestoRadians($resul);
                    } else if ($this->anguloActual == "RAD") {
                        return $resul;
                    } else {
                        return $this->GradToRadians($resul);
                    }
                }

                public function  DegreestoRadians($angle) {
                    return $angle * (pi() / 180);
                }
            
                public function RadianstoGrad($angle) {
                    return $angle * (200 / pi());
                }
            
                public function GradToDegrees($angle) {
                    return $angle * 180 / 200;
                }
            
                public function GradToRadians($angle) {
                    return $angle * pi() / 200;
                }

                public function abrirParentesis() {
                    if ($this->pantalla != "0") {
                        $this->pantalla .= "(";
                    } else {
                        $this->pantalla = "(";
                    }
                    //$this->parentesisAbiertos++;
                }

                public function cerrarParentesis() {
                    $this->pantalla .= ")";
                    //$this->parentesisAbiertos--;
                }
            
                public function base10ex() {
                    if(!$this->shiftClicked){
                        $this->pantalla .= "10**";
                       
                    } else{
                        $this->pantalla .= exp(1);
                        $this->pantalla .= "**";
                    }
                }
            
                public function logaritmo() {
                    if(!$this->shiftClicked){
                        $this->pantalla .= "log10(";
                    } else{
                        $this->pantalla .= "log(";
                    }
                    //$this->parentesisAbiertos++;
                }

                public function expdms() {
                    if(!$this->shiftClicked){
                        $this->pantalla .= "exp(";
                        //$this->parentesisAbiertos++;
                    } else{
                        $d = intval($this->pantalla);
                        $m = intval((floatval($this->pantalla) -  $d) * 60);
                        $s = (floatval($this->pantalla) -  $d - $m/60) * 3600;
                        $s=strval($s);
                        $s =str_replace($s,".","");
                        if(is_nan( floatval($d)) || is_nan( floatval($m)) || is_nan( floatval($s))){
                            $this->pantalla = "ERROR";
                        } else{
                            $this->pantalla =  $d.".". $m. $s;
                        }
                    }
                }

                public function moddeg() {
                    if(!$this->shiftClicked){
                        $this->pantalla .= "%";
                    } else{
                        $d = intval($this->pantalla);
                        $m = intval((floatval($this->pantalla) - $d) / 60);
                        $s = (floatval($this->pantalla) - $d - $m/60) / 3600;
                        $s= strval($s);
                        $s=str_replace($s,".","");
                        if(is_nan(floatval($d)) || is_nan(floatval($m)) || is_nan(floatval($s))){
                            $this->pantalla = "ERROR";
                        } else{
                            $this->pantalla = $d.".".$m.$s;
                        }
                    }
                    
                }

                public function fe(){
                    $array=explode(".", $this->pantalla);
                    if(is_null($array[1])){
                        $this->pantalla="ERROR";
                    } else {
                        $entero=$array[0];
                        $decimal=$array[1];
                        $exp = strlen($entero)-1;
                        $factor=10**$exp;
                        $resultado=$this->pantalla/$factor;
                        $this->pantalla=(string)$resultado."e+".(string)$exp;
                    }
                }
            
                public function pi() {
                    $this->pantalla += pi();
                }
            
                public function cambiarMedidaAngulo() {
                    if ( $this->anguloActual == "DEG"  ) {
                        $this->anguloActual = "RAD"; 
                    } else if ( $this->anguloActual == "RAD") {
                        $this->anguloActual = "GRAD";
                    } else {
                        $this->anguloActual = "DEG";
                    }
                }

                public function getAnguloActual(){
                    return $this->anguloActual;
                }

                public function shift(){
                    $this->shiftClicked=!$this->shiftClicked;
                }

                public function isShiftClicked(){
                    return $this->shiftClicked;
                }


                public function hyp(){
                    $this->hypClicked =!$this->hypClicked;
                }
            
                public function isHypClicked(){
                    return $this->hypClicked;
                }
            
            }

            if (!isset($_SESSION['calculadoraCientifica']))
			  $_SESSION['calculadoraCientifica']=new CalculadoraCientifica();
		    $calcCient = $_SESSION['calculadoraCientifica'];

            

            if (count($_POST)>0)  {
                $calcCient->limpiarPantalla();
                if (isset($_POST['0']))
                    $calcCient->dígitos(0);
                elseif (isset($_POST['1']))
                    $calcCient->dígitos(1);
                elseif (isset($_POST['2']))
                    $calcCient->dígitos(2);
                elseif (isset($_POST['3']))
                    $calcCient->dígitos(3);                    
                elseif (isset($_POST['4']))
                    $calcCient->dígitos(4);
                elseif (isset($_POST['5']))
                    $calcCient->dígitos(5);
                elseif (isset($_POST['6']))
                    $calcCient->dígitos(6);
                elseif (isset($_POST['7']))
                    $calcCient->dígitos(7);
                elseif (isset($_POST['8']))
                    $calcCient->dígitos(8);
                elseif (isset($_POST['9']))
                    $calcCient->dígitos(9);
                elseif (isset($_POST['c']))
                    $calcCient->borrarTodo(); 
                elseif (isset($_POST['cambioSigno']))
                    $calcCient->cambioSigno(); 
                elseif (isset($_POST['raiz']))
                    $calcCient->raiz(); 
                elseif (isset($_POST['porcentaje']))
                    $calcCientCient->porcentaje(); 
                elseif (isset($_POST['multiplicacion']))
                    $calcCient->multiplicacion(); 
                elseif (isset($_POST['division']))
                    $calcCient->division(); 
                elseif (isset($_POST['resta']))
                    $calcCient->resta(); 
                elseif (isset($_POST['mrc']))
                    $calcCient->mrc(); 
                elseif (isset($_POST['suma']))
                    $calcCient->suma(); 
                elseif (isset($_POST['mMenos']))
                    $calcCient->mMenos(); 
                elseif (isset($_POST['punto']))
                    $calcCient->punto(); 
                elseif (isset($_POST['igual']))
                    $calcCient->igual(); 
                elseif (isset($_POST['mMas']))
                    $calcCient->mMas(); 
                elseif (isset($_POST['mc']))
                    $calcCient->mc(); 
                elseif (isset($_POST['mr']))
                    $calcCient->mr(); 
                elseif (isset($_POST['ms']))
                    $calcCient->ms(); 
                elseif (isset($_POST['potencia2']))
                    $calcCient->elevar2y3(); 
                elseif (isset($_POST['potencia/raiz']))
                    $calcCient->elevaryPotenciaY(); 
                elseif (isset($_POST['seno']))
                    $calcCient->seno(); 
                elseif (isset($_POST['coseno']))
                    $calcCient->coseno(); 
                elseif (isset($_POST['tangente']))
                    $calcCient->tangente(); 
                elseif (isset($_POST['(']))
                    $calcCient->abrirParentesis(); 
                elseif (isset($_POST[')']))
                    $calcCient->cerrarParentesis(); 
                elseif (isset($_POST['10xex']))
                    $calcCient->base10ex(); 
                elseif (isset($_POST['log/ln']))
                    $calcCient->logaritmo(); 
                elseif (isset($_POST['exp/dms']))
                    $calcCient->expdms();
                elseif (isset($_POST['mod/deg']))
                    $calcCient->moddeg();
                elseif (isset($_POST['fe']))
                    $calcCient->fe();
                elseif (isset($_POST['pi']))
                    $calcCient->pi();
                elseif (isset($_POST['eliminarUno']))
                    $calcCient->borrarDigito();
                elseif (isset($_POST['medidas']))
                    $calcCient->cambiarMedidaAngulo();
                elseif (isset($_POST['shift']))
                    $calcCient->shift();
                elseif (isset($_POST['hyp']))
                    $calcCient->hyp();
            };

            if($calcCient->isShiftClicked() && !$calcCient->isHypClicked()){
                $potencia2="x^3";
                $potenciay="y√x";
                $seno="sin-1";
                $coseno="cos-1";
                $tangente="tan-1";
                $raiz="1/x";
                $ex="e^x";
                $log="ln";
                $exp="dms";
                $mod="deg";
            } else if(!$calcCient->isShiftClicked() && !$calcCient->isHypClicked()){
                $potencia2="x^2";
                $potenciay="x^y";
                $seno="sin";
                $coseno="cos";
                $tangente="tan";
                $raiz="√";
                $ex="10^x";
                $log="log";
                $exp="Exp";
                $mod="Mod";
            } else if(!$calcCient->isShiftClicked() && $calcCient->isHypClicked()){
                $potencia2="x^2";
                $potenciay="x^y";
                $seno="sinh";
                $coseno="cosh";
                $tangente="tanh";
                $raiz="√";
                $ex="10^x";
                $log="log";
                $exp="Exp";
                $mod="Mod";
            } else{
                $potencia2="x^3";
                $potenciay="y√x";
                $seno="sinh-1";
                $coseno="cosh-1";
                $tangente="tanh-1";
                $raiz="1/x";
                $ex="e^x";
                $log="ln";
                $exp="dms";
                $mod="deg";
            }
            
            $pantalla=$_SESSION['calculadoraCientifica']->getPantalla();
            $anguloActual=$_SESSION['calculadoraCientifica']->getAnguloActual();
            
        
    echo "
    <form action='#' method='post' name='botones'>
        <label for='resultado'> Científica</label>
        <input type='text' value='$pantalla' id='resultado' disabled readonly>

        <div>
            <input type='submit' class='button' name='medidas' value='$anguloActual' />
            <input type='submit' class='button' name='hyp' value='HYP'/>
            <input type='submit' class='button' name='fe' value='F-E'/>
        </div>

        <input type='submit' class='button' name='mc' value='MC'/>
        <input type='submit' class='button' name='mr' value='MR'/>
        <input type='submit' class='button' name='mMenos' value='M-'/>
        <input type='submit' class='button' name='mMas' value='M+'/>
        <input type='submit' class='button' name='ms' value='MS'/>

        <input type='submit' class='button' name='potencia2' value='$potencia2'/>
        <input type='submit' class='button' name='potencia/raiz' value='$potenciay' />
        <input type='submit' class='button' name='seno' value='$seno' />
        <input type='submit' class='button' name='coseno' value='$coseno' />
        <input type='submit' class='button' name='tangente' value='$tangente' />
        <input type='submit' class='button' name='raiz' value='$raiz' />
        <input type='submit' class='button' name='10xex' value='$ex' />
        <input type='submit' class='button' name='log/ln' value='$log' />
        <input type='submit' class='button' name='exp/dms' value='$exp' />
        <input type='submit' class='button' name='mod/deg' value='$mod' />
        <input type='submit' class='button' name='shift' value='↑' />
        <input type='submit' class='button' name='ce' value='CE' />
        <input type='submit' class='button' name='c' value='C'/>
        <input type='submit' class='button' name='eliminarUno' value='⌫' />
        <input type='submit' class='button' name='division' value='/'/>
        <input type='submit' class='button' name='pi' value='π' />
        <input type='submit' class='button' name='7' value='7' />
        <input type='submit' class='button' name='8' value='8' />
        <input type='submit' class='button' name='9' value='9' />
        <input type='submit' class='button' name='multiplicacion' value='x' />
        <input type='submit' class='button' name='n!' value='n!' />
        <input type='submit' class='button' name='4' value='4' />
        <input type='submit' class='button' name='5' value='5' />
        <input type='submit' class='button' name='6' value='6' />
        <input type='submit' class='button' name='resta' value='-' />
        <input type='submit' class='button' name = 'cambioSigno' value = '+/-'/>
        <input type='submit' class='button' name='1' value='1' />
        <input type='submit' class='button' name='2' value='2' />
        <input type='submit' class='button' name='3' value = '3'/>
        <input type='submit' class='button' name='suma' value='+' />
        <input type='submit' class='button' name='(' value='(' />
        <input type='submit' class='button' name=')' value=')' />
        <input type='submit' class='button' name='0' value='0' />
        <input type='submit' class='button' name='punto' value=',' />
        <input type='submit' class='button' name='igual' value='=' />
 
    </form> 
    ";
      ?>
</body>

</html>