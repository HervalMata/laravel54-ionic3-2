<?php

namespace CodeFlix\Media;


use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;

trait UploadTrait
{
    /**
     * @param $model
     * @param UploadedFile $file
     * @return false|string
     */
    public function upload($model, UploadedFile $file, $type)
    {

        /** @var FilesystemAdapter $storage */
        $storage = $model->getStorage();
        //gerando o nome arquivo
        $name = md5(time() . "{$model->id}-{$file->getClientOriginalName()
        }") . ".{$file->getClientOriginalExtension()}";

        //dd($name);
        //se nao guardar retorna false
        $result = $storage->putFileAs($model->{"{$type}_folder_storage"}, $file,
            $name);

        return $result ? $name : $result;
    }
}