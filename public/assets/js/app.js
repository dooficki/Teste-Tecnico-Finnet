// ===== FUNÇÕES GLOBAIS DA APLICAÇÃO =====

$(document).ready(function() {
    // Ocultar mensagens flash automaticamente após 5 segundos
    setTimeout(function() {
        $('.flash-message').fadeOut();
    }, 5000);

    // Validação de formulários
    $('.needs-validation').on('submit', function(event) {
        if (!this.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        $(this).addClass('was-validated');
    });

    // Confirmar ações de exclusão
    $('.btn-delete').on('click', function(e) {
        if (!confirm('Tem certeza que deseja excluir este item?')) {
            e.preventDefault();
            return false;
        }
    });

    // Estado de carregamento para formulários
    $('form').on('submit', function() {
        var $form = $(this);
        var $submitBtn = $form.find('button[type="submit"]');
        
        if ($submitBtn.length) {
            var originalText = $submitBtn.text();
            $submitBtn.prop('disabled', true)
                      .html('<span class="loading"></span> Processando...');
            
            // Reabilitar após 10 segundos como fallback
            setTimeout(function() {
                $submitBtn.prop('disabled', false).text(originalText);
            }, 10000);
        }
    });

    // Funcionalidade de busca
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('.table tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Alternar sidebar no mobile
    $('.sidebar-toggle').on('click', function() {
        $('.sidebar').toggleClass('show');
    });

    // Fechar sidebar ao clicar fora no mobile
    $(document).on('click', function(e) {
        if ($(window).width() <= 768) {
            if (!$(e.target).closest('.sidebar, .sidebar-toggle').length) {
                $('.sidebar').removeClass('show');
            }
        }
    });
});

// ===== FUNÇÕES UTILITÁRIAS =====

// Mostrar mensagem de alerta
function showAlert(type, message) {
    var alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show flash-message" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('body').append(alertHtml);
    
    setTimeout(function() {
        $('.flash-message').fadeOut(function() {
            $(this).remove();
        });
    }, 5000);
}

// Formatar data
function formatDate(date) {
    return new Intl.DateTimeFormat('pt-BR').format(new Date(date));
}

// Validar email
function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// ===== FUNÇÕES ESPECÍFICAS DO SISTEMA =====

// Buscar alunos por nome ou email
function searchStudents(query) {
    if (query.length < 2) return;
    
    $.ajax({
        url: '/api/students/search',
        method: 'GET',
        data: { q: query },
        success: function(response) {
            var $results = $('#searchResults');
            $results.empty();
            
            if (response.length > 0) {
                response.forEach(function(student) {
                    $results.append(`
                        <div class="search-result-item" onclick="selectStudent(${student.id})">
                            <strong>${student.nome}</strong><br>
                            <small>${student.email}</small>
                        </div>
                    `);
                });
            } else {
                $results.append('<div class="text-muted">Nenhum aluno encontrado</div>');
            }
        }
    });
}

// Selecionar aluno dos resultados da busca
function selectStudent(studentId) {
    console.log('Aluno selecionado:', studentId);
}

// Carregar áreas para dropdown de seleção
function loadAreas() {
    $.ajax({
        url: '/api/areas',
        method: 'GET',
        success: function(response) {
            var $select = $('#area_id');
            $select.empty();
            $select.append('<option value="">Selecione uma área</option>');
            
            response.forEach(function(area) {
                $select.append(`<option value="${area.id}">${area.titulo}</option>`);
            });
        }
    });
}

// Calcular idade a partir da data de nascimento
function calculateAge(birthDate) {
    var today = new Date();
    var birth = new Date(birthDate);
    var age = today.getFullYear() - birth.getFullYear();
    var monthDiff = today.getMonth() - birth.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
    }
    
    return age;
} 