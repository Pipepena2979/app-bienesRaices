<main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php 
        if($resultado) {
            $mensaje = mostrarNotificacion( intval($resultado));
        if($mensaje) { ?> 
            <p class="alerta exito"><?php echo sanitizar($mensaje) ?> </p>
        <?php } ?>
    <?php } ?>
        <a href="/propiedades/crear" class="boton boton-verde">Nueva Propiedad</a>

        <h2>Listado de Propiedades</h2>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!-- MOSTRAR LOS RESULTADOS DE LA BASE DE DATOS -->
                <?php foreach($propiedades as $propiedad): ?>
                <tr>
                    <td> <?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td><img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla" alt="imagen casa"> </td>
                    <td>$ <?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST" class="w-100" action="/propiedades/eliminar">

                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">

                            <input type="hidden" name="tipo" value="propiedad">

                            <input type="submit" class="boton-rojo-block" value="Eliminar"></input>
                        </form>
                        <a href="/propiedades/actualizar?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="/vendedores/crear" class="boton boton-verde">Nuevo Vendedor(a)</a>
        <h2>Listado de Vendedores</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- MOSTRAR LOS RESULTADOS DE LA BASE DE DATOS -->
                <?php foreach($vendedores as $vendedor): ?>
                <tr>
                    <td> <?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                    <td> <?php echo $vendedor->telefono; ?></td>
                    <td>
                    <form method="POST" class="w-100" action="/vendedores/eliminar">

                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">

                            <input type="hidden" name="tipo" value="vendedor">

                            <input type="submit" class="boton-rojo-block" value="Eliminar"></input>
                        </form>
                        <a href="/vendedores/actualizar?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="blogs/crear" class="boton boton-verde">Nuevo Blog</a>
        <h2>Listado de Artículos de Blog</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Autor</th>
                    <th>Detalles</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- MOSTRAR LOS RESULTADOS DE LA BASE DE DATOS -->
                <?php foreach($blogs as $blog): ?>
                <tr>
                    <td><?php echo $blog->id; ?></td>
                    <td><?php echo $blog->titulo; ?></td>
                    <td><?php echo $blog->autor; ?></td>
                    <td><?php echo $blog->detalles; ?></td>
                    <td><img src="/imagenes/<?php echo $blog->imagen; ?>" class="imagen-tabla" alt="imagen blog"></td>
                    <td>
                    <form method="POST" class="w-100" action="/blogs/eliminar">

                            <input type="hidden" name="id" value="<?php echo $blog->id; ?>">

                            <input type="hidden" name="tipo" value="blog">

                            <input type="submit" class="boton-rojo-block" value="Eliminar"></input>
                        </form>
                        <a href="/blogs/actualizar?id=<?php echo $blog->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</main>