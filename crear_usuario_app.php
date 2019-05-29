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
    //---Verificar que es un bote creado por el administrador
    $sql = "SELECT * FROM trabajadores WHERE ID = '$id_usuario' AND CODIGO = '$codigo_usuario'";
    $result = $conexion->query($sql);
    $row = mysqli_fetch_assoc($result);
    //---Si se encuentra
    if($result->num_rows > 0){
        $arr = array('crear' => 'no');
        echo json_encode($arr);
    }
    else{
        $arr = array('crear' => 'si');
        echo json_encode($arr);
    }
    mysqli_close($conexion);
}
?>