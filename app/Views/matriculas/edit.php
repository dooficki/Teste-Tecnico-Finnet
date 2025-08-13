<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Editar Matrícula</h1>
    <a href="/matriculas" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/matriculas/update">
            <input type="hidden" name="id" value="<?= $matricula['id'] ?>">
            
            <div class="mb-3">
                <label for="aluno_id" class="form-label">Aluno *</label>
                <select class="form-control" id="aluno_id" name="aluno_id" required>
                    <option value="">Selecione um aluno</option>
                    <?php foreach ($alunos as $aluno): ?>
                        <option value="<?= $aluno['id'] ?>" <?= $aluno['id'] == $matricula['aluno_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($aluno['nome']) ?> (<?= htmlspecialchars($aluno['email']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text">Selecione o aluno (obrigatório)</div>
            </div>

            <div class="mb-3">
                <label for="area_id" class="form-label">Área de Curso *</label>
                <select class="form-control" id="area_id" name="area_id" required>
                    <option value="">Selecione uma área</option>
                    <?php foreach ($areas as $area): ?>
                        <option value="<?= $area['id'] ?>" <?= $area['id'] == $matricula['area_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($area['titulo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text">Selecione a área de curso (obrigatório)</div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="ativa" <?= $matricula['status'] === 'ativa' ? 'selected' : '' ?>>Ativa</option>
                    <option value="cancelada" <?= $matricula['status'] === 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                </select>
                <div class="form-text">Status da matrícula</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Atualizar
                </button>
                <a href="/matriculas" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div> 