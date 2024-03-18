<?php


namespace Model;



class Usuario extends ActiveRecord
{

    protected static $tabla = "usuarios";
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $token;
    public $confirmado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? "";
        $this->email = $args['email'] ?? "";
        $this->password = $args['password'] ?? "";
        $this->token = $args['token'] ?? "";
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    public function validarNuevaCuenta()
    {

        if (!$this->nombre) {

            self::setAlerta('error', 'El Nombre es Obligatorio');
        }
        if (!$this->email) {

            self::setAlerta('error', 'El Email es Obligatorio');
        }
        if (!$this->password) {

            self::setAlerta('error', 'El Password es Obligatorio');
        }
    }

    public function existeUsuario()
    {

        $query = " SELECT * FROM " . self::$tabla . " WHERE email ='" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);


        if ($resultado->num_rows) {
            self::setAlerta('error', 'El usuario ya existe');
        };
        return $resultado;
    }

    public function hashPassword()
    {

        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    public function comprobarPassword($password)
    {

        $resultado = password_verify($password, $this->password);

        if (!$resultado) {

            self::setAlerta('error', 'Password Incorrecto');
        } else {
            return true;
        }
    }


    public function crearToken()
    {

        $this->token = uniqid();
    }
    public function validarLogin()
    {

        if (!$this->email) {

            self::setAlerta('error', 'El Email es Obligatorio');
        }
        if (!$this->password) {

            self::setAlerta('error', 'El Password es Obligatorio');
        }
    }
    public function validarEmail()
    {

        if (!$this->email) {

            self::setAlerta('error', 'El Email es Obligatorio');
        }
        if (!filter_var($this->email , FILTER_VALIDATE_EMAIL)) {

            self::setAlerta('error', 'El Email no es Valido');
        }
    }
    public function validarPass()
    {

        if (!$this->password) {

            self::setAlerta('error', 'El Password es Obligatorio');
        }
        if (strlen($this->password) < 8) {

            self::setAlerta('error', 'El Password no Puede contener menos de 8 Caracteres');
        }
    }
};
