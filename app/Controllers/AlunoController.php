<?php

namespace App\Controllers;

use App\Models\Aluno;

class AlunoController extends BaseController
{
    private $alunoModel;

    public function __construct()
    {
        $this->alunoModel = new Aluno();
    }

    public function index()
    {
        $search = $_GET['search'] ?? '';
        
        if (!empty($search)) {
            $alunos = $this->alunoModel->search($search);
        } else {
            $alunos = $this->alunoModel->getAll();
        }
        
        $this->render('alunos/index', [
            'title' => 'Alunos',
            'alunos' => $alunos,
            'search' => $search
        ]);
    }

    public function create()
    {
        $this->render('alunos/create', [
            'title' => 'Novo Aluno'
        ]);
    }

    public function store()
    {
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $data_nascimento = $_POST['data_nascimento'] ?? '';

        // Validação
        if (empty($nome)) {
            $this->setFlashMessage('danger', 'O nome é obrigatório!');
            $this->redirect('/alunos/create');
            return;
        }

        if (empty($email)) {
            $this->setFlashMessage('danger', 'O email é obrigatório!');
            $this->redirect('/alunos/create');
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setFlashMessage('danger', 'Email inválido!');
            $this->redirect('/alunos/create');
            return;
        }

        $data = [
            'nome' => $nome,
            'email' => $email,
            'data_nascimento' => $data_nascimento ?: null
        ];

        if ($this->alunoModel->create($data)) {
            $this->setFlashMessage('success', 'Aluno criado com sucesso!');
            $this->redirect('/alunos');
        } else {
            $this->setFlashMessage('danger', 'Erro ao criar aluno!');
            $this->redirect('/alunos/create');
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $this->setFlashMessage('danger', 'ID do aluno não informado!');
            $this->redirect('/alunos');
            return;
        }

        $aluno = $this->alunoModel->getById($id);
        
        if (!$aluno) {
            $this->setFlashMessage('danger', 'Aluno não encontrado!');
            $this->redirect('/alunos');
            return;
        }

        $this->render('alunos/edit', [
            'title' => 'Editar Aluno',
            'aluno' => $aluno
        ]);
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $data_nascimento = $_POST['data_nascimento'] ?? '';

        if (!$id) {
            $this->setFlashMessage('danger', 'ID do aluno não informado!');
            $this->redirect('/alunos');
            return;
        }

        if (empty($nome)) {
            $this->setFlashMessage('danger', 'O nome é obrigatório!');
            $this->redirect('/alunos/edit?id=' . $id);
            return;
        }

        if (empty($email)) {
            $this->setFlashMessage('danger', 'O email é obrigatório!');
            $this->redirect('/alunos/edit?id=' . $id);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setFlashMessage('danger', 'Email inválido!');
            $this->redirect('/alunos/edit?id=' . $id);
            return;
        }

        $data = [
            'nome' => $nome,
            'email' => $email,
            'data_nascimento' => $data_nascimento ?: null
        ];

        if ($this->alunoModel->update($id, $data)) {
            $this->setFlashMessage('success', 'Aluno atualizado com sucesso!');
            $this->redirect('/alunos');
        } else {
            $this->setFlashMessage('danger', 'Erro ao atualizar aluno!');
            $this->redirect('/alunos/edit?id=' . $id);
        }
    }

    public function delete()
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->setFlashMessage('danger', 'ID do aluno não informado!');
            $this->redirect('/alunos');
            return;
        }

        if ($this->alunoModel->delete($id)) {
            $this->setFlashMessage('success', 'Aluno excluído com sucesso!');
        } else {
            $this->setFlashMessage('danger', 'Erro ao excluir aluno!');
        }

        $this->redirect('/alunos');
    }
} 