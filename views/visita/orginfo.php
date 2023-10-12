<?php

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

if (count($resultado) > 0) {
    foreach ($resultado as $key => $organizacion) {
        $postID = $organizacion->id;
        $name = $organizacion->nombre_organizacion;
        $name_replaced = URLify::filter($name); ?>
        <article class="entrada-blog">
            <h2><?= $organizacion->nombre_organizacion; ?></h2>
            <img src="<?= SERVERURL . $organizacion->folder_path . $organizacion->url_imagen; ?>" alt="Imagen Organizacion">
            <p><i class="<?= $organizacion->icono; ?>"></i>Ayuda entregada: <?= $organizacion->cat_ayuda; ?> </p>
            <p><i class="fas fa-lg fa-building"></i> Dirección: <?= $organizacion->direccion_org; ?></p>
            <p><i class="fas fa-lg fa-phone"></i> teléfono: <?= $organizacion->telefono_org; ?></p>
            <p><i class="fas fa-at"></i> <?= $organizacion->correo_org; ?></p>
            <a href="<?= SERVERURL;?>organizacion/<?= $name_replaced?>?e=<?= $organizacion->id ?>">Ver Organización</a>
        </article>

    <?php } ?>
    <?php if ($allNumRows > $showLimit) { ?>
        <div class="load-more" lastID="<?= $postID; ?>"  zonaID="<?php echo $zona ?? ''; ?>" data-csrf="<?= $_SESSION['token'] ?>" style="display: none;">
            <img src="<?= SERVERURL; ?>build/images/loading.gif" />
        </div>
    <?php } else { ?>
        <div class="load-more back" lastID="0" data-csrf="<?= $_SESSION['token'] ?>">
            <a href="#top">Volver arriba</a>
        </div>
    <?php }
} else { ?>
    <div class="load-more back" lastID="0" data-csrf="<?= $_SESSION['token'] ?>">
        <a href="#top">Volver arriba</a>
    </div>
<?php
}
