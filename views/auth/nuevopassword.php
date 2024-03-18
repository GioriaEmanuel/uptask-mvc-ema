<div class="contenedor nuevo-pass">
    <?php include_once __DIR__ . '../../templates/titulo_paginas.php'; ?>


    <div class="contenedor-sm">

        <p class="descripcion-pagina">
            Recuperar Password
        </p>
        </p>
        <?php if ($alertas) {
            include_once __DIR__ . '../../templates/alertas.php';
        }; ?>
        <form class="formulario" action="" method="POST">

            <div class="campo">
                <label for="password">Nuevo Password</label>
                <input type="password" name="password" id="password" placeholder="Ingresa tu Nuevo Password">
            </div>
            <div class="campo">
                <label for="password_rep">Repite el Password</label>
                <input type="password" name="password_rep" id="password_rep" placeholder="Repite tu Password">
            </div>

            <input type="submit" class="boton" value="Restableces Password">
        </form>

        <div class="acciones">
            <a href="/crear">¿No tienes cuenta?..<span>Creala aqui</span></a>
            <a href="/">Iniciar Sesion</a>
        </div>
    </div>
</div>