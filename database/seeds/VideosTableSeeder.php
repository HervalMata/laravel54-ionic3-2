<?php

use CodeFlix\Models\Video;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createData(100);
    }

    private function createData($max = 5)
    {
        /** @var Collection $series */
        $series = \CodeFlix\Models\Serie::all();
        $categories = \CodeFlix\Models\Category::all();
        factory(Video::class, $max)
            ->create()//cria o video e retorna uma collection
            //pode trabalhar com cada elemento da iteracao, no caso video
            // instancia incluida no BD
            ->each(function ($video) use ($series, $categories) {
                //pega a relacao e nao a colecao, se quiser pegar a colecao
                // ($video->categories)
                $video->categories()->attach($categories->random(4)->pluck('id'));
                /** @var Video $video */
                $num = rand(1, 3);
                //somente se for 2 sera associado ao video
                if ($num % 2 == 0) {
                    //associa com a serie
                    //seleciona uma serie aleatoria
                    $serie = $series->random();
                    $video->serie_id = $serie->id;
                    //relaciona video com serie
                    $video->serie()->associate($serie);
                    $video->save();
                }
            });


        // Exibe uma informação no console durante o processo de seed
        $this->command->info($max . ' demo fake created');
    }
}
