<?php

namespace Tests\Browser;

use CodeFlix\Models\User;
use function route;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = User::where('email', '=', 'admin@user.com')->first();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(route('admin.categories.index'))
                ->clickLink('Nova Categoria')
                ->assertSee('Nova Categoria')
                ->type('name', 'test ')
                ->click('button[type=submit]')
                ->assertSee('Listagem de Categorias')
                ->assertSee('test');
        });
    }
}
