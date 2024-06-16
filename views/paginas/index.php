<main class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>

        <?php include 'iconos.php'; ?>

</main>

    <section class="seccion contenedor">
        <h2>Casas y Departamentos en Venta</h2>

        <?php 
        include 'listado.php';
        ?>

        <div class="alinear-derecha">
            <a href="/propiedades" class="boton-verde">Ver Todas</a>
        </div>
    </section>

    <section class="imagen-contacto">
        <h2>Encuentra la casa de tus sueños</h2>
        <p>Llena el formulario de contacto y un asesor se pondra en contacto contigo en la menor brevedad posible</p>
        <a href="/contacto" class="boton-amarillo">Contactános</a>
    </section>

    <div class="contenedor seccion seccion-inferior">
        <section class="blog">
        <h1>Nuestro Blog</h1>
    <?php foreach($blogs as $blog): ?>
    <article class="entrada-blog">
        <div class="imagen">
        <picture>
            <img loading="lazy" src="/imagenes/<?php echo $blog->imagen; ?>" alt="Texto Entrada Blog">
        </picture>
        </div>
            <div class="texto-entrada">
        <a href="entrada?id=<?php echo $blog->id; ?>">
            <h4><?php echo $blog->titulo; ?></h4>
                <p>Escrito el: <span><?php echo $blog->fecha; ?></span> por: <span><?php echo $blog->autor; ?></span> </p>
                <p>
                <p><?php echo $blog->detalles; ?></p>
                </p>
            </a>
            </div>
    </article>
    <?php endforeach; ?>
        </section>
        <section class="testimoniales">
            <h3>Testimoniales</h3>
            <div class="testimonial">
                <blockquote>
                    El personal se comporto de una excelente forma, muy buena atención y la casa que me ofrecieron cumple con todas mis expectativas.
                </blockquote>
                <p>- Andrés Felipe Peña Castro</p>
            </div>
        </section>
    </div>