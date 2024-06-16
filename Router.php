<?php 

namespace MVC;

class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }
    
    public function comprobarRutas() {

        session_start();
        $auth = $_SESSION['login'] ?? null;

        //** ARREGLO DE RUTAS PROTEGIDAS */
        $rutas_protegidas = ['/admin', '/propiedades/crear','/propiedades/actualizar', '/propiedades/eliminar','/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar', '/blogs/crear', '/blogs/actualizar', '/blogs/eliminar'];

        $urlActual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        //** PROTEGER LAS RUTAS */
        if(in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('location: /');
        }

        if($fn) {
            //** LA URL EXISTE Y HAY UNA FUNCIÓN ASOCIADA */
            call_user_func($fn, $this);
        } else {
            echo "Error 404 Página no encontrada";
        }
    }

    //** MUESTRA UNA VISTA */
    public function render($view, $datos = []) {

        foreach($datos as $key => $value) {
            $$key = $value; //** $$:VARIABLE DE VARIABLE */
        }

        ob_start(); //** ALMACENAMIENTO EN MEMORIA DURANTE UN MOMENTO... */
        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); //** LIMPIA EL BUFFER(ESPACIO EN MEMORIA EN EL CUAL ALMACENAMOS LOS DATOS DE FORMA TEMPORAL) */
        include __DIR__ . "/views/layout.php";
    }
}