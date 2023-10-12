<?php

namespace Model;
use \AllowDynamicProperties;
#[AllowDynamicProperties]
class ActiveRecord {
    

    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    public static function setDB($database) {
        self::$db = $database;
    }

    public static function simpleSQL($query) {
       
        $resultado = self::$db->query($query);

        $array = [];

        while($registro = $resultado->fetch_assoc()) {
            $array[] = $registro;
        }

        return $array;
    }

    public static function consultarSQL($query) {
        
        $resultado = self::$db->query($query);

        $array = [];

        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        $resultado->free();

        return $array;
    }

    public static function objetoSql($query){
          
          $resultado = self::$db->query($query);
          
          $array = [];
  
          if(!empty($resultado->num_rows) && $resultado->num_rows > 0){
          
            while($registro = $resultado->fetch_assoc()) {
                $array[] = static::crearObjetoSql($registro);
            }

            $resultado->free();

          }
  
          return $array;

    }

    protected static function crearObjetoSql($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            
                $objeto->$key = $value;
            
        }

        return $objeto;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }
    
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id' ) continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

   
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            if($value != '' && !empty($value) && $value != null){
            $sanitizado[$key] = self::$db->real_escape_string($value);
            }
        }
        return $sanitizado;
    }

    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

   
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            
            $resultado = $this->actualizar();
        } else {
           
            $resultado = $this->crear();
        }

        return $resultado;
    }

   
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    
    public static function find($id) {
        $id_escape = self::$db->real_escape_string($id);
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = $id_escape";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }


    public static function where(String $column, $value) {
        $column_escape = self::$db->real_escape_string($column);
        $value_escape = self::$db->real_escape_string($value);
        $query = " SELECT * FROM " . static::$tabla  ." WHERE $column_escape = '$value_escape' ";
        $query .= " LIMIT 1 ";

        $resultado = self::consultarSQL($query);
        
        return array_shift( $resultado ) ;
    }

    public static function allWhere(String $column, $value) {
        $column_escape = self::$db->real_escape_string($column);
        $value_escape = self::$db->real_escape_string($value);
        $query = " SELECT * FROM " . static::$tabla  ." WHERE $column_escape = '$value_escape' ";

        $resultado = self::consultarSQL($query);
        
        return $resultado ;
    }


    
    public static function SQL($query) {
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function fetchSQL($query) {
        
        $resultado = self::$db->query($query);

        $array = [];

        while($registro = $resultado->fetch_assoc()) {
            $array[] = $registro;
        }

        return $array;

    }


    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT $limite";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

   
    public function crear() {
        
        $atributos = $this->sanitizarAtributos();

        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('"; 
        $query .= join("','", array_values($atributos));
        $query .= "')";

        $resultado = self::$db->query($query);
        if(static::$tabla == "formulario_visitas"){
            $insert = ['id' => self::$db->insert_id];
        }else{
            $insert = ['result' =>  $resultado];
        }

        return $insert;
    }

    public function simpleUpdate($column, $value){
        $query = "UPDATE ". static::$tabla . " SET " . $column . " = ". "'$value'" ." WHERE id = '" . self::$db->real_escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);

        return [
            'result' =>  $resultado
         ];
    }

    public function actualizar() {
       
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(',', $valores );
        $query .= " WHERE id = '" . self::$db->real_escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);
        
        return [
            'result' =>  $resultado
         ];
    }

    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . ' WHERE id = ' . self::$db->real_escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        return $resultado;

    }

    public function deleteBy($column, $value) {
        $query = "DELETE * FROM " . static::$tabla  ." WHERE $column = '$value'" . self::$db->real_escape_string($this->$column) . " LIMIT 1";
        $resultado = self::$db->query($query);

        return $resultado;

    }

}

