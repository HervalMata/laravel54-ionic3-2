<?php

namespace CodeFlix\Media;


use function dd;
use function env;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Imagine\Image\Box;
use function md5;
use function time;

trait VideoUploadTrait
{
    //use UploadTrait;
    /**
     * @param $id
     * @param UploadedFile $file
     * @return mixed
     */
    public function uploadFile($id, UploadedFile $file)
    {
        $model = $this->find($id);
        //movendo o file para o lugar certo
        $name = $this->upload($model, $file, 'file');
        if ($name) {
            $this->deleteFileOld($model);
            $model->file = $name;
            $model->save();
        }

        return $model;
    }

    public function deleteFileOld($model)
    {
        /** @var FilesystemAdapter $storage */
        $storage = $model->getStorage();

        if($storage->exists($model->file_relative)){
            $storage->delete($model->file_relative);
        }
    }
}