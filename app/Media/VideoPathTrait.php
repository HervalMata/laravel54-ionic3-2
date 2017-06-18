<?php

namespace CodeFlix\Media;


use function explode;
use function route;

trait VideoPathTrait
{
    use ThumbPathTrait;

    //“Accessor e Mutator: propriedades extras as classes do modelo tratando-as como se
    // fossem os campos da tabela”
    // Accessor é usado para se obter um valor personalizado de uma classe, como se
    // fosse uma propriedade.
    // Mutator é usado para preencher uma propriedade da classe,
    //“Para criar um Accessor, deve-se criar um método com o prefixo get e
    // o sufixo Attribute”
    /**
     * retorna o ID da serie, sera retornado o ID, pois será usada essa trait
     * no model Serie.
     * @return string
     */
    public function getThumbFolderStorageAttribute()
    {
        return "videos/{$this->id}";
    }


    public function getThumbAssetAttribute()
    {
        //return route('admin.series.thumb_asset', ['serie'=>$this->id]);
    }

    public function getThumbSmallAssetAttribute()
    {
        //return route('admin.series.thumb_small_asset', ['serie'=>$this->id]);
    }

    public function getThumbDefaultAttribute()
    {
        return env('VIDEO_NO_THUMB');
    }

}