<?php

namespace CodeFlix\Repositories;

use function array_except;
use CodeFlix\Media\ThumbUploadTrait;
use function dd;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeFlix\Repositories\SerieRepository;
use CodeFlix\Models\Serie;
use CodeFlix\Validators\SerieValidator;

/**
 * Class SerieRepositoryEloquent
 * @package namespace CodeFlix\Repositories;
 */
class SerieRepositoryEloquent extends BaseRepository implements SerieRepository
{
    use ThumbUploadTrait;

    public function create(array $attributes)
    {
        //dd($attributes);
        $model =  parent::create(array_except($attributes, 'thumb_file'));
        $this->uploadThumb($model->id, $attributes['thumb_file']);

        return $model;
    }

    public function update(array $attributes, $id)
    {
        $model =  parent::update(array_except($attributes, 'thumb_file'), $id);
        if(isset($attributes['thumb_file'])){
            $this->uploadThumb($model->id, $attributes['thumb_file']);
        }

        return $model;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Serie::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
