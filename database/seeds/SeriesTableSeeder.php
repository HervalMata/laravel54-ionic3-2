<?php

use CodeFlix\Models\Serie;
use CodeFlix\Repositories\SerieRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class SeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Serie::truncate();
        $this->createData(5);
    }

    /**
     * @param int $max
     */
    private function createData($max = 5)
    {
        /** @var Collection $series */
        $series = factory(Serie::class, $max)->create();
        $repository = app(SerieRepository::class);
        $collectionThumbs = $this->getThumbs();
        $series->each(function ($serie) use ($repository, $collectionThumbs){
            $repository->uploadThumb($serie->id, $collectionThumbs->random());
        });

        // Exibe uma informação no console durante o processo de seed
        $this->command->info($max . ' demo series created');
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
}
