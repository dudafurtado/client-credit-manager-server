# Estrutura do Banco de Dados

## Exportação e Importação do Banco de Dados

Para exportar um banco de dados MySQL do Beekeeper (ou qualquer banco MySQL/MariaDB) para o seu computador usando o terminal, você pode utilizar o comando mysqldump. Isso cria um arquivo .sql contendo as instruções para recriar o banco de dados, suas tabelas e dados.

`mysqldump -h 127.0.0.1 -u SEU_USUARIO -p NOME_DO_BANCO > caminho/para/o_arquivo.sql`

`-h 127.0.0.1`: O host onde o banco está rodando.
`-u SEU_USUARIO`: O nome de usuário do MySQL que você está usando para se conectar.
`-p`: Esse flag pede a senha do banco de dados. Depois de pressionar Enter, você precisará digitar a senha.
`NOME_DO_BANCO`: O nome do banco de dados que você quer exportar.
`> caminho/para/o_arquivo.sql`: Isso redireciona a saída do mysqldump para um arquivo .sql que será salvo no caminho especificado no seu computador.

Se você não quiser incluir os dados, apenas a estrutura do banco, pode adicionar a opção --no-data ao comando, por exemplo:

`mysqldump -h 127.0.0.1 -u SEU_USUARIO -p --no-data NOME_DO_BANCO > caminho/para/o_arquivo.sql`

Se você estiver lidando com um banco de dados PostgreSQL o comando seria pg_dump.

`pg_dump -h 127.0.0.1 -p SUA_PORTA -U SEU_USUARIO -d NOME_DO_BANCO > caminho/para/arquivo.sql`

## Restauração do Banco de Dados

### Pelo Terminal

Para restaurar um banco de dados que está no ar, utilizando o MySQL com as credenciais que você forneceu, siga os passos abaixo.

1. Navegue até o diretório onde o arquivo dump.sql está salvo
2. Você vai executar o comando MySQL para restaurar o banco de dados no servidor remoto
3. Inserir a senha

Comando para restaurar:

`mysql -h SEU_HOST -P SUA_PORTA -u SEU_USUARIO -p NOME_DO_BANCO < dump.sql`
`mysql -h MYSQLHOST -P MYSQLPORT -u MYSQLUSER -p MYSQLDATABASE < dump.sql`

O terminal pedirá a senha. Quando você executar o comando acima, digite a senha ou cole.

### Pelo Site

MySQL Backup Recovery in a Click! Reestruturação de um backup do banco de dados em um deployado.
[Site de Recuperação](<https://simplerestore.io/>)

Upload your MySQL dump file
Enter your connection string

Para transformar um arquivo .sql em um arquivo compactado .tar.gz, você pode seguir os passos abaixo em um terminal Linux

1. Certifique-se de que está no diretório onde está o arquivo .sql

2. Compacte o arquivo .sql em um .tar.gz usando o comando tar

`tar -czvf nome_do_arquivo.tar.gz nome_do_arquivo.sql`

[Tutorial Restore or Migrate your MySQL Dump to Railway](<https://www.youtube.com/watch?v=Hrvi_BSYswo&ab_channel=SimpleBackups>)
