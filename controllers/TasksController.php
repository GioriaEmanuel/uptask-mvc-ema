<?php

namespace Controllers;

use MVC\Router;
use Model\Proyecto;
use Model\Usuario;

class TasksController
{

    public static function index(Router $router)
    {
        $alertas = [];
        session_start();
        isAuth();

        $proyectos = Proyecto::wheres('usuario_id',$_SESSION['id']);
        
            if(empty($proyectos)){

            Proyecto::setAlerta('error','No tienes Proyectos Maraca');
            } 
        
        $alertas = Proyecto::getAlertas();

      
        $router->render('tasks/index', [

            'nombre' => $_SESSION['nombre'],
            'pagina' => "Proyectos",
            'alertas' => $alertas,
            'proyectos' =>$proyectos
        ]);
    }
    public static function crear(Router $router)
    {

        session_start();

        isAuth();
        $alertas = [];

            if($_SERVER['REQUEST_METHOD']== 'POST'){

                $proyecto = new Proyecto($_POST);
                $proyecto->validar();

                $alertas = $proyecto->getAlertas();

                if(empty($alertas)){

                    $proyecto->usuario_id = $_SESSION['id'];
                    $resultado = $proyecto->guardar();
                    
                    if($resultado){
                       header('Location: /proyecto?id='.$proyecto->url);
                    }
                
            }
          
            
        }

        $router->render('tasks/crear-proyectos', [

            'nombre' => $_SESSION['nombre'],
            'pagina' => "Crear Proyectos",
            'alertas' => $alertas
        ]);
    }

    public static function proyecto(Router $router){

            session_start();
            isAuth();
           
            //revisar que el usuario logueado sea el que mira el proyecto
            
            $token = $_GET['id'];
            if(!$token) header('Location:  /tasks');

            $proyecto = Proyecto::where('url', $token);
            
             if($proyecto->usuario_id !== $_SESSION['id']){

                header('Location:  /tasks');
             }
            
             $alertas = Usuario::getAlertas();

        $router->render('tasks/proyecto',[
            'pagina' => $proyecto->proyecto
         

        ]);


    }
    public static function perfil(Router $router)
    {

        session_start();

        isAuth();

        $alertas = [];
        
        $nuevosDatos = new Usuario();

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $usuario =  Usuario::where('id' , $_SESSION['id']);
                $password_ant = $_POST['password_ant'];
                $nuevosDatos->sincronizar($_POST);

                $nuevosDatos->validarEmail();
                $mailExiste = Usuario::where('email' , $nuevosDatos->email);

                    if( $mailExiste && $usuario->id != $mailExiste->id ){

                        $alertas = $nuevosDatos::setAlerta('error', 'El mail ya esta registrado');
                        
                    }else{

                        $usuario->nombre=$nuevosDatos->nombre ?? $usuario->nombre;
                        $usuario->email=$nuevosDatos->email ?? $usuario->email;
                        
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['nombre'] = $usuario->nombre;

                        $usuario->guardar();


                        if($nuevosDatos->password){

                            $nuevosDatos->validarPass();
    
                            $alertas = $nuevosDatos->getAlertas();

                            
    
                            if(empty($alertas['error']) && $usuario->comprobarPassword($password_ant)){
                                
                                
                                $usuario->sincronizar($nuevosDatos);
    
                                $usuario->hashPassword();
                                
                                $usuario->guardar();
    
                                $alertas = $nuevosDatos::setAlerta('exito' , 'Datos Actualizados Correctamente');
    
                                $_SESSION['nombre'] = $usuario->nombre;
                                $_SESSION['email'] = $usuario->email;
                            }
                        }
                    }

                    $alertas = $nuevosDatos->getAlertas();
                

                 

            }

      
        $router->render('tasks/perfil', [

            'nombre' => $_SESSION['nombre'],
            'email' => $_SESSION['email'],
            'pagina' => "Editar Perfil",
            'alertas' => $alertas
        ]);
    }
};
