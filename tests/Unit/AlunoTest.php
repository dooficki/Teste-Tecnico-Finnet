<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Aluno;

class AlunoTest extends TestCase
{
    private $alunoModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->alunoModel = new Aluno();
        
        // Mock da conexão com banco
        $this->alunoModel->setConnection($this->db);
    }

    public function testCreateAluno()
    {
        $data = [
            'nome' => 'Pedro Costa',
            'email' => 'pedro@test.com',
            'data_nascimento' => '1993-11-08'
        ];

        $result = $this->alunoModel->create($data);
        
        $this->assertTrue($result);
        
        // Verificar se foi inserido
        $alunos = $this->alunoModel->getAll();
        $this->assertCount(1, $alunos);
        $this->assertEquals('Pedro Costa', $alunos[0]['nome']);
        $this->assertEquals('pedro@test.com', $alunos[0]['email']);
    }

    public function testGetAllAlunos()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $alunos = $this->alunoModel->getAll();
        
        $this->assertCount(2, $alunos);
        $this->assertEquals('João Silva', $alunos[0]['nome']);
        $this->assertEquals('Maria Santos', $alunos[1]['nome']);
    }

    public function testGetAlunoById()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $aluno = $this->alunoModel->getById(1);
        
        $this->assertNotNull($aluno);
        $this->assertEquals('João Silva', $aluno['nome']);
        $this->assertEquals('joao@test.com', $aluno['email']);
    }

    public function testUpdateAluno()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $data = [
            'nome' => 'João Silva Atualizado',
            'email' => 'joao.novo@test.com',
            'data_nascimento' => '1995-03-20'
        ];
        
        $result = $this->alunoModel->update(1, $data);
        
        $this->assertTrue($result);
        
        // Verificar se foi atualizado
        $aluno = $this->alunoModel->getById(1);
        $this->assertEquals('João Silva Atualizado', $aluno['nome']);
        $this->assertEquals('joao.novo@test.com', $aluno['email']);
    }

    public function testDeleteAluno()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $result = $this->alunoModel->delete(1);
        
        $this->assertTrue($result);
        
        // Verificar se foi removido
        $alunos = $this->alunoModel->getAll();
        $this->assertCount(1, $alunos);
        
        $deletedAluno = $this->alunoModel->getById(1);
        $this->assertNull($deletedAluno);
    }

    public function testSearchAlunoByName()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $alunos = $this->alunoModel->search('João');
        
        $this->assertCount(1, $alunos);
        $this->assertEquals('João Silva', $alunos[0]['nome']);
    }

    public function testSearchAlunoByEmail()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $alunos = $this->alunoModel->search('maria@test.com');
        
        $this->assertCount(1, $alunos);
        $this->assertEquals('Maria Santos', $alunos[0]['nome']);
    }

    public function testSearchAlunoNotFound()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $alunos = $this->alunoModel->search('Não Existe');
        
        $this->assertCount(0, $alunos);
    }

    public function testCountAlunos()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $count = $this->alunoModel->count();
        
        $this->assertEquals(2, $count);
    }

    public function testGetRecentAlunos()
    {
        // Inserir dados de teste
        $this->insertTestData();
        
        $recent = $this->alunoModel->getRecent(1);
        
        $this->assertCount(1, $recent);
        // Verificar se o aluno está presente (ordem pode variar)
        $nomes = array_column($recent, 'nome');
        $this->assertContains('Maria Santos', $nomes);
    }

    public function testCreateAlunoWithEmptyName()
    {
        $data = [
            'nome' => '',
            'email' => 'test@test.com',
            'data_nascimento' => '1990-01-01'
        ];

        $result = $this->alunoModel->create($data);
        
        // Deve falhar devido ao nome vazio
        $this->assertFalse($result);
    }

    public function testCreateAlunoWithInvalidEmail()
    {
        $data = [
            'nome' => 'Teste',
            'email' => 'email-invalido',
            'data_nascimento' => '1990-01-01'
        ];

        $result = $this->alunoModel->create($data);
        
        // Deve falhar devido ao email inválido
        $this->assertFalse($result);
    }

    public function testGetNonExistentAluno()
    {
        $aluno = $this->alunoModel->getById(999);
        
        $this->assertNull($aluno);
    }
} 