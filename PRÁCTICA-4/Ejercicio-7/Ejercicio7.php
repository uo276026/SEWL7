<!DOCTYPE HTML>

<html lang="es">
<head>
    <!-- Datos que describen el documento, CODIFICACION DE CARACTERES -->
    <meta charset="UTF-8" />
    <title>Videoclub</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name ="author" content ="Lara Fernández Méndez" />
    <meta name ="description" content ="Un videoclub para alquilar peliculas" />
    <meta name ="keywords" content ="videoclub, bbdd, peliculas" />
    <!--Definición de la ventana gráfica-->
    <meta name ="viewport" content ="width=device-width, initial-scale=1.0" />
    <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="Ejercicio7.css" />
</head>

<body>
    <header><h1>Videoclub</h1></header>
    <p></p>
    <h2>Resultados:</h2>
        <?php
        session_start();
      
        
        class BaseDatos{

            private $servername;
            private $username;
            private $password;
            private $database;
            private $tablesCreated;

            public function __construct()
            {
                $this->servername = "localhost";
                $this->username = "DBUSER2022";
                $this->password = "DBPSWD2022";
                $this->database = "Videoclub";
                $this->tablesCreated=false;
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

            public function crearTablas(){
                try{
                    $this->crearTablaUsuario();
                    $this->crearTablaPelicula();
                    $this->crearTablaDirector();
                    $this->crearTablaCuentaBancaria();
                    $this->crearTablaGenero();
                    $this->tablesCreated=true;
                } catch (Exception $e){
                    echo "<p>Ha ocurrido un error al crear las tablas: ".$e->getMessage()."</p>";
                }
            }

            public function crearTablaUsuario(){
                $db = new mysqli($this->servername, $this->username, $this->password);
                $db->select_db($this->database);
                $crearTabla = "CREATE TABLE IF NOT EXISTS Usuario (id INT NOT NULL AUTO_INCREMENT, 
                        dni VARCHAR(9) NOT NULL,
                        nombre VARCHAR(255) NOT NULL, 
                        apellidos VARCHAR(255) NOT NULL,  
                        email VARCHAR(255) NOT NULL,
                        telefono int not null,
                        PRIMARY KEY (id))";
                if($db->query($crearTabla) === TRUE){
                    echo "<p>Tabla 'Usuario' creada con éxito </p>";
                } else { 
                    echo "<p>ERROR en la creación de la tabla 'Usuario'. Error : ". $db->error . "</p>";
                    exit();
                }   
                $db->close();
            }

            public function crearTablaPelicula(){
                $db = new mysqli($this->servername, $this->username, $this->password);
                $db->select_db($this->database);
                $crearTabla = "CREATE TABLE IF NOT EXISTS Pelicula (id INT NOT NULL AUTO_INCREMENT, 
                        nombre VARCHAR(255) NOT NULL, 
                        genero_id VARCHAR(255),
                        puntuacion int not null,
                        alquilada VARCHAR(255) not null,
                        usuario_id_alquila VARCHAR(255),
                        director_id VARCHAR(255),
                        precio int not null,  
                        PRIMARY KEY (id))";
                if($db->query($crearTabla) === TRUE){
                    echo "<p>Tabla 'Pelicula' creada con éxito </p>";
                } else { 
                    echo "<p>ERROR en la creación de la tabla 'Pelicula'. Error : ". $db->error . "</p>";
                    exit();
                }  
                $db->close();
            }

            public function crearTablaDirector(){
                $db = new mysqli($this->servername, $this->username, $this->password);
                $db->select_db($this->database);
                $crearTabla = "CREATE TABLE IF NOT EXISTS Director (id INT NOT NULL AUTO_INCREMENT, 
                        nombre_apellidos VARCHAR(255) NOT NULL, 
                        lugarNacimiento VARCHAR(255),
                        añoNacimiento int NOT NULL,  
                        PRIMARY KEY (id))";
                if($db->query($crearTabla) === TRUE){
                    echo "<p>Tabla 'Director' creada con éxito </p>";
                } else { 
                    echo "<p>ERROR en la creación de la tabla 'Director'. Error : ". $db->error . "</p>";
                    exit();
                }  
                $db->close();
            }

            public function crearTablaGenero(){
                $db = new mysqli($this->servername, $this->username, $this->password);
                $db->select_db($this->database);
                $crearTabla = "CREATE TABLE IF NOT EXISTS Genero (id INT NOT NULL AUTO_INCREMENT, 
                        nombre VARCHAR(255) NOT NULL, 
                        PRIMARY KEY (id))";
                if($db->query($crearTabla) === TRUE){
                    echo "<p>Tabla 'Genero' creada con éxito </p>";
                } else { 
                    echo "<p>ERROR en la creación de la tabla 'Genero'. Error : ". $db->error . "</p>";
                    exit();
                }  
                $db->close();
            }
            
            

            public function crearTablaCuentaBancaria(){
                $db = new mysqli($this->servername, $this->username, $this->password);
                $db->select_db($this->database);
                $crearTabla = "CREATE TABLE IF NOT EXISTS Cuenta_Bancaria (id INT NOT NULL AUTO_INCREMENT, 
                        numCuentaBancaria VARCHAR(255) NOT NULL,  
                        dinero int not null,
                        PRIMARY KEY (id))";
                if($db->query($crearTabla) === TRUE){
                    echo "<p>Tabla 'Cuenta_Bancaria' creada con éxito </p>";
                } else { 
                    echo "<p>ERROR en la creación de la tabla 'Cuenta_Bancaria'. Error : ". $db->error . "</p>";
                    exit();
                }  
                $db->close();
            }


             public function insertarDatos(){
                try{
                    $filasAgregadasUsuario= 0;
                    $filasAgregadasUsuario+=$this->insertarUsuarios(["1", "Lara", "Fernández", "lara@email.com", "111"]);//1
                    $filasAgregadasUsuario+=$this->insertarUsuarios(["2", "Iván", "González", "ivan@email.com", "222"]);//2
                    echo "<p>Filas agregadas en 'Usuario': " . $filasAgregadasUsuario . " </p>";

                    $filasAgregadasPelicula= 0;
                    $filasAgregadasPelicula+=$this->insertarPelicula(['La Naranja Mecánica', 4, 9, 'sí', 1, 10, 1]);//1
                    $filasAgregadasPelicula+=$this->insertarPelicula(['El Resplandor', 1, 8, 'no', 1, 10, null]);//2
                    $filasAgregadasPelicula+=$this->insertarPelicula(['Pulp Fiction', 2, 9, 'no', 2, 14, null]);//3
                    $filasAgregadasPelicula+=$this->insertarPelicula(['Reservoir Dogs', 9, 8, 'sí', 2, 15, 1]);//4
                    $filasAgregadasPelicula+=$this->insertarPelicula(['Los odiosos ocho', 5, 7, 'no', 2, 12, null]);//5
                    $filasAgregadasPelicula+=$this->insertarPelicula(['Kill Bill', 9, 8, 'no', 2, 11, null]);//6
                    $filasAgregadasPelicula+=$this->insertarPelicula(['Psicosis', 1, 9, 'no', 3, 5, null]);//7
                    $filasAgregadasPelicula+=$this->insertarPelicula(['Iron Man', 9, 4, 'no', 4, 6, null]);//8
                    $filasAgregadasPelicula+=$this->insertarPelicula(['Los Vengadores', 4, 6, 'sí', 4, 7, null, 1]);//9
                    $filasAgregadasPelicula+=$this->insertarPelicula(['Spider-Man: Homecoming', 4, 3, 'no', 4, 5, null]);//10
                    echo "<p>Filas agregadas en 'Pelicula': " . $filasAgregadasPelicula . " </p>";

                    $filasAgregadasDirector= 0;
                    $filasAgregadasDirector+=$this->insertarDirector(['Stanley Kubrick', 'Estados Unidos', 1928]);//1
                    $filasAgregadasDirector+=$this->insertarDirector(['Quentin Tarantino', 'Estados Unidos', 1963 ]);//2
                    $filasAgregadasDirector+=$this->insertarDirector(['Alfred Hitchcock', 'Inglaterra', 1899]);//3
                    $filasAgregadasDirector+=$this->insertarDirector(['Kevin Feige', 'Estados Unidos', 1973 ]);//4
                    echo "<p>Filas agregadas en 'Director': " . $filasAgregadasDirector . " </p>";

                    $filasAgregadasGenero= 0;
                    $filasAgregadasGenero+=$this->insertarGenero(['Terror']);//1
                    $filasAgregadasGenero+=$this->insertarGenero(['Comedia']);//2
                    $filasAgregadasGenero+=$this->insertarGenero(['Drama']);//3
                    $filasAgregadasGenero+=$this->insertarGenero(['Ciencia Ficcion']);//4
                    $filasAgregadasGenero+=$this->insertarGenero(['Western']);//5
                    $filasAgregadasGenero+=$this->insertarGenero(['Fantasía']);//6
                    $filasAgregadasGenero+=$this->insertarGenero(['Romántico']);//7
                    $filasAgregadasGenero+=$this->insertarGenero(['Musical']);//8
                    $filasAgregadasGenero+=$this->insertarGenero(['Acción']);//9
                    echo "<p>Filas agregadas en 'Genero': " . $filasAgregadasGenero . " </p>";

                    $filasAgregadasCuentaBancaria= 0;
                    $filasAgregadasCuentaBancaria+=$this->insertarCuentaBancaria([123,100]);
                    $filasAgregadasCuentaBancaria+=$this->insertarCuentaBancaria([456,10]);
                    $filasAgregadasCuentaBancaria+=$this->insertarCuentaBancaria([789,0]);
                    $filasAgregadasCuentaBancaria+=$this->insertarCuentaBancaria([111,50]);
                    echo "<p>Filas agregadas en 'Cuenta Bancaria': " . $filasAgregadasCuentaBancaria . " </p>";

                } catch (Exception $e){
                    echo "<p>Ha ocurrido un error al insertar los datos: ".$e->getMessage()."</p>";
                }
            }

            public function insertarPelicula($pelicula){
                $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                $consultaPre = $db->prepare("INSERT INTO Pelicula (nombre, genero_id, puntuacion, alquilada, director_id, precio, usuario_id_alquila) VALUES (?,?,?,?,?,?,?)");   
                $consultaPre->bind_param('siisiii', $pelicula[0], $pelicula[1], $pelicula[2], $pelicula[3], $pelicula[4], $pelicula[5], $pelicula[6]);    
                $consultaPre->execute();
                $filasAgregadas= $consultaPre->affected_rows;
                $consultaPre->close();
                $db->close();    
                return $filasAgregadas;       
            }

            public function insertarDirector($director){
                $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                $consultaPre = $db->prepare("INSERT INTO Director (nombre_apellidos, lugarNacimiento, añoNacimiento) VALUES (?,?,?)");   
                $consultaPre->bind_param('sss', $director[0], $director[1], $director[2]);    
                $consultaPre->execute();
                $filasAgregadas= $consultaPre->affected_rows;
                $consultaPre->close();
                $db->close();    
                return $filasAgregadas;       
            }

            public function insertarGenero($genero){
                $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                $consultaPre = $db->prepare("INSERT INTO Genero (nombre) VALUES (?)");   
                $consultaPre->bind_param('s', $genero[0]);    
                $consultaPre->execute();
                $filasAgregadas= $consultaPre->affected_rows;
                $consultaPre->close();
                $db->close();    
                return $filasAgregadas;       
            }


            public function insertarCuentaBancaria($cuenta_bancaria){
                $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                $consultaPre = $db->prepare("INSERT INTO Cuenta_Bancaria (numCuentaBancaria, dinero) VALUES (?,?)");   
                $consultaPre->bind_param('si', $cuenta_bancaria[0], $cuenta_bancaria[1]);    
                $consultaPre->execute();
                $filasAgregadas= $consultaPre->affected_rows;
                $consultaPre->close();
                $db->close();    
                return $filasAgregadas;       
            }

            
            public function insertarUsuarios($usuario){
                $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                $consultaPre = $db->prepare("INSERT INTO Usuario (dni, nombre, apellidos, email, telefono) VALUES (?,?,?,?,?)");   
                $consultaPre->bind_param('ssssi', $usuario[0], $usuario[1], $usuario[2], $usuario[3], $usuario[4]);    
                $consultaPre->execute();
                $filasAgregadas= $consultaPre->affected_rows;
                $consultaPre->close();
                $db->close();    
                return $filasAgregadas;       
            }

            public function registrarUsuario(){
                try{
                    $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                    $consultaPre = $db->prepare("INSERT INTO Usuario (dni, nombre, apellidos, email, telefono) VALUES (?,?,?,?,?)");   
                    $consultaPre->bind_param('ssssi', $_POST["dni"], $_POST["nombre"], $_POST["apellidos"], $_POST["email"], $_POST["telefono"]);    
                    $consultaPre->execute();
                    echo "<p>Registrado correctamente como usuario</p>";
                    $consultaPre->close();
                    $db->close();    
                } catch (Exception $e){
                    echo "<p>Ha ocurrido un error al registrar el usuario: ".$e->getMessage()."</p>";
                }
            }

            public function dropTables(){
                try{
                    $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                    $db->query('DROP TABLE IF EXISTS Director');   
                    $db->query('DROP TABLE IF EXISTS Pelicula'); 
                    $db->query('DROP TABLE IF EXISTS Usuario'); 
                    $db->query('DROP TABLE IF EXISTS Genero'); 
                    $db->query('DROP TABLE IF EXISTS Cuenta_Bancaria');
                    echo "<p>Tablas eliminadas correctamente</p>";
                    $db->close();  
                    $this->tablesCreated=false;
                } catch (Exception $e){
                    echo "<p>Ha ocurrido un error al eliminar las tablas: ".$e->getMessage()."</p>";
                }
            }

            public function mostrarPeliculas(){
                try{
                    $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                    if($db->connect_error) {
                        exit ("<p>ERROR de conexión:".$db->connect_error."</p>");  
                    }
                    $resultado =  $db->query('SELECT * FROM Pelicula');   
                    if ($resultado->num_rows > 0) {
                            echo "<h3>PELICULAS: </h3>";
                            echo "<table>
                            <thead>
                            <tr>
                                <th> Nombre </th>
                                <th> Genero </th>
                                <th> Puntuación </th>
                                <th> Director </th>
                                <th> ¿Esta alquilada? </th>
                                <th> Precio </th>
                            </tr>
                            <tbody>";
                            while($row = $resultado->fetch_assoc()) { 
                                $consultaPre = $db->prepare("SELECT * FROM Director WHERE id = ?");   
                                $consultaPre->bind_param('s', $row['director_id']);    
                                $consultaPre->execute();
                                $director = $consultaPre->get_result();
                                $director = $director->fetch_assoc();
                                $consultaPre = $db->prepare("SELECT * FROM Genero WHERE id = ?");   
                                $consultaPre->bind_param('s', $row['genero_id']);    
                                $consultaPre->execute();
                                $genero = $consultaPre->get_result();
                                $genero = $genero->fetch_assoc();
                                echo " <tr>
                                    <td >".  $row['nombre'] ."</td>
                                    <td >".  $genero['nombre']. "</td>
                                    <td >".  $row['puntuacion'] ."</td>
                                    <td >".  $director['nombre_apellidos'] ."</td>
                                    <td >".  $row['alquilada'] ."</td>
                                    <td >".  $row['precio'] ."€</td>
                                    </tr>";
                            }
                            echo " </table>";
                        } else {
                            echo "<p>No hay peliculas disponibles en este momento</p>";
                        }          
                    $db->close(); 
                } catch (Exception $e){
                    echo "<p>Ha ocurrido un error al mostrar la tabla: ".$e->getMessage()."</p>";
                } 
            }

            public function alquilar(){
                try{
                    $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                    if($db->connect_error) {
                        exit ("<p>ERROR de conexión:".$db->connect_error."</p>");  
                    }
                    $consultaPre = $db->prepare("SELECT * FROM Usuario WHERE dni = ?");   
                    $consultaPre->bind_param('s', $_POST["dni"]);    
                    $consultaPre->execute();
                    $usuario = $consultaPre->get_result();
                    if ($usuario->num_rows > 0) {
                        $consultaPre = $db->prepare("SELECT * FROM Pelicula WHERE lower(nombre) = ?");  
                        $nombrePelicula = strtolower($_POST["nombrePelicula"]);
                        $consultaPre->bind_param('s', $nombrePelicula);    
                        $consultaPre->execute();
                        $pelicula = $consultaPre->get_result();
                        if ($pelicula->num_rows > 0) {
                            $consultaPre = $db->prepare("SELECT * FROM Cuenta_Bancaria WHERE numCuentaBancaria = ?");  
                            $consultaPre->bind_param('s', $_POST["numCuentaBanco"]);    
                            $consultaPre->execute();
                            $cuentaBanco = $consultaPre->get_result();
                            if ($cuentaBanco->num_rows > 0) {
                                $rowPeli = $pelicula->fetch_assoc();
                                if($rowPeli['alquilada']=="sí"){
                                    echo "<p>Error: La Pelicula '" . $_POST["nombrePelicula"] . "' ya está alquilada</p>";
                                } else {
                                    $rowBanco = $cuentaBanco->fetch_assoc();
                                    if($rowBanco['dinero']>=$rowPeli['precio']){
                                        $rowUsuario = $usuario->fetch_assoc();
                                        $this->actualizarPeliAlquilada($db, $rowUsuario['id'], $rowPeli['id']);
                                        $this->actualizaDineroCuentaBancaria($db, $rowBanco['id'], $rowBanco['dinero'], $rowPeli['precio']);
                                        echo "<p>Pelicula '" . $_POST["nombrePelicula"] . "' alquilada correctamente. Se han extraido ".$rowPeli['precio']. "€ de su cuenta bancaria.</p>";
                                    } else{
                                        echo "<p>No tiene suficiente dinero. La pelicula cuesta " . $rowPeli['precio'] . " € y usted tiene ".$rowBanco['dinero']." € en el banco.</p>";
                                    }
                                }
                            } else {
                                echo "<p> No existe una cuenta en el banco de número " . $_POST["numCuentaBanco"] . "</p>";
                            }
                        } else{
                            echo "<p> Pelicula de nombre '" . $_POST["nombrePelicula"] . "' no encontrada</p>";
                        }
                    } else{
                        echo "<p> Usuario de DNI '" . $_POST["dni"] . "' no encontrado</p>";
                    }
                } catch (Exception $e){
                    echo "<p>Ha ocurrido un error alquilar la pelicula: ".$e->getMessage()."</p>";
                }
            }

            public function actualizarPeliAlquilada($db, $usuarioid, $peliculaid){
                $consultaPre = $db->prepare("UPDATE Pelicula SET alquilada=?, usuario_id_alquila=? WHERE id=?");
                $alquilado="sí";
                $consultaPre->bind_param('sii', $alquilado, $usuarioid, $peliculaid);    
                $consultaPre->execute();
            }

            public function actualizaDineroCuentaBancaria($db, $idCuentaBancaria, $dineroCuentaBancaria, $peliculaPrecio){
                $consultaPre = $db->prepare("UPDATE Cuenta_Bancaria SET dinero=? WHERE id=?");
                $dineroACtualizado=$dineroCuentaBancaria - $peliculaPrecio;
                $consultaPre->bind_param('ii', $dineroACtualizado, $idCuentaBancaria);    
                $consultaPre->execute();
            }

            public function mostrarMisPeliculasAlquiladas(){
                try{
                    $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                    if($db->connect_error) {
                        exit ("<p>ERROR de conexión:".$db->connect_error."</p>");  
                    }
                    $consultaPre = $db->prepare("SELECT * FROM Usuario WHERE dni = ?");   
                    $consultaPre->bind_param('s', $_POST["dni"]);    
                    $consultaPre->execute();
                    $usuario = $consultaPre->get_result();
                    if ($usuario->num_rows <= 0){
                        echo "<p> No existe un usuario de DNI '".$_POST["dni"]."'</p>";
                        return;
                    }
                    $rowUsuario = $usuario->fetch_assoc();
                    $idUsuario=$rowUsuario["id"];

                    $consultaPre = $db->prepare("SELECT * FROM Pelicula WHERE usuario_id_alquila = ?");   
                    $consultaPre->bind_param('i', $idUsuario);    
                    $consultaPre->execute();
                    $resultado = $consultaPre->get_result();

                    if ($resultado->num_rows > 0) {
                            echo "<h3>MIS PELICULAS ALQUILADAS: </h3>";
                            echo "<table>
                            <thead>
                            <tr>
                                <th> Nombre </th>
                                <th> Genero </th>
                                <th> Puntuación </th>
                                <th> Director </th>
                                <th> Precio </th>
                            </tr>
                            <tbody>";
                            while($row = $resultado->fetch_assoc()) {
                                $consultaPre = $db->prepare("SELECT * FROM Director WHERE id = ?");   
                                $consultaPre->bind_param('s', $row['director_id']);    
                                $consultaPre->execute();
                                $director = $consultaPre->get_result();
                                $director = $director->fetch_assoc();
                                $consultaPre = $db->prepare("SELECT * FROM Genero WHERE id = ?");   
                                $consultaPre->bind_param('s', $row['genero_id']);    
                                $consultaPre->execute();
                                $genero = $consultaPre->get_result();
                                $genero = $genero->fetch_assoc();

                                echo " <tr>
                                    <td >".  $row['nombre'] ."</td>
                                    <td >".  $genero['nombre']. "</td>
                                    <td >".  $row['puntuacion'] ."</td>
                                    <td >".  $director['nombre_apellidos'] ."</td>
                                    <td >".  $row['precio'] ."€</td>
                                    </tr>";
                            }
                            echo " </table>";
                        } else {
                            echo "<p>No tienes peliculas alquiladas.</p>";
                        }          
                    $db->close();    
                } catch (Exception $e){
                    echo "<p>Ha ocurrido un error al mostrar la tabla: ".$e->getMessage()."</p>";
                }
            }

            public function getDB(){
                try{
                    $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                    return $db;
                } catch (Exception $e){
                    echo "<p>La base de datos no esta creada</p>";
                    return null;
                }
            }

            public function isTableCreated(){
                try{
                    if($this->getDB()!=null){
                        $db=$this->getDB();
                        $resultado =  $db->query('SELECT * FROM Genero'); 
                        if ($resultado->num_rows > 0) {
                            return true;
                        } 
                    }
                    return false;
                } catch(Exception $e){
                    echo "<p>Las tablas no están creadas</p>";
                    return false;
                }
            }

            public function añadirPelicula(){
                try{
                    $db = new mysqli($this->servername, $this->username, $this->password, $this->database);
                    $consultaPre = $db->prepare("INSERT INTO Pelicula (nombre, genero_id, puntuacion, alquilada, precio, director_id) VALUES (?,?,?,?,?,?)");  
                    $alquilada="no"; 
                    $consultaPre->bind_param('ssssii', $_POST["nombre"], $_POST["genero"], $_POST["puntuacion"],  $alquilada, $_POST["precio"], $_POST["director"]);    
                    $consultaPre->execute();
                    echo "<p>Pelicula añadida a la base de datos.</p>";
                    $consultaPre->close();
                    $db->close();    
                } catch (Exception $e){
                    echo "<p>Ha ocurrido un error al añadir la pelicula: ".$e->getMessage()."</p>";
                }
            }
    }

		$dataBase = new BaseDatos();

        if (count($_POST)>0)  {
            if (isset($_POST['crearBaseDatos']))
                $dataBase->crearBaseDatos();
            if (isset($_POST['crearTablas']))
                $dataBase->crearTablas();
            if (isset($_POST['insertarDatos']))
                $dataBase->insertarDatos();
            if (isset($_POST['dropTables']))
                $dataBase->dropTables();
            if (isset($_POST['registrarse']))
                $dataBase->registrarUsuario();
            if (isset($_POST['mostrarPeliculas']))
                $dataBase->mostrarPeliculas();
            if (isset($_POST['alquilar']))
                $dataBase->alquilar();   
            if (isset($_POST['mostrarMisPeliculasAlquiladas']))
                $dataBase->mostrarMisPeliculasAlquiladas();   
            if (isset($_POST['añadirPelicula']))
                $dataBase->añadirPelicula();   
                
        }   
        
       
        $generosNombres = array();
        $generosIds = array();
        $directoresNombres = array();
        $directoresIds = array();
        if($dataBase->isTableCreated()){
            try{
                $db = $dataBase->getDB();
                $resultado =  $db->query('SELECT * FROM Director'); 
                if ($resultado->num_rows > 0) {
                    $i=0;
                    while($row = $resultado->fetch_assoc()) { 
                        $directoresIds[$i]=$row['id'];
                        $directoresNombres[$i]=$row['nombre_apellidos'];
                        $i++;
                    }
                }
                $db = $dataBase->getDB();
                $resultado =  $db->query('SELECT * FROM Genero'); 
                if ($resultado->num_rows > 0) {
                    $i=0;
                    while($row = $resultado->fetch_assoc()) { 
                        $generosIds[$i]=$row['id'];
                        $generosNombres[$i]=$row['nombre'];
                        $i++;
                    }
                }
            } catch(Exception $e) {
                echo "<p>Ha ocurrido un error:" .$e->getMessage(). "</p>";
            }
        }
    

      

    echo "  
    <h2>Opciones Administrador:</h2>
    <form action='#' method='post'>
        <p><input type = 'submit' class='button' name = 'crearBaseDatos' value = 'Crear Base de Datos'/></p>
        <p><input type = 'submit' class='button' name = 'crearTablas' value = 'Crear tablas'/></p>
        <p><input type = 'submit' class='button' name = 'insertarDatos' value = 'Insertar datos'/></p>
        <p><input type = 'submit' class='button' name = 'dropTables' value = 'Eliminar tablas'/></p>
    </form>
    <form action='#' method='post'>
        <h3>Añadir pelicula</h3>
        <p><label>Nombre pelicula: <input type='text' name='nombre' required></label></p>
        <p><label>Puntuación: <input type='number' name='puntuacion' required min='0' max='10'></label></p>
        <p><label>Precio: <input type='number' name='precio' required ></label></p>";


        if(!empty($directoresNombres)){
            echo" <label>Director: </label><select name='director'>";
             for ($i = 0; $i <= count($directoresIds)-1; $i++){
                 echo "<option id=director.$i value=$directoresIds[$i]>$directoresNombres[$i]</option>";
             }
            echo"</select> ";
        }

        if(!empty($generosNombres)){
           echo" <label>Género: </label><select name='genero'>";
            for ($i = 0; $i <= count($generosIds)-1; $i++){
                echo "<option id=genero.$i value=$generosIds[$i]>$generosNombres[$i]</option>";
            }
            echo"</select> ";
        }
        
    echo "   
    <p><input type = 'submit' class='button' name = 'añadirPelicula' value = 'Añadir pelicula'/></p>
    </form>

    <form action='#' method='post'>
        <h2>Registrarse como usuario</h2>
        <p><label>DNI: <input type='text' name='dni' required></label></p>
        <p><label>Nombre: <input type='text' name='nombre' required></label></p>
        <p><label>Apellidos: <input type='text' name='apellidos' required></label></p>
        <p><label>Email: <input type='text' name='email' required></label></p>
        <p><label>Telefono: <input type='text' name='telefono' required></label></p>
        <p><input type = 'submit' class='button' name = 'registrarse' value = 'Registrarse'/></p>
    </form>

    <h2>Peliculas</h2>
    <form action='#' method='post'>
        <p><input type = 'submit' class='button' name = 'mostrarPeliculas' value = 'Ver Peliculas Disponibles'/></p>
    </form>
    <form action='#' method='post'>
        <p><label>DNI: <input type='text' name='dni' required></label>
        <input type = 'submit' class='button' name = 'mostrarMisPeliculasAlquiladas' value = 'Ver Mis Peliculas Alquiladas'/></p>
    </form>
    <form action='#' method='post'>
        <h3>Alquiler de Pelicula</h3>
        <p><label>DNI: <input type='text' name='dni' required></label></p>
        <p><label>Nombre de pelicula: <input type='text' name='nombrePelicula' required></label></p>
        <p><label>Número de cuenta bancaria (Ej: 123): <input type='text' name='numCuentaBanco' required></label></p>
        <p><input type = 'submit' class='button' name = 'alquilar' value = 'Alquilar'/></p>
    </form>

    ";
    
    ?>
</body>

</html>