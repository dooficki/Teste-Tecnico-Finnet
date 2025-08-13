<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Nova Matrícula</h1>
        <p class="text-muted mb-0">Adicione uma nova matrícula para um aluno</p>
    </div>
    <a href="/matriculas" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/matriculas/store">
            <div class="mb-3">
                <label for="aluno_id" class="form-label">Aluno *</label>
                <select class="form-control" id="aluno_id" name="aluno_id" required>
                    <option value="">Selecione um aluno</option>
                    <?php foreach ($alunos as $aluno): ?>
                        <option value="<?= $aluno['id'] ?>">
                            <?= htmlspecialchars($aluno['nome']) ?> (<?= htmlspecialchars($aluno['email']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text">Selecione o aluno que será matriculado (obrigatório)</div>
            </div>

            <div class="mb-3">
                <label for="area_id" class="form-label">Área de Curso *</label>
                <select class="form-control" id="area_id" name="area_id" required>
                    <option value="">Selecione uma área</option>
                    <?php foreach ($areas as $area): ?>
                        <option value="<?= $area['id'] ?>">
                            <?= htmlspecialchars($area['titulo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text">Selecione a área de curso (obrigatório)</div>
            </div>

            <!-- Seção para mostrar matrículas existentes do aluno -->
            <div class="mb-3" id="matriculasExistentes" style="display: none;">
                <label class="form-label">Matrículas Existentes do Aluno</label>
                <div class="card border-info">
                    <div class="card-body">
                        <div id="matriculasList"></div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Salvar
                </button>
                <a href="/matriculas" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Dados das matrículas para consulta
const matriculas = <?= json_encode($matriculas ?? []) ?>;
const areas = <?= json_encode($areas) ?>;

document.getElementById('aluno_id').addEventListener('change', function() {
    const alunoId = this.value;
    const matriculasExistentes = document.getElementById('matriculasExistentes');
    const matriculasList = document.getElementById('matriculasList');
    
    if (!alunoId) {
        matriculasExistentes.style.display = 'none';
        return;
    }
    
    // Filtrar matrículas do aluno selecionado
    const matriculasAluno = matriculas.filter(m => m.aluno_id == alunoId);
    
    if (matriculasAluno.length === 0) {
        matriculasList.innerHTML = '<p class="text-muted mb-0">Este aluno ainda não possui matrículas.</p>';
    } else {
        let html = '<div class="row">';
        matriculasAluno.forEach(matricula => {
            const area = areas.find(a => a.id == matricula.area_id);
            const statusBadge = matricula.status === 'ativa' 
                ? '<span class="badge bg-success">Ativa</span>'
                : '<span class="badge bg-danger">Cancelada</span>';
                
            html += `
                <div class="col-md-6 mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">${area ? area.titulo : 'N/A'}</span>
                        ${statusBadge}
                    </div>
                </div>
            `;
        });
        html += '</div>';
        matriculasList.innerHTML = html;
    }
    
    matriculasExistentes.style.display = 'block';
});

// Pré-selecionar aluno se passado na URL
const urlParams = new URLSearchParams(window.location.search);
const alunoId = urlParams.get('aluno_id');
if (alunoId) {
    document.getElementById('aluno_id').value = alunoId;
    document.getElementById('aluno_id').dispatchEvent(new Event('change'));
}
</script> 