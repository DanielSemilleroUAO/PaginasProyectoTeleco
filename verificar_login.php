<?php
session_start();
?>

<?php
//---CAPTURA DE DATOS
if(!isset($_POST['nombre_usuario']) || empty($_POST['nombre_usuario'])){
    $nick = 0;
}
else{
    $nick = $_POST['nombre_usuario'];
}
if(!isset($_POST['codigo_usuario']) || empty($_POST['codigo_usuario'])){
    $codigo_usuario = 0;
}
else{
    $codigo_usuario = $_POST['codigo_usuario'];
}
$password = $_POST['contrasena'];
//--info-base-datos
$host_db = "localhost";
$user_db = "root";
$pass_db = "";
$db_name = "base_usuarios";

$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);

if ($conexion->connect_error) {
    echo "<script type='text/javascript'>window.alert('Error de conexión a la base de datos');</script>";
    echo "<script type='text/javascript'>location.href='LoginUsuario.html'</script>";
}
else{
    $sql = "SELECT * FROM usuario WHERE NICK = '$nick' OR COD_USUARIO = '$codigo_usuario'";
    $result = $conexion->query($sql);
    $row = mysqli_fetch_assoc($result);
    if ($result->num_rows > 0) { 

        $host_db = "localhost";
        $user_db = "root";
        $pass_db = "";
        $db_name = "base_admin";

        $conexion2 = new mysqli($host_db, $user_db, $pass_db, $db_name);
        $id_usuario = $row["COD_USUARIO"];
        $sql_2 = "SELECT * FROM bd_usuarios WHERE ID_USUARIO = '$id_usuario'";
        $result_2 = $conexion2->query($sql_2);
        $datos = mysqli_fetch_array($result_2);
        if($datos["ESTADO"] == '/'){
            echo "<script type='text/javascript'>window.alert('El usuario ha sido bloqueado por el administrador');</script>";
            echo "<script type='text/javascript'>location.href='LoginUsuario.html'</script>";
        }
        else{
            if ($password == $row['PASSWORD']) { 
                //---Creación de variables de sesion
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $row['NICK'];
                $_SESSION['id_usuario'] = $row['ID'];
                $_SESSION['cod_usuario'] = $row['COD_USUARIO'];
                $_SESSION['start'] = time();
                $_SESSION['expire'] = $_SESSION['start'] + (15 * 60);
                echo "<script type='text/javascript'>location.href='panel_control.php'</script>";
            } 
            else { 
                echo "<script type='text/javascript'>window.alert('Contraseña incorrecta');</script>";
                echo "<script type='text/javascript'>location.href='LoginUsuario.html'</script>";
            }
        }
        mysqli_close($conexion2); 
    }
    else{
        echo "<script type='text/javascript'>window.alert('Usuario no se encuentra registrado');</script>";
        echo "<script type='text/javascript'>location.href='LoginUsuario.html'</script>";
    }
    mysqli_close($conexion); 
}
?>