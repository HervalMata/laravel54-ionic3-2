<?php
/**
 * Retorna os "values" pela "key".
 * Basta criar um arquivo php no dir "config" com um retorno de array.
 *
 * @link: https://scotch.io/tutorials/how-to-use-laravel-config-files
 * Para usar basta dizer a facade qual o arquivo de configuração usar.
 * Para isso, basta digitar o nome do arquivo de configuração sem ".php" e um ponto
 * depois como este.
 * @example: {{(Config::get('filePHP.key.key1'))}}
 *           echo Config::get('social.facebook.url');
 */
return [
    'app' => [
        'comercial' => 'CodeFlix - Seus vídeos em um só lugar',
        'ver' => env('APP_VER', '0.0.1'),
    ],

];
