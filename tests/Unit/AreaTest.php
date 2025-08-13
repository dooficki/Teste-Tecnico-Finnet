<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Area;

class AreaTest extends TestCase
{
    private $areaModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->areaModel = new Area();
        
        // Mock da conexão com banco
        $this->areaModel->setConnection($this->db);
    }

    public function testCreateArea()
    {
        $data = [
            'titulo' => 'Matemática',
            'descricao' => 'Ciência dos números'
        ];

        $result = $this->areaModel->create($data);
        
        $this->assertTrue($result);
        
        // Verificar se foi inserido
        $areas = $this->areaModel->getAll();
        $this->assertCount(1, $areas);
        $this->assertEquals('Matemática', $areas[0]['titulo']);
        $this->assertEquals('Ciência dos números', $areas[0]['descricao']);
    }

    public function testGetAllAreas()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $areas = $this->areaModel->getAll();
        
        $this->assertCount(3, $areas);
        // Verificar se as áreas estão presentes (ordem pode variar)
        $titulos = array_column($areas, 'titulo');
        $this->assertContains('Biologia', $titulos);
        $this->assertContains('Química', $titulos);
        $this->assertContains('Física', $titulos);
    }

    public function testGetAreaById()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $area = $this->areaModel->getById(1);
        
        $this->assertNotNull($area);
        $this->assertEquals('Biologia', $area['titulo']);
        $this->assertEquals('Estudo dos seres vivos', $area['descricao']);
    }

    public function testUpdateArea()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $data = [
            'titulo' => 'Biologia Atualizada',
            'descricao' => 'Nova descrição da biologia'
        ];
        
        $result = $this->areaModel->update(1, $data);
        
        $this->assertTrue($result);
        
        // Verificar se foi atualizado
        $area = $this->areaModel->getById(1);
        $this->assertEquals('Biologia Atualizada', $area['titulo']);
        $this->assertEquals('Nova descrição da biologia', $area['descricao']);
    }

    public function testDeleteArea()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $result = $this->areaModel->delete(1);
        
        $this->assertTrue($result);
        
        // Verificar se foi removido
        $areas = $this->areaModel->getAll();
        $this->assertCount(2, $areas);
        
        $deletedArea = $this->areaModel->getById(1);
        $this->assertNull($deletedArea); // getById retorna null quando não encontra
    }

    public function testCountAreas()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $count = $this->areaModel->count();
        
        $this->assertEquals(3, $count);
    }

    public function testGetRecentAreas()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $recent = $this->areaModel->getRecent(2);
        
        $this->assertCount(2, $recent);
        // Verificar se as áreas estão presentes (ordem pode variar)
        $titulos = array_column($recent, 'titulo');
        $this->assertContains('Biologia', $titulos);
        $this->assertContains('Química', $titulos);
    }

    public function testCreateAreaWithEmptyTitle()
    {
        $data = [
            'titulo' => '',
            'descricao' => 'Descrição válida'
        ];

        $result = $this->areaModel->create($data);
        
        // Deve falhar devido ao título vazio
        $this->assertFalse($result);
    }

    public function testGetNonExistentArea()
    {
        $area = $this->areaModel->getById(999);
        
        $this->assertNull($area); // getById retorna null quando não encontra
    }
} 