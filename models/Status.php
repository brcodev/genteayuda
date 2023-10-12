<?php

namespace Model;

use DateTime;

class Status extends ActiveRecord
{

    public static $tabla = 'org_status';
    public static $columnasDB = ['id', 'status'];

    public $id;
    public $status;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->status = $args['status'] ?? '';
    }
}