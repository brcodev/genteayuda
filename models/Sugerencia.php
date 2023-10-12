<?php

namespace Model;


class Sugerencia extends ActiveRecord
{

    public static $tabla = 'sugerencia';
    public static $columnasDB = ['id', 'nombre', 'apellido', 'mail', 'mensaje', 'create_date'];

    public $id;
    public $nombre;
    public $apellido;
    public $mail;
    public $mensaje;
    public $create_date;

    public function __construct($args = []){

        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->mail = $args['mail'] ?? '';
        $this->mail = $args['mensaje'] ?? '';

    }
}