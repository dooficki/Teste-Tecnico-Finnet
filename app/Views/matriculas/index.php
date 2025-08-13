<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Matrículas</h1>
        <p class="text-muted mb-0">Gerencie as matrículas dos alunos nas diferentes áreas de cursos</p>
    </div>
    <a href="/matriculas/create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nova Matrícula
    </a>
</div>

<!-- Resumo das matrículas por aluno -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-primary">
            <div class="card-body">
                <h6 class="card-title text-primary">
                    <i class="fas fa-info-circle"></i> Como funciona
                </h6>
                <p class="card-text small mb-0">
                    <strong>Um aluno pode ser matriculado em múltiplas áreas:</strong><br>
                    • João Silva → Biologia + Química<br>
                    • Maria Santos → Biologia<br>
                    • Pedro Costa → Física
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-success">
            <div class="card-body">
                <h6 class="card-title text-success">
                    <i class="fas fa-check-circle"></i> Status das Matrículas
                </h6>
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-success mb-0"><?= count(array_filter($matriculas, fn($m) => $m['status'] === 'ativa')) ?></h4>
                        <small class="text-muted">Ativas</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-danger mb-0"><?= count(array_filter($matriculas, fn($m) => $m['status'] === 'cancelada')) ?></h4>
                        <small class="text-muted">Canceladas</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($matriculas)): ?>
            <div class="text-center py-4">
                <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Nenhuma matrícula cadastrada</h5>
                <p class="text-muted">Clique no botão "Nova Matrícula" para começar.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Aluno</th>
                            <th>Áreas Matriculadas</th>
                            <th>Total de Matrículas</th>
                            <th>Última Matrícula</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Agrupar matrículas por aluno
                        $alunosMatriculas = [];
                        foreach ($matriculas as $matricula) {
                            $alunoId = $matricula['aluno_id'];
                            if (!isset($alunosMatriculas[$alunoId])) {
                                $alunosMatriculas[$alunoId] = [
                                    'nome' => $matricula['aluno_nome'],
                                    'matriculas' => []
                                ];
                            }
                            $alunosMatriculas[$alunoId]['matriculas'][] = $matricula;
                        }
                        ?>
                        
                        <?php foreach ($alunosMatriculas as $alunoId => $aluno): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($aluno['nome']) ?></strong>
                                </td>
                                <td>
                                    <?php foreach ($aluno['matriculas'] as $matricula): ?>
                                        <span class="badge bg-primary me-1 mb-1">
                                            <?= htmlspecialchars($matricula['area_titulo']) ?>
                                            <?php if ($matricula['status'] === 'cancelada'): ?>
                                                <i class="fas fa-times text-danger"></i>
                                            <?php endif; ?>
                                        </span>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= count($aluno['matriculas']) ?> matrícula(s)
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $ultimaMatricula = end($aluno['matriculas']);
                                    echo date('d/m/Y H:i', strtotime($ultimaMatricula['data_matricula']));
                                    ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/matriculas/create?aluno_id=<?= $alunoId ?>" 
                                           class="btn btn-sm btn-outline-success" 
                                           title="Adicionar nova matrícula">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info" 
                                                onclick="showAlunoMatriculas(<?= $alunoId ?>)"
                                                title="Ver detalhes">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal de detalhes das matrículas do aluno -->
<div class="modal fade" id="alunoMatriculasModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes das Matrículas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="alunoMatriculasContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir a matrícula <strong id="matriculaName"></strong>?</p>
                <p class="text-danger"><small>Esta ação não pode ser desfeita.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Dados das matrículas para o modal
const alunosMatriculas = <?= json_encode($alunosMatriculas) ?>;

function showAlunoMatriculas(alunoId) {
    const aluno = alunosMatriculas[alunoId];
    if (!aluno) return;
    
    let content = `
        <h6 class="mb-3">Matrículas de <strong>${aluno.nome}</strong></h6>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Área</th>
                        <th>Data da Matrícula</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
    `;
    
    aluno.matriculas.forEach(matricula => {
        const statusBadge = matricula.status === 'ativa' 
            ? '<span class="badge bg-success">Ativa</span>'
            : '<span class="badge bg-danger">Cancelada</span>';
            
        content += `
            <tr>
                <td><strong>${matricula.area_titulo}</strong></td>
                <td>${new Date(matricula.data_matricula).toLocaleDateString('pt-BR')}</td>
                <td>${statusBadge}</td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="/matriculas/edit?id=${matricula.id}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm" 
                                onclick="confirmDelete(${matricula.id}, '${aluno.nome} - ${matricula.area_titulo}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    content += `
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <a href="/matriculas/create?aluno_id=${alunoId}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Adicionar Nova Matrícula
            </a>
        </div>
    `;
    
    document.getElementById('alunoMatriculasContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('alunoMatriculasModal')).show();
}

function confirmDelete(id, name) {
    document.getElementById('matriculaName').textContent = name;
    document.getElementById('deleteForm').action = '/matriculas/delete';
    
    // Limpar formulário anterior
    const form = document.getElementById('deleteForm');
    form.innerHTML = '<button type="submit" class="btn btn-danger">Excluir</button>';
    
    // Adicionar campo hidden com o ID
    let hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'id';
    hiddenInput.value = id;
    form.appendChild(hiddenInput);
    
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script> 