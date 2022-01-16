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
                    'nome' => anchor("usuarios/exibir/$usuario->id", esc($usuario->nome), 'title="Exibir usuário '.esc($usuario->nome).'"'),
                    'email' => esc($usuario->email),
                    'ativo' => ($usuario->ativo  == true ? '<i class="fa fa-unlock text-success"></i>&nbsp;Ativo' : '<i class="fa fa-lock text-warning"></i>&nbsp;Invativo'),
                ];
        }
        $retorno = [
            'data' => $data,
        ];
        return $this->response->setJSON($retorno);

    }

    public function exibir(int $id = null)
    {
        $usuario = $this->buscaUsuarioOu404($id);

        $data = [
            'titulo' => "Detalhes do usuário(a) ". esc($usuario->nome),
            'usuario' => $usuario,
        ];

        return view('Usuarios/exibir', $data);
    }


    public function editar(int $id = null)
    {
        $usuario = $this->buscaUsuarioOu404($id);

        $data = [
            'titulo' => "Editando o usuário(a) ". esc($usuario->nome),
            'usuario' => $usuario,
        ];

        return view('Usuarios/editar', $data);
    }

    public function atualizar()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $post = $this->request->getPost();

        echo '<pre>';
        print_r($post);
        exit;
    }


    private function buscaUsuarioOu404(int $id = null)
    {
        if (!$id || !$usuario = $this->usuarioModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o usuário $id");
        }

        return $usuario;
    }


}
