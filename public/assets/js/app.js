// ===== FUNÇÕES GLOBAIS DA APLICAÇÃO =====

$(document).ready(function() {
    // Auto-hide flash messages after 5 seconds
    setTimeout(function() {
        $('.flash-message').fadeOut();
    }, 5000);

    // Form validation
    $('.needs-validation').on('submit', function(event) {
        if (!this.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        $(this).addClass('was-validated');
    });

    // Confirm delete actions
    $('.btn-delete').on('click', function(e) {
        if (!confirm('Tem certeza que deseja excluir este item?')) {
            e.preventDefault();
            return false;
        }
    });

    // Loading state for forms
    $('form').on('submit', function() {
        var $form = $(this);
        var $submitBtn = $form.find('button[type="submit"]');
        
        if ($submitBtn.length) {
            var originalText = $submitBtn.text();
            $submitBtn.prop('disabled', true)
                      .html('<span class="loading"></span> Processando...');
            
            // Re-enable after 10 seconds as fallback
            setTimeout(function() {
                $submitBtn.prop('disabled', false).text(originalText);
            }, 10000);
        }
    });

    // Search functionality
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('.table tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Toggle sidebar on mobile
    $('.sidebar-toggle').on('click', function() {
        $('.sidebar').toggleClass('show');
    });

    // Close sidebar when clicking outside on mobile
    $(document).on('click', function(e) {
        if ($(window).width() <= 768) {
            if (!$(e.target).closest('.sidebar, .sidebar-toggle').length) {
                $('.sidebar').removeClass('show');
            }
        }
    });
});

// ===== FUNÇÕES UTILITÁRIAS =====

// Show alert message
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

// Format date
function formatDate(date) {
    return new Intl.DateTimeFormat('pt-BR').format(new Date(date));
}

// Validate email
function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// ===== FUNÇÕES ESPECÍFICAS DO SISTEMA =====

// Search students by name or email
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

// Select student from search results
function selectStudent(studentId) {
    console.log('Selected student:', studentId);
}

// Load areas for select dropdown
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

// Calculate age from birth date
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