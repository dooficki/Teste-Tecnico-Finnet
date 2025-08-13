<?php

class CreateMatriculasTable
{
    public function up($db)
    {
        $sql = "
        -- Criação da tabela matriculas
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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

        return $db->exec($sql);
    }

    public function down($db)
    {
        $sql = "DROP TABLE IF EXISTS matriculas;";
        return $db->exec($sql);
    }
} 