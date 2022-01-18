<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Usuarios extends BaseController
{
   private $usuarioModel;
   
   public function __construct() {
       $this->usuarioModel = new UsuarioModel();
   }

    public function index(): string
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

    public function exibir(int $id = null): string
    {
        $usuario = $this->buscaUsuarioOu404($id);

        $data = [
            'titulo' => "Detalhes do usuário(a) ". esc($usuario->nome),
            'usuario' => $usuario,
        ];

        return view('Usuarios/exibir', $data);
    }


    public function editar(int $id = null): string
    {
        $usuario = $this->buscaUsuarioOu404($id);

        $data = [
            'titulo' => "Editar usuário(a) ". esc($usuario->nome),
            'usuario' => $usuario,
        ];

        return view('Usuarios/editar', $data);
    }

    public function atualizar()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }
        // Envia a hash do token da requisição
        $retorno['token'] = csrf_hash();

        // Recupera o post da requisição
        $post = $this->request->getPost();

        unset($post['password']);
        unset($post['password_confirmation']);

        // Valida a existência do Usuário
        $usuario = $this->buscaUsuarioOu404($post['id']);

        // Prencheendo os atributos do usuário com os valores do post
        $usuario->fill($post);

        if ($usuario->hasChanged() === false) {
            $retorno['info'] = 'Não há dados para serem atualizados';
            return $this->response->setJSON($retorno);
        }

        if ($this->usuarioModel->protect(false)->save($usuario)) {


            return $this->response->setJSON($retorno);
        }

        $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->usuarioModel->errors();

        return $this->response->setJSON($retorno);
    }


    private function buscaUsuarioOu404(int $id = null)
    {
        if (!$id || !$usuario = $this->usuarioModel->withDeleted(true)->find($id)) {
            throw PageNotFoundException::forPageNotFound("Usuário não encontrado $id");
        }

        return $usuario;
    }


}
