<?php

namespace App\Controllers;

use App\Models\Area;
use App\Models\Aluno;
use App\Models\Matricula;

class DashboardController extends BaseController
{
    public function index()
    {
        $areaModel = new Area();
        $alunoModel = new Aluno();
        $matriculaModel = new Matricula();

        $stats = [
            'total_areas' => $areaModel->count(),
            'total_alunos' => $alunoModel->count(),
            'total_matriculas' => $matriculaModel->count(),
            'areas_recentes' => $areaModel->getRecent(5),
            'alunos_recentes' => $alunoModel->getRecent(5),
            'matriculas_recentes' => $matriculaModel->getRecent(5)
        ];

        $this->render('dashboard/index', [
            'title' => 'Dashboard - Plataforma de Ensino',
            'stats' => $stats
        ]);
    }
} 