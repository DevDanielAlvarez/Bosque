<?php

use AstroDaniel\Bosque\AbstractDTO;

beforeEach(function () {
  $this->fakeDTO = new class('Daniel Alvarez de Almeida',20) extends AbstractDTO {

    public function __construct(
      private readonly string $name,
      private readonly int $age
    ) {}

    public function getName() : string {
      return $this->name;
    }
  };
});

it('can get attributes as array', function(){
  $propertiesAsArray = $this->fakeDTO->toArray();
  expect($propertiesAsArray)->toBeArray();
  expect($propertiesAsArray['name'])->toBe('Daniel Alvarez de Almeida');
  expect($propertiesAsArray['age'])->toBe(20);
});

it('can get attributes as json', function(){
  $propertiesAsJson = $this->fakeDTO->toJson();
  expect($propertiesAsJson)->toBeString();
  expect($propertiesAsJson)->toBe('{"name":"Daniel Alvarez de Almeida","age":20}');
});

it('can get property as array except name',function(){
  $propertiesAsArray = $this->fakeDTO->except(['name'])->toArray();
  expect(array_key_exists('name',$propertiesAsArray))->toBeFalse();
});

