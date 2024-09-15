<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueceu a Senha</title>
</head>
<body>
    <h1>Prezado(a) {{ $user->name }}</h1>

    <p>Para recuperar a senha dO Sistema de Gerenciamento de Clientes com Cartões de Crédito, use o código de verificação abaixo:</p>

    <p>{{ $code }}</p>

    <p>Por questões de segurança esse código é válido somente até as {{ $formattedTime }} do dia {{ $formattedDate }}. Caso esse prazo esteja expirado, será necessário solicitar outro código.</p>

    <p>Atenciosamente, Desenvolvedora Maria Eduarda.</p>
</body>
</html>