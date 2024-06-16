<?php 

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Model\Blog;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {

    public static function index(Router $router) {
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $blogs = Blog::all();
        
        //** MUESTRA MENSAJE CONDICIONAL */
        $resultado = $_GET['resultado'] ?? null;

        $router->render('/propiedades/admin',
        [
            'propiedades' => $propiedades,
            'vendedores' => $vendedores,
            'blogs' => $blogs,
            'resultado' => $resultado
        ] );
    }

    public static function crear(Router $router) {
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();

        //** ARREGLO CON MENSAJE DE ERRORES */
        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //** CREA UNA NUEVA INSTANCIA */
        $propiedad = new Propiedad($_POST['propiedad']);

        //** SUBIDA DE ARCHIVOS */

        //** GENERA UN NOMBRE UNICO PARA CADA IMAGEN */
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".webp";

        //** SETEAR LA IMAGEN */
        //** REALIZA UN RESIZE A LA IMAGEN CON INTERVENTION IMAGE */
        
        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
        $propiedad->setImagen($nombreImagen);
        }
        
        //** VALIDAR */
        $errores = $propiedad->validar();

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
            $propiedad->guardar();
        }
    }
    $router->render('/propiedades/crear',[
        'propiedad' => $propiedad,
        'vendedores' => $vendedores,
        'errores' => $errores
    ]);
}

    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();

        //** ARREGLO CON MENSAJE DE ERRORES */
        $errores = Propiedad::getErrores();

        //** METODO POST PARA ACTUALIZAR PROPIEDADES */
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //** ASIGNAR LOS ATRIBUTOS */
            $args = $_POST['propiedad'];
    
            $propiedad->sincronizar($args);
    
            //** VALIDACION */
            $errores = $propiedad->validar();
    
            //** SUBIDA DE ARCHIVOS */
            //** GENERA UN NOMBRE UNICO PARA CADA IMAGEN */
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".webp";
    
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
            }
    
            //** REVISAR QUE EL ARREGLO DE ERRORES ESTE VACIO */
            if(empty($errores)) {
            //** ALMACENAR LA IMAGEN EN EL DISCO DURO */
            if($_FILES['propiedad']['tmp_name']['imagen']) {
            $image->save(CARPETA_IMAGENES . $nombreImagen);
            }
    
            $propiedad->guardar();
        }
    }
        $router->render('/propiedades/actualizar',[
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
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
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                } 
            }
        }
    }
}