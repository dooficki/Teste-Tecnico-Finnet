<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Matricula;

class MatriculaTest extends TestCase
{
    private $matriculaModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->matriculaModel = new Matricula();
        
        // Mock da conexão com banco
        $this->matriculaModel->setConnection($this->db);
    }

    public function testCreateMatricula()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $data = [
            'aluno_id' => 1,
            'area_id' => 3 // Física
        ];

        $result = $this->matriculaModel->create($data);
        
        $this->assertTrue($result);
        
        // Verificar se foi inserido
        $matriculas = $this->matriculaModel->getAll();
        $this->assertCount(4, $matriculas);
        
        $novaMatricula = end($matriculas);
        $this->assertEquals(1, $novaMatricula['aluno_id']);
        $this->assertEquals(3, $novaMatricula['area_id']);
    }

    public function testGetAllMatriculas()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $matriculas = $this->matriculaModel->getAll();
        
        $this->assertCount(3, $matriculas);
        
        // Verificar se tem os dados dos joins
        $this->assertArrayHasKey('aluno_nome', $matriculas[0]);
        $this->assertArrayHasKey('area_titulo', $matriculas[0]);
    }

    public function testGetMatriculaById()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $matricula = $this->matriculaModel->getById(1);
        
        $this->assertNotNull($matricula);
        $this->assertEquals(1, $matricula['aluno_id']);
        $this->assertEquals(1, $matricula['area_id']);
        $this->assertEquals('João Silva', $matricula['aluno_nome']);
        $this->assertEquals('Biologia', $matricula['area_titulo']);
    }

    public function testUpdateMatricula()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $data = [
            'aluno_id' => 2,
            'area_id' => 2,
            'status' => 'cancelada'
        ];
        
        $result = $this->matriculaModel->update(1, $data);
        
        $this->assertTrue($result);
        
        // Verificar se foi atualizado
        $matricula = $this->matriculaModel->getById(1);
        $this->assertEquals(2, $matricula['aluno_id']);
        $this->assertEquals(2, $matricula['area_id']);
        $this->assertEquals('cancelada', $matricula['status']);
    }

    public function testDeleteMatricula()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $result = $this->matriculaModel->delete(1);
        
        $this->assertTrue($result);
        
        // Verificar se foi removido
        $matriculas = $this->matriculaModel->getAll();
        $this->assertCount(2, $matriculas);
        
        $deletedMatricula = $this->matriculaModel->getById(1);
        $this->assertNull($deletedMatricula);
    }

    public function testGetByAlunoAndArea()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $matricula = $this->matriculaModel->getByAlunoAndArea(1, 1);
        
        $this->assertNotNull($matricula);
        $this->assertEquals(1, $matricula['aluno_id']);
        $this->assertEquals(1, $matricula['area_id']);
        $this->assertEquals('João Silva', $matricula['aluno_nome']);
        $this->assertEquals('Biologia', $matricula['area_titulo']);
    }

    public function testGetByAlunoAndAreaNotFound()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $matricula = $this->matriculaModel->getByAlunoAndArea(1, 3);
        
        $this->assertNull($matricula);
    }

    public function testCountMatriculas()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $count = $this->matriculaModel->count();
        
        $this->assertEquals(3, $count);
    }

    public function testGetRecentMatriculas()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $recent = $this->matriculaModel->getRecent(2);
        
        $this->assertCount(2, $recent);
        $this->assertArrayHasKey('aluno_nome', $recent[0]);
        $this->assertArrayHasKey('area_titulo', $recent[0]);
    }

    public function testCreateDuplicateMatricula()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $data = [
            'aluno_id' => 1,
            'area_id' => 1 // João já está matriculado em Biologia
        ];

        $result = $this->matriculaModel->create($data);
        
        // Deve falhar devido à duplicação
        $this->assertFalse($result);
    }

    public function testCreateMatriculaWithInvalidAluno()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $data = [
            'aluno_id' => 999, // Aluno inexistente
            'area_id' => 1
        ];

        $result = $this->matriculaModel->create($data);
        
        // Deve falhar devido ao aluno inexistente
        $this->assertFalse($result);
    }

    public function testCreateMatriculaWithInvalidArea()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $data = [
            'aluno_id' => 1,
            'area_id' => 999 // Área inexistente
        ];

        $result = $this->matriculaModel->create($data);
        
        // Deve falhar devido à área inexistente
        $this->assertFalse($result);
    }

    public function testGetNonExistentMatricula()
    {
        $matricula = $this->matriculaModel->getById(999);
        
        $this->assertNull($matricula);
    }

    public function testMatriculaWithStatus()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $matriculas = $this->matriculaModel->getAll();
        
        // Verificar se todas as matrículas têm status
        foreach ($matriculas as $matricula) {
            $this->assertArrayHasKey('status', $matricula);
            $this->assertContains($matricula['status'], ['ativa', 'cancelada']);
        }
    }
} 