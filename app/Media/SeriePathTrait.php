<?php

namespace CodeFlix\Media;


use function explode;
use function route;

trait SeriePathTrait
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
        return "series/{$this->id}";
    }


    public function getThumbAssetAttribute()
    {
        return $this->isLocalDriver()?
            route('admin.series.thumb_asset',['serie' => $this->id]):
            $this->thumb_path;
    }

    public function getThumbSmallAssetAttribute()
    {
        return $this->isLocalDriver()?
            route('admin.series.thumb_small_asset', ['serie' => $this->id]):
            $this->thumb_small_path;
    }

    public function getThumbDefaultAttribute()
    {
        return env('SERIE_NO_THUMB');
    }

}