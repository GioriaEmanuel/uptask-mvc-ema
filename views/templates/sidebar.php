<aside class="sidebar">

    
    <div class="iconos-menu">
    <h2>UpTask</h2>

    <img class="luna" loading="lazy" width="40" height="40" src="/build/img/modo-nocturno.png" alt="modo_nocturno">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon desplegable icon-tabler icon-tabler-menu-order" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M4 10h16" />
            <path d="M4 14h16" />
            <path d="M9 18l3 3l3 -3" />
            <path d="M9 6l3 -3l3 3" />
        </svg>
    </div>
    <nav class="navegacion ocultar">
        <a href="/tasks" class="enlaces <?php echo $pagina === 'Proyectos' ? 'activo' : '' ?>">Proyectos</a>
        <a href="/crear-proyectos" class="enlaces <?php echo $pagina === 'Crear Proyectos' ? 'activo' : '' ?>">Crear Proyecto</a>
        <a href="/perfil" class="enlaces  <?php echo $pagina === 'Editar Perfil' ? 'activo' : '' ?>">Perfil</a>
    </nav>
</aside>

<?php $script = '<script src="build/js/navegacion.js"></script>'; ?>