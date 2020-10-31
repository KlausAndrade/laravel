# Relacionamento entre models do Laravel

Usaremos as tabelas companhias e clientes neste exemplo

## Criar uma instalaão limpa do laravel

laravel new relacionamentos

cd relacionamentos

## Criar os model e as migrations

php artisan make:model Companhia -m

php artisan make:model Cliente -m

## Altere o método up de companhias
```php
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->unsignedBigInteger('companhia_id')->nullable();
            $table->timestamps();
        });

       Schema::table('clientes', function($table) {
          $table->foreign('companhia_id')->references('id')->on('companhias');
       });
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('clientes');
        Schema::enableForeignKeyConstraints();
    }


Companhias
    public function up()
    {
        Schema::create('companhias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });
    }
```
## Antes lembre de que a tabela companhias seja cadastrada antes da clientes (que tem foreign key), para isso renomear companhias adequadamente
php artisan migrate

app/Companhia
```php
<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Companhia extends Model
{
    public function clientes(){
        return $this->hasMany(Cliente::class);
 
   }
 
}
```
app/Cliente.php
```php
<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Cliente extends Model
{
    public function companhia()
    {
        return $this->belongsTo(Companhia::class);
    }
}
```
## Criar controller

php artisan make:controller EloquentController

Editar 

app/Http/Controllers/EloquentController.php
```php
<?php
namespace App\Http\Controllers;

use App\Companhia;
use App\Cliente;
use Illuminate\Http\Request;

class EloquentController extends Controller
{
    public function Home()
    {
        $companhias = Companhia::all();
        return view('welcome',['companhias' => $companhias]);
    }
}
```

## Criar a rota
Route::get('/','EloquentController@Home');

## Criar a view ou editar
resources/views/welcome.blade.php.
```php
 <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Eloquent</title>

    </head>
    <body>
        
     @foreach($companhias as $companhia)

         <h3>{{ $companhia->name }}</h3>
                        
             <ul>
                 @foreach($companhia->clientes as $cliente)
                    <li> {{ $cliente->name }}</li>
                  @endforeach
             </ul> 
     @endforeach

    </body>
</html> 
```

## Cadastrar registros em clientes e companhies.

## Testar

php artisan serve

http://localhost:8000

## Crédito
https://www.codechief.org/article/laravel-hasmany-eloquent-relationship-example-from-scratch#gsc.tab=0

## Relação entre clientes e telefones de um para um
Criar a foreign key em telefones

## Model Cliente
```php
public function telefone(){
  return $this->hasOne(Telefone::class);// ou 'App\Telefone', 'foreign key'
}
```
## Num controller
```php
use App\Cliente;
use App\Telefone;

public function um(){
  // Retornar um cliente com seu telefone
  $cliente = Cliente::find(1);
  $telefone = $cliente->telefone->numero;

  return $cliente->nome.' '.$telefone;
}
```

## Criar uma route para isso

## Relação de um para muitos: 

## Model Cliente
```php
public function telefones(){
  return $this->hasMany(Telefone::class);// ou 'App\Telefone', 'foreign key'
}
```
## No controller
```php
public function todos($id){
  // Retornar um cliente com seu telefone
  $cliente = Cliente::find($id);
  $telefones = $cliente->telefones->numero;

  return $cliente->nome.' '.$telefones;
}
```

## Rota
Route::get('todos/{id}', 'ClienteController@todos');

## Vários para um, ou seja, um para vários invertido

Route::get('dono/{numero}', 'ClienteController@dono');

## No ClienteController
```php
public function dono($numero){
  $telefone = Telefones::where('numero', $numero)->get()-first();// o find() é específico para id

  return $cliente->nome.' '.$telefones;
}
```

## Chamar com
localhost:8000/dono/numero

## No model Telefone
```php
public function dono(){
  return $this->belongsTo(Cliente::class);// ou 'App\Cliente', 'foreign key'
}
```
## No ClienteController
```php
public function dono($numero){
  $telefone = Telefones::where('numero', $numero)->get()-first();// o find() é específico para id
  $cliente = Telefone->dono()

  return $cliente;
}
```

## Entrando com telefone retornar o cliente
Route::get('dono/{numero}', 'ClienteController@dono');

## Relação de muitos para muitos funcionarios para funcoes

## manyTomany requer uma tabela de pivot

migration

