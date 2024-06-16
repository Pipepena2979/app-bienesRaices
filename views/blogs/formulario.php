<fieldset>
    <legend>Nuestro Blog</legend>
    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="blog[titulo]" placeholder="Titulo Blog" value="<?php echo sanitizar($blog->titulo); ?>">

    <label for="autor">Autor:</label>
    <input type="text" id="autor" name="blog[autor]" placeholder="Autor blog" value="<?php echo sanitizar($blog->autor); ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="blog[imagen]">

    <?php if($blog->imagen) { ?>
    <img src="/imagenes/<?php echo $blog->imagen ?>" class="imagen-small">
    <?php } ?>

    <label for="detalles">detalles:</label>
    <textarea id="detalles" name="blog[detalles]"><?php echo sanitizar($blog->detalles); ?></textarea>
    
</fieldset>