# Bosque
![library logo](https://64.media.tumblr.com/77eeba3ea288877e2634f2584599a09b/e5cfc0461d08ef56-e3/s250x400/7bcb25818c3b34b69a11113cdbfdf733f21ab8de.pnj)


Why Choose Bosque for Your PHP Projects?

Bosque is a powerful PHP library designed to simplify model manipulation and data transfer. With the inclusion of the AbstractDTO class, Bosque enables developers to easily create Data Transfer Objects (DTOs) that can be transformed into arrays and JSON format with just a few lines of code.


## Install
```bash
composer require astro-daniel/bosque
```

## AbstractDTO
First create a file and extend the Abstract DTO, for example:
```php
<?php

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
$userDTO = new UserDTO(name : "Daniel", email : "ddd@ddd.com");
$userDTO->toArray(); // [name : "Daniel", "email" : "ddd@ddd.com"]
```
#### To Json
```php
<?php

$userDTO = new UserDTO(name : "Daniel", email : "ddd@ddd.com");
$userDTO->toJson(); // "{"name":"Daniel","email":"ddd@ddd.com"}"
```

#### Except
```php
<?php
$userDTO = new UserDTO(name : "Daniel", email : "ddd@ddd.com");
$userDTO->except(properties: ['name'])->toJson(); //"{"email":"ddd@ddd.com"}"
$userDTO->except(properties: ['email'])->toArray(); // ["name" : "Daniel"]
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

    $userDTO = new UserDTO(name : "Daniel", email : "ddd@ddd.com");
    $userDTO->except(['email'])->toArray(); //["name" => "DANIEL"]
```
*Naming Convention: The getter method should be named get followed by the name of the property, with the first letter capitalized (e.g., getName for the property $name).

