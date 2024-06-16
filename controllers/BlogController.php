<?php

namespace Controllers;

use MVC\Router;
use Model\Blog;
use Intervention\Image\ImageManagerStatic as Image;



class BlogController {

    public static function crear(Router $router) {

        $blog = new Blog;

        //** ARREGLO CON MENSAJE DE ERRORES */
        $errores = Blog::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //** CREA UNA NUEVA INSTANCIA */
        $blog = new Blog($_POST['blog']);

        //** SUBIDA DE ARCHIVOS */

        //** GENERA UN NOMBRE UNICO PARA CADA IMAGEN */
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".webp";

        //** SETEAR LA IMAGEN */
        //** REALIZA UN RESIZE A LA IMAGEN CON INTERVENTION IMAGE */
        
        if($_FILES['blog']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['blog']['tmp_name']['imagen'])->fit(800,600);
        $blog->setImagen($nombreImagen);
        }
        
        //** VALIDAR */
        $errores = $blog->validar();

        //** REVISAR QUE EL ARREGLO DE ERRORES ESTE VACIO */
        if(empty($errores)) {

             //** CREACION DE LA CARPETA DE IMAGENES */
            $carpetaImagenes = '../../imagenes/';

            if(!is_dir(CARPETA_IMAGENES)) {
                mkdir(CARPETA_IMAGENES);
            }

            //** GUARDA LA IMAGEN EN EL SERVIDOR */
            $image->save(CARPETA_IMAGENES . $nombreImagen);

            //** GUARDA LA IMAGEN EN LA BASE DE DATOS */
            $blog->guardar();
        }
    }
    $router->render('/blogs/crear',[
        'blog' => $blog,
        'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');
        $blog = Blog::find($id);

        //** ARREGLO CON MENSAJE DE ERRORES */
        $errores = Blog::getErrores();

        //** METODO POST PARA ACTUALIZAR PROPIEDADES */
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //** ASIGNAR LOS ATRIBUTOS */
            $args = $_POST['propiedad'];
    
            $blog->sincronizar($args);
    
            //** VALIDACION */
            $errores = $blog->validar();
    
            //** SUBIDA DE ARCHIVOS */
            //** GENERA UN NOMBRE UNICO PARA CADA IMAGEN */
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".webp";
    
            if($_FILES['blog']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['blog']['tmp_name']['imagen'])->fit(800,600);
            $blog->setImagen($nombreImagen);
            }
    
            //** REVISAR QUE EL ARREGLO DE ERRORES ESTE VACIO */
            if(empty($errores)) {
            //** ALMACENAR LA IMAGEN EN EL DISCO DURO */
            if($_FILES['blog']['tmp_name']['imagen']) {
            $image->save(CARPETA_IMAGENES . $nombreImagen);
            }
    
            $blog->guardar();
        }
    }
        $router->render('/blogs/actualizar',[
            'blog' => $blog,
            'errores' => $errores,
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //** VALIDAR ID */
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id) {
                $tipo = $_POST['tipo'];
                if(validarTipoContenido($tipo)) {
                    $blog = Blog::find($id);
                    $blog->eliminar();
                } 
            }
        }
    }
}