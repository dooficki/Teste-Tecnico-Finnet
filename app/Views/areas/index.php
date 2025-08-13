<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Áreas de Cursos</h1>
    <a href="/areas/create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nova Área
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($areas)): ?>
            <div class="text-center py-4">
                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Nenhuma área cadastrada</h5>
                <p class="text-muted">Clique no botão "Nova Área" para começar.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th>Data de Criação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($areas as $area): ?>
                            <tr>
                                <td><?= $area['id'] ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($area['titulo']) ?></strong>
                                </td>
                                <td>
                                    <?= htmlspecialchars($area['descricao'] ?: '-') ?>
                                </td>
                                <td>
                                    <?= date('d/m/Y H:i', strtotime($area['created_at'])) ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/areas/edit?id=<?= $area['id'] ?>" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete(<?= $area['id'] ?>, '<?= htmlspecialchars($area['titulo']) ?>')"
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
                <p>Tem certeza que deseja excluir a área <strong id="areaName"></strong>?</p>
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
    document.getElementById('areaName').textContent = name;
    document.getElementById('deleteForm').action = '/areas/delete';
    
    // Adicionar campo hidden com o ID
    let hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'id';
    hiddenInput.value = id;
    document.getElementById('deleteForm').appendChild(hiddenInput);
    
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script> 