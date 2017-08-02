<?php

namespace Tests\Feature\Admin;

use CodeFlix\Models\User;
use function factory;
use Illuminate\Database\Eloquent\Model;
use function route;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIfUserDoesntSeeUsersList()
    {
        $this->get(route('admin.users.index'))
            //->assertSee("Listagem de Usuários")
            ->assertRedirect(route('admin.login'))
            ->assertStatus(302);
    }

    public function testIfUserSeeUsersList()
    {
        Model::unguard();
        $user = factory(User::class)
            ->states('admin')
            ->create(['verified' => true]);

        $this->actingAs($user)
            ->get(route('admin.users.index'))
            ->assertStatus(200)
            ->assertSee('Listagem de Usuários');

        $this->get(route('admin.users.index'))
            ->assertStatus(200)
            ->assertSee('Listagem de Usuários');
    }

}
