<?php

namespace App\Models;

use App\Config\Database;

class Matricula
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Define conexão customizada (para testes)
     */
    public function setConnection($connection)
    {
        $this->db = $connection;
    }

    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT m.*, a.nome as aluno_nome, ar.titulo as area_titulo 
            FROM matriculas m 
            JOIN alunos a ON m.aluno_id = a.id 
            JOIN areas ar ON m.area_id = ar.id 
            ORDER BY m.data_matricula DESC
        ");
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT m.*, a.nome as aluno_nome, ar.titulo as area_titulo 
            FROM matriculas m 
            JOIN alunos a ON m.aluno_id = a.id 
            JOIN areas ar ON m.area_id = ar.id 
            WHERE m.id = ?
        ");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create($data)
    {
        // Validações
        if (empty($data['aluno_id']) || empty($data['area_id'])) {
            return false;
        }
        
        // Verificar se já existe matrícula
        $existing = $this->getByAlunoAndArea($data['aluno_id'], $data['area_id']);
        if ($existing) {
            return false;
        }
        
        $stmt = $this->db->prepare("INSERT INTO matriculas (aluno_id, area_id) VALUES (?, ?)");
        return $stmt->execute([$data['aluno_id'], $data['area_id']]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE matriculas SET aluno_id = ?, area_id = ?, status = ? WHERE id = ?");
        return $stmt->execute([$data['aluno_id'], $data['area_id'], $data['status'], $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM matriculas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function count()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM matriculas");
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function getRecent($limit = 5)
    {
        $stmt = $this->db->prepare("
            SELECT m.*, a.nome as aluno_nome, ar.titulo as area_titulo 
            FROM matriculas m 
            JOIN alunos a ON m.aluno_id = a.id 
            JOIN areas ar ON m.area_id = ar.id 
            ORDER BY m.data_matricula DESC 
            LIMIT " . (int)$limit
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByAlunoAndArea($aluno_id, $area_id)
    {
        $stmt = $this->db->prepare("
            SELECT m.*, a.nome as aluno_nome, ar.titulo as area_titulo 
            FROM matriculas m 
            JOIN alunos a ON m.aluno_id = a.id 
            JOIN areas ar ON m.area_id = ar.id 
            WHERE m.aluno_id = ? AND m.area_id = ?
        ");
        $stmt->execute([$aluno_id, $area_id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
} 