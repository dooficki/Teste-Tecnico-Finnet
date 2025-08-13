<?php

/**
 * Migration: Create Alunos Table
 * 
 * Esta migration cria a tabela de alunos
 * com suporte a UTF-8, email único e timestamps
 */

class CreateAlunosTable
{
    public function up($db)
    {
        $sql = "
        -- Criação da tabela alunos
        CREATE TABLE IF NOT EXISTS alunos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            data_nascimento DATE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

        return $db->exec($sql);
    }

    public function down($db)
    {
        $sql = "DROP TABLE IF EXISTS alunos;";
        return $db->exec($sql);
    }
} 