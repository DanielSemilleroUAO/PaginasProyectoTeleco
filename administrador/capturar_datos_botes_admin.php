<?php
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
	//die("La conexion falló: " . $conexion->connect_error);
	echo "<script type='text/javascript'>window.alert('Error de conexión a la base de datos');</script>";
	echo "<script type='text/javascript'>location.href='botes_admin.php'</script>";
}
else{
	$sql = "SELECT * FROM bd_botes WHERE ID_BOTE = '$id_bote'";
	$result = $conexion->query($sql);
	if($result->num_rows > 0){
		echo "<script type='text/javascript'>window.alert('Usuario ya existe');</script>";
	}
	else{
		//-----Generar-consulta-codigo-bd
		$sql = "INSERT INTO bd_botes (ID_BOTE,FECHA,ESTADO) VALUES ('$id_bote','$fecha','$estado')";
		//-----Ejecutar-consulta-bd
		mysqli_query($conexion, $sql);
	}
	//-----Cerrar-bd
	mysqli_close($conexion);
	echo "<script type='text/javascript'>location.href='botes_admin.php'</script>";
}
?>   