<?php

namespace Askedio\LaravelValidatorFilter;

class Filter
{
    protected $attribute;

    protected $value;

    protected $parameters;

    protected $validator;

    protected $functional;

    public function __construct($attribute, $value, $parameters, $validator)
    {
        $this->attribute = $attribute;
        $this->value = $value;
        $this->parameters = $parameters;
        $this->validator = $validator;

        $this->setData();

        $this->run();
    }

    protected function run()
    {
        $this->replace($this->getData());
    }

    protected function getData()
    {
        return $this->data;
    }

    protected function setData()
    {
        if ($this->paramsContainAFunction()) {
            $this->data = [$this->attribute => $this->getValueFromFunction($this->value)];
            return;
        }

        $this->data = $this->replaceWithSanitizer();
    }

    protected function replaceWithSanitizer()
    {
        $data = [$this->attribute => $this->value];

        app('sanitizer')->sanitize([$this->attribute => $this->parameters], $data);

        return $data;
    }

    protected function paramsContainAFunction()
    {
        preg_match('/(.*)\[(.*)\]/s', implode($this->parameters), $this->functional);

        return count($this->functional) == 3 && function_exists($this->functional[1]);
    }

    private function getValueFromFunction($value)
    {
        return call_user_func_array($this->functional[1], array_map(function ($string) use ($value) {
            return strtr($string, ['{$value}' => $value]);
        }, explode(';', $this->functional[2])));
    }

    private function replace($data)
    {
        $replace = array_merge(array_dot($this->validator->getData()), [$this->attribute => $data[$this->attribute]]);

        request()->replace($replace);

        $this->validator->setData($replace);
    }
}
