<?php
//---Variables de sesion
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
} else {
  echo "<script type='text/javascript'>window.alert('Esta pagina es solo para usuarios registrados.');</script>";
  echo "<script type='text/javascript'>location.href='index.html'</script>";
  exit;
}
$now = time();
//----Verificar tiempo de sesion
if($now > $_SESSION['expire']) {
  session_destroy();
  echo "<script type='text/javascript'>window.alert('Su sesion a terminado, necesita hacer login');</script>";
  echo "<script type='text/javascript'>location.href='index.html'</script>";
  exit;
}
//---Tomar la hora de la zona en que se encuentra el servidor
date_default_timezone_set('America/Bogota');
$mydate=getdate();
$fecha_final = date("Y-m-d");
$fecha_inicio = date("Y-m-d", strtotime( '-1 days' ) );
$fecha = "$mydate[year]/$mydate[mon]/$mydate[mday]";
$hora= "$mydate[hours]:$mydate[minutes]:$mydate[seconds]";
//----------------------------fechas
if(!isset($_POST['fecha_inicio_c']) || empty($_POST['fecha_inicio_c'])){
  $fecha_i = $fecha_inicio;
}
else{
  $fecha_i = $_POST['fecha_inicio_c'];
}
if(!isset($_POST['fecha_final_c']) || empty($_POST['fecha_final_c'])){
  $fecha_f = $fecha_final;
}
else{
  $fecha_f = $_POST['fecha_final_c'];
}

