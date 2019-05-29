<?php
//--- VARIABLES DE SESION
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
} else {
	echo "<script type='text/javascript'>window.alert('Esta pagina es solo para usuarios registrados.');</script>";
	echo "<script type='text/javascript'>location.href='index.html'</script>";
	exit;
}
$now = time();
//--- VERIFICAR TIEMPO DE SESION
if($now > $_SESSION['expire']) {
	session_destroy();
	echo "<script type='text/javascript'>window.alert('Su sesion a terminado, necesita hacer login');</script>";
	echo "<script type='text/javascript'>location.href='index.html'</script>";
	exit;
}
//---Capturar datos del formulario (name del input)
$id_bote = $_POST['id_bote'];
date_default_timezone_set('America/Chicago');
$mydate=getdate();
$fecha = "$mydate[year]/$mydate[mon]/$mydate[mday]";
$estado = "*";
//--- Info-base-de-datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_admin";
//------Conexión-base-de-datos
$conexion = new mysqli($servername, $username, $password, $dbname);
if ($conexion->connect_error) {
	//--- Si hay error de conexión a la base de datos o la base de datos no existe
	echo "<script type='text/javascript'>window.alert('Error de conexión a la base de datos');</script>";
	echo "<script type='text/javascript'>location.href='AdminBotesUsuario.php'</script>";
}
else{
	//--- Verificar que el bote en la base de datos administrador no se encuentra bloqueado (/)
	$sql = "SELECT * FROM bd_botes WHERE ID_BOTE = '$id_bote' AND ESTADO = '*'";
	$result = $conexion->query($sql);
	//--- Si el resultado tiene columnas (Tiene datos asociados de acuerdo a la consulta)
	if($result->num_rows > 0){
		//-----------------------------------
			//--- Info-base-de-datos
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "base_usuarios";
		//------Conexión-base-de-datos
		$conexion_1 = new mysqli($servername, $username, $password, $dbname);
		if ($conexion->connect_error) {
			//--- Si hay error de conexión a la base de datos o la base de datos no existe
			echo "<script type='text/javascript'>window.alert('Error de conexión a la base de datos');</script>";
			echo "<script type='text/javascript'>location.href='RegistroUsuario.html'</script>";
		}
		else {
			//--- Verificar que botes se encuentra asociados al usuario
			$sql = "SELECT * FROM botes WHERE ID_BOTE = '$id_bote'";
			$result = $conexion_1->query($sql);
			if($result->num_rows > 0){
				//--- Bote ya se encuentra asociado a otro usuario
				echo "<script type='text/javascript'>window.alert('El bote ya se encuentra activo con otro usuario');</script>";
			}
			else {
				//-----Generar-consulta-codigo-bd
				$id_usuario = $_SESSION['id_usuario'];
				//-----Asociar bote con el usuario que lo ingresa
				$sql = "INSERT INTO botes (ID_BOTE,ID_USUARIO,FECHA) VALUES ('$id_bote','$id_usuario','$fecha')";
				//-----Ejecutar-consulta-bd
				mysqli_query($conexion_1, $sql);
				//----Mensaje de registro exitoso
				echo "<script type='text/javascript'>window.alert('Usuario exitosamente registrado');</script>";
			}
			//-----Cerrar-bd
			mysqli_close($conexion_1);
		}
		//-----------------------------------
	}
	else{
		//----El bote no existe en la base de datos del administrador
		echo "<script type='text/javascript'>window.alert('El bote no se encuentra activo');</script>";
	}
	//-----Cerrar-bd
	mysqli_close($conexion);
	echo "<script type='text/javascript'>location.href='AdminBotesUsuario.php'</script>";
}
?>   