- funcionarios
- funcoes
- funcionarios_funcoes
- contendo duas foreign key, uma para funcionarios e uma para funcoes

## Model Funcionarios
```php
public function funcao(){
  return $this->belogsToMany('App\Funcao');
}
```
## Model Funcao
```php
public function funcionario(){
  return $this->belogsToMany('App\Funcionario');
}
```
## Lembrar que quando a tabela relacionada tem um nome padrão e a chave primeária tem um nome padrão, o método pode ser assim:
```php
public function funcao(){
  return $this->belogsToMany('App\Funcao');
}
```
## Quando o nome da tabela relacionada não é padrão:
```php
public function funcao(){
  return $this->belogsToMany('App\Funcao', 'nometabela');
}
```
## Quando a PK também não é padrão:
```php
public function funcao(){
  return $this->belogsToMany('App\Funcao', 'tabela', 'chave');
}
```

Exemplo
```php
public function funcao(){
  return $this->belogsToMany('App\Funcao', 'funcionarios_funcoes', 'funcionario_id', 'funcao_id');
}
```
https://www.javatpoint.com/laravel-relationship
https://www.bulfaitelo.com.br/2017/04/tutorial-laravel-para-iniciantes-parte06.html
https://www.youtube.com/watch?v=iqZfbZ-tyZI

## inserir na tabela estrangeira um campo chamado 
tabela_id int not null

Na tabela primária um campo chamado id

Ex:

cliente_id int not null;

Relacionar users com groups:

- groups
- id
- name

- users
- id
- name
- group_id

## Relacionar os Models Group com User
Quando seguimos as convenções do Laravel nosso c´odigo fica mais simples, como abaixo
```php
class Group extends Model {
    public function user()
    {
      return $this->hasMany('User');// Cada grupo tem um ou muitos users
    }
}
 
class User extends Model {
    public function group()
    {
       return $this->belongsTo('Group'); // Cada user pertence a um grupo
    }
}
```

## Relacionamento entre posts e comments - Um para muitos

Post
```php
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function comments()
    {
        return $this->hasMany('App\Comment'); // Passamos aqui a chave estrangeira, mas somente quando diferente de id
    }
}
```
Comments
```php
<?php
namespace App;
//App/Post;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function post()
    {
        return $this->belongsTo('App\Post');
//      return $this->belongsTo('Post');
    }
}
```
## Ou usamos App\Post
ou fazemos o importe no começo e usamos apenas Post


## Relacionamento entre produtos e fornecedores
```php
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';
    protected $fillable = ['nome', ...];
    public $timestamps = false;
    public function produtos(){
        return $this->hasMany(Produto::class);
    }
}

<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'name',
        ...
    ];

    public function fornecedores(){
        return $this->belongsToMany(Fornecedor::class);
    }
}
```

## Migrations para fornecedor_produto
```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFornecedorProdutoTable extends Migration
{
    public function up()
    {
        Schema::create('fornecedor_produto', function (Blueprint $table) {
            $table->integer('produto_id')->unsigned();
            $table->integer('fornecedor_id')->unsigned();

            $table->foreign('produto_id')
                ->references('id')->on('produtos')
                ->onDelete('cascade');

            $table->foreign('fornecedor_id')
                ->references('id')->on('fornecedores')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fornecedor_produto');
    }
}
```

## Posts e Comentários
```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}

<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
```

https://laravel.com/docs/7.x/eloquent-relationships

## Usuários - Endereços e Filho e Pai (considerar 1 para 1)

1 para N

- users e groups
- produtos e categorias
- pedidos e produtos


## model de usuários
```php
public function endereco()
{
    return $this->hasOne(Endereco::class, foreignKey, 'user', localKey, 'id')
}
```
Agora podemos chamar o método endereco() no controller e lá mostrar os campos da tabela

## Model User

## Adicionar método
```php
public function user(){
  return $this->belongTo(User:class, foreignKey, 'user', ownerKey, 'id'); // Um usuário tem um endereço
}
```
No controller Endereco podemos usar este método user() para mostrar as informações

https://www.youtube.com/watch?v=qTH0b59Y00o


## Relacionamento em forms
```php
{{ Form::model($order) }}
    <div>
        {{ Form::label('title', 'Title:') }}
        {{ Form::text('title') }}
    </div>
 
    <div>
        {{ Form::label('description', 'Description:') }}
        {{ Form::textarea('description') }}
    </div>
{{ Form::close() }}
```
  
