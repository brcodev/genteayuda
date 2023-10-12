<?php

namespace Model;

class Categoria extends ActiveRecord{
    
    public static $tabla = 'categoria_ayuda';
    public static $columnasDB = ['id', 'cat_ayuda', 'icono'];

    public $id;
    public $cat_ayuda;
    public $icono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->cat_ayuda = $args['cat_ayuda'] ?? '';
        $this->icono = $args['icono'] ?? '';
    }



}