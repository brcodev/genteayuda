<?php

namespace Model;

class Evento extends ActiveRecord{
    
    public static $tabla = 'eventos';
    public static $columnasDB = ['id', 'nombre_evento', 'fecha_evento', 'hora_evento', 'direccion_evento', 'eve_zona_id', 'descripcion_evento', 'id_cat_ayuda', 'id_org', 'folder_path', 'url_img_evento', 'creation_date', 'editado' ];

    public $id;
    public $nombre_evento;
    public $fecha_evento;
    public $hora_evento;
    public $direccion_evento;
    public $eve_zona_id;
    public $descripcion_evento;
    public $id_cat_ayuda;
    public $id_org;
    public $folder_path;
    public $url_img_evento;
    public $creation_date;
    public $editado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre_evento = $args['nombre'] ?? '';
        $this->fecha_evento = $args['fecha'] ?? '';
        $this->hora_evento = $args['hora'] ?? '';
        $this->direccion_evento = $args['address'] ?? '';
        $this->eve_zona_id = $args['zona'] ?? '';
        $this->descripcion_evento = $args['descripcion'] ?? '';
        $this->id_cat_ayuda = $args['ayuda'] ?? '';
        $this->id_org = $args['org'] ?? '';
        $this->folder_path = $args['path'] ?? '';
        $this->url_img_evento = $args['img'] ?? '';
        $this->editado = $args['edit'] ?? '';

    }


    public static function queryJoin(String $where = ""){
        $sql = "SELECT * ";
        $sql .= " FROM eventos e ";
        $sql .= " INNER JOIN zonas z ";
        $sql .= " ON e.eve_zona_id=z.id ";
        $sql .= " INNER JOIN categoria_ayuda c ";
        $sql .= " ON e.id_cat_ayuda=c.id ";
        $sql .= " INNER JOIN organizaciones o ";
        if($where != ""){
            $sql .= " ON e.id_org=o.id WHERE nombre_evento = '$where' ";
        }else{
            $sql .= " ON e.id_org=o.id";
        }
        

        return $sql;

    }



}