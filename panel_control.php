<?php
//--- Variables de sesion
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
} else {
  echo "<script type='text/javascript'>window.alert('Esta pagina es solo para usuarios registrados.');</script>";
  echo "<script type='text/javascript'>location.href='index.html'</script>";
  exit;
}
$now = time();
//---Verificar tiempo de sesion
if($now > $_SESSION['expire']) {
  session_destroy();
  echo "<script type='text/javascript'>window.alert('Su sesion a terminado, necesita hacer login');</script>";
  echo "<script type='text/javascript'>location.href='index.html'</script>";
  exit;
}
//----Capturar hora que posee el servidor
date_default_timezone_set('America/Chicago');
$mydate=getdate();
$fecha = "$mydate[year]/$mydate[mon]/$mydate[mday]";
$hora= "$mydate[hours]:$mydate[minutes]:$mydate[seconds]";
//--- Info-base-de-datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_usuarios";
//------Conexión-base-de-datos
$conexion = new mysqli($servername, $username, $password, $dbname);
if ($conexion->connect_error) {
  //---Error de conexión o tabla no existe
  echo "<script type='text/javascript'>window.alert('Error de conexión a la base de datos');</script>";
}
else{
  $id_usuario = $_SESSION['id_usuario'];
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
 //---Variables acomuladoras para mostrar la cantidad del residuos que hay en todos los botes asociados al usuario
 $c_pa=0;
 $c_me=0;
 $c_vi=0;
 $c_ca=0;
 $c_org=0;
 $c_plas=0;
 $total=0;
 //----Recorrer todos los botes asociados al usuario
 for($i=0;$i<$c_datos;$i++){
  $sql = "SELECT * FROM historial WHERE ID_BOTE = '$datos_botes[$i]' ORDER BY FECHA DESC LIMIT 1";
  $result = mysqli_query($conexion, $sql);
  $row_cnt = $result->num_rows;
  if($row_cnt > 0){
    while($row = mysqli_fetch_array($result))  
    {  
      //--Cambiar el tipo de dato (String-->Float) para poder almacenar
      $c_pa+=floatval($row['C_PA']);
      $c_me+=floatval($row['C_MET']);
      $c_vi+=floatval($row['C_VI']);
      $c_ca+=floatval($row['C_CAR']);
      $c_org+=floatval($row['C_ORG']);
      $c_plas+=floatval($row['C_PLA']);
    }
  }
}
//---Suma de todos los residuos de todos los botes
$total = $c_pa + $c_me + $c_vi + $c_ca + $c_org + $c_plas;
//-----Cerrar-bd
mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <!-- Configuración de la pagina -->
  <!-- ICONO PAGINA-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="https://raw.githubusercontent.com/tlkh/SmartBin/master/img/trashy.gif">
  <!-- NOMBRE PAGINA -->
  <title>Botes interactivos Cali</title>
  <meta name="description" content="Colombia.">
  <meta name="keywords" content="Botes inteligentes">
  <!-- CSS ESTILO -->
  <link rel="stylesheet" href="estilo_paginas.css">
  <!-- Importación JS para la barra de navegación -->
  <script src="js/navbar-ontop.js"></script>
  <script src="js/smooth-scroll.js" style=""></script>
  <!-- Importación google chart mapa -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {
      'packages':['map'],
      // Note: you will need to get a mapsApiKey for your project.
      // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
      'mapsApiKey': 'AIzaSyBt6YOJXifjgIlfX4SPDT8Ddq_j57Uemn4'
    });
    google.charts.setOnLoadCallback(drawChart);
    //--Función para google chart
    function drawChart() {
      /*var data = google.visualization.arrayToDataTable([
        ['Lat', 'Long', 'Name'],
        [3.353806, -76.521788, 'Work'],
        [3.353776, -76.522518, 'University'],
        [3.353531, -76.520823, 'Airport'],
        [3.353275, -76.521074, 'Shopping']
        ]);
      var options = {
        icons: {
          default: {
            normal: 'bote_lleno.gif',
            selected: 'https://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Ball-Right-Azure-icon.png'
          }
        },
      };*/
      //---Datos para poder mostrar el icono y la info de cada bote 
      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Lat');
      data.addColumn('number', 'Long');
      data.addColumn('string', 'Location');
      data.addColumn('string', 'Marker');
      //---Datos del bote: Latitud, Longitud, Datos para mostart al dar clic, tipo icono (lleno o vacio)
      data.addRows([
        <?php
        $conexion = new mysqli($servername, $username, $password, $dbname);
        for($i=0;$i<$c_datos;$i++){
          $sql = "SELECT * FROM historial WHERE ID_BOTE = '$datos_botes[$i]' ORDER BY FECHA DESC LIMIT 1";
          $result = mysqli_query($conexion, $sql);
          $row_cnt = $result->num_rows;
          if($row_cnt > 0){
            while($row = mysqli_fetch_array($result))  
            {  
              if($row["LLENO"] == "*"){
                $icono = 'red';
              }
              else{
                $icono = 'green';
              }
              $mostrar = '<a href="historial_bote.php?id_bote='.$row["ID_BOTE"].'">'.$row["ID_BOTE"].'</a>';
              echo "[".$row["LATITUD"].",".$row["LONGITUD"].",'".$mostrar."','".$icono."'],";  
            }
          }
        }
        mysqli_close($conexion);
        ?> 
        ]);

      var options = {
        showInfoWindow: true,
        useMapTypeControl: true,
        icons: {
          red: {
            normal:   'bote_lleno.gif',
            selected: 'https://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Ball-Right-Azure-icon.png'
          },
          green: {
            normal:   'Logo_mapa.gif',
            selected: 'https://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Ball-Right-Azure-icon.png'
          },
          default: {
            normal: 'bote_lleno.gif',
            selected: 'https://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Ball-Right-Azure-icon.png'
          }
        }
      };
      var map = new google.visualization.Map(document.getElementById('map_markers_div'));
      map.draw(data, options);
    }
  </script>

