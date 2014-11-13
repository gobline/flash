# Flash Component - Mendo Framework

The Mendo Flash component allows to **store data across requests and objects** with a **session or request level scope**. It is primarily designed to store **messages** accross requests.

## Usage

```php
$flash = new Mendo\Flash\Flash();

$flash->next('error', 'User email is invalid'); // sets a message that will be available in the next request

$flash->get('error'); // message only available in the next request, throws \InvalidArgumentException

$flash->get('error', 'foo'); // message only available in the next request, returns default "foo" value

$flash->now('info', 'Three credits remain in your account'); // message available in the current request

$flash->get('info'); // returns "Three credits remain in your account"

$flash->keep(); // keep messages set in the previous request so they will be available in the next request
```

Note that messages stored with ```next()``` are made available for the next request but not the request after that one. ```keep()``` allows to keep the same messages accross multiple requests.

## Installation

You can install Mendo Flash using the dependency management tool [Composer](https://getcomposer.org/).
Run the *require* command to resolve and download the dependencies:

```
composer require mendoframework/flash
```