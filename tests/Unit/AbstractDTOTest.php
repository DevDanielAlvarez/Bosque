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

it('can use magic getter method', function () {

  expect($this->fakeDTO->getAge())->toBe(20);
  expect(fn() => $this->fakeDTO->getEmail())->toThrow(BadMethodCallException::class);

});

it('can convert property name to camel case', function(){
  $productDTO = new class(20.5) extends AbstractDTO{
    public function __construct(private float $availableQuantity){}
  };

  expect($productDTO->toArray()['available_quantity'])->toBe(20.5);
});

it('massive test', function(){

  class PostDTO extends AbstractDTO{
    public function __construct(private string $title, private string $createdBy, private string $createdAt){

    }

    public function getTitle(): string{
      return 'Title: ' . $this->title;
    }
  }

  $postDTO = new PostDTO('My New Car', 'Daniel Alvarez','03-03-2025');

  expect($postDTO->toArray())->toBe([
    'title' => 'Title: My New Car',
    'created_by' => 'Daniel Alvarez',
    'created_at' => '03-03-2025'
  ]);

  expect($postDTO->toJson())->toBe('{"title":"Title: My New Car","created_by":"Daniel Alvarez","created_at":"03-03-2025"}');

});