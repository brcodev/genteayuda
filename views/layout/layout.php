<!doctype html>
<html class="no-js" lang="">

<head>
  
  <meta charset="utf-8">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  

  <link rel="stylesheet" href="<?php echo SERVERURL;?>build/css/normalize.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo SERVERURL;?>build/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo SERVERURL;?>build/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Oswald:wght@200;300;400;500;600;700&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito&family=Padauk&family=Poppins&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet"> 
  
  

  <meta name="theme-color" content="#fafafa">
</head>

<body>

    <div class="barra">

       <div class="menu-movil">
          <span></span>
          <span></span>
          <span></span>
        </div>

        <nav class="navegacion-principal">
            <a href="<?php echo SERVERURL;?>">Inicio</a>
            <a href="<?php echo SERVERURL;?>nosotros">Nosotros</a>
            <a href="<?php echo SERVERURL;?>categorias">Ayudas</a>
            <a href="<?php echo SERVERURL;?>contacto">Contacto</a>
            <a href="<?php echo SERVERURL;?>eventos">Eventos sociales</a>
        </nav>
    </div>

    <?php echo $contenido; ?>

    <?php echo $script ?? ''; ?>

</body>
</html>    