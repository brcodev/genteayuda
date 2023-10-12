<?php

namespace Model;

use Model\ActiveRecord;

class Visita extends ActiveRecord{

    public static $tabla = 'formulario_visitas';
    public static $columnasDB = ['id', 'nombre_visita', 'apellido_visita', 'id_region', 'form_zona', 'correo_visita', 'telefono_visita', 'descripcion_visita', 'fecha_formulario']; 
    
    public $id;
    public $nombre_visita;
    public $apellido_visita;
    public $id_region;
    public $form_zona;
    public $correo_visita;
    public $telefono_visita;
    public $descripcion_visita;
    public $fecha_formulario;
    

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre_visita = $args['nombre'] ?? '';
        $this->apellido_visita = $args['apellido'] ?? '';
        $this->id_region = $args['region'] ?? '';
        $this->form_zona = $args['form_zona'] ?? '';
        $this->correo_visita = $args['correo'] ?? '';
        $this->telefono_visita = $args['telefono'] ?? '';
        $this->descripcion_visita = $args['asunto'] ?? '';
        $this->fecha_formulario = $args['fecha'] ?? '';
              
    }
 
}