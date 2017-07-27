<?php

namespace CodeFlix\Providers;

use CodeFlix\Models\Video;
use Dingo\Api\Exception\Handler;
use Form;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\ServiceProvider;
use const null;
use function response;
use const true;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //registrando um evento que ira executar algo apos a atualizacao do
        //video - aula Concluindo uploads de arquivo
        Video::updated(function($video){
            if(!$video->completed) {
                if ($video->file != null &&
                    $video->thumb != null &&
                    $video->duration != null
                ) {
                    $video->completed = true;
                    $video->save();
                }
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

//        $this->app->bind(
//            'bootstrapper::form',
//            function ($app) {
//                $form = new Form(
//                    $app->make('collective::html'),
//                    $app->make('url'),
//                    $app->make('view'),
//                    $app['session.store']->token()
//                );
//
//                return $form->setSessionStore($app['session.store']);
//            },
//            true
//        );

        $handler = app(Handler::class);

        //config um status code erro diferente no digo API
        $handler->register(function (AuthenticationException $exception){
           return response()->json(['error' => 'Unauthenticated'], 401);
        });
    }
}
