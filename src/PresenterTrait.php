<?php

namespace Yaro\Presenter;

trait PresenterTrait
{
    protected $presenter = '';

    public function setPresenterClass(string $class)
    {
        $this->presenter = $class;

        return $this;
    }

    public function getPresenterClass(string $class)
    {
        return $this->presenter;
    }

    public function isSamePresenterClass(string $class)
    {
        return $this->presenter == $class;
    }

    public function toArray()
    {
        $presenter = $this->presenter;
        if ($presenter) {
            $presenter = new $presenter($this);
            return $presenter->toArray();
        }

        return parent::toArray();
    }
}
