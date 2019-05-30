<?php
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
}
else{
  if((!isset($_POST['id_usuario_c']) || empty($_POST['id_usuario_c'])) && (!isset($_POST['fecha_activacion']) || empty($_POST['fecha_activacion']))){
    $sql = "SELECT * FROM bd_usuarios";
  //$a = mysqli_query($conexion, $sql);
    $result = mysqli_query($conexion, $sql);
  }
  else{
    if(!isset($_POST['id_usuario_c']) || empty($_POST['id_usuario_c'])){
      $id_consulta = 0;
    }
    else{
      $id_consulta = $_POST['id_usuario_c'];
    }
    if(!isset($_POST['fecha_activacion']) || empty($_POST['fecha_activacion'])){
      $fecha = 0;
    }
    else{
      $fecha = $_POST['fecha_activacion'];
    }  
    $sql = "SELECT * FROM bd_usuarios WHERE ID_USUARIO = '$id_consulta' OR FECHA= '$fecha' ";
  //$a = mysqli_query($conexion, $sql);
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
      <div class="collapse navbar-collapse justify-content-center" id="navbar2SupportedContent">
        <!-- Items de la barra de navegación -->
        <form action="capturar_datos_usuarios_admin.php" method="post">
          <ul class="navbar-nav">
            <!-- Visualización de ingreso de id bote, botón ingresar bote, logo de la empresa -->
            <li class="nav-item mx-2">
              <input type="text" class="form-control btn-lg" placeholder="Ingrese código del bote" name="id_usuario" required="">
            </li>
            <li class="nav-item mx-2">
              <button class="btn btn-dark btn-block mx-2 text-white btn-outline-light" type="submit">Añadir Código</button>
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
        </form>
      </div>
    </div>
  </nav>
  <!-- Portada con imagen -->
  <div class="d-flex align-items-center py-5 cover" style="background-image: url(&quot;CALI_1.jpg&quot;); background-position: left top; background-size: 100%; background-repeat: repeat;">
    <!-- Container con imagen de color negro difuminado -->
    <div class="container" style="	background-image: linear-gradient(to bottom, rgba(0,0,0,0.7), rgba(0,0,0,0.8));	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
      <div class="row" style="">
        <div class="col-lg-12 text-white mt-5" style="">
          <h1 class="d-none d-md-block text-center text-capitalize text-light" style=""><b>Administrador de botes interactivos Cali (Usuarios)</b></h1>
          <!-- Navegador para busquedas de botes para habilitar, deshabilitar(eliminar) -->
          <form action="usuarios_admin.php" method="post">
            <ul class="nav nav-pills navbar-dark justify-content-center py-2">
              <li class="nav-item"> <input type="text" class="form-control " placeholder="Ingrese código de activación" name="id_usuario_c"> </li>
              <li class="nav-item mx-2"> </li>
              <li class="nav-item mx-2"> <input type="text" class="form-control " placeholder="Ingrese fecha de activación" name="fecha_activacion"></li>
              <li class="nav-item mx-2"> <button type="submit" class="btn btn-dark btn-block mx-2 text-white btn-outline-light">
                <font size="3" class="justify-content-start">Buscar</font>
              </button> </li>
            </ul>
          </form>
          <br>
          <!-- Tabla de datos de los bote ingresados al sistema -->
          <form action="desactivar_usuario.php" method="post">
            <div class="table-responsive">
              <table class="table table-striped table-dark">
                <thead>
                  <tr>
                    <th scope="col"></th>
                    <th scope="col">ID_USUARIO</th>
                    <th scope="col">FECHA DE ACTIVACIÓN</th>
                    <th scope="col">ESTADO</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Imprimir datos en tabla con php -->
                  <?php
                  $i = 0;
                  while ($columna = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<th scope='row'><input type='checkbox' id='checkbox[]' name='checkbox[]' value='".$columna['ID_USUARIO'] ."'></th>";
                    echo "<td>" . $columna['ID_USUARIO'] . "</td>";
                    echo "<td>" . $columna['FECHA'] . "</td>";
                    echo "<td>" . $columna['ESTADO'] . "</td>";
                    echo "</tr>";} 
                    ?>

                  </tbody>
                </table>
              </div>
              <!-- Botones de habilitar y deshabilitar --> 
              <div class="row py">
                <div class="text-center btn-block py"><button type="submit" class="btn btn-lg mt-4 btn-outline-light">Cambiar de estado</button></div>
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