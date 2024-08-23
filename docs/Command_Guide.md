# Guia de Comandos Laravel

## 1. Criar um Controlador

Para criar um novo controlador, execute:

`php artisan make:controller NomeDoControlador`  

Este comando cria o controlador na pasta `app/Http/Controllers`.

### Criar um Controlador com Opções

Opções:

- `--resource`: Cria um controlador resourceful com métodos básicos (index, create, store, show, edit, update, destroy).
- `--invokable`: Cria um controlador com um único método `__invoke()`.

## 2. Criar Rotas

### Definir Rotas Manualmente

Para criar rotas, adicione o seguinte ao arquivo de api da pasta de rotas:  

`Route::get('/users', [UserController::class, 'index']);`  
`Route::resource('users', UserController::class);`

### Exemplos de Rotas Resourceful

- `GET /users`: Para listar todos os usuários (`index`).
- `POST /users`: Para criar um novo usuário (`store`).
- `GET /users/{id}`: Para mostrar um usuário específico (`show`).
- `PUT/PATCH /users/{id}`: Para atualizar um usuário (`update`).
- `DELETE /users/{id}`: Para deletar um usuário (`destroy`).

### Listagem das rotas existentes

`php artisan route:list`

## 3. Criar uma Migration

Para criar uma nova migration, use:  

`php artisan make:migration nome_da_migration`

### Execute as Migrações e Seeders

`php artisan migrate`  

### Opções para Migration

- `--create=nome_tabela`: Cria uma nova tabela na migration.
- `--table=nome_tabela`: Edita uma tabela existente.

### Reverter Migrações

- Reverter a última batch: `php artisan migrate:rollback`
- Reverter múltiplas batches: `php artisan migrate:rollback --step=3`
- Reverter todas as migrações: `php artisan migrate:reset`
- Reverter e reexecutar todas as migrações: `php artisan migrate:refresh`
- Reverter todas as migrações e executar novamente: `php artisan migrate:fresh`

### Métodos Úteis na Migration

- Adicionar timestamps automaticamente: `$table->timestamps();`
- Adicionar suporte a soft deletes: `$table->softDeletes();`

## 4. Criar um Seeder

Usar o Factory para criar um seed.

`php artisan db:seed`

`php artisan make:seeder UserSeeder`
`php artisan db:seed --class=UserSeeder`

## 5. Criar um Model

Para criar um novo model, use:  
`php artisan make:model NomeDoModel`

### Opções para Criar Model

- `-m`: Cria uma migration junto com o model.
- `-c`: Cria um controlador junto com o model.
- `-r`: Cria um controlador resourceful junto com o model.
- `-a`: Cria um model, migration, factory e controller com uma única linha de comando.

### Comando Combinado para Model

Para criar um model `Cliente` com migration, controller e resourceful, execute:  
`php artisan make:model Cliente -mcr`

## 6. Criar um Form Request

Form Requests são classes específicas para validação.

### Criar um Form Request

`php artisan make:request StoreUserRequest`

Você pode definir regras diferentes para os métodos `store` e `update`. O Laravel permite definir regras de validação de forma condicional com base no método HTTP, útil para ter regras diferentes para criar e atualizar recursos.
