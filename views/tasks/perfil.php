<?php include_once __DIR__ . '../../templates/header.php'; ?>


<?php include_once __DIR__ . '../../templates/header.php'; ?>


<div class="contenedor-sm">

        <?php include_once __DIR__ . '../../templates/alertas.php'; ?>
        <form action="" method="POST"class="formulario">

            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Ingresa el nombre" value = '<?php echo $nombre ; ?>'>
            </div>
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Ingresa el email" value = '<?php echo $email ; ?>'>
            </div>
            <div class="campo">
                <label for="password">Nuevo Pasword</label>
                <input type="password" name="password" id="password" placeholder="Ingresa el nuevo Password">
            </div>
            <div class="campo">
                <label for="password_ant">Pasword Anterior</label>
                <input type="password" name="password_ant" id="password_ant" placeholder="Ingresa Password Anterior">
            </div>
            <input type="submit" class="boton boton-perfil" value="Guardar Cambios">

        </form>

</div>


<?php include_once __DIR__ . '../../templates/footer.php'; ?>