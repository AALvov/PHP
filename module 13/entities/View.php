<?php

abstract class View
{
    public $storage;

    public function __construct(Storage $object)
    {
        $this->storage = $object;
    }

    abstract protected function displayTextById($id);

    abstract protected function displayTextByUrl($url);

}