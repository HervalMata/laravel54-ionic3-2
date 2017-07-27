<?php

namespace Tests\Feature\Api;

use Dingo\Api\Routing\UrlGenerator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAccessToken()
    {
        /*
        Model::unguard();

        dd(\DB::table('users')->get());
        $user = factory(User::class)
            ->states('admin')
            ->create([
                'email' => 'admin@user.com',
                'verified' => true
            ]);
        */
        $urlGenerator = app(UrlGenerator::class)->version('v1');

        $this->post($urlGenerator->route('api.access_token', [
            'email' => 'admin@user.com',
            'password' => 'secret'
        ]))
            ->assertStatus(200)
        ->assertJsonStructure(['token']);
    }
}
