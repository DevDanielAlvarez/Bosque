<?php

use AstroDaniel\Bosque\AbstractDTO;

beforeEach(function () {
  $this->fakeDTO = new class('Daniel Alvarez de Almeida', 20) extends AbstractDTO {

    public function __construct(
      private readonly string $name,
      private readonly int $age
    ) {}

    public function getName(): string
    {
      return $this->name;
    }
  };
});

it('can get attributes as array', function () {
  $propertiesAsArray = $this->fakeDTO->toArray();
  expect($propertiesAsArray)->toBeArray();
  expect($propertiesAsArray['name'])->toBe('Daniel Alvarez de Almeida');
  expect($propertiesAsArray['age'])->toBe(20);
});

it('can get attributes as json', function () {
  $propertiesAsJson = $this->fakeDTO->toJson();
  expect($propertiesAsJson)->toBeString();
  expect($propertiesAsJson)->toBe('{"name":"Daniel Alvarez de Almeida","age":20}');
});

it('can get property as array except name', function () {
  $propertiesAsArray = $this->fakeDTO->except(['name'])->toArray();
  expect(array_key_exists('name', $propertiesAsArray))->toBeFalse();
});

it('can get property as json except age', function () {
  $propertiesAsJson = $this->fakeDTO->except(properties: ['age'])->toJson();
  var_dump($propertiesAsJson);
  expect($propertiesAsJson)->toBe('{"name":"Daniel Alvarez de Almeida"}');
});

it('can reset except property in abstract DTO', function () {
  $json = $this->fakeDTO->except(properties: ['age'])->toJson();
  expect($json)->toBe('{"name":"Daniel Alvarez de Almeida"}');
  expect($this->fakeDTO->toJson())->toBe('{"name":"Daniel Alvarez de Almeida","age":20}');
});

it('respect getter method', function () {

  $userDto = new class('daniel') extends AbstractDTO {
    public function __construct(private readonly string $name) {}

    public function getName() : string{
      return strtoupper($this->name);
    }
  };
  expect($userDto->toArray()['name'])->toBe('DANIEL');
  expect($userDto->toJson())->toBeAbstract('{"name":DANIEL}');
});
