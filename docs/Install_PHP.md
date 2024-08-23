# Instalação do PHP e Composer

## 1. Instalação do PHP

Execute o seguinte comando para instalar o PHP no Ubuntu:
`sudo apt install php`

## 2. Instalação do Composer

### Passo 1: Instale Dependências Necessárias

Antes de instalar o Composer, certifique-se de que as dependências necessárias estão instaladas:
`sudo apt install php-cli unzip curl -y`

### Passo 2: Baixe e Instale o Composer

Use o seguinte comando para baixar e instalar o Composer:
`curl -sS https://getcomposer.org/installer | php`

### Passo 3: Mover o Composer para um Diretório Global

Após a instalação, mova o Composer para um diretório global para facilitar o uso:
`sudo mv composer.phar /usr/local/bin/composer`

### Passo 4: Verificar a Instalação

Para verificar se o Composer foi instalado corretamente, execute:
`composer --version`
