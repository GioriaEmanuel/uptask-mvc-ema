<div class="tasks">

    <?php include_once __DIR__ . '../../templates/sidebar.php'; ?>

    <div class="principal">
        <div class="header">

            <div class="contenido-header">

                <h1 class="titulo-header">Hola <?php echo $_SESSION['nombre']; ?></h1>
            </div>


        </div>
        <div class="contenido">
            <h2 class="nombre-pagina"><?php echo $pagina; ?></h2>
