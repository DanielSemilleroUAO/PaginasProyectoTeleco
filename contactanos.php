<?php
//---Capturar datos del formulario (name del input)
$correo = $_POST['correo'];
$mensaje = $_POST['mensaje'];
 ?>
<!-- Pagina para mostrar datos capturados de contactanos-->
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
  <!-- Logos usados en la pagina -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
</head>
<body>
    <div class="d-flex align-items-center py-5 cover" style="   background-image: url(CALI_1.jpg);  background-position: left top;  background-size: 100%;  background-repeat: repeat;">
    <div class="container">
      <div class="row" style="">
        <br>
        <div class="col-lg-12 text-white mt-5" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,0.8), rgba(0,0,0,0.8)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
          <br>
          <!-- Nombre de la empresa-->
          <h1 class="d-none d-md-block text-light" style="">Hola <?php echo $correo?>, un gusto escucharte. Tu solicitud fue exitosa.</h1>
          <br>
          <h3 class="d-none d-md-block text-light">Tu mensaje o inquietud es la siguiente:<br>
            <?php echo $mensaje?>     
          </h3>
          <div class="row">
            
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <!-- Botón de login -->
              <div class="col-md-12 text-center" ><a href="index.html" class="btn btn-lg mt-4 btn-outline-light">Volver al inicio</a></div>
            </div>
          </div>
          <br>
        </div>
      </div>
    </div>
  </div>
</body>
</html>