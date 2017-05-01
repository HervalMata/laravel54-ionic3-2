[laravel-ide-helper]: https://github.com/barryvdh/laravel-ide-helper
## Ionic2 com Laravel 5.4

Curso de Laravel com Ionic2 para desenvolver uma aplicação baseada com o NetFlix.

## Passos executados

- Laravel 5 IDE Helper Generator: [Leia mais.][laravel-ide-helper]

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

- Criar Banco de Dados no MySQL 5.7

```bash
$ mysql -uroot -p123478
mysql> create database code_laravel54_ionic2;
mysql> exit;
```
- Criando usuário administrador

```bash
$ php artisan make:migration add_role_to_users_table --table=users
$ php artisan make:migration create_user_admin_data --table=users
$ php artisan migrate:refresh
```

- Criando usuários com seeders

```bash
$ php artisan make:seeder UsersTableSeeder
$ php artisan migrate:refresh --seed
```

- Autenticando usuários Administrativos

```bash
$ php artisan make:auth

# alterando a role do user 1
$ mysql -uroot -p123478
mysql> use code_laravel54_ionic2;
mysql> update users set role=2 where id=1;
```

- Por minha conta: Add Whoops na Aplicação - [Leia mais](https://github.com/GrahamCampbell/Laravel-Exceptions)

```bash
$ composer require graham-campbell/exceptions
$ composer require filp/whoops --dev

# add as configurações
$ php artisan vendor:publish --provider="GrahamCampbell\Exceptions\ExceptionsServiceProvider"
```

- Traduzir o envio de e-mail para pt-BR - Aula 25 traduzindo e-mails

```bash
$ php artisan make:notification DefaultResetPasswordNotification
$ php artisan vendor:publish --tag=laravel-notifications
# criar UserController com resources e o model Models\User
$ php artisan make:controller Admin\\UserController --resource --model=Models\\User
```