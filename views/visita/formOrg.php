<dialog id="loadingModal" class="modal">
  <div class="modal-content text-center">
    <i class="fa fa-spinner fa-spin"></i>
    <span>Enviando...</span>
  </div>
</dialog>

<div class="formbold-main-wrapper contacto-ins">
    <div class="">
        <form role="form" name="orgForm" id="orgForm" method="POST" action="<?= SERVERURL ?>visita/org">
            <div class="formbold-input-flex">
                <div>
                    <label for="nombres" class="formbold-form-label">Nombres del representante</label>
                    <input type="text" name="nombres" placeholder="Nombres" maxlength="50"  class="formbold-form-input" />
                </div>
                <div>
                    <label for="apellidos" class="formbold-form-label">Apellidos del representante</label>
                    <input type="text" name="apellidos" placeholder="Apellidos"  maxlength="50"  class="formbold-form-input" />
                </div>
            </div>

            <div class="formbold-input-group">
                <div>
                    <label for="nombre_org" class="formbold-form-label">Nombre de la organización a inscribir</label>
                    <input type="text" name="nombre_org" placeholder="Nombre de la organización" maxlength="100"  class="formbold-form-input" />
                </div>
            </div>

            <div class="formbold-input-group">
                <label class="formbold-form-label">
                    Región en la que se entrega ayuda
                </label>

                <select class="formbold-form-select" name="region" >
                    <option value=""> - Seleccione Región -</option>
                    <?php
                    
                    foreach ($regiones as $region) : ?>
                        <option value="<?= $region->id ?>">
                            <?= $region->region; ?>

                        </option>

                    <?php endforeach; ?>

                </select>
                
            </div>

            <div class="formbold-input-radio-wrapper">
                <label for="ayuda" class="formbold-form-label"> Tipo de ayuda entregada </label>

                <div class="formbold-radio-flex">
                    <div class="formbold-radio-group">
                        <label class="formbold-radio-label">
                            <input class="formbold-input-radio" type="radio" name="ayuda" value="1" >
                            Alimentaria
                            <span class="formbold-radio-checkmark"></span>
                        </label>
                    </div>

                    <div class="formbold-radio-group">
                        <label class="formbold-radio-label">
                            <input class="formbold-input-radio" type="radio" name="ayuda" value="2">
                            Psicológica
                            <span class="formbold-radio-checkmark"></span>
                        </label>
                    </div>

                    <div class="formbold-radio-group">
                        <label class="formbold-radio-label">
                            <input class="formbold-input-radio" type="radio" name="ayuda" value="3">
                            Vestuario
                            <span class="formbold-radio-checkmark"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="formbold-input-flex">
                <div>
                    <label for="nombres" class="formbold-form-label">Correo de contacto</label>
                    <input type="email" name="correo" placeholder="Correo" maxlength="100"  class="formbold-form-input" />
                </div>
                <div>
                    <label for="apellidos" class="formbold-form-label">Teléfono representante</label>
                    <input type="tel" name="telefono" placeholder="912345678" class="formbold-form-input"  />
                </div>
            </div>

            <div>
                <label for="message" class="formbold-form-label"> Deja un mensaje especificando en que consiste tu organización</label>
                <textarea rows="6" name="asunto" placeholder="Deja tu mensaje" class="formbold-form-input" ></textarea>
            </div>

            <input type="hidden" name="csrf" value="<?= $csrf ?>">           
            <button class="formbold-btn">
                Enviar Solicitud
            </button>
        </form>
    </div>
</div>
