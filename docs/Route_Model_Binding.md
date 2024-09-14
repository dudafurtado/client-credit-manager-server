# Route Model Binding

- [Documentação](<https://laravel.com/docs/11.x/routing#route-model-binding>)
- [Guia](<https://medium.com/@moumenalisawe/mastering-route-model-binding-in-laravel-a-comprehensive-guide-d95d3e0327f2>)

É uma funcionalidade do Laravel que automaticamente converte um parâmetro da URL (como {client}) para uma instância do modelo correspondente (como App\Models\Client). Isso simplifica o código, pois você não precisa buscar manualmente o modelo no banco de dados.

Quando você acessa uma rota que contém {client}, o Laravel vai buscar o cliente no banco de dados usando o ID da URL. Se o cliente existir, ele será passado como um modelo para o controlador ou middleware.

Para garantir que o Laravel sempre resolva o parâmetro {client} para uma instância de Client, você pode usar o método Route::model() no AppServiceProvider.

Defina o Binding Explícito no AppServiceProvider. No arquivo app/Providers/AppServiceProvider.php, você precisa adicionar a função Route::model() dentro do método boot() para configurar o route model binding para o modelo Client. Você pode definir isso da seguinte maneira:

`Route::model('client', Client::class);`
`'/clients/{client}/cards/{card}'`
`Client $client, Card $card`

Middleware: No middleware, você pode acessar o modelo Client diretamente com $request->route('client'). Isso simplifica a lógica, pois o Laravel já fez a busca no banco para você.

## Vantagens

Código mais limpo: Você não precisa buscar manualmente o modelo Client com Client::findOrFail().

Automaticidade: O Laravel faz o trabalho pesado de resolver o modelo com base no ID.
Integração automática: Como o modelo já foi resolvido antes de chegar ao middleware ou controlador, você sabe que sempre está trabalhando com um objeto válido.

Agora, quando você acessa uma rota como /clients/123/cards, o Laravel automaticamente transforma o 123 em um objeto Client e passa para o seu middleware ou controlador.
