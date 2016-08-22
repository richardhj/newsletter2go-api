# Newsletter2Go model based API integration

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]]()
[![Dependency Status][ico-dependencies]][link-dependencies]

This package provides a model based implementation of the Newsletter2Go API. It aims to make complex documentations unnecessary. With its clear structure and extensive PHPDoc, it is really easy to use.

## Install

Via Composer

``` bash
$ composer require richardhj/newsletter2go-api
```

## Usage

If you want to fetch items via the API there might be a static function for. Example:

```php
// Use the user's credentials
$users = Newsletter2Go\Api\Model\NewsletterUser::findAll(null, ApiCredentialsFactory::createFromUsernameAndPassword('secret_auth_token', 'user@example.org', 'open_sesame'));
// or use the user's refresh token. It is present after a successful login with credentials
$users = Newsletter2Go\Api\Model\NewsletterUser::findAll(null, ApiCredentialsFactory::createFromRefreshToken('secret_auth_token', 'secret_users_refresh_token'));

// Use a PHPDoc comment and profit from auto suggestion
/** @var NewsletterUser $user */
foreach ($users as $user) {
    // What's about naming all users "Doe"?
    $user->setLastName('Doe');
    // Save the user (via the API of course)
    $user->save();
}
```

If you want to create items via the API, this is how. Example:

```php
$recipient = new Newsletter2Go\Api\Model\NewsletterRecipient();
$recipient
    ->setListId('abc123')
    ->setFirstName('John')
    ->setLastName('Doe')
    ->setEmail('doe@example.org')
    ->setGender('m');

// Update an existing recipient or create a new recipient
$recipient->save();
```

*to be extended. not all methods implemented yet*

Visit [the official API documentation](https://docs.newsletter2go.com) for reference.

## License

The  GNU Lesser General Public License (LGPL).

[ico-version]: https://img.shields.io/packagist/v/richardhj/newsletter2go-api.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-LGPL-brightgreen.svg?style=flat-square
[ico-dependencies]: https://www.versioneye.com/php/richardhj:newsletter2go-api/badge.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/richardhj/newsletter2go-api
[link-dependencies]: https://www.versioneye.com/php/richardhj:newsletter2go-api
