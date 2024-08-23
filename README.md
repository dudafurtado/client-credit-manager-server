# Sistema de Gerenciamento de Clientes com Cartões de Crédito

## Descrição

O "Sistema de Gerenciamento de Clientes com Cartões de Crédito" é uma aplicação desenvolvida com Laravel para gerenciar clientes e seus cartões de crédito. A aplicação permite a administração de usuários e clientes, além de fornecer funcionalidades para gerenciamento de cartões de crédito e endereços.

## Sumário

- [Laravel Framework](docs/Laravel_Framework.md)
- [Guia de Comandos Laravel](docs/Command_Guide.md)
- [Deploy](docs/Deploy.md)
- [Para Lidar com Erros](docs/Error_Dealing.md)
- [Instalação do PHP e Composer](docs/Install_PHP.md)
- [Inicialização do Projeto](docs/Start_Laravel.md)

## Funcionalidades

### ADMIN

- **Criar**: `POST /admin` - Cria um novo administrador.
- **Mostrar**: `GET /admin/{id}` - Exibe os detalhes de um administrador.

### AUTH

- **Login**: `POST /auth/login` - Permite o login do administrador.
- **Logout**: `POST /auth/logout` - Permite o logout do administrador.

### CLIENT

- **Criar**: `POST /clients` - Adiciona um novo cliente.
- **Listar**: `GET /clients` - Lista todos os clientes. Permite filtragem por nome e paginação.
- **Mostrar**: `GET /clients/{id}` - Exibe os detalhes de um cliente.
- **Atualizar**: `PUT /clients/{id}` - Atualiza as informações de um cliente.
- **Deletar**: `DELETE /clients/{id}` - Remove um cliente.

### CARD

- **Criar**: `POST /cards` - Adiciona um novo cartão de crédito.
- **Atualizar**: `PUT /cards/{id}` - Atualiza as informações de um cartão de crédito.
- **Deletar**: `DELETE /cards/{id}` - Remove um cartão de crédito.

## Estrutura de Dados

### Admin

- `name`: Nome do administrador
- `email`: E-mail do administrador
- `password`: Senha do administrador

### Clientes

- `first_name`: Primeiro nome do cliente
- `surname`: Sobrenome do cliente
- `email`: E-mail do cliente
- `birth_date`: Data de nascimento do cliente
- `address_id`: ID do endereço do cliente
- `card_id`: ID do cartão de crédito do cliente
- `phone`: Telefone do cliente (com máscara)

### Endereços

- `zip_code`: Código postal
- `street`: Rua
- `additional_information`: Informações adicionais
- `neighborhood`: Bairro
- `city`: Cidade
- `state`: Estado

#### Exemplo de Dados de Endereço

`{ "cep": "01001-000", "logradouro": "Praça da Sé", "complemento": "lado ímpar", "unidade": "", "bairro": "Sé", "localidade": "São Paulo", "uf": "SP", "ibge": "3550308", "gia": "1004", "ddd": "11", "siafi": "7107" }`

### Cartão de Crédito

- `number`: Número do cartão
- `expire_date`: Data de expiração
- `CVV`: Código de segurança

## Requisitos

- PHP 7.3 ou superior
- Composer
- MySQL ou outro banco de dados compatível

## Instalação

1. Clone o repositório: `git clone <URL do repositório>`
2. Navegue até a pasta do projeto: `cd nome-do-projeto`
3. Instale as dependências: `composer install`
4. Configure o ambiente: `cp .env.example .env`
5. Gere a chave de aplicação: `php artisan key:generate`
6. Configure o banco de dados no arquivo `.env` e crie o banco de dados.
7. Execute as migrações e seeders: `php artisan migrate` `php artisan db:seed`
8. Inicie o servidor de desenvolvimento: `php artisan serve`

## Uso

Para acessar a aplicação, abra seu navegador e vá para `http://localhost:8000`.

## Contribuição

Para contribuir com o projeto, faça um fork do repositório, crie uma branch com suas alterações, e envie um pull request.
