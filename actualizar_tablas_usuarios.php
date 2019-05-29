<?php
//---- VARIABLES DE SESION
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
} else {
	echo "<script type='text/javascript'>window.alert('Esta pagina es solo para usuarios registrados.');</script>";
	echo "<script type='text/javascript'>location.href='index.html'</script>";
	exit;
}
$now = time();
//-- VERIFICAR TIEMPO
if($now > $_SESSION['expire']) {
	session_destroy();
	echo "<script type='text/javascript'>window.alert('Su sesion a terminado, necesita hacer login');</script>";
	echo "<script type='text/javascript'>location.href='index.html'</script>";
	exit;
}
//---Capturar datos del formulario (name del input)
date_default_timezone_set('America/Chicago');
$mydate=getdate();
$fecha = "$mydate[year]/$mydate[mon]/$mydate[mday]";
$estado = "*";
//--- Info-base-de-datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_usuarios";
//------Conexión-base-de-datos
$conexion = new mysqli($servername, $username, $password, $dbname);
if ($conexion->connect_error) {
	echo "<script type='text/javascript'>window.alert('Error de conexión a la base de datos');</script>";
	echo "<script type='text/javascript'>location.href='AdminBotesUsuario.php'</script>";
}
else{
	//--- Lectura de checkbox que se han seleccionado
	if(isset($_POST["checkbox"])) { 
		$delete = $_POST["checkbox"]; 
		$cantidad = count($delete); 
		for ($i=0; $i<$cantidad; $i++) {  
			$del_id = $delete[$i]; 
			//echo $del_id;
			//--- Borrar bote asociado al usuario (tabla botes)
			$sql = "DELETE FROM botes WHERE ID_BOTE ='$del_id'"; 
         mysqli_query($conexion,$sql);// or die ("Problemas en el select:".mysqli_error($conexion)); 
     } 
     //--- Cerrar conexión
     mysqli_close($conexion);
     echo "<script type='text/javascript'>location.href='AdminBotesUsuario.php'</script>";
 }
 //--- Cuando no selecciona ningun bote (No marca ningun checkbox)
 echo "<script type='text/javascript'>window.alert('Por favor seleccione un bote a eliminar');</script>";
 echo "<script type='text/javascript'>location.href='AdminBotesUsuario.php'</script>";
}
?>   