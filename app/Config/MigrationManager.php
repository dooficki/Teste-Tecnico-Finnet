<?php

namespace App\Config;

class MigrationManager
{
    private $db;
    private $migrationsPath;
    private $seedsPath;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->migrationsPath = __DIR__ . '/../../database/migrations/';
        $this->seedsPath = __DIR__ . '/../../database/seeds/';
    }

    /**
     * Executa todas as migrations pendentes
     */
    public function migrate()
    {
        $this->createMigrationsTable();
        
        $migrations = $this->getMigrationFiles();
        $executed = $this->getExecutedMigrations();
        
        foreach ($migrations as $migration) {
            if (!in_array($migration, $executed)) {
                $this->runMigration($migration);
            }
        }
        
        echo "✅ Migrations executadas com sucesso!\n";
    }

    /**
     * Executa todos os seeds
     */
    public function seed()
    {
        $seeds = $this->getSeedFiles();
        
        foreach ($seeds as $seed) {
            $this->runSeed($seed);
        }
        
        echo "✅ Seeds executados com sucesso!\n";
    }

    /**
     * Cria a tabela de controle de migrations
     */
    private function createMigrationsTable()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        
        $this->db->exec($sql);
    }

    /**
     * Obtém arquivos de migration
     */
    private function getMigrationFiles()
    {
        $files = glob($this->migrationsPath . '*.php');
        sort($files);
        return array_map('basename', $files);
    }

    /**
     * Obtém arquivos de seed
     */
    private function getSeedFiles()
    {
        $files = glob($this->seedsPath . '*.php');
        sort($files);
        return array_map('basename', $files);
    }

    /**
     * Obtém migrations já executadas
     */
    private function getExecutedMigrations()
    {
        $stmt = $this->db->query("SELECT migration FROM migrations");
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Executa uma migration específica
     */
    private function runMigration($filename)
    {
        $className = $this->getClassNameFromFile($filename);
        $filePath = $this->migrationsPath . $filename;
        
        require_once $filePath;
        
        $migration = new $className();
        $result = $migration->up($this->db);
        
        if ($result !== false) {
            $stmt = $this->db->prepare("INSERT INTO migrations (migration) VALUES (?)");
            $stmt->execute([$filename]);
            echo "✅ Migration executada: {$filename}\n";
        } else {
            echo "❌ Erro na migration: {$filename}\n";
        }
    }

    /**
     * Executa um seed específico
     */
    private function runSeed($filename)
    {
        $className = $this->getClassNameFromFile($filename);
        $filePath = $this->seedsPath . $filename;
        
        require_once $filePath;
        
        $seed = new $className();
        $result = $seed->run($this->db);
        
        if ($result !== false) {
            echo "✅ Seed executado: {$filename}\n";
        } else {
            echo "❌ Erro no seed: {$filename}\n";
        }
    }

    /**
     * Extrai nome da classe do arquivo
     */
    private function getClassNameFromFile($filename)
    {
        // Determinar o path correto baseado no contexto
        $filePath = '';
        if (strpos($filename, 'sample_data') !== false) {
            $filePath = $this->seedsPath . $filename;
        } else {
            $filePath = $this->migrationsPath . $filename;
        }
        
        $content = file_get_contents($filePath);
        preg_match('/class\s+(\w+)/', $content, $matches);
        return $matches[1] ?? 'UnknownClass';
    }
} 