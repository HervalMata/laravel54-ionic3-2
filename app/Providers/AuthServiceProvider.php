<?php

namespace CodeFlix\Providers;

use CodeFlix\Models\User;
use function dd;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'CodeFlix\Model' => 'CodeFlix\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //autorizando usuario - aula 20 - Auto usuarios adm
        //ira retorna true or false
        \Gate::define('admin', function ($user){
            return $user->role == User::ROLE_ADMIN;
        });
    }
}
