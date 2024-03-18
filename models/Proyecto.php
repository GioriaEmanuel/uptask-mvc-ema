<?php 

namespace Model;

use Model\ActiveRecord;

class Proyecto extends ActiveRecord{

    static protected $tabla ="proyectos";
    static protected $columnasDB = ['id','proyecto','url','usuario_id'];

    public $id;
    public $proyecto;
    public $url;
    public $usuario_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->proyecto = $args['proyecto'] ?? "";
        $this->url = $args['url'] ?? "";
        $this->usuario_id = $args['usuario_id'] ?? "";
    }
    public function validar(){

        if(!$this->proyecto){

            self::setAlerta('error', 'El nombre es obligatorio');
        }else{
            $this->url = md5(uniqid());
        }
    }
}



;?>