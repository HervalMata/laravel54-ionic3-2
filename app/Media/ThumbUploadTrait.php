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
    //use UploadTrait;
    /**
     * @param $id
     * @param UploadedFile $file
     * @return mixed
     */
    public function uploadThumb($id, UploadedFile $file)
    {
        $model = $this->find($id);
        //movendo o file para o lugar certo
        $name = $this->upload($model, $file, 'thumb');
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