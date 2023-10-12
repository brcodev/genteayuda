<?php

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

if (count($result) > 0) {
    foreach ($result as $key => $evento) {
        $postID = $evento->id;
        $name = $evento->nombre_evento;
        $name_evento = URLify::filter($name); ?>
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
    <?php if ($allNumRows > $showLimit) { ?>
        <div class="load-more" lasteventID="<?= $postID; ?>" zonaID="<?= $zona ?? ''; ?>" data-csrf="<?= $_SESSION['token'] ?>" style="display: none;">
            <img src="<?= SERVERURL; ?>build/images/loading.gif" />
        </div>
        
    <?php } else { ?>
        <div class="load-more" lasteventID="0" data-csrf="<?= $_SESSION['token'] ?>">
            <a href="#top">Volver arriba</a>
        </div>
    <?php }
} else { ?>
    <div class="load-more" lasteventID="0" data-csrf="<?= $_SESSION['token'] ?>">
        <a href="#top">Volver arriba</a>
    </div>
<?php
}
