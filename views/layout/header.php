<!doctype html>
<html class="no-js" lang="es">

<head>
  
  <meta charset="utf-8">
  <title>GenteAyuda</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <link rel="icon" href="<?php echo SERVERURL;?>favicon.png" type="image/x-icon">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="<?php echo SERVERURL;?>build/css/normalize.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo SERVERURL;?>build/css/all.min.css">
  <link rel="stylesheet" href="https://genteayuda.site/build/css/lightbox.css">
  <!-- Ionicons <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo SERVERURL;?>build/css/style.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Oswald:wght@200;300;400;500;600;700&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito&family=Padauk&family=Poppins&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet"> 
<script
src="https://code.jquery.com/jquery-3.7.0.min.js"
integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
crossorigin="anonymous">
</script>
  
  <?php
    $archivo = basename($_SERVER['PHP_SELF']); //Retrona el nombre del archivo actual
    $pagina = str_replace(".php", "", $archivo); //toma 3 parametros lo que se busca, el valor por el cual sera remplazado y la fuente de los datos
    if($pagina === "organizacion" ||  $pagina === "evento"):
      
      echo "<link href='".SERVERURL."build/css/lightbox.min.css' rel='stylesheet' />";

    endif;

    ?>
    
  

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
            <a href="<?php echo SERVERURL;?>eventos">Eventos</a>
        </nav>
    </div>

    
   

    
