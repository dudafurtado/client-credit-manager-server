# Inicialização do Projeto

## Criação de uma API REST com Laravel

### Passo 1: Criar um Novo Projeto Laravel

Use o Composer para criar um novo projeto Laravel com o seguinte comando:
`composer create-project --prefer-dist laravel/laravel nome-do-projeto`
Substitua `nome-do-projeto` pelo nome que você deseja dar ao seu projeto.

OU

`composer create-project laravel/laravel nome-do-projeto`

### Passo 2: Criar um Banco de Dados MySQL

Laravel oferece suporte nativo e muito bem integrado com MySQL. Amplamente utilizado, com uma grande comunidade e suporte. Suporte para transações, chaves estrangeiras e integridade referencial. Escalável e eficiente para a maioria das aplicações web.

`mysql -u root -p`  
`CREATE DATABASE nome_do_banco;`

### Passo 3: Configurar o Arquivo `.env`

Inserir credenciais do MySQL:
`DB_CONNECTION=mysql`  
`DB_HOST=127.0.0.1`  
`DB_PORT=3306`  
`DB_DATABASE=nome_do_banco`  
`DB_USERNAME=seu_usuario`  
`DB_PASSWORD=sua_senha`

Configurar Fuso Horário:
`APP_TIMEZONE=America/Sao_Paulo`

Alterar a URL padrão de localhost para IP address:
`APP_URL=http://127.0.0.1:8000`

Mudar o idioma de inglês para português do Brasil
`APP_LOCALE=pt-BR`

### Passo 4: Instale as Dependências do Projeto

`composer install`

### Passo 5: Gere a Chave da Aplicação

Verificar primeiro se ao criar o projeto a chave do projeto não já foi criada. Casa não exista então deve ser usado o comando abaixo.

`php artisan key:generate`

O env deve então conter a seguinte váriavel:

`APP_KEY=base64:`

### Passo 6: Configure o Ambiente

As váriaveis que foram alteradas no .env devem existir no env.example também, pois o Laravel não copia e não lida com elas.

`cp .env.example .env`

### Passo 7: Checar a View

O arquivo de rota web cria automaticamente uma tela de boas-vindas e para verificar que até o momento todos os passos estão corretos é interessante verificar no navegador se o resultado é positivo.

Abra seu navegador e vá para `http://localhost:8000` para acessar o projeto Laravel.

### Passo 8: Instalar Roteamento da API

Para disponibilizar o uso das rotas que possuem o prefix '/api' deve ser usado o comando abaixo.

`php artisan install:api`

Será criada uma rota básica para usuários que deve ser testada sem o intermediário.

### Passo 9: Inicie o Servidor de Desenvolvimento

`php artisan serve`

### Passo 10: Acessar o Projeto

Abra o insomnia e construa uma coleção para testar as rotas seguindo a URL básica: `http://localhost:8000`.

#### Como criar a API com Laravel Tutorial

O conteúdo aprendido para criar esse projeto foi retirado do vídeo do Youtube de um professor chamado Celke. O tutorial ensina como criar o CRUD completo.

[Vídeo no Youtube]<https://www.youtube.com/watch?v=jl65Kk8ZWDU>