</head>
<body class="text-center">
  <!-- Barra de navegación  -->
  <nav class="navbar navbar-expand-md fixed-top bg-dark navbar-dark">
    <div class="container">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent" aria-controls="navbar2SupportedContent" aria-expanded="false" aria-label="Toggle navigation" style=""> <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbar2SupportedContent">
        <!-- Items de la barra de navegación -->
        <ul class="navbar-nav">
          <li class="nav-item mx-2">
            <a class="btn btn-dark btn-block mx-2 text-white btn-outline-light" href="AdminBotesUsuario.php">Administrar botes</a>
          </li>
          <li class="nav-item mx-2">
            <a class="btn btn-dark btn-block mx-2 text-white btn-outline-light" href="panel_control.php">Actualizar</a>
          </li>
          <li class="nav-item mx-2">
            <a class="btn btn-dark btn-block mx-2 text-white btn-outline-light" href="cerrar_sesion.php">Cerrar sesion</a>
          </li>
          <li class="nav-item mx-2">
          </li>
          <li class="nav-item mx-2">
            <img class="img-fluid d-block" src="Logo.gif" width="50" draggable="true">
          </li>
          <li class="nav-item mx-2">
            <img class="img-fluid d-block" src="Logo_empresa.png" width="40" height="38">
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Portada con imagen de fondo  -->
  <div class="d-flex align-items-center p-2 cover" style="background-image: url(&quot;CALI_1.jpg&quot;); background-position: left top; background-size: 100%; background-repeat: repeat;">
    <!-- Container con imagen de fondo de color negro con difuminado -->
    <div class="container" style="	background-image: linear-gradient(to bottom, rgba(0,0,0,0.8), rgba(0,0,0,0.8));	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
      <div class="row" style="">

        <div class="col-lg-12 text-white" style="">
          <br>
          <br>
          <!-- Saludo a usario, fecha y hora de visita-->
          <h1 class="d-none d-md-block text-center text-capitalize text-light" style=""><b>Hola <?php echo  $_SESSION['username']; ?>, Fecha: <?php echo  $fecha; ?> Hora: <?php echo  $hora; ?></b></h1>
          
          <!-- Mostrar mapa y ubicación de todos los botes que estan asociados al usuario -->
          <div class="row">
           <div class="col-md-6 text-center" style="">
            <!--<iframe width="100%" height="400" src="https://maps.google.com/maps?q=New%20York&amp;z=14&amp;output=embed" scrolling="no" frameborder="0"></iframe>-->
            <div id="map_markers_div" style="width: 460px; height: 440px"></div>
          </div> 

          <!-- Mostrar datos promedios de la cantidad de todos los residusos que hay en los botes -->
          <div class="col-md-6 text-center ">
            <h1><b>#Botes: <?php echo $c_datos; ?></b></h1>
            <div class="table-responsive">
              <table class="table table-striped table-dark">
                <thead>
                  <tr>
                    <th scope="col">RESIDUO</th>
                    <th scope="col">CANTIDAD (Kg)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>PAPEL</td>
                    <td><?php echo $c_pa; ?></td>
                  </tr>
                  <tr>
                    <td>PLASTICO</td>
                    <td><?php echo $c_plas; ?></td>
                  </tr>
                  <tr>
                    <td>VIDRIO</td>
                    <td><?php echo $c_vi; ?></td>
                  </tr>
                  <tr>
                    <td>ORGANICOS</td>
                    <td><?php echo $c_org; ?></td>
                  </tr>
                  <tr>
                    <td>METAL</td>
                    <td><?php echo $c_me; ?></td>
                  </tr>
                  <tr>
                    <td>CARTÓN</td>
                    <td><?php echo $c_ca; ?></td>
                  </tr>
                  <tr>
                    <td>TOTAL</td>
                    <td><?php echo $total; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
        
      </div>
    </div>

  </div>
</div>
</body>
</html>