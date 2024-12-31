<?php

use AstroDaniel\Bosque\AbstractService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Fluent;

beforeEach(function () {
  $this->modelMocked = Mockery::mock(Model::class);
  $this->fakeModel = new class extends Model {};
  $this->fakeService = new class($this->fakeModel) extends AbstractService{};
  $this->serviceMocked = new class($this->modelMocked) extends AbstractService {};
});

it('can set a record', function () {
  expect($this->serviceMocked->getRecord())->toBe($this->modelMocked);
});

it('can update a record', function () {
  $this->modelMocked->shouldReceive('update')
    ->once()
    ->with([
      'name' => 'Daniel Alvarez de Almeida'
    ])
    ->andReturn(true);

  expect($this->serviceMocked->update(['name' => 'Daniel Alvarez de Almeida']))->toBeInstanceOf(get_class($this->serviceMocked));
});

it('can delete a record', function () {
  $this->modelMocked
    ->shouldReceive('delete')
    ->andReturn(true);

  $this->modelMocked->delete();

  expect($this->modelMocked->delete())->toBe(true);
});

it('can force delete a record', function () {
  $this->modelMocked->shouldReceive('forceDelete')
    ->andReturn(true);

  expect($this->serviceMocked->forceDelete())->toBe(true);
});

it('can get record', function () {
  expect($this->serviceMocked->getRecord())->toEqual($this->modelMocked);
});

it('can get record data',function(){
  $this->modelMocked->shouldReceive('toArray')
    ->once()
    ->andReturn([]);
  expect($this->serviceMocked->getRecordData())->toBeInstanceOf(Fluent::class);
});
