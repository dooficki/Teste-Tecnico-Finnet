<?php

namespace App\Controllers;

use App\Models\Area;

class AreaController extends BaseController
{
    private $areaModel;

    public function __construct()
    {
        $this->areaModel = new Area();
    }

    public function index()
    {
        $areas = $this->areaModel->getAll();
        
        $this->render('areas/index', [
            'title' => 'Áreas de Cursos',
            'areas' => $areas
        ]);
    }

    public function create()
    {
        $this->render('areas/create', [
            'title' => 'Nova Área de Curso'
        ]);
    }

    public function store()
    {
        $titulo = trim($_POST['titulo'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');

        // Validação
        if (empty($titulo)) {
            $this->setFlashMessage('danger', 'O título é obrigatório!');
            $this->redirect('/areas/create');
            return;
        }

        $data = [
            'titulo' => $titulo,
            'descricao' => $descricao
        ];

        if ($this->areaModel->create($data)) {
            $this->setFlashMessage('success', 'Área de curso criada com sucesso!');
            $this->redirect('/areas');
        } else {
            $this->setFlashMessage('danger', 'Erro ao criar área de curso!');
            $this->redirect('/areas/create');
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $this->setFlashMessage('danger', 'ID da área não informado!');
            $this->redirect('/areas');
            return;
        }

        $area = $this->areaModel->getById($id);
        
        if (!$area) {
            $this->setFlashMessage('danger', 'Área não encontrada!');
            $this->redirect('/areas');
            return;
        }

        $this->render('areas/edit', [
            'title' => 'Editar Área de Curso',
            'area' => $area
        ]);
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        $titulo = trim($_POST['titulo'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');

        if (!$id) {
            $this->setFlashMessage('danger', 'ID da área não informado!');
            $this->redirect('/areas');
            return;
        }

        if (empty($titulo)) {
            $this->setFlashMessage('danger', 'O título é obrigatório!');
            $this->redirect('/areas/edit?id=' . $id);
            return;
        }

        $data = [
            'titulo' => $titulo,
            'descricao' => $descricao
        ];

        if ($this->areaModel->update($id, $data)) {
            $this->setFlashMessage('success', 'Área de curso atualizada com sucesso!');
            $this->redirect('/areas');
        } else {
            $this->setFlashMessage('danger', 'Erro ao atualizar área de curso!');
            $this->redirect('/areas/edit?id=' . $id);
        }
    }

    public function delete()
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            $this->setFlashMessage('danger', 'ID da área não informado!');
            $this->redirect('/areas');
            return;
        }

        if ($this->areaModel->delete($id)) {
            $this->setFlashMessage('success', 'Área de curso excluída com sucesso!');
        } else {
            $this->setFlashMessage('danger', 'Erro ao excluir área de curso!');
        }

        $this->redirect('/areas');
    }
} 