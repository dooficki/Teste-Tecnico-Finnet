<?php

namespace App\Models;

use App\Config\Database;

class Area
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM areas ORDER BY titulo");
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM areas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO areas (titulo, descricao) VALUES (?, ?)");
        return $stmt->execute([$data['titulo'], $data['descricao']]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE areas SET titulo = ?, descricao = ? WHERE id = ?");
        return $stmt->execute([$data['titulo'], $data['descricao'], $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM areas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function count()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM areas");
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function getRecent($limit = 5)
    {
        $stmt = $this->db->prepare("SELECT * FROM areas ORDER BY created_at DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
} 