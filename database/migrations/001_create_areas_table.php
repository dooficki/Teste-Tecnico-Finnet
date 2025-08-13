<?php

/**
 * Migration: Create Areas Table
 * 
 * Esta migration cria a tabela de áreas de cursos
 * com suporte a UTF-8 e timestamps
 */

class CreateAreasTable
{
    public function up($db)
    {
        $sql = "
        -- Configuração de charset UTF-8
        SET NAMES utf8mb4;
        SET CHARACTER SET utf8mb4;
        SET character_set_connection=utf8mb4;

        -- Criação da tabela areas
        CREATE TABLE IF NOT EXISTS areas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(255) NOT NULL,
            descricao TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

        return $db->exec($sql);
    }

    public function down($db)
    {
        $sql = "DROP TABLE IF EXISTS areas;";
        return $db->exec($sql);
    }
} 