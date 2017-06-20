<?php

namespace CodeFlix\Media;


use function env;
use const false;

trait ThumbPathTrait
{
    use VideoStorageTrait;

    /**
     * objetivo retornar a pasta de armazenamento com o atributo thumb do BD
     * @return string
     */
    public function getThumbRelativeAttribute()
    {
        return $this->thumb ? "{$this->thumb_folder_storage}/{$this->thumb}"
            : false;
    }

    /**
     * @return mixed
     */
    public function getThumbPathAttribute()
    {
        if ($this->thumb_relative) {
            return $this->getAbsolutePath($this->getStorage(),
                $this->thumb_relative);
        }
        return false;
    }

    /**
     * @return string
     */
    public function getThumbSmallRelativeAttribute()
    {
        if ($this->thumb) {
            list($name, $extension) = explode('.', $this->thumb);
            return "{$this->thumb_folder_storage}/{$name}_small.{$extension}";
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getThumbSmallPathAttribute()
    {
        if ($this->thumb_small_relative) {
            return $this->getAbsolutePath($this->getStorage(),
                $this->thumb_small_relative);
        }

        return false;
    }

}