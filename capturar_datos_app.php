<?php
//--- Info-base-de-datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_admin";
//----Conexión con la base de datos
$conexion = new mysqli($servername, $username, $password, $dbname);
if ($conexion->connect_error) {
    //---Muestra error en la pagina, para el hardware sería una respuesta que lo haría retener el datos (Almacenar localmente en el dispositivo hardware --base de datos local)
    die("ERROR");
}
else{
    //---Captura de todos los datos enviados por el bote 
    $ID_BOTE = $_GET["ID"];
    $latitud = $_GET["latitud"];
    $longitud = $_GET["longitud"];
    $dato_1 = $_GET["c_pla"];
    $dato_2 = $_GET["c_org"];
    $dato_3 = $_GET["c_pa"];
    $dato_4 = $_GET["c_vi"];
    $dato_5 = $_GET["c_car"];
    $dato_6 = $_GET["c_met"];
    $dato_7 = $_GET["c_acum"];
    $fecha = $_GET["fecha"];
    $lleno = $_GET["lleno"];
    //---Verificar que es un bote creado por el administrador
    $sql = "SELECT * FROM bd_botes WHERE ID_BOTE = '$ID_BOTE' AND ESTADO = '*'";
    $result = $conexion->query($sql);
    //---Si se encuentra
    if($result->num_rows > 0){
        //--Conexión de base usuarios para guardar en la tabla historial
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "base_usuarios";
        //---Conexión a la tabla historial de botes
        $conexion_2 = new mysqli($servername, $username, $password, $dbname);
        if ($conexion_2->connect_error) {
            //---Muestra error en la pagina, para el hardware sería una respuesta que lo haría retener el datos (Almacenar localmente en el dispositivo hardware --base de datos local)
            die("ERROR");
        }
        else{
            //--Insertar datos en la tabla historial
            $sql = "INSERT INTO historial (ID_BOTE,LATITUD,LONGITUD,C_PLA,C_ORG,C_PA,C_VI,C_CAR,C_MET,C_PROM,FECHA,LLENO) VALUES ('$ID_BOTE','$latitud','$longitud','$dato_1','$dato_2','$dato_3','$dato_4','$dato_5','$dato_6','$dato_7','$fecha','$lleno')";
            mysqli_query($conexion_2, $sql);
            //---Cerrar conexión
            mysqli_close($conexion_2);
            //---Mostrar mensaje, que el hardware interpretar como el mensaje fue enviado y puede ser eliminado de la base de datos local (No retener el dato en base de datos)
            echo "OK";
        }
    }
    else{
        //---Bote no existente en la base de datos (Bote falso)
        echo "ERROR";
    }
    mysqli_close($conexion);
}
/* ---Algunas ubicaciones
3.353806, -76.521788
3.353776, -76.522518
3.353531, -76.520823
3.353275, -76.521074*/
//--- Petición que va tener el hardware
//https://localhost/PAGINAS_APLICACIONES_TELEMATICAS/capturar_datos_hw.php?ID=bote0001&latitud=3.353275&longitud=-76.521074&c_pla=1&c_org=1&c_pa=1&c_vi=1&c_car=1&c_met=1&c_acum=1&fecha=2019/03/17-20:41:05&lleno=*
//https://localhost/PAGINAS_APLICACIONES_TELEMATICAS/capturar_datos_hw.php?ID=bote0002&latitud=3.353531&longitud=-76.520823&c_pla=1&c_org=1&c_pa=1&c_vi=1&c_car=1&c_met=1&c_acum=1&fecha=2019/03/17-21:41:05&lleno=-
?>