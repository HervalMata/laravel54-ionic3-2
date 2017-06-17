<?php

namespace CodeFlix\Media;


use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use function md5;
use function time;

trait ThumbUploadTrait
{
    /**
     * @param $id
     * @param UploadedFile $file
     * @return mixed
     */
    public function uploadThumb($id, UploadedFile $file)
    {
        $model = $this->find($id);
        //movendo o file para o lugar certo
        $name = $this->upload($model, $file);
        if ($name) {
            $model->thumb = $name;
            $model->save();
        }

        return $model;
    }

    /**
     * @param $model
     * @param UploadedFile $file
     * @return false|string
     */
    public function upload($model, UploadedFile $file)
    {

        /** @var FilesystemAdapter $storage */
        $storage = $model->getStorage();
        //gerando o nome arquivo
        $name = md5(time() . "{$model->id}-{$file->getClientOriginalName()
        }") . ".{$file->getExtension()}";
        //se nao guardar retorna false
        $result = $storage->putFileAs($model->thumb_folder_storage, $file, $name);

        return $result ? $name : $result;
    }
}