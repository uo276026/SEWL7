<!DOCTYPE HTML>

<html lang="es">
<head>
    <!-- Datos que describen el documento, CODIFICACION DE CARACTERES -->
    <meta charset="UTF-8" />
    <title>Gestión Base de Datos</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name ="author" content ="Lara Fernández Méndez" />
    <meta name ="description" content ="Base de datos de pruebas de usabilidad" />
    <meta name ="keywords" content ="base de datos, bbdd, tablas, usabilidad" />
    <!--Definición de la ventana gráfica-->
    <meta name ="viewport" content ="width=device-width, initial-scale=1.0" />
    <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="Ejercicio6.css" />
</head>

<body>
    <header><h1>Gestión Base de Datos</h1></header>
    <h2>Resultados:</h2>
        <?php
        session_start();
      
        
        class BaseDatos{

            private $servername;
            private $username;
            private $password;
            private $database;

            public function __construct()
            {
                $this->servername = "localhost";
                $this->username = "DBUSER2022";
                $this->password = "DBPSWD2022";
                $this->database = "DataBasePruebasUsabilidad";
            }

            public function crearBaseDatos(){
                $db = new mysqli($this->servername, $this->username, $this->password);
                if ($db->connect_errno) {
                    echo "<p>Error de conexión: " . $db->connect_error."</p>";
                } else {
                    echo "<p>".$db->host_info . "\r\n</p>";
                } 
                $cadenaSQL = "CREATE DATABASE IF NOT EXISTS $this->database COLLATE utf8_spanish_ci";
                if($db->query($cadenaSQL) === TRUE){
                    echo "<p>Base de datos '$this->database' creada con éxito</p>";
                } else { 
                    echo "<p>ERROR en la creación de la Base de Datos '$this->database'. Error: " . $db->error . "</p>";
                    exit();
                }  
                $db->close();
            }

            public function crearTabla(){
                $database = "databasepruebasusabilidad";
                $db = new mysqli($this->servername, $this->username, $this->password);
                $db->select_db($database);
                $crearTabla = "CREATE TABLE IF NOT EXISTS PruebasUsabilidad (id INT NOT NULL AUTO_INCREMENT, 
                        dni VARCHAR(9) NOT NULL,
                        nombre VARCHAR(255) NOT NULL, 
                        apellidos VARCHAR(255) NOT NULL,  
                        email VARCHAR(255) NOT NULL,
                        telefono int not null,
                        edad int not null,
                        sexo VARCHAR(4) NOT NULL,
                        periciaInformatica int NOT NULL,
                        tiempo int not null,
                        tareaRealizada VARCHAR(3) not null,
                        comentarios VARCHAR(255),
                        propuestasMejora VARCHAR(255),
                        valoracion int not null,
                        PRIMARY KEY (id))";
            
                if($db->query($crearTabla) === TRUE){
                    echo "<p>Tabla 'PruebasUsabilidad' creada con éxito </p>";
                } else { 
                    echo "<p>ERROR en la creación de la tabla 'PruebasUsabilidad'. Error : ". $db->error . "</p>";
                    exit();
                }   
                $db->close();
            }

            public function insertarDatos(){
                $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                if($db->connect_error) {
                    exit ("<p>ERROR de conexión:".$db->connect_error."</p>");  
                } else {
                    echo "<p>Conexión establecida.</p>";
                }
                $consultaPre = $db->prepare("INSERT INTO PruebasUsabilidad (dni, nombre, apellidos, email, telefono, edad, 
                sexo, periciaInformatica, tiempo, tareaRealizada, comentarios, propuestasMejora, valoracion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");   
                $consultaPre->bind_param('ssssiisiisssi', 
                        $_POST["dni"],$_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["telefono"], $_POST["edad"], $_POST["sexo"], $_POST["periciaInf"],
                        $_POST["tiempo"], $_POST["tarea"], $_POST["comentarios"], $_POST["mejoras"], $_POST["valoracion"]);    

                $consultaPre->execute();
                echo "<p>Filas agregadas: " . $consultaPre->affected_rows . "</p>";
                $consultaPre->close();
                $db->close();           
            }

            public function modDatos(){
                $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                if($db->connect_error) {
                    exit ("<p>ERROR de conexión:".$db->connect_error."</p>");  
                } else {
                    echo "<p>Conexión establecida.</p>";
                }
                $consultaPre = $db->prepare("UPDATE PruebasUsabilidad SET nombre=?, apellidos=?, email=?, telefono=?, edad=?, sexo=?, periciaInformatica=?,
                 tiempo=?, tareaRealizada=?, comentarios=?, propuestasMejora=?, valoracion=? WHERE dni=?");

                 $consultaPre->bind_param('sssiisiisssis', 
                 $_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["telefono"], $_POST["edad"], $_POST["sexo"], $_POST["periciaInf"],
                 $_POST["tiempo"], $_POST["tarea"], $_POST["comentarios"], $_POST["mejoras"], $_POST["valoracion"], $_POST["dni"]);    

                $consultaPre->execute();
                echo "<p>Filas modificadas: " . $consultaPre->affected_rows . "</p>";
                $consultaPre->close();
                $db->close(); 
            }

            public function eliminarDatos(){
                $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                if($db->connect_error) {
                    exit ("<p>ERROR de conexión:".$db->connect_error."</p>");  
                } else {
                    echo "<p>Conexión establecida.</p>";
                }
                $consultaPre = $db->prepare("DELETE FROM PruebasUsabilidad WHERE dni = ?");   
                $consultaPre->bind_param('s', $_POST["dni"]);    
                $consultaPre->execute();
                echo "<p>Filas eliminadas: " . $consultaPre->affected_rows . "</p>";
                $consultaPre->close();
                
                
            }

            public function mostrarDatos(){
                $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                if($db->connect_error) {
                    exit ("<p>ERROR de conexión:".$db->connect_error."</p>");  
                } else {
                    echo "<p>Conexión establecida.</p>";
                }
                $resultado =  $db->query('SELECT * FROM PruebasUsabilidad');   
                if ($resultado->num_rows > 0) {
                        echo "<p>Los datos en la tabla 'PruebasUsabilidad' son: </p>";
                        echo "<p>Número de filas = " . $resultado->num_rows . "</p>";
                        echo "<table>
                        <thead>
                          <tr>
                            <th> id </th>
                            <th> dni </th>
                            <th> nombre y apellidos </th>
                            <th> email </th>
                            <th> telefono </th>
                            <th> edad </th>
                            <th> sexo </th>
                            <th> pericia informatica </th>
                            <th> tiempo </th>
                            <th> tarea realizada </th>
                            <th> comentarios </th>
                            <th> mejoras </th>
                            <th> valoración </th>
                          </tr>
                          <tbody>";
                        while($row = $resultado->fetch_assoc()) {
                            echo " <tr>
                                <td >".  $row['id']."</td>
                                <td >".  $row['dni'] ."</td>
                                <td >".  $row['nombre']. " " . $row['apellidos'] ."</td>
                                <td >".  $row['email']. "</td>
                                <td >".  $row['telefono'] ."</td>
                                <td >".  $row['edad'] ."</td>
                                <td >".  $row['sexo'] ."</td>
                                <td >".  $row['periciaInformatica'] ."</td>
                                <td >".  $row['tiempo'] ."</td>
                                <td >".  $row['tareaRealizada'] ."</td>
                                <td >".  $row['comentarios'] ."</td>
                                <td >".  $row['propuestasMejora'] ."</td>
                                <td >".  $row['valoracion'] ."</td>
                                </tr>";
                        }
                        echo " </table>";
                    } else {
                        echo "<p>Tabla vacía. Número de filas = " . $resultado->num_rows . "</p>";
                    }          
                $db->close();    
            }

            public function generarInforme(){
                $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                if($db->connect_error) {
                    exit ("<p>ERROR de conexión:".$db->connect_error."</p>");  
                } else {
                    echo "<p>Conexión establecida.</p>";
                }
                $resultado =  $db->query('SELECT * FROM PruebasUsabilidad');   
                if ($resultado->num_rows > 0) {
                    $edades=0;
                    $numMasc=0;
                    $numFem=0;
                    $nivelesPericia=0;
                    $tiempo=0;
                    $tareaBien=0;
                    $puntuacion=0;
                    while($row = $resultado->fetch_assoc()) {
                        $edades+=intval($row['edad']);
                        if($row['sexo']=="masc"){
                            $numMasc+=1;
                        } else{
                            $numFem+=1;
                        }
                        $nivelesPericia+=intval($row['periciaInformatica']);
                        $tiempo+=intval($row['tiempo']);
                        if($row['tareaRealizada']=="si"){
                            $tareaBien+=1;
                        }
                        $puntuacion+=intval($row['valoracion']);
                    }
                    echo "<h3> INFORME ESTADISTICAS </H3>";
                    echo "<p> Media Edades = ".$edades/$resultado->num_rows."</p>";
                    echo "<p> Porcentaje de Mujeres = ".$numFem/$resultado->num_rows*100 . "%</p>";
                    echo "<p> Porcentaje de Hombres = ".$numMasc/$resultado->num_rows*100 . "%</p>";
                    echo "<p> Media Nivel Pericia = ".$nivelesPericia/$resultado->num_rows . "</p>";
                    echo "<p> Media Tiempo Tarea = ".$tiempo/$resultado->num_rows . "</p>";
                    echo "<p> Porcentaje de Tareas Realizadas = ".$tareaBien/$resultado->num_rows*100 . "%</p>";
                    echo "<p> Media Puntuación = ".$puntuacion/$resultado->num_rows . "</p>";
                } else {
                    echo "<p>Tabla vacía. Número de filas = " . $resultado->num_rows . "</p>";
                } 
                $db->close();    
            }


            public function buscarDatos(){
                $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                if($db->connect_error) {
                    exit ("<p>ERROR de conexión:".$db->connect_error."</p>");  
                } else {
                    echo "<p>Conexión establecida.</p>";
                }
                $consultaPre = $db->prepare("SELECT * FROM PruebasUsabilidad WHERE dni = ?");   
                $consultaPre->bind_param('s', $_POST["dni"]);    
                $consultaPre->execute();
                $resultado = $consultaPre->get_result();

                if ($resultado->fetch_assoc()!=NULL) {
                    echo "<p>Las filas de la tabla 'PruebasUsabilidad' que coinciden con la búsqueda son:</p>";
                    $resultado->data_seek(0); 
                    echo "<table>
                        <thead>
                          <tr>
                            <th> id </th>
                            <th> dni </th>
                            <th> nombre y apellidos </th>
                            <th> email </th>
                            <th> telefono </th>
                            <th> edad </th>
                            <th> sexo </th>
                            <th> pericia informatica </th>
                            <th> tiempo </th>
                            <th> tarea realizada </th>
                            <th> comentarios </th>
                            <th> mejoras </th>
                            <th> valoración </th>
                          </tr>
                          <tbody>";
                    while($row = $resultado->fetch_assoc()) {
                        echo " <tr>
                        <td >".  $row['id']."</td>
                        <td >".  $row['dni'] ."</td>
                        <td >".  $row['nombre']. " " . $row['apellidos'] ."</td>
                        <td >".  $row['email']. "</td>
                        <td >".  $row['telefono'] ."</td>
                        <td >".  $row['edad'] ."</td>
                        <td >".  $row['sexo'] ."</td>
                        <td >".  $row['periciaInformatica'] ."</td>
                        <td >".  $row['tiempo'] ."</td>
                        <td >".  $row['tareaRealizada'] ."</td>
                        <td >".  $row['comentarios'] ."</td>
                        <td >".  $row['propuestasMejora'] ."</td>
                        <td >".  $row['valoracion'] ."</td>
                        </tr>";
                    }
                echo " </table>";                 
                } else {
                    echo "<p>Búsqueda sin resultados</p>";
                }
        
                $consultaPre->close();
                $db->close();     
            }
            public function exportarDatosCSV(){
                $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                if($db->connect_error) {
                    exit ("<p>ERROR de conexión:".$db->connect_error."</p>");  
                } else {
                    echo "<p>Conexión establecida.</p>";
                }
                
                $filename = "PruebasUsabilidad.csv";
                $fp = fopen($filename, 'w');
                $resultado =  $db->query('SELECT * FROM PruebasUsabilidad');   
                if ($resultado->num_rows > 0) {
                        echo "<p>Número de filas = " . $resultado->num_rows . "</p>";
                        while($row = $resultado->fetch_assoc()) {
                            fputcsv($fp, $row, ";");
                        }
                        echo "<p> Datos correctamente exportados </p>";
                    } else {
                        echo "<p>Tabla vacía. Número de filas = " . $resultado->num_rows . "</p>";
                    }          
                $db->close();  
                fclose($fp);  
            }

            public function cargarCSV(){
                $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                if($db->connect_error) {
                    exit ("<p>ERROR de conexión:".$db->connect_error."</p>");  
                } else {
                    echo "<p>Conexión establecida.</p>";
                }
                
                if($_FILES["archivo"]==null){
                   echo "<p>Ningún archivo seleccionado.</p>";
                } else{
                    echo "<p>Archivo seleccionado: ".$_FILES["archivo"]["name"] ."</p>";
                    if(substr($_FILES['archivo']['name'], -4)==".csv"){
                        $filename = $_FILES['archivo']['tmp_name'];
                        $handle = fopen($filename, "r");
                        while( ($data = fgetcsv($handle, 1000, ";") ) !== FALSE ){
                            if($data[0]!="" && $data[0]!=null){
                                $consultaPre = $db->prepare("INSERT INTO PruebasUsabilidad (id, dni, nombre, apellidos, email, telefono, edad, 
                                sexo, periciaInformatica, tiempo, tareaRealizada, comentarios, propuestasMejora, valoracion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");   
                                $consultaPre->bind_param('sssssiisiisssi', 
                                        $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $data[10], $data[11], $data[12],  $data[13]);    

                                $consultaPre->execute();
                                $consultaPre->close();   
                            }
                        }   
                        echo "<p>Los datos se han subido correctamente</p>";
                    } else {
                        echo "<p>El archivo no es un CSV</p>";
                    }
                }
                $db->close();      
            }
    }

       
        $dataBase = new BaseDatos();
        if (count($_POST)>0)  {
            if (isset($_POST['crearBaseDatos']))
                $dataBase->crearBaseDatos();
            if (isset($_POST['crearTabla']))
                $dataBase->crearTabla();
            if (isset($_POST['insertarDatos']))
                $dataBase->insertarDatos();
            if (isset($_POST['modDatos']))
                $dataBase->modDatos();
            if (isset($_POST['eliminarDatos']))
                $dataBase->eliminarDatos();
            if (isset($_POST['mostrarDatos']))
                $dataBase->mostrarDatos();
            if (isset($_POST['generarInforme']))
                $dataBase->generarInforme();
            if (isset($_POST['buscarDatos']))
                $dataBase->buscarDatos();
            if (isset($_POST['exportarDatosCSV']))
                $dataBase->exportarDatosCSV();
            if (isset($_POST['cargarCSV']))
                $dataBase->cargarCSV();

                
                
        }        
        
    echo "  
    <form action='#' method='post' enctype='multipart/form-data'>
        <h2>Opciones</h2>
        <p><input type = 'submit' class='button' name = 'crearBaseDatos' value = 'Crear Base de Datos'/></p>
        <p><input type = 'submit' class='button' name = 'crearTabla' value = 'Crear una tabla'/></p>
        <p><input type = 'submit' class='button' name = 'mostrarDatos' value = 'Mostrar contenido de tabla'/></p>
        <p><input type = 'submit' class='button' name = 'generarInforme' value = 'Generar informe'/></p>
        <h2>Cargar datos desde un archivo CSV a la tabla</h2>
        <p><input type='file' name='archivo'></p>
        <p><input type = 'submit' class='button' name = 'cargarCSV' value = 'Subir CSV'/></p>
        <h2>Exportar datos de la tabla a un archivo PruebasUsabilidad.csv </h2>
        <input type = 'submit' class='button' name = 'exportarDatosCSV' value = 'Exportar datos CSV'/>
    
    </form>

    <form action='#' method='post'>
        <h2>Buscar datos en tabla</h2>
        <label>DNI de prueba a buscar : <input type='text' name='dni' required></label>
        <p><input type = 'submit' class='button' name = 'buscarDatos' value = 'Buscar datos'/></p>
    </form>

    <form action='#' method='post'>
        <h2>Insertar datos a tabla</h2>
        <h3>Datos de persona que realiza la prueba:</h3>
        <label>DNI: <input type='text' name='dni' required></label>
        <label>Nombre: <input type='text' name='nombre' required></label>
        <label>Apellidos: <input type='text' name='apellidos' required></label>
        <label>Email: <input type='text' name='email' required></label>
        <label>Telefono: <input type='number' name='telefono' min='0' max='99999999999' required></label>
        <label>Edad: <input type='number' name='edad' min='0' max='150' required></label>
        <fieldset>
        <legend> Sexo: </legend>
        <p><label for='masc1'>Masculino</label> <input id='masc1' type='radio' value='masc' name='sexo' required/></p>
        <p><label for='fem1'>Femenino</label> <input id='fem1' type='radio' value='fem' name='sexo' required/></p>
        </fieldset>
        <label>Pericia Informática: <input type='number' name='periciaInf' min='0' max='10' required></label>
        <label>Tiempo en segundos: <input type='number' name='tiempo' min='0' max='99999999' required></label>
        <fieldset>
        <legend> ¿Ha realizado la tarea correctamente? </legend>
        <p><label for='si1'>Sí</label> <input id='si1' type='radio' name='tarea' value='si' required/></p>
        <p><label for='no1'>No</label> <input id='no1' type='radio' name='tarea' value='no' required/></p>
        </fieldset>
        <label>Comentarios: <input type='text' name='comentarios'></label>
        <label>Propuestas de mejoras: <input type='text' name='mejoras'></label>
        <label>Valoración de Aplicación: <input type='number' name='valoracion' min='0' max='10' required></label>
        <p><input type = 'submit' class='button' name = 'insertarDatos' value = 'Insertar datos en tabla'/></p>
    </form>

    <form action='#' method='post'>
        <h2>Modificar datos de tabla</h2>
        <label>DNI de prueba a modificar : <input type='text' name='dni' required></label>
        <label>Nombre: <input type='text' name='nombre' required></label>
        <label>Apellidos: <input type='text' name='apellidos' required></label>
        <label>Email: <input type='text' name='email' required></label>
        <label>Telefono: <input type='number' name='telefono' min='0' max='99999999999' required></label>
        <label>Edad: <input type='number' name='edad' min='0' max='150' required></label>
        <fieldset>
        <legend> Sexo: </legend>
        <p><label for='masc2'>Masculino</label> <input id='masc2' type='radio' value='masc' name='sexo' required/></p>
        <p><label for='fem2'>Femenino</label> <input id='fem2' type='radio' value='fem' name='sexo' required/></p>
        </fieldset>
        <label>Pericia Informática: <input type='number' name='periciaInf' min='0' max='10' required></label>
        <label>Tiempo en segundos: <input type='number' name='tiempo' min='0' max='99999999'></label>
        <fieldset>
        <legend> ¿Ha realizado la tarea correctamente? </legend>
        <p><label for='si2'>Sí</label> <input id='si2' type='radio' name='tarea' value='si' required/></p>
        <p><label for='no2'>No</label> <input id='no2' type='radio' name='tarea' value='no' required/></p>
        </fieldset>
        <label>Comentarios: <input type='text' name='comentarios'></label>
        <label>Propuestas de mejoras: <input type='text' name='mejoras'></label>
        <label>Valoración de Aplicación: <input type='number' name='valoracion' min='0' max='10' required></label>
        <p><input type = 'submit' class='button' name = 'modDatos' value = 'Modificar datos en tabla'/></p>
    </form>

    <form action='#' method='post'>
        <h2>Eliminar datos de tabla</h2>
        <label>DNI de prueba a eliminar : <input type='text' name='dni' required></label>
        <p><input type = 'submit' class='button' name = 'eliminarDatos' value = 'Eliminar datos de una tabla'/></p>
    </form>
    ";
    
    ?>
</body>

</html>