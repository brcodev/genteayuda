<?php if(!isset($display) || empty($display)){
   $display = "";
} ?>

<footer class="footer" style="<?= $display ?> background: <?= $color ?> ">
  
    <ul class="social-icon">
      <li class="social-icon__item"><a class="social-icon__link" href="#">
        <i class="fa-brands fa-facebook-f" style="color:<?= $a ?>"></i>
        </a></li>
      <li class="social-icon__item"><a class="social-icon__link" href="#">
        <i class="fa-brands fa-twitter" style="color:<?= $a ?>"></i>
        </a></li>
      <li class="social-icon__item"><a class="social-icon__link" href="#">
        <i class="fa-brands fa-instagram" style="color:<?= $a ?>"></i>
        </a></li>
    </ul>
    <ul class="menu" style="text-align:center; padding: 0">

    <style>
      .menu__link{
        color: <?= $a ?>;
      }

    </style>


        <li class="menu__item"><a class="menu__link" href="<?= SERVERURL ?>nosotros">Nosotros</a></li>
        <li class="menu__item"><a class="menu__link" href="<?= SERVERURL ?>categorias">Ayudas</a></li>
        <li class="menu__item"><a class="menu__link" href="<?= SERVERURL ?>contacto">Contacto</a></li>
        <li class="menu__item"><a class="menu__link" href="<?= SERVERURL ?>eventos">Eventos</a></li>
    </ul>
    <p class="menu__item" style="text-align: center;"><a class="menu__link"  href="<?= SERVERURL ?>">GENTEAYUDA</a></p>
  </footer>

  
  <script src="<?php echo SERVERURL;?>build/js/modernizr-3.8.0.min.js"></script>
  
  <!-- Bootstrap 4 -->
  <script src="<?php echo SERVERURL;?>build/js/lightbox.min.js"></script>
  <script src="<?php echo SERVERURL;?>build/js/tinysort.min.js"></script>
  <script src="<?php echo SERVERURL;?>build/js/main.js"></script>

  <?php if(!$slider_off) : ?>
    <script src="<?php echo SERVERURL;?>build/js/slider.js"></script>
  <?php endif; ?>  

  <script src="<?php echo SERVERURL;?>build/js/main.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <!-- Footer -->
  
  
</body>

</html>
