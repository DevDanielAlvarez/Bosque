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


