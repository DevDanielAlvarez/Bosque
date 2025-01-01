<?php

namespace AstroDaniel\Bosque;

use AstroDaniel\Bosque\Interfaces\DTOInterface;
use Illuminate\Support\Fluent;
use ReflectionClass;
use ReflectionProperty;

class AbstractDTO implements DTOInterface
{
  private array $except = [];
  /**
   * return this properties as array
   */
  public function toArray(): array
  {
    $reflection = new ReflectionClass($this);
    $data  = [];
    foreach ($reflection->getProperties() as $property) {
      if($this->verifyIfPropertyIsAccepted($property)){
        continue;
      }
      $property->setAccessible(true);
      $data[$property->getName()] = $property->getValue($this);
    }

    return $data;
  }

  public function except(array $fields): self
  {
    $this->except = $fields;
    return $this;
  }

  public function toJson(): string
  {
    return (new Fluent($this->toArray()))->toJson();
  }

  private function verifyIfPropertyIsAccepted(ReflectionProperty $propertyToVerify): bool
  {
    foreach ($this->except as $exceptField) {
      if ($propertyToVerify->getName() == $exceptField) {
        return true;
      }
    }
    return false;
  }
}
