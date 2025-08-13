<?php

/**
 * Script CLI para executar migrations e seeds
 * 
 * Uso:
 * php migrate.php migrate  - Executa migrations
 * php migrate.php seed     - Executa seeds
 * php migrate.php fresh    - Recria banco e executa tudo
 */

require_once __DIR__ . '/vendor/autoload.php';

use App\Config\MigrationManager;

if ($argc < 2) {
    echo "❌ Uso: php migrate.php [migrate|seed|fresh]\n";
    echo "  migrate - Executa migrations pendentes\n";
    echo "  seed    - Executa seeds\n";
    echo "  fresh   - Recria banco e executa tudo\n";
    exit(1);
}

$command = $argv[1];
$manager = new MigrationManager();

try {
    switch ($command) {
        case 'migrate':
            echo "🔄 Executando migrations...\n";
            $manager->migrate();
            break;
            
        case 'seed':
            echo "🔄 Executando seeds...\n";
            $manager->seed();
            break;
            
        case 'fresh':
            echo "🔄 Recriando banco de dados...\n";
            // Aqui você pode adicionar lógica para recriar o banco
            echo "🔄 Executando migrations...\n";
            $manager->migrate();
            echo "🔄 Executando seeds...\n";
            $manager->seed();
            break;
            
        default:
            echo "❌ Comando inválido: {$command}\n";
            echo "Comandos disponíveis: migrate, seed, fresh\n";
            exit(1);
    }
    
    echo "✅ Operação concluída com sucesso!\n";
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
    exit(1);
} 