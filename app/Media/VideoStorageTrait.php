<?php

namespace CodeFlix\Media;


use function config;
use Illuminate\Filesystem\FilesystemAdapter;
use Storage;

trait VideoStorageTrait
{
    /**
     * para saber qual o loca de armazenamento
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public function getStorage()
    {
        return Storage::disk($this->getDiskDrive());
    }

    /**
     * para saber o driver que esta sendo usado do disco
     * @return mixed
     */
    protected function getDiskDrive()
    {
        return config('filesystems.default');
    }

    /**
     * Retorna o driver (o disco) e o adaptador, que se refere ao local de
     * armazenamento, aplicando o path prefixo que eh o relativePath.
     * Retornado o camninho completo do video.
     * @param FilesystemAdapter $storage
     * @param $fileRelativePath
     * @return mixed
     */
    protected function getAbsolutePath(FilesystemAdapter $storage, $fileRelativePath)
    {
        return $this->isLocalDriver()?
            $storage->getDriver()->getAdapter()->applyPathPrefix
            ($fileRelativePath): $storage->url($fileRelativePath);
    }

    public function isLocalDriver()
    {
        $driver = config("filesystems.disks.{$this->getDiskDrive()}.driver");

        return $driver == 'local';
    }
}