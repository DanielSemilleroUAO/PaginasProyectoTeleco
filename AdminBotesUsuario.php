<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
} else {
  echo "<script type='text/javascript'>window.alert('Esta pagina es solo para usuarios registrados.');</script>";
  echo "<script type='text/javascript'>location.href='index.html'</script>";
  exit;
}
$now = time();
if($now > $_SESSION['expire']) {
  session_destroy();
  echo "<script type='text/javascript'>window.alert('Su sesion a terminado, necesita hacer login');</script>";
  echo "<script type='text/javascript'>location.href='index.html'</script>";
  exit;
}
//--- Info-base-de-datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_usuarios";
//------Conexión-base-de-datos
$conexion = new mysqli($servername, $username, $password, $dbname);
if ($conexion->connect_error) {
  //---Error de conexión a la base datos (No existe)
  echo "<script type='text/javascript'>window.alert('Error de conexión a la base de datos');</script>";
}
else{
  //---Si las variables del formulario estan vacias muestra todos los botes 
  if((!isset($_POST['id_bote_consulta']) || empty($_POST['id_bote_consulta'])) && (!isset($_POST['fecha_activacion']) || empty($_POST['fecha_activacion']))){
    $id_usuario = $_SESSION['id_usuario'];
    $sql = "SELECT * FROM botes WHERE ID_USUARIO = '$id_usuario'";
    $result = mysqli_query($conexion, $sql);
  }
  else{
    //---Hacer consulta con datos ingresados (ID o fecha de ingreso al sistema)
    $id_consulta = $_POST['id_bote_consulta'];
    $fecha = $_POST['fecha_activacion'];
    $sql = "SELECT * FROM botes WHERE ID_BOTE = '$id_consulta' OR FECHA= '$fecha' ";
    $result = mysqli_query($conexion, $sql);
  }
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
</head>
<body class="text-center">
  <!-- Barra de navegación  -->
  <nav class="navbar navbar-expand-md fixed-top bg-dark navbar-dark">
    <div class="container">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="
      " data-target="#navbar2SupportedContent" aria-controls="navbar2SupportedContent" aria-expanded="false" aria-label="Toggle navigation" style=""> <span class="navbar-toggler-icon"></span> </button>
      <form action="admin_botes_usuarios.php" method="post">
        <div class="collapse navbar-collapse justify-content-center" id="navbar2SupportedContent">
          <!-- Items de la barra de navegación -->
          <ul class="navbar-nav">
            <!-- Visualización de ingreso de id bote, botón ingresar bote, logo de la empresa -->
            <li class="nav-item mx-2">
              <input name="id_bote" type="text" class="form-control btn-lg" placeholder="Ingrese código del bote" required="">
            </li>
            <li class="nav-item mx-2">
              <button type="submit" class="btn btn-dark btn-block mx-2 text-white btn-outline-light">Añadir bote</button>
            </li>
            <li class="nav-item mx-2">
             <a class="btn btn-dark btn-block mx-2 text-white btn-outline-light" href="panel_control.php">Ir panel de control</a>
           </li>
           <li class="nav-item mx-2">
             <a class="btn btn-dark btn-block mx-2 text-white btn-outline-light" href="cerrar_sesion.php">Cerrar sesion</a>
           </li>
           <li class="nav-item mx-2">
            <img class="img-fluid d-block" src="Logo.gif" width="50" draggable="true">
          </li>
          <li class="nav-item mx-2">
            <img class="img-fluid d-block" src="Logo_empresa.png" width="40" height="38">
          </li>
        </ul>
      </div>
    </form>
  </div>
</nav>
<!-- Portada con imagen -->
<div class="d-flex align-items-center py-5 cover" style="background-image: url(&quot;CALI_1.jpg&quot;); background-position: left top; background-size: 100%; background-repeat: repeat;">
  <!-- Container con imagen de color negro difuminado -->
  <div class="container" style="	background-image: linear-gradient(to bottom, rgba(0,0,0,0.7), rgba(0,0,0,0.8));	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
    <div class="row" style="">
      <div class="col-lg-12 text-white mt-5" style="">
        <h1 class="d-none d-md-block text-center text-capitalize text-light" style=""><b>Administrar botes</b></h1>
        <!-- Navegador para busquedas de botes para habilitar, deshabilitar(eliminar) -->
        <form action="AdminBotesUsuario.php" method="post">
          <ul class="nav nav-pills navbar-dark justify-content-center py-2">
            <li class="nav-item"> <input type="text" class="form-control " placeholder="Ingrese código del bote" name="id_bote_consulta"> </li>
            <li class="nav-item mx-2"> </li>
            <li class="nav-item mx-2"> <input type="text" class="form-control " placeholder="Ingrese fecha de activación" name="fecha_activacion"></li>
            <li class="nav-item mx-2"> <button type="submit" class="btn btn-dark btn-block mx-2 text-white btn-outline-light">
              <font size="3" class="justify-content-start">Buscar</font>
            </button> </li>
          </ul>
        </form>
        <br>
        <!-- Tabla de datos de los bote ingresados al sistema -->
        <form action="actualizar_tablas_usuarios.php" method="post">
          <div class="table-responsive">
            <table class="table table-striped table-dark">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col">ID_BOTE</th>
                  <th scope="col">FECHA DE ACTIVACIÓN</th>
                </tr>
              </thead>
              <tbody>
               <!-- Imprimir datos en tabla con php -->
               <?php
               $i = 0;
               while ($columna = mysqli_fetch_array($result)){
                echo "<tr>";
                echo "<th scope='row'><input type='checkbox' id='checkbox[]' name='checkbox[]' value='".$columna['ID_BOTE'] ."'></th>";
                echo "<td>" . $columna['ID_BOTE'] . "</td>";
                echo "<td>" . $columna['FECHA'] . "</td>";
                echo "</tr>";} 
                ?>
              </tbody>
            </table>
          </div>
          <!-- Botones de habilitar y deshabilitar --> 
          <div class="row">
            <div class="text-center btn-block">
              <button type="submit" class="btn btn-lg mt-4 btn-outline-light">Eliminar</button>
            </div>
          </div>
        </form>
        <br>
      </div>
    </div>
    <div class="row"></div>
  </div>
</div>
</body>
</html>