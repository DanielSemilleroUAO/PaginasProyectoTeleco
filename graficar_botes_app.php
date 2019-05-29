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
	$codigo_usuario = $_GET["cod_trabajador"];
	$id_usuario = $_GET["id"];
    //---Ingresar dato a la bd
	$sql = "SELECT * FROM trabajadores WHERE CODIGO = '$codigo_usuario' AND ID = '$id_usuario'";
	$result = mysqli_query($conexion, $sql);
	$row = mysqli_fetch_assoc($result);
	//$id_usuario = $row["ID"];
	$residuos = $row["TIPO_RESIDUO"];
	$residuos = explode(",", $residuos);
	$plastico = false;
	$papel = false;
	$carton = false;
	$vidrio = false;
	$organico = false;
	$metal = false;
	for($i = 0; $i < count($residuos);$i++){
		if($residuos[$i] == 'pa'){
			$papel = true;
		}
		if($residuos[$i] == 'ca'){
			$carton = true;
		}
		if($residuos[$i] == 'me'){
			$metal = true;
		}
		if($residuos[$i] == 'vi'){
			$vidrio = true;
		}
		if($residuos[$i] == 'o'){
			$organico = true;
		}
		if($residuos[$i] == 'pla'){
			$plastico = true;
		}
	}
	$sql = "SELECT * FROM botes WHERE ID_USUARIO = '$id_usuario'";
	$result = mysqli_query($conexion, $sql);
	$c_datos = $result->num_rows;
	//-----Para ubicacion en el mapa se capturan todos los nombres de los botes asociados al usuario
	if($c_datos > 0){
		while($row = mysqli_fetch_array($result))  
		{  
			$datos_botes[]  = $row["ID_BOTE"];  
		}
	}
	for($i=0;$i<$c_datos;$i++){
		$sql = "SELECT * FROM historial WHERE ID_BOTE = '$datos_botes[$i]' ORDER BY FECHA DESC LIMIT 1";
		$result = mysqli_query($conexion, $sql);
		$row_cnt = $result->num_rows;
		if($row_cnt > 0){
			while($row = mysqli_fetch_array($result))  
			{  
				if($row["LLENO"] == "*"){
					if(($papel == true AND floatval($row["C_PA"]) >= 6) OR ($plastico == true AND floatval($row["C_PLA"]) >= 6) OR ($organico == true AND floatval($row["C_ORG"]) >= 6 ) OR ($vidrio == true AND floatval($row["C_VI"]) >= 6) OR ($metal == true AND floatval($row["C_MET"]) >= 6 ) OR ($carton == true AND floatval($row["C_CAR"]) >= 6 )){
						$id_botes[] = $row["ID_BOTE"];
						$latitudes[] = $row["LATITUD"];
						$longitudes[] = $row["LONGITUD"];
					}
					
					
				}
				
			}
		}
	}
	$datos = array
	(
		array('ids' => $id_botes),
		array('lats' => $latitudes),
		array('longs' => $longitudes)
	);
	print_r($id_botes);
	print_r($latitudes);
	print_r($longitudes);
	print_r($datos);
	mysqli_close($conexion);
}
?>