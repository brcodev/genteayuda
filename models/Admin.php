<?php

namespace Model;

use DateTime;

class Admin extends ActiveRecord
{

    public static $tabla = 'admins';
    public static $columnasDB = ['id', 'usuario', 'nombre', 'apellido', 'correo_admin', 'tel', 'image', 'password', 'nivel', 'access_token', 'actual_login', 'last_login', 'codigo', 'token_creation', 'token_expires', 'editado', 'fecha_creacion', 'attempts', 'fecha_recuperacion'];

    public $id;
    public $usuario;
    public $nombre;
    public $apellido;
    public $correo_admin;
    public $tel;
    public $image;
    public $password;
    public $nivel;
    public $access_token;
    public $actual_login;
    public $last_login;
    public $codigo;
    public $token_creation;
    public $token_expires;
    public $editado;
    public $fecha_creacion;
    public $fecha_recuperacion;
    public $attempts;

    public function __construct($args = []){
    
        $this->id = $args['id'] ?? null;
        $this->usuario = $args['usuario'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->correo_admin = $args['correo'] ?? '';
        $this->tel = $args['telefono'] ?? null;
        $this->image = $args['image'] ?? null;
        $this->password = $args['password'] ?? '';
        $this->nivel = $args['type'] ?? 1;
        $this->access_token = $args['access_token'] ?? null;
        $this->actual_login = $args['actual_login'] ?? date('Y-m-d H:i:s');
        $this->last_login = $args['last_login'] ?? null;
        $this->codigo = $args['codigo'] ?? ''; 
        $this->editado = $args['editado'] ?? null;
        $this->fecha_recuperacion = $args['recuperacion'] ?? null;
        $this->attempts = $args['attempts'] ?? null;
    }


    public function syncAdmin($args = []){

        $this->id = $args['id'] ?? null;
        $this->usuario = $args['usuario'] ?? $this->usuario;
        $this->nombre = $args['nombre'] ?? $this->nombre;
        $this->apellido = $args['apellido'] ?? $this->apellido;
        $this->correo_admin = $args['correo'] ?? $this->correo_admin;
        $this->tel = $args['telefono'] ?? $this->tel;
        $this->password = $args['password'] ?? $this->password;
        $this->nivel = $args['type'] ?? 1;
        $this->codigo = $args['codigo'] ?? $this->codigo;
        $this->access_token = $args['acesss_token'] ?? $this->access_token;  
        $this->editado = date("Y-m-d H:i:s");   
        $this->fecha_recuperacion = $args['recuperacion'] ?? null;
    }


    public function createAccess(){
        $this->access_token = bin2hex(random_bytes(16));
    }


    public function crearToken(){
        $this->codigo = bin2hex(random_bytes(16)); 
    }

    public function checkPass($password){
    
        $result = password_verify($password, $this->password);

        if ($result) {

            return true;
        } else {

            return false;
        }
    }

    public function updatePassword($password){
        $hashPass = password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);

        return $hashPass;
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT, ["cost" => 12]);
    }

    public function tokenDelete(){
        $query = "UPDATE admins SET codigo = NULL, token_creation = NULL, token_expires = NULL, fecha_recuperacion = now() WHERE id = " . self::$db->real_escape_string($this->id) . " LIMIT 1 ";

        $resultado = self::$db->query($query);
        

        return $resultado;

    }

    public function accessUpdate(){
        $token = bin2hex(random_bytes(16));
        $query = "UPDATE admins SET access_token = '$token' WHERE id = " . self::$db->real_escape_string($this->id) . " LIMIT 1 ";

        $resultado = self::$db->query($query);

        return $resultado;
    }


    public function accessDelete(){
        $query = "UPDATE admins SET access_token = NULL WHERE id = " . self::$db->real_escape_string($this->id) . " LIMIT 1 ";

        $resultado = self::$db->query($query);
        
        return $resultado;

    }
    
}
