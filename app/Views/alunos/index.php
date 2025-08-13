<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Alunos</h1>
    <a href="/alunos/create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novo Aluno
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="/alunos" class="row g-3">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="<?= htmlspecialchars($search ?? '') ?>"
                           placeholder="Buscar por nome ou email...">
                    <button type="submit" class="btn btn-outline-primary">Buscar</button>
                </div>
            </div>
            <div class="col-md-4">
                <?php if (!empty($search)): ?>
                    <a href="/alunos" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Limpar
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($alunos)): ?>
            <div class="text-center py-4">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">
                    <?= !empty($search) ? 'Nenhum aluno encontrado' : 'Nenhum aluno cadastrado' ?>
                </h5>
                <p class="text-muted">
                    <?= !empty($search) ? 'Tente ajustar os termos da busca.' : 'Clique no botão "Novo Aluno" para começar.' ?>
                </p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Data de Nascimento</th>
                            <th>Idade</th>
                            <th>Data de Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                            <tr>
                                <td><?= $aluno['id'] ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($aluno['nome']) ?></strong>
                                </td>
                                <td>
                                    <a href="mailto:<?= htmlspecialchars($aluno['email']) ?>">
                                        <?= htmlspecialchars($aluno['email']) ?>
                                    </a>
                                </td>
                                <td>
                                    <?= $aluno['data_nascimento'] ? date('d/m/Y', strtotime($aluno['data_nascimento'])) : '-' ?>
                                </td>
                                <td>
                                    <?php 
                                    if ($aluno['data_nascimento']) {
                                        $idade = date_diff(date_create($aluno['data_nascimento']), date_create('today'))->y;
                                        echo $idade . ' anos';
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?= date('d/m/Y H:i', strtotime($aluno['created_at'])) ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/alunos/edit?id=<?= $aluno['id'] ?>" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete(<?= $aluno['id'] ?>, '<?= htmlspecialchars($aluno['nome']) ?>')"
                                                title="Excluir">
                                            <i class="fas fa-trash"></i>
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

<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o aluno <strong id="alunoName"></strong>?</p>
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
function confirmDelete(id, name) {
    document.getElementById('alunoName').textContent = name;
    document.getElementById('deleteForm').action = '/alunos/delete';
    
    // Adicionar campo hidden com o ID
    let hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'id';
    hiddenInput.value = id;
    document.getElementById('deleteForm').appendChild(hiddenInput);
    
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script> 