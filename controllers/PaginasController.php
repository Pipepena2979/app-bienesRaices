<?php

namespace Controllers;

use Model\Blog;
use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {

    public static function index(Router $router) {

        //** METODO QUE NOS MUESTRA 3 PROPIEDADES UNICAMENTE EN LA PÁGINA PRINCIPAL */
        $propiedades = Propiedad::get(3);
        $blogs = Blog::get(3);
        $inicio = true;
        
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio,
            'blogs' => $blogs
        ]);
    }

    public static function nosotros(Router $router) {
        
        $router->render('paginas/nosotros');
    }

    public static function propiedades(Router $router) {

        $propiedades = Propiedad::all();
        
        $router->render('paginas/propiedades',[
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router) {

        $id = ValidarORedireccionar('/propiedades');

        //** BUSCAR LA PROPIEDAD POR SU ID */
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad',[
            'propiedad' => $propiedad
        ]);
    }

    public static function blog( Router $router ) {

        $blogs = Blog::all();
        $router->render('paginas/blog',[
            'blogs' => $blogs
        ]);
    }

    public static function entrada( Router $router ) {
        
        $id = validarORedireccionar('/blog');
        
        // Obtener los datos de la propiedad
        $blog = Blog::find($id);

        $router->render('paginas/entrada', [
                'blog' => $blog]);
        }
    public static function contacto( Router $router ) {

        $mensaje = null;
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];

            //** CREAR UNA NUEVA INSTANCIA DE PHPMAILER */
            $mail = new PHPMailer();

            //** CONFIGURAR SMTP(PROTOCOLO UTILIZADO PARA ENVIAR EMAILS) */
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];
            $mail->SMTPSecure = $_ENV['EMAIL_SMTPSECURE'];
            $mail->Port = $_ENV['EMAIL_PORT'];

            //** CONFIGURAR EL CONTENIDO DEL EMAIL */
            $mail->setFrom('admin@bienesraices.com'); //** QUIEN ENVIA EL EMAIL */
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com'); //** QUIEN RECIBE EL EMAIL */
            $mail->Subject = 'Tienes un nuevo mensaje'; //** ASUNTO DEL EMAIL(LO QUE EL USUARIO VA A LEER) */

            //** HABILITAR HTML */
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            //** DEFINIR EL CONTENIDO */
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>';

            //** ENVIAR DE FORMA CONDICIONAL ALGUNOS CAMPOS DE EMAIL O TELÉFONO */
            if($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p>Eligió ser contactado vía llamada telefónica</p>';
                $contenido .= '<p>Teléfono: ' . $respuestas['telefono'] . '</p>';
                $contenido .= '<p>Fecha Contacto: ' . $respuestas['fecha'] . '</p>';
                $contenido .= '<p>Hora: ' . $respuestas['hora'] . '</p>';
            } else {
                //** ES EMAIL, ENTONCES AGREGAMOS EL CAMPO EMAIL */
                $contenido .= '<p>Eligió ser contactado por email</p>';
                $contenido .= '<p>Email: ' . $respuestas['email'] . '</p>';
            }

            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['opciones'] . '</p>';
            $contenido .= '<p>Precio o Presupuesto: $' . $respuestas['precio'] . '</p>';
            $contenido .= '</html>';
            

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML';

            //** ENVIAR EL EMAIL */
            if($mail->send()) {
                $mensaje = "Mensaje Enviado Correctamente";
            } else {
                $mensaje = "El mensaje no se pudo Envíar";
            }
        }

        $router->render('paginas/contacto',[
            'mensaje' => $mensaje
        ]);
    }
}