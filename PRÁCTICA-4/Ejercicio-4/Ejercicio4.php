<!DOCTYPE HTML>

<html lang="es">
<head>
    <!-- Datos que describen el documento, CODIFICACION DE CARACTERES -->
    <meta charset="UTF-8" />
    <title>PRECIOS PETROLEO - Ej4</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name ="author" content ="Lara Fernández Méndez" />
    <meta name ="description" content ="Una calculadora con funciones científicas" />
    <meta name ="keywords" content ="calculadora, ciencias, matematicas, calculo" />
    <!--Definición de la ventana gráfica-->
    <meta name ="viewport" content ="width=device-width, initial-scale=1.0" />
    <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="Ejercicio4.css" />
</head>

<body>
    <header><h1>PRECIOS DEL PETROLEO</h1></header>
    <?php
    session_start();
        $apikey = "jev68tgz35b69715s9gekh7a8q6ce6ides4yauk0ak8ef09kp6lavnj7ct1c";
        $url = "https://commodities-api.com/api/latest?access_key=".$apikey;
        $datos = file_get_contents($url);
        if($datos==null) {
            echo "<h3>Error en el archivo XML recibido</h3>";
        } else{
            echo "<h2>XML correctamente recibido</h2>";
            echo "<p>".$datos."</p>";
            $json = json_decode($datos);
            if($json==null) {
                echo "<h3>Error en el archivo JSON recibido</h3>";
            }
            else {
                echo "<h3>JSON decodificado correctamente</h3>";
            }
            # Datos contenidos en el JSON

            echo "<h3>PETROLEO BRENT:</h3>";
            echo "<p>".$json->data->rates->BRENTOIL." $ por barril</p>";
            echo "<h3>PETROLEO WTI:</h3>";
            echo "<p>".$json->data->rates->WTIOIL." $ por barril</p>";
        }
      ?>
</body>

</html>