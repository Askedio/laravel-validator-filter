<?php

namespace Askedio\LaravelValidatorFilter\Tests;

class FilterTest extends BaseTestCase
{
    public function testThatFilterCanUseNl2Br()
    {
        $string = 'Hello ' . PHP_EOL . ' World';

        $validator = app('validator')->make([
          'string' => $string,
        ], [
          'string' => 'filter:nl2br',
        ]);

        $validator->passes();

        $this->assertEquals($validator->getData()['string'], nl2br($string));
    }

    public function testThatFilterCanUseStripTagsButKeepBr()
    {
        $string = 'Hello <br> World<p></p>';

        $validator = app('validator')->make([
          'string' => $string,
        ], [
          'string' => 'filter:strip_tags[{$value}; "<br>"]',
        ]);

        $validator->passes();

        $this->assertEquals($validator->getData()['string'], strip_tags($string, '<br>'));
    }
}
