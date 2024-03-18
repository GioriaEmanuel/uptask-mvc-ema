<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;
use Model\Usuario;

class TareasController
{


    public static function index()
    {

        session_start();

        $url = $_GET['url'];

        if (!$url) header('Location: /tasks');


        $proyecto = Proyecto::where('url', $url);

        $tareas = Tarea::wheres('proyecto_id', $proyecto->id);

        if (!$tareas || $proyecto->usuario_id != $_SESSION['id']) {

            $respuesta = [
                'tipo' => 'error',
                'respuesta' => 'Error en la conexion o No hay tareas'
            ];
            echo json_encode($respuesta);
        } else {

            echo json_encode($tareas);
        }
    }
    public static function crear()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            session_start();
            //obtengo el proyecto al que pertenece
            $proyecto = Proyecto::where('url', $_POST['url']);

            if (!$proyecto || $proyecto->usuario_id != $_SESSION['id']) {

                $respuesta = [
                    'tipo' => 'error',
                    'respuesta' => 'Error al agregar la tarea'
                ];
                echo json_encode($respuesta);
            } else {

                //creo la nueva tarea
                $tarea = new Tarea($_POST);
                $tarea->proyecto_id = $proyecto->id;

                $id = $tarea->guardar();

                $respuesta = [
                    'tipo' => 'exito',
                    'respuesta' => 'Tarea Agregada Exitosamente',
                    'proyecto_id' => $tarea->proyecto_id,
                    'id' => $id['id']
                ];
                echo json_encode($respuesta);
            }
        }
    }
    public static function actualizar()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            session_start();

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $cambiar = $_POST['cambiar'];


            if (!$id) {

                $respuesta = [
                    'tipo' => 'error',
                    'respuesta' => 'Accion no valida'
                ];
                echo json_encode($respuesta);
            }

            //obtegno la tarea
            $tarea = Tarea::where('id', $id);

            //Si cabmbiar es si solo se cambia el id
            if ($cambiar == 'si') {

                $tarea->estado = $tarea->estado == "pendiente" ? "terminada" : "pendiente";
                //sino se cambia el nombre

            } else {
                $tarea->nombre = $nombre;
            }


            $tarea->guardar();

            $respuesta = [
                'tipo' => 'exito',
                'respuesta' => 'Tarea Actualizada'
            ];
            echo json_encode($respuesta);
        }
    }
    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            session_start();

            $proyecto = Proyecto::where('url', $_POST['url']);

            $id = $_POST['id'];

            if (!$id || $proyecto->usuario_id != $_SESSION['id']) {

                $respuesta = [
                    'tipo' => 'error',
                    'respuesta' => 'Accion no valida'
                ];
                echo json_encode($respuesta);
            }

            $tarea = Tarea::where('id', $id);

            $tarea->eliminar();

            $respuesta = [
                'tipo' => 'exito',
                'respuesta' => 'Tarea Eliminada'
            ];
            echo json_encode($respuesta);
        }
    }
}
