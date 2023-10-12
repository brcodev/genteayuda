<?php

namespace Model;


class Reclamo extends ActiveRecord
{

    public static $tabla = 'reclamo';
    public static $columnasDB = ['id', 'nombre', 'apellido', 'mail', 'mensaje', 'create_date', 'status', 'admin_observation', 'resolution_date'];

    public $id;
    public $nombre;
    public $apellido;
    public $mail;
    public $mensaje;
    public $create_date;
    public $status;
    public $admin_observation;
    public $resolution_date;

    public function __construct($args = []){

        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->mail = $args['mail'] ?? '';
        $this->mensaje = $args['mensaje'] ?? '';
        $this->status = $args['status'] ?? '';
        $this->resolution_date = $args['res_date'] ?? '';
        $this->admin_observation = $args['obs'] ?? '';

    }
}