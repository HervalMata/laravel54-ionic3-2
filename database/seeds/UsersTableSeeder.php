<?php

use CodeFlix\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 20)
            ->states('admin')
            ->create()->each(function ($user){
                $user->verified = true;
                $user->save();
            });
    }
}
