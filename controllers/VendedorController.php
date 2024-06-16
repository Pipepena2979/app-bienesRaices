<?php 

namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController {

    public static function crear(Router $router) {

        $vendedores = new Vendedor;

        //** ARREGLO CON MENSAJE DE ERRORES */
        $errores = Vendedor::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //** CREAR UNA NUEVA INSTANCIA */
            $vendedor = new Vendedor($_POST['vendedor']);
        
            //** VALIDAR QUE NO HAYA CAMPOS VACIOS */
            $errores = $vendedor->validar();
        
            //** NO HAY ERRORES */
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }
    
        $router->render('/vendedores/crear',[
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {
        
        $id = validarORedireccionar('/admin');
        $vendedor = Vendedor::find($id);

        //** ARREGLO CON MENSAJE DE ERRORES */
        $errores = Vendedor::getErrores();

        //** METODO POST PARA ACTUALIZAR VENDEDORES */
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //** ASIGNAR LOS VALORES */
            $args = $_POST['vendedor'];
            
            //** SINCRONIZAR EL OBJETO EN MEMORIA CON LO QUE EL USUARIO ESCRIBIO */
            $vendedor->sincronizar($args);
        
            //** VALIDACIÓN */
            $errores = $vendedor->validar();
        
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }
        $router->render('/vendedores/actualizar',[
            'vendedor' => $vendedor,
            'errores' => $errores
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
                    //** COMPARA LO QUE VAMOS A ELIMINAR */
                    if($tipo === 'vendedor') {
                        $vendedor = Vendedor::find($id);
                        $vendedor->eliminar();
                    } 
                }
            }
        }
    }
}