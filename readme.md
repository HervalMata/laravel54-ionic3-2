[laravel-ide-helper]: https://github.com/barryvdh/laravel-ide-helper
# Ionic2 com Laravel 5.4

Curso de Laravel com Ionic2 para desenvolver uma aplicação baseada com o NetFlix.

## Passos com Beckend

#### 1 - Laravel 5 IDE Helper Generator: [Leia mais.][laravel-ide-helper]

```bash
# add no composer dev
$ composer require --dev barryvdh/laravel-ide-helper 
$ php artisan vendor:publish --provider="Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider" --tag=config
$ php artisan ide-helper:generate
$ php artisan ide-helper:meta
```
Autocomplete dos métodos fluentes do Laravel com o IDE Helper Generator
Basta acessar `config/ide-helper.php`, e alterar a linha abaixo:

```php
// de false para true
...
'include_fluent' => true,
...
```
Para ter o autocomple dos Models, tem que instalar uma dependência:

```bash
$ composer require doctrine/dbal:~2.3
# para gerar doc de um Model com o Laravel IDE Helper
$ php artisan ide-helper:models --dir="app/Models" "CodeFlix\Models\User"
# ou para toda o dir
$ php artisan ide-helper:models --dir="app/Models"
# ou para ignorar algum model
$ php artisan ide-helper:models --dir="app/Models" --ignore="Post,User"
```

#### 2 - Criar Banco de Dados no MySQL 5.7

```bash
$ mysql -uroot -p123478
mysql> create database code_laravel54_ionic2;
mysql> exit;
```
#### 3 - Criando usuário administrador

```bash
$ php artisan make:migration add_role_to_users_table --table=users
$ php artisan make:migration create_user_admin_data --table=users
$ php artisan migrate:refresh
```

#### 4 - Criando usuários com seeders

```bash
$ php artisan make:seeder UsersTableSeeder
$ php artisan migrate:refresh --seed
```

#### 5 - Autenticando usuários Administrativos

```bash
$ php artisan make:auth

# alterando a role do user 1
$ mysql -uroot -p123478
mysql> use code_laravel54_ionic2;
mysql> update users set role=2 where id=1;
```

#### 6 - Por minha conta: Add Whoops na Aplicação - [Leia mais](https://github.com/GrahamCampbell/Laravel-Exceptions)

```bash
$ composer require graham-campbell/exceptions
$ composer require filp/whoops --dev

# add as configurações
$ php artisan vendor:publish --provider="GrahamCampbell\Exceptions\ExceptionsServiceProvider"
```

```php
...
class Handler extends ExceptionHandler
{
...
// por 
...
class Handler extends GrahamCampbell\Exceptions\NewExceptionHandler
{
...
```

#### 7 - Traduzir o envio de e-mail para pt-BR - Aula 25 traduzindo e-mails

```bash
$ php artisan make:notification DefaultResetPasswordNotification
$ php artisan vendor:publish --tag=laravel-notifications
# criar UserController com resources e o model Models\User
$ php artisan make:controller Admin\\UserController --resource --model=Models\\User
```

#### 8 - Pacote bootstrapper [Leia Mais](https://github.com/patricktalmadge/bootstrapper)

```bash
# http://bootstrapper.patrickrosemusic.co.uk/installation
$ composer require patricktalmadge/bootstrapper:5.*
# opcional
```

#### 9 - Pacote [Laravel 5 form builder](https://github.com/kristijanhusak/laravel-form-builder)

