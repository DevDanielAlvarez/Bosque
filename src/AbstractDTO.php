<?php

namespace AstroDaniel\Bosque;

use AstroDaniel\Bosque\Interfaces\DTOInterface;
use ReflectionClass;
use ReflectionProperty;

abstract class AbstractDTO implements DTOInterface
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
      if ($this->hasGetterMethod($property, $reflection)) {

        $method = $reflection->getMethod($this->getGetterMethodName($property));

        if ($method->isPublic()) {
          $data[$property->getName()] = $method->invoke($this);
          continue;
        }
      }
      //==== End Verify Getter ====\\


      //access property
      $property->setAccessible(true);
      $data[$this->convertToSnakeCase($property->getName())] = $property->getValue($this);
    }
    $this->except = [];
    return $data;
  }

  private function convertToSnakeCase(string $string): string
  {
      return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
  }

  protected function hasGetterMethod(ReflectionProperty $property, ReflectionClass $reflection): bool
  {
    return $reflection->hasMethod($this->getGetterMethodName($property));
  }

  protected function getGetterMethodName(ReflectionProperty $property): string
  {
    return 'get' . ucfirst($property->getName());
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

  public function __call(string $name, array $args)
  {
    // Check if the method is a getter
    if (str_starts_with($name, 'get')) {
      $propertyName = lcfirst(substr($name, 3));

      if (property_exists($this, $propertyName)) {
        $reflection = new ReflectionProperty($this, $propertyName);

        if (!$reflection->isPublic()) {
          $reflection->setAccessible(true);
        }

        return $reflection->getValue($this);
      }
    }

    throw new \BadMethodCallException("Method {$name} does not exist.");
  }
}
