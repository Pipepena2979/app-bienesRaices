<?php 

namespace Model;

class Blog extends ActiveRecord {
    
    protected static $tabla = 'blogs';
    protected static $columnasDB = ['id', 'titulo', 'fecha' ,'autor', 'detalles','imagen'];

    public $id;
    public $titulo;
    public $fecha;
    public $autor;
    public $detalles;
    public $imagen;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->fecha = date('Y/m/d');
        $this->autor = $args['autor'] ?? '';
        $this->detalles = $args['detalles'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
    }

    public function validar() {
        
        if(!$this->titulo) {
            self::$errores[] = 'El Titulo es Obligatorio';
        }

        if(!$this->autor) {
            self::$errores[] = 'El Autor es Obligatorio';
        }

        if(!$this->detalles) {
            self::$errores[] = 'La Descripción es Obligatoria';
        }

        if(!$this->imagen) {
            self::$errores[] = 'La Imagen del Artículo de Blog es Obligatoria';
        }

        return self::$errores;
    }
}