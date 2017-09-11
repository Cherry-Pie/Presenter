<?php

namespace Yaro\Presenter;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Yaro\Presenter\Helpers\ObjectArray;

abstract class AbstractPresenter implements Arrayable
{
    protected $model;

    /**
     * Arrayable attributes (functions/presents)
     * @var array
     */
    protected $arrayable = [];

    /**
     * Presenter constructor.
     * @param $model
     */
    public function __construct($model = null)
    {
        $this->model = is_array($model) ? new ObjectArray($model) : $model;
    }

    public function getArrayableAttributes()
    {
        return $this->arrayable;
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->model, $method], $args);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->model->{$name};
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];

        foreach ($this->getArrayableAttributes() as $key) {
            $methodName = 'get'.Str::studly($key).'Present';

            if (method_exists($this, $methodName)) {
                $result[$key] = $this->{$methodName}();
            } else {
                $result[$key] = $this->model->{$key};
            }
        }

        return $result;
    }
}
