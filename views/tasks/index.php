<?php include_once __DIR__ . '../../templates/header.php'; ?>

<?php include_once __DIR__. '../../templates/alertas.php' ;?>

<ul class="listado-proyecto">
    <?php foreach($proyectos as $proyecto) { ?>

        <li class="proyecto">
            <a href="/proyecto?id=<?php echo $proyecto->url; ?>"><?php echo $proyecto->proyecto ;?></a>
        </li>



    <?php };?>
</ul>


<?php include_once __DIR__ . '../../templates/footer.php'; ?>
