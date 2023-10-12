<?php

namespace Model;

class Regiones extends ActiveRecord {

    public static $tabla = 'regiones';
    public static $columnasDB = ['id', 'region'];

    public $id;
    public $region;

    public function __construct($args = []){

        $this->id = $args['id'] ?? null;
        $this->region = $args['region'] ?? ''; 
    
    }

}

