[laravel-ide-helper]: https://github.com/barryvdh/laravel-ide-helper
## Ionic2 com Laravel 5.4

Curso de Laravel com Ionic2 para desenvolver uma aplicação paracida com o NetFlix.

## Passos executados

- Laravel 5 IDE Helper Generator: [Leia mais.][laravel-ide-helper]

```bash
# add no composer dev
$ composer require --dev barryvdh/laravel-ide-helper 
$ php artisan vendor:publish --provider="Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider" --tag=config
$ php artisan ide-helper:generate
$ php artisan ide-helper:meta
```
- Criar Banco de Dados no MySQL 5.7

```bash
$ mysql -uroot -p123478
mysql> create database code_laravel54_ionic2;
mysql> exit;
```
