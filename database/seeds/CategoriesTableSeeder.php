<?php

use CodeFlix\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;

class CategoriesTableSeeder extends Seeder
{
    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Category::truncate();

        $this->createData(5);
    }

    private function createData($max = 10)
    {
        factory(Category::class, $max)->create();
        // Exibe uma informação no console durante o processo de seed
        $this->command->info($max . ' demo categories created');
    }
}
