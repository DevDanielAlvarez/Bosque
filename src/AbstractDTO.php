<?php

namespace AstroDaniel\Bosque;

use AstroDaniel\Bosque\Interfaces\DTOInterface;
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
      //==== Start Verify is blocked ====\\
      if ($this->verifyIfPropertyIsAccepted($property)) {
        continue;
      }
      //====End Verify is blocked
      //==== Start Verify Getter ====\\
      $propertyName = $property->getName();
      $getterMethod = 'get' . ucfirst($propertyName);

      if ($reflection->hasMethod($getterMethod)) {
        $method = $reflection->getMethod($getterMethod);
        if ($method->isPublic()) {
          $data[$propertyName] = $method->invoke($this);
          continue;
        }
      }
      //==== End Verify Getter ====\\
      $property->setAccessible(true);
      $data[$property->getName()] = $property->getValue($this);
    }
    $this->except = [];
    return $data;
  }

  public function except(array $properties): self
  {
    $this->except = $properties;
    return $this;
  }

  public function toJson(): string
  {
    return json_encode(($this->toArray()));
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
