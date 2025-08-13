<?php

namespace App\Controllers;

use App\Models\Matricula;
use App\Models\Aluno;
use App\Models\Area;

class MatriculaController extends BaseController
{
    private $matriculaModel;
    private $alunoModel;
    private $areaModel;

    public function __construct()
    {
        $this->matriculaModel = new Matricula();
        $this->alunoModel = new Aluno();
        $this->areaModel = new Area();
    }

    public function index()
    {
        $matriculas = $this->matriculaModel->getAll();
        
        $this->render('matriculas/index', [
            'title' => 'Matrículas',
            'matriculas' => $matriculas
        ]);
    }

    public function create()
    {
        $alunos = $this->alunoModel->getAll();
        $areas = $this->areaModel->getAll();
        $matriculas = $this->matriculaModel->getAll();
        
        $this->render('matriculas/create', [
            'title' => 'Nova Matrícula',
            'alunos' => $alunos,
            'areas' => $areas,
            'matriculas' => $matriculas
        ]);
    }

    public function store()
    {
        $aluno_id = $_POST['aluno_id'] ?? '';
        $area_id = $_POST['area_id'] ?? '';

        // Validação
        if (empty($aluno_id)) {
            $this->setFlashMessage('danger', 'O aluno é obrigatório!');
            $this->redirect('/matriculas/create');
            return;
        }

        if (empty($area_id)) {
            $this->setFlashMessage('danger', 'A área é obrigatória!');
            $this->redirect('/matriculas/create');
            return;
        }

        // Verificar se já existe matrícula para este aluno nesta área
        $existingMatricula = $this->matriculaModel->getByAlunoAndArea($aluno_id, $area_id);
        if ($existingMatricula) {
            $this->setFlashMessage('danger', 'Este aluno já está matriculado nesta área!');
            $this->redirect('/matriculas/create');
            return;
        }

        $data = [
            'aluno_id' => $aluno_id,
            'area_id' => $area_id
        ];

        if ($this->matriculaModel->create($data)) {
            $this->setFlashMessage('success', 'Matrícula criada com sucesso!');
            $this->redirect('/matriculas');
        } else {
            $this->setFlashMessage('danger', 'Erro ao criar matrícula!');
            $this->redirect('/matriculas/create');
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $this->setFlashMessage('danger', 'ID da matrícula não informado!');
            $this->redirect('/matriculas');
            return;
        }

        $matricula = $this->matriculaModel->getById($id);
        
        if (!$matricula) {
            $this->setFlashMessage('danger', 'Matrícula não encontrada!');
            $this->redirect('/matriculas');
            return;
        }

        $alunos = $this->alunoModel->getAll();
        $areas = $this->areaModel->getAll();

        $this->render('matriculas/edit', [
            'title' => 'Editar Matrícula',
            'matricula' => $matricula,
            'alunos' => $alunos,
            'areas' => $areas
        ]);
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        $aluno_id = $_POST['aluno_id'] ?? '';
        $area_id = $_POST['area_id'] ?? '';
        $status = $_POST['status'] ?? 'ativa';

        if (!$id) {
            $this->setFlashMessage('danger', 'ID da matrícula não informado!');
            $this->redirect('/matriculas');
            return;
        }

        if (empty($aluno_id)) {
            $this->setFlashMessage('danger', 'O aluno é obrigatório!');
            $this->redirect('/matriculas/edit?id=' . $id);
            return;
        }

        if (empty($area_id)) {
            $this->setFlashMessage('danger', 'A área é obrigatória!');
            $this->redirect('/matriculas/edit?id=' . $id);
            return;
        }

        $data = [
            'aluno_id' => $aluno_id,
            'area_id' => $area_id,
            'status' => $status
        ];

        if ($this->matriculaModel->update($id, $data)) {
            $this->setFlashMessage('success', 'Matrícula atualizada com sucesso!');
            $this->redirect('/matriculas');
        } else {
            $this->setFlashMessage('danger', 'Erro ao atualizar matrícula!');
            $this->redirect('/matriculas/edit?id=' . $id);
        }
    }

    public function delete()
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->setFlashMessage('danger', 'ID da matrícula não informado!');
            $this->redirect('/matriculas');
            return;
        }

        if ($this->matriculaModel->delete($id)) {
            $this->setFlashMessage('success', 'Matrícula excluída com sucesso!');
        } else {
            $this->setFlashMessage('danger', 'Erro ao excluir matrícula!');
        }

        $this->redirect('/matriculas');
    }
} 