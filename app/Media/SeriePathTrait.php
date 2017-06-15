<?php

namespace CodeFlix\Media;


use function explode;

trait SeriePathTrait
{
    use VideoStorageTrait;

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

    /**
     * objetivo retornar a pasta de armazenamento com o atributo thumb do BD
     * @return string
     */
    public function getThumbRelativeAttribute()
    {
        return "{$this->thumb_folder_storage}/{$this->thumb}";
    }

    /**
     * @return mixed
     */
    public function getThumbPathAttribute()
    {
        return $this->getAbsolutePath($this->getStorage(),
            $this->thumb_relative);
    }

    /**
     * @return string
     */
    public function getThumbSmallRelativeAttribute()
    {
        list($name, $extension) = explode('.', $this->thumb);
        return "{$this->thumb_folder_storage}/{$name}_small.{$extension}";
    }

    /**
     * @return mixed
     */
    public function getThumbSmallPathAttribute()
    {
        return $this->getAbsolutePath($this->getStorage(),
            $this->thumb_small_relative);
    }
}