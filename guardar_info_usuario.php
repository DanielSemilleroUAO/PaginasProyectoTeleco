<?php
//---Capturar datos del formulario (name del input)
$nombre = $_POST['nombre'];
$identificacion = $_POST['identificacion'];
$codigo= $_POST['codigo'];
$correo = $_POST['correo'];
$numero_telefono = $_POST['numero_telefono'];
$ciudad = $_POST['ciudad'];
$nick = $_POST['nick'];
$contrasena = $_POST['contrasena'];
//--- Info-base-de-datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_admin";
//------Conexión-base-de-datos
$conexion = new mysqli($servername, $username, $password, $dbname);
if ($conexion->connect_error) {
	//die("La conexion falló: " . $conexion->connect_error);
	echo "<script type='text/javascript'>window.alert('Error de conexión a la base de datos');</script>";
	echo "<script type='text/javascript'>location.href='RegistroUsuario.html'</script>";
}
else{
	$sql = "SELECT * FROM bd_usuarios WHERE ID_USUARIO = '$codigo' AND ESTADO = '*'";
	$result = $conexion->query($sql);
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
			echo "<script type='text/javascript'>window.alert('Error de conexión a la base de datos');</script>";
			echo "<script type='text/javascript'>location.href='RegistroUsuario.html'</script>";
		}
		else {
			//---Consulta si el usuario existe en la base de datos usuario
			$sql = "SELECT * FROM usuario WHERE COD_USUARIO = '$codigo'";
			$result = $conexion_1->query($sql);
			if($result->num_rows > 0){
				echo "<script type='text/javascript'>window.alert('Codigo de Usurio BIIoT ya se encuentra activo');</script>";
			}
			else {
				//---Consulta si la identificación existe en la base de datos usuario
				$sql = "SELECT * FROM usuario WHERE IDENTIFICACION = '$identificacion'";
				$result = $conexion_1->query($sql);
				if($result->num_rows > 0){
					echo "<script type='text/javascript'>window.alert('Usuario ya existe');</script>";
				}
				else {
					//---Consulta si el nick  existe en la base de datos usuario
					$sql = "SELECT * FROM usuario WHERE NICK = '$nick'";
					$result = $conexion_1->query($sql);
					if($result->num_rows > 0){
						echo "<script type='text/javascript'>window.alert('Por favor cambiar el nick (Nick ya existe)');</script>";
					}
					else {
						//-----Generar-consulta-codigo-bd (Ingresar usuario)
						$sql = "INSERT INTO usuario (NOMBRE,IDENTIFICACION,COD_USUARIO,EMAIL,TELEFONO,CIUDAD,NICK,PASSWORD) VALUES ('$nombre','$identificacion','$codigo','$correo','$numero_telefono','$ciudad','$nick','$contrasena')";
						//-----Ejecutar-consulta-bd
						mysqli_query($conexion_1, $sql);
						//---Mensaje de registro exitoso
						echo "<script type='text/javascript'>window.alert('Usuario exitosamente registrado');</script>";
					}
				}
			}
			//-----Cerrar-bd
			mysqli_close($conexion_1);
		//-----------------------------------
		}
	}
	else {
		echo "<script type='text/javascript'>window.alert('Codigo de Usuario BIIoT no se encuentra activo');</script>";
	}
	//-----Cerrar-bd
	mysqli_close($conexion);
	echo "<script type='text/javascript'>location.href='RegistroUsuario.html'</script>";
}
?>   