<?php

namespace Model;

class Zona extends ActiveRecord{
    
    protected static $tabla = 'zonas';
    protected static $columnasDB = ['id', 'zona'];
    
    public $id;
    public $zona;

    public function __construct($args = []){
        
        $this->id = $args['id'] ?? null;
        $this->zona = $args['zona'] ?? '';
    }     
    
}