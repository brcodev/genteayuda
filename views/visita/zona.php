<?php

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

if (isset($resultado) && !empty($resultado)) {

    foreach ($resultado as $key => $organizacion) {
        $postID = $organizacion->id;
        $name = $organizacion->nombre_organizacion;
        $name_replaced = URLify::filter($name); 
        ?>

        <article class="entrada-blog">
            <h2><?= $organizacion->nombre_organizacion; ?></h2>
            <img src="<?= SERVERURL . $organizacion->folder_path . $organizacion->url_imagen; ?>" alt="Imagen Organizacion">
            <p><i class="<?php echo $organizacion->icono; ?>"></i>Ayuda entregada: <?= $organizacion->cat_ayuda; ?> </p>
            <p><i class="fas fa-lg fa-building"></i> Dirección: <?= $organizacion->direccion_org; ?></p>
            <p><i class="fas fa-lg fa-phone"></i> teléfono: <?= $organizacion->telefono_org; ?></p>
            <p><i class="fas fa-at"></i> <?= $organizacion->correo_org; ?></p>
            <a href="<?= SERVERURL;?>organizacion/<?= $name_replaced?>?e=<?= $organizacion->id ?>">Ver Organización</a>
        </article>
    <?php } ?>

    <div class="load-more" lastID="<?= $postID; ?>" zonaID="<?= $zona ?? ''; ?>" data-csrf="<?= $_SESSION['token'] ?>" style="display: none;">
        <img src="<?php echo SERVERURL; ?>images/loading.gif" />
    </div>

    <?php } else if (isset($result) && !empty($result)) {

    foreach ($result as $key => $evento) {
        $postID = $evento->id;
        $name = $evento->nombre_evento;
        $name_evento = URLify::filter($name);
         ?>
        
        <article class="entrada-blog">
            <h2><?= $evento->nombre_evento; ?></h2>
            <img src="<?php echo SERVERURL . $evento->folder_path . $evento->url_img_evento ?>" alt="Imagen evento">
            <p><i class="<?= $evento->icono; ?>"></i> Ayuda entregada: <?= $evento->cat_ayuda; ?> </p>
            <p><i class="fas fa-lg fa-building"></i> Dirección: <?= $evento->direccion_evento; ?></p>
	    <p><i class="fa-solid fa-calendar"></i> Fecha: <?= date("d-m-Y", strtotime($evento->fecha_evento)) ?></p>
            <p><i class="fa-solid fa-clock"></i> Hora: <?= date("H:i", strtotime($evento->hora_evento)); ?> Hrs.</p>
            <a href="<?= SERVERURL ?>evento/<?= $name_evento ?>?e=<?= $evento->id ?>">Ver Evento</a>
        </article>
    <?php } ?>

    <div class="load-more" lasteventID="<?= $postID; ?>" zonaID="<?= $zona ?? ''; ?>" data-csrf="<?= $_SESSION['token'] ?>" style="display: none;">
        <img src="<?= SERVERURL; ?>images/loading.gif" />
    </div>
    

<?php } ?>
