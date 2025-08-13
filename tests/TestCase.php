<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use PDO;

abstract class TestCase extends BaseTestCase
{
    protected $db;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupTestDatabase();
    }

    protected function tearDown(): void
    {
        $this->cleanupTestDatabase();
        parent::tearDown();
    }

    /**
     * Configura banco de dados de teste
     */
    protected function setupTestDatabase()
    {
        // Usar banco de teste separado
        $host = $_ENV['DB_HOST'] ?? 'db';
        $database = 'plataforma_ensino_test';
        $username = $_ENV['DB_USERNAME'] ?? 'root';
        $password = $_ENV['DB_PASSWORD'] ?? 'root123';

        try {
            $this->db = new PDO(
                "mysql:host={$host};dbname={$database};charset=utf8mb4",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );

            // Criar tabelas de teste
            $this->createTestTables();
        } catch (\PDOException $e) {
            $this->markTestSkipped('Banco de dados de teste não disponível: ' . $e->getMessage());
        }
    }

    /**
     * Cria tabelas de teste
     */
    protected function createTestTables()
    {
        $sql = "
        -- Tabela de áreas de cursos
        CREATE TABLE IF NOT EXISTS areas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(255) NOT NULL,
            descricao TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        -- Tabela de alunos
        CREATE TABLE IF NOT EXISTS alunos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            data_nascimento DATE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

        $this->db->exec($sql);
    }

    /**
     * Limpa banco de dados de teste
     */
    protected function cleanupTestDatabase()
    {
        if ($this->db) {
            $this->db->exec("DROP TABLE IF EXISTS matriculas");
            $this->db->exec("DROP TABLE IF EXISTS alunos");
            $this->db->exec("DROP TABLE IF EXISTS areas");
        }
    }

    /**
     * Insere dados de teste
     */
    protected function insertTestData()
    {
     
        $this->db->exec("INSERT INTO areas (titulo, descricao) VALUES 
            ('Biologia', 'Estudo dos seres vivos'),
            ('Química', 'Ciência da matéria'),
            ('Física', 'Ciência dos fenômenos naturais')
        ");

        $this->db->exec("INSERT INTO alunos (nome, email, data_nascimento) VALUES 
            ('João Silva', 'joao@test.com', '1995-03-15'),
            ('Maria Santos', 'maria@test.com', '1998-07-22')
        ");

     
        $this->db->exec("INSERT INTO matriculas (aluno_id, area_id) VALUES 
            (1, 1),
            (1, 2),
            (2, 1)
        ");
    }
} 