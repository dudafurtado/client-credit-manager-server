# Para Lidar com Erros

## 1. Limpe o Cache e Recarregue

`php artisan route:clear`  
`php artisan cache:clear`  
`php artisan config:cache`

`composer dump-autoload`  

## 2. Usando os comandos

### Usando o Comando dump()

O comando dump() exibe a saída diretamente no navegador ou no terminal (se você estiver executando comandos Artisan). É útil para depuração rápida.

`dump($variable)`

### Usando o Comando dd()

O comando dd() significa "dump and die". Ele exibe a variável e interrompe a execução do script, útil para interromper o fluxo e visualizar o que está acontecendo.

`dd($variable)`

## 3. Verifique os Logs

`tail -f storage/logs/laravel.log`

Escrevendo no Log com Log::debug()
Se você quiser registrar informações em um arquivo de log, pode usar a classe Log do Laravel. Isso é útil quando você está trabalhando em um ambiente de produção ou quando o output no navegador não é conveniente.

`use Illuminate\Support\Facades\Log;`

`Log::debug('A variável é: ', ['variable' => $variable]);`

Isso irá escrever a informação no arquivo de log localizado em storage/logs/laravel.log.
