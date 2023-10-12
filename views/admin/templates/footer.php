
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<script type="text/javascript">

$(document).ready(function(){$("#admin-logout").on("submit",function(e){e.preventDefault();e=$(this).serializeArray();$.ajax({type:$(this).attr("method"),data:e,url:$(this).attr("action"),dataType:"json",success:function(e){e.result?window.location.href="https://genteayuda.site/":Swal.fire({icon:"error",title:"No se pudo Cerrar Sesión",text:"Intente nuevamente o cierre el navegador"}).then(()=>{setTimeout(()=>{window.location.reload()},100)})}})})}); 

</script>
  
<script src="<?=SERVERURL?>build/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>


<?php

if(!empty($lightbox) || $lightbox != ''){
  echo $lightbox;
} 

if(!empty($jsc) || $jsc!= ''){
  echo $jsc;
} ?> 

<script src="<?=SERVERURL?>build/js/lte-user-app.min.js"></script>
<script src="<?=SERVERURL?>build/js/jquery.dataTables.min.js"></script>
<script src="<?=SERVERURL?>build/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=SERVERURL?>build/js/dataTables.responsive.min.js"></script>
<script src="<?=SERVERURL?>build/js/responsive.bootstrap4.min.js"></script>

<script src="<?=SERVERURL?>build/js/select2.full.min.js"></script>

<script src="<?=SERVERURL?>build/js/daterangepicker.js"></script>

<script src="<?=SERVERURL?>build/js/fontawesome-iconpicker.min.js"></script>

<script src="<?=SERVERURL?>build/js/bs-custom-file-input.min.js"></script>
<script src="<?=SERVERURL?>build/js/slider.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<script src="<?=SERVERURL?>build/js/app.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</body>
</html>