<?php

namespace CodeFlix\Media;


use function env;

trait ThumbPathTrait
{
    use VideoStorageTrait;

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