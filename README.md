Aqui está o README ajustado para o Projeto Vox:

---

# Projeto Vox

## Descrição

O Projeto Vox é um sistema desenvolvido com Symfony que permite o cadastro de empresas e o gerenciamento do seu quadro societário. A aplicação utiliza PostgreSQL como banco de dados.

## Tecnologias Utilizadas

- **Symfony Framework**: Framework PHP para desenvolvimento web.
- **PostgreSQL**: Sistema de gerenciamento de banco de dados relacional.
- **Doctrine ORM**: Mapeamento objeto-relacional para PHP.
- **Docker**: Plataforma para desenvolvimento e execução de contêineres.

## Pré-requisitos

Certifique-se de que você tenha os seguintes pré-requisitos instalados:

- **PHP 8.1+**
- **Composer**
- **Docker** e **Docker Compose**

## Configuração do Ambiente

1. **Clone o projeto**:

   ```bash
   git clone git@github.com:abrahao/Projeto-Vox.git
   ```

2. **Navegue até o diretório do projeto**:

   ```bash
   cd Projeto-Vox/backend
   ```

3. **Instale as dependências com o Composer**:

   ```bash
   composer install
   ```

   Volte para o diretório `Projeto-Vox`:

   ```bash
   cd ..
   ```

4. **Inicie o ambiente com Docker**:

   Crie e inicie os contêineres necessários para o projeto:

   ```bash
   docker-compose up --build
   ```

5. **Acesse o contêiner da aplicação**:

   Em outro terminal, entre no contêiner da aplicação:

   ```bash
   docker exec -it symfony_app bash
   ```

6. **Execute as migrações do banco de dados**:

   No contêiner da aplicação, execute as migrações do banco de dados:

   ```bash
   php bin/console doctrine:migrations:migrate
   ```

## Rotas da Aplicação

### CRUD de Empresas

- **Listar Empresas**: `/empresas`
- **Criar Nova Empresa**: `/empresas/new`
- **Visualizar Empresas**: `/empresas/list`
- **Editar Empresa**: `/empresas/{id}/edit`
- **Excluir Empresa**: `/empresas/delete/{id}`

### CRUD de Sócios

- **Listar Sócios**: `/socio`
- **Criar Novo Sócio**: `/socio/new`
- **Visualizar Sócios**: `/socio/list`
- **Editar Sócio**: `/socio/{id}/edit`
- **Excluir Sócio**: `/socio/delete/{id}`

## API (Ainda em Desenvolvimento)

### Rotas para Empresas

- **Obter Empresa por ID**: `/api/empresas/{id}.{_format}`
- **Listar Empresas**: `/api/empresas.{_format}`
- **Listar Empresas (Sem Formato)**: `/api/empresas`
- **Obter Empresa por ID (Sem Formato)**: `/api/empresas/{id}`

### Rotas para Sócios

- **Obter Sócio por ID**: `/api/socios/{id}.{_format}`
- **Listar Sócios**: `/api/socios.{_format}`
- **Listar Sócios (Sem Formato)**: `/api/socios`
- **Obter Sócio por ID (Sem Formato)**: `/api/socios/{id}`

---

Se precisar de mais ajustes ou tiver dúvidas, estou à disposição!
