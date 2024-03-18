<div class="contenedor crear">
    
    <?php include_once __DIR__.'../../templates/titulo_paginas.php' ;?>

    <div class="contenedor-sm">

        <p class="descripcion-pagina">
            Crear una Nueva Cuenta
        </p>
        <?php if($alertas){ include_once __DIR__.'../../templates/alertas.php';} ;?>

        <form class="formulario" action="" method="POST">

            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="nombre" name="nombre" id="nombre" placeholder="Ingresa tu Nombre" value="<?php echo $usuario->nombre ;?>">
            </div>
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Ingresa tu Email" value="<?php echo $usuario->email ;?>">
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Ingresa tu Password">
            </div>
            <div class="campo">
                <label for="password_rep">Repite tu Password</label>
                <input type="password" name="password_rep" id="password_rep" placeholder="Ingresa tu Password">
            </div>
            <input type="submit" class="boton" value="Crear Cuenta">
        </form>
        
        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta?.. <span>Iniciar Sesion</span></a>
            <a href="/olvide">¿Olvidaste tu password?</a>
        </div>
    </div>
</div>