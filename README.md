# Bosque
![library logo](https://64.media.tumblr.com/77eeba3ea288877e2634f2584599a09b/e5cfc0461d08ef56-e3/s250x400/7bcb25818c3b34b69a11113cdbfdf733f21ab8de.pnj)

Why Choose Bosque for Your Laravel Projects?

Bosque is the perfect solution for Laravel developers looking for cleaner, more efficient, and reusable code. By integrating the AbstractService and AbstractDTO classes, the library provides powerful tools for model manipulation and data transfer within your applications.

## Install
```bash
composer require astro-daniel/bosque
```

## AbstractDTO
First create a file and extend the Abstract DTO, for example:
```php
<?php

namespace App\DTO;

use AstroDaniel\Bosque\AbstractDTO;

class UserDTO extends AbstractDTO
{
    public function __construct(
        private readonly string $name,
        private readonly string $email
    ) {}
}
```
How to use dto
#### To Array
```php
<?php
$user = User::first();
$userDTO = new UserDTO(name : $user->name, email : $user->email);
dd($userDTO->toArray()); // [name : "Daniel", "email" : "ddd@ddd.com"]
```
#### To Json
```php
<?php
$user = User::first();
$userDTO = new UserDTO(name : $user->name, email : $user->email);
dd($userDTO->toJson()); // "{"name":"Miss Shanelle Krajcik V","email":"iklein@example.com"}"
```

#### Except
```php
<?php
$user = User::first();
$userDTO = new UserDTO(name : $user->name, email : $user->email);
dump($userDTO->except(properties: ['name'])->toJson()); //"{"email":"iklein@example.com"}"
dd($userDTO->except(properties: ['email'])->toArray()); // ["name" : "Miss Shanelle Krajcik V"]
```
#### You can define getters that abstract DTO will understand
```php
<?php

namespace App\DTO;

use AstroDaniel\Bosque\AbstractDTO;

class UserDTO extends AbstractDTO
{
    public function __construct(
        private readonly string $name,
        private readonly string $email
    ) {}

    public function getName() : string {
        return strtoupper($this->name);
    }
}

 $user = User::first();
    $userDTO = new UserDTO(name : $user->name, email : $user->email);
    dump($userDTO->except(['email'])->toArray()); //["name" => "MISS SHANELLE KRAJCIK V"]
```


