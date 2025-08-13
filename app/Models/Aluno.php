<?php

namespace App\Models;

use App\Config\Database;

class Aluno
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
        $stmt = $this->db->query("SELECT * FROM alunos ORDER BY nome");
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM alunos WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create($data)
    {
        // Validações
        if (empty($data['nome']) || empty($data['email'])) {
            return false;
        }
        
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        $stmt = $this->db->prepare("INSERT INTO alunos (nome, email, data_nascimento) VALUES (?, ?, ?)");
        return $stmt->execute([$data['nome'], $data['email'], $data['data_nascimento']]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE alunos SET nome = ?, email = ?, data_nascimento = ? WHERE id = ?");
        return $stmt->execute([$data['nome'], $data['email'], $data['data_nascimento'], $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM alunos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function search($term)
    {
        $stmt = $this->db->prepare("SELECT * FROM alunos WHERE nome LIKE ? OR email LIKE ? ORDER BY nome");
        $term = "%$term%";
        $stmt->execute([$term, $term]);
        return $stmt->fetchAll();
    }

    public function count()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM alunos");
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function getRecent($limit = 5)
    {
        $stmt = $this->db->prepare("SELECT * FROM alunos ORDER BY created_at DESC LIMIT " . (int)$limit);
        $stmt->execute();
        return $stmt->fetchAll();
    }
} 