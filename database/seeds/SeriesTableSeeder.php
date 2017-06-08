<?php

use CodeFlix\Models\Serie;
use Illuminate\Database\Seeder;

class SeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Serie::truncate();

        $this->createData(5);
    }

    private function createData($max = 5)
    {
        factory(Serie::class, $max)->create();
        // Exibe uma informação no console durante o processo de seed
        $this->command->info($max . ' demo series created');
    }
}
