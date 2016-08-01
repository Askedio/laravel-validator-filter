<?php

namespace Askedio\LaravelValidatorFilter;

class Filter
{
    protected $attribute;

    protected $value;

    protected $parameters;

    protected $validator;

    protected $functional;

    protected $filters = [];

    protected $data;

    public function run($attribute, $value, $parameters, $validator)
    {
        $this->attribute = $attribute;
        $this->value = $value;
        $this->parameters = $parameters;
        $this->validator = $validator;

        $this->process();

        $this->replace();
    }

    public function register($name, $callback)
    {
        $this->filters[$name] = $callback;
    }

    protected function process()
    {
        $value = $this->value;

        foreach ($this->parameters as $param) {
            if (array_key_exists($param, $this->filters)) {
                $value = call_user_func($this->filters[$param], $value);
                continue;
            }

            if (is_callable($param)) {
                $value = call_user_func($param, $value);
                continue;
            }

            if ($this->stringHasAFunction($param)) {
                $value = $this->callFunctionFromString($value);
                continue;
            }
        }

        $this->data = $value;
    }

    protected function stringHasAFunction($param)
    {
        preg_match('/(.*)\[(.*)\]/s', $param, $this->functional);

        return count($this->functional) == 3 && is_callable($this->functional[1]);
    }

    private function callFunctionFromString($value)
    {
        return call_user_func_array($this->functional[1], array_map(function ($string) use ($value) {
            return strtr($string, ['{$value}' => $value]);
        }, explode(';', $this->functional[2])));
    }

    private function replace()
    {
        $replace = array_merge(array_dot($this->validator->getData()), [$this->attribute => $this->data]);

        if (request()->has($this->attribute)) {
            request()->replace($replace);
        }

        $this->validator->setData($replace);
    }
}
