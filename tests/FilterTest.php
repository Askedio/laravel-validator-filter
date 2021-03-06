<?php

namespace Askedio\LaravelValidatorFilter\Tests;

class FilterTest extends BaseTestCase
{
    public function testThatFilterCanUseNl2Br()
    {
        $string = 'Hello '.PHP_EOL.' World';

        request()->replace(['string' => $string]);

        $validator = app('validator')->make([
          'string' => $string,
        ], [
          'string' => 'filter:nl2br',
        ]);

        $validator->passes();

        $result = nl2br($string);

        $this->assertEquals($validator->getData()['string'], $result);
        $this->assertEquals(request()->get('string'), $result);
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

    public function testCustomFilter()
    {
        app('filter')->register('plusOne', function ($value) {
            return $value + 1;
        });

        $validator = app('validator')->make([
          'int' => '<br>1',
        ], [
          'int' => 'filter:strip_tags,plusOne',
        ]);

        $validator->passes();

        $this->assertEquals($validator->getData()['int'], 2);
    }
}
