<?php
//--- Info-base-de-datos
$servername = "localhost";
$username = "id8007519_root_1";
$password = "1143867053DanieL";
$dbname = "id8007519_base_usuarios";
//----Conexión con la base de datos
$conexion = new mysqli($servername, $username, $password, $dbname);
if ($conexion->connect_error) {
    //---Muestra error en la pagina, para el hardware sería una respuesta que lo haría retener el datos (Almacenar localmente en el dispositivo hardware --base de datos local)
    die("ERROR");
}
else{
    //---Captura de todos los datos enviados por el bote 
    $id_usuario = $_GET["id"];
    $codigo_usuario = $_GET["cod_trabajador"];
    $residuos = $_GET["residuos"];
    //---Ingresar dato a la bd
    $sql = "INSERT INTO trabajadores (ID,CODIGO,TIPO_RESIDUO) VALUES ('$id_usuario','$codigo_usuario','$residuos')";
    mysqli_query($conexion, $sql);
    mysqli_close($conexion);
}
?>