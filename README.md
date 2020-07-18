# Twikey PHP Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/appstract/Twikey-php-client.svg?style=flat-square)](https://packagist.org/packages/appstract/Twikey-php-client)
[![Total Downloads](https://img.shields.io/packagist/dt/appstract/Twikey-php-client.svg?style=flat-square)](https://packagist.org/packages/appstract/Twikey-php-client)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/appstract/Twikey-php-client/master.svg?style=flat-square)](https://travis-ci.org/appstract/Twikey-php-client)

PHP Client for the [Twikey API](https://twikey.com)

## Installation

You can install the package via composer:

``` bash
composer require appstract/Twikey-php-client
```

## Usage

Setup the connection.

``` php
use Appstract\Twikey\Connection;
use Appstract\Twikey\Twikey;

$connection = new Connection();

$connection->setApiToken('yourapitoken');

$twikey = new Twikey($connection);
```

Create an invitation:

```php

$invite = $twikey::invite();

$invite->ct = 1234;
$invite->l = 'nl';
$invite->iban = 'GB33BUKB20201555555555';
$invite->bic = 'BUKBGB22';
$invite->email = 'test@example.com';
$invite->reminderDays = 14;

$invite->save();

var_dump($invite->toArray());

```

Find a mandate:
```php

$mandate = $twikey::mandate()->find('ABC5');

var_dump($mandate->toArray());

```


Create a transaction:
```php

$transaction = $twikey::transaction();
$transaction->mndtId = 'ABC5';
$transaction->message = 'Invoice 1234';
$transaction->amount = '84.32';

$transaction->save();

var_dump($transaction->toArray());

```


## Contributing

Contributions are welcome, [thanks to y'all](https://github.com/appstract/Twikey-php-client/graphs/contributors) :)

## About Appstract

Appstract is a small team from The Netherlands. We create (open source) tools for Web Developers and write about related subjects on [Medium](https://medium.com/appstract). You can [follow us on Twitter](https://twitter.com/appstractnl), [buy us a beer](https://www.paypal.me/appstract/10) or [support us on Patreon](https://www.patreon.com/appstract).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
