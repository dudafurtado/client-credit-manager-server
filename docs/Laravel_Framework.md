# Laravel Framework

## O que é Laravel?

Laravel é um framework baseado na linguagem PHP usado para o desenvolvimento de aplicações web. Ele é conhecido por ser robusto, fácil de usar e fornecer um ambiente de desenvolvimento ágil. Laravel adota uma arquitetura MVC (Model-View-Controller), que separa a lógica de negócios, a apresentação e o controle da aplicação.

## Por que usar Laravel?

- **Facilidade de uso:** Laravel simplifica tarefas comuns, como roteamento, sessões, cache, e autenticação.
- **Ecossistema rico:** O framework possui um ecossistema de ferramentas e bibliotecas, como o Eloquent ORM, que facilita a interação com bancos de dados.
- **Comunidade ativa:** Laravel possui uma comunidade grande e ativa, o que facilita encontrar tutoriais, soluções e plugins.
- **Escalabilidade:** Ele suporta desde pequenas aplicações até grandes projetos corporativos.
- **Recursos:** Oferece um ecossistema completo, incluindo filas, eventos, notificações e autenticação.

## Arquitetura baseada no padrão MVC

### Model (Modelo)

- **Função:** Representa a lógica de negócios e a manipulação de dados. No Laravel, o modelo geralmente corresponde a uma tabela no banco de dados.
- **Exemplo:** Um modelo `User` pode representar a tabela `users` no banco de dados, e você pode usar o Eloquent ORM para interagir com essa tabela.
- **Localização:** Normalmente, os modelos estão localizados na pasta `app/Models`.

### View (Visão)

- **Função:** Responsável pela apresentação dos dados para o usuário. Em Laravel, as views são os templates que mostram os dados em HTML.
- **Exemplo:** Uma view `welcome.blade.php` pode exibir uma página de boas-vindas com dados do modelo `User`.
- **Localização:** As views estão localizadas na pasta `resources/views`.

### Controller (Controlador)

- **Função:** Atua como intermediário entre o Model e a View. Ele processa as requisições do usuário, interage com o Model para obter dados e passa esses dados para a View.
- **Exemplo:** Um controlador `UserController` pode lidar com requisições relacionadas a usuários, como listar todos os usuários ou mostrar os detalhes de um usuário específico.
- **Localização:** Os controladores estão na pasta `app/Http/Controllers`.

## Interação do banco de dados com Eloquent ORM

Laravel facilita a interação com o banco de dados utilizando o Eloquent ORM, que permite realizar operações no banco de dados de forma simples e intuitiva.

## Artisan CLI

Artisan é a interface de linha de comando do Laravel, usada para realizar várias tarefas automatizadas e operações rotineiras no desenvolvimento de uma aplicação.

### Funcionalidades principais

- **Criar Estruturas de Código:** Artisan pode gerar código boilerplate para controllers, models, migrations, e outros componentes da aplicação.
  - Exemplo: `php artisan make:model User` cria um novo modelo `User`.
- **Migrations:** Gerencia o esquema do banco de dados.
  - Comandos como `php artisan migrate` aplicam as migrações e criam ou alteram tabelas no banco de dados.
- **Seeds:** Popula o banco de dados com dados de teste ou iniciais.
  - O comando `php artisan db:seed` executa os seeders configurados.
- **Servir a Aplicação:** O comando `php artisan serve` inicia um servidor de desenvolvimento local.
- **Limpeza e Cache:** Comandos para limpar cache, visualizar rotas (`php artisan route:list`), e otimizar o desempenho da aplicação (`php artisan optimize`).
- **Desenvolvimento Personalizado:** Você pode criar seus próprios comandos Artisan para automatizar tarefas específicas do seu projeto.
