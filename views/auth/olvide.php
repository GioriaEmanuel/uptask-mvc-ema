<div class="contenedor olvide">
    <?php include_once __DIR__ . '../../templates/titulo_paginas.php'; ?>


    <div class="contenedor-sm">

        <p class="descripcion-pagina">
            Recuperar Password
        </p>
        <?php if ($alertas) {
            include_once __DIR__ . '../../templates/alertas.php';
        }; ?>

        <form class="formulario" action="" method="POST">

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Ingresa tu Email">
            </div>
            <p>*Te enviaremos un email con instrucciones para la recuperacion</p>
            <input type="submit" class="boton" value="Contactame">
        </form>

        <div class="acciones">
            <a href="/crear">¿No tienes cuenta?.. <span>Creala aqui</span></a>
            <a href="/">Iniciar Sesion</a>
        </div>
    </div>
</div>