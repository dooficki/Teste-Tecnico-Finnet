<?php
$content = ob_start();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <span class="text-muted">Bem-vindo, <?= $_SESSION['user_name'] ?>!</span>
        </div>
    </div>
</div>

<!-- Cards de Estatísticas -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Áreas de Cursos
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total_areas'] ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Alunos Cadastrados
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total_alunos'] ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Matrículas Ativas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total_matriculas'] ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Taxa de Matrícula
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $stats['total_alunos'] > 0 ? round(($stats['total_matriculas'] / $stats['total_alunos']) * 100, 1) : 0 ?>%
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-percentage fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ações Rápidas -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt"></i> Ações Rápidas
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="/areas/create" class="btn btn-primary btn-block w-100">
                            <i class="fas fa-plus"></i> Nova Área
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="/alunos/create" class="btn btn-success btn-block w-100">
                            <i class="fas fa-user-plus"></i> Novo Aluno
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="/matriculas/create" class="btn btn-info btn-block w-100">
                            <i class="fas fa-user-graduate"></i> Nova Matrícula
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="/matriculas" class="btn btn-warning btn-block w-100">
                            <i class="fas fa-list"></i> Ver Matrículas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dados Recentes -->
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-book"></i> Áreas Recentes
                </h6>
            </div>
            <div class="card-body">
                <?php if (!empty($stats['areas_recentes'])): ?>
                    <?php foreach ($stats['areas_recentes'] as $area): ?>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-grow-1">
                                <strong><?= htmlspecialchars($area['titulo']) ?></strong>
                                <br>
                                <small class="text-muted"><?= htmlspecialchars($area['descricao']) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Nenhuma área cadastrada ainda.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-users"></i> Alunos Recentes
                </h6>
            </div>
            <div class="card-body">
                <?php if (!empty($stats['alunos_recentes'])): ?>
                    <?php foreach ($stats['alunos_recentes'] as $aluno): ?>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-grow-1">
                                <strong><?= htmlspecialchars($aluno['nome']) ?></strong>
                                <br>
                                <small class="text-muted"><?= htmlspecialchars($aluno['email']) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Nenhum aluno cadastrado ainda.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-user-graduate"></i> Matrículas Recentes
                </h6>
            </div>
            <div class="card-body">
                <?php if (!empty($stats['matriculas_recentes'])): ?>
                    <?php foreach ($stats['matriculas_recentes'] as $matricula): ?>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-grow-1">
                                <strong><?= htmlspecialchars($matricula['aluno_nome']) ?></strong>
                                <br>
                                <small class="text-muted"><?= htmlspecialchars($matricula['area_titulo']) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Nenhuma matrícula realizada ainda.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?> 