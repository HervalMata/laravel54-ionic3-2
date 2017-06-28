<?php

namespace CodeFlix\Providers;

use CodeFlix\Models\Video;
use function functionCallback;
use Illuminate\Support\ServiceProvider;
use const null;
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
    }
}
