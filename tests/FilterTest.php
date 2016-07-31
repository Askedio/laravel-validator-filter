<?php

namespace Askedio\LaravelValidatorFilter\Tests;

class FilterTest extends BaseTestCase
{
    public function testThatFilterCanUseNl2Br()
    {
        $validator = app('validator')->make([
          'title' => 'Hello ' . PHP_EOL . ' World'
        ], [
          'title' => 'filter:nl2br',
        ]);

        $validator->fails();

        $this->assertEquals($validator->getData()['title'], nl2br('Hello ' . PHP_EOL . ' World'));

    }
}
