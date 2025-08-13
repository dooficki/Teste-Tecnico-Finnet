<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Novo Aluno</h1>
    <a href="/alunos" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/alunos/store">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome *</label>
                <input type="text" 
                       class="form-control" 
                       id="nome" 
                       name="nome" 
                       required 
                       maxlength="255"
                       placeholder="Nome completo do aluno">
                <div class="form-text">Nome completo do aluno (obrigatório)</div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" 
                       class="form-control" 
                       id="email" 
                       name="email" 
                       required 
                       maxlength="255"
                       placeholder="email@exemplo.com">
                <div class="form-text">Email válido do aluno (obrigatório)</div>
            </div>

            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" 
                       class="form-control" 
                       id="data_nascimento" 
                       name="data_nascimento">
                <div class="form-text">Data de nascimento (opcional)</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Salvar
                </button>
                <a href="/alunos" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div> 