<?php

/**
 * Seed: Sample Data
 * 
 * Este seed insere dados de exemplo para teste
 * Inclui áreas, alunos e matrículas
 */

class SampleData
{
    public function run($db)
    {
        // Inserir áreas de exemplo
        $areas = [
            ['titulo' => 'Biologia', 'descricao' => 'Estudo dos seres vivos e suas interações'],
            ['titulo' => 'Química', 'descricao' => 'Ciência que estuda a composição e propriedades da matéria'],
            ['titulo' => 'Física', 'descricao' => 'Ciência que estuda os fenômenos naturais'],
            ['titulo' => 'Matemática', 'descricao' => 'Ciência dos números, quantidades e formas']
        ];

        foreach ($areas as $area) {
            $stmt = $db->prepare("INSERT INTO areas (titulo, descricao) VALUES (?, ?)");
            $stmt->execute([$area['titulo'], $area['descricao']]);
        }

        // Inserir alunos de exemplo
        $alunos = [
            ['nome' => 'João Silva', 'email' => 'joao@email.com', 'data_nascimento' => '1995-03-15'],
            ['nome' => 'Maria Santos', 'email' => 'maria@email.com', 'data_nascimento' => '1998-07-22'],
            ['nome' => 'Pedro Costa', 'email' => 'pedro@email.com', 'data_nascimento' => '1993-11-08']
        ];

        foreach ($alunos as $aluno) {
            $stmt = $db->prepare("INSERT INTO alunos (nome, email, data_nascimento) VALUES (?, ?, ?)");
            $stmt->execute([$aluno['nome'], $aluno['email'], $aluno['data_nascimento']]);
        }

        // Inserir matrículas de exemplo
        $matriculas = [
            ['aluno_id' => 1, 'area_id' => 1], // João em Biologia
            ['aluno_id' => 1, 'area_id' => 2], // João em Química
            ['aluno_id' => 2, 'area_id' => 1], // Maria em Biologia
            ['aluno_id' => 3, 'area_id' => 3]  // Pedro em Física
        ];

        foreach ($matriculas as $matricula) {
            $stmt = $db->prepare("INSERT INTO matriculas (aluno_id, area_id) VALUES (?, ?)");
            $stmt->execute([$matricula['aluno_id'], $matricula['area_id']]);
        }

        return true;
    }
} 