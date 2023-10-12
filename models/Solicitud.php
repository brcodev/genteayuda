<?php
namespace Model;

use Model\ActiveRecord;

class Solicitud extends ActiveRecord{

    public static $tabla = "solicitud_ayudas";
    public static $columnasDB = ['id', 'form_id', 'ayuda_id'];

    public $id;
    public $form_id;
    public $ayuda_id;

    public function __construct($args = []){

        $this->id = $args['id'] ?? null;
        $this->form_id = $args['form_id'] ?? null;
        $this->ayuda_id = $args['ayuda_id'] ?? null;
    
        
    }

}