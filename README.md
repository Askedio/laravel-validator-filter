# Laravel Validator Filter
Filter items before your validate them with Laravel 5s Validator.

Values will be filtered based on the function you provide. If the parameter exists in the request it will also be replaced.

[![Build Status](https://travis-ci.org/Askedio/laravel-validator-filter.svg?branch=master)](https://travis-ci.org/Askedio/laravel-validator-filter)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/f91e7399c0ff40c988ba1587f3594d8a)](https://www.codacy.com/app/gcphost/laravel-validator-filter?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Askedio/laravel-validator-filter&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/f91e7399c0ff40c988ba1587f3594d8a)](https://www.codacy.com/app/gcphost/laravel-validator-filter?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Askedio/laravel-validator-filter&amp;utm_campaign=Badge_Coverage)

# Installation
~~~
composer require askedio/laravel-validator-filter
~~~

Add the following to the providers array in `config/app.php`:
~~~
Askedio\LaravelValidatorFilter\FilterServiceProvider::class
~~~

# Usage
Use the `filter:` flag with a function or custom [sanitizer](https://github.com/daylerees/sanitizer).
~~~
$validator = app('validator')->make([
  'string' => $string,
], [
  'string' => 'filter:nl2br',
]);

$validator->passes();
~~~

You can also use a function with paramaters.
~~~
$validator = app('validator')->make([
  'string' => $string,
], [
  'string' => 'filter:strip_tags[{$value}; "<br>"]',
]);

$validator->passes();
~~~