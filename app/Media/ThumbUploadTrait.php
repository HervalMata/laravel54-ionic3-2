<?php

namespace CodeFlix\Media;


use function dd;
use function env;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Imagine\Image\Box;
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
            $this->deleteThumbOld($model);
            $model->thumb = $name;
            $this->makeThumbSmall($model);
            $model->save();
        }

        return $model;
    }

    protected function makeThumbSmall($model)
    {
        $storage = $model->getStorage();
        $thumbFile = $model->thumb_path;
        $format = \Image::format($thumbFile);
        $thumbnailSmall = \Image::open($thumbFile)->thumbnail(new Box(64, 36));
        $storage->put($model->thumb_small_relative, $thumbnailSmall->get($format));
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
        }") . ".{$file->getClientOriginalExtension()}";

        //dd($name);
        //se nao guardar retorna false
        $result = $storage->putFileAs($model->thumb_folder_storage, $file, $name);

        return $result ? $name : $result;
    }

    public function deleteThumbOld($model)
    {
        /** @var FilesystemAdapter $storage */
        $storage = $model->getStorage();

        if($storage->exists($model->thumb_relative) && $model->thumb !=
            $model->thumb_default){
            $storage->delete([$model->thumb_relative,
                $model->thumb_small_relative]);
        }
    }
}