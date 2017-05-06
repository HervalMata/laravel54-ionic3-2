[laravel-ide-helper]: https://github.com/barryvdh/laravel-ide-helper
## Ionic2 com Laravel 5.4

Curso de Laravel com Ionic2 para desenvolver uma aplicação baseada com o NetFlix.

## Passos executados

1 - Laravel 5 IDE Helper Generator: [Leia mais.][laravel-ide-helper]

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

2 - Criar Banco de Dados no MySQL 5.7

```bash
$ mysql -uroot -p123478
mysql> create database code_laravel54_ionic2;
mysql> exit;
```
3 - Criando usuário administrador

```bash
$ php artisan make:migration add_role_to_users_table --table=users
$ php artisan make:migration create_user_admin_data --table=users
$ php artisan migrate:refresh
```

4 - Criando usuários com seeders

```bash
$ php artisan make:seeder UsersTableSeeder
$ php artisan migrate:refresh --seed
```

5 - Autenticando usuários Administrativos

```bash
$ php artisan make:auth

# alterando a role do user 1
$ mysql -uroot -p123478
mysql> use code_laravel54_ionic2;
mysql> update users set role=2 where id=1;
```

6 - Por minha conta: Add Whoops na Aplicação - [Leia mais](https://github.com/GrahamCampbell/Laravel-Exceptions)

```bash
$ composer require graham-campbell/exceptions
$ composer require filp/whoops --dev

# add as configurações
$ php artisan vendor:publish --provider="GrahamCampbell\Exceptions\ExceptionsServiceProvider"
```

7 - Traduzir o envio de e-mail para pt-BR - Aula 25 traduzindo e-mails

```bash
$ php artisan make:notification DefaultResetPasswordNotification
$ php artisan vendor:publish --tag=laravel-notifications
# criar UserController com resources e o model Models\User
$ php artisan make:controller Admin\\UserController --resource --model=Models\\User
```

8 - Pacote bootstrapper [Leia Mais](https://github.com/patricktalmadge/bootstrapper)

```bash
# http://bootstrapper.patrickrosemusic.co.uk/installation
$ composer require patricktalmadge/bootstrapper:5.*
```

9 - Pacote [Laravel 5 form builder](https://github.com/kristijanhusak/laravel-form-builder)

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