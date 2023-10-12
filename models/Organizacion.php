<?php

namespace Model;

class Organizacion extends ActiveRecord{
    
    public static $tabla = 'organizaciones';
    public static $columnasDB = ['id', 'nombre_organizacion', 'id_registered', 'correo_org', 'telefono_org', 'direccion_org', 'id_region',
                                 'org_zona_id', 'id_ayuda_entregada', 'descripcion_organizacion', 'folder_path', 'url_imagen', 'in_link', 'fb_link', 'tw_link', 'fecha_creacion_org'
                                 ];

   public $id, $nombre_organizacion, $id_registered, $correo_org, $telefono_org, $direccion_org, $id_region, $org_zona_id, $id_ayuda_entregada,
          $descripcion_organizacion, $folder_path, $url_imagen, $in_link, $fb_link, $tw_link, $fecha_creacion_org, $org_editado;
          
          
   public function __construct($args = [])
   {
       $this->id = $args['id'] ?? null;
       $this->nombre_organizacion = $args['nombre'] ?? '';
       $this->id_registered = $args['registered'] ?? '';
       $this->correo_org = $args['correo'] ?? '';
       $this->telefono_org = $args['telefono'] ?? null;
       $this->direccion_org = $args['direccion'] ?? null;
       $this->id_region = $args['region'] ?? '';
       $this->org_zona_id = $args['zona'] ?? '';
       $this->id_ayuda_entregada = $args['ayuda'] ?? '';
       $this->descripcion_organizacion = $args['descripcion'] ?? '';
       $this->folder_path = $args['path'] ?? '';
       $this->url_imagen = $args['image'] ?? '';
       $this->in_link = $args['in_link'] ?? null;
       $this->fb_link = $args['fb_link'] ?? null;
       $this->tw_link = $args['tw_link'] ?? null;
       $this->fecha_creacion_org = $args['fecha'] ?? '';
       $this->org_editado = $args['edit'] ?? '';

   }

}