# Laravel Validator Filter
Filter items before your validate them with Laravel 5s Validator.

Values will be filtered based on the function you provide. If the parameter exists in the request it will also be replaced.

[![Build Status](https://travis-ci.org/Askedio/laravel-validator-filter.svg?branch=master)](https://travis-ci.org/Askedio/laravel-validator-filter)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/f91e7399c0ff40c988ba1587f3594d8a)](https://www.codacy.com/app/gcphost/laravel-validator-filter?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Askedio/laravel-validator-filter&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/f91e7399c0ff40c988ba1587f3594d8a)](https://www.codacy.com/app/gcphost/laravel-validator-filter?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Askedio/laravel-validator-filter&amp;utm_campaign=Badge_Coverage)
[![StyleCI](https://styleci.io/repos/74531615/shield?branch=master)](https://styleci.io/repos/74531615)

# Installation
~~~
composer require askedio/laravel-validator-filter
~~~

Add the following to the providers array in `config/app.php`:
~~~
Askedio\LaravelValidatorFilter\FilterServiceProvider::class
~~~

# Examples

You can use any function that is callable and accepts the value as the parameter.
```php
$validator = app('validator')->make([
  'string' => 'Hello ' . PHP_EOL . ' World',
], [
  'string' => 'filter:strip_tags,nl2br',
]);

$validator->passes();

dd($validator->getData());
```

You can use a function with parameters in line. `()` = `[]` & `,` = `;`.
```php
$validator = app('validator')->make([
  'string' => 'Hello <br> World<p></p>',
], [
  'string' => 'filter:strip_tags[{$value}; "<br>"]',
]);

$validator->passes();

dd($validator->getData());
```

You can also define your own custom filter.
```php
app('filter')->register('plusOne', function ($value) {
    return $value+1;
});

$validator = app('validator')->make([
  'int' => '<br>1',
], [
  'int' => 'filter:strip_tags,plusOne',
]);

$validator->passes();

dd($validator->getData());
```
