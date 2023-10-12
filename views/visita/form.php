<dialog id="loadingModal" class="modal" style="text-align: center;">
    <div class="modal-content text-center">
        <i class="fa fa-spinner fa-spin"></i>
        <span>Enviando...</span>
    </div>
</dialog>
<div class="contacto">

    <h2>Rellena el formulario si quieres recibir información.</h2>

    <div class="formbold-main-wrapper contacto-ins">
        <div class="">

            <form role="form" name="sentForm" id="sentForm" method="POST" action="<?= SERVERURL ?>visita/save">
                <div class="formbold-input-flex">
                    <div>
                        <label for="nombre" class="formbold-form-label">Nombre (OPCIONAL)</label>
                        <input type="text" name="nombre" placeholder="Nombre" maxlength="50" class="formbold-form-input">
                    </div>
                    <div>
                        <label for="apellido" class="formbold-form-label">Apellido (OPCIONAL)</label>
                        <input type="text" name="apellido" placeholder="Apellido" maxlength="50" class="formbold-form-input">
                    </div>
                </div>

                <div class="formbold-input-group">
                    <label class="formbold-form-label">
                        Región en la que busca ayuda.
                    </label>

                    <select class="formbold-form-select" name="region">
                        <option value=""> - Seleccione Región - </option>

                        <?php foreach ($regiones as $region) : ?>
                            <option value="<?= $region->id ?>">
                                <?= $region->region; ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="formbold-input-radio-wrapper">
                    <label for="ayuda" class="formbold-form-label"> Marque que tipos de ayuda desea recibir información</label>

                    <div class="formbold-radio-flex">
                        <div class="formbold-radio-group">
                            <label class="formbold-radio-label">
                                <input class="formbold-input-radio" type="checkbox" name="ayuda[]" value="1">
                                Alimentaria
                                <span class="formbold-radio-checkmark"></span>
                            </label>
                        </div>

                        <div class="formbold-radio-group">
                            <label class="formbold-radio-label">
                                <input class="formbold-input-radio" type="checkbox" name="ayuda[]" value="2">
                                Psicológica
                                <span class="formbold-radio-checkmark"></span>
                            </label>
                        </div>

                        <div class="formbold-radio-group">
                            <label class="formbold-radio-label">
                                <input class="formbold-input-radio" type="checkbox" name="ayuda[]" value="3">
                                Vestuario
                                <span class="formbold-radio-checkmark"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="formbold-input-flex">
                    <div>
                        <label for="nombres" class="formbold-form-label">Correo de contacto</label>
                        <input type="email" name="correo" placeholder="Correo" class="formbold-form-input">
                    </div>
                    <div>
                        <label for="apellidos" class="formbold-form-label">Teléfono (OPCIONAL)</label>
                        <input type="tel" name="telefono" placeholder="Debe contener 9 digitos" class="formbold-form-input">
                    </div>
                </div>

                <div>
                    <label for="message" class="formbold-form-label"> Si lo deseas puedes dejar un mensaje especificando tu situación</label>
                    <textarea rows="6" name="asunto" placeholder="Deja tu mensaje" class="formbold-form-input"></textarea>
                </div>

                <input type="hidden" name="csrf" value="<?= $csrf ?>">
                <button class="formbold-btn">
                    Enviar
                </button>
            </form>
        </div>
    </div>

    <ul class="social-icon" style="margin-top: 6rem; text-align:center; padding: 0">
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

    <ul class="menu" style=" text-align:center; padding: 0">

        <li class="menu__item"><a class="menu__link" href="<?= SERVERURL ?>nosotros">Nosotros</a></li>
        <li class="menu__item"><a class="menu__link" href="<?= SERVERURL ?>categorias">Ayudas</a></li>
        <li class="menu__item"><a class="menu__link" href="<?= SERVERURL ?>contacto">Contacto</a></li>
        <li class="menu__item"><a class="menu__link" href="<?= SERVERURL ?>eventos">Eventos</a></li>

    </ul>
    <p class="menu__item" style="text-align: center;"><a class="menu__link" href="<?= SERVERURL ?>">GENTEAYUDA</a></p>
</div>

</div>
