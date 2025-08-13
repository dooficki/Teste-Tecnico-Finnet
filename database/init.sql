-- Criação das tabelas para a plataforma de ensino

-- Tabela de áreas de cursos
CREATE TABLE IF NOT EXISTS areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de alunos
CREATE TABLE IF NOT EXISTS alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    data_nascimento DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de matrículas
CREATE TABLE IF NOT EXISTS matriculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    area_id INT NOT NULL,
    data_matricula TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('ativa', 'cancelada') DEFAULT 'ativa',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE,
    FOREIGN KEY (area_id) REFERENCES areas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_matricula (aluno_id, area_id)
);

-- Inserir dados de exemplo
INSERT INTO areas (titulo, descricao) VALUES
('Biologia', 'Estudo dos seres vivos e suas interações'),
('Química', 'Ciência que estuda a composição e propriedades da matéria'),
('Física', 'Ciência que estuda os fenômenos naturais'),
('Matemática', 'Ciência dos números, quantidades e formas');

INSERT INTO alunos (nome, email, data_nascimento) VALUES
('João Silva', 'joao@email.com', '1995-03-15'),
('Maria Santos', 'maria@email.com', '1998-07-22'),
('Pedro Costa', 'pedro@email.com', '1993-11-08');

INSERT INTO matriculas (aluno_id, area_id) VALUES
(1, 1), -- João em Biologia
(1, 2), -- João em Química
(2, 1), -- Maria em Biologia
(3, 3); -- Pedro em Física 