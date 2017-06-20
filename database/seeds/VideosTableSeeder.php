<?php

use CodeFlix\Models\Video;
use CodeFlix\Repositories\VideoRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createData(2);
    }

    private function createData($max = 5)
    {
        /** @var Collection $series */
        $series = \CodeFlix\Models\Serie::all();
        $categories = \CodeFlix\Models\Category::all();
        $repository = app(VideoRepository::class);
        $collectionThumbs = $this->getThumbs();
        $collectionVideos = $this->getVideos();
        factory(Video::class, $max)
            ->create()//cria o video e retorna uma collection
            //pode trabalhar com cada elemento da iteracao, no caso video
            // instancia incluida no BD
            ->each(function ($video) use (
                $series,
                $categories,
                $repository,
                $collectionThumbs,
                $collectionVideos
            ) {
                $repository->uploadThumb($video->id, $collectionThumbs->random());
                $repository->uploadFile($video->id, $collectionVideos->random
                ());
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

    protected function getThumbs()
    {
        return new \Illuminate\Support\Collection([
            new UploadedFile(
                storage_path('app/files/faker/thumbs/thumb_symfony.jpg'),
                'thumb_symfony.jpg'
            )
        ]);
    }

    protected function getVideos()
    {
        return new \Illuminate\Support\Collection([
            new UploadedFile(
                storage_path('app/files/faker/videos/Fluxo-git-flow.mp4'),
                'Fluxo-git-flow.mp4'
            )
        ]);
    }
}
