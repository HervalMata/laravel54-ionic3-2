<?php

namespace CodeFlix\Repositories;

use CodeFlix\Media\ThumbUploadTrait;
use CodeFlix\Media\UploadTrait;
use CodeFlix\Media\VideoUploadTrait;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeFlix\Repositories\VideoRepository;
use CodeFlix\Models\Video;
use CodeFlix\Validators\VideoValidator;

/**
 * Class VideoRepositoryEloquent
 * @package namespace CodeFlix\Repositories;
 */
class VideoRepositoryEloquent extends BaseRepository implements VideoRepository
{
    use ThumbUploadTrait, VideoUploadTrait, UploadTrait;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Video::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $model = parent::update($attributes, $id);
        if(isset($attributes['categories'])){
            $model->categories()->sync($attributes['categories']);
        }

        return $model;
    }
}
