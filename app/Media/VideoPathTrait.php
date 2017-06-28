<?php

namespace CodeFlix\Media;


use function explode;
use const false;
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

    public function getFileFolderStorageAttribute()
    {
        return "videos/{$this->id}";
    }

    public function getFileAssetAttribute()
    {
        return $this->isLocalDriver()?
            route('admin.videos.file_asset',['video' => $this->id]):
            $this->file_path;
    }

    public function getThumbDefaultAttribute()
    {
        return env('VIDEO_NO_THUMB');
    }

    /**
     * objetivo retornar a pasta de armazenamento com o atributo thumb do BD
     * @return string
     */
    public function getFileRelativeAttribute()
    {
        return $this->file ? "{$this->file_folder_storage}/{$this->file}"
            : false;
    }

    /**
     * @return mixed
     */
    public function getFilePathAttribute()
    {
        if($this->file_relative) {
            return $this->getAbsolutePath($this->getStorage(),
                $this->file_relative);
        }

        return false;
    }

    public function getThumbAssetAttribute()
    {
        return $this->isLocalDriver()?
            route('admin.videos.thumb_asset',['video' => $this->id]):
            $this->thumb_path;
    }

    public function getThumbSmallAssetAttribute()
    {
        return $this->isLocalDriver()?
            route('admin.videos.thumb_small_asset',['video' => $this->id]):
            $this->thumb_small_path;
    }

}