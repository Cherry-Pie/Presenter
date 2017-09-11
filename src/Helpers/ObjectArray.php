<?php

namespace App\Presenter\Helpers;

class ObjectArray
{
    private $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get(string $name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }
}
