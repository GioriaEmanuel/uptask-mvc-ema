<div class="contenedor login">
    <?php include_once __DIR__ . '../../templates/titulo_paginas.php'; ?>


    <div class="contenedor-sm">

        <p class="descripcion-pagina">
            Iniciar Sesion
        </p>
        <?php if ($alertas) {
                include_once __DIR__ . '../../templates/alertas.php';
            }; ?>

        <form class="formulario" action="" method="POST">

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Ingresa tu Email">
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Ingresa tu Password">
            </div>
            <input type="submit" class="boton" value="Iniciar Sesion">
        </form>

        <div class="acciones">
            <a href="/crear">¿No tienes cuenta?.. <span>Creala aqui</span></a>
            <a href="/olvide">¿Olvidaste tu password?</a>
        </div>
    </div>
</div>