<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Editar Área de Curso</h1>
    <a href="/areas" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/areas/update">
            <input type="hidden" name="id" value="<?= $area['id'] ?>">
            
            <div class="mb-3">
                <label for="titulo" class="form-label">Título *</label>
                <input type="text" 
                       class="form-control" 
                       id="titulo" 
                       name="titulo" 
                       required 
                       maxlength="255"
                       value="<?= htmlspecialchars($area['titulo']) ?>"
                       placeholder="Ex: Biologia, Química, Física...">
                <div class="form-text">Nome da área de curso (obrigatório)</div>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" 
                          id="descricao" 
                          name="descricao" 
                          rows="4"
                          placeholder="Descreva brevemente o conteúdo desta área..."><?= htmlspecialchars($area['descricao'] ?? '') ?></textarea>
                <div class="form-text">Descrição opcional da área de curso</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Atualizar
                </button>
                <a href="/areas" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div> 