Pacote para criação de usuários, inspirado no Symfony's form builder, com suporte ao Bootstrap 3
Esse pacote usa o pacote [Laravel Collective HTML](https://laravelcollective.com/docs/5.3/html).

Links da documentação do Pacote:

[http://kristijanhusak.github.io/laravel-form-builder/overview/installation.html]()
[https://packagist.org/packages/kris/laravel-form-builder]()

```bash
# instalando uma versão específica
$ composer require kris/laravel-form-builder:1.11.0
$ composer update
# para criar a classe de Form
$ php artisan make:form Forms/UserForm --fields="name:text, email:email"
```

#### 10 - Pacote [Laravel 5 Repositories](https://github.com/andersao/l5-repository)

Laravel 5 Repositories é usado para abstrair a camada de dados, tornando nossa aplicação mais flexível para manter.
Você quer saber um pouco mais sobre o padrão do Repositório? [Using Repository Pattern in Laravel 5](http://bit.ly/1IdmRNS).

Links da documentação do Pacote:

https://packagist.org/packages/prettus/l5-repository

```bash
# instalando uma versão específica
$ composer require prettus/l5-repository:2.6.18
$ php artisan vendor:publish --provider "Prettus\Repository\Providers\RepositoryServiceProvider"
$ php artisan make:repository Category
$ php artisan make:provider RepositoryServiceProvider
```

#### 11 - Pacote [Laravel User Verification](https://github.com/jrean/laravel-user-verification)

```bash
# instalando uma versão específica
$ composer require https://github.com/jrean/laravel-user-verification:4.1.9
```
adiconar a Facade no `config/app.php`:

```php
# RouteServiceProvider
Jrean\UserVerification\UserVerificationServiceProvider::class,
...
# Alias
'UserVerification' => Jrean\UserVerification\Facades\UserVerification::class,
# Publicar o package config file com o comando:
$ php artisan vendor:publish --provider="Jrean\UserVerification\UserVerificationServiceProvider" --tag="migrations"
# arquivo de configuração
$ php artisan vendor:publish --provider="Jrean\UserVerification\UserVerificationServiceProvider" --tag="config"
$ php artisan vendor:publish --provider="Jrean\UserVerification\UserVerificationServiceProvider" --tag=views
```

Depois das configurções rodas as migrates:

 ```bash
 $ php artisan migrate:refresh --seed
 ```

## Passos com o Frontend

#### 1 - Instalar o node na Aplicação Laravel

```bash
# instalando a dependências do NodeJS na raiz do projeto
$ npm install
# compilar os js/css da aplicação
$ npm run dev
```

#### 2 - Usando o Laravel Mix - Reloading
Para rodar o watch o servidor do artisan já deverá estar rodando, pois o **browserSync**, usa um proxy no servidor do artisan na porta 8000, para a porta 3000.

```js
/* rodando o watch */
mix.browserSync('http://localhost:8000');
```

```bash
# rode o servidor do artisan
$ php artisan serve
# rodando o watch
$ npm run watch
```

#### 3 - Exercícios: Implementando Usuários e Categorias

Usuários e Categorias

Nesta primeira fase, você deverá implementar:

* A autenticação administrativa dos usuários com verificação da conta.
* A administração de usuários.
* Uma área em que o usuário possa alterar sua senha. Cria duas rotas, uma para mostrar o formulário de alteração de senha e outra para realizar o processo. Quando o usuário validar a conta, deve ser redirecionado para a área de alteração de senha.
* A administração de categorias. Cada categoria terá id e name.

Faça todas as implementações usando repositórios e acrescente a barra de menus com os links necessários.

```bash
# Criar migrate categories metodo tradicional Laravel
$ php artisan make:migration create_categories_table --create=categories
# criando o model
$ php artisan make:model Models/Category
# ou tudo de uma vez
$ php artisan make:model Category -m
# cria mapeamento do Model
$ php artisan ide-helper:models --dir="app/Models" "CodeFlix\Models\Category"
# gera o ide_helper
$ php artisan ide-helper:generate
# criar classe para popilar dados
$ php artisan make:seeder CategoriesTableSeeder
# reset db
$ php artisan migrate:refresh
# comando para ler a classe que popula os dados
$ php artisan db:seed
```

Criar Model Categories pelo Pacote **prettus/l5-repository**, após gerar os 
arquivos é necessário registrar no RepositoryServiceProvider o bind apontando
 para o model do Elquent.

```bash
# O comando abaixo ira gerar os seguinte arquivios:
#################
# Model: Category.php
# Migrate: XXXX_create_categories_table.php
# Interface: CategoryRepository.php
# Classe Concreta: CategoryRepositoryEloquent.php
#################
$ php artisan make:repository Category
```

Controllers:

```bash
# Criando o Controller CategoryControler:
$ php artisan make:controller Admin/CategoryController --model=Models/Category
```

Usando o pacote FormBuilder

```bash
$ php artisan make:form Forms/CategoryForm --fields="name:text"
```

Criando Manter Série:

```bash
#com o plugin do la5 no zsh bash pode usar o la5 ou php artisan para 
autocomplete
$ la5 make:repository Serie
#ou
$ php artisan make:repository Serie
$ la5 make:controller Admin/SerieController --resource --model=CodeFlix/Models/Serie
$ php artisan make:seeder SeriesTableSeeder
```

API:

usando a biblioteca jwt-auth:

```bash
#https://github.com/tymondesigns/jwt-auth
$ composer require tymon/jwt-auth:"dev-develop#9f759fe9e3112e1de50920c05537d752780cf966"

#add no app.php
'Tymon\JWTAuth\Providers\JWTAuthServiceProvider'

$ php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

$ php artisan jwt:secret

$ php artisan make:controller Api\AuthController

```

Entendeno o Token: https://jwt.io/

```json
{
  //quem eh o emissor do token
  "iss": "http://localhost:8000/api/access_token",
  
  //data de qudo foi gerado o token
  "iat": 1499391203,
  
  //data de quando expira o token
  "exp": 1499394803,
  //diz q soh pode ser usado a partir de tal momento
  "nbf": 1499391203,
  
  //id unico para identificar o token
  "jti": "v6ideJGjL9dUcy6N",
  
  //sujeito do token que a resposta da implementacao do metodo
  //da interface getJWTIdentifier(), no model User.
  "sub": 1,
  
  //as identificacoes customizadas de reivindicacao, implementado 
  //pela interface JWTSubject->getJWTCustomClaims(), no model User 
  "user": {
    "id": 1,
    "name": "Administrator",
    "email": "admin@user.com"
  }
}
```

Aula Rate limiting ok
