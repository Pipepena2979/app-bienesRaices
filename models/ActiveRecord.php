<?php

namespace Model;

class ActiveRecord {

    //** BASE DE DATOS */
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    //** ERRORES */
    protected static $errores = [];

    //** DEFINIR LA CONEXION A LA BASE DE DATOS */
    public static function setDB($database) {
        self::$db = $database;
    }
    public function guardar () {
        if(!is_null($this->id)) {
            //** ACTUALIZANDO */
            $this->actualizar();
        } else {
            //** CREANDO UN NUEVO REGISTRO */
            $this->crear();
        }
    }

    public function crear () {

        //** SANITIZAR LOS NUEVOS REGISTROS/DATOS */
        $registros = $this->sanitizarRegistros();

        //** INSERTAR EN LA BASE DE DATOS */
            $query = " INSERT INTO " . static::$tabla . " ( ";
            $query .= join(', ', array_keys($registros));
            $query .= " ) VALUES (' ";
            $query .= join("', '", array_values($registros));
            $query .= " ') ";

            $resultado = self::$db->query($query);

            //** MENSAJE DE EXITO O ERROR */
            if($resultado) {
            //** REDIRECCIONAR AL USUARIO DESPUES DE QUE HAYA LLENADO EL FORMUARIO*/
                header('location: /admin?resultado=1');
            }  
    }

    public function actualizar() {
        
        //** SANITIZAR LOS NUEVOS REGISTROS/DATOS */
        $registros = $this->sanitizarRegistros();

        $valores = [];
        foreach($registros as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= (join(', ', $valores));
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado) {
            //** REDIRECCIONAR AL USUARIO */
            header('location: /admin?resultado=2');
        }

        return $resultado;
    }

    public function eliminar() {
        //** ELIMINAR EL REGISTRO */
        $query = "DELETE FROM " . static::$tabla . " WHERE id = ". self::$db->escape_string($this->id) . " LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
    }

    //** IDENTIFICAR Y UNIR LOS ATRIBUTOS DE LA BASE DE DATOS */
    public function registros () {
        $registros = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $registros[$columna] = $this->$columna;
        }
        return $registros;
    }

    public function sanitizarRegistros () {
        $registros = $this->registros();
        $sanitizado = [];
        foreach($registros as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //** SUBIDA DE ARCHIVOS */
    public function setImagen($imagen) {
        //** ELIMINAR LA IMAGEN PREVIA */
        if(!is_null($this->id)) {
            $this->borrarImagen();
        }
        
        //** ASIGNAR AL ATRIBUTO DE IMAGEN EL NOMBRE DE LA IMAGEN */
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    //** ELIMINA EL ARCHIVO */
    public function borrarImagen() {
        //** COMPROBAR SI EL ARCHIVO EXISTE */
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    //** VALIDACION */
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {
        static::$errores = [];
        return static::$errores;
    }

    //** LISTAR TODAS LOS REGISTROS:ALL() */
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    //** OBTENE DETERMINADO NUMERO DE REGISTROS */

    public static function get($cantidad){
        $query = "SELECT * FROM ". static::$tabla ." LIMIT " . $cantidad;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    //** BUSCAR UN REGISTRO POR SU ID:FIND() */
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";

        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    public static function consultarSQL($query) {
        //** CONSULTAR LA BASE DE DATOS */
        $resultado = self::$db->query($query);

        //** ITERAR LOS RESULTADOS */
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        
        //** LIBERAR LA MEMORIA */
        $resultado->free();

        //** RETORNAR RESULTADO */
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;
        foreach($registro as $key => $value) {
            if(property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //** SINCRONIZA/MODIFICA EL OBJETO EN MEMORIA CON LOS CAMBIOS REALIZADOS POR EL USUARIO */
    public function sincronizar($args=[]) {
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}