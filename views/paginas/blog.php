<main class="contenedor seccion contenido-centrado">
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

</main>
