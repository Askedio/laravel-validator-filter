<?php

namespace Askedio\LaravelValidatorFilter;

class Filter
{

    public function __construct($attribute, $value, $parameters, $validator)
    {

      $data = [$attribute => $value];

      app('sanitizer')->sanitize([$attribute => $parameters], $data);

      $replace = array_merge(array_dot($validator->getData()), [$attribute => $data[$attribute]]);
      
      request()->replace($replace);

      $validator->setData($replace);

      return true;


    }
}
