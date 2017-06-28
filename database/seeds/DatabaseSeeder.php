<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->deletDirectory();
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(SeriesTableSeeder::class);
        $this->call(VideosTableSeeder::class );
    }

    public function deletDirectory()
    {
        $rootPath = config('filesystems.disks.videos_local.root');
        \File::deleteDirectory($rootPath, true);
    }
}
