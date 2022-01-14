<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Usuarios extends BaseController
{
   private $usuarioModel;
   
   public function __construct() {
       $this->usuarioModel = new \App\Model\UsuarioModel();
   }

    public function index()
    {
        
    }
}
