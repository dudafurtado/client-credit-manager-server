# Autenticação no Laravel

Este projeto implementa um sistema de autenticação utilizando Laravel, com um controlador específico para lidar com as operações de login e logout.

## Controlador: AuthController

### Rotas

**Rota de Login**  
**Método:** POST  
**Nome:** store  
**Descrição:** Esta rota é responsável por autenticar o usuário utilizando as credenciais fornecidas (e-mail e senha).

**Rota de Logout**  
**Método:** POST  
**Nome:** destroy  
**Descrição:** Esta rota é utilizada para realizar o logout do usuário autenticado, revogando o token de acesso. Embora não haja conteúdo no corpo da requisição, o método POST é utilizado porque ocorre uma alteração no estado da sessão.

### Autenticação com Laravel

O módulo `Auth` do Laravel é utilizado para verificar as credenciais do usuário na tabela de `usuarios`.  

`Auth::attempt(['email' => $request->email, 'password' => $request->password]);`

### Geração de Token

Após a verificação bem-sucedida das credenciais, o usuário autenticado é obtido usando `Auth::user()`. Em seguida, é gerado um token de autenticação que será enviado na resposta.  

`$user = Auth::user(); $token = $request->user()->createToken('api-token')->plainTextToken;`

## Tutorial em Vídeo

Para um tutorial completo sobre como criar um sistema de login na API com Laravel 11, incluindo a criação de rotas restritas, assista ao vídeo no YouTube: [Como criar login na API com Laravel 11 - Criar rota restrita na API com Laravel 11](https://www.youtube.com/watch?v=CzE-sSuoERM)
