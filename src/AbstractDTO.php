<?php

namespace AstroDaniel\Bosque;

use AstroDaniel\Bosque\Interfaces\DTOInterface;
use ReflectionClass;
use ReflectionProperty;

class AbstractDTO implements DTOInterface
{
  /**
   * Properties that will not be returned
   * @var array
   */
  private array $except = [];

  /**
   * Set value in except property
   * @param array $properties
   * @return \AstroDaniel\Bosque\AbstractDTO
   */
  protected function setExcept(array $properties): self
  {
    $this->except = $properties;
    return $this;
  }
  /**
   * Get except property
   * @return array
   */
  protected function getExcept(): array
  {
    return $this->except;
  }
  /**
   * Return properties as array
   * @return array
   */
  public function toArray(): array
  {
    $reflection = new ReflectionClass($this);
    $data  = [];
    foreach ($reflection->getProperties() as $property) {
      //==== Start Verify is blocked ====\\
      if ($this->isPropertyExcluded($property)) {
        continue;
      }
      //====End Verify is blocked ====\\

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

  /**
   * Set except properties
   * @param array $properties
   * @return \AstroDaniel\Bosque\AbstractDTO
   */
  public function except(array $properties): self
  {
    $this->except = $properties;
    return $this;
  }

  /**
   * Return properties as json
   * @return string
   */
  public function toJson(): string
  {
    return json_encode(($this->toArray()));
  }

  private function isPropertyExcluded(ReflectionProperty $propertyToVerify): bool
  {
    foreach ($this->except as $exceptField) {
      if ($propertyToVerify->getName() == $exceptField) {
        return true;
      }
    }
    return false;
  }
}