//--------------------------horas
date_default_timezone_set('America/Bogota');
if(!isset($_POST['hora_inicio_c']) || empty($_POST['hora_inicio_c'])){
  $hora_i = date('H:i').":00";
}
else{
  $hora_i = $_POST['hora_inicio_c'];
}
if(!isset($_POST['hora_final_c']) || empty($_POST['hora_final_c'])){
  $hora_f = date('H:i').":00";
}
else{
  $hora_f = $_POST['hora_final_c'];
}
//---Cambiar - por / para el formato que se envía desde el hardware (Poder comparar)
$fecha_i_c = str_replace("-","/",$fecha_i);
$fecha_f_c = str_replace("-","/",$fecha_f);
//---Capturar dato enviado por el método GET
$id_bote = $_GET["id_bote"];
//--- Info-base-de-datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_usuarios";
//------Conexión-base-de-datos
$conexion = new mysqli($servername, $username, $password, $dbname);
if ($conexion->connect_error) {
  //---Error en la conexión o la base de datos no existe
  echo "<script type='text/javascript'>window.alert('Error de conexión a la base de datos');</script>";
}
else{
//---Variables acomuladores del bote asociado
 $c_pa=0;
 $c_me=0;
 $c_vi=0;
 $c_ca=0;
 $c_org=0;
 $c_plas=0;
 $total=0;
 //---Consulta para traer todos los datos asociados al bote
 $sql = "SELECT * FROM historial WHERE FECHA BETWEEN '$fecha_i_c-$hora_i' AND '$fecha_f_c-$hora_f' AND C_PLA != 'NULL' AND C_PLA != '' AND C_ORG != 'NULL' AND C_ORG != '' AND C_PA != 'NULL' AND C_PA != '' AND C_VI != 'NULL' AND C_VI != '' AND C_CAR != 'NULL' AND C_CAR != '' AND C_MET != 'NULL' AND C_MET != '' AND ID_BOTE = '$id_bote'";
 $result = mysqli_query($conexion, $sql);
 $row_cnt = $result->num_rows;
 if($row_cnt > 0){
  while($row = mysqli_fetch_array($result))  
  {  
    $c_pa+=floatval($row['C_PA']);
    $c_me+=floatval($row['C_MET']);
    $c_vi+=floatval($row['C_VI']);
    $c_ca+=floatval($row['C_CAR']);
    $c_org+=floatval($row['C_ORG']);
    $c_plas+=floatval($row['C_PLA']);
  }
}
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
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" style="">
    // Load Charts and the corechart package.
    google.charts.load('current', {
      'packages': ['corechart', 'line']
    });
    google.charts.setOnLoadCallback(drawBasic1);
    
    function drawBasic1() {

      var data = google.visualization.arrayToDataTable([  
        ['fecha', 'pla', 'org', 'pa', 'vi', 'car', 'met','low','Avg','High'],  
        <?php
        $conexion = new mysqli($servername, $username, $password, $dbname);
        $sql = "SELECT * FROM historial WHERE FECHA BETWEEN '$fecha_i_c-$hora_i' AND '$fecha_f_c-$hora_f' AND C_PLA != 'NULL' AND C_PLA != '' AND C_ORG != 'NULL' AND C_ORG != '' AND C_PA != 'NULL' AND C_PA != '' AND C_VI != 'NULL' AND C_VI != '' AND C_CAR != 'NULL' AND C_CAR != '' AND C_MET != 'NULL' AND C_MET != '' AND ID_BOTE = '$id_bote'";
        $result = mysqli_query($conexion, $sql);
        $row_cnt = $result->num_rows;
        if($row_cnt > 0){
          while($row = mysqli_fetch_array($result))  
          {  
            echo "['".$row["FECHA"]."', ".$row["C_PLA"].",".$row["C_ORG"].",".$row["C_PA"].",".$row["C_VI"].",".$row["C_CAR"].",".$row["C_MET"].",20,10,20],";  
          }
        }
        else{ 
          echo "[0,0,0,0,0,0,0,20,20,20]";
        }
        mysqli_close($conexion);
        ?>  
        ]);  

      var options = {
        hAxis: {
          title: 'Fecha'
        },
        vAxis: {
          title: 'Cantidad de residuos (kg)',
          viewWindow: {
            max:50,
            min:0
          }
        },
        isStacked: true,
        series: {
          0: {
            type: 'line',
            color:'black'
          },
          1: {
            type: 'line',
            color:'green'
          },
          2: {
            type: 'line',
            color:'yellow'
          },
          3: {
            type: 'line',
            color:'blue'
          },
          4: {
            type: 'line',
            color:'brown'
          },
          5: {
            type: 'line',
            color:'gray'
          },
          6: {
            lineWidth: 0,
            type: 'area',
            visibleInLegend: false,
            enableInteractivity: false,
            color:'green'
          },
          7: {
            lineWidth: 0,
            type: 'area',
            visibleInLegend: false,
            enableInteractivity: false,
            color:'green'
          },
          8: {
            lineWidth: 0,
            type: 'area',
            visibleInLegend: false,
            enableInteractivity: false,
            color:'red'
          }
        },
        width: 450,
        height: 400,
        axes: {
          x: {
            0: {
              side: 'center'
            }
          }
        }
      };

      var chart = new google.visualization.ComboChart(document.getElementById('chart_1'));

      chart.draw(data, options);
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
            <a class="btn btn-dark btn-block mx-2 text-white btn-outline-light" href="AdminBotesUsuario.php">Añadir bote</a>
          </li>
          <li class="nav-item mx-2">
            <a class="btn btn-dark btn-block mx-2 text-white btn-outline-light" href="panel_control.php">Ir panel de control</a>
          </li>
          <li class="nav-item mx-2">
            <a class="btn btn-dark btn-block mx-2 text-white btn-outline-light" href=<?php echo "'historial_bote.php?id_bote=".$id_bote."'"; ?> >Actualizar datos</a>
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
  <!-- Portada con imagen de fondo -->
  <div class="d-flex align-items-center p-2 cover" style="background-image: url(&quot;CALI_1.jpg&quot;); background-position: left top; background-size: 100%; background-repeat: repeat;">
    <!-- Container con color negro difuminado -->
    <div class="container" style="	background-image: linear-gradient(to bottom, rgba(0,0,0,0.8), rgba(0,0,0,0.8));	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
      <div class="row" style="">
        <div class="col-lg-12 text-white " style="">
          <br>
          <br>
          <!-- Mostrar el nombre que usuario asigno al bote, fecha y hora de visualización de los datos -->
          <h2 class="d-none d-md-block text-center text-capitalize text-light" style=""><b>Esta viendo <?php echo $id_bote; ?>, Fecha: <?php echo $fecha; ?> Hora: <?php echo $hora;?></b></h2>
          <div class="row">
            <!-- Agregar grafica de google charts que va contener los datos del bote que se esta viendo el historial -->
            <!--<div class="col-md-6" style=""><img class="img-fluid d-block" src="https://static.pingendo.com/img-placeholder-1.svg" width="300" height="500"></div> -->
            <div class="mx-2" id="chart_1" ></div>
            <div class="col-md-6">
              <!-- Mostrar datos promedios de la cantidad de todos los residusos que hay en los botes -->
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
      <form action=<?php echo "'historial_bote.php?id_bote=".$id_bote."'"; ?> method="post">
        <div class="row">
          <!-- Ingreso de fechas y horas para una consulta deseada -->
          <div class="mx-2 text-white text-center" style="">
            <label sfor="bday">Fecha inicio:</label>
            <input class="mx-2" type="date" id="dia_inicio_t" name="fecha_inicio_c" required="" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="<?php echo $fecha_i;?>"> Hora inicio<input class="mx-2" type="time" id="tiempo_inicio_t" name="hora_inicio_c" value="<?php echo $hora_i;?>" required="">
            <label for="bday">Fecha final:</label>
            <input class="mx-2" type="date" id="dia_final_t" name="fecha_final_c" required="" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="<?php echo $fecha_f;?>"> Hora final<input class="mx-2" type="time" id="tiempo_final_t" name="hora_final_c" value="<?php echo $hora_f;?>" required="">
          </div>
          <div class="text-center mx-2">
            <div class="row text-center">
              <!-- Actualizar graficas, datos recolectados y promedio de residuos recolectados -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12"><button type="submit" class="btn btn-block text-white btn-outline-light">Actualizar Consulta</button></div>
        </div>
      </form>
    </div>
  </div>
  <?php echo $fecha_f;?>
</body>

</html>