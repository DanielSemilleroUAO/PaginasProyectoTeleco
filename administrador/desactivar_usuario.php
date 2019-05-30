<?php
//--- Info-base-de-datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_admin";

//------Conexión-base-de-datos
$conexion = new mysqli($servername, $username, $password, $dbname);
if ($conexion->connect_error) {
	echo "<script type='text/javascript'>window.alert('Error de conexión a la base de datos');</script>";
	echo "<script type='text/javascript'>location.href='usuarios_admin.php'</script>";
}
else{
	if(isset($_POST["checkbox"])) { 
		$delete = $_POST["checkbox"]; 
		$cantidad = count($delete); 
		for ($i=0; $i<$cantidad; $i++) {  
			$del_id = $delete[$i]; 
			//echo $del_id;
			$sql = "SELECT ESTADO FROM bd_usuarios WHERE ID_USUARIO ='$del_id'";
			$result = mysqli_query($conexion,$sql);
			$datos = mysqli_fetch_array($result);
			if($datos["ESTADO"]=="*"){
				$cambio = "/";
			}
			else{
				$cambio = "*";
			}
			$sql = "UPDATE bd_usuarios SET ESTADO = '$cambio' WHERE ID_USUARIO ='$del_id'"; 
			mysqli_query($conexion,$sql);
		} 

		mysqli_close($conexion);
		echo "<script type='text/javascript'>location.href='usuarios_admin.php'</script>";
	}
	echo "<script type='text/javascript'>window.alert('Por favor seleccione un usuarios a cambiar de estado');</script>";
	echo "<script type='text/javascript'>location.href='usuarios_admin.php'</script>";
}
?>   