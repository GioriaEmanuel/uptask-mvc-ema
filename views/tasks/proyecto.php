<?php include_once __DIR__ . '../../templates/header.php'; ?>


<div class="contenedor-sm">

    <div class="filtros">
        <h3>Filtrar Tareas</h3>
        <form action="" class="formulario-inputs">
            <div class="inputs">
                <div class="input">
                    <label for="todas">Todas</label>
                    <input type="radio" name="filtro" id="todas" value="todas" checked>
                </div>
                <div class="input">
                    <label for="pendientes">Pendientes</label>
                    <input type="radio" name="filtro" id="pendientes" value="pendiente">
                </div>
                <div class="input">
                    <label for="terminadas">Terminadas</label>
                    <input type="radio" name="filtro" id="terminadas" value="terminada">
                </div>
            </div>

        </form>
    </div>

    <?php include_once __DIR__ . '../../templates/alertas.php'; ?>

    <div class="contenedor-tareas">

        <button type="button" id="agregar-tarea" class="agregar-tarea">+ Nueva tarea</button>

    </div>

</div>


<?php $script .= '<script src="build/js/tareas.js"></script>' ?>

<?php include_once __DIR__ . '../../templates/footer.php'; ?>