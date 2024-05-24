<?php

namespace Controllers;

use Clases\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{


    public static function login(Router $router)
    {
        $alertas = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);
            $auth->validarLogin();

            $alertas = $auth->getAlertas();

            if (empty($alertas)) {

                $usuario = Usuario::where('email', $auth->email);

                if (!$usuario || $usuario->token) {

                    $auth->setAlerta('error', 'El usuario no existe o no ha sido confirmado');
                } else {;

                    if ($usuario->comprobarPassword($auth->password)) {

                        session_start();

                        $_SESSION['login'] = true;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['email'] = $usuario->email;

                        header('Location: /tasks');
                    }
                }
            }
            $alertas = $auth->getAlertas();
        }

        $router->render('auth/login', [

            'pagina' => "Login",
            'alertas' => $alertas
        ]);
    }
    public static function logout(Router $router)
    {
        session_start();

        $_SESSION = [];

        header('Location: /');
    }
    public static function invitado(Router $router)
    {
        session_start();

        $_SESSION['login'] = true;
        $_SESSION['nombre'] = 'invitado';
        $_SESSION['id'] = '20';
        $_SESSION['email'] = 'invitado@invitado.com';
        header('Location: /tasks');
    }
    public static function crear(Router $router)
    {

        $alertas = [];
        $usuario = new Usuario();
        $password_rep = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $password_rep = $_POST['password_rep'];


            $usuario->sincronizar($_POST);
            $usuario->validarNuevaCuenta();

            if ($password_rep != $usuario->password) {

                $usuario->setAlerta('error', 'Los passwords no coinciden');
            }

            $alertas = $usuario->getAlertas();

            //si alertas esta vacio

            if (empty($alertas)) {


                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = $usuario->getAlertas();
                } else {

                    $usuario->hashPassword();
                    $usuario->crearToken();

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email_status = $email->enviarConfirmacion(); //respuesta del email en caso de errores
                    $resultado = $usuario->guardar();

                    if ($resultado) {

                        header('Location: /mensaje?mensaje=Te Hemos Eviando un Email Para Confirmar tu Cuenta');
                    }
                }
            }
        }

        $router->render('auth/crear', [

            'pagina' => "Crear Cuenta",
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }
    public static function olvide(Router $router)
    {
        $alertas = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);

            $auth->validarEmail();

            $alertas = $auth->getAlertas();

            if (empty($alertas)) {

                $usuario = $auth->where('email', $auth->email);

                if (!$usuario) {

                    $alertas = $auth->setAlerta("error", "El usuario no Existe");
                } else {

                    $usuario->crearToken();
                    $usuario->confirmado = 0;

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $envio = $email->enviarInstrucciones();

                    $usuario->guardar();

                    if ($envio) {
                        header('Location: /mensaje?mensaje=Revisa tu Email');
                    }
                }
            }
            $alertas = $auth->getAlertas();
        }


        $router->render('auth/olvide', [

            'pagina' => "Recuperar Password",
            "alertas" => $alertas
        ]);
    }

    public static function nuevopassword(Router $router)
    {

        $token = $_GET['token'];
        $alertas = [];

        $usuario = Usuario::where('token', $token);

        if (!$usuario) {

            Usuario::setAlerta('error', 'Token no Valido');
            $alertas = Usuario::getAlertas();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $password = $_POST['password'];
            $password_rep = $_POST['password_rep'];

            if ($password != $password_rep) {

                $usuario->setAlerta('error', ' Los passwords no Coinciden');
            } else {

                $usuario->password = $password;
                $usuario->validarPass();
            }


            $alertas = $usuario->getAlertas();

            if (empty($alertas)) {

                $usuario->hashPassword();
                $usuario->token = "";
                $usuario->confirmado = 1;
                $resultado = $usuario->guardar();

                header('Location: /');
            }
        }


        $router->render('auth/nuevopassword', [

            'pagina' => "Nuevo Password",
            'alertas' => $alertas
        ]);
    }
    public static function confirmar(Router $router)
    {
        $token = $_GET['token'];
        $alerta = null;

        $usuario = Usuario::where('token', $token);

        if (!$usuario) {
            $alerta = "Token no Valido";
        }

        if (!$alerta) {

            $usuario->token = "";
            $usuario->confirmado = 1;
            $usuario->guardar();
        }



        $router->render('auth/confirmar', [

            'pagina' => "Confirmacion Cuenta",
            'alerta' => $alerta
        ]);
    }
    public static function mensaje(Router $router)
    {

        $mensaje = $_GET['mensaje'];


        $router->render('auth/mensaje', [

            'pagina' => "Mensaje",
            'mensaje' => $mensaje
        ]);
    }
};
