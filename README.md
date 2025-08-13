# Este é um sistema administrativo para gerenciar matrículas de alunos em cursos da plataforma de ensino do Prof. Jubilut. O sistema permite:

- Gerenciar áreas de cursos (Biologia, Química, Física, etc.)
- Cadastrar e gerenciar alunos
- Realizar matrículas de alunos em cursos
- Consultar alunos por nome e email
- Dashboard com estatísticas

## Tecnologias Utilizadas

- **PHP 7.4+** - Linguagem principal
- **MySQL** - Banco de dados
- **Bootstrap 5** - Framework CSS
- **jQuery** - Biblioteca JavaScript
- **Font Awesome** - Ícones
- **Composer** - Gerenciador de dependências

## Pré-requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Composer
- Servidor web (Apache/Nginx)

## 🔧 Instalação

### Opção 1: Docker 

#### 1. Clone o repositório
```bash
git clone [URL_DO_REPOSITORIO]
cd Teste-Tecnico-Finnet
```

#### 2. Execute com Docker
```bash
# Construir e iniciar os containers
docker-compose up -d

# Instalar dependências do Composer
docker-compose exec app composer install
```

#### 3. Acesse o sistema
- **Aplicação:** http://localhost:8080
- **phpMyAdmin:** http://localhost:8081
- **Email:** admin@jubilut.com
- **Senha:** admin123

#### 4. Credenciais do banco
- **Host:** db
- **Database:** plataforma_ensino
- **User:** root
- **Password:** root123

### Opção 2: Instalação Local

#### 1. Clone o repositório
```bash
git clone [URL_DO_REPOSITORIO]
cd Teste-Tecnico-Finnet
```

#### 2. Instale as dependências
```bash
composer install
```

#### 3. Configure o banco de dados
- Crie um banco de dados MySQL chamado `plataforma_ensino`
- Configure as credenciais no arquivo `app/Config/Database.php`

#### 4. Configure o servidor web
Configure seu servidor web para apontar para a pasta `public/`

**Para Apache:**
```apache
DocumentRoot /caminho/para/projeto/public
```

**Para Nginx:**
```nginx
root /caminho/para/projeto/public;
```

#### 5. Acesse o sistema
- URL: `http://localhost`
- **Email:** admin@jubilut.com
- **Senha:** admin123

## Funcionalidades

### Autenticação
- Sistema de login/logout
- Proteção de rotas

### Dashboard
- Estatísticas gerais
- Ações rápidas
- Dados recentes

### Áreas de Cursos
- CRUD completo
- Título (obrigatório)
- Descrição

### Alunos
- CRUD completo
- Nome (obrigatório)
- Email (obrigatório)
- Data de nascimento
- Consulta por nome e email

### Matrículas
- CRUD completo
- Relacionamento entre alunos e áreas
- Um aluno pode ser matriculado em múltiplos cursos

```bash
composer test
```

Segurança

- Validação de entrada de dados
- Proteção contra SQL Injection
- Autenticação de sessão
- Escape de dados na saída

