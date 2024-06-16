<?php 
    if(!isset($_SESSION)) {
        session_start();
    }

    $auth = $_SESSION['login'] ?? false;

    if(!isset($inicio)) {
        $inicio = false;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/bienesraicesMVC/../build/css/app.css">
</head>
<body>
    
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="/bienesraicesMVC/../build/img/logo.svg" alt="Logotipo de Bienes Raices" class="logo">
                </a>
                <div class="mobile-menu">
                    <img src="/bienesraicesMVC/../build/img/barras.svg" alt="icono menu responsive">
                </div>
                <div class="derecha">
                    <img class="dark-mode-boton" src="/bienesraicesMVC/../build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a class="enlaces" href="/nosotros">Nosotros</a>
                        <a class="enlaces" href="/propiedades">Anuncios</a>
                        <a class="enlaces" href="/blog">Blog</a>
                        <a class="enlaces" href="/contacto">Contacto</a>
                        <?php if($auth) : ?>
                            <a href="/logout">Cerrar Sesión</a>
                        <?php endif; ?>
                    </nav>
                </div>

                
            </div> <!-- Cierre de la barra-->

            <?php if($inicio) { ?>
                <h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>
            <?php } ?>
        </div>
    </header>


    <?php echo $contenido; ?>

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a class="enlaces" href="/nosotros">Nosotros</a>
                <a class="enlaces" href="/propiedades ">Anuncios</a>
                <a class="enlaces" href="/blog">Blog</a>
                <a class="enlaces" href="/contacto">Contacto</a>
            </nav>
        </div>

        <p class="copyright">Todos los Derechos Reservados <?php echo date('Y'); ?> &copy;</p>
    </footer>

    <script src="/bienesraicesMVC/../build/js/bundle.min.js"></script>
</body>
</html>