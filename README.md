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

### Fetch and alter

If you want to fetch items via the API there might be a static function for. Example:

```php
$users = Newsletter2Go\Api\Model\NewsletterUser::findAll(null, $apiCredentials);

// Use a PHPDoc comment and profit from auto suggestion
/** @var NewsletterUser $user */
foreach ($users as $user) {
    // What's about naming all users "Doe"?
    $user->setLastName('Doe');
    // Save the user (via the API of course)
    $user->save();
    
    // $data contains all data fetched for this item
    $data = $user->getData();
}
```
```php
$recipients = Newsletter2Go\Api\Model\NewsletterRecipient::findByListAndGroup('abc123', 'xyz987', null, $apiCredentials);
var_dump($recipients);

foreach ($recipients as $recipient) {
    $recipient->addToGroup('xyz345');
    $recipient->removeFromGroup('asdf12');
}
```

#### Api Credentials

```ApiCredentials``` are mandatory for the api communication. First of all you need the ```auth_key``` that can be found in the Newsletter2Go back end. The ```auth_key``` is the same for all company's accounts.
Furthermore you either need a user's ```username``` and ```password``` or a user's ```refresh_token```.

If you rather want to use and save the ```refresh_token``` instead of username and password in your application, you have to make an initial api authorization call with the ```username``` and ```password``` anyway. Check the [manual of the corresponding OAuth provider](https://github.com/richardhj/oauth2-newsletter2go/blob/master/README.md) to get to know how to fetch a ```refresh_token```.

```php
// Use the ApiCredentialsFactory
$apiCredentials = ApiCredentialsFactory::createFromUsernameAndPassword('secret_auth_token', 'user@example.org', 'open_sesame');
$apiCredentials = ApiCredentialsFactory::createFromRefreshToken('secret_auth_token', 'secret_users_refresh_token');
// Or simply use ::create()
$apiCredentials = ApiCredentialsFactory::create('secret_auth_token', 'secret_users_refresh_token');
```

#### Get parameters

When fetching a collection from the api, you can provide a ```GetParamters``` instance. Get parameters allow you to filter, limit etc. the item collection that will be returned. Example:

```php
$getParams = new Newsletter2Go\Api\Tool\GetParameters();
$getParams
    ->setExpand(true)
    ->setFilter('email=like="%@example.org"')
    ->setOffset(2)
    ->setLimit(1);

$recipients = Newsletter2Go\Api\Model\NewsletterRecipient::findByListAndGroup('abc123', 'xyz987', $getParams, $apiCredentials);
var_dump($recipients);
```

### Create

If you want to create items via the API, this is how. Example:

```php
$recipient = new Newsletter2Go\Api\Model\NewsletterRecipient();
$recipient->setApiCredentials($apiCredentials);
$recipient
    ->setListId('abc123')
    ->setFirstName('John')
    ->setLastName('Doe')
    ->setEmail('doe@example.org')
    ->setGender('m');

// Good to have an id, otherwise the email address will be the primary key and you will not be able to change the email address of a recipient properly
$recipient->setId('xyz123');

// Update an existing recipient (when id given or email address known in Newsletter2Go) or create a new recipient
$recipient->save();
```

### Delete

For models that implement ```Newsletter2Go\Api\Model\ModelDeletableInterface```, ```delete()``` is available. Example:

```php
$groups = Newsletter2Go\Api\Model\NewsletterGroup::findByList('abc123', $getParams, $credentials);

/** @var NewsletterGroup $group */
foreach ($groups as $group) {
    $group->delete();
}
```

### Official API documentation

Visit [the official API documentation](https://docs.newsletter2go.com) for reference.

## License

The  GNU Lesser General Public License (LGPL).

[ico-version]: https://img.shields.io/packagist/v/richardhj/newsletter2go-api.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-LGPL-brightgreen.svg?style=flat-square
[ico-dependencies]: https://www.versioneye.com/php/richardhj:newsletter2go-api/badge.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/richardhj/newsletter2go-api
[link-dependencies]: https://www.versioneye.com/php/richardhj:newsletter2go-api
