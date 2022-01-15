<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Usuarios extends BaseController
{
   private $usuarioModel;
   
   public function __construct() {
       $this->usuarioModel = new UsuarioModel();
   }

    public function index()
    {
        
        $data = [
            'titulo' => 'Listando os Usuários do Sistema',
        ];

        return view('Usuarios/index', $data);

    }

    public function recuperaUsuarios() 
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $atributos = [
            'id',
            'nome',
            'email',
            'ativo',
            'imagem',
        ];

        $usuarios = $this->usuarioModel->select($atributos)
                                        ->findAll();                           
        $data = [];
        foreach($usuarios as $usuario) {
                $data[] = [
                    'imagem' => $usuario->imagem,
                    'nome' => esc($usuario->nome),
                    'email' => esc($usuario->email),
                    'ativo' => ($usuario->ativo  == true ? '<i class="fa fa-unlock text-success"></i>&nbsp;Ativo' : '<i class="fa fa-lock text-warning"></i>&nbsp;Invativo'),
                ];
        }
        $retorno = [
            'data' => $data,
        ];
        return $this->response->setJSON($retorno);

    }
}
