<?php

namespace Model;

use Model\ActiveRecord;

class OrgRequest extends ActiveRecord{
    public static $tabla = 'org_form';
    public static $columnasDB = ['id', 'nombres', 'apellidos', 'org_name', 'help', 'region', 'zona_form', 'mail', 'phone', 'description', 'date_creation', 'admin_observation', 'status', 'status_by', 'date_approved', 'published']; 
    
    public $id;
    public $nombres;
    public $apellidos;
    public $org_name;
    public $help;
    public $region;
    public $zona_form;
    public $mail;
    public $phone;
    public $description;
    public $date_creation;
    public $admin_observation;
    public $status;
    public $status_by;
    public $date_approved;
    public $published;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombres= $args['nombres'] ?? '';
        $this->apellidos= $args['apellidos'] ?? '';
        $this->org_name= $args['nombre_org'] ?? '';
        $this->help = $args['ayuda'] ?? '';
        $this->region = $args['region'] ?? '';
        $this->zona_form = $args['zona_form'] ?? '';
        $this->mail = $args['correo'] ?? '';
        $this->phone = $args['telefono'] ?? '';
        $this->description = $args['asunto'] ?? '';
        $this->date_creation = $args['date_creation'] ?? '';
        $this->admin_observation = $args['admin_observation'] ?? '';
        $this->status = $args['status'] ?? '';
        $this->status_by = $args['status_by'] ?? '';
        $this->date_approved = $args['status'] ?? '';
        $this->published = $args['published'] ?? '';

    }
}