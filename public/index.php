<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use Controllers\TareasController;
use Controllers\TasksController;
use MVC\Router;
$router = new Router();

//RUTAS PUBLICAS

$router->get('/',[LoginController::class, 'login']);
$router->post('/',[LoginController::class, 'login']);

$router->get('/crear',[LoginController::class, 'crear']);
$router->post('/crear',[LoginController::class, 'crear']);

$router->get('/mensaje',[LoginController::class, 'mensaje']);
$router->get('/confirmar',[LoginController::class, 'confirmar']);

$router->get('/olvide',[LoginController::class, 'olvide']);//colocacion de email para envio de correo con token
$router->post('/olvide',[LoginController::class, 'olvide']);

$router->get('/nuevopassword',[LoginController::class, 'nuevopassword']);//lectura y restablecimiento del pass
$router->post('/nuevopassword',[LoginController::class, 'nuevopassword']);

$router->get('/logout',[LoginController::class, 'logout']);

$router->get('/invitado',[LoginController::class,'invitado']);

//RUTAS PRIVADAS

//Dashboard
$router->get('/tasks',[TasksController::class,'index']);

$router->get('/crear-proyectos',[TasksController::class,'crear']);
$router->post('/crear-proyectos',[TasksController::class,'crear']);
$router->get('/perfil',[TasksController::class,'perfil']);
$router->post('/perfil',[TasksController::class,'perfil']);
$router->get('/proyecto',[TasksController::class,'proyecto']);

//Api tareas

$router->get('/api/tareas', [TareasController::class,'index']);
$router->post('/api/tarea', [TareasController::class,'crear']);
$router->post('/api/tarea/actualizar', [TareasController::class,'actualizar']);
$router->post('/api/tarea/eliminar', [TareasController::class,'eliminar']);
